<?php
namespace App\Middleware;

use App\Helpers\Response;

class RateLimitMiddleware
{
    public static function handle($limit = 60, $seconds = 60)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = sys_get_temp_dir() . '/rate_' . md5($ip);

        $data = file_exists($key) ? json_decode(file_get_contents($key), true) : [
            'count' => 0,
            'start' => time()
        ];

        if (time() - $data['start'] > $seconds) {
            $data = ['count' => 0, 'start' => time()];
        }

        $data['count']++;

        if ($data['count'] > $limit) {
            Response::json(['error' => 'Too many requests'], 429);
        }

        file_put_contents($key, json_encode($data));
    }
}
