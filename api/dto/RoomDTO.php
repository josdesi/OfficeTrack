<?php
class RoomDTO {
    private $id;
    private $roomName;
    private $roomKey;
    private $description;
    private $typeRoomld; 

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getRoomName(){
		return $this->roomName;
	}

	public function setRoomName($roomName){
		$this->roomName = $roomName;
	}

	public function getRoomKey(){
		return $this->roomKey;
	}

	public function setRoomkey($roomKey){
		$this->roomKey = $roomKey;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function getTypeRoomId(){
		return $this->typeRoomId;
	}

	public function setTypeRoomId($typeRoomld){
		$this->typeRoomId = $typeRoomld;
	}

    public function jsonSerialize(){
        return [
            "id"=>  $this->id,
            "roomName"=> $this->roomName,
            "roomKey"=> $this->roomKey,
            "description"=> $this->description,
            "typeRoomld"=> $this->typeRoomId
		];
    }
 
}
?>