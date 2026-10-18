<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0 || !empty($_SESSION['otp_pending'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
    exit;
}

SystemNotifications::ensure_table();
$db = new DataBase();
$conn = $db->get_data_base_connction();
$session_user_id = (int)$_SESSION['user_id'];
$user_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$access_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;
$is_admin = (strpos($user_role, 'admin') !== false || $access_level === 1 || ($session_user_id === 1 && empty($_SESSION['admin_impersonating'])));
$current_user = get_current_logged_user_info();
$recipient_name = !empty($current_user['full_name']) && $current_user['full_name'] !== 'Guest'
    ? mysqli_real_escape_string($conn, $current_user['full_name'])
    : '';
$scope = $is_admin
    ? "(recipient_role = 'admin' OR recipient_role = 'all')"
    : "(recipient_role = 'all'" . ($recipient_name !== '' ? " OR (recipient_role = 'employee' AND recipient_name = '$recipient_name')" : '') . ")";

$id   = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    $result = $conn->query("DELETE FROM `system_notifications` WHERE `id` = '$id' AND $scope");
} else {
    $result = $conn->query("DELETE FROM `system_notifications` WHERE $scope");
}

if (!$result) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Could not delete notifications.']);
    exit;
}

echo json_encode([
    'status'  => 'success',
    'message' => 'Notification(s) removed from database.'
]);
exit;
?>
