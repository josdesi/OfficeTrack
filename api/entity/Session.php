<?php

class Session
{
    private $conn;
    private $table_name = "sessions";

    public $userId;
    public $token;
    public $sessionType;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                userId=:userId, token=:token, sessionType=:sessionType, created=now(), modified=now()";
        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":sessionType", $this->sessionType);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("Error al eliminar");
        }
    }

    
    public function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE userId=:userId AND sessionType=:sessionType";
        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":sessionType", $this->sessionType);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("Error al eliminar");
        }
    }
    
    private function sanitizeProperties(){
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->token = htmlspecialchars(strip_tags($this->token));
        $this->sessionType = htmlspecialchars(strip_tags($this->sessionType));
    }
}

?>