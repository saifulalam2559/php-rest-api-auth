<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Helpers\Response;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

$authController = new AuthController();

if ($uri === '/api/register' && $method === 'POST') {
    $authController->register();
} elseif ($uri === '/api/login' && $method === 'POST') {
    $authController->login();
} elseif ($uri === '/api/profile' && $method === 'GET') {
    $authController->profile();
} else {
    Response::json(['message' => 'Route not found'], 404);
}
