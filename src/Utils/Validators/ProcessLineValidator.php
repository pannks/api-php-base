<?php

namespace App\Utils\Validators;

use App\Utils\Validator;

class ProcessLineValidator
{
  /**
   * Validate the user creation request data.
   * 
   * @param array $data
   * @return array List of validation errors (empty if valid)
   */
  public static function validateNotify(?array $data): array
  {
    $errors = [];

    if (empty($data['message']) || !Validator::IsString($data['message'], false)) {
      $errors['message'] = 'Message is required and must be a valid string.';
    }
    return $errors;
  }

  public static function validatePush(?array $data): array
  {
    $errors = [];

    if (empty($data['to']) || !Validator::IsString($data['to'], false)) {
      $errors['to'] = 'To is required and must be a valid string.';
    }

    return $errors;
  }
}
