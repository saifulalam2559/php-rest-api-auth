<?php
namespace App\Middleware;

use App\Helpers\JwtHelper;
use App\Helpers\Response;

class AuthMiddleware
{
    public static function handle()
    {
        $headers = getallheaders();

        if (empty($headers['Authorization'])) {
            Response::json(['error' => 'Authorization header missing'], 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $payload = JwtHelper::verify($token);

        if (!$payload) {
            Response::json(['error' => 'Invalid or expired token'], 401);
        }

        return $payload;
    }
}
