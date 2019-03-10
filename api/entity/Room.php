<?php
class Room
{
    private $conn;
    private $table_name = "rooms";  

    public $id;
    public $roomName;
    public $roomKey;
    public $description;
    public $typeRoomld;


    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        
        $query = "INSERT INTO
        ". $this->table_name . "
        SET roomName=:roomName, roomkey=:roomKey, description=:description, typeRoomId=:typeRoomId, created=now(), modified=now()";

        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":roomName", $this->roomName);
        $stmt->bindParam(":roomKey", $this->roomKey);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":typeRoomId", $this->typeRoomId);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("Error al eliminar");
        }
    }

    public function update(){

    }

    public function delete(){

        $query = "DELETE FROM
                 " . $this->table_name . "
                 WHERE roomKey=:roomKey";
        $stmt = $this->conn->prepare($query);
        $roomKey = htmlspecialchars(strip_tags($this->roomKey));
        $stmt->bindParam(":roomKey",$roomKey);
        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("Error al eliminar");
        }
        
        if($stmt->rowCount()===1){
            return true;
        }else{
            return null;
        }  

    }

    
    public function findRoomByRoomKey($roomKey)
    {
        $query = "SELECT roomKey FROM rooms WHERE roomKey=:roomKey";
        $stmt = $this->conn->prepare($query);
        $roomKey = htmlspecialchars(strip_tags($roomKey));
        $stmt->bindParam(":roomKey",$roomKey);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            return null;
        }else{
            return $result;
        }            
    }

    public function findRoomByRoomName($roomName)
    {
        $query = "SELECT roomName FROM rooms WHERE roomName=:roomName";
        $stmt = $this->conn->prepare($query);
        $roomName = htmlspecialchars(strip_tags($roomName));
        $stmt->bindParam(":roomName",$roomName);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            return null;
        }else{
            return $result;
        }          
    }

    private function sanitizeProperties(){
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->roomName = htmlspecialchars(strip_tags($this->roomName));
        $this->roomKey = htmlspecialchars(strip_tags($this->roomKey));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->typeRoomId = htmlspecialchars(strip_tags($this->typeRoomId));
    }
}

?>