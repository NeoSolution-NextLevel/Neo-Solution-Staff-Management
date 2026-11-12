<?php
/**
 * toggle_two_factor.php
 * Handles turning 2FA ON or OFF directly from the Settings page.
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$action = trim($_POST['action'] ?? ''); // 'enable' or 'disable'
$uid = (int)$session_user_id;

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    if ($action === 'disable') {
        $conn->query("UPDATE `main_user_login` SET `is_two_factor_auth_enable` = 0 WHERE `id` = {$uid}");
        echo json_encode([
            'status' => 'success',
            'message' => 'Two-Factor Authentication has been disabled.',
            'is_two_factor_auth_enable' => false
        ]);
        exit;
    }

    if ($action === 'enable') {
        // Check if phone number is available
        $q = $conn->query("SELECT phone_number, user_name FROM `main_user_login` WHERE `id` = {$uid} LIMIT 1");
        $phone = '';
        if ($q && $r = $q->fetch_assoc()) {
            $phone = trim($r['phone_number'] ?? '');
        }
        if (empty($phone)) {
            echo json_encode([
                'status' => 'error',
                'require_phone' => true,
                'message' => 'Please save your phone number before enabling Two-Factor Authentication.'
            ]);
            exit;
        }

        $conn->query("UPDATE `main_user_login` SET `is_two_factor_auth_enable` = 1 WHERE `id` = {$uid}");
        echo json_encode([
            'status' => 'success',
            'message' => 'Two-Factor Authentication has been enabled successfully.',
            'is_two_factor_auth_enable' => true
        ]);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action parameter.']);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
