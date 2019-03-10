<?php

class SessionDTO
{
    private $userId;
    private $token;
    private $sessionType;

    public function getUserId(){
        return $this->userId;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function getSessionType(){
        return $this->sessionType;
    }

    public function setSessionType($sessionType){
        $this->sessionType = $sessionType;
    }
}  

?>