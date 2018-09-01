<?php
//Set JSON header.
header('Content-type: application/json');

require_once('Database.class.php');

class Api{
    private $db;
    private $ApiURL = array();

    public function __construct(){
        $this->db = new Database;

        //Add the Api url.
        foreach($this->db->get_all_api() as $key => $value){
            $this->ApiURL[] = $value['api_Version'] . '/' . $value['api_Meta'];
        }

        //The Api is existed or not. 
        if(in_array($this->get_now_api(), $this->ApiURL)){
            //Show it!
            $this->pack_api();
        }else{
            $this->render(404, 'Api Not Found.', true);
        }
    }

    private function pack_api(){
        //We think the api is existed.
        $apiData = $this->db->get_single_api($this->get_now_api('version'), $this->get_now_api('meta'))[0];
        $api_type = $apiData['api_Type'];

        if($api_type == 'read'){
            
        }else{

        }
    }

    //URL Router
    private function get_now_api($type='all'){
        $urlPathInfo = @explode('/',$_SERVER['PATH_INFO']);

        $version = @$urlPathInfo[2];
        $meta = @$urlPathInfo[3];
        
        //Used to get the every part of the url.
        switch($type){
            case 'all':
                return $version . '/' . $meta;
            break;
            case 'version':
                return $version;
            break;
            case 'meta':
                return $meta;
            break;
            default:
                return $version . '/' . $meta;
        }
    }

    private function render($code, $data, $isError = false){
        $renderData = array();
        $renderData['code'] = $code;
        if($isError){
            $renderData['log'] = $data;
        }else{
            $renderData['data'] = $data;
        }

        $renderData = json_encode($renderData);
        echo($renderData);
    }
}