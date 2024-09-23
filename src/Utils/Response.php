<?php

namespace App\Utils;

class Response
{
  /**
   * Set a HTTP header.
   *
   * @param string $header
   * @param string $value
   */
  public static function setHeader(string $header, string $value)
  {
    header("$header: $value");
  }
  /**
   * Send a JSON response.
   *
   * @param mixed $data
   * @param int $statusCode
   * @return void
   */
  public static function json($data, $statusCode = 200)
  {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
  }

  /**
   * Send a HTML response.
   *
   * @param mixed $data
   * @return void
   */
  public static function html($data)
  {
    header('Content-Type: text/html, charset=utf-8');
    http_response_code(200);
    echo $data;
    exit;
  }

  /**
   * Send a TXT response.
   *
   * @param mixed $data
   * @return void
   */
  public static function txt($data)
  {
    header('Content-Type: text/plain, charset=utf-8');
    http_response_code(200);
    echo $data;
    exit;
  }

  /**
   * Handle 404 - Not Found errors.
   *
   * @param string $message
   * @return void
   */
  public static function error404($message = 'Not Found')
  {
    self::json([
      'error' => $message,
    ], 404);
  }

  /**
   * Handle 400 - Bad Request errors.
   *
   * @param string | array $message
   * @return void
   */
  public static function error400($message = 'Bad Request')
  {
    self::json([
      'error' => $message,
    ], 400);
  }

  /**
   * Handle 401 - Unauthorized errors.
   *
   * @param string $message
   * @return void
   */
  public static function error401($message = 'Unauthorized')
  {
    self::json([
      'error' => $message,
    ], 401);
  }

  /**
   *  Handle 422 - Unprocessable Entity.
   * 
   *  @param string $message
   *  @return void
   */
  public static function error422($message = 'Unprocessable Entity')
  {
    self::json(['error' => $message], 422);
  }

  /**
   * Handle 500 - Internal Server Error.
   *
   * @param string $message
   * @return void
   */
  public static function error500($message = 'Internal Server Error')
  {
    self::json([
      'error' => $message,
    ], 500);
  }

  /**
   * Handle 405 - Method Not Allowed.
   *
   * @param string $message
   * @return void
   */
  public static function error405($message = 'Method Not Allowed')
  {
    self::json([
      'error' => $message,
    ], 405);
  }

  /**
   * Handle generic exceptions.
   *
   * @param \Exception $exception
   * @return void
   */
  public static function handleException($exception)
  {
    self::json([
      'error' => 'An unexpected error occurred.',
      'message' => $exception->getMessage(),
    ], 500);
  }

  /**
   * Handle validation errors (422 Unprocessable Entity).
   *
   * @param array $errors
   * @return void
   */
  public static function validationError(array $errors)
  {
    self::json([
      'error' => 'Validation Failed',
      'errors' => $errors,
    ], 422);
  }
}
