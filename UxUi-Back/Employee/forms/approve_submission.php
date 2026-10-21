<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../imports/email/Email_Send.php';
    include_once __DIR__ . '/../../../imports/sms/SMS_Sending.php';
    include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';

    // Verify Admin authentication
    if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
        exit;
    }

    $role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';
    $ac_type = isset($_SESSION['ac_type']) ? strtolower($_SESSION['ac_type']) : '';
    if (strpos($role, 'admin') === false && strpos($ac_type, 'admin') === false && strpos($role, 'super') === false) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Administrator privileges required.']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $submission_id = isset($_POST['submission_id']) ? (int)$_POST['submission_id'] : 0;
    if ($submission_id <= 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Valid submission ID is required.']);
        exit;
    }

    $admin_id = (int)$_SESSION['user_id'];
    $admin_notes = isset($_POST['admin_notes']) ? trim($_POST['admin_notes']) : '';

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Fetch submission
    $sub_res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE `id` = {$submission_id} LIMIT 1");
    if (!$sub_res || $sub_res->num_rows === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Submission record not found.']);
        exit;
    }

    $sub = $sub_res->fetch_assoc();
    if ($sub['status'] === 'approved' && !empty($sub['created_user_id'])) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'This employee submission has already been approved.']);
        exit;
    }

    $email       = trim($sub['email']);
    $first_name  = trim($sub['first_name']);
    $last_name   = trim($sub['last_name']);
    $full_name   = trim($first_name . ' ' . $last_name);
    $phone       = trim($sub['phone_number']);
    $pwd_hash    = $sub['password_hash'];
    $department  = trim($sub['department']);
    $job_title   = trim($sub['job_title']);
    $nic         = trim($sub['nic']);
    $dob         = $sub['dob'];
    $gender      = trim($sub['gender'] ?: 'Male');
    $address     = trim($sub['address']);
    $em_name     = trim($sub['emergency_contact_name']);
    $em_phone    = trim($sub['emergency_contact_phone']);

    $safe_email  = addslashes($email);
    $safe_name   = addslashes($full_name);
    $safe_first  = addslashes($first_name);
    $safe_last   = addslashes($last_name);
    $safe_phone  = addslashes($phone);
    $safe_dept   = addslashes($department);
    $safe_job    = addslashes($job_title);
    $safe_nic    = addslashes($nic);
    $safe_dob    = !empty($dob) ? "'" . addslashes($dob) . "'" : "NULL";
    $safe_gender = addslashes($gender);
    $safe_addr   = addslashes($address);
    $safe_em_n   = addslashes($em_name);
    $safe_em_p   = addslashes($em_phone);

    // 1. Generate 6-digit OTP code
    $otp_code = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

    // 2. Create or update main_user_login record
    // Account is created in pending OTP verification state (account_active_state = 0, moible_verfiy = 0)
    $user_id = 0;
    $chk_u = $conn->query("SELECT id FROM `main_user_login` WHERE `user_name` = '{$safe_email}' LIMIT 1");
    if ($chk_u && ($u_row = $chk_u->fetch_assoc())) {
        $user_id = (int)$u_row['id'];
        $conn->query("UPDATE `main_user_login` SET 
            `phone_number` = '{$safe_phone}', 
            `password` = '{$pwd_hash}', 
            `account_active_state` = 0, 
            `moible_verfiy` = 0, 
            `email_verify` = 1,
            `name_show` = '{$safe_name}',
            `first_name` = '{$safe_first}',
            `last_name` = '{$safe_last}',
            `main_user_account_access_level_list_id` = 2,
            `ac_type` = 'Employee',
            `ast` = 1
        WHERE `id` = {$user_id}");
    } else {
        $ref_key = 'EMP-' . str_pad($submission_id, 4, '0', STR_PAD_LEFT);
        $ins_u = "INSERT INTO `main_user_login` (
            `company_id`, `user_name`, `password`, `name_show`, `first_name`, `last_name`,
            `phone_number`, `ref_key`, `main_user_account_access_level_list_id`, `ac_type`,
            `account_active_state`, `email_verify`, `moible_verfiy`, `ast`, `sdt`
        ) VALUES (
            1, '{$safe_email}', '{$pwd_hash}', '{$safe_name}', '{$safe_first}', '{$safe_last}',
            '{$safe_phone}', '{$ref_key}', 2, 'Employee',
            0, 1, 0, 1, NOW()
        )";
        if ($conn->query($ins_u)) {
            $user_id = (int)$conn->insert_id;
        }
    }

    if ($user_id <= 0) {
        $user_id = $submission_id;
    }

    $emp_code = 'EMP-' . str_pad($user_id, 3, '0', STR_PAD_LEFT);

    // 3. Create or update employee_profiles
    $default_roster = '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';
    $conn->query("INSERT INTO `employee_profiles` (
        `user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `status`, `join_date`,
        `nic`, `dob`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`,
        `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`, `weekly_roster`, `updated_at`
    ) VALUES (
        {$user_id}, '{$safe_name}', '{$safe_email}', '{$safe_phone}', '{$safe_dept}', '{$safe_job}', 'pending_verification', CURDATE(),
        '{$safe_nic}', {$safe_dob}, '{$safe_gender}', '{$safe_addr}', '{$safe_em_n}', '{$safe_em_p}',
        '{$emp_code}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri', '" . addslashes($default_roster) . "', NOW()
    ) ON DUPLICATE KEY UPDATE 
        `phone` = '{$safe_phone}', 
        `department` = '{$safe_dept}', 
        `job_title` = '{$safe_job}', 
        `status` = 'pending_verification', 
        `nic` = '{$safe_nic}', 
        `address` = '{$safe_addr}', 
        `updated_at` = NOW()");

    // 4. Create or update employees table
    $conn->query("INSERT INTO `employees` (
        `fullname`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`, `main_user_login_id`
    ) VALUES (
        '{$safe_name}', '{$safe_email}', '{$safe_dept}', '{$safe_job}', 'pending_verification', CURDATE(), {$user_id}
    ) ON DUPLICATE KEY UPDATE `status` = 'pending_verification', `departments` = '{$safe_dept}', `job_roles` = '{$safe_job}'");

    // 5. Default bank details
    $chk_bank = $conn->query("SELECT id FROM `bank_details` WHERE `user_id` = {$user_id} LIMIT 1");
    if (!$chk_bank || $chk_bank->num_rows === 0) {
        $conn->query("INSERT INTO `bank_details` (`user_id`, `employee_id`, `employee_name`, `holder_name`, `status`, `ast`, `sdt`) 
            VALUES ({$user_id}, '{$emp_code}', '{$safe_name}', '{$safe_name}', 'Active', '1', NOW())");
    }

    // 6. Update submission record with approved status and generated OTP
    $safe_notes = addslashes($admin_notes);
    $conn->query("UPDATE `employee_form_submissions` SET 
        `status` = 'approved',
        `reviewed_by` = {$admin_id},
        `reviewed_at` = NOW(),
        `admin_notes` = '{$safe_notes}',
        `otp_code` = '{$otp_code}',
        `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 24 HOUR),
        `is_otp_verified` = 0,
        `created_user_id` = {$user_id}
    WHERE `id` = {$submission_id}");

    // 7. Send Approval Email to Employee
    $comp_obj = new Company_Info_Variable_List();
    $comp_name = $comp_obj->get_compnay_name();

    $verify_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/Employee-Verify-OTP.php?email=' . urlencode($email);

    $email_sent = false;
    $email_error = '';
    try {
        $mail_subject = "Application Approved: Verify Your Account with OTP - {$comp_name}";
        $mail_body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #10b981;'>
                <h2 style='color: #14204d; margin: 0 0 6px;'>{$comp_name}</h2>
                <span style='background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 700;'>
                    Application Approved
                </span>
            </div>
            
            <p style='font-size: 15px; color: #1e293b; line-height: 1.6;'>Dear <strong>{$full_name}</strong>,</p>
            <p style='font-size: 15px; color: #1e293b; line-height: 1.6;'>
                We are pleased to inform you that your Employee Registration Form for <strong>{$department}</strong> ({$job_title}) has been reviewed and <strong>approved</strong> by the Administration.
            </p>

            <div style='background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; margin: 20px 0;'>
                <p style='margin: 0 0 8px; font-size: 14px; color: #166534; font-weight: 700;'>
                    <i class='fas fa-mobile-alt'></i> Verification OTP Dispatched:
                </p>
                <p style='margin: 0; font-size: 13.5px; color: #166534;'>
                    A 6-digit OTP verification code has been sent via SMS to your contact number <strong>{$phone}</strong>.
                    Please click the button below and enter your OTP to activate your account and access the staff dashboard.
                </p>
            </div>

            <div style='text-align: center; margin: 28px 0;'>
                <a href='{$verify_url}' style='background: #10b981; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: 700; font-size: 15px; display: inline-block; box-shadow: 0 4px 12px rgba(16,185,129,0.25);'>
                    Verify Account with OTP
                </a>
            </div>

            <p style='font-size: 13px; color: #64748b; line-height: 1.5;'>
                Verification Link:<br>
                <a href='{$verify_url}' style='color: #2563eb; word-break: break-all;'>{$verify_url}</a>
            </p>

            <div style='margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #94a3b8; text-align: center;'>
                Employee ID: <strong>{$emp_code}</strong> | Department: {$department}<br>
                © " . date('Y') . " {$comp_name}. All rights reserved.
            </div>
        </div>";

        $sender = new Email_Send($email, $mail_subject, $mail_body, 'employee_approved');
        $email_sent = $sender->send_email();
        if (!$email_sent) {
            $email_error = $sender->get_last_error();
        }
    } catch (\Throwable $mEx) {
        $email_error = $mEx->getMessage();
    }

    // 8. Send OTP to Employee Contact Number via SMS
    $sms_sent = false;
    $sms_error = '';
    try {
        $sms_msg = "Your {$comp_name} verification code is: {$otp_code}. Enter this OTP to verify and activate your employee account.";
        $sms_obj = new SMS_Sending($phone, $sms_msg);
        $sms_resp = $sms_obj->send_message();
        $sms_sent = true;
    } catch (\Throwable $sEx) {
        $sms_error = $sEx->getMessage();
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Employee registration approved successfully! Approval email sent and OTP dispatched to contact number.',
        'data' => [
            'submission_id' => $submission_id,
            'user_id' => $user_id,
            'employee_code' => $emp_code,
            'email' => $email,
            'phone' => $phone,
            'otp_code' => $otp_code,
            'email_sent' => $email_sent,
            'email_error' => $email_error,
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
