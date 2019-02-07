<?php
class Database{
 
    // Credenciales para la base de datos
    private $host = "localhost";
    private $db_name = "office_track";
    private $username = "root";
    private $password = "";
    public $conn;
 
    // Obtener la conexión con la base de datos
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        } finally {
            
        }
 
        return $this->conn;
    }
}
?>