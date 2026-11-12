<?php
/**
 * change_password_ajax.php
 * Handles changing the current user's password directly from the Settings page.
 */
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA_By_Email.php';
include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
include_once __DIR__ . '/../../../imports/security/key_list.php';

$session_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
if ($session_user_id === 0 || !empty($_SESSION['otp_pending'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$current_password = trim($_POST['current_password'] ?? '');
$new_password     = trim($_POST['new_password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if ($current_password === '' || $new_password === '') {
    echo json_encode(['status' => 'error', 'message' => 'Current and new password are required.']);
    exit;
}

if (strlen($new_password) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'New password must be at least 6 characters.']);
    exit;
}

if ($confirm_password !== '' && $new_password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'New passwords do not match.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $uid = (int)$session_user_id;

    $user_name = '';
    $db_password = '';
    $q = $conn->query("SELECT id, user_name, password FROM `main_user_login` WHERE `id` = {$uid} LIMIT 1");
    if ($q && $r = $q->fetch_assoc()) {
        $user_name = $r['user_name'];
        $db_password = $r['password'];
    }

    if (empty($user_name)) {
        echo json_encode(['status' => 'error', 'message' => 'User account not found.']);
        exit;
    }

    $advance_security_check = new Advance_Security();
    $encrypted_current = $advance_security_check->get_data_encrypt($user_name, $current_password);

    if ($db_password !== $encrypted_current) {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
        exit;
    }

    $encrypted_new = $advance_security_check->get_data_encrypt($user_name, $new_password);

    $updater = new main_user_login_ADD_UPDATE();
    $updater->set_id($uid);
    $updater->set_password($encrypted_new);

    if ($updater->process_update()) {
        echo json_encode(['status' => 'success', 'message' => 'Password changed successfully!']);
    } else {
        $conn->query("UPDATE `main_user_login` SET `password` = '" . mysqli_real_escape_string($conn, $encrypted_new) . "' WHERE `id` = {$uid}");
        echo json_encode(['status' => 'success', 'message' => 'Password changed successfully!']);
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
