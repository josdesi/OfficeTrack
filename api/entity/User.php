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

   
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        if (
            empty($this->username) ||
            empty($this->email) ||
            empty($this->password)
        ) {
            throw new Exception("Body Request Error");
            return null;
        } 

        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, email=:email, created=now(), modified=now()";


        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->sanitizeProperties();

        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);;
        $stmt->bindParam(":email", $this->email);

        if($this->usernameExist()){

            throw new Exception("The username is already in use");
            return null;

        } elseif ($this->emailExist()) {
            
            throw new Exception("Another account with this email has already been registered");
            return null;
        }

        return $stmt->execute();

    }

    public function update()
    {
        if (
            empty($this->id) ||
            empty($this->username) ||
            empty($this->email)
        ) {
            throw new Exception("Body Request Error");
            return null;
        } 

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                username=:username, password=:password, name=:name, fatherSurname=:fatherSurname, motherSurname=:motherSurname , phone=:phone, email=:email, modified=now()
                    WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->sanitizeProperties();

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":fatherSurname", $this->fatherSurname);
        $stmt->bindParam(":motherSurname", $this->motherSurname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);

        if($this->usernameExist()){
            throw new Exception("The username is already in use");
            return null;

        } elseif ($this->emailExist()) {            
            throw new Exception("Another account with this email has already been registered");
            return null;
        }
        echo 'dsfa';

        return $stmt->execute();

    }



    // Private methods

    private function sanitizeProperties(){
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->fatherSurname = htmlspecialchars(strip_tags($this->fatherSurname));
        $this->motherSurname = htmlspecialchars(strip_tags($this->motherSurname));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
    }

    private function emailExist()
    {
        $query = "SELECT email FROM users WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email",$this->email);
        $stmt->execute();        
        if($stmt->fetch(PDO::FETCH_ASSOC)===false){
            return false;
        }else{
            return true;
        }            
    }

    private function usernameExist()
    {
        $query = "SELECT username FROM users WHERE username=:username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username",$this->username);
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_ASSOC) === false){
            return false;
        }else{
            return true;
        }         
    }
}
