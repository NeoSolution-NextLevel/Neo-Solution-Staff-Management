<?php

include_once '../../imports/need/session_setup.php';
include_once '../../imports/need/DB.php';
include_once '../../imports/Company_Info/Company_Info_Variable_List.php';

include_once '../../imports/security/encrypt_decrypt.php';
include_once '../../imports/security/key_list.php';
include_once '../../Controllers/Main/main_user_login/main_user_login_LIST.php';
include_once '../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once '../../Controllers/Main/main_user_login_device/main_user_login_device_ADD_UPDATE.php';
include_once '../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';
include_once '../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_SINGLE_DATA.php';
include_once '../../Controllers/Main/Cook_Managment/Cook_Createing.php';
include_once '../../Controllers/Main/User_Accout_Check_Device.php';
include_once '../../Controllers/Main/User_Accout_Check.php';
include_once '../../imports/sms/SMS_Sending.php';


$get_user_name = isset($_POST['val_01']) ? $_POST['val_01'] : "";
$get_password = isset($_POST['val_02']) ? $_POST['val_02'] : "";

$json = array();
$state = array();

$User_Account_Check_obj = new User_Account_Check($get_user_name, $get_password);

unset(
    $_SESSION['user'],
    $_SESSION['user_id'],
    $_SESSION['temp_user'],
    $_SESSION['otp_pending'],
    $_SESSION['otp_encrypt'],
    $_SESSION['session_token'],
    $_SESSION['user_main_cook_id'],
    $_SESSION['main_user_account_access_level_list_id'],
    $_SESSION['url_home'],
    $_SESSION['user_role'],
    $_SESSION['ac_type']
);

if ($User_Account_Check_obj->check_user_name()) {

    if ($User_Account_Check_obj->check_temp_lock_state()) {
        $state['error'] = "temporary lock";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    if ($User_Account_Check_obj->check_password()) {

        $_SESSION['session_token'] = $User_Account_Check_obj->get_session_token();
        $_SESSION['user_id'] = $User_Account_Check_obj->get_user_id();
        $_SESSION['user_name'] = $User_Account_Check_obj->get_user_name();

        // Check main_user_account_access_level_list_id and get url_home
        $access_level_id = $User_Account_Check_obj->get_main_user_account_access_level_list_id();
        $acl_obj = new main_user_account_access_level_list_SINGLE_DATA($access_level_id);
        $url_home = "";
        $user_role = "";
        if ($acl_obj->get_state()) {
            $url_home = trim($acl_obj->get_url_home());
            $user_role = trim($acl_obj->get_type_of_access());
        }

        $_SESSION['main_user_account_access_level_list_id'] = $access_level_id;
        $_SESSION['url_home'] = $url_home;
        $_SESSION['user_role'] = $user_role;
        $_SESSION['ac_type'] = $user_role;

        $state['error'] = "0";
        $state['url_home'] = $url_home;
        $state['user_role'] = $user_role;

        if ($User_Account_Check_obj->get_google_authentication()) {
            $_SESSION['otp_pending'] = true;
            $state['google_authentication'] = "1";
            $state['is_two_factor_auth_enable'] = "0";
        } else {
            $_SESSION['otp_pending'] = false;
            $state['google_authentication'] = "0";

            if ($User_Account_Check_obj->get_is_two_factor_auth_enable() == "1") {
                $phone_number = $User_Account_Check_obj->get_phone_number();

                $otp = random_int(100000, 999999);
                $message = "Your OTP code is: $otp. Do not share this code.";

                $sms_obj = new SMS_Sending($phone_number, $message);
                $sms_obj->send_message();

                $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
                $Advance_Security_obj = new Advance_Security();
                $otp_encrypt = $Advance_Security_obj->get_data_encrypt($Advance_Security_Key_List_obj->get_two_step_varification(), $otp);

                $_SESSION['otp_encrypt'] = $otp_encrypt;
                $state['is_two_factor_auth_enable'] = "1";
            } else {
                $state['is_two_factor_auth_enable'] = "0";
            }
        }

        // Check cookies creating 
        $Cook_Createing = new Cook_Createing($User_Account_Check_obj->get_user_id());
        $_SESSION['user_main_cook_id'] = $Cook_Createing->get_cook_id();

        $json[] = $state;
    } else {
        $state['error'] = $User_Account_Check_obj->get_error();
        $json[] = $state;
    }
} else {
    $state['error'] = $User_Account_Check_obj->get_error();
    $json[] = $state;
}

echo json_encode($json);
