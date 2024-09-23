<?php

namespace App\Services\V1;

use App\Interfaces\MailServiceInterface;

class  MailService implements MailServiceInterface
{
  public function __construct() {}

  public function send(array $data): bool
  {
    // Simulated logic to send an email
    return true;
  }

  public function preview(array $data): string
  {
    return "Mail sent to {$data['to']} with subject: {$data['subject']}";
  }
}
