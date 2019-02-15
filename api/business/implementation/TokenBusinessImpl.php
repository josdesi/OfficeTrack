<?php

include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

class TokenBusinessImpl
{
    public function createToken($userDTO)
    {
        $token = array(
            "id" => $userDTO->getId(),
            "username" => $userDTO->getUsername(),
            "email" => $userDTO->getEmail(),
        );
        return JWT::encode($token, "example_key");
    }

    public function validateToken($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, "example_key", array('HS256'));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function decodeToken($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, "example_key", array('HS256'));
            $decoded = (array) $decoded;
            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }
}
