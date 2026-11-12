<?php
/**
 * toggle_two_factor.php
 * Turns 2FA OFF for the logged-in user.
 * Turning it ON must go through OTP verification (View-List/Main/Two_Factor_Authentication/Two_Factor_Authentication.php),
 * so 'enable' is refused here.
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$action = trim($_POST['action'] ?? '');
$uid = (int)$session_user_id;

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    if ($action === 'disable') {
        if (!$conn->query("UPDATE `main_user_login` SET `is_two_factor_auth_enable` = 0 WHERE `id` = {$uid}")) {
            throw new Exception('Could not disable Two-Factor Authentication (' . $conn->error . ').');
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Two-Factor Authentication has been disabled.',
            'is_two_factor_auth_enable' => false
        ]);
        exit;
    }

    if ($action === 'enable') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Two-Factor Authentication must be enabled by verifying a code sent to your phone/email.'
        ]);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action parameter.']);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
