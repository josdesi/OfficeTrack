<?php

class UserBusinessImpl implements UserBusiness{
         
    public function createUser( $userDTO ){
        
        $database = new Database();
        $db = $database->getConnection();        
        $user = new User($db);

        $user->username = $userDTO->getUsername();
        $user->password = $userDTO->getPassword();
        $user->email = $userDTO->getEmail();


        if ($user->create())
            return $userDTO;
        else 
            throw new Exception("El usuario no pudo crearse");

        return null;
    }
}
?>