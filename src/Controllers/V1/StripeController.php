<?php

namespace App\Controllers\V1;

use App\Interfaces\MailServiceInterface;
use App\Utils\Request;
use App\Utils\Response;
use App\Services\V1\StripeService;

class StripeController
{
  private StripeService $stripeService;
  private $mailService;


  public function __construct(StripeService $stripeService, MailServiceInterface $mailService)
  {
    $this->stripeService = $stripeService;
    $this->mailService = $mailService;
  }

  public function createEmbeddedCheckout(Request $request): void
  {
    $data = $request->body;
    $this->stripeService->createEmbeddedCheckoutSession($data);
  }

  public function getCheckoutStatus(Request $request): void
  {

    if (!isset($request->body['session_id'])) {
      echo Response::error404('Session ID not found');
    }

    $session_id = $request->body['session_id'];
    $response_obj = $this->stripeService->getCheckoutStatus(session_id: $session_id);

    // if ($response_obj['status'] === 'complete') {
    //   $mailService = $this->mailService;

    //   $res = $mailService->send([
    //     'to' => $response_obj['customer_email'],
    //     'toName' => $response_obj['customer_email'],
    //     'from' => "pann@gmail.com",
    //     'fromName' => "PannKs",
    //     'name' => $request->body['customer_name'] ?? '',
    //     'subject' => 'Thank You for Ordering',
    //     "orderNumber" => $request->body['order_number'] ?? '',
    //     'templateName' => 'thank_you',
    //     "buttonUrl" => "https://google.com",
    //     "buttonText" => "Get File",
    //   ]);
    //   if ($res) {
    //     echo Response::json($response_obj);
    //   } else {
    //     $response_obj['message'] = 'Failed to send email';
    //     echo Response::json($response_obj, 500);
    //   }
    // } 
    echo Response::json($response_obj);
  }
  public function getSessionInfo(Request $request): void
  {


    if (!isset($request->body['session_id'])) {
      echo Response::error404('Session ID not found');
    }

    $session_id = $request->body['session_id'];
    $response_obj = $this->stripeService->retrieveSession(session_id: $session_id);

    echo Response::json($response_obj);
  }
  public function getSessionLineItems(Request $request): void
  {


    if (!isset($request->body['session_id'])) {
      echo Response::error404('Session ID not found');
    }

    $session_id = $request->body['session_id'];
    $response_obj = $this->stripeService->retrieveSessionLineItems(session_id: $session_id);

    echo Response::json($response_obj);
  }
}
