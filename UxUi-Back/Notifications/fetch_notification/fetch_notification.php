<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

$role = isset($_GET['role']) ? trim($_GET['role']) : 'admin';
$user = isset($_GET['user']) ? trim($_GET['user']) : '';

$where = "WHERE (recipient_role = '" . addslashes($role) . "' OR recipient_role = 'all')";
if (!empty($user)) {
    $where .= " OR (recipient_name = '" . addslashes($user) . "')";
}

$sql = "SELECT * FROM `system_notifications` $where ORDER BY `created_at` DESC, `id` DESC LIMIT 50";
$res = $db->get_result($sql);

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
