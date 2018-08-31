<?php
define( 'ABSPATH', '..' );

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
        case 'DeleteModule':
            deleteModule();
        break;
        case 'EditModule':
            editModule();
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
        $data[$i - 1] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2'], $_POST['field_' . $i .'_3']];
    }

    $data = json_encode($data, JSON_UNESCAPED_UNICODE); //Don't escaped Chinese words.

    $db->add_module($_POST['name'], $data, $_POST['friendlyname']);

    redirect('/wb-develop/index.php/Module');
}

function addAPI(){
    global $db;

    $data['name'] = $_POST['name'];
    $data['meta'] = $_POST['meta'];
    $data['type'] = $_POST['type'];
    $data['method'] = $_POST['method'];
    $data['version'] = $_POST['version'];
    $data['module'] = $_POST['module'];

    $db->add_api($data);

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
        $data[$i - 1] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2'], $_POST['field_' . $i .'_3']];
    }

    $data = json_encode($data, JSON_UNESCAPED_UNICODE); //Don't escaped Chinese words.

    $db->edit_module($mid, $name, $friendlyName, $data);

    redirect('/wb-develop/index.php/EditModule?id=' . $mid);
}

function deleteModule(){
    global $db;
    $db->delete_module($_POST['mid']);

    redirect('/wb-develop/index.php/Module');
}

function redirect($url){
    header('Location: ' . $url);
}