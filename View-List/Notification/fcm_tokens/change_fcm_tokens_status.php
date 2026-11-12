<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/fcm_tokens_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
$token = isset($_POST['token']) ? trim($_POST['token']) : (isset($_GET['token']) ? trim($_GET['token']) : '');

if ($id > 0) {
    $status_val = isset($_POST['ast']) ? (int)$_POST['ast'] : (isset($_GET['ast']) ? (int)$_GET['ast'] : 0);
    $fcm_obj = new fcm_tokens_ADD_UPDATE();
    $fcm_obj->set_id($id);
    $fcm_obj->set_ast($status_val);

    if ($fcm_obj->process_update()) {
        $state['error'] = "0";
        $state['status'] = "success";
        $state['id'] = $id;
        $state['ast'] = $status_val;
        $state['msg'] = "FCM token status updated successfully.";
    } else {
        $state['error'] = $fcm_obj->get_error() ?: "Failed to update token status.";
    }
} elseif (!empty($token)) {
    $fcm_obj = new fcm_tokens_ADD_UPDATE();
    if ($fcm_obj->deactivate_token($token)) {
        $state['error'] = "0";
        $state['status'] = "success";
        $state['token'] = $token;
        $state['msg'] = "FCM token deactivated successfully.";
    } else {
        $state['error'] = "Failed to deactivate token.";
    }
} else {
    $state['error'] = "Token ID or Token string is required.";
}

$json[] = $state;
echo json_encode($json);

