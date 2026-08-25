<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 1;
if (isset($_SESSION['main_user_login_id']) && !empty($_SESSION['main_user_login_id'])) {
    $userId = (int)$_SESSION['main_user_login_id'];
}

$profile = null;

try {
    $check = $db->get_result("SELECT * FROM `employee_profiles` WHERE `user_id` = " . $userId . " LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $profile = $check->fetch_assoc();
    } else {
        $empCheck = $db->get_result("SELECT * FROM `employees` ORDER BY `id` ASC LIMIT 1");
        if ($empCheck && $empCheck->num_rows > 0) {
            $profile = $empCheck->fetch_assoc();
        }
    }
} catch (Exception $e) {
    $profile = null;
}

echo json_encode([
    'status' => 'success',
    'data'   => $profile
]);
exit;
