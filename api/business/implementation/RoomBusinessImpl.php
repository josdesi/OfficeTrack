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
  
    public function findRoomByRoomkey($roomKey){
        $database = new Database();
        $db = $database->getConnection();        
        $room = new Room($db);

        return $room->findRoomByRoomKey($roomKey);
    }

    public function findRoomByRoomName($roomName){
        $database = new Database();
        $db = $database->getConnection();        
        $room = new Room($db);

        return $room->findRoomByRoomName($roomName);
    }
    
    public function updateRoom( $roomDTO ){
        
    }
}
?>