<?php

namespace App\Utils\Validators;

use App\Utils\Validator;

class CreateUserValidator
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

    // Validate email
    if (empty($data['email']) || !Validator::IsEmail($data['email'])) {
      $errors['email'] = 'A valid email is required.';
    }

    // Validate firstname (must be a string, not empty)
    if (empty($data['firstname']) || !Validator::IsString($data['firstname'], false)) {
      $errors['firstname'] = 'First name is required and must be a valid string.';
    }

    // Validate lastname (must be a string, not empty)
    if (empty($data['lastname']) || !Validator::IsString($data['lastname'], false)) {
      $errors['lastname'] = 'Last name is required and must be a valid string.';
    }

    // Validate password (must be at least 8 characters)
    if (empty($data['password']) || !Validator::MinLength($data['password'], 8)) {
      $errors['password'] = 'Password must be at least 8 characters long.';
    }

    return $errors;
  }
}
