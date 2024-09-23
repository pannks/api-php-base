<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\App\Route;
// use App\Database\Database;

// set_exception_handler("ErrorHandler::handleException");
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

// $database = Database::getInstance($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
// $conn = $database->getConnection();
$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];
$stripeRedirectUrl = $_ENV['STRIPE_REDIRECT_URL'];

$route = new Route();
$route->handleRequest();



// switch ($resource) {
//         // case 'visit_logs':
//         //     $visit_log_gateway = new VisitLogGateway($database);
//         //     $controller = new VisitLogController($visit_log_gateway);
//         //     $controller->processRequest($method, $id);
//         //     break;

//     case 'mail':
//         $mail_gateway = new MailGateway();
//         $controller = new MailController($mail_gateway);
//         $controller->processRequest($method);
//         break;

//     case 'checkout':
//         $controller = new CheckoutController($stripeSecretKey);
//         $controller->createCheckoutSession();
//         break;

//     case 'status':
//         $controller = new CheckoutStatus($stripeSecretKey);
//         $controller->getStatus();
//         break;

//     case 'line-notify':
//         $line_notify_gateway = new LineNotifyGateway();
//         $controller = new LineNotifyController($line_notify_gateway);
//         $controller->processRequest($method, $id);
//         break;

//     case 'line-push':
//         $line_push_gateway = new LinePushGateway();
//         $controller = new LinePushController($line_push_gateway);
//         $controller->processRequest($method);
//         break;

//     default:
//         http_response_code(404);
//         exit;
// }
