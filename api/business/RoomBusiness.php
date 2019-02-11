<?php

interface RoomBusiness {

   public function createRoom( $userDTO );
   public function updateRoom( $userDTO );
   public function findRoomByRoomName( $roomName );
   public function findRoomByRoomKey( $roomKey );
   
}
?>