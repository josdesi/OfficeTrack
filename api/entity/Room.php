<?php
class Room
{
    private $conn;
    private $table_name = "rooms";  

    public $roomId;
    public $roomName;
    public $roomKey;
    public $description;
    public $roomTypeId;


    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        
        $query = "INSERT INTO
        ". $this->table_name . "
        SET roomName=:roomName, roomkey=:roomKey, description=:description, roomTypeId=:roomTypeId, created=now(), modified=now()";

        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":roomName", $this->roomName);
        $stmt->bindParam(":roomKey", $this->roomKey);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":roomTypeId", $this->roomTypeId);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible crear el registro en la tabla rooms");
        }
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET roomName=:roomName, roomkey=:roomKey, description=:description, roomTypeId=:roomTypeId, created=now(), modified=now() WHERE roomId=:roomId";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":roomId", $this->roomId);
        $stmt->bindParam(":roomName", $this->roomName);
        $stmt->bindParam(":roomKey", $this->roomKey);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":roomTypeId", $this->roomTypeId);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible actualizar el registro en la tabla rooms");
        }
    }

    public function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE roomId=:roomId";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $statement->bindParam(":roomId", $this->roomId);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible eleminar el registro en la tabla rooms");
        }

    }

    
    public function findByRoomKey($roomKey)
    {
        $query = "SELECT roomId, roomName, roomKey, description, roomTypeId, created, modified FROM " . $this->table_name . " WHERE roomKey=:roomKey";

        $stmt = $this->conn->prepare($query);

        $roomKey = htmlspecialchars(strip_tags($roomKey));

        $stmt->bindParam(":roomKey", $roomKey);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por roomKey");
        }

        if ($result === false) {
            return null;
        }

        $room = new RoomDTO;
        $room->setRoomId($result["roomId"]);
        $room->setRoomName($result["roomName"]);
        $room->setRoomKey($result["roomKey"]);
        $room->setDescription($result["description"]);
        $room->setRoomTypeId($result["roomId"]);
        $room->setCreated($result["created"]);
        $room->setModified($result["modified"]);
        
        return $room;    
    }

    public function findByRoomName($roomName)
    {
        $query = "SELECT roomId, roomName, roomKey, description, roomTypeId, created, modified FROM " . $this->table_name . " WHERE roomName=:roomName";

        $stmt = $this->conn->prepare($query);

        $roomName = htmlspecialchars(strip_tags($roomName));

        $stmt->bindParam(":roomName", $roomName);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por roomName");
        }

        if ($result === false) {
            return null;
        }

        $room = new RoomDTO;
        $room->setRoomId($result["roomId"]);
        $room->setRoomName($result["roomName"]);
        $room->setRoomKey($result["roomKey"]);
        $room->setDescription($result["description"]);
        $room->setRoomTypeId($result["roomId"]);
        $room->setCreated($result["created"]);
        $room->setModified($result["modified"]);
        
        return $room;  
    }

    private function sanitizeProperties(){
        $this->roomId = htmlspecialchars(strip_tags($this->roomId));
        $this->roomName = htmlspecialchars(strip_tags($this->roomName));
        $this->roomKey = htmlspecialchars(strip_tags($this->roomKey));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->roomTypeId = htmlspecialchars(strip_tags($this->roomTypeId));
    }
}

?>