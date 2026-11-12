<?php
/**
 * fetch_security_settings.php
 * Returns current user's phone number, 2FA status, and basic profile info.
 */
header('Content-Type: application/json; charset=utf-8');

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
    $uid_esc = (int)$session_user_id;

    $user_name = '';
    $phone_number = '';
    $is_two_factor_auth_enable = 0;

    $q = $conn->query("SELECT id, user_name, phone_number, is_two_factor_auth_enable, first_name, last_name, name_show FROM `main_user_login` WHERE `id` = {$uid_esc} LIMIT 1");
    if ($q && $r = $q->fetch_assoc()) {
        $user_name = $r['user_name'] ?? '';
        $phone_number = $r['phone_number'] ?? '';
        $is_two_factor_auth_enable = (int)($r['is_two_factor_auth_enable'] ?? 0);
    }

    // Check employee_profiles for phone fallback
    if (empty($phone_number)) {
        $ep = $conn->query("SELECT phone, phone_number FROM `employee_profiles` WHERE `user_id` = {$uid_esc} LIMIT 1");
        if ($ep && $epr = $ep->fetch_assoc()) {
            $phone_number = !empty($epr['phone']) ? $epr['phone'] : (!empty($epr['phone_number']) ? $epr['phone_number'] : '');
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => [
            'user_id' => $session_user_id,
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
