<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../imports/email/Email_Send.php';
    include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';
    include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
    include_once __DIR__ . '/../../../imports/security/key_list.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Ensure employee registration tables exist
    $conn->query("CREATE TABLE IF NOT EXISTS `employee_registration_forms` (
      `id` int NOT NULL AUTO_INCREMENT,
      `form_token` varchar(64) NOT NULL,
      `title` varchar(255) NOT NULL DEFAULT 'Employee Registration Form',
      `department` varchar(100) DEFAULT 'Engineering',
      `job_title` varchar(100) DEFAULT 'Staff',
      `target_email` varchar(255) DEFAULT NULL,
      `created_by` int NOT NULL DEFAULT 1,
      `status` varchar(30) DEFAULT 'active',
      `allow_multiple` tinyint(1) DEFAULT 1,
      `expires_at` datetime DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `unique_form_token` (`form_token`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $conn->query("CREATE TABLE IF NOT EXISTS `employee_form_submissions` (
      `id` int NOT NULL AUTO_INCREMENT,
      `form_id` int DEFAULT NULL,
      `form_token` varchar(64) DEFAULT NULL,
      `first_name` varchar(100) NOT NULL,
      `last_name` varchar(100) NOT NULL,
      `email` varchar(255) NOT NULL,
      `phone_number` varchar(50) NOT NULL,
      `password_hash` varchar(450) NOT NULL,
      `department` varchar(100) NOT NULL DEFAULT 'Engineering',
      `job_title` varchar(100) NOT NULL DEFAULT 'Staff',
      `nic` varchar(50) DEFAULT NULL,
      `dob` date DEFAULT NULL,
      `gender` varchar(20) DEFAULT 'Male',
      `address` text DEFAULT NULL,
      `emergency_contact_name` varchar(255) DEFAULT NULL,
      `emergency_contact_phone` varchar(50) DEFAULT NULL,
      `status` varchar(30) DEFAULT 'pending',
      `admin_notes` text DEFAULT NULL,
      `reviewed_by` int DEFAULT NULL,
      `reviewed_at` datetime DEFAULT NULL,
      `otp_code` varchar(10) DEFAULT NULL,
      `otp_expires_at` datetime DEFAULT NULL,
      `is_otp_verified` tinyint(1) DEFAULT 0,
      `otp_verified_at` datetime DEFAULT NULL,
      `created_user_id` int DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_form_token` (`form_token`),
      KEY `idx_email` (`email`),
      KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $form_token = isset($_POST['form_token']) ? trim($_POST['form_token']) : '';
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name  = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone      = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $password   = isset($_POST['password']) ? trim($_POST['password']) : '';
    $department = isset($_POST['department']) && trim($_POST['department']) !== '' ? trim($_POST['department']) : 'Unassigned';
    $job_title  = isset($_POST['job_title']) && trim($_POST['job_title']) !== '' ? trim($_POST['job_title']) : 'Staff';
    $nic        = isset($_POST['nic']) ? trim($_POST['nic']) : '';
    $dob        = isset($_POST['dob']) && !empty($_POST['dob']) ? trim($_POST['dob']) : null;
    $gender     = isset($_POST['gender']) ? trim($_POST['gender']) : 'Male';
    $address    = isset($_POST['address']) ? trim($_POST['address']) : '';
    $em_name    = isset($_POST['emergency_contact_name']) ? trim($_POST['emergency_contact_name']) : '';
    $em_phone   = isset($_POST['emergency_contact_phone']) ? trim($_POST['emergency_contact_phone']) : '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($password)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'First Name, Last Name, Email, Contact Phone, and Password are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    // Validate form token
    $form_id = 0;
    $form_creator_email = '';
    if (!empty($form_token)) {
        $safe_token = addslashes($form_token);
        $f_res = $conn->query("SELECT f.*, u.user_name AS creator_email 
            FROM `employee_registration_forms` f 
            LEFT JOIN `main_user_login` u ON f.created_by = u.id 
            WHERE f.form_token = '{$safe_token}' AND f.status = 'active' LIMIT 1");
        if ($f_res && ($f_row = $f_res->fetch_assoc())) {
            $form_id = (int)$f_row['id'];
            $form_creator_email = $f_row['creator_email'] ?? '';
            if (!empty($f_row['expires_at']) && strtotime($f_row['expires_at']) < time()) {
                ob_end_clean();
                echo json_encode(['status' => 'error', 'message' => 'This registration form link has expired. Please request a new link from your Super Admin.']);
                exit;
            }
        } else {
            ob_end_clean();
            echo json_encode(['status' => 'error', 'message' => 'Invalid or inactive registration form token.']);
            exit;
        }
    }

    // Check if email already registered in system
    $safe_email = addslashes($email);
    $chk_user = $conn->query("SELECT id FROM `main_user_login` WHERE `user_name` = '{$safe_email}' LIMIT 1");
    if ($chk_user && $chk_user->num_rows > 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'This email address is already registered in the system.']);
        exit;
    }

    // Check if duplicate pending submission exists
    $chk_sub = $conn->query("SELECT id FROM `employee_form_submissions` WHERE `email` = '{$safe_email}' AND `status` = 'pending' LIMIT 1");
    if ($chk_sub && $chk_sub->num_rows > 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'An application with this email has already been submitted and is currently pending admin approval.']);
        exit;
    }

    // Encrypt password using system security scheme
    $sec = new Advance_Security();
    $password_hash = $sec->get_data_encrypt($email, $password);

    // Escape all strings
    $safe_token  = !empty($form_token) ? "'" . addslashes($form_token) . "'" : "NULL";
    $safe_formid = $form_id > 0 ? $form_id : "NULL";
    $safe_first  = addslashes($first_name);
    $safe_last   = addslashes($last_name);
    $safe_name   = addslashes(trim($first_name . ' ' . $last_name));
    $safe_phone  = addslashes($phone);
    $safe_pwd    = addslashes($password_hash);
    $safe_dept   = addslashes($department);
    $safe_job    = addslashes($job_title);
    $safe_nic    = addslashes($nic);
    $safe_dob    = !empty($dob) ? "'" . addslashes($dob) . "'" : "NULL";
    $safe_gender = addslashes($gender);
    $safe_addr   = addslashes($address);
    $safe_em_n   = addslashes($em_name);
    $safe_em_p   = addslashes($em_phone);

    // 1. Immediately create user in main_user_login (in pending approval state)
    // Ref key temporary prefix pending Super Admin approval
    $temp_ref = 'REG-' . strtoupper(substr(md5($email . time()), 0, 6));
    $ins_user_sql = "INSERT INTO `main_user_login` (
        `company_id`, `user_name`, `password`, `name_show`, `first_name`, `last_name`,
        `phone_number`, `ref_key`, `main_user_account_access_level_list_id`, `ac_type`,
        `account_active_state`, `email_verify`, `moible_verfiy`, `ast`, `sdt`
    ) VALUES (
        1, '{$safe_email}', '{$safe_pwd}', '{$safe_name}', '{$safe_first}', '{$safe_last}',
        '{$safe_phone}', '{$temp_ref}', 3, 'Employee',
        0, 0, 0, 1, NOW()
    )";

    if (!$conn->query($ins_user_sql)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Failed to create user account record: ' . $conn->error]);
        exit;
    }

    $created_user_id = (int)$conn->insert_id;

    // 2. Insert into employee_form_submissions linked to created_user_id
    $sql = "INSERT INTO `employee_form_submissions` (
        `form_id`, `form_token`, `first_name`, `last_name`, `email`, `phone_number`, `password_hash`,
        `department`, `job_title`, `nic`, `dob`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`,
        `status`, `created_user_id`, `created_at`
    ) VALUES (
        {$safe_formid}, {$safe_token}, '{$safe_first}', '{$safe_last}', '{$safe_email}', '{$safe_phone}', '{$safe_pwd}',
        '{$safe_dept}', '{$safe_job}', '{$safe_nic}', {$safe_dob}, '{$safe_gender}', '{$safe_addr}', '{$safe_em_n}', '{$safe_em_p}',
        'pending', {$created_user_id}, NOW()
    )";

    if (!$conn->query($sql)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Failed to save registration submission: ' . $conn->error]);
        exit;
    }

    $submission_id = (int)$conn->insert_id;

    // Notify administrators of the new registration
    $comp_obj = new Company_Info_Variable_List();
    $admin_emails = [];
    $adm_res = $conn->query("
        SELECT DISTINCT `user_name`
        FROM `main_user_login`
        WHERE (
            LOWER(TRIM(COALESCE(`ac_type`, ''))) IN ('admin', 'super_admin')
            OR `main_user_account_access_level_list_id` = 1
        )
        AND `account_active_state` = 1
        AND `ast` = 1
        AND `full_block` = 0
    ");
    if ($adm_res) {
        while ($adm_r = $adm_res->fetch_assoc()) {
            $recipient = trim((string)$adm_r['user_name']);
            if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $admin_emails[strtolower($recipient)] = $recipient;
            }
        }
    }
    if (!$admin_emails && !empty($form_creator_email) && filter_var($form_creator_email, FILTER_VALIDATE_EMAIL)) {
        $admin_emails[strtolower($form_creator_email)] = $form_creator_email;
    }
    if (!$admin_emails) {
        $fallback_email = Email_Send::resolve_admin_email();
        if (filter_var($fallback_email, FILTER_VALIDATE_EMAIL)) {
            $admin_emails[strtolower($fallback_email)] = $fallback_email;
        }
    }

    $full_name = trim($first_name . ' ' . $last_name);
    $portal_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Admin_user_dashboard.php';

    $email_sent_to_admin = false;
    $admin_mail_errors = [];

    try {
        $mail_subject = "[Action Required] New Staff Registration Submitted - {$full_name}";
        $mail_body = "
        <div style='font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='background: linear-gradient(135deg, #14204d 0%, #1c2b63 100%); padding: 20px; border-radius: 8px; text-align: center; color: #ffffff;'>
                <h2 style='margin: 0 0 6px; font-size: 20px;'>New Staff Registration Submitted</h2>
                <p style='margin: 0; font-size: 13.5px; opacity: 0.9;'>Pending Super Administrator Review &amp; Role/Department Assignment</p>
            </div>
            
            <p style='font-size: 15px; color: #1e293b; margin: 20px 0 14px;'>
                An applicant has registered as a staff member on the portal. Please review their submission and assign their role (Admin or Staff) and department:
            </p>

            <table style='width: 100%; border-collapse: collapse; margin-bottom: 24px;'>
                <tr style='background: #f8fafc;'>
                    <td style='padding: 10px 14px; font-weight: bold; width: 35%; border: 1px solid #e2e8f0; color: #475569;'>Candidate Full Name</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a; font-weight: 600;'>{$full_name}</td>
                </tr>
                <tr>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Corporate / Email</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>{$email}</td>
                </tr>
                <tr style='background: #f8fafc;'>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Contact Phone Number</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a; font-weight: 600;'>{$phone}</td>
                </tr>
                <tr>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Department</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>{$department} (Pending Admin Assignment)</td>
                </tr>
                <tr style='background: #f8fafc;'>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Job Title / Role</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>{$job_title}</td>
                </tr>
                <tr>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>NIC / ID Number</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>" . (!empty($nic) ? $nic : 'Not specified') . "</td>
                </tr>
                <tr style='background: #f8fafc;'>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Date of Birth &amp; Gender</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>" . (!empty($dob) ? $dob : 'N/A') . " ({$gender})</td>
                </tr>
                <tr>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Residential Address</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>" . (!empty($address) ? nl2br(htmlspecialchars($address)) : 'N/A') . "</td>
                </tr>
                <tr style='background: #f8fafc;'>
                    <td style='padding: 10px 14px; font-weight: bold; border: 1px solid #e2e8f0; color: #475569;'>Emergency Contact</td>
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>" . (!empty($em_name) ? "{$em_name} ({$em_phone})" : 'N/A') . "</td>
                </tr>
            </table>

            <div style='background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px;'>
                <p style='margin: 0; font-size: 13.5px; color: #166534;'>
                    <strong>Super Admin Action:</strong> Open the Admin Dashboard to review this application. You can assign the registrant as either an Administrator or Staff, select their department, and activate their portal account.
                </p>
            </div>

            <div style='text-align: center; margin: 24px 0;'>
                <a href='{$portal_url}' style='background: #2563eb; color: #ffffff; text-decoration: none; padding: 13px 26px; border-radius: 8px; font-weight: bold; font-size: 14.5px; display: inline-block;'>
                    Go to Admin Portal to Review &amp; Approve
                </a>
            </div>

            <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
                NEO Solution Staff Management System Notification
            </p>
        </div>";

        foreach ($admin_emails as $admin_email) {
            $sender = new Email_Send($admin_email, $mail_subject, $mail_body, 'employee_form_submitted');
            if ($sender->send_email()) {
                $email_sent_to_admin = true;
            } else {
                $admin_mail_errors[] = $admin_email . ': ' . $sender->get_last_error();
            }
        }
    } catch (\Throwable $mEx) {
        $admin_mail_errors[] = $mEx->getMessage();
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => $email_sent_to_admin
            ? 'Staff registration submitted. Super Admin has been notified and will review your application and assign your role.'
            : 'Staff registration submitted. Pending Super Admin review and approval.',
        'data' => [
            'submission_id' => $submission_id,
            'user_id' => $created_user_id,
            'email' => $email,
            'phone' => $phone,
            'admin_notified' => $email_sent_to_admin,
            'admin_recipients_count' => count($admin_emails),
            'admin_email_errors' => $admin_mail_errors
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
