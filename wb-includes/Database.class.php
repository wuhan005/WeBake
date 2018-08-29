<?php

require_once( ABSPATH . '/wb-config.php');

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

    public function get_all_module(){
        $result = mysqli_query($this->conn, 'SELECT * FROM wb_module');
        return mysqli_fetch_all($result, MYSQLI_BOTH);
    }

    public function get_all_api(){
        $result = mysqli_query($this->conn, 'SELECT * FROM wb_api');
        return mysqli_fetch_all($result, MYSQLI_BOTH);
    }

    public function get_single_api($version, $meta){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_api WHERE `api_Version` = '$version' AND `api_Meta` = '$meta'");
        return mysqli_fetch_all($result, MYSQLI_BOTH); 
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

    public function get_module_by_id($id){
        $result = mysqli_query($this->conn, "SELECT `module_Name` FROM wb_module WHERE `module_ID` = '$id'");
        
        //If user has deleted the module.
        if($result){
            // The [2] is the options_name.
            return mysqli_fetch_row($result);
        }else{
            return '[不存在]';
        }
    }

    public function get_all_options(){
        $result = mysqli_query($this->conn, 'SELECT * FROM wb_options');
        return mysqli_fetch_all($result);
    }

    public function get_account_by_name($accountName){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_account WHERE `account_Name` = '$accountName'");
        $result =  mysqli_fetch_array($result,MYSQLI_ASSOC);
        if(count($result) != 0){
            return $result;
        }else{
            return false;
        }
    }

    public function add_module($name, $data){
        mysqli_query($this->conn, "INSERT INTO `wb_module` (`module_ID`, `module_Name`, `module_Key`) VALUES (NULL, '$name', '$data');");
    }

    public function add_api($data){
        $data = implode(', ', $this->array_quote($data));
        mysqli_query($this->conn, 'INSERT INTO `wb_api` (`api_ID`, `api_Name`, `api_Meta`, `api_Type`, `api_Method`, `api_Version`, `api_Module`) VALUES (NULL, ' . $data . ');' );
    }

    private function array_quote($array){
        foreach($array as $key => $value){
            if(!is_numeric($value)){    //The number won't be added '.
                $array[$key] = '\'' . $value . '\'';
            }
        }
        return $array;
    }
}