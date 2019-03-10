<?php

class SessionBusinessImpl implements SessionBusiness{
         
    public function createSession( $sessionDTO ){
        
        $database = new Database();
        $db = $database->getConnection();        
        $session = new Session( $db );

        $session->userId = $sessionDTO->getUserId();
        $session->token = $sessionDTO->getToken();
        $session->sessionType = $sessionDTO->getSessionType();
        
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
        
        $database = new Database();
        $db = $database->getConnection();
        $session = new Session( $db );

        $session->userId = $sessionDTO->getUserId();
        $session->sessionType = $sessionDTO->getSessionType();

        try {
            $session->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }    
}
?>