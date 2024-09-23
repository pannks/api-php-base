<?php

namespace App\Utils;

class Container
{
  private $instances = [];

  /**
   * Register a service in the container.
   *
   * @param string $key The class or service name to register.
   * @param callable $resolver A closure that defines how to create the service.
   */
  public function set(string $key, callable $resolver)
  {
    $this->instances[$key] = $resolver;
  }

  /**
   * Resolve a service from the container.
   *
   * @param string $key The class or service name to resolve.
   * @return mixed The resolved service.
   * @throws \Exception If the service is not found.
   */
  public function get(string $key)
  {
    if (!isset($this->instances[$key])) {
      throw new \Exception("No service found for key: {$key}");
    }
    // Call the resolver and return the instance
    return call_user_func($this->instances[$key]);
  }
}
