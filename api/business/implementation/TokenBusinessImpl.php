<?php

use \Firebase\JWT\JWT;

class TokenBusinessImpl
{
    public function createToken($userDTO)
    {
        $token = array(
            "id" => $userDTO->getId(),
            "username" => $userDTO->getUsername(),
            "name" => $userDTO->getEmail(),
            "fatherSurname" => $userDTO->getfatherSurname(),
            "motherSurname" => $userDTO->getmotherSurname(),
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
