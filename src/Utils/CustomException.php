<?php

namespace App\Utils;

class CustomException extends \Exception
{
  private $errors;

  public function __construct(array $errors)
  {
    $this->errors = $errors;
    parent::__construct('Validation error', 400);
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
