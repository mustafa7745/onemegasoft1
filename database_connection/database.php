<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin:*");
class DB{
public   $servername = "localhost";
public $username = "root";
public $password = '';
public $dbname = "onemegasoft";
public $conn;

     function __construct() {
        //  echo "dttd";
       $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
       if ($this->conn->connect_error) {
          die("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8');
    }
}



