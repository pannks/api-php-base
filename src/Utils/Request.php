<?php

namespace App\Utils;

class Request
{
  public $params;
  public $headers;
  public $body;
  public $queryParams;
  public $cookies;
  public $protocol;
  public $method;
  public $host;

  public function __construct($params = [], $headers = [], $body = null, $queryParams = [])
  {
    // Existing properties
    $this->params = $params;
    $this->headers = $headers;
    $this->body = $body;
    $this->queryParams = $queryParams;
    $this->cookies = $_COOKIE; // Get all cookies
    $this->protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $this->method = $_SERVER['REQUEST_METHOD']; // Get the request method (GET, POST, etc.)
    $this->host = $_SERVER['HTTP_HOST']; // Get the host (domain or IP)
  }

  // Helper method to extract common parameters
  public function extract()
  {
    return [
      'params' => $this->params,
      'queryParams' => $this->queryParams,
      'headers' => $this->headers,
      'body' => $this->body,
      'cookies' => $this->cookies,
      'protocol' => $this->protocol,
      'method' => $this->method,
      'host' => $this->host
    ];
  }
}
