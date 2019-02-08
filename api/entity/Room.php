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

        if($this->roomNameExist()){
            throw new ManagerException("The room name is already in use","RSP_02");
            return null;

        } elseif ($this->roomKeyExist()) {          
            throw new ManagerException("Another room alredy has the same key","RSP_03");
            return null;
        }

        var_dump($stmt->execute());
    }

    public function update(){

    }

    public function read(){

    }

    public function readOne($id){

    }

    private function sanitizeProperties(){
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->roomName = htmlspecialchars(strip_tags($this->roomName));
        $this->roomKey = htmlspecialchars(strip_tags($this->roomKey));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->typeRoomId = htmlspecialchars(strip_tags($this->typeRoomId));
    }

    private function roomKeyExist()
    {
        $query = "SELECT roomKey FROM rooms WHERE roomKey=:roomKey";
        $stmt = $this->conn->prepare($query);
        $this->roomKey = htmlspecialchars(strip_tags($this->roomKey));
        $stmt->bindParam(":roomKey",$this->roomKey);
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_ASSOC)===false){
            return false;
        }else{
            return true;
        }            
    }

    private function roomNameExist()
    {
        $query = "SELECT roomName FROM rooms WHERE roomName=:roomName";
        $stmt = $this->conn->prepare($query);
        $this->roomName = htmlspecialchars(strip_tags($this->roomName));
        $stmt->bindParam(":roomName",$this->roomName);
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_ASSOC) === false){
            return false;
        }else{
            return true;
        }         
    }
}

?>