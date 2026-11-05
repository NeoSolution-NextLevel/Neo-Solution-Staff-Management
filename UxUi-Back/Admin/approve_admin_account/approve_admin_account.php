<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
    exit;
}

$user_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$access_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;

$is_admin = (strpos($user_role, 'admin') !== false || $access_level === 1 || (int)$_SESSION['user_id'] === 1);
if (!$is_admin) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Access denied. Administrator privileges required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    exit;
}

$admin_id = isset($_POST['admin_id']) ? (int)$_POST['admin_id'] : 0;
$action = isset($_POST['action']) ? trim($_POST['action']) : '';

if ($admin_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid account ID.']);
    exit;
}

if ($admin_id === 1) {
    echo json_encode(['status' => 'error', 'message' => 'Root Super Administrator account cannot be modified.']);
    exit;
}

$db = new DataBase();
$conn = $db->get_data_base_connction();

$actor_id = (int)$_SESSION['user_id'];
$actor_result = $conn->query("SELECT ac_type, account_active_state, ast, full_block, main_user_account_access_level_list_id FROM `main_user_login` WHERE `id` = {$actor_id} LIMIT 1");
$actor = $actor_result ? $actor_result->fetch_assoc() : null;
$actor_acl = $actor && isset($actor['main_user_account_access_level_list_id']) ? (int)$actor['main_user_account_access_level_list_id'] : 0;
$actor_actype = $actor && isset($actor['ac_type']) ? strtolower(trim($actor['ac_type'])) : '';

$is_super_admin = (
    $actor_id === 1 || 
    $actor_actype === 'super admin' || 
    $actor_actype === 'admin' || 
    $actor_acl === 1 || 
    $actor_acl === 3 || 
    strpos($user_role, 'admin') !== false ||
    strpos($user_role, 'super') !== false
);
if (!$is_super_admin) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Super Administrator privileges required.']);
    exit;
}

$q = $conn->query("SELECT id, user_name, name_show, first_name, last_name, ref_key, ac_type, main_user_account_access_level_list_id, account_active_state FROM `main_user_login` WHERE `id` = {$admin_id} LIMIT 1");
if (!$q || $q->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Account not found.']);
    exit;
}

$target_admin = $q->fetch_assoc();
$user_email = trim($target_admin['user_name']);
$admin_name = !empty($target_admin['name_show']) ? $target_admin['name_show'] : trim($target_admin['first_name'] . ' ' . $target_admin['last_name']);
if (empty($admin_name)) $admin_name = $user_email;

$comp_info = new Company_Info_Variable_List();
$company_name = $comp_info->get_compnay_name();
$base_url = isset($home_page) ? rtrim($home_page, '/') : '';
$login_url = $base_url . '/UxUi/Main/User-Login.php';

if ($action === 'approve') {
    $update = $conn->query("UPDATE `main_user_login` SET 
        `account_active_state` = 1, 
        `email_verify` = 1, 
        `moible_verfiy` = 1,
        `ast` = 1, 
        `full_block` = 0 
        WHERE `id` = {$admin_id}");

    if ($update) {
        // Send Approval Email
        $subject = "Your Account has been Approved - {$company_name}";
        $html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #10b981;'>
                <h2 style='color: #14204d; margin: 0;'>{$company_name}</h2>
                <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Portal Access Granted</p>
            </div>
            <p style='font-size: 16px; color: #1e293b;'>Hello <strong>{$admin_name}</strong>,</p>
            <div style='background: #ecfdf5; border: 1px solid #a7f3d0; border-left: 4px solid #10b981; border-radius: 8px; padding: 16px; margin: 20px 0;'>
                <p style='margin: 0; font-size: 15px; font-weight: 700; color: #065f46;'>Account Approved!</p>
                <p style='margin: 6px 0 0; font-size: 13.5px; color: #047857;'>
                    Your account registration has been reviewed and approved by the Super Administrator. Your account is now fully active.
                </p>
            </div>
            <p style='font-size: 14px; color: #475569;'>
                You can now sign in to the NEO Solution Portal using your registered email and password.
            </p>
            <div style='text-align: center; margin: 28px 0;'>
                <a href='{$login_url}' style='display: inline-block; background: #10b981; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 14.5px; padding: 12px 32px; border-radius: 8px; box-shadow: 0 4px 12px rgba(16,185,129,0.28);'>
                    Log In to Portal
                </a>
            </div>
            <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
                &copy; " . date('Y') . " {$company_name}. All rights reserved.
            </p>
        </div>";

        try {
            $mailer = new Email_Send($user_email, $subject, $html, 'account_approved');
            $mailer->send_email();
        } catch (\Throwable $e) {}

        // Log notification
        try {
            SystemNotifications::create(
                "Account Approved: {$admin_name}",
                "Account for {$admin_name} ({$user_email}) was approved by Super Admin.",
                "admin_approval",
                "admin",
                "Super Admin"
            );
        } catch (\Throwable $e) {}

        echo json_encode([
            'status' => 'success',
            'message' => "Account for {$admin_name} has been approved successfully."
        ]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update account in database.']);
        exit;
    }
} elseif ($action === 'reject' || $action === 'block') {
    $update = $conn->query("UPDATE `main_user_login` SET 
        `account_active_state` = 0, 
        `full_block` = 1, 
        `ast` = 0 
        WHERE `id` = {$admin_id}");

    if ($update) {
        // Send Rejection Email
        $subject = "Account Registration Update - {$company_name}";
        $html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #ef4444;'>
                <h2 style='color: #14204d; margin: 0;'>{$company_name}</h2>
                <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Account Registration Review</p>
            </div>
            <p style='font-size: 15px; color: #1e293b;'>Hello <strong>{$admin_name}</strong>,</p>
            <div style='background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 8px; padding: 16px; margin: 20px 0;'>
                <p style='margin: 0; font-size: 15px; font-weight: 700; color: #991b1b;'>Registration Not Approved</p>
                <p style='margin: 6px 0 0; font-size: 13.5px; color: #b91c1c;'>
                    Your account registration request could not be approved by the Super Administrator at this time.
                </p>
            </div>
            <p style='font-size: 14px; color: #475569;'>
                If you believe this is an error or require further information, please contact your organization's primary administrator.
            </p>
            <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
                &copy; " . date('Y') . " {$company_name}. All rights reserved.
            </p>
        </div>";

        try {
            $mailer = new Email_Send($user_email, $subject, $html, 'account_rejected');
            $mailer->send_email();
        } catch (\Throwable $e) {}

        // Log notification
        try {
            SystemNotifications::create(
                "Account Declined: {$admin_name}",
                "Account registration request for {$admin_name} ({$user_email}) was declined by Super Admin.",
                "admin_approval",
                "admin",
                "Super Admin"
            );
        } catch (\Throwable $e) {}

        echo json_encode([
            'status' => 'success',
            'message' => "Account for {$admin_name} has been declined."
        ]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update account in database.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action specified. Must be "approve" or "reject".']);
    exit;
}
