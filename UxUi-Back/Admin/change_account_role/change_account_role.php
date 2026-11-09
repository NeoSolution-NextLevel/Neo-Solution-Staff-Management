<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';
include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';

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
    echo json_encode(['status' => 'error', 'message' => 'Administrator privileges required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    exit;
}

$account_id = isset($_POST['account_id']) ? (int)$_POST['account_id'] : 0;
$new_role   = isset($_POST['new_role']) ? trim($_POST['new_role']) : '';

if ($account_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid account ID provided.']);
    exit;
}

if ($account_id === 1) {
    echo json_encode(['status' => 'error', 'message' => 'Primary Super Administrator account role cannot be changed.']);
    exit;
}

if (!in_array($new_role, ['Admin', 'Employee'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid role specified. Role must be "Admin" or "Employee".']);
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
    $actor_actype === 'super_admin' || 
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

// Fetch the account to change
$q = $conn->query("SELECT id, user_name, name_show, first_name, last_name, ref_key, ac_type, main_user_account_access_level_list_id, account_active_state FROM `main_user_login` WHERE `id` = {$account_id} LIMIT 1");
if (!$q || $q->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Account not found.']);
    exit;
}

$target_user = $q->fetch_assoc();
$user_email  = trim($target_user['user_name']);
$user_name   = !empty($target_user['name_show']) ? $target_user['name_show'] : trim($target_user['first_name'] . ' ' . $target_user['last_name']);
if (empty($user_name)) $user_name = $user_email;

$new_access_level_id = ($new_role === 'Admin') ? 2 : 3;
$new_ac_type         = ($new_role === 'Admin') ? 'Admin' : 'Employee';

// Update in main_user_login
$update_sql = "UPDATE `main_user_login` SET 
    `ac_type` = '{$new_ac_type}',
    `main_user_account_access_level_list_id` = {$new_access_level_id}
    WHERE `id` = {$account_id}";

if ($conn->query($update_sql)) {
    // Also keep employee_profiles and employees synchronized if existing
    $safe_email = addslashes($user_email);
    $safe_name  = addslashes($user_name);
    
    if ($new_role === 'Admin') {
        // Updated to Administrator
        $conn->query("UPDATE `employee_profiles` SET `job_title` = 'Administrator' WHERE `user_id` = {$account_id} OR `email` = '{$safe_email}'");
        $conn->query("UPDATE `employees` SET `job_role` = 'Administrator' WHERE `main_user_login_id` = '{$account_id}' OR `email` = '{$safe_email}'");
    } else {
        // Updated to Employee (Staff)
        $conn->query("UPDATE `employee_profiles` SET `job_title` = 'Staff' WHERE (`user_id` = {$account_id} OR `email` = '{$safe_email}') AND `job_title` = 'Administrator'");
        $conn->query("UPDATE `employees` SET `job_role` = 'Staff' WHERE (`main_user_login_id` = '{$account_id}' OR `email` = '{$safe_email}') AND `job_role` = 'Administrator'");
    }

    $comp_info = new Company_Info_Variable_List();
    $company_name = $comp_info->get_compnay_name();
    $base_url = isset($home_page) ? rtrim($home_page, '/') : '';
    $login_url = $base_url . '/UxUi/Main/User-Login.php';
    $role_label = ($new_role === 'Admin') ? 'Administrator (Admin Portal)' : 'Staff (Employee Portal)';

    // Send Role Change Notification Email
    $subject = "Your Account Role Has Been Updated - {$company_name}";
    $html = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
        <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #2563eb;'>
            <h2 style='color: #14204d; margin: 0;'>{$company_name}</h2>
            <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Role & Access Control Update</p>
        </div>
        <p style='font-size: 16px; color: #1e293b;'>Hello <strong>{$user_name}</strong>,</p>
        <div style='background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #2563eb; border-radius: 8px; padding: 16px; margin: 20px 0;'>
            <p style='margin: 0; font-size: 15px; font-weight: 700; color: #1e40af;'>Role Access Updated</p>
            <p style='margin: 6px 0 0; font-size: 13.5px; color: #1d4ed8;'>
                Your portal role and permissions have been updated to <strong>{$role_label}</strong> by the Super Administrator.
            </p>
        </div>
        <p style='font-size: 14px; color: #475569;'>
            On your next sign in, you will automatically be directed to your updated workspace with the appropriate access permissions.
        </p>
        <div style='text-align: center; margin: 28px 0;'>
            <a href='{$login_url}' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 14.5px; padding: 12px 32px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37,99,235,0.28);'>
                Sign In to Portal
            </a>
        </div>
        <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
            &copy; " . date('Y') . " {$company_name}. All rights reserved.
        </p>
    </div>";

    try {
        $mailer = new Email_Send($user_email, $subject, $html, 'role_changed');
        $mailer->send_email();
    } catch (\Throwable $e) {}

    // System Notification
    try {
        SystemNotifications::create(
            "Account Role Changed: {$user_name}",
            "Account for {$user_name} ({$user_email}) was assigned the role: {$new_role}.",
            "admin_role_change",
            "admin",
            "Super Admin"
        );
    } catch (\Throwable $e) {}

    echo json_encode([
        'status'  => 'success',
        'message' => "Role for {$user_name} has been updated to {$role_label}.",
        'data'    => [
            'id'       => $account_id,
            'role'     => $new_role,
            'ac_type'  => $new_ac_type,
            'role_label' => ($new_role === 'Admin') ? 'Administrator' : 'Employee'
        ]
    ]);
    exit;
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to update role in database: ' . $conn->error
    ]);
    exit;
}

