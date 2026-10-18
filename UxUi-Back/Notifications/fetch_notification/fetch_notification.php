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
$recipient_role = $is_admin ? 'admin' : 'employee';
$current_user = get_current_logged_user_info();
$recipient_name = !empty($current_user['full_name']) && $current_user['full_name'] !== 'Guest'
    ? $current_user['full_name']
    : '';

SystemNotifications::ensure_table();
$db = new DataBase();
$conn = $db->get_data_base_connction();

$safe_name = mysqli_real_escape_string($conn, $recipient_name);
if ($is_admin) {
    $where = "WHERE recipient_role = 'admin' OR recipient_role = 'all'";
} else {
    $where = "WHERE recipient_role = 'all'";
    if ($safe_name !== '') {
        $where .= " OR (recipient_role = 'employee' AND recipient_name = '$safe_name')";
    }
}

$sql = "SELECT * FROM `system_notifications` $where ORDER BY `created_at` DESC, `id` DESC LIMIT 50";
$res = $conn->query($sql);
if (!$res) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Could not load notifications.']);
    exit;
}

$notifications = [];
$unread_count = 0;

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $is_unread = (int)$row['is_read'] === 0;
        if ($is_unread) $unread_count++;

        $time_str = isset($row['created_at']) ? $row['created_at'] : date('Y-m-d H:i');

        $notifications[] = [
            'id'      => (int)$row['id'],
            'title'   => $row['title'],
            'message' => $row['message'],
            'time'    => $time_str,
            'type'    => !empty($row['type']) ? $row['type'] : 'general',
            'unread'  => $is_unread
        ];
    }
}

echo json_encode([
    'status'       => 'success',
    'unread_count' => $unread_count,
    'total'        => count($notifications),
    'data'         => $notifications
]);
exit;
?>
