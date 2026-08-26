<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/response.php';

class AuthController
{
  private $userModel;

  public function __construct($pdo)
  {
    $this->userModel = new User($pdo);
  }

  public function register()
  {
    $input = json_decode(file_get_contents("php://input"), true);

    $name = trim($input['name'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';


    if (empty($name) || empty($email) || empty($password)) {
      sendResponse(400, false, "Name, Email, password are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      sendResponse(400, false, "Invalid Email Format");
    }

    if (strlen($password) < 6) {
      sendResponse(400, false, "Password length must be at least 6 characters");
    }

    $existingUser = $this->userModel->findByEmail($email);

    if ($existingUser) {
      sendResponse(409, false, "User already exists with this email");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userId = $this->userModel->create($name, $email, $hashedPassword);

    sendResponse(201, true, "User Registered Successfully", [
      'id' => $userId,
      'name' => $name,
      'email' => $email
    ]);
  }
}
