<?php

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/sms/SMS_Sending.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';
include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
include_once __DIR__ . '/../../../imports/security/key_list.php';
include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';
include_once __DIR__ . '/../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA_By_Email.php';

$json = [];
$state = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ================= SEND OTP ================= */
    if (isset($_POST['setting_enable_disable_send_otp'])) {

        $phone_number = trim($_POST['val_01'] ?? "");
        $session_uid  = (int)($_SESSION['user_id'] ?? 0);
        $user_email   = trim($_SESSION['user_name'] ?? "");

        $db = new DataBase();
        $conn = $db->get_data_base_connction();

        // If phone is empty in POST, check database
        if (!$phone_number && $session_uid > 0) {
            $chk = $conn->query("SELECT phone_number, user_name FROM `main_user_login` WHERE `id` = {$session_uid} LIMIT 1");
            if ($chk && ($cRow = $chk->fetch_assoc())) {
                $phone_number = trim($cRow['phone_number'] ?? '');
                if (!$user_email && !empty($cRow['user_name'])) {
                    $user_email = trim($cRow['user_name']);
                }
            }
        }

        if (!$phone_number) {
            $state['error']   = "1";
            $state['message'] = "Please provide a valid phone number to receive the OTP.";
            $json[] = $state;
            echo json_encode($json);
            exit;
        }

        // Save/persist phone number in main_user_login if logged in
        if ($session_uid > 0 && !empty($phone_number)) {
            $safePhone = mysqli_real_escape_string($conn, $phone_number);
            $conn->query("UPDATE `main_user_login` SET `phone_number` = '{$safePhone}' WHERE `id` = {$session_uid}");
            $conn->query("UPDATE `employee_profiles` SET `phone` = '{$safePhone}' WHERE `user_id` = {$session_uid}");
        }

        $otp = random_int(100000, 999999);
        $company_obj = new Company_Info_Variable_List();
        $c_name = $company_obj->get_compnay_name();
        $message = "Your {$c_name} verification OTP is: $otp. Valid for 10 minutes. Do not share this code.";

        $sms_sent = false;
        try {
            $sms_obj = new SMS_Sending($phone_number, $message);
            $sms_res = $sms_obj->send_message();
            if ($sms_obj->get_last_http_code() === 200) {
                $sms_sent = true;
            }
        } catch (\Throwable $e) {}

        // Send email as reliable backup
        $email_sent = false;
        if (!empty($user_email)) {
            try {
                $mail_subj = "Two-Factor Authentication OTP - {$c_name}";
                $mail_html = "
                <div style='font-family: Arial, sans-serif; max-width: 540px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                    <div style='text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 14px; margin-bottom: 20px;'>
                        <h2 style='color: #14204d; margin: 0;'>{$c_name}</h2>
                        <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Security & Two-Factor Authentication</p>
                    </div>
                    <p style='font-size: 15px; color: #1e293b;'>Hello,</p>
                    <p style='font-size: 14px; color: #334155;'>Here is your Two-Factor Authentication OTP code to verify your mobile number:</p>
                    <div style='background: #f8fafc; border: 2px dashed #2563eb; border-radius: 10px; padding: 18px; text-align: center; margin: 20px 0;'>
                        <span style='font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;'>Verification OTP</span>
                        <div style='font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #1e3a8a; font-family: monospace; margin-top: 6px;'>{$otp}</div>
                        <p style='font-size: 12px; color: #64748b; margin: 6px 0 0;'>Valid for 10 minutes.</p>
                    </div>
                    <p style='font-size: 12px; color: #94a3b8; text-align: center;'>© " . date('Y') . " {$c_name}. All rights reserved.</p>
                </div>";
                $m_sender = new Email_Send($user_email, $mail_subj, $mail_html, '2fa_otp');
                $email_sent = $m_sender->send_email();
            } catch (\Throwable $emEx) {}
        }

        $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
        $Advance_Security_obj = new Advance_Security();
        $otp_encrypt = $Advance_Security_obj->get_data_encrypt($Advance_Security_Key_List_obj->get_two_step_varification(), $otp);

        $_SESSION['otp_encrypt'] = $otp_encrypt;

        $state['error'] = "0";
        $state['otp']   = $otp_encrypt;

        if ($sms_sent && $email_sent) {
            $state['message'] = "OTP sent to your phone ($phone_number) and email ($user_email).";
        } elseif ($sms_sent) {
            $state['message'] = "OTP sent to your phone ($phone_number).";
        } elseif ($email_sent) {
            $state['message'] = "OTP sent to your registered email ($user_email). (SMS delivery is delayed).";
        } else {
            $state['message'] = "OTP generated successfully. Please check your phone / email.";
        }

        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    /* ================= CHECK OTP ================= */
    if (isset($_POST['setting_enable_disable_otp_check'])) {

        $otp_encrypt = $_POST['val_01'] ?? ($_SESSION['otp_encrypt'] ?? "");
        $user_otp    = trim($_POST['val_02'] ?? "");
        $email       = trim($_POST['val_03'] ?? ($_SESSION['user_name'] ?? ""));
        $phone_input = trim($_POST['phone_number'] ?? "");

        $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
        $Advance_Security_obj = new Advance_Security();

        $otp = $Advance_Security_obj->get_data_decrypt(
            $Advance_Security_Key_List_obj->get_two_step_varification(),
            $otp_encrypt
        );

        if ((string)$otp === (string)$user_otp && !empty($user_otp)) {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $session_uid = (int)($_SESSION['user_id'] ?? 0);

            // Update 2FA status and phone number
            $is_enable = isset($_POST['want_enable']) ? 1 : (isset($_POST['want_disable']) ? 0 : 1);
            if ($session_uid > 0) {
                $phoneSql = !empty($phone_input) ? ", `phone_number` = '" . mysqli_real_escape_string($conn, $phone_input) . "'" : "";
                $conn->query("UPDATE `main_user_login` SET `is_two_factor_auth_enable` = {$is_enable} {$phoneSql} WHERE `id` = {$session_uid}");
                if (!empty($phone_input)) {
                    $conn->query("UPDATE `employee_profiles` SET `phone` = '" . mysqli_real_escape_string($conn, $phone_input) . "' WHERE `user_id` = {$session_uid}");
                }
            } elseif (!empty($email)) {
                $safeEmail = mysqli_real_escape_string($conn, $email);
                $phoneSql = !empty($phone_input) ? ", `phone_number` = '" . mysqli_real_escape_string($conn, $phone_input) . "'" : "";
                $conn->query("UPDATE `main_user_login` SET `is_two_factor_auth_enable` = {$is_enable} {$phoneSql} WHERE `user_name` = '{$safeEmail}'");
            }

            $state['error']   = "0";
            $state['message'] = "OTP-Verified-Successfully";
        } else {
            $state['error']   = "1";
            $state['message'] = "Invalid or expired OTP code.";
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
