<?php

namespace App\Providers;

use App\Config\StripeConfig;
use App\Services\V1\StripeService;

class StripeProvider
{
  public static function getStripeService(): StripeService
  {
    $config = new StripeConfig(
      stripeSecretKey: $_ENV['STRIPE_SECRET_KEY'],
      stripeRedirectUrl: $_ENV['STRIPE_REDIRECT_URL'],
      stripeSuccessUrl: 'http://localhost:3000/success',
      stripeCancelUrl: 'http://localhost:3000/cancel'
    );

    return new StripeService($config);
  }
}
