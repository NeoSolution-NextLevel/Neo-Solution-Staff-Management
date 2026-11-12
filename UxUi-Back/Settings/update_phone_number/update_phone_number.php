<?php
/**
 * update_phone_number.php
 * Saves the logged-in user's phone number (main_user_login, plus employee_profiles / employees when present).
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

// Normalise: drop spaces, dashes and brackets; keep digits and an optional leading +
$phone = preg_replace('/[\s\-().]/', '', trim($_POST['phone_number'] ?? ''));
if ($phone === '') {
    echo json_encode(['status' => 'error', 'message' => 'Phone number cannot be empty.']);
    exit;
}
if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Enter a valid phone number (7-15 digits, optional + prefix), e.g. +94771234567.']);
    exit;
}

function col_exists($conn, $table, $col) {
    $r = $conn->query("SHOW COLUMNS FROM `{$table}` LIKE '" . $conn->real_escape_string($col) . "'");
    return $r && $r->num_rows > 0;
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $uid = (int)$session_user_id;
    $safePhone = $conn->real_escape_string($phone);

    // Primary store - this one must succeed
    if (!$conn->query("UPDATE `main_user_login` SET `phone_number` = '{$safePhone}' WHERE `id` = {$uid}")) {
        throw new Exception('Could not save phone number (' . $conn->error . ').');
    }

    // Best-effort copies; a missing table/column must not fail the save
    if (col_exists($conn, 'employee_profiles', 'phone')) {
        $conn->query("UPDATE `employee_profiles` SET `phone` = '{$safePhone}' WHERE `user_id` = {$uid}");
    }
    if (col_exists($conn, 'employees', 'phone_number') && col_exists($conn, 'employees', 'main_user_login_id')) {
        $conn->query("UPDATE `employees` SET `phone_number` = '{$safePhone}' WHERE `main_user_login_id` = {$uid}");
    }

    $_SESSION['phone_number'] = $phone;

    echo json_encode([
        'status' => 'success',
        'message' => 'Phone number saved successfully.',
        'phone_number' => $phone
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
