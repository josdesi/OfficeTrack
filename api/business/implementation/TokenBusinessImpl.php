<?php

use \Firebase\JWT\JWT;

class TokenBusinessImpl
{
    public function createSessionToken($userDTO,$sessionType)
    {
        $payload = array(
            "data" => array(
                "sessionType"=> $sessionType,
                "userId" => $userDTO->getUserId(),
                "username" => $userDTO->getUsername(),
                "name" => $userDTO->getEmail(),
                "fatherSurname" => $userDTO->getfatherSurname(),
                "motherSurname" => $userDTO->getmotherSurname(),
            )
        );
        return JWT::encode($payload, "example_key");
    }

    public function decodeSessionToken($token)
    {
        try {
            return $decoded = JWT::decode($token, "example_key", array('HS256'));
        } catch (Exception $e) {
            throw new Exception("Token invalido");            
        }
    }
}
