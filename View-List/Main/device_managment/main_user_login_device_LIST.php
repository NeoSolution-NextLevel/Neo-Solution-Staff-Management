<?php
include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';





$json = array();



$main_user_login_device_LIST_obj = new main_user_login_device_LIST();
$main_user_login_device_LIST_obj->filter_by_main_user_login_id($_SESSION['user_id']);

if (isset($_POST['all_device_without_crrent'])) {
    $main_user_login_device_LIST_obj->filter_by_is_active("0");
}

$get_result = $main_user_login_device_LIST_obj->get_result();


if ($get_result && $get_result->num_rows > 0) {
    while ($row = $get_result->fetch_assoc()) {
        $json[] = $row;
    }
}
echo json_encode($json);
