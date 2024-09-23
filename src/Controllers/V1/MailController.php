<?php

namespace App\Controllers\V1;

use App\Utils\Request;
use App\Utils\Response;
use App\Interfaces\MailServiceInterface;
use App\Utils\Validators\CreateMailValidator;

class MailController
{
  private $mailService;

  public function __construct(MailServiceInterface $mailService)
  {
    $this->mailService = $mailService;
  }

  public function sendMail(Request $request)
  {
    $validationErrors = CreateMailValidator::validate($request->body);
    if (!empty($validationErrors)) {
      // Respond with validation errors
      echo Response::json(['errors' => $validationErrors], 400);
      return;
    }
    $data = $request->body;
    $template = $request->params['template'] ?? null;

    if ($template) {
      $data = $this->addTemplateNameFromPath($template, $data);
    } elseif (!isset($data['templateName'])) {
      return Response::error400('templateName not found in body nor params');
    }

    try {
      $result = $this->mailService->send($data);
      if ($result) {
        return Response::json(['message' => 'Mail sent successfully']);
      } else {
        return Response::error500('Failed to send mail');
      }
    } catch (\InvalidArgumentException $e) {
      return Response::error400($e->getMessage());
    } catch (\Exception $e) {
      return Response::error500($e->getMessage());
    }
  }

  public function previewMail(Request $request)
  {
    $data = $request->body;
    $template = $request->params['template'] ?? null;

    if ($template) {
      $data = $this->addTemplateNameFromPath($template, $data);
    } elseif (!isset($data['templateName'])) {
      return Response::error400('templateName not found in body nor params');
    }

    try {
      $result = $this->mailService->preview($data);
      return Response::html($result);
    } catch (\InvalidArgumentException $e) {
      return Response::error400($e->getMessage());
    } catch (\Exception $e) {
      return Response::error500($e->getMessage());
    }
  }

  private function addTemplateNameFromPath(string $path, array $data): array
  {
    switch ($path) {
      case 'new-order':
        $data['templateName'] = 'thank_you';
        break;
      default:
        return $data;
    }

    return $data;
  }
}
