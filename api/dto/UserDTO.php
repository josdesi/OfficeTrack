<?php
class UserDTO implements JsonSerializable {
 
    private $id;
    private $username;
    private $password;
    private $name;
    private $fatherSurname;
    private $motherSurname;
    private $phone;
    private $email;
    private $verify;
    private $emailToken;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
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
        return $this->email;
    }

    public function setVerify($verify){
        $this->verify = $verify;
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