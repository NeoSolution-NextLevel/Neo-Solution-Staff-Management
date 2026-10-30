<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../imports/sms/SMS_Sending.php';
    include_once __DIR__ . '/../../../imports/email/Email_Send.php';
    include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';
    include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
    include_once __DIR__ . '/../../../imports/security/key_list.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $email  = isset($_POST['email']) && !empty($_POST['email']) 
        ? trim($_POST['email']) 
        : (isset($_SESSION['temp_otp_email']) && !empty($_SESSION['temp_otp_email']) 
            ? trim($_SESSION['temp_otp_email']) 
            : (isset($_SESSION['user_name']) ? trim($_SESSION['user_name']) : ''));
    $sub_id = isset($_POST['submission_id']) ? (int)$_POST['submission_id'] : 0;

    if (empty($email) && $sub_id <= 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Email address is required to resend OTP.']);
        exit;
    }

    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $safe_email = addslashes($email);

    $new_otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    $phone = '';
    $user_id_found = 0;
    $target_name = 'User';

    // 1. Try locating in employee_form_submissions
    $whereClause = $sub_id > 0 ? "`id` = {$sub_id}" : "`email` = '{$safe_email}' ORDER BY `id` DESC LIMIT 1";
    $sub_res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE {$whereClause}");

    if ($sub_res && $sub_res->num_rows > 0) {
        $sub = $sub_res->fetch_assoc();
        $sub_id_found = (int)$sub['id'];
        $phone = trim($sub['phone_number'] ?? '');
        $target_name = trim(($sub['first_name'] ?? '') . ' ' . ($sub['last_name'] ?? ''));
        $user_id_found = (int)($sub['created_user_id'] ?? 0);

        $conn->query("UPDATE `employee_form_submissions` SET 
            `otp_code` = '{$new_otp}',
            `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 24 HOUR)
        WHERE `id` = {$sub_id_found}");
    }

    // 2. Also locate/update in main_user_login
    $u_res = $conn->query("SELECT id, user_name, name_show, first_name, last_name, phone_number FROM `main_user_login` WHERE `user_name` = '{$safe_email}' OR `id` = {$user_id_found} LIMIT 1");
    if ($u_res && ($uRow = $u_res->fetch_assoc())) {
        $user_id_found = (int)$uRow['id'];
        if (empty($phone) && !empty($uRow['phone_number'])) {
            $phone = trim($uRow['phone_number']);
        }
        if (empty($target_name) || $target_name === 'User') {
            $target_name = !empty($uRow['name_show']) ? $uRow['name_show'] : trim(($uRow['first_name'] ?? '') . ' ' . ($uRow['last_name'] ?? ''));
        }

        $conn->query("UPDATE `main_user_login` SET 
            `otp_code` = '{$new_otp}', 
            `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 24 HOUR) 
        WHERE `id` = {$user_id_found}");
    }

    if (empty($target_name)) {
        $target_name = $email;
    }

    // Save temporary verification session
    $_SESSION['temp_otp_email'] = $email;
    if ($user_id_found > 0) {
        $_SESSION['temp_otp_user_id'] = $user_id_found;
    }

    // Encrypt for 2FA session compatibility
    try {
        $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
        $Advance_Security_obj = new Advance_Security();
        $otp_encrypt = $Advance_Security_obj->get_data_encrypt($Advance_Security_Key_List_obj->get_two_step_varification(), $new_otp);
        $_SESSION['otp_encrypt'] = $otp_encrypt;
    } catch (\Throwable $secEx) {}

    $comp_obj = new Company_Info_Variable_List();
    $comp_name = $comp_obj->get_compnay_name();

    // 3. Dispatch Email with OTP (Primary & Reliable Delivery)
    $email_sent = false;
    $email_error = '';
    try {
        if (!empty($email)) {
            $mail_subj = "Your Account Verification OTP Code - {$comp_name}";
            $mail_html = "
            <div style='font-family: Arial, sans-serif; max-width: 580px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                <div style='text-align: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 2px solid #2563eb;'>
                    <h2 style='color: #14204d; margin: 0;'>{$comp_name}</h2>
                    <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Staff Portal Verification</p>
                </div>
                <p style='font-size: 15px; color: #1e293b;'>Hello <strong>" . htmlspecialchars($target_name) . "</strong>,</p>
                <p style='font-size: 14px; color: #334155;'>Here is your requested 6-digit verification OTP code:</p>
                <div style='background: #f8fafc; border: 2px dashed #2563eb; border-radius: 10px; padding: 20px; text-align: center; margin: 20px 0;'>
                    <span style='font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;'>Verification OTP Code</span>
                    <div style='font-size: 34px; font-weight: 800; letter-spacing: 8px; color: #1e3a8a; font-family: monospace; margin-top: 6px;'>{$new_otp}</div>
                    <p style='font-size: 12px; color: #64748b; margin: 8px 0 0;'>Valid for 24 hours. Enter this code on the verification page.</p>
                </div>
                <p style='font-size: 12px; color: #94a3b8; text-align: center;'>© " . date('Y') . " {$comp_name}. All rights reserved.</p>
            </div>";
            $m_sender = new Email_Send($email, $mail_subj, $mail_html, 'resend_otp');
            $email_sent = $m_sender->send_email();
            if (!$email_sent) {
                $email_error = $m_sender->get_last_error();
            }
        }
    } catch (\Throwable $emEx) {
        $email_error = $emEx->getMessage();
    }

    // 4. Dispatch SMS
    $sms_sent = false;
    $sms_error = '';
    if (!empty($phone)) {
        try {
            $sms_msg = "Your {$comp_name} verification code is: {$new_otp}. Enter this OTP to verify your account.";
            $sms_obj = new SMS_Sending($phone, $sms_msg);
            $sms_obj->send_message();
            if ($sms_obj->get_last_http_code() === 200) {
                $sms_sent = true;
            }
        } catch (\Throwable $sEx) {
            $sms_error = $sEx->getMessage();
        }
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => "A new 6-digit OTP verification code has been dispatched to your email inbox ({$email})" . (!empty($phone) ? " and phone ({$phone})." : "."),
        'data' => [
            'email' => $email,
            'phone' => $phone,
            'email_sent' => $email_sent,
            'email_error' => $email_error,
            'sms_sent' => $sms_sent
        ]
    ]);
    exit;

} catch (\Throwable $e) {
    ob_end_clean();
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error: ' . $e->getMessage()
    ]);
    exit;
}
