<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';

$session_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$session_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$access_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;
$is_admin = (strpos($session_role, 'admin') !== false || $access_level === 1 || ($session_user_id === 1 && empty($_SESSION['admin_impersonating'])));
if ($session_user_id === 0 || !$is_admin || !empty($_SESSION['otp_pending'])) {
    http_response_code($session_user_id === 0 || !empty($_SESSION['otp_pending']) ? 401 : 403);
    echo json_encode(['status' => 'error', 'message' => 'Administrator access required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
if (empty($email)) {
    $email = Email::resolve_admin_email();
}

$res = Email::send_test_email($email);
echo json_encode($res);
exit;
