<?php
class User
{

    // Variables para la conexión con la base de datos
    private $conn;
    private $table_name = "users";

    // Propiedades del objeto
    public $userId;
    public $username;
    public $password;
    public $name;
    public $fatherSurname;
    public $motherSurname;
    public $phone;
    public $email;
    public $verify;
    public $emailToken;
    public $created;
    public $modified;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET
                    username=:username, password=:password, name=:name, fatherSurname=:fatherSurname, motherSurname=:motherSurname, phone=:phone, email=:email, verify=:verify, emailToken=:emailToken, created=now(), modified=now()";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->sanitizeProperties();

        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":fatherSurname", $this->fatherSurname);
        $stmt->bindParam(":motherSurname", $this->motherSurname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":verify", $this->verify);
        $stmt->bindParam(":emailToken", $this->emailToken);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible crear el registro en la tabla users");
        }

    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET
                    username=:username, password=:password, name=:name, fatherSurname=:fatherSurname, motherSurname=:motherSurname, phone=:phone, email=:email, verify=:verify, emailToken=:emailToken, created=now(), modified=now()
                    WHERE userId=:userId";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->sanitizeProperties();

        // bind values
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":fatherSurname", $this->fatherSurname);
        $stmt->bindParam(":motherSurname", $this->motherSurname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":verify", $this->verify);
        $stmt->bindParam(":emailToken", $this->emailToken);

        $successfulQuery = $stmt->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible actualizar el registro en la tabla users");
        }
    }

    public function delete()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE userId=:userId";

        $statement = $this->conn->prepare($query);

        $this->sanitizeProperties();

        $statement->bindParam(":userId", $this->userId);

        $successfulQuery = $statement->execute();

        if (!$successfulQuery) {
            throw new Exception("No fue posible eleminar el registro en la tabla users");
        }

    }

   public function findByEmail($email)
    {
        $query = "SELECT userId, username, password, name, fatherSurname, motherSurname, phone, email, verify, emailToken, created, modified FROM " . $this->table_name . " WHERE email=:email";
        $stmt = $this->conn->prepare($query);

        $email = htmlspecialchars(strip_tags($email));

        $stmt->bindParam(":email", $email);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por email");
        }

        if ($result === false) {
            return null;
        }

        $user = new UserDTO;
        $user->setUserId($result["userId"]);
        $user->setUsername($result["username"]);
        $user->setPassword($result["password"]);
        $user->setName($result["name"]);
        $user->setFatherSurname($result["fatherSurname"]);
        $user->setMotherSurname($result["motherSurname"]);
        $user->setPhone($result["phone"]);
        $user->setEmail($result["email"]);
        $user->setVerify($result["verify"]);
        $user->setEmailToken($result["emailToken"]);
        $user->setCreated($result["created"]);
        $user->setModified($result["modified"]);
        
        return $user;
    }

    public function findByUsername($username)
    {
        $query = "SELECT userId, username, password, name, fatherSurname, motherSurname, phone, email, verify, emailToken, created, modified FROM " . $this->table_name . " WHERE username=:username";
        $stmt = $this->conn->prepare($query);

        $username = htmlspecialchars(strip_tags($username));

        $stmt->bindParam(":username", $username);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por username");
        }

        if ($result === false) {
            return null;
        }

        $user = new UserDTO;
        $user->setUserId($result["userId"]);
        $user->setUsername($result["username"]);
        $user->setPassword($result["password"]);
        $user->setName($result["name"]);
        $user->setFatherSurname($result["fatherSurname"]);
        $user->setMotherSurname($result["motherSurname"]);
        $user->setPhone($result["phone"]);
        $user->setEmail($result["email"]);
        $user->setVerify($result["verify"]);
        $user->setEmailToken($result["emailToken"]);
        $user->setCreated($result["created"]);
        $user->setModified($result["modified"]);
        
        return $user;
    }    

    public function findByUserId($userId)
    {
        $query = "SELECT userId, username, password, name, fatherSurname, motherSurname, phone, email, verify, emailToken, created, modified FROM " . $this->table_name . " WHERE userId=:userId";
        $stmt = $this->conn->prepare($query);

        $userId = htmlspecialchars(strip_tags($userId));

        $stmt->bindParam(":userId", $userId);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por userId");
        }

        if ($result === false) {
            return null;
        }

        $user = new UserDTO;
        $user->setUserId($result["userId"]);
        $user->setUsername($result["username"]);
        $user->setPassword($result["password"]);
        $user->setName($result["name"]);
        $user->setFatherSurname($result["fatherSurname"]);
        $user->setMotherSurname($result["motherSurname"]);
        $user->setPhone($result["phone"]);
        $user->setEmail($result["email"]);
        $user->setVerify($result["verify"]);
        $user->setEmailToken($result["emailToken"]);
        $user->setCreated($result["created"]);
        $user->setModified($result["modified"]);
        
        return $user;
    }

    public function findByEmailToken($emailToken)
    {
        $query = "SELECT userId, username, password, name, fatherSurname, motherSurname, phone, email, verify, emailToken, created, modified FROM " . $this->table_name . " WHERE emailToken=:emailToken";
        $stmt = $this->conn->prepare($query);

        $emailToken = htmlspecialchars(strip_tags($emailToken));

        $stmt->bindParam(":emailToken", $emailToken);

        $successfulQuery = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$successfulQuery) {
            throw new Exception("Error al buscar por email");
        }

        if ($result === false) {
            return null;
        }

        $user = new UserDTO;
        $user->setUserId($result["userId"]);
        $user->setUsername($result["username"]);
        $user->setPassword($result["password"]);
        $user->setName($result["name"]);
        $user->setFatherSurname($result["fatherSurname"]);
        $user->setMotherSurname($result["motherSurname"]);
        $user->setPhone($result["phone"]);
        $user->setEmail($result["email"]);
        $user->setVerify($result["verify"]);
        $user->setEmailToken($result["emailToken"]);
        $user->setCreated($result["created"]);
        $user->setModified($result["modified"]);
        
        return $user;
    }

    private function sanitizeProperties()
    {
        $this->userId = htmlspecialchars(strip_tags($this->userId));
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
