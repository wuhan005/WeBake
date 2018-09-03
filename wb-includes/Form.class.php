<?php 
defined('ABSPATH') OR exit('No direct script access allowed');

//Used to access the GET or POST data.
//The data will be checked.
class Form {

    public function get($name){
        if(isset($_GET[$name])){
            return $_GET[$name];
        }else{
            return null;
        }
    }

    public function post($name){
        if(isset($_POST[$name])){
            return $_POST[$name];
        }else{
            return null;
        }
    }
}