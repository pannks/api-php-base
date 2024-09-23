<?php

namespace App\Interfaces;

interface MailServiceInterface
{
  public function send(array $data): bool;
  public function preview(array $data): string;
}
