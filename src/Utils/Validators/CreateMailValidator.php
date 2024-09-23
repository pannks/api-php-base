<?php

namespace App\Utils\Validators;

use App\Utils\Validator;

class CreateMailValidator
{
  /**
   * Validate the user creation request data.
   * 
   * @param array $data
   * @return array List of validation errors (empty if valid)
   */
  public static function validate(?array $data): array
  {
    $errors = [];

    if (empty($data['to']) || !Validator::IsEmail($data['to'])) {
      $errors['to'] = 'A valid email receptian address is required.';
    }
    if (empty($data['from']) || !Validator::IsEmail($data['from'])) {
      $errors['from'] = 'A valid email sender address is required.';
    }
    if (empty($data['subject'])) {
      $errors['subject'] = 'A subject is required.';
    }

    return $errors;
  }
}
