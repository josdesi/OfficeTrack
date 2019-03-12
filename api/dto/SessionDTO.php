<?php

class SessionDTO
{
    private $sessionId = "";
    private $userId = "";
    private $sessionToken = "";
    private $sessionType = "";
    private $created = ""; 
    private $modified = ""; 

    public function getSessionId(){
        return $this->sessionId;
    }
    public function setSessionId($sessionId){
        $this->sessionId = $sessionId;
    }


    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }


    public function getSessionToken(){
        return $this->sessionToken;
    }
    public function setSessionToken($sessionToken){
        $this->sessionToken = $sessionToken;
    }


    public function getSessionType(){
        return $this->sessionType;
    }
    public function setSessionType($sessionType){
        $this->sessionType = $sessionType;
    }


    public function getCreated(){
		return $this->created;
	}
	public function setCreated($created){
		$this->created = $created;
	}


	public function getModified(){
		return $this->modified;
	}
	public function setModified($modified){
		$this->modified = $modified;
	}
}  

?>