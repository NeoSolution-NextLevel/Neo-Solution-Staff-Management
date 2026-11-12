<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/fcm_tokens_SINGLE_DATA.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state_data = array();

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    $single_obj = new fcm_tokens_SINGLE_DATA($id);

    if ($single_obj->get_state()) {
        $state_data = $single_obj->get_data_array();
        $state_data['error'] = "0";
        $state_data['status'] = "success";
    } else {
        $state_data['error'] = "FCM token record not found.";
    }
} else {
    $state_data['error'] = "Token ID is required.";
}

$json[] = $state_data;
echo json_encode($json);

