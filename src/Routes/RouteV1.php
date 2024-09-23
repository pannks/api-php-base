<?php

namespace App\Routes;

use App\Config\AuthConfig;
use App\Utils\Request;
use App\Utils\Response;

use App\Database\Database;

use App\Services\V1\UserService;
use App\Services\V1\StripeService;
use App\Services\V1\AuthenticationService;

use App\Controllers\V1\LineController;
use App\Controllers\V1\MailController;
use App\Controllers\V1\UserController;
use App\Controllers\V1\StripeController;

use App\Interfaces\LineServiceInterface;
use App\Interfaces\MailServiceInterface;
use App\Interfaces\UserServiceInterface;

use App\Middleware\AuthenticationMiddleware;

class RouteV1 extends BaseRoute
{

  protected function registerServices()
  {
    $database = Database::getInstance($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_PORT']);
    $pdo = $database->getConnection();
    $authConfig = new AuthConfig(authToken: $_ENV['AUTH_TOKEN']);

    $this->container->set(AuthenticationService::class, function () use ($authConfig): AuthenticationService {
      return new AuthenticationService($authConfig);
    });

    $this->container->set(AuthenticationMiddleware::class, function () {
      return new AuthenticationMiddleware(
        $this->container->get(AuthenticationService::class)
      );
    });

    $this->container->set(UserServiceInterface::class, function () use ($pdo): UserService {
      return new UserService(pdo: $pdo);
    });

    $this->container->set(MailServiceInterface::class, function () {
      return \App\Providers\MailProvider::getGoogleMailService();
    });

    $this->container->set(LineServiceInterface::class, function () {
      return \App\Providers\LineProvider::getLineService();
    });

    $this->container->set(StripeService::class, function () {
      return \App\Providers\StripeProvider::getStripeService();
    });
  }

  protected function registerControllers()
  {
    $this->container->set(UserController::class, function (): UserController {
      return new UserController($this->container->get(UserServiceInterface::class));
    });

    $this->container->set(MailController::class, function (): MailController {
      return new MailController($this->container->get(MailServiceInterface::class));
    });

    $this->container->set(LineController::class, function (): LineController {
      return new LineController($this->container->get(LineServiceInterface::class));
    });

    $this->container->set(StripeController::class, function (): StripeController {
      return new StripeController(
        stripeService: $this->container->get(StripeService::class),
        mailService: $this->container->get(MailServiceInterface::class)
      );
    });
  }

  protected function defineRoutes()
  {
    $userController = $this->container->get(UserController::class);
    $mailController = $this->container->get(MailController::class);
    $lineController = $this->container->get(LineController::class);
    $stripeController = $this->container->get(StripeController::class);

    $auth = [AuthenticationMiddleware::class];

    $this->route('test')
      ->add('GET', '', fn(Request $r) => Response::json('Hello, World!'));

    $this->route('users')
      ->add('GET', '', fn(Request $r) => $userController->getAll($r), $auth)
      ->add('GET', ':id', fn(Request $r) => $userController->getById($r), $auth)
      ->add('POST', '', fn(Request $r) => $userController->create($r), $auth)
      ->add('PUT', ':id', fn(Request $r) => $userController->update($r), $auth)
      ->add('DELETE', ':id', fn(Request $r) => $userController->delete($r), $auth);

    $this->route('mail')
      ->add('POST', '', fn(Request $r) => $mailController->sendMail($r))
      ->add('POST', 'preview', fn(Request $r) => $mailController->previewMail($r))
      ->add('POST', 'send', fn(Request $r) => $mailController->sendMail($r))
      ->add('POST', 'preview/:template', fn(Request $r) => $mailController->previewMail($r))
      ->add('POST', 'send/:template', fn(Request $r) => $mailController->sendMail($r));

    $this->route('line-notify')
      ->add('GET', '', fn(Request $r) => Response::json(['message' => 'Hello, World!']))
      ->add('POST', 'preview', fn(Request $r)  => $lineController->previewNotifyMessage($r))
      ->add('POST', ':path', fn(Request $r)  => $lineController->sendNotifyMessage($r));

    $this->route('line-push')
      ->add('GET', '', fn(Request $r) => Response::json(['message' => 'Hello, World!']))
      ->add('POST', 'push', fn(Request $r)  => $lineController->sendPushMessage($r))
      ->add('POST', 'preview', fn(Request $r)  => $lineController->previewPushMessage($r));

    $this->route('checkout')
      ->add('GET', '', fn(Request $r) => Response::json(['message' => 'API is running']))
      ->add('POST', 'status', fn(Request $r) => $stripeController->getCheckoutStatus($r))
      ->add('POST', 'info', fn(Request $r) => $stripeController->getSessionInfo($r))
      ->add('POST', 'lineitems', fn(Request $r) => $stripeController->getSessionLineItems($r))
      ->add('POST', '', fn(Request $r) => $stripeController->createEmbeddedCheckout($r));
  }
}
