<?php
namespace App\Controllers;

use App\Models\User;
use App\Helpers\Response;

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

        // Simple token (for demo)
        $token = base64_encode($user['id'] . '|' . time());

        Response::json([
            'token' => $token,
            'user' => ['id' => $user['id'], 'email' => $user['email']]
        ]);
    }

    public function profile()
    {
        $headers = getallheaders();
        if (empty($headers['Authorization'])) {
            Response::json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $parts = explode('|', base64_decode($token));

        $userId = $parts[0] ?? null;

        if (!$userId) {
            Response::json(['error' => 'Invalid token'], 401);
        }

        $user = User::findById($userId);

        Response::json(['user' => $user]);
    }
}
