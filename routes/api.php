<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$authController = new AuthController($pdo);

if ($uri === "/ecommerce_api/register" && $method == "POST") {
  $authController->register();
  exit;
}

http_response_code(404);
echo  json_encode(["Route" => "Route Not Found"]);
