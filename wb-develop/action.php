<?php
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
    }
}else{
    //TODO
}

function addModule(){
    global $db;

    $row = $_POST['row'];
    $data[0] = [$_POST['field_1_1'],'number'];

    for($i = 2; $i <= $row; $i++){
        $data[$i - 1] = [$_POST['field_' . $i .'_1'], $_POST['field_' . $i .'_2']];
    }

    $data = json_encode($data);

    $db->add_module($_POST['name'], $data);

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

function redirect($url){
    header('Location: ' . $url);
}