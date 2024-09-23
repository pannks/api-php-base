<?php
// src/Middleware/AuthenticationMiddleware.php
namespace App\Middleware;

use App\Interfaces\MiddlewareInterface;
use App\Services\V1\AuthenticationService;
use App\Utils\Request;
use App\Utils\Response;

class AuthenticationMiddleware implements MiddlewareInterface
{
  private AuthenticationService $authService;

  public function __construct(AuthenticationService $authService)
  {
    $this->authService = $authService;
  }

  public function handle(Request $request, callable $next)
  {
    if (!$this->authService->isAuthenticated($request)) {
      Response::error401('Unauthorized');
      return;
    }

    return $next($request);
  }
}
