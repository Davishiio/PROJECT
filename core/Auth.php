<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Auth.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Auth
{
    private static $secret = 'a9263b102ce9142f8b9c8ffad584203b'; //https://www.infranetworking.com/md5 "davidjosue" xd
public static function generateToken($userId, $role) {
    $payload = [
        'iss' => 'lapuerka.com      ',       // Issuer
        'iat' => time(),                   // Issued at
        'exp' => time() + 3600,            // Expira en 1 hora
        'data' => [
            'id_usuario' => $userId,
            'rol' => $role
        ] // como extra de seguridad podemos encriptar el id del usuario y su rol pero no quiero 
    ];

    return JWT::encode($payload, self::$secret, 'HS256');
}



    public static function validateToken($token) {
    try {
        $decoded = JWT::decode($token, new Key(self::$secret, 'HS256'));
        return $decoded->data;
    } catch (Exception $e) {
        return false;
    }
}

}
