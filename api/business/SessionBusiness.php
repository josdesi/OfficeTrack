<?php

interface SessionBusiness {

   public function createSession( $sessionDTO );
   public function readSession( $sessionDTO );
   public function updateSession( $sessionDTO );
   public function deleteSession( $sessionDTO );
   
}
?>