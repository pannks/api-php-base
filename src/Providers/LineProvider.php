<?php

namespace App\Providers;

use App\Config\LineConfig;
use App\Services\V1\LineService;


class LineProvider
{
  public static function getLineService()
  {
    $config = new LineConfig(
      linePushUrl: 'https://api.line.me/v2/bot/message/push',
      linePushAccessToken: $_ENV['LINE_PUSH_ACCESS_TOKEN'],
      notifyUrl: 'https://notify-api.line.me/api/notify',
      channelAccessToken: $_ENV['LINE_CHANNEL_ACCESS_TOKEN'],
      channelSecret: $_ENV['LINE_CHANNEL_SECRET']
    );

    return new LineService($config);
  }
}
