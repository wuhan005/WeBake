<?php
defined('ABSPATH') OR exit('No direct script access allowed');

require_once( ABSPATH . '/wb-config.php');

class Database {

    private $conn;
    private $isConnected = false;

    public function __construct(){
        $this->connect();

    }

    private function connect(){
        $this->conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
        if(!$this->conn){
            header('Location: /wb-error.php?t=database_error');     //Return an error.
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

    //Get single module's data.
    public function get_module_data($moduleID){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_data WHERE data_Module = $moduleID");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function get_all_api(){
        $result = mysqli_query($this->conn, 'SELECT * FROM wb_api');
        return mysqli_fetch_all($result, MYSQLI_BOTH);
    }

    public function get_single_api($url){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_api WHERE `api_URL` = '$url'");
        return mysqli_fetch_all($result, MYSQLI_BOTH)[0]; 
    }

    public function get_single_api_by_id($id){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_api WHERE `api_ID` = $id");
        return mysqli_fetch_all($result, MYSQLI_BOTH)[0];       
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

    //Get single module data.
    public function get_module_by_id($id){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_module WHERE `module_ID` = '$id'");
        
        //If user has deleted the module.
        if($result){
            // The [2] is the options_name.
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }else{
            return '[不存在]';
        }
    }

    public function get_module_by_name($moudleName){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_ WHERE module_Name = $moduleName");
        return mysqli_fetch_all($result, MYSQLI_ASSOC); 
    }

    public function get_key_friendly_name($moduleID, $keyName){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_module WHERE `module_ID` = '$moduleID'");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $key = $result[0]['module_Key'];
        $key = json_decode($key);
        foreach($key as $index => $value){
            if($value[0] == $keyName){
                return $value[1];
            }
        }
        return null;
    }

    public function get_data_by_id($id){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_data WHERE `data_ID` = $id");
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0]; 
    }

    public function get_all_options(){
        $result = mysqli_query($this->conn, 'SELECT * FROM wb_options');
        return mysqli_fetch_all($result);
    }

    public function get_account_by_name($accountName){
        $result = mysqli_query($this->conn, "SELECT * FROM wb_account WHERE `account_Name` = '$accountName'");
        $result =  mysqli_fetch_array($result, MYSQLI_ASSOC);
        if(count($result) != 0){
            return $result;
        }else{
            return false;
        }
    }

    public function add_module($name, $data, $friendlyName){
        mysqli_query($this->conn, "INSERT INTO `wb_module` (`module_ID`, `module_Name`, `module_FriendlyName`, `module_Key`) VALUES (NULL, '$name', '$friendlyName', '$data');");
    }

    public function add_api($data){
        //Pay attention the $data's order.
        $data = implode(', ', $this->array_quote($data));
        mysqli_query($this->conn, 'INSERT INTO `wb_api` (`api_ID`, `api_Name`, `api_URL`, `api_Type`, `api_Setting`, `api_Method`, `api_Module`) VALUES (NULL, ' . $data . ');' );
        //echo('INSERT INTO `wb_api` (`api_ID`, `api_Name`, `api_URL`, `api_Type`, `api_Setting`, `api_Method`, `api_Module`) VALUES (NULL, ' . $data . ');');
    }

    public function edit_api($data, $id){
        //$data = implode(', ', $this->array_quote($data));
        mysqli_query($this->conn, 'UPDATE `wb_api` SET ' . $this->api_data_string_convert($data) . " WHERE `api_ID` = $id;");
        //echo('UPDATE `wb_api` SET ' . $this->api_data_string_convert($data) . " WHERE `api_ID` = $id;");
    }

    public function delete_api($id){
        mysqli_query($this->conn, "DELETE FROM `wb_api` WHERE `api_ID` = $id");
    }

    //Add single module data.
    public function add_data($moduleID, $content){
        $moduleCount = count($this->get_module_data($moduleID));

        $data[0] = json_encode($content, JSON_UNESCAPED_UNICODE);    //Data Don't escaped Chinese words.
        $data[1] = $moduleID;   //From which module.

        $data = implode(', ', $this->array_quote($data));

        mysqli_query($this->conn, 'INSERT INTO `wb_data` (`data_ID`, `data_Content`, `data_Module`) VALUES (NULL, ' . $data . ');' );        
    }

    public function edit_data($moduleID, $content){
        $data = json_encode($content, JSON_UNESCAPED_UNICODE);    //Data Don't escaped Chinese words.

        mysqli_query($this->conn, "UPDATE `wb_data` SET `data_Content` = '$data' WHERE `data_ID` = $moduleID;");
    }

    public function delete_data($id){
        mysqli_query($this->conn, "DELETE FROM `wb_data` WHERE `data_ID` = $id");
    }

    public function edit_module($mid, $name, $friendlyName, $data){
        mysqli_query($this->conn, "UPDATE `wb_module` SET `module_Name` = '$name', `module_FriendlyName` = '$friendlyName', `module_Key` = '$data' WHERE `module_ID` = $mid;");
    }

    public function delete_module($mid){
        mysqli_query($this->conn, "DELETE FROM `wb_module` WHERE `module_ID` = $mid");
    }

    public function edit_setting($data){
        foreach($data as $key => $value){
            mysqli_query($this->conn, "UPDATE `wb_options` SET `options_Value` = '$value' WHERE `options_Name` = '$key';");
        }

    }

    private function api_data_string_convert($data){
        //Convert the update api string.
        $fieldArray = ['api_Name', 'api_URL', 'api_Type', 'api_Setting', 'api_Method', 'api_Module'];
        $updateString = '';
        
        foreach($fieldArray as $key => $value){
            $updateString .= "`$value` = '" . $data[$value] . '\',';
        }

        //Remove the last comma.
        $updateString = substr($updateString, 0, strlen($updateString) - 1);
        return $updateString;
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