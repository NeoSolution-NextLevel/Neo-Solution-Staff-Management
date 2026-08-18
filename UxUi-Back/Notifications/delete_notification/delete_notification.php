<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

SystemNotifications::ensure_table();
$db = new DataBase();

$id   = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
$role = isset($_POST['role']) ? trim($_POST['role']) : (isset($_GET['role']) ? trim($_GET['role']) : 'admin');

if ($id > 0) {
    $db->get_result("DELETE FROM `system_notifications` WHERE `id` = '$id'");
} else {
    // Clear all for this role
    $db->get_result("DELETE FROM `system_notifications` WHERE `recipient_role` = '" . addslashes($role) . "' OR `recipient_role` = 'all'");
}

echo json_encode([
    'status'  => 'success',
    'message' => 'Notification(s) removed from database.'
]);
exit;
?>
