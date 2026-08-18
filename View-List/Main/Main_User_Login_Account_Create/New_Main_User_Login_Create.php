<?php

include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_LIST.php';
include_once '../../../imports/Company_Info/Company_Info_Variable_List.php';
include_once '../../../imports/security/encrypt_decrypt.php';
include_once '../../../imports/security/key_list.php';


$json = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name_show = isset($_POST['val_01']) ? $_POST['val_01'] : ""; //show name 
    $user_name = isset($_POST['val_02']) ? $_POST['val_02'] : ""; // user name ( email ) 
    $ref_key = isset($_POST['val_03']) ? $_POST['val_03'] : ""; // employee id 
    $password = isset($_POST['val_04']) ? $_POST['val_04'] : ""; // password
    $main_user_account_access_level_list_id = isset($_POST['val_05']) ? $_POST['val_05'] : ""; // main_user_account_access_level_list_id
    $ac_type = isset($_POST['val_06']) ? $_POST['val_06'] : ""; // ac_type
    $first_name = isset($_POST['val_07']) ? $_POST['val_07'] : ""; // first_name
    $last_name = isset($_POST['val_08']) ? $_POST['val_08'] : ""; // last_name

    $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();
    $main_user_login_LIST_obj = new main_user_login_LIST();
    $main_user_login_LIST_obj->filter_by_user_name($user_name);

    $get_result = $main_user_login_LIST_obj->get_result();


    //check email
    if ($get_result && $get_result->num_rows == 0) {

        $advance_security_check = new Advance_Security();

        $password = $advance_security_check->get_data_encrypt($user_name, $password);

        $main_user_login_ADD_UPDATE_obj->set_registration_from_data($user_name, $password, $name_show, " ", $ref_key, $ac_type, $main_user_account_access_level_list_id, $first_name, $last_name);

        if (isset($_POST['id'])) {

            $get_id = $_POST['id'];
            $main_user_login_ADD_UPDATE_obj->set_id($get_id);

            if (isset($_POST['del'])) {
                $main_user_login_ADD_UPDATE_obj->remove();
            }

            if ($main_user_login_ADD_UPDATE_obj->process_update()) {
                $state['error'] = "0";
                $state['id'] = $get_id;
            } else {
                $state['error'] = $main_user_login_ADD_UPDATE_obj->get_error();
            }
        } else {
            if ($main_user_login_ADD_UPDATE_obj->process_new_record()) {
                $state['error'] = "0";
                $state['id'] = $main_user_login_ADD_UPDATE_obj->get_id();
            } else {
                $state['error'] = $main_user_login_ADD_UPDATE_obj->get_error();
            }
        }
        $json[] = $state;
    } else {
        $state['error'] = "Already have this email";
        $json[] = $state;
    }
} else {
    $state['error'] = "Missing required fields";
    $json[] = $state;
}

echo json_encode($json);
