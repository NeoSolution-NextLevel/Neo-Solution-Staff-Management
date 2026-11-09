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
    include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
    include_once __DIR__ . '/../../../imports/security/key_list.php';

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

    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $safe_email = addslashes($email);

    $matched = false;
    $u_id = 0;
    $user_name = $email;
    $full_name = '';
    $user_role = 'Employee';
    $ac_type = 'Employee';
    $access_level_id = 3;
    $department = 'Administration';
    $job_title = 'Staff';
    $phone_number = '';

    // 1. Try employee_form_submissions
    $whereClause = $sub_id > 0 
        ? "`id` = {$sub_id}" 
        : (!empty($safe_email) ? "`email` = '{$safe_email}' ORDER BY `id` DESC LIMIT 1" : "0");

    if ($whereClause !== "0") {
        $sub_res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE {$whereClause}");
        if ($sub_res && $sub_res->num_rows > 0) {
            $sub = $sub_res->fetch_assoc();
            $stored_otp = trim((string)($sub['otp_code'] ?? ''));

            if (!empty($stored_otp) && $stored_otp === trim($otp_code)) {
                // Check expiry
                if (!empty($sub['otp_expires_at']) && strtotime($sub['otp_expires_at']) < time()) {
                    ob_end_clean();
                    echo json_encode(['status' => 'error', 'message' => 'This OTP verification code has expired. Please click "Resend OTP" to receive a new code.']);
                    exit;
                }

                $matched = true;
                $u_id = (int)($sub['created_user_id'] ?? 0);
                $user_name = $sub['email'];
                $full_name = trim(($sub['first_name'] ?? '') . ' ' . ($sub['last_name'] ?? ''));
                $department = $sub['department'] ?? 'Administration';
                $job_title = $sub['job_title'] ?? 'Staff';
                $phone_number = $sub['phone_number'] ?? '';

                $sub_id_found = (int)$sub['id'];
                $conn->query("UPDATE `employee_form_submissions` SET 
                    `is_otp_verified` = 1, 
                    `otp_verified_at` = NOW() 
                WHERE `id` = {$sub_id_found}");
            }
        }
    }

    // 2. Try main_user_login (direct OTP code or fallback)
    if (!$matched) {
        $userWhere = !empty($safe_email) ? "`user_name` = '{$safe_email}'" : ($u_id > 0 ? "`id` = {$u_id}" : "0");
        if ($userWhere !== "0") {
            $uQ = $conn->query("SELECT * FROM `main_user_login` WHERE {$userWhere} LIMIT 1");
            if ($uQ && ($uRow = $uQ->fetch_assoc())) {
                $stored_otp = trim((string)($uRow['otp_code'] ?? ''));
                if (!empty($stored_otp) && $stored_otp === trim($otp_code)) {
                    if (!empty($uRow['otp_expires_at']) && strtotime($uRow['otp_expires_at']) < time()) {
                        ob_end_clean();
                        echo json_encode(['status' => 'error', 'message' => 'This OTP verification code has expired. Please click "Resend OTP" to receive a new code.']);
                        exit;
                    }

                    $matched = true;
                    $u_id = (int)$uRow['id'];
                    $user_name = $uRow['user_name'];
                    $full_name = !empty($uRow['name_show']) ? $uRow['name_show'] : trim(($uRow['first_name'] ?? '') . ' ' . ($uRow['last_name'] ?? ''));
                    $user_role = $uRow['ac_type'] ?? 'Employee';
                    $ac_type = $user_role;
                    $access_level_id = (int)($uRow['main_user_account_access_level_list_id'] ?? 3);
                    $phone_number = $uRow['phone_number'] ?? '';
                }
            }
        }
    }

    // 3. Try decrypting session OTP (2FA flow)
    if (!$matched && !empty($_SESSION['otp_encrypt'])) {
        try {
            $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
            $Advance_Security_obj = new Advance_Security();
            $decrypted_otp = $Advance_Security_obj->get_data_decrypt(
                $Advance_Security_Key_List_obj->get_two_step_varification(),
                $_SESSION['otp_encrypt']
            );

            if ((string)$decrypted_otp === (string)$otp_code) {
                $matched = true;
                $session_uid = (int)($_SESSION['temp_otp_user_id'] ?? ($_SESSION['user_id'] ?? 0));
                if ($session_uid > 0) {
                    $uQ = $conn->query("SELECT * FROM `main_user_login` WHERE `id` = {$session_uid} LIMIT 1");
                    if ($uQ && ($uRow = $uQ->fetch_assoc())) {
                        $u_id = (int)$uRow['id'];
                        $user_name = $uRow['user_name'];
                        $full_name = !empty($uRow['name_show']) ? $uRow['name_show'] : trim(($uRow['first_name'] ?? '') . ' ' . ($uRow['last_name'] ?? ''));
                        $user_role = $uRow['ac_type'] ?? 'Employee';
                        $ac_type = $user_role;
                        $access_level_id = (int)($uRow['main_user_account_access_level_list_id'] ?? 3);
                        $phone_number = $uRow['phone_number'] ?? '';
                    }
                }
            }
        } catch (\Throwable $e) {}
    }

    if (!$matched) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP verification code. Please check your email / SMS and enter the 6-digit code correctly.']);
        exit;
    }

    // Activate user in main_user_login
    if ($u_id <= 0 && !empty($user_name)) {
        $chk_user = $conn->query("SELECT id FROM `main_user_login` WHERE `user_name` = '" . addslashes($user_name) . "' LIMIT 1");
        if ($chk_user && ($ur = $chk_user->fetch_assoc())) {
            $u_id = (int)$ur['id'];
        }
    }

    if ($u_id > 0) {
        $conn->query("UPDATE `main_user_login` SET 
            `account_active_state` = 1, 
            `moible_verfiy` = 1, 
            `email_verify` = 1, 
            `ast` = 1,
            `otp_code` = NULL,
            `otp_expires_at` = NULL
        WHERE `id` = {$u_id}");

        $conn->query("UPDATE `employee_profiles` SET `status` = 'active', `updated_at` = NOW() WHERE `user_id` = {$u_id}");
        $conn->query("UPDATE `employees` SET `status` = 'active' WHERE `main_user_login_id` = {$u_id}");

        // Auto login session setup
        $_SESSION['user_id'] = $u_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['name_show'] = $full_name;
        $_SESSION['full_name'] = $full_name;
        $_SESSION['user_role'] = $user_role;
        $_SESSION['ac_type'] = $ac_type;
        $_SESSION['main_user_account_access_level_list_id'] = $access_level_id;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['department'] = $department;
        $_SESSION['job_title'] = $job_title;

        $isAdmin = (strtolower((string)$user_role) === 'admin' || strtolower((string)$ac_type) === 'admin' || $access_level_id === 2 || $access_level_id === 1 || $u_id === 1);
        $url_home = ($isAdmin && ($access_level_id === 1 || $u_id === 1)) ? 'UxUi/Super_Admin_user_dashboard.php' : ($isAdmin ? 'UxUi/Admin_user_dashboard.php' : 'UxUi/Employee_user_dashboard.php');
        $_SESSION['url_home'] = $url_home;

        // Initialize persistent cook session
        try {
            $cookObj = new Cook_Createing($u_id);
            $_SESSION['user_main_cook_id'] = $cookObj->get_cook_id();
        } catch (\Throwable $cEx) {}

        unset($_SESSION['otp_pending'], $_SESSION['temp_otp_user_id'], $_SESSION['temp_otp_email'], $_SESSION['otp_encrypt']);
    }

    $isAdmin = (strtolower((string)$user_role) === 'admin' || strtolower((string)$ac_type) === 'admin' || $access_level_id === 2 || $access_level_id === 1 || $u_id === 1);
    $dashboard_url = rtrim($GLOBALS['home_page'], '/') . '/' . (($isAdmin && ($access_level_id === 1 || $u_id === 1)) ? 'UxUi/Super_Admin_user_dashboard.php' : ($isAdmin ? 'UxUi/Admin_user_dashboard.php' : 'UxUi/Employee_user_dashboard.php'));
    $success_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/Successful-Page.php?message=' . urlencode("Account-Verified-Successfully");

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Congratulations! Your account has been verified and activated.',
        'data' => [
            'user_id' => $u_id,
            'email' => $user_name,
            'full_name' => $full_name,
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
