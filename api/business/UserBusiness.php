<?php

interface UserBusiness {

   public function createUser( $userDTO );
   public function updateUser( $userDTO );
   public function findUserByEmail( $email );
   public function findUserByUsername( $username );
   
}
?>