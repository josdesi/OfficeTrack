<?php

class SessionBusinessImpl implements SessionBusiness{
         
    public function createSession( $sessionDTO ){
        
        $database = new Database();
        $db = $database->getConnection();        
        $session = new Session( $db );

        $session->user_id = $sessionDTO->getUser_id();
        $session->token = $sessionDTO->getToken();
        
        try {
            $session->create();
            return $sessionDTO;
        } catch (Exception $e) {
            throw $e;
            return null;
        }
    }

    public function readSession( $sessionDTO ){
        
    }
    
    public function updateSession( $sessionDTO ){
        
    }

    public function deleteSession( $sessionDTO ){
        
    }    
}
?>