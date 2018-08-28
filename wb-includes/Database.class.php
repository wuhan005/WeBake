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
        if(!$this->conn){
            //TODO
        }else{
            mysqli_select_db($this->conn, DB_NAME);
            $this->isConnected = true;
        }
    }

    public function get_db_status(){
        return $this->isConnected;
    }

    public function get_single_option($optionName){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_options WHERE `options_Name` = '$optionName'");
        
        //If the option is not existed, it will return false;
        if($result){
            // The [2] is the options_name.
            return mysqli_fetch_row($result)[2];
        }else{
            return '';
        }
        
    }

    public function get_all_options(){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_options");
        return mysqli_fetch_all($result);
    }
}