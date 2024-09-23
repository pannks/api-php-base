<?php

namespace App\Providers;

use App\Config\MailConfig;
use App\Services\V1\GoogleMailService;
use App\Interfaces\MailServiceInterface;

class MailProvider
{
  public static function getGoogleMailService(): MailServiceInterface
  {
    $config = new MailConfig(
      smtpHost: $_ENV['SMTP_HOST'],
      smtpPort: (int)$_ENV['SMTP_PORT'],
      smtpUsername: $_ENV['SMTP_USER'],
      smtpPassword: $_ENV['SMTP_PASSWORD'],
      smtpEncryption: $_ENV['SMTP_ENCRYPTION'] ?? 'tls'
    );

    return new GoogleMailService($config);
  }
}
