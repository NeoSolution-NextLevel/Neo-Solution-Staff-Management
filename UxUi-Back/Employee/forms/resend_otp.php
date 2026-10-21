<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../imports/sms/SMS_Sending.php';
    include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';

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
    $whereClause = $sub_id > 0 ? "`id` = {$sub_id}" : "`email` = '{$safe_email}' ORDER BY `id` DESC LIMIT 1";

    $sub_res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE {$whereClause}");
    if (!$sub_res || $sub_res->num_rows === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Submission not found.']);
        exit;
    }

    $sub = $sub_res->fetch_assoc();

    if ($sub['status'] !== 'approved') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'OTP can only be dispatched for approved applications.']);
        exit;
    }

    $new_otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    $sub_id_found = (int)$sub['id'];

    $conn->query("UPDATE `employee_form_submissions` SET 
        `otp_code` = '{$new_otp}',
        `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 24 HOUR)
    WHERE `id` = {$sub_id_found}");

    $phone = trim($sub['phone_number']);
    $comp_obj = new Company_Info_Variable_List();
    $comp_name = $comp_obj->get_compnay_name();

    $sms_sent = false;
    $sms_error = '';
    try {
        $sms_msg = "Your {$comp_name} verification code is: {$new_otp}. Enter this OTP to verify and activate your employee account.";
        $sms_obj = new SMS_Sending($phone, $sms_msg);
        $sms_obj->send_message();
        $sms_sent = true;
    } catch (\Throwable $sEx) {
        $sms_error = $sEx->getMessage();
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'A new 6-digit OTP verification code has been dispatched to your contact number.',
        'data' => [
            'phone' => $phone,
            'sms_sent' => $sms_sent,
            'sms_error' => $sms_error
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
