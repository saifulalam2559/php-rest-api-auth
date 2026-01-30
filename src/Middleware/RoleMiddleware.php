<?php
namespace App\Middleware;

use App\Helpers\Response;

class RoleMiddleware
{
    public static function require($role, $user)
    {
        if (empty($user['role']) || $user['role'] !== $role) {
            Response::json(['error' => 'Forbidden - insufficient role'], 403);
        }
    }
}
