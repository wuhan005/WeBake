<?php
defined('ABSPATH') OR exit('No direct script access allowed');

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
            $this->ApiURL[] = $value['api_URL'];
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
        $apiData = $this->db->get_single_api($this->get_now_api('url'));

        $api_type = $apiData['api_Type'];
        $api_method = $apiData['api_Method'];
        $api_module = $apiData['api_Module'];   //Get the api module ID.

        $api_Setting = $apiData['api_Setting'];
        $api_Setting = json_decode($api_Setting, true);

        //READ
        if($api_type == 'read'){

            if($api_Setting[0] == 'all'){
                //Get all data. Don't mind the api type.
                $data = $this->db->get_module_data($api_module);
                $data = $this->data_handle($data);

                $this->render(200, $data);

            }else if($api_Setting[0] == 'part'){
                $data = $this->db->get_module_data($api_module);
                $dataCount = count($data);

                $dataPerPage = $api_Setting[1];
                $pageParmName = $api_Setting[2];

                //Get the page parm name of the different type.
                if($api_method == 'get'){
                    if(isset($_GET[$pageParmName])){
                        $nowPage = $_GET[$pageParmName];
                    }else{
                        //If does't get parm, return error.
                        $this->render(500, 'Lack of parameter.');
                        die();
                    }
                }else if($api_method == 'post'){
                    if(isset($_POST[$pageParmName])){
                        $nowPage = $_POST[$pageParmName];
                    }else{
                        //If does't get parm, return error.
                        $this->render(500, 'Lack of parameter.');
                        die();
                    }
                }

                $totalPage = ceil($dataCount / $dataPerPage);
                $firstData = ($nowPage - 1) * $dataPerPage;
                $lastData = $firstData + $dataPerPage;

                $nowPageData = array();
                //Judge the page's data is empty or not.
                if($firstData < $dataCount){
                    for($i = $firstData; $i<$lastData; $i++){
                        if($i < $dataCount){    //In the last page, the data's count may not enough.
                            $nowPageData[] = $data[$i];
                        }
                    }
                }else{
                    $this->render(201, $this->data_handle($nowPageData));   //If the result is empty, return a 201 code.
                    die();
                }

                $this->render(200, $this->data_handle($nowPageData, $firstData));
            }


        }else if($api_type == 'add'){
            $moduleField = $this->db->get_module_by_id($api_module);
            $moduleField = $moduleField['module_Key'];
            $moduleField = json_decode($moduleField, true);

            if($api_method == 'get'){
                //Make sure all the value is sent.
                $data = array();
                foreach($moduleField as $key => $value){
                    //value[0] is the name of the field.
                    //$key == 0 means the first field ID no need to be given.
                    if(isset($_GET[$value[0]]) || $key == 0){
                        if($key != 0){
                            $data[$value[0]] = $_GET[$value[0]];
                        }
                        continue;
                    }else{
                        //Missing parm, turn error.
                        $this->render(500, 'Lack of parameter: ' . $value[0]);
                        die();
                    }
                }
                $this->db->add_data($api_module, $data);
                $this->render(200, 'success.');

            }else if($api_method == 'post'){
                //Make sure all the value is sent.
                $data = array();
                foreach($moduleField as $key => $value){
                    //value[0] is the name of the field.
                    //$key == 0 means the first field ID no need to be given.
                    if(isset($_POST[$value[0]]) || $key == 0){
                        if($key != 0){
                            $data[$value[0]] = $_POST[$value[0]];
                        }
                        continue;
                    }else{
                        //Missing parm, turn error.
                        $this->render(500, 'Lack of parameter: ' . $value[0]);
                        die();
                    }
                }
                $this->db->add_data($api_module, $data);
                $this->render(200, 'success.');
            }

        }
    }

    //Convert the data to user.
    //The $firstID is used in the part data. The default value 0 is for the display all data's api.
    private function data_handle($data, $firstID = 0){
        $result = array();

        foreach($data as $key => $value){
            $result[$key]['id'] = $firstID + $key + 1;     //Add current api's id.
            $dataContent = json_decode($value['data_Content'], true);

            //Loop to add each data field.
            foreach($dataContent as $dataKey => $dataValue){
                $result[$key]['data'][$dataKey] = $dataValue;
            }
        }

        return $result;
    }

    //URL Router
    private function get_now_api(){
        $urlPath = $_SERVER['PATH_INFO'];

        // Get the '/Api/' string's posistion.
        $firstIndex = strpos($urlPath, '/Api/');
        
        //Get the string behind the '/Api/'.
        $urlPath = substr($urlPath, $firstIndex + 5);
        return $urlPath;
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