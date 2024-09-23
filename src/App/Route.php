<?php

namespace App\App;

use App\Utils\Response;
use App\Routes\RouteV1;
use App\Routes\RouteV2;

class Route
{
  private $apiVersions = ['v1', 'v2'];

  public function handleRequest()
  {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    $headers = $this->getRequestHeaders();
    $body = $this->getRequestBody($method);
    $queryParams = $_GET;

    $parts = explode('/', trim($path, '/'));

    if (count($parts) < 3 || $parts[0] !== 'api') {
      Response::error404(); // Return a 404 error
    }

    $version = $parts[1];
    if (!in_array($version, $this->apiVersions)) {
      Response::error404('Invalid API version');
    }

    switch ($version) {
      case 'v1':
        $routes = new RouteV1();
        $routes->handleRoutes($parts, $method, $headers, $body, $queryParams);
        break;
      case 'v2':
        $routes = new RouteV2();
        $routes->handleRoutes($parts, $method, $headers, $body, $queryParams);
        break;
      default:
        Response::error404('API version not supported');
        break;
    }
  }

  /**
   * Get the request body if it's a POST, PUT, or PATCH method
   */
  private function getRequestBody($method)
  {
    // For POST, PUT, PATCH requests, we usually have a body
    if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
      $body = file_get_contents('php://input');
      // Assuming JSON input, decode it into an associative array
      return json_decode($body, true);
    }

    // Return null for methods that don't typically have a body (e.g., GET, DELETE)
    return null;
  }

  private function getRequestHeaders()
  {
    if (function_exists('getallheaders')) {
      // Debug: Print headers for verification
      $headers = getallheaders();
      return $headers;
    } else {
      // Fallback for environments where getallheaders() is not available
      $headers = [];
      foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
          $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
      }
      // error_log(print_r($headers, true)); // Log headers for debugging
      return $headers;
    }
  }
}
