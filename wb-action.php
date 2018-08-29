<?php
require_once('./wb-includes/Account.class.php');

if(isset($_GET['do'])){
    switch($_GET['do']){
        case 'Login':
            login();
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

function redirect($url){
    header('Location: ' . $url);
}