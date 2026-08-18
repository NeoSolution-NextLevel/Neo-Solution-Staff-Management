<?php

include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_login_device/main_user_login_device_ADD_UPDATE.php';

$json = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $main_user_login_device_ADD_UPDATE_obj = new main_user_login_device_ADD_UPDATE();


    if (isset($_POST['id'])) {

        $get_id = $_POST['id'];
        $main_user_login_device_ADD_UPDATE_obj->set_id($get_id);

        if (isset($_POST['remove'])) {
            $main_user_login_device_ADD_UPDATE_obj->remove();
        }
        if ($main_user_login_device_ADD_UPDATE_obj->process_update()) {
            $state['error'] = "0";
            $state['id'] = $get_id;
        } else {
            $state['error'] = "Update-Error";
        }
    }

    if (isset($_POST['all_remove'])) {

        if ($main_user_login_device_ADD_UPDATE_obj->log_out_all_device_except_current_one($_SESSION['user_id'])) {
            $state['error'] = "0";
        } else {
            $state['error'] = "Update-Error";
        }
    }
    $json[] = $state;
} else {
    $state['error'] = "Missing required fields";
    $json[] = $state;
}

echo json_encode($json);
