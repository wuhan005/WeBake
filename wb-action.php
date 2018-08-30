<?php
require_once('./wb-includes/Account.class.php');

if(isset($_GET['do'])){
    switch($_GET['do']){
        case 'Login':
            login();
        break;
        case 'AddModule':
            add_module_data($this->db); //Require database;
        break;
    }
}else{
    //TODO
}

function login(){
    $account = new Account();

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

function redirect($url){
    header('Location: ' . $url);
}