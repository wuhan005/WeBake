<?php

require_once('../wb-config.php');

class Database {

    private $conn;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
        if(!$conn){
            // TODO
        }
    }

    public function get_db_status(){
        var_dump($this->conn);
    }
}