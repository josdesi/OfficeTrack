<?php

include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

class TokenBusinessImpl 
{    
    public function createToken( $userDTO){
        $token = array(
            // "iss" => $iss,
            // "aud" => $aud,
            // "iat" => $iat,
            // "nbf" => $nbf,
            "data" => array(
                "id" => $userDTO->getId(),
                "username" => $userDTO->getUsername(),
                "email" => $userDTO->getEmail(),
            )
         );
         return JWT::encode($token, "excaple_key");
    }

    public function validateToken($jwt){
        try {
            $decoded = JWT::decode($jwt, "excaple_key", array('HS256'));
            $decoded = (array) $decoded;
            return (array)$decoded["data"];
     
        }catch(Exception $e){
            return false;
        }
    }
}
?>