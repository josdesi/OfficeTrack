<?php

interface RoomBusiness {

   public function create( $roomDTO );
   public function update( $roomDTO );
   public function delete( $roomDTO );
   public function findByRoomName( $roomName );
   public function findByRoomKey( $roomKey );
   
}
?>