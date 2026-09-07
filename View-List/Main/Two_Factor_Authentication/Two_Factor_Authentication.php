<?php

include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../imports/sms/SMS_Sending.php';
include_once '../../../imports/security/encrypt_decrypt.php';
include_once '../../../imports/security/key_list.php';
include_once '../../../imports/Company_Info/Company_Info_Variable_List.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA_By_Email.php';

$json = [];
$state = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ================= SEND OTP ================= */
    if (isset($_POST['setting_enable_disable_send_otp'])) {

        $phone_number = $_POST['val_01'] ?? "";

        if (!$phone_number) {
            $state['error']   = "1";
            $state['message'] = "Phone-Number-Required";
            $json[] = $state;
            echo json_encode($json);
            exit;
        }

        $otp = random_int(100000, 999999);
        $message = "Your OTP code is: $otp. Do not share this code.";

        $sms_obj = new SMS_Sending($phone_number, $message);
        $sms_obj->send_message();

        $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
        $Advance_Security_obj = new Advance_Security();
        $otp_encrypt = $Advance_Security_obj->get_data_encrypt($Advance_Security_Key_List_obj->get_two_step_varification(), $otp);

        $state['error']   = "0";
        $state['otp']     = $otp_encrypt;
        $state['message'] = "OTP sent successfully";
        $json[] = $state;

        echo json_encode($json);
        exit;
    }

    /* ================= CHECK OTP ================= */
    if (isset($_POST['setting_enable_disable_otp_check'])) {

        $otp_encrypt = $_POST['val_01'] ?? ($_SESSION['otp_encrypt'] ?? "");
        $user_otp    = $_POST['val_02'] ?? ""; // User input OTP
        $email       = $_POST['val_03'] ?? ($_SESSION['user_name'] ?? "");

        $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
        $Advance_Security_obj = new Advance_Security();

        $otp = $Advance_Security_obj->get_data_decrypt(
            $Advance_Security_Key_List_obj->get_two_step_varification(),
            $otp_encrypt
        );


        if ($otp == $user_otp) {
            if (isset($_POST['setting_enable_disable_main_user_login_update'])) {
                $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();

                $main_user_login_SINGLE_DATA_By_Email_obj = new main_user_login_SINGLE_DATA_By_Email($email);

                if ($main_user_login_SINGLE_DATA_By_Email_obj->get_state()) {
                    $user_id = $main_user_login_SINGLE_DATA_By_Email_obj->get_id();

                    $main_user_login_ADD_UPDATE_obj->set_id($user_id);

                    if (isset($_POST['want_disable'])) {
                        $main_user_login_ADD_UPDATE_obj->is_not_is_two_factor_auth_enable();
                    } else if (isset($_POST['want_enable'])) {
                        $main_user_login_ADD_UPDATE_obj->is_is_two_factor_auth_enable();
                    }

                    if ($main_user_login_ADD_UPDATE_obj->process_update()) {
                        $state['error']   = "0";
                        $state['message'] = "OTP-Verified-Successfully";
                    } else {
                        $state['error']   = "1";
                        $state['message'] = "User-Update-failed";
                    }
                } else {
                    $state['error']   = "1";
                    $state['message'] = "User-Not-found";
                }
            } else {
                $state['error']   = "0";
                $state['message'] = "OTP-Verified-Successfully";
            }
        } else {
            $state['error']   = "1";
            $state['message'] = "OTP-Verification-Failed";
        }

        $json[] = $state;
        echo json_encode($json);
        exit;
    }
}

/* ================= INVALID REQUEST ================= */
$state['error']   = "1";
$state['message'] = "Invalid-request";
$json[] = $state;

echo json_encode($json);
