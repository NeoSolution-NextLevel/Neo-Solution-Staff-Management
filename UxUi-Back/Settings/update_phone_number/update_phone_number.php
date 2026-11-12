<?php
/**
 * update_phone_number.php
 * Updates phone number for the current logged-in user in both main_user_login and employee_profiles.
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

$phone = trim($_POST['phone_number'] ?? '');
if ($phone === '') {
    echo json_encode(['status' => 'error', 'message' => 'Phone number cannot be empty.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $uid = (int)$session_user_id;
    $safePhone = mysqli_real_escape_string($conn, $phone);

    // Update main_user_login
    $conn->query("UPDATE `main_user_login` SET `phone_number` = '{$safePhone}' WHERE `id` = {$uid}");

    // Also update employee_profiles if exists
    $conn->query("UPDATE `employee_profiles` SET `phone` = '{$safePhone}' WHERE `user_id` = {$uid}");

    // Also update employees table if exists
    $conn->query("UPDATE `employees` SET `phone_number` = '{$safePhone}' WHERE `user_id` = {$uid} OR `id` = {$uid}");

    $_SESSION['phone_number'] = $phone;

    echo json_encode([
        'status' => 'success',
        'message' => 'Phone number updated successfully.',
        'phone_number' => $phone
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
