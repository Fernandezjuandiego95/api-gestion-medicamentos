<?php

require_once __DIR__ . "/../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler {
    private static $secret_key = '2323';
    private static $codigo = 'HS256';
    private static $exp_seconds = 3600;

    public static function generateToken($user) {
        $issuedAt = time();
        $payload = [
            'iat' => $issuedAt,
            'exp' => $issuedAt + self::$exp_seconds,
            'data' => [
                'id' => $user['id'],
                'username' => $user['username']
            ]
        ];
        return JWT::encode($payload, self::$secret_key, self::$codigo);
    }

    public static function validateToken($jwt) {
        try {
            $decoded = JWT::decode($jwt, new Key(self::$secret_key, self::$codigo));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
}
