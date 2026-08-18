<?php

include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA_By_Email.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_LIST.php';
include_once '../../../imports/Company_Info/Company_Info_Variable_List.php';
include_once '../../../imports/security/encrypt_decrypt.php';
include_once '../../../imports/security/key_list.php';


$json = array();
$state = array();
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name_show = isset($_POST['val_01']) ? $_POST['val_01'] : ""; //show name 
    $user_name = isset($_POST['val_02']) ? $_POST['val_02'] : ""; // user name ( email ) 
    $first_name = isset($_POST['val_03']) ? $_POST['val_03'] : ""; // first_name
    $last_name = isset($_POST['val_04']) ? $_POST['val_04'] : ""; // last_name
    $phone_number = isset($_POST['val_05']) ? $_POST['val_05'] : ""; // phone_number
    $dis = isset($_POST['val_06']) ? $_POST['val_06'] : ""; // dis

    $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();


    if (isset($_POST['id'])) {

        $get_id = $_POST['id'];
        $main_user_login_ADD_UPDATE_obj->set_id($get_id);

        if (isset($_POST['user_profile_page_details_update'])) {
            $main_user_login_ADD_UPDATE_obj->set_user_profile_data($user_name, $name_show, $first_name, $last_name, $dis, $phone_number);
        }

        if (isset($_POST['image_url'])) {
            $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : "";  // Image url 
            $main_user_login_ADD_UPDATE_obj->set_image_url($image_url);
        }


        if (isset($_POST['change_password'])) {
            $password =  $_POST['password'];
            $user_name =  $_POST['user_name'];
            $current_password =  $_POST['current_password'];
            $advance_security_check = new Advance_Security();

            $current_password = $advance_security_check->get_data_encrypt($user_name, $current_password);


            $main_user_login_SINGLE_DATA_By_Email_obj = new main_user_login_SINGLE_DATA_By_Email($user_name);

            if ($main_user_login_SINGLE_DATA_By_Email_obj->get_state()) {

                // echo  "DB Password : " . $main_user_login_SINGLE_DATA_By_Email_obj->get_user_name();
                // echo  "Current password : " . $current_password;
                if ($main_user_login_SINGLE_DATA_By_Email_obj->get_password() == $current_password) {

                    $password = $advance_security_check->get_data_encrypt($user_name, $password);
                    $main_user_login_ADD_UPDATE_obj->set_password($password);
                } else {
                    $state['error'] = "1";
                    $state['message'] = "Current-Password-Not-Match";
                    $json[] = $state;
                    echo json_encode($json);
                    exit;
                }
            } else {
                $state['error'] = "1";
                $state['message'] = "User-Not-Found";
                $json[] = $state;
                echo json_encode($json);
                exit;
            }
        }

        if (isset($_POST['del'])) {
            $main_user_login_ADD_UPDATE_obj->remove();
        }

        if ($main_user_login_ADD_UPDATE_obj->process_update()) {
            $state['error'] = "0";
            $state['message'] = "Update-User-Details";
            $state['id'] = $get_id;
        } else {
            $state['error'] = $main_user_login_ADD_UPDATE_obj->get_error();
        }
    } else {
        $state['error'] = "1";
        $state['message'] = "User-Id-Not-Found";
        $state['id'] = $get_id;
    }
    $json[] = $state;
} else {
    $state['error'] = "Missing required fields";
    $json[] = $state;
}

echo json_encode($json);
