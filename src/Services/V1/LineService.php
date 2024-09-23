<?php

namespace App\Services\V1;

use App\Utils\Response;
use App\Config\LineConfig;
use App\Utils\TemplateEngine;
use App\Interfaces\LineServiceInterface;
use App\Utils\CustomException;

class LineService implements LineServiceInterface
{
  private LineConfig $config;
  private TemplateEngine $templateEngine;

  public function __construct(LineConfig $config)
  {
    $this->config =  $config;
    $templateDir = __DIR__ . '/../../templates/messages/';
    $this->templateEngine = new TemplateEngine($templateDir, 'json');
  }

  public function notify(string $message, ?string $channel = null): void
  {

    $channel = $channel ?? $this->config->getChannelAccessToken();

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: Bearer ' . $channel
    ];

    $postData = http_build_query([
      'message' => $message
    ]);

    $ch = curl_init($this->config->getNotifyUrl());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200) {
      echo Response::json(['success' => true, 'response' => $response]);
    } else {
      echo Response::json(['success' => false, 'error' => $error ?: 'Unknown error', 'response' => $response], $httpCode);
    }
  }

  public function push(string $to, string | array $message, ?string $templateName = null): void
  {
    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->config->getLinePushAccessToken()
    ];

    $messageJson = $message;
    if ($templateName !== null) {
      $json = $this->templateEngine->render($templateName, $message ?? []);
      $messageJson = json_decode($json, true);
    }

    $postData = json_encode([
      'to' => $to,
      'messages' => $messageJson
    ]);

    $ch = curl_init($this->config->getLinePushUrl());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200) {
      echo Response::json(['success' => true, 'response' => $response]);
    } else {
      echo Response::json(['success' => false, 'error' => $error ?: 'Unknown error', 'response' => $response], $httpCode);
    }
  }

  public function previewPushMessage(string | array $message, ?string $templateName = null): string | array
  {
    $messageJson = $message;
    try {
      if ($templateName !== null) {
        $this->templateEngine->validate($templateName, (object)$message);
        $messageJson = $this->templateEngine->render($templateName, $message ?? []);
      }
    } catch (\Exception $e) {
      Response::error400($e->getMessage());
      return '';
    }

    return $messageJson;
  }

  public function previewNotifyMessage(array|string $message, string $templateName): string
  {
    $this->templateEngine = new TemplateEngine(__DIR__ . '/../../templates/chats/', 'txt');
    try {
      $this->templateEngine->validate($templateName, (object)$message);
      $message = $this->templateEngine->render($templateName, $message);
      return $message;
    } catch (CustomException $e) {
      Response::error400($e->getErrors());
      return '';
    } catch (\Exception $e) {
      Response::error400($e->getMessage());
      return '';
    }
  }
}
