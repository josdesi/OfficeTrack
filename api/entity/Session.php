<?php

class Session
{
    private $conn;
    private $table_name = "sessions";

    public $userId;
    public $token;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                userId=:userId, token=:token, created=now(), modified=now()";
        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":token", $this->token);

        return $stmt->execute();
    }

    private function sanitizeProperties(){
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->token = htmlspecialchars(strip_tags($this->token));
    }

    public function delete(){
        $query = "DELETE FROM" . $this->table_name . "WHERE userID=:userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
    }

}

?>