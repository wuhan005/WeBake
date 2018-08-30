<?php
require_once('Database.class.php');

class WeBake{

    private $urlPathInfo;
    private $nowPage;
    private $pages = [];

    private $db;

    //URL Router.
    public function __construct(){

        //Register the router
        $this->pages['Login'] = 'wb-login';
        $this->pages['Api'] = 'wb-api';
        $this->pages['Action'] = 'wb-action';
        $this->pages['Dashboard'] = 'wb-dashboard';
        $this->pages['Module'] = 'wb-module';
        $this->pages['AddModule'] = 'wb-addmodule';
        
        $this->urlPathInfo = @explode('/',$_SERVER['PATH_INFO']);
        $this->nowPage = @$this->urlPathInfo[1];

        if($this->nowPage == null){
            //If it is /index.php, then go to login page.
            $this->nowPage = 'Login';
        }

        //Load the database.
        $this->db = new Database();

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