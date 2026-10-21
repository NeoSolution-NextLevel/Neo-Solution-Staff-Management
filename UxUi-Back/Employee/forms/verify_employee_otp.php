<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../imports/need/auth_guard.php';
    include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Createing.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $email    = isset($_POST['email']) && !empty($_POST['email']) 
        ? trim($_POST['email']) 
        : (isset($_SESSION['temp_otp_email']) && !empty($_SESSION['temp_otp_email']) 
            ? trim($_SESSION['temp_otp_email']) 
            : (isset($_SESSION['user_name']) ? trim($_SESSION['user_name']) : ''));
    $otp_code = isset($_POST['otp_code']) ? trim($_POST['otp_code']) : (isset($_POST['otp']) ? trim($_POST['otp']) : '');
    $sub_id   = isset($_POST['submission_id']) ? (int)$_POST['submission_id'] : 0;

    if (empty($otp_code)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Please enter the 6-digit OTP verification code.']);
        exit;
    }

    if (empty($email) && $sub_id <= 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Email address or application reference is required.']);
        exit;
    }

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Query submission
    $safe_email = addslashes($email);
    $whereClause = $sub_id > 0 
        ? "`id` = {$sub_id}" 
        : "`email` = '{$safe_email}' ORDER BY `id` DESC LIMIT 1";

    $sub_res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE {$whereClause}");
    if (!$sub_res || $sub_res->num_rows === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'No registration submission found for this email address.']);
        exit;
    }

    $sub = $sub_res->fetch_assoc();

    // Check status
    if ($sub['status'] === 'pending') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Your application has not yet been approved by the Administration. Once approved, you will receive an OTP code to verify your account.']);
        exit;
    }

    if ($sub['status'] === 'rejected') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'This application was not approved by administration.']);
        exit;
    }

    if ((int)$sub['is_otp_verified'] === 1) {
        // Already verified - allow immediate login
        $u_id = (int)$sub['created_user_id'];
        if ($u_id > 0) {
            $conn->query("UPDATE `main_user_login` SET `account_active_state` = 1, `moible_verfiy` = 1, `ast` = 1 WHERE `id` = {$u_id}");
        }

        ob_end_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Your account is already verified! You can proceed to the login portal.',
            'already_verified' => true,
            'redirect_url' => rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/User-Login.php'
        ]);
        exit;
    }

    // Verify OTP code
    $stored_otp = trim((string)$sub['otp_code']);
    $entered_otp = trim((string)$otp_code);

    if ($stored_otp !== $entered_otp) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP verification code. Please check your SMS and enter the 6-digit code correctly.']);
        exit;
    }

    // Check OTP expiration (if set)
    if (!empty($sub['otp_expires_at']) && strtotime($sub['otp_expires_at']) < time()) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'This OTP verification code has expired. Please click "Resend OTP" to receive a new code.']);
        exit;
    }

    // Mark verified in employee_form_submissions
    $sub_id_found = (int)$sub['id'];
    $conn->query("UPDATE `employee_form_submissions` SET 
        `is_otp_verified` = 1, 
        `otp_verified_at` = NOW() 
    WHERE `id` = {$sub_id_found}");

    // Activate in main_user_login
    $u_id = (int)$sub['created_user_id'];
    if ($u_id <= 0) {
        $chk_user = $conn->query("SELECT id FROM `main_user_login` WHERE `user_name` = '{$safe_email}' LIMIT 1");
        if ($chk_user && ($ur = $chk_user->fetch_assoc())) {
            $u_id = (int)$ur['id'];
        }
    }

    if ($u_id > 0) {
        $conn->query("UPDATE `main_user_login` SET 
            `account_active_state` = 1, 
            `moible_verfiy` = 1, 
            `email_verify` = 1, 
            `ast` = 1 
        WHERE `id` = {$u_id}");

        $conn->query("UPDATE `employee_profiles` SET `status` = 'active', `updated_at` = NOW() WHERE `user_id` = {$u_id}");
        $conn->query("UPDATE `employees` SET `status` = 'active' WHERE `main_user_login_id` = {$u_id}");

        // Auto login session setup
        $_SESSION['user_id'] = $u_id;
        $_SESSION['user_name'] = $sub['email'];
        $_SESSION['name_show'] = trim($sub['first_name'] . ' ' . $sub['last_name']);
        $_SESSION['full_name'] = trim($sub['first_name'] . ' ' . $sub['last_name']);
        $_SESSION['first_name'] = $sub['first_name'];
        $_SESSION['last_name'] = $sub['last_name'];
        $_SESSION['user_role'] = 'Employee';
        $_SESSION['ac_type'] = 'Employee';
        $_SESSION['main_user_account_access_level_list_id'] = 2;
        $_SESSION['phone_number'] = $sub['phone_number'];
        $_SESSION['department'] = $sub['department'];
        $_SESSION['job_title'] = $sub['job_title'];
        $_SESSION['url_home'] = 'UxUi/Employee_user_dashboard.php';

        // Load profile extra details
        $chkP = $conn->query("SELECT id, employee_id_code, profile_pic FROM `employee_profiles` WHERE `user_id` = {$u_id} LIMIT 1");
        if ($chkP && ($pRow = $chkP->fetch_assoc())) {
            $_SESSION['employee_profile_id'] = (int)$pRow['id'];
            $_SESSION['employee_id_code'] = $pRow['employee_id_code'];
            if (!empty($pRow['profile_pic'])) {
                $_SESSION['profile_pic'] = $pRow['profile_pic'];
                $_SESSION['image_url'] = $pRow['profile_pic'];
            }
        }

        // Initialize persistent cook session
        try {
            $cookObj = new Cook_Createing($u_id);
            $_SESSION['user_main_cook_id'] = $cookObj->get_cook_id();
        } catch (\Throwable $cEx) {}

        unset($_SESSION['otp_pending'], $_SESSION['temp_otp_user_id'], $_SESSION['temp_otp_email']);
    }

    $dashboard_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Employee_user_dashboard.php';
    $success_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/Successful-Page.php?message=' . urlencode("Account-Verified-Successfully");

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Congratulations! Your mobile contact number has been verified and your account is now fully active.',
        'data' => [
            'user_id' => $u_id,
            'email' => $sub['email'],
            'full_name' => trim($sub['first_name'] . ' ' . $sub['last_name']),
            'redirect_url' => $success_url,
            'dashboard_url' => $dashboard_url
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
