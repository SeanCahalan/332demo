<?php
class DBController {
    private $host = "localhost";
    private $username = "root";
    private $dbname = "conference";
    private $conn;
    
    function __construct() {
	$this->conn = $this->connectDB();
    }

    function connectDB() {
	$conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username);
        return $conn;
    }

    function exec($query){
	$this->conn->exec($query);
    }
    
    function runQuery($query) {
	$statement = $this->conn->prepare($query);
	$statement->execute();
	return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>