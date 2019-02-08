<?php

class RoomBusinessImpl implements RoomBusiness{
         
    public function createRoom( $roomDTO ){
        
        $database = new Database();
        $db = $database->getConnection();        
        $room = new Room($db);

        $room->roomName = $roomDTO->getRoomName();
        $room->roomKey = $roomDTO->getRoomKey();
        $room->typeRoomId = $roomDTO->getTypeRoomId();
        
        try {
            $room->create();
            return $roomDTO;
        } catch (Exception $e) {
            throw $e;
            return null;
        }        
    }
    
    public function updateRoom( $roomDTO ){
        
    }
}
?>