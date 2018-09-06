<?php
define( 'ABSPATH', '..' );

//Make sure the user is login.
require_once('../wb-includes/Account.class.php');
$account = new Account();
if(!$account->isLogin() || $account->getUserType() != 'developer'){
    header('Location: /index.php/Login');
}

require_once('../wb-includes/Database.class.php');
$db = new Database();

if(isset($_GET['do'])){
    switch($_GET['do']){
        case 'AddModule':
            addModule();
        break;
        case 'AddAPI':
            addAPI();
        break;
        case 'DeleteAPI':
            deleteAPI();
        break;
        case 'DeleteModule':
            deleteModule();
        break;
        case 'EditModule':
            editModule();
        break;
        case 'EditSetting':
            editSetting();
        break;
    }
}else{
    //TODO
}

function addModule(){
    global $db;

    $row = $_POST['row'];
    //ID field.
    $data[0] = [$_POST['field_1_1'],'number'];

    //Add the other user's field.
    for($i = 2; $i <= $row; $i++){
        //The boolean, select, checkbox. upload needs the data field.
        $needMoreOption = ['boolean', 'select', 'checkbox', 'upload'];

        if(in_array($_POST['field_' . $i .'_3'], $needMoreOption)){
            $optionArray = comma_to_array($_POST['field_' . $i .'_4']);

            $data[$i - 1] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2'], $_POST['field_' . $i .'_3'], $optionArray];
        }else{
            $data[$i - 1] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2'], $_POST['field_' . $i .'_3']];
        }
    }

    $data = json_encode($data, JSON_UNESCAPED_UNICODE); //Don't escaped Chinese words.

    $db->add_module($_POST['name'], $data, $_POST['friendlyname']);

    redirect('/wb-develop/index.php/Module');
}

function addAPI(){
    global $db;

    //The order should be equal to the database's.
    $data['name'] = $_POST['name'];
    $data['meta'] = $_POST['meta'];
    $data['type'] = $_POST['type'];

    //Setting
    //Different type.
    if($data['type'] == 'read'){
        if($_POST['showAmount'] == 'all'){
            //Add the setting, 'all' is just one element.
            $data['setting'] = json_encode(['all']);
        }else if($_POST['showAmount'] == 'part'){
            $data['setting'] = json_encode(['part', $_POST['countPerPage'], $_POST['nowPageName']]);
        }
    }

    $data['method'] = $_POST['method'];
    $data['version'] = $_POST['version'];
    $data['module'] = $_POST['module'];


    $db->add_api($data);

    redirect('/wb-develop/index.php/API');
}

function deleteAPI(){
    global $db;
    if(isset($_POST['id'])){
        $db->delete_api($_POST['id']);
    }

    redirect('/wb-develop/index.php/API');
}

function editModule(){
    global $db;

    $mid = $_POST['mid'];
    $row = $_POST['row'];
    $name = $_POST['name'];
    $friendlyName = $_POST['friendlyname'];

    //ID field.
    $data[0] = [$_POST['field_1_1'],'number'];

    //Add the other user's field.
    for($i = 2; $i <= $row; $i++){
        //The boolean, select, checkbox. upload needs the data field.
        $needMoreOption = ['boolean', 'select', 'checkbox', 'upload'];

        //Make sure the field isn't deleted.
        if(!isset($_POST['field_' . $i .'_1'])){
            continue;
        }

        if(in_array($_POST['field_' . $i .'_3'], $needMoreOption)){
            $optionArray = comma_to_array($_POST['field_' . $i .'_4']);

            $data[] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2'], $_POST['field_' . $i .'_3'], $optionArray];
        }else{
            $data[] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2'], $_POST['field_' . $i .'_3']];
        }
    }

    $data = json_encode($data, JSON_UNESCAPED_UNICODE); //Don't escaped Chinese words.

    $db->edit_module($mid, $name, $friendlyName, $data);

    redirect('/wb-develop/index.php/Module');
}

function deleteModule(){
    global $db;
    $db->delete_module($_POST['mid']);

    redirect('/wb-develop/index.php/Module');
}

function editSetting(){
    global $db;
    $data['project_name'] = $_POST['projectName'];
    $data['copyright'] = $_POST['copyright'];

    $db->edit_setting($data);

    redirect('/wb-develop/index.php/Setting');
}

function comma_to_array($string){
    $string = str_replace('，', ',', $string);  //Convert the Chinese character comma to English comma.
    $array = explode(',', $string);

    return $array;
}
function redirect($url){
    header('Location: ' . $url);
}