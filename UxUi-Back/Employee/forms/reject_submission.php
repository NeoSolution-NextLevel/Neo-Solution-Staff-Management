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
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : 'Application declined by administration.';
    $admin_id = (int)$_SESSION['user_id'];

    if ($submission_id <= 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Valid submission ID required.']);
        exit;
    }

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    $sub_res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE `id` = {$submission_id} LIMIT 1");
    if (!$sub_res || $sub_res->num_rows === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Submission not found.']);
        exit;
    }
    $sub = $sub_res->fetch_assoc();

    $safe_reason = addslashes($reason);
    $conn->query("UPDATE `employee_form_submissions` SET 
        `status` = 'rejected', 
        `admin_notes` = '{$safe_reason}', 
        `reviewed_by` = {$admin_id}, 
        `reviewed_at` = NOW() 
    WHERE `id` = {$submission_id}");

    // If an account was previously created, deactivate it
    if (!empty($sub['created_user_id'])) {
        $u_id = (int)$sub['created_user_id'];
        $conn->query("UPDATE `main_user_login` SET `account_active_state` = 0, `ast` = 0 WHERE `id` = {$u_id}");
        $conn->query("UPDATE `employee_profiles` SET `status` = 'inactive' WHERE `user_id` = {$u_id}");
        $conn->query("UPDATE `employees` SET `status` = 'inactive' WHERE `main_user_login_id` = {$u_id}");
    }

    // Optional notification email to applicant
    try {
        $comp_obj = new Company_Info_Variable_List();
        $comp_name = $comp_obj->get_compnay_name();
        $mail_subject = "Update on Your Employee Registration Application - {$comp_name}";
        $mail_body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <h3 style='color: #e53e3e;'>Application Update</h3>
            <p>Dear {$sub['first_name']},</p>
            <p>Thank you for submitting your Employee Registration Form. After review, the administration has updated the status of your application:</p>
            <div style='background: #fef2f2; border-left: 4px solid #ef4444; padding: 12px; margin: 16px 0; color: #991b1b;'>
                <strong>Decision:</strong> Rejected<br>
                <strong>Reason / Notes:</strong> " . htmlspecialchars($reason) . "
            </div>
            <p style='color: #64748b; font-size: 13px;'>If you believe this was an error, please reach out to your system administrator or HR department.</p>
        </div>";

        $sender = new Email_Send($sub['email'], $mail_subject, $mail_body, 'employee_rejected');
        $sender->send_email();
    } catch (\Throwable $e) {}

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Submission marked as rejected.'
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
