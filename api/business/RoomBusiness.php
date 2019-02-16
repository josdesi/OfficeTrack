<?php

interface RoomBusiness {

   public function createRoom( $roomDTO );
   public function updateRoom( $roomDTO );
   public function deleteRoom( $roomDTO );
   public function findRoomByRoomName( $roomName );
   public function findRoomByRoomKey( $roomKey );
   
}
?>