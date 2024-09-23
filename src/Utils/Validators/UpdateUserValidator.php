<?php

namespace App\Utils\Validators;

use App\Utils\Validator;

class UpdateUserValidator
{
  /**
   * Validate the user update request data.
   * 
   * @param array $data
   * @return array List of validation errors (empty if valid)
   */
  public static function validate(array $data): array
  {
    $errors = [];

    // Validate email if provided
    if (!empty($data['email']) && !Validator::IsEmail($data['email'])) {
      $errors['email'] = 'A valid email is required.';
    }

    // Validate firstname if provided
    if (!empty($data['firstname']) && !Validator::IsString($data['firstname'], false)) {
      $errors['firstname'] = 'First name must be a valid string.';
    }

    // Validate lastname if provided
    if (!empty($data['lastname']) && !Validator::IsString($data['lastname'], false)) {
      $errors['lastname'] = 'Last name must be a valid string.';
    }

    // Validate password if provided (minimum length of 8 characters)
    if (!empty($data['password']) && !Validator::MinLength($data['password'], 8)) {
      $errors['password'] = 'Password must be at least 8 characters long.';
    }

    return $errors;
  }
}
