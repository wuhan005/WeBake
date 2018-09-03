<?php
require_once('../wb-includes/Database.class.php');
require_once('../wb-includes/Account.class.php');

class Dev_Loader{
    private $urlPathInfo;
    private $nowPage;
    private $pages = [];

    private $db;
    private $account;

    //URL Router.
    public function __construct(){
        $this->account = new Account;

        //Register the router
        $this->pages['Index'] = 'main';
        $this->pages['API'] = 'api';
        $this->pages['Module'] = 'module';
        $this->pages['Setting'] = 'setting';
        $this->pages['AddModule'] = 'add_module';
        $this->pages['EditModule'] = 'edit_module';
        $this->pages['DeleteModule'] = 'delete_module';
        $this->pages['AddAPI'] = 'add_api';
        $this->pages['DeleteAPI'] = 'delete_api';
        

        $this->urlPathInfo = @explode('/',$_SERVER['PATH_INFO']);
        $this->nowPage = @$this->urlPathInfo[1];

        if($this->nowPage == null){
            //If it is /index.php, then go to the mainpage.
            $this->nowPage = 'Index';
        }

        //Make sure the user is login the its type is develop.
        if(!$this->account->isLogin() || $this->account->getUserType() != 'developer'){
            header('Location: /index.php');
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