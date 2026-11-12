<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notifications_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    $status_val = isset($_POST['ast']) ? (int)$_POST['ast'] : (isset($_GET['ast']) ? (int)$_GET['ast'] : 0);
    $notif_obj = new notifications_ADD_UPDATE();
    $notif_obj->set_id($id);
    $notif_obj->set_ast($status_val);

    if ($notif_obj->process_update()) {
        $state['error'] = "0";
        $state['status'] = "success";
        $state['id'] = $id;
        $state['ast'] = $status_val;
        $state['msg'] = "Notification status updated successfully.";
    } else {
        $state['error'] = $notif_obj->get_error() ?: "Failed to update notification status.";
    }
} else {
    $state['error'] = "Notification ID is required.";
}

$json[] = $state;
echo json_encode($json);
