<?php
class Newsletter
{
    private $conn;
    private $table_name = "newsletter";

    public $newsletterId = "";
    public $email = "";

    public function __construct($db){
        $this->conn = $db;
    }

    public function createNewsletter(){
        $query = "INSERT INTO " . $this->table_name . " SET email=:email, created=now(), modified=now()";

        $this->sanitizeProperties();

        $statement = $this->conn->prepare($query);

        $statement->bindParam(":email", $this->email);

        $successfulQuery = $statement->execute();

        if(!$successfulQuery){
            throw new Exception("Error al persistir newsletter");          
        }
    }

    private function sanitizeProperties(){
        $this->newsletterId = htmlspecialchars(strip_tags($this->newsletterId));
        $this->email = htmlspecialchars(strip_tags($this->email));
    }

    public function findByEmail($email)
    {
        $query = "SELECT newsletterId, email  FROM " . $this->table_name ." WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $stmt->bindParam(":email", $email);

        $successfulQuery = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por email");
        }

        if($result === false){
            return null;
        }

        $newletter = new NewsletterDTO;
        $newletter->setNewsletterId($result["newslatterId"]);
        $newletter->setEmail($result["email"]);
        return $newletter;
    }
}
