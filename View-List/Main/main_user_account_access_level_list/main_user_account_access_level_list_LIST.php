<?php
include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_LIST.php';




$json = array();



$main_user_account_access_level_list_LIST_obj = new main_user_account_access_level_list_LIST();

$get_result = $main_user_account_access_level_list_LIST_obj->get_result();


if ($get_result && $get_result->num_rows > 0) {
    while ($row = $get_result->fetch_assoc()) {
        $json[] = $row;
    }
}

echo json_encode($json);
