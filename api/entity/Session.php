<?php

class Session
{
    private $conn;
    private $table_name = "sessions";

    public $user_id;
    public $token;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_id=:user_id, token=:token, created=now(), modified=now()";
        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":token", $this->token);

        return $stmt->execute();
    }

    private function sanitizeProperties(){
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->token = htmlspecialchars(strip_tags($this->token));
    }

}

?>