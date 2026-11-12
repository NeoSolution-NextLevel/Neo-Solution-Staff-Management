<?php
/**
 * send_notification.php
 * Endpoint for sending notifications in NEO Solution Staff Management System.
 * Accessible to Administrators and authorized staff.
 */
require_once __DIR__ . '/notification-config.php';
require_once __DIR__ . '/notification_dispatch.php';

$senderId = ems_require_main_user_login();
if (!ems_is_admin() && !ems_is_superadmin()) {
    ems_json(['ok' => false, 'error' => 'Only administrators can send broadcast notifications'], 403);
}

$type = trim($_POST['type'] ?? ($_POST['audience'] ?? ($_POST['category'] ?? ($_POST['target'] ?? 'all'))));
$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? ($_POST['message'] ?? ''));
$category_or_audience = trim($_POST['category'] ?? ($_POST['subscription_id'] ?? ($_POST['target'] ?? '')));
$image_pth = trim($_POST['image_pth'] ?? ($_POST['image_path'] ?? ''));
$targetUserId = isset($_POST['target_user_id']) ? (int)$_POST['target_user_id'] : (isset($_POST['target_member_user_id']) ? (int)$_POST['target_member_user_id'] : 0);

$result = ems_dispatch_admin_notification($type, $title, $body, $category_or_audience, $senderId, $image_pth, 0, $targetUserId);
if (empty($result['ok'])) {
    ems_json(['ok' => false, 'error' => $result['error'] ?? 'Send failed'], 400);
}

ems_json($result);
