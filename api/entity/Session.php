<?php

class Session
{
    private $conn;
    private $table_name = "sessions";

    public $userId;
    public $sessionToken;
    public $sessionType;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){

        $query = "INSERT INTO ". $this->table_name . " SET
                    userId=:userId, sessionToken=:sessionToken, sessionType=:sessionType, created=now(), modified=now()";

        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":sessionToken", $this->sessionToken);
        $stmt->bindParam(":sessionType", $this->sessionType);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible crear el registro en la tabla sessions");
        }

    }

    
    public function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE userId=:userId AND sessionType=:sessionType";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $statement->bindParam(":userId", $this->userId);
        $statement->bindParam(":sessionType", $this->sessionType);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible eleminar el registro en la tabla sessions");
        }
    }
    
    private function sanitizeProperties(){
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->sessionToken = htmlspecialchars(strip_tags($this->sessionToken));
        $this->sessionType = htmlspecialchars(strip_tags($this->sessionType));
    }
}

?>