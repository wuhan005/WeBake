<?php
require_once('../wb-includes/Database.class.php');

class Dev_Loader{
    private $urlPathInfo;
    private $nowPage;
    private $pages = [];

    private $db;

    //URL Router.
    public function __construct(){

        //Register the router
        $this->pages['Index'] = 'main';
        $this->pages['API'] = 'api';
        $this->pages['Module'] = 'module';
        $this->pages['Setting'] = 'setting';
        $this->pages['AddModule'] = 'add_module';
        $this->pages['AddAPI'] = 'add_api';
        

        $this->urlPathInfo = @explode('/',$_SERVER['PATH_INFO']);
        $this->nowPage = @$this->urlPathInfo[1];

        if($this->nowPage == null){
            //If it is /index.php, then go to the mainpage.
            $this->nowPage = 'Index';
        }

        //Load the database
        $this->db = new Database();

        $this->load_page();
    }

    public function load_page(){
        if(array_key_exists($this->nowPage, $this->pages)){
            require_once('header.php');
            require_once($this->pages[$this->nowPage] . '.php');
            require_once('footer.php');
        }else{
            //If the page isn't existed, turn to 404.
            echo('Page not found.');
        }
    }
}