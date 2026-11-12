<?php
/**
 * fetch_security_settings.php
 * Returns the current user's phone number and 2FA status.
 */
header('Content-Type: application/json; charset=utf-8');
if (function_exists('mysqli_report')) { mysqli_report(MYSQLI_REPORT_OFF); }

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';

$session_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
if ($session_user_id === 0 || !empty($_SESSION['otp_pending'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $uid = (int)$session_user_id;

    $user_name = '';
    $phone_number = '';
    $is_two_factor_auth_enable = 0;

    $q = $conn->query("SELECT user_name, phone_number, is_two_factor_auth_enable FROM `main_user_login` WHERE `id` = {$uid} LIMIT 1");
    if (!$q) {
        throw new Exception('Could not read account settings (' . $conn->error . ').');
    }
    if ($r = $q->fetch_assoc()) {
        $user_name = $r['user_name'] ?? '';
        $phone_number = trim((string)($r['phone_number'] ?? ''));
        $is_two_factor_auth_enable = (int)($r['is_two_factor_auth_enable'] ?? 0);
    }

    // Fallback: phone stored on the employee profile (column is `phone`)
    if ($phone_number === '') {
        $ep = $conn->query("SELECT `phone` FROM `employee_profiles` WHERE `user_id` = {$uid} LIMIT 1");
        if ($ep && ($epr = $ep->fetch_assoc()) && !empty($epr['phone'])) {
            $phone_number = trim((string)$epr['phone']);
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => [
            'user_id' => $uid,
            'user_name' => $user_name,
            'phone_number' => $phone_number,
            'is_two_factor_auth_enable' => $is_two_factor_auth_enable === 1
        ]
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
