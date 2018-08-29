<?php
require_once('Database.class.php');

class Account{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function Login($name, $password){

        $userData = $this->db->get_account_by_name($name);
        if($userData != false){
            if($userData['account_Name'] == $name AND $userData['account_Password'] == $password){
                //Login successfully, return account type.
                return $userData['account_Type'];
            }
        }else{
            return false;
        }
    }
}