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

    $form_token = isset($_POST['form_token']) ? trim($_POST['form_token']) : '';
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name  = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone      = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $password   = isset($_POST['password']) ? trim($_POST['password']) : '';
    $department = isset($_POST['department']) && trim($_POST['department']) !== '' ? trim($_POST['department']) : 'Engineering';
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

    // Encrypt password
    $sec = new Advance_Security();
    $enc_password = $sec->get_data_encrypt($email, $password);

    $safe_first   = addslashes($first_name);
    $safe_last    = addslashes($last_name);
    $safe_phone   = addslashes($phone);
    $safe_enc_pwd = addslashes($enc_password);
    $safe_dept    = addslashes($department);
    $safe_job     = addslashes($job_title);
    $safe_nic     = addslashes($nic);
    $safe_dob     = $dob ? "'" . addslashes($dob) . "'" : "NULL";
    $safe_gender  = addslashes($gender);
    $safe_address = addslashes($address);
    $safe_em_name = addslashes($em_name);
    $safe_em_ph   = addslashes($em_phone);
    $safe_ftoken  = addslashes($form_token);

    $ins_sql = "INSERT INTO `employee_form_submissions` (
        `form_id`, `form_token`, `first_name`, `last_name`, `email`, `phone_number`, `password_hash`,
        `department`, `job_title`, `nic`, `dob`, `gender`, `address`, `emergency_contact_name`,
        `emergency_contact_phone`, `status`, `created_at`
    ) VALUES (
        {$form_id}, '{$safe_ftoken}', '{$safe_first}', '{$safe_last}', '{$safe_email}', '{$safe_phone}', '{$safe_enc_pwd}',
        '{$safe_dept}', '{$safe_job}', '{$safe_nic}', {$safe_dob}, '{$safe_gender}', '{$safe_address}', '{$safe_em_name}',
        '{$safe_em_ph}', 'pending', NOW()
    )";

    if (!$conn->query($ins_sql)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Failed to save submission: ' . $conn->error]);
        exit;
    }

    $submission_id = (int)$conn->insert_id;

    // Send notification email with submitted form details to Admin
    $comp_obj = new Company_Info_Variable_List();
    $admin_email = !empty($form_creator_email) && filter_var($form_creator_email, FILTER_VALIDATE_EMAIL)
        ? $form_creator_email
        : $comp_obj->get_default_sending_email();

    if (empty($admin_email)) {
        $adm_res = $conn->query("SELECT user_name FROM `main_user_login` WHERE `main_user_account_access_level_list_id` = 1 OR `ac_type` = 'Admin' ORDER BY `id` ASC LIMIT 1");
        if ($adm_res && ($adm_r = $adm_res->fetch_assoc())) {
            $admin_email = $adm_r['user_name'];
        }
    }

    $full_name = trim($first_name . ' ' . $last_name);
    $portal_url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Admin_user_dashboard.php';

    $email_sent_to_admin = false;
    $admin_mail_error = '';

    try {
        $mail_subject = "[Action Required] New Employee Registration Form Submitted - {$full_name}";
        $mail_body = "
        <div style='font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='background: linear-gradient(135deg, #14204d 0%, #1c2b63 100%); padding: 20px; border-radius: 8px; text-align: center; color: #ffffff;'>
                <h2 style='margin: 0 0 6px; font-size: 20px;'>New Employee Registration Form Submitted</h2>
                <p style='margin: 0; font-size: 13.5px; opacity: 0.9;'>Pending Administrator Review &amp; Approval</p>
            </div>
            
            <p style='font-size: 15px; color: #1e293b; margin: 20px 0 14px;'>
                An applicant has filled out and submitted their employee registration form. Please review the details below:
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
                    <td style='padding: 10px 14px; border: 1px solid #e2e8f0; color: #0f172a;'>{$department}</td>
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
                    <strong>Next Steps:</strong> Log in to the Admin Portal to review and approve this submission. Once approved, the system will send an approval email and dispatch a secure 6-digit OTP code to the employee's contact number <strong>{$phone}</strong> for account verification.
                </p>
            </div>

            <div style='text-align: center; margin: 24px 0;'>
                <a href='{$portal_url}' style='background: #2563eb; color: #ffffff; text-decoration: none; padding: 13px 26px; border-radius: 8px; font-weight: bold; font-size: 14.5px; display: inline-block;'>
                    Go to Admin Portal to Approve
                </a>
            </div>

            <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
                NEO Solution Staff Management System Notification
            </p>
        </div>";

        $sender = new Email_Send($admin_email, $mail_subject, $mail_body, 'employee_form_submitted');
        $email_sent_to_admin = $sender->send_email();
        if (!$email_sent_to_admin) {
            $admin_mail_error = $sender->get_last_error();
        }
    } catch (\Throwable $mEx) {
        $admin_mail_error = $mEx->getMessage();
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Employee registration form submitted successfully! Your application is now pending administrator approval.',
        'data' => [
            'submission_id' => $submission_id,
            'email' => $email,
            'phone' => $phone,
            'admin_notified' => $email_sent_to_admin,
            'admin_email_error' => $admin_mail_error
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
