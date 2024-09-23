<?php

namespace App\Utils\Validators;

use App\Utils\CustomException;
use JsonSchema\Validator;
use JsonSchema\Constraints\Constraint;

class TemplateValidator
{
  private $schemaDir;

  public function __construct($templateDir)
  {
    // Assuming schemas are in a sibling directory under "schemas"
    $this->schemaDir = __DIR__ . '/../../templates/schemas/';
  }

  /**
   * Validate the data against the schema associated with the template
   *
   * @param string $templateName
   * @param mixed $data
   * @return void
   * @throws \Exception If the schema file does not exist, is invalid, or validation fails.
   */
  public function validate($templateName, $data)
  {
    $schemaFile = $this->schemaDir . $templateName . '.json';

    if (!file_exists($schemaFile)) {
      throw new \Exception("Schema file not found: " . $schemaFile);
    }

    // Load the schema
    $schema = json_decode(file_get_contents($schemaFile));
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new \Exception("Invalid JSON schema: " . json_last_error_msg());
    }

    // Create a new Validator instance
    $validator = new Validator();

    // Validate the data using CHECK_MODE_NORMAL to accumulate all errors
    $validator->validate($data, $schema, Constraint::CHECK_MODE_NORMAL);

    // If validation fails, throw an exception with the list of errors
    if (!$validator->isValid()) {
      $errors = $validator->getErrors();
      $errorMessages = $this->formatErrors($errors);
      throw new CustomException($errorMessages);
    }
  }

  /**
   * Format validation errors into a readable array
   *
   * @param array $errors
   * @return array
   */
  private function formatErrors(array $errors)
  {
    $formattedErrors = [];
    foreach ($errors as $error) {
      $propertyPath = $error['property'] ?: 'root'; // Handle case where property is root
      $formattedErrors[] = sprintf("Error in '%s': %s", $propertyPath, $error['message']);
    }
    return $formattedErrors;
  }
}
