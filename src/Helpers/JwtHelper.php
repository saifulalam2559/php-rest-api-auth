<?php
namespace App\Helpers;

class JwtHelper
{
    private static $secret = 'CHANGE_ME_SECRET_KEY';

    public static function generate($payload, $expireSeconds = 3600)
    {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload['exp'] = time() + $expireSeconds;
        $payloadEncoded = base64_encode(json_encode($payload));

        $signature = hash_hmac(
            'sha256',
            $header . '.' . $payloadEncoded,
            self::$secret,
            true
        );

        return $header . '.' . $payloadEncoded . '.' . base64_encode($signature);
    }

    public static function verify($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;

        [$header, $payload, $signature] = $parts;

        $expected = base64_encode(hash_hmac(
            'sha256',
            $header . '.' . $payload,
            self::$secret,
            true
        ));

        if (!hash_equals($expected, $signature)) return false;

        $data = json_decode(base64_decode($payload), true);

        if (!empty($data['exp']) && $data['exp'] < time()) return false;

        return $data;
    }
}
