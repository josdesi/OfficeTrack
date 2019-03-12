<?php

interface UserBusiness {

   public function create( $userDTO );
   public function update( $userDTO );
   public function delete( $userDTO );
   public function findByEmail( $email );
   public function findByUsername( $username );
   public function verifyPassword( $passwordFromDB, $passwordFromClient);
   
}
?>