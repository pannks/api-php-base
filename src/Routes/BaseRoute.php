<?php

namespace App\Routes;

use App\Utils\Request;
use App\Utils\Response;
use App\Utils\Container;

abstract class BaseRoute
{
  protected $routes = [];
  protected $container;

  public function __construct()
  {
    $this->container = new Container();
    $this->registerServices();
    $this->registerControllers();
    $this->defineRoutes();
  }

  abstract protected function defineRoutes();

  protected function registerServices()
  {
    // Register common services in the container (you can override this in specific routes if needed)
  }

  protected function registerControllers()
  {
    // Register common controllers in the container (you can override this in specific routes if needed)
  }

  // Handle request by finding matching route
  public function handleRoutes($parts, $method, $headers, $body, $queryParams)
  {
    $resource = $parts[2] ?? null;
    $pathSegments = array_slice($parts, 3); // Get all parts after the resource

    if ($method === 'OPTIONS') {
      $this->handleOptions($resource);
      return;
    }

    if ($this->isIdRequired($method) && empty($pathSegments)) {
      Response::error422('ID is required but not provided');
      return;
    }

    if (isset($this->routes[$resource])) {
      $route = $this->routes[$resource];
      $matchResult = $route->match($method, $pathSegments);

      if ($matchResult) {
        $handler = $matchResult['handler'];
        $middlewares = $matchResult['middlewares'];
        $params = $matchResult['params'];
        $request = new Request(params: $params, headers: $headers, body: $body, queryParams: $queryParams);

        // Build middleware chain
        $middlewareChain = $this->buildMiddlewareChain($middlewares, $handler);

        // Execute the middleware chain
        return call_user_func($middlewareChain, $request);
      } else {
        Response::error405('Method Not Allowed');
      }
    } else {
      Response::error404('Resource not found');
    }
  }

  private function handleOptions($resource)
  {
    if (!$resource || !isset($this->routes[$resource])) {
      Response::error404('Resource not found');
      return;
    }

    $route = $this->routes[$resource];
    $allowedMethods = $route->getAllowedMethods();

    // Set CORS headers
    Response::setHeader('Access-Control-Allow-Origin', '*'); // Adjust as needed
    Response::setHeader('Access-Control-Allow-Methods', implode(', ', $allowedMethods));
    Response::setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization'); // Adjust as needed
    Response::setHeader('Allow', implode(', ', $allowedMethods));

    // Optionally, you can add more headers like Access-Control-Max-Age
    // Response::setHeader('Access-Control-Max-Age', '86400'); // 24 hours

    // Respond with 200 OK
    Response::json(['message' => 'CORS preflight'], 200);
  }
  private function buildMiddlewareChain(array $middlewares, callable $handler): callable
  {
    $middlewareChain = $handler;
    foreach (array_reverse($middlewares) as $middlewareClass) {
      $middlewareInstance = $this->container->get($middlewareClass);
      $next = $middlewareChain;
      $middlewareChain = function (Request $request) use ($middlewareInstance, $next) {
        return $middlewareInstance->handle($request, $next);
      };
    }
    return $middlewareChain;
  }

  // Helper method to register resource routes
  protected function route($resource)
  {
    if (!isset($this->routes[$resource])) {
      $this->routes[$resource] = new ResourceRoute($resource);
    }
    return $this->routes[$resource];
  }

  // Check if the method requires an ID (for PUT and DELETE)
  protected function isIdRequired($method)
  {
    return in_array($method, ['PUT', 'DELETE']);
  }
}

class ResourceRoute
{
  private $resource;
  private $methods = [];

  public function __construct($resource)
  {
    $this->resource = $resource;
  }

  public function add($method, $path, $handler, $middlewares = [])
  {
    $this->methods[$method][$path] = [
      'handler' => $handler,
      'middlewares' => $middlewares
    ];
    return $this;
  }

  public function match($method, $pathSegments)
  {
    if (isset($this->methods[$method])) {
      foreach ($this->methods[$method] as $pathPattern => $routeInfo) {
        // Handle empty path pattern
        $patternSegments = $pathPattern === '' ? [] : explode('/', $pathPattern);

        if (count($patternSegments) !== count($pathSegments)) {
          continue;
        }

        $params = [];
        $matched = true;
        for ($i = 0; $i < count($patternSegments); $i++) {
          if (strpos($patternSegments[$i], ':') === 0) {
            // This is a parameter, capture it
            $paramName = substr($patternSegments[$i], 1);
            $params[$paramName] = $pathSegments[$i];
          } elseif ($patternSegments[$i] !== $pathSegments[$i]) {
            $matched = false;
            break;
          }
        }
        if ($matched) {
          return [
            'handler' => $routeInfo['handler'],
            'middlewares' => $routeInfo['middlewares'],
            'params' => $params
          ];
        }
      }
    }
    return null; // No match found
  }
  public function getAllowedMethods(): array
  {
    return array_keys($this->methods);
  }
}
