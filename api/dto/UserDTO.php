<?php
class UserDTO implements JsonSerializable {
 
    private $userId = "";
    private $username = "";
    private $password = "";
    private $name = "";
    private $fatherSurname = "";
    private $motherSurname = "";
    private $phone = "";
    private $email = "";
    private $verify = 0;
    private $emailToken = "";
    private $created = ""; 
    private $modified = ""; 

    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }


    public function getUsername(){
        return $this->username;
    }
    public function setUsername($username){
        $this->username = $username;
    }


    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){        
        $this->password = $password;
    }


    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }


    public function getFatherSurname(){
        return $this->fatherSurname;
    }
    public function setFatherSurname($fatherSurname){
        $this->fatherSurname = $fatherSurname;
    }


    public function getMotherSurname(){
        return $this->motherSurname;
    }
    public function setMotherSurname($motherSurname){
        $this->motherSurname = $motherSurname;
    }

    public function getPhone(){
        return $this->phone;
    }
    public function setPhone($phone){
        $this->phone = $phone;
    }


    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }


    public function getEmailToken(){
        return $this->emailToken;
    }
    public function setEmailToken($emailToken){
        $this->emailToken = $emailToken;
    }


    public function getVerify(){
        return $this->verify;
    }
    public function setVerify($verify){
        $this->verify = $verify;
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

    public function jsonSerialize() {
        return [            
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'name' => $this->name,
            'fatherSurname' => $this->fatherSurname,
            'motherSurname' => $this->motherSurname,
            'phone' => $this->phone,
            'email' => $this->email
        ];
    }
}
?>