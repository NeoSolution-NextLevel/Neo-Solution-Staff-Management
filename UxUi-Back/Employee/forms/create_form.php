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

    // Must be logged in as Admin / Super Admin
    if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
        exit;
    }

    $role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';
    $ac_type = isset($_SESSION['ac_type']) ? strtolower($_SESSION['ac_type']) : '';
    if (strpos($role, 'admin') === false && strpos($ac_type, 'admin') === false && strpos($role, 'super') === false) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Admin authorization required.']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Ensure table exists
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

    $title       = isset($_POST['title']) && trim($_POST['title']) !== '' ? trim($_POST['title']) : 'Employee Onboarding Form';
    $department  = isset($_POST['department']) && trim($_POST['department']) !== '' ? trim($_POST['department']) : 'Engineering';
    $job_title   = isset($_POST['job_title']) && trim($_POST['job_title']) !== '' ? trim($_POST['job_title']) : 'Staff';
    $target_email= isset($_POST['target_email']) ? trim($_POST['target_email']) : '';
    $send_email  = !empty($_POST['send_email']) && $_POST['send_email'] !== '0' && $_POST['send_email'] !== 'false';
    $expiry_days = isset($_POST['expiry_days']) ? (int)$_POST['expiry_days'] : 30;
    $allow_mult  = isset($_POST['allow_multiple']) ? (int)$_POST['allow_multiple'] : 1;
    $created_by  = (int)$_SESSION['user_id'];

    $token = bin2hex(random_bytes(24)); // 48 char hex token

    $safe_token  = addslashes($token);
    $safe_title  = addslashes($title);
    $safe_dept   = addslashes($department);
    $safe_job    = addslashes($job_title);
    $safe_email  = addslashes($target_email);

    $expires_sql = $expiry_days > 0 ? "DATE_ADD(NOW(), INTERVAL {$expiry_days} DAY)" : "NULL";

    $ins_sql = "INSERT INTO `employee_registration_forms` (
        `form_token`, `title`, `department`, `job_title`, `target_email`, `created_by`, `status`, `allow_multiple`, `expires_at`, `created_at`
    ) VALUES (
        '{$safe_token}', '{$safe_title}', '{$safe_dept}', '{$safe_job}', " . (!empty($target_email) ? "'{$safe_email}'" : "NULL") . ",
        {$created_by}, 'active', {$allow_mult}, {$expires_sql}, NOW()
    )";

    if (!$conn->query($ins_sql)) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        exit;
    }

    $form_id = (int)$conn->insert_id;

    $base_url = rtrim($GLOBALS['home_page'], '/');
    $form_url = $base_url . '/UxUi/Main/Employee-Registration-Form.php?token=' . urlencode($token);

    // Optional email dispatch to candidate
    $email_dispatched = false;
    $email_err = '';
    if ($send_email && !empty($target_email) && filter_var($target_email, FILTER_VALIDATE_EMAIL)) {
        try {
            $comp_obj = new Company_Info_Variable_List();
            $comp_name = $comp_obj->get_compnay_name();

            $mail_subject = "Invitation: Complete Your Employee Registration Form - {$comp_name}";
            $mail_body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #2563eb;'>
                    <h2 style='color: #14204d; margin: 0 0 6px;'>{$comp_name}</h2>
                    <p style='color: #64748b; margin: 0; font-size: 14px;'>Staff Onboarding &amp; Account Portal</p>
                </div>
                <p style='font-size: 15px; color: #1e293b; line-height: 1.6;'>Hello,</p>
                <p style='font-size: 15px; color: #1e293b; line-height: 1.6;'>
                    You have been invited by the Administration to complete your official Employee Registration Form for <strong>{$department}</strong> ({$job_title}).
                </p>
                <div style='background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin: 20px 0;'>
                    <p style='margin: 0 0 8px; font-size: 13.5px; color: #475569;'><strong>Designated Department:</strong> {$department}</p>
                    <p style='margin: 0; font-size: 13.5px; color: #475569;'><strong>Designated Role:</strong> {$job_title}</p>
                </div>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$form_url}' style='background: #2563eb; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: 700; font-size: 15px; display: inline-block; box-shadow: 0 4px 12px rgba(37,99,235,0.25);'>
                        Open Registration Form
                    </a>
                </div>
                <p style='font-size: 13px; color: #64748b; line-height: 1.5;'>
                    If the button above does not work, copy and paste this link into your browser:<br>
                    <a href='{$form_url}' style='color: #2563eb; word-break: break-all;'>{$form_url}</a>
                </p>
                <div style='margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #94a3b8; text-align: center;'>
                    This link was generated exclusively for your employee onboarding by Super Admin.
                </div>
            </div>";

            $sender = new Email_Send($target_email, $mail_subject, $mail_body, 'onboarding_invite');
            $email_dispatched = $sender->send_email();
            if (!$email_dispatched) {
                $email_err = $sender->get_last_error();
            }
        } catch (\Throwable $mEx) {
            $email_err = $mEx->getMessage();
        }
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Employee registration form created successfully.',
        'data' => [
            'id' => $form_id,
            'form_token' => $token,
            'form_url' => $form_url,
            'title' => $title,
            'department' => $department,
            'job_title' => $job_title,
            'target_email' => $target_email,
            'email_sent' => $email_dispatched,
            'email_error' => $email_err,
            'created_at' => date('Y-m-d H:i:s')
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
