<?php

namespace App\Services\V1;

use Stripe\Stripe;
use App\Utils\Response;
use App\Config\LineConfig;
use App\Config\StripeConfig;
use Stripe\Checkout\Session;

class StripeService
{
  private StripeConfig $config;

  public function __construct(StripeConfig $config)
  {
    $this->config =  $config;
  }

  public function createEmbeddedCheckoutSession($data)
  {
    Stripe::setApiKey($this->config->getStripeSecretKey());

    $checkoutObject = [
      'ui_mode' => 'embedded',
      'line_items' => $data['line_items'],
      'customer_email' => $data['customer_email'],
      'mode' => 'payment',
      'locale' => 'th',
      'phone_number_collection' => ['enabled' => true],
      'return_url' => $this->config->getStripeRedirectUrl() . '/return?session_id={CHECKOUT_SESSION_ID}',
      // 'success_url' => 'http://localhost:3000' . '/success.php',
      // 'cancel_url' => 'http://localhost:3000' . '/cancel.php',
    ];

    if ($data['coupon_code']) {
      $checkoutObject['discounts'] = [['coupon' => $data['coupon_code']]];
    }

    $checkout_session = Session::create($checkoutObject);

    return Response::json(['clientSecret' => $checkout_session->client_secret]);
  }

  public function getCheckoutStatus(string $session_id)
  {
    $stripe = new \Stripe\StripeClient($this->config->getStripeSecretKey());

    try {
      $session = $stripe->checkout->sessions->retrieve($session_id);
      if ($session->status === 'complete') {
        $listItems = $stripe->checkout->sessions->allLineItems($session_id);

        $responseObj = [
          'id' => $session->id,
          "created" => $session->created,
          'amount_total' => $session->amount_total,
          'status' => $session->status,
          'customer_email' => $session->customer_details->email,
          'phone' => $session->customer_details->phone,
          'expires_at' => $session->expires_at,
          'mode' => $session->mode,
          'line_items' => $listItems->data
        ];

        return $responseObj;
      }
    } catch (\Exception $e) {
      return Response::error500($e->getMessage());
    }
  }
  public function retrieveSession(string $session_id)
  {
    $stripe = new \Stripe\StripeClient($this->config->getStripeSecretKey());
    try {
      $session = $stripe->checkout->sessions->retrieve($session_id);
      return $session;
    } catch (\Exception $e) {
      return Response::error500($e->getMessage());
    }
  }
  public function retrieveSessionLineItems(string $session_id)
  {
    $stripe = new \Stripe\StripeClient($this->config->getStripeSecretKey());
    try {
      $session = $stripe->checkout->sessions->allLineItems($session_id);
      return $session;
    } catch (\Exception $e) {
      return Response::error500($e->getMessage());
    }
  }

  public function createCustomer(string $name, string $email, string $phone)
  {
    $stripe = new \Stripe\StripeClient($this->config->getStripeSecretKey());

    $customer = $stripe->customers->create([
      'name' => $name,
      'email' => $email,
      'phone' => $phone
    ]);

    return $customer;
  }
}
