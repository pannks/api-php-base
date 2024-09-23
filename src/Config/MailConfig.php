<?php

namespace App\Config;

class MailConfig
{
  private string $smtpHost;
  private int $smtpPort;
  private string $smtpUsername;
  private string $smtpPassword;
  private string $smtpEncryption;

  public function __construct(
    string $smtpHost,
    int $smtpPort,
    string $smtpUsername,
    string $smtpPassword,
    string $smtpEncryption = 'tls'
  ) {
    $this->smtpHost = $smtpHost;
    $this->smtpPort = $smtpPort;
    $this->smtpUsername = $smtpUsername;
    $this->smtpPassword = $smtpPassword;
    $this->smtpEncryption = $smtpEncryption;
  }

  public function getSmtpHost(): string
  {
    return $this->smtpHost;
  }

  public function getSmtpPort(): int
  {
    return $this->smtpPort;
  }

  public function getSmtpUsername(): string
  {
    return $this->smtpUsername;
  }

  public function getSmtpPassword(): string
  {
    return $this->smtpPassword;
  }

  public function getSmtpEncryption(): string
  {
    return $this->smtpEncryption;
  }
}
