<?php
class connection extends PDO{
    private $host = 'localhost'; 
    private $db_name = 'test'; 
    private $username = 'root'; 
    private $password = ''; 
    public $conn;
    public function __construct(){}
    public function connect(){
     $this->conn=null;
     try{
     $dsn="mysql:host=".$this->host.";dbname=".$this->db_name;
     $this->conn=new PDO($dsn,$this->username,$this->password);
     }
     catch(PDOException $e){
       echo "connection failed: ".$e->getMessage();
     }
    }
}

