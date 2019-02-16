<?php

class UserBusinessImpl implements UserBusiness{
         
    public function createUser( $userDTO ){
        
        $database = new Database();
        $db = $database->getConnection();        
        $user = new User($db);

        $user->username = $userDTO->getUsername();
        $user->password = $userDTO->getPassword();
        $user->email = $userDTO->getEmail();

        try {
            $user->create();
            return $userDTO;
        } catch (Exception $e) {
            throw $e;
            return null;
        }        
    }

    public function updateUser( $userDTO ){
        
        $database = new Database();
        $db = $database->getConnection();     
        $user = new User($db);

        $user->id = $userDTO->getId();
        $user->username = $userDTO->getUsername();
        $user->password = $userDTO->getPassword();
        $user->name = $userDTO->getName();
        $user->fatherSurname = $userDTO->getFatherSurname();
        $user->motherSurname = $userDTO->getMotherSurname();
        $user->phone = $userDTO->getPhone();
        $user->email = $userDTO->getEmail();
        
        
        try {
            $user->update();
            return $userDTO;
        } catch (Exception $e) {
            throw $e;
            return null;
        }  
    }

    public function deleteUser( $userDTO ){

        $database = new Database();
        $db = $database->getConnection();     
        $user = new User($db);

        $user->username = $userDTO->getUsername();
        
        try {
            $user->delete();
            return true;
        } catch (Exception $e) {
            throw $e;
            return null;
        }  
    }

    public function verifyPassword( $username, $password){
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        return $user->verifyPassword($username, $password);
    }

    public function findUserByEmail($email){
        $database = new Database();
        $db = $database->getConnection();        
        $user = new User($db);
        return $user->findUserByEmail($email);
    }

    public function findUserByUsername($username){
        $database = new Database();
        $db = $database->getConnection();        
        $user = new User($db);
        return $user->findUserByUsername($username);
    }
}
?>