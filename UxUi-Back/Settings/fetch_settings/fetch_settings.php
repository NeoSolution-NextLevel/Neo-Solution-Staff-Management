<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$default_settings = [
    'email_notifications' => true,
    'task_updates'        => true,
    'leave_status'        => true,
    'system_alerts'       => false,
    'profile_visibility'  => true,
    'activity_status'     => false
];

if (!isset($_SESSION['app_settings'])) {
    $_SESSION['app_settings'] = $default_settings;
}

echo json_encode([
    'status' => 'success',
    'data'   => $_SESSION['app_settings']
]);
exit;
