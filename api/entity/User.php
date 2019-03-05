<?php
class User
{

    // Variables para la conexión con la base de datos
    private $conn;
    private $table_name = "users";

    // Propiedades del objeto
    public $id;
    public $username;
    public $password;
    public $name;
    public $fatherSurname;
    public $motherSurname;
    public $phone;
    public $email;
    public $created;
    public $modified;
    public $emailToken;
    public $verify;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, email=:email, created=now(), modified=now(), emailToken=:emailToken, verify=:verify";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->sanitizeProperties();

        $passwordHash = $this->generatePasswordHash($this->password);

        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":emailToken", $this->emailToken);
        $stmt->bindParam(":verify", $this->verify);

        return $stmt->execute();

    }

    public function update()
    {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                username=:username, password=:password, name=:name, fatherSurname=:fatherSurname, motherSurname=:motherSurname , phone=:phone, email=:email, modified=now(), emailToken=:emailToken, verify=:verify
                    WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->sanitizeProperties();

        $passwordHash = $this->generatePasswordHash($this->password);

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":fatherSurname", $this->fatherSurname);
        $stmt->bindParam(":motherSurname", $this->motherSurname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":emailToken", $this->emailToken);
        $stmt->bindParam(":verify", $this->verify);

        return $stmt->execute();
    }

    public function delete()
    {

        $query = "DELETE FROM
                 " . $this->table_name . "
                 WHERE username=:username";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            return true;
        } else {
            return null;
        }
    }

    public function verifyPassword($username, $password)
    {
        $userPasswordHash = $this->getUserPasswordHash($username);
        return password_verify($password, $userPasswordHash);
    }

    public function findUserByEmail($email)
    {
        $query = "SELECT id, username, email  FROM users WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            throw new Exception("Error al buscar por email");
            
        }

        if ($result === false) {
            return null;
        } else {
            $user = new UserDTO;
            $user->setId($result["id"]);
            $user->setEmail($result["email"]);
            $user->setUsername($result["username"]);
            return $user;
        }
    }

    public function confirmEmailToken($emailToken)
    {
        $query = "UPDATE " . $this->table_name . " SET verify=1 WHERE emailToken=:emailToken;";

        $stmt = $this->conn->prepare($query);
        $emailToken = htmlspecialchars(strip_tags($emailToken));
        $stmt->bindParam(":emailToken", $emailToken);
        $stmt->execute();
        $affected = $stmt->rowCount();
        if ($affected !== 1) {
            return null;
        } else {
            return true;
        }
    }

    public function findUserByUsername($username)
    {
        $query = "SELECT id, username, email FROM users WHERE username=:username";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            throw new Exception("Error al buscar por email");            
        }

        if ($result === false) {
            return null;
        } else {
            $user = new UserDTO;
            $user->setId($result["id"]);
            $user->setEmail($result["email"]);
            $user->setUsername($result["username"]);
            return $user;
        }
    }

    // Private methods

    private function getUserPasswordHash($username)
    {
        $query = "SELECT password FROM users WHERE username=:username";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            return null;
        } else {
            return $result["password"];
        }
    }

    private function generatePasswordHash($password)
    {
        $password = htmlspecialchars(strip_tags($password));
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function sanitizeProperties()
    {
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->fatherSurname = htmlspecialchars(strip_tags($this->fatherSurname));
        $this->motherSurname = htmlspecialchars(strip_tags($this->motherSurname));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->emailToken = htmlspecialchars(strip_tags($this->emailToken));
        $this->verify = htmlspecialchars(strip_tags($this->verify));
    }

}
