<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\App\Route;

$configFile = '.env';
// $configFile = '.env.prod';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__), $configFile);
$dotenv->load();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

$route = new Route();
$route->handleRequest();
