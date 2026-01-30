<?php
namespace App\Controllers;

use App\Models\User;
use App\Helpers\Response;
use App\Middleware\RoleMiddleware;

class AuthController
{
    public function register()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['email']) || empty($input['password'])) {
            Response::json(['error' => 'Email and password required'], 422);
        }

        User::create($input['email'], $input['password']);

        Response::json(['message' => 'User registered successfully']);
    }

public function login()
{
    $input = json_decode(file_get_contents('php://input'), true);

    $user = User::findByEmail($input['email']);

    if (!$user || !password_verify($input['password'], $user['password'])) {
        Response::json(['error' => 'Invalid credentials'], 401);
    }

    $token = JwtHelper::generate([
        'user_id' => $user['id'],
        'email'   => $user['email']
    ]);

    Response::json([
        'token' => $token,
        'user' => ['id' => $user['id'], 'email' => $user['email']]
    ]);
}

//
public function profile()
{
    $payload = AuthMiddleware::handle();

    $user = User::findById($payload['user_id']);

    Response::json(['user' => $user]);
}




public function adminOnly()
{
    $payload = AuthMiddleware::handle();
    $user = User::findById($payload['user_id']);

    RoleMiddleware::require('admin', $user);

    Response::json(['message' => 'Welcome Admin', 'user' => $user]);
}


    
}
