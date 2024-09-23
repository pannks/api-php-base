<?php

namespace App\Config;

class AuthConfig
{
  private string $authToken;

  public function __construct(string $authToken)
  {
    $this->authToken = $authToken;
  }

  public function getAuthToken()
  {
    return  $this->authToken;
  }
}
