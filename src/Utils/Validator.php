<?php

namespace App\Utils;

class Validator
{
  /**
   * Check if a value is a valid email.
   * 
   * @param string $email
   * @return bool
   */
  public static function IsEmail(string $email): bool
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
  }

  /**
   * Check if a value is a valid number.
   * 
   * @param mixed $value
   * @return bool
   */
  public static function IsNumber($value): bool
  {
    return is_numeric($value);
  }

  /**
   * Check if a value is a valid string (and optionally if it's not empty).
   * 
   * @param mixed $value
   * @param bool $allowEmpty
   * @return bool
   */
  public static function IsString($value, bool $allowEmpty = true): bool
  {
    if (!is_string($value)) {
      return false;
    }

    if (!$allowEmpty && empty(trim($value))) {
      return false;
    }

    return true;
  }

  /**
   * Check if a string is of a minimum length.
   * 
   * @param string $value
   * @param int $minLength
   * @return bool
   */
  public static function MinLength(string $value, int $minLength): bool
  {
    return strlen($value) >= $minLength;
  }
}
