<?php

class SessionDTO
{
    private $user_id;
    private $token;

    public function getUser_id(){
        return $this->user_id;
    }

    public function setUser_id($user_id){
        $this->user_id = $user_id;
    }

    public function getToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $token;
    }
}  

?>