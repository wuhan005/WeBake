<?php
defined('ABSPATH') OR exit('No direct script access allowed');

if(isset($_GET['do'])){
    switch($_GET['do']){
        case 'Login':
            login($this->account);
        break;
        case 'AddData':
            add_module_data($this->db); //Require database;
        break;
        case 'EditData':
            edit_module_data($this->db); //Require database;
        break;
        case 'DeleteData':
            delete_module_data($this->db); //Require database;
        break;
        case 'Logout':
            $this->account->LogOut();
            redirect('/index.php?logout');
        break;
    }
}else{
    //TODO
}

function login($account){

    if(isset($_POST['name']) AND isset($_POST['password'])){

        $Login = $account->Login($_POST['name'], $_POST['password']);

        if($Login){
            switch($Login){
                case 'admin':
                    redirect('/index.php/Dashboard');
                break;
                case 'developer':
                    redirect('/wb-develop/index.php');
                break;
            }
        }else{
            //Login fail.
            redirect('/index.php?error');
        }
    }else{
        //TODO
        redirect('/index.php?error');
    }
}

function add_module_data($db){

    if(isset($_POST['mid'])){
        $postData = $_POST;
        $data = array();
        foreach($postData as $key => $value){
            //Remove the 'mid' key.
            if($key != 'mid'){
                $data[$key] = $value;
            }
        }      

        $db->add_data($_POST['mid'], $data);
    }
    redirect('/index.php/Module?id=' . $_POST['mid']);
}

function edit_module_data($db){
    //Module ID is used to redirect.
    if(isset($_POST['id']) AND $_POST['mid']){   
        $postData = $_POST;
        $data = array();
        foreach($postData as $key => $value){
            //Remove the 'mid' and 'id key.
            if($key != 'mid' AND $key != 'id'){
                $data[$key] = $value;
            }
        }

        $db->edit_data($_POST['id'], $data);
    }
    redirect('/index.php/Module?id=' . $_POST['mid']);
}

function delete_module_data($db){
    //Module ID is used to redirect.
    if(isset($_POST['id']) AND $_POST['mid']){      
        $db->delete_data($_POST['id']);
    }
    redirect('/index.php/Module?id=' . $_POST['mid']);
}

function redirect($url){
    header('Location: ' . $url);
}