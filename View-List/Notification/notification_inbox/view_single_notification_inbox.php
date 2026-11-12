<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notification_inbox_SINGLE_DATA.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state_data = array();

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['inbox_id']) ? (int)$_POST['inbox_id'] : (isset($_GET['inbox_id']) ? (int)$_GET['inbox_id'] : 0)));

if ($id > 0) {
    $single_obj = new notification_inbox_SINGLE_DATA($id);

    if ($single_obj->get_state()) {
        $state_data = $single_obj->get_data_array();
        $state_data['error'] = "0";
        $state_data['status'] = "success";
    } else {
        $state_data['error'] = "Notification inbox record not found.";
    }
} else {
    $state_data['error'] = "Inbox ID is required.";
}

$json[] = $state_data;
echo json_encode($json);
