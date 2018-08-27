<?php

require_once('../wb-config.php');

class Database {

    private $conn;
    private $isConnected = false;

    public function __construct(){
        $this->connect();

    }

    private function connect(){
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
        var_dump($conn);
        if(!$conn){
            // TODO
        }else{
            $this->isConnected = true;
        }
    }

    public function get_db_status(){
        return $this->isConnected;
    }
}