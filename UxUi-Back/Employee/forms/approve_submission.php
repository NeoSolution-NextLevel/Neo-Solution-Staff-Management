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
        echo json_encode(['status' => 'error', 'message' => 'This staff submission has already been approved.']);
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

    // Super Admin Decisions: Role, Department, and Job Title
    $assigned_role = isset($_POST['assigned_role']) && in_array(trim($_POST['assigned_role']), ['Admin', 'Employee']) 
        ? trim($_POST['assigned_role']) 
        : 'Employee';
    $assigned_dept = isset($_POST['assigned_department']) && !empty(trim($_POST['assigned_department'])) 
        ? trim($_POST['assigned_department']) 
        : ($department !== 'Unassigned' ? $department : 'Engineering');
    $assigned_job  = isset($_POST['assigned_job_title']) && !empty(trim($_POST['assigned_job_title'])) 
        ? trim($_POST['assigned_job_title']) 
        : ($assigned_role === 'Admin' ? 'Administrator' : ($job_title !== 'Staff' ? $job_title : 'Staff'));

    $isAdminAccount = ($assigned_role === 'Admin');
    // access level: 2 is Admin, 3 is Employee (1 is Super Admin)
    $access_level_id = $isAdminAccount ? 2 : 3;
    $ac_type_val = $isAdminAccount ? 'Admin' : 'Employee';

    $safe_email  = addslashes($email);
    $safe_name   = addslashes($full_name);
    $safe_first  = addslashes($first_name);
    $safe_last   = addslashes($last_name);
    $safe_phone  = addslashes($phone);
    $safe_dept   = addslashes($assigned_dept);
    $safe_job    = addslashes($assigned_job);
    $safe_nic    = addslashes($nic);
    $safe_dob    = !empty($dob) ? "'" . addslashes($dob) . "'" : "NULL";
    $safe_gender = addslashes($gender);
    $safe_addr   = addslashes($address);
    $safe_em_n   = addslashes($em_name);
    $safe_em_p   = addslashes($em_phone);

    // Both Admin and Staff accounts are directly verified & activated upon Admin approval
    $user_id = 0;
    $chk_u = $conn->query("SELECT id FROM `main_user_login` WHERE `user_name` = '{$safe_email}' LIMIT 1");
    if ($chk_u && ($u_row = $chk_u->fetch_assoc())) {
        $user_id = (int)$u_row['id'];
        $conn->query("UPDATE `main_user_login` SET 
            `phone_number` = '{$safe_phone}', 
            `password` = '{$pwd_hash}', 
            `account_active_state` = 1, 
            `moible_verfiy` = 1, 
            `email_verify` = 1,
            `name_show` = '{$safe_name}',
            `first_name` = '{$safe_first}',
            `last_name` = '{$safe_last}',
            `main_user_account_access_level_list_id` = {$access_level_id},
            `ac_type` = '{$ac_type_val}',
            `ast` = 1
        WHERE `id` = {$user_id}");
    } else {
        $prefix = $isAdminAccount ? 'ADM-' : 'EMP-';
        $ref_key = $prefix . str_pad($submission_id, 4, '0', STR_PAD_LEFT);

        $ins_u = "INSERT INTO `main_user_login` (
            `company_id`, `user_name`, `password`, `name_show`, `first_name`, `last_name`,
            `phone_number`, `ref_key`, `main_user_account_access_level_list_id`, `ac_type`,
            `account_active_state`, `email_verify`, `moible_verfiy`, `ast`, `sdt`
        ) VALUES (
            1, '{$safe_email}', '{$pwd_hash}', '{$safe_name}', '{$safe_first}', '{$safe_last}',
            '{$safe_phone}', '{$ref_key}', {$access_level_id}, '{$ac_type_val}',
            1, 1, 1, 1, NOW()
        )";
        if (!$conn->query($ins_u)) {
            ob_end_clean();
            echo json_encode(['status' => 'error', 'message' => 'Failed to create login account: ' . $conn->error]);
            exit;
        }
        $user_id = (int)$conn->insert_id;
    }

    if ($user_id <= 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Could not provision user login account.']);
        exit;
    }

    $id_code = ($isAdminAccount ? 'ADM-' : 'EMP-') . str_pad($user_id, 3, '0', STR_PAD_LEFT);
    $acc_status = 'active';

    // Create or update employee_profiles
    $default_roster = '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';
    $conn->query("INSERT INTO `employee_profiles` (
        `user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `status`, `join_date`,
        `nic`, `dob`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`,
        `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`, `weekly_roster`, `updated_at`
    ) VALUES (
        {$user_id}, '{$safe_name}', '{$safe_email}', '{$safe_phone}', '{$safe_dept}', '{$safe_job}', '{$acc_status}', CURDATE(),
        '{$safe_nic}', {$safe_dob}, '{$safe_gender}', '{$safe_addr}', '{$safe_em_n}', '{$safe_em_p}',
        '{$id_code}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri', '" . addslashes($default_roster) . "', NOW()
    ) ON DUPLICATE KEY UPDATE 
        `phone` = '{$safe_phone}', 
        `department` = '{$safe_dept}', 
        `job_title` = '{$safe_job}', 
        `status` = '{$acc_status}', 
        `nic` = '{$safe_nic}', 
        `address` = '{$safe_addr}', 
        `employee_id_code` = '{$id_code}',
        `updated_at` = NOW()");

    // Create or update employees table
    $conn->query("INSERT INTO `employees` (
        `fullname`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`, `main_user_login_id`
    ) VALUES (
        '{$safe_name}', '{$safe_email}', '{$safe_dept}', '{$safe_job}', '{$acc_status}', CURDATE(), {$user_id}
    ) ON DUPLICATE KEY UPDATE `status` = '{$acc_status}', `departments` = '{$safe_dept}', `job_roles` = '{$safe_job}'");

    // Default bank details
    $chk_bank = $conn->query("SELECT id FROM `bank_details` WHERE `user_id` = {$user_id} LIMIT 1");
    if (!$chk_bank || $chk_bank->num_rows === 0) {
        $conn->query("INSERT INTO `bank_details` (`user_id`, `employee_id`, `employee_name`, `holder_name`, `status`, `ast`, `sdt`) 
            VALUES ({$user_id}, '{$id_code}', '{$safe_name}', '{$safe_name}', 'Active', '1', NOW())");
    }

    // Update submission record with approved status, assigned role/dept, and mark verified
    $safe_notes = addslashes($admin_notes);
    if (!$conn->query("UPDATE `employee_form_submissions` SET
        `status` = 'approved',
        `department` = '{$safe_dept}',
        `job_title` = '{$safe_job}',
        `reviewed_by` = {$admin_id},
        `reviewed_at` = NOW(),
        `admin_notes` = '{$safe_notes}',
        `is_otp_verified` = 1,
        `otp_verified_at` = NOW(),
        `created_user_id` = {$user_id}
    WHERE `id` = {$submission_id} AND `status` = 'pending'")) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Failed to save approval details: ' . $conn->error]);
        exit;
    }

    $comp_obj = new Company_Info_Variable_List();
    $comp_name = $comp_obj->get_compnay_name();
    $login_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/User-Login.php';

    $email_sent = false;
    $email_error = '';

    // Send Approval & Activation Confirmation Email to the user with direct login link
    try {
        $role_label_display = $isAdminAccount ? 'Administrator' : 'Staff Member';
        $badge_color = $isAdminAccount ? '#7c3aed' : '#2563eb';
        $badge_bg = $isAdminAccount ? '#f3e8ff' : '#eff6ff';

        $mail_subject = "Account Approved & Activated - Welcome to {$comp_name}";
        $mail_body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid {$badge_color};'>
                <h2 style='color: #14204d; margin: 0 0 6px;'>{$comp_name}</h2>
                <span style='background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 700;'>
                    Account Approved &amp; Verified
                </span>
            </div>
            
            <p style='font-size: 15px; color: #1e293b; line-height: 1.6;'>Dear <strong>{$full_name}</strong>,</p>
            <p style='font-size: 15px; color: #1e293b; line-height: 1.6;'>
                Your application has been reviewed and directly approved by the Administration. Your email address has been verified and your portal account is now <strong>active</strong>.
            </p>

            <div style='background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; margin: 20px 0;'>
                <div style='font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 10px;'>Your Account Details:</div>
                <div style='font-size: 14px; color: #0f172a; margin-bottom: 6px;'><strong>Username / Email:</strong> <span style='color: #2563eb; font-weight: 700;'>{$email}</span></div>
                <div style='font-size: 14px; color: #0f172a; margin-bottom: 6px;'><strong>Account ID:</strong> <span style='font-family: monospace; font-weight: 700; color: #0f172a;'>{$id_code}</span></div>
                <div style='font-size: 14px; color: #0f172a; margin-bottom: 6px;'><strong>Assigned Role:</strong> <span style='background: {$badge_bg}; color: {$badge_color}; padding: 2px 8px; border-radius: 6px; font-weight: 700; font-size: 12.5px;'>{$role_label_display}</span></div>
                <div style='font-size: 14px; color: #0f172a; margin-bottom: 6px;'><strong>Department:</strong> <span style='font-weight: 600;'>{$assigned_dept}</span></div>
                <div style='font-size: 14px; color: #0f172a;'><strong>Job Title / Designation:</strong> <span style='font-weight: 600;'>{$assigned_job}</span></div>
            </div>

            <p style='font-size: 14px; color: #334155; line-height: 1.5;'>
                You can now log in directly using your registered email and the password you created during sign-up:
            </p>

            <div style='text-align: center; margin: 28px 0;'>
                <a href='{$login_url}' style='background: {$badge_color}; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; display: inline-block; box-shadow: 0 4px 12px rgba(37,99,235,0.25);'>
                    Sign In to Portal
                </a>
            </div>

            <p style='font-size: 12px; color: #64748b; text-align: center;'>
                Portal link: <a href='{$login_url}' style='color: #2563eb;'>{$login_url}</a>
            </p>

            <div style='margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #94a3b8; text-align: center;'>
                © " . date('Y') . " {$comp_name}. All rights reserved.
            </div>
        </div>";

        $sender = new Email_Send($email, $mail_subject, $mail_body, 'staff_direct_approved');
        $email_sent = $sender->send_email();
        if (!$email_sent) {
            $email_error = $sender->get_last_error();
        }
    } catch (\Throwable $mEx) {
        $email_error = $mEx->getMessage();
    }

    // Optional SMS notification confirming immediate approval
    if (!empty($phone)) {
        try {
            $sms_msg = "Hello {$first_name}, your {$comp_name} account has been approved and activated by the administrator. You can now log in directly at {$login_url}";
            $sms_obj = new SMS_Sending($phone, $sms_msg);
            $sms_obj->send_message();
        } catch (\Throwable $sEx) {}
    }

    ob_end_clean();
    $roleLabel = $isAdminAccount ? 'Administrator' : 'Staff';
    $message = "Application approved and email verified! Account is active immediately as {$roleLabel} ({$assigned_dept} - {$assigned_job}). Confirmation email sent with login link.";

    echo json_encode([
        'status' => 'success',
        'message' => $message,
        'data' => [
            'submission_id' => $submission_id,
            'user_id' => $user_id,
            'role' => $roleLabel,
            'department' => $assigned_dept,
            'job_title' => $assigned_job,
            'id_code' => $id_code,
            'email' => $email,
            'phone' => $phone,
            'email_sent' => $email_sent,
            'email_error' => $email_error
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
