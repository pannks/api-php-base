<?php

namespace App\Controllers\V1;

use App\Utils\Request;
use App\Utils\Response;
use App\Interfaces\LineServiceInterface;
use App\Utils\Validators\ProcessLineValidator;

class LineController
{
  private LineServiceInterface $lineService;

  public function __construct(LineServiceInterface $lineService)
  {
    $this->lineService = $lineService;
  }

  public function sendNotifyMessage(Request $request): void
  {
    if ($request->params['path'] !== 'notify') {
      echo Response::error404('Notify path not found: ' . $request->params['path']);
      return;
    }

    $validationErrors = ProcessLineValidator::validateNotify($request->body);

    if (!empty($validationErrors)) {
      echo Response::json(['errors' => $validationErrors], 400);
      return;
    }

    $this->lineService->notify($request->body['message']);
    return;
  }

  public function sendPushMessage(Request $request): void
  {


    $validationErrors = ProcessLineValidator::validatePush($request->body);

    if (!empty($validationErrors)) {
      echo Response::json(['errors' => $validationErrors], 400);
      return;
    }

    $this->lineService->push($request->body['to'], $request->body['body']);
    return;
  }

  public function previewPushMessage(Request $request): void
  {
    $previewMessage = json_decode($this->lineService->previewPushMessage($request->body['message'], $request->body['templateName']));
    echo Response::json($previewMessage);
    return;
  }

  public function previewNotifyMessage(Request $request): void
  {
    $previewMessage = $this->lineService->previewNotifyMessage($request->body['message'], $request->body['templateName']);
    echo Response::txt($previewMessage);
    return;
  }
}
