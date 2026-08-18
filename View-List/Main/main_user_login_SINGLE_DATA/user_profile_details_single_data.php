<?php
include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA.php';
include_once '../../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_SINGLE_DATA.php';
include_once '../../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';


$json = array();



if (isset($_POST['session_user_id'])) {

    if (isset($_SESSION['user_id'])) {
        $main_user_login_id = $_SESSION['user_id'];
    } else {
        $state_data['error'] = "user id not found";
        $json[] = $state_data;
        echo json_encode($json);
        exit;
    }
} else {
    $main_user_login_id = 0;
}




// echo "User id : " . $main_user_login_id;
$main_user_login_SINGLE_DATA_obj = new main_user_login_SINGLE_DATA($main_user_login_id);

if ($main_user_login_SINGLE_DATA_obj->get_state()) {
    $state_data['id'] = $main_user_login_SINGLE_DATA_obj->get_id();
    $state_data['user_name'] = $main_user_login_SINGLE_DATA_obj->get_user_name();
    $state_data['password'] = $main_user_login_SINGLE_DATA_obj->get_password();
    $state_data['account_active_state'] = $main_user_login_SINGLE_DATA_obj->get_account_active_state();
    $state_data['ast'] = $main_user_login_SINGLE_DATA_obj->get_ast();
    $state_data['sdt'] = $main_user_login_SINGLE_DATA_obj->get_sdt();
    $state_data['last_login'] = $main_user_login_SINGLE_DATA_obj->get_last_login();
    $state_data['name_show'] = $main_user_login_SINGLE_DATA_obj->get_name_show();
    $state_data['email_verify'] = $main_user_login_SINGLE_DATA_obj->get_email_verify();
    $state_data['moible_verfiy'] = $main_user_login_SINGLE_DATA_obj->get_moible_verfiy();
    $state_data['very_first_login'] = $main_user_login_SINGLE_DATA_obj->get_very_first_login();
    $state_data['cook_key'] = $main_user_login_SINGLE_DATA_obj->get_cook_key();
    $state_data['ref_key'] = $main_user_login_SINGLE_DATA_obj->get_ref_key();
    $state_data['temp_lock'] = $main_user_login_SINGLE_DATA_obj->get_temp_lock();
    $state_data['full_block'] = $main_user_login_SINGLE_DATA_obj->get_full_block();
    $state_data['ac_type'] = $main_user_login_SINGLE_DATA_obj->get_ac_type();
    $state_data['company_id'] = $main_user_login_SINGLE_DATA_obj->get_company_id();
    $state_data['control_account_state'] = $main_user_login_SINGLE_DATA_obj->get_control_account_state();
    $state_data['image_url'] = $main_user_login_SINGLE_DATA_obj->get_image_url();
    $state_data['google_id'] = $main_user_login_SINGLE_DATA_obj->get_google_id();
    $state_data['google_authentication_secret'] = $main_user_login_SINGLE_DATA_obj->get_google_authentication_secret();
    $state_data['microsoft_id'] = $main_user_login_SINGLE_DATA_obj->get_microsoft_id();
    $state_data['is_google_authentication_enable'] = $main_user_login_SINGLE_DATA_obj->get_is_google_authentication_enable();
    $state_data['first_name'] = $main_user_login_SINGLE_DATA_obj->get_first_name();
    $state_data['last_name'] = $main_user_login_SINGLE_DATA_obj->get_last_name();
    $state_data['dis'] = $main_user_login_SINGLE_DATA_obj->get_dis();
    $state_data['phone_number'] = $main_user_login_SINGLE_DATA_obj->get_phone_number();
    $state_data['is_two_factor_auth_enable'] = $main_user_login_SINGLE_DATA_obj->get_is_two_factor_auth_enable();



    if (isset($_POST['user_access_level_dedtails'])) {
        $user_access_level_id = $main_user_login_SINGLE_DATA_obj->get_main_user_account_access_level_list_id();

        $main_user_account_access_level_list_SINGLE_DATA_obj = new main_user_account_access_level_list_SINGLE_DATA($user_access_level_id);
        if ($main_user_account_access_level_list_SINGLE_DATA_obj->get_state()) {

            $state_data['type_of_access'] = $main_user_account_access_level_list_SINGLE_DATA_obj->get_type_of_access();
            $state_data['job_role'] = $main_user_account_access_level_list_SINGLE_DATA_obj->get_job_role();
        } else {
            $state_data['error'] = "Access Level Not Found";
        }
    }

    if (isset($_POST['main_user_login_device_login_details'])) {

        $main_user_login_device_LIST_obj = new main_user_login_device_LIST();
        $main_user_login_device_LIST_obj->filter_by_main_user_login_id($main_user_login_SINGLE_DATA_obj->get_id());
        $main_user_login_device_LIST_obj->filter_by_is_active();
        $main_user_login_device_LIST_obj->filter_by_ast();
        $main_user_login_device_LIST_obj->get_count_report();

        $get_result = $main_user_login_device_LIST_obj->get_result();

        if ($get_result && $get_result->num_rows > 0) {
            $row = $get_result->fetch_assoc();
            $state_data['device_count'] = $row['total_count'];
        } else {
            $state_data['device_count'] = 0;
        }
    }




    $state_data['error'] = "0";
} else {
    $state_data['error'] = "user id not found";
}

$json[] = $state_data;




echo json_encode($json);
