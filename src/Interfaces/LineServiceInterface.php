<?php

namespace App\Interfaces;

interface LineServiceInterface
{
  public function notify(string $message, ?string $channel = null): void;
  public function push(string $to, string $message): void;
  public function previewPushMessage(string | array $message, ?string $templateName): string | array;
  public function previewNotifyMessage(array|string $message, string $templateName): string;
}
