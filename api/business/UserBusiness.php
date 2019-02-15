<?php

interface UserBusiness {

   public function createUser( $userDTO );
   public function updateUser( $userDTO );
   public function deleteUser( $userDTO );
   public function findUserByEmail( $email );
   public function findUserByUsername( $username );
   public function verifyPassword( $username, $password);
   
}
?>