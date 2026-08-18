<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Notifications Modules
 */
$notif_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($notif_action) {
    case 'mark_read':
    case 'read':
        include_once __DIR__ . '/../mark_notification_read/mark_notification_read.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_notification/delete_notification.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_notification/fetch_notification.php';
        break;
}
