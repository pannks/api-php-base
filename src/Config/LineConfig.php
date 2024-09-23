<?php

namespace App\Config;

class LineConfig
{
  private string $notifyUrl;
  private string $channelAccessToken;
  private string $channelSecret;
  private string $linePushUrl;
  private string $linePushAccessToken;


  public function __construct(string $channelAccessToken, string $channelSecret, string $linePushUrl, string $linePushAccessToken, string $notifyUrl)
  {
    $this->linePushUrl = $linePushUrl;
    $this->linePushAccessToken = $linePushAccessToken;
    $this->notifyUrl = $notifyUrl;
    $this->channelAccessToken = $channelAccessToken;
    $this->channelSecret = $channelSecret;
  }

  public function getChannelAccessToken(): string
  {
    return $this->channelAccessToken;
  }

  public function getChannelSecret(): string
  {
    return $this->channelSecret;
  }

  public function getLinePushUrl(): string
  {
    return $this->linePushUrl;
  }

  public function getLinePushAccessToken(): string
  {
    return $this->linePushAccessToken;
  }

  public function getNotifyUrl(): string
  {
    return $this->notifyUrl;
  }
}
