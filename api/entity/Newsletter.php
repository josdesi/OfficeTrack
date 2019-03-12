<?php
class Newsletter
{
    private $conn;
    private $table_name = "newsletter";

    public $newsletterId = "";
    public $email = "";
    public $newsletterToken = "";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {

        $query = "INSERT INTO " . $this->table_name . " SET email=:email, status=:status, newsletterToken=:newsletterToken, created=now(), modified=now()";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":status", $this->status);
        $statement->bindParam(":newsletterToken", $this->newsletterToken);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("Error al persistir newsletter");
        }
    }

    public function update()
    {

        $query = "UPDATE " . $this->table_name . " SET email=:email, status=:status, newsletterToken=:newsletterToken, created=now(), modified=now() WHERE newsletterId=:newsletterId";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $statement->bindParam(":newsletterId", $this->newsletterId);
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":status", $this->status);
        $statement->bindParam(":newsletterToken", $this->newsletterToken);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible actualizar el registro en la tabla newsletters");
        }
    }

    public function delete()
    {
        
        $query = "DELETE FROM " . $this->table_name . " WHERE newsletterId=:newsletterId";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $statement->bindParam(":newsletterId", $this->newsletterId);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible eleminar el registro en la tabla newsletters");
        }
    }

    public function findByEmail($email)
    {
        $query = "SELECT newsletterId, email, status, newsletterToken FROM " . $this->table_name . " WHERE email=:email";
        $stmt = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $stmt->bindParam(":email", $email);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por email");
        }

        if ($result === false) {
            return null;
        }

        $newletter = new NewsletterDTO;
        $newletter->setNewsletterId($result["newslatterId"]);
        $newletter->setEmail($result["email"]);
        $newletter->setStatus($result["status"]);
        $newletter->setNewsletterTokens($result["newsletterToken"]);
        
        return $newletter;
    }

    
    public function findByNewsletterToken($newsletterToken)
    {
        $query = "SELECT newsletterId, email, status, newsletterToken  FROM " . $this->table_name . " WHERE newsletterToken=:newsletterToken";

        $stmt = $this->conn->prepare($query);

        $newsletterToken = htmlspecialchars(strip_tags($newsletterToken));

        $stmt->bindParam(":newsletterToken", $newsletterToken);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por email");
        }

        if ($result === false) {
            return null;
        }

        $newletter = new NewsletterDTO;
        $newletter->setNewsletterId($result["newsletterId"]);
        $newletter->setEmail($result["email"]);
        $newletter->setStatus($result["status"]);
        $newletter->setNewsletterToken($result["newsletterToken"]);

        return $newletter;
    }

    private function sanitizeProperties()
    {
        $this->newsletterId = htmlspecialchars(strip_tags($this->newsletterId));
        $this->email = htmlspecialchars(strip_tags($this->email));
    }
}
