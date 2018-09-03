<?php
defined('ABSPATH') OR exit('No direct script access allowed');

require_once('Database.class.php');
require_once('Form.class.php');
require_once('./wb-includes/Account.class.php');

class WeBake{

    private $urlPathInfo;
    private $nowPage;
    private $pages = [];

    private $db;
    private $form;
    private $account;

    //URL Router.
    public function __construct(){

        //Load the Account part.
        $this->account = new Account();

        //Register the router
        $this->pages['Login'] = 'wb-login';
        $this->pages['Api'] = 'wb-api';
        $this->pages['Action'] = 'wb-action';
        $this->pages['Dashboard'] = 'wb-dashboard';
        $this->pages['Module'] = 'wb-module';
        $this->pages['AddData'] = 'wb-adddata';
        $this->pages['DeleteData'] = 'wb-deletedata';
        $this->pages['EditData'] = 'wb-editdata';

        //The pages which need login to access.
        $needLoginPage = ['Dashboard', 'Module', 'AddData', 'DeleteData', 'EditData'];
        
        $this->urlPathInfo = @explode('/',$_SERVER['PATH_INFO']);
        $this->nowPage = @$this->urlPathInfo[1];

        if($this->nowPage == null){
            if(!$this->account->isLogin()){
                //If it is /index.php, then go to login page.
                $this->nowPage = 'Login';
            }else{
                if($this->account->getUserType() == 'developer'){
                    header('Location: /wb-develop/index.php');
                }else{
                    $this->nowPage = 'Dashboard';
                }
            }
        }

        if(!$this->account->isLogin() AND in_array($this->nowPage, $needLoginPage)){
            $this->nowPage = 'Login';
        }

        //Load the database.
        $this->db = new Database();

        //Load the Form Class.
        $this->form = new Form();

        $this->load_page();
    }

    public function load_page(){
        if(array_key_exists($this->nowPage, $this->pages)){
            require_once('./' . $this->pages[$this->nowPage] . '.php');
        }else{
            //If the page isn't existed, turn to 404.
            echo('Page not found.');
        }
    }
}