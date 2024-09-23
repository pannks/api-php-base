<?php

namespace App\Config;

class StripeConfig
{
  private string $stripeSecretKey;
  private string $stripeRedirectUrl;
  private string $stripeSuccessUrl;
  private string $stripeCancelUrl;


  public function __construct(string $stripeSecretKey, string $stripeRedirectUrl, string $stripeSuccessUrl, string $stripeCancelUrl)
  {
    $this->stripeSecretKey = $stripeSecretKey;
    $this->stripeRedirectUrl = $stripeRedirectUrl;
    $this->stripeSuccessUrl = $stripeSuccessUrl;
    $this->stripeCancelUrl = $stripeCancelUrl;
  }

  public function getStripeSecretKey(): string
  {
    return $this->stripeSecretKey;
  }

  public function getStripeRedirectUrl(): string
  {
    return $this->stripeRedirectUrl;
  }

  public function getStripeSuccessUrl(): string
  {
    return $this->stripeSuccessUrl;
  }

  public function getStripeCancelUrl(): string
  {
    return $this->stripeCancelUrl;
  }
}
