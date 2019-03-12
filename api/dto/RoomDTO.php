<?php
class RoomDTO {
    private $roomId = "";
    private $roomName = "";
    private $roomKey = "";
    private $description = "";
    private $roomTypeId = ""; 
    private $created = ""; 
    private $modified = ""; 

	public function getRoomId(){
		return $this->roomId;
	}
	public function setRoomId($roomId){
		$this->roomId = $roomId;
	}


	public function getRoomName(){
		return $this->roomName;
	}
	public function setRoomName($roomName){
		$this->roomName = $roomName;
	}


	public function getRoomkey(){
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


	public function getRoomTypeId(){
		return $this->roomTypeId;
	}
	public function setRoomTypeId($roomTypeId){
		$this->roomTypeId = $roomTypeId;
	}
	

	public function getCreated(){
		return $this->created;
	}
	public function setCreated($created){
		$this->created = $created;
	}


	public function getModified(){
		return $this->modified;
	}
	public function setModified($modified){
		$this->modified = $modified;
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