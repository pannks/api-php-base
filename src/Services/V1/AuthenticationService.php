<?php

namespace App\Services\V1;

use App\Config\AuthConfig;
use App\Utils\Request;

class AuthenticationService
{

  private AuthConfig $config;

  public function __construct(AuthConfig $config)
  {
    $this->config = $config;
  }


  public function isAuthenticated(Request $request): bool
  {

    $authHeader = $request->headers['Authorization'] ?? '';

    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
      $token = $matches[1];
      return $token == $this->config->getAuthToken();
    }

    return false;
  }
}
