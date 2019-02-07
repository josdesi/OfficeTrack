<?php
class User {
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
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
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, email=:email, created=now(), modified=now()";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->email=htmlspecialchars(strip_tags($this->email));
     
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
     
        // execute query
    try {
        if($stmt->execute()){
            return true;
        }
    } catch (Exception $th) {
        //throw $th;
        echo 'Excepción capturada: ',  $th->getMessage(), "\n";
        return false;
    }

        
     
        
         
    }
    function update(){
 
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name=:name, fatherSurname=:fatherSurname, motherSurname=:motherSurname , phone=:phone, modified=now()
                    WHERE id=:id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->fatherSurname=htmlspecialchars(strip_tags($this->fatherSurname));
        $this->motherSurname=htmlspecialchars(strip_tags($this->motherSurname));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
     
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":fatherSurname", $this->fatherSurname);
        $stmt->bindParam(":motherSurname", $this->motherSurname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":id", $this->id);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
}
?>