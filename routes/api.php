<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === "/ecommerce_api/test" && $method === "GET") {
  echo json_encode(["message" => "Api is Working"]);
  exit;
}


http_response_code(404);
echo  json_encode(["Route" => "Route Not Found"]);
