<?php
defined('ABSPATH') OR exit('No direct script access allowed');

require_once('Database.class.php');

class Account{

    private $db;

    public function __construct(){
        $this->db = new Database();
        if(isset($_COOKIE['PHPSESSID']) AND $_COOKIE['PHPSESSID'] == ''){

            //If the PHPSESSID's value is empty, it will return an error, so we should delete the PHPSESSID.
            setcookie('PHPSESSID', '', time() - 3600);
        }else{
            session_start();
        }

    }

    public function Login($name, $password){

        $userData = $this->db->get_account_by_name($name);
        if($userData != false){
            if($userData['account_Name'] == $name AND $userData['account_Password'] == $password){
                //Login successfully, return account type.

                $_SESSION['isLoggedIn'] = true;
                $_SESSION['accountType'] = $userData['account_Type'];
                return $userData['account_Type'];
            }
        }else{
            return false;
        }
    }

    public function isLogin(){
        if(isset($_SESSION['isLoggedIn'])){
            return $_SESSION['isLoggedIn'];
        }else{
            return false;
        }
    }

    public function getUserType(){
        if(isset($_SESSION['accountType'])){
            return $_SESSION['accountType'];
        }else{
            return false;
        }
    }
}