<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['app_settings']) || !is_array($_SESSION['app_settings'])) {
    $_SESSION['app_settings'] = [];
}

$_SESSION['app_settings']['email_notifications'] = isset($_POST['email_notifications']) ? ($_POST['email_notifications'] === 'true' || $_POST['email_notifications'] === '1' || $_POST['email_notifications'] === 'on') : false;
$_SESSION['app_settings']['task_updates']        = isset($_POST['task_updates']) ? ($_POST['task_updates'] === 'true' || $_POST['task_updates'] === '1' || $_POST['task_updates'] === 'on') : false;
$_SESSION['app_settings']['leave_status']        = isset($_POST['leave_status']) ? ($_POST['leave_status'] === 'true' || $_POST['leave_status'] === '1' || $_POST['leave_status'] === 'on') : false;
$_SESSION['app_settings']['system_alerts']       = isset($_POST['system_alerts']) ? ($_POST['system_alerts'] === 'true' || $_POST['system_alerts'] === '1' || $_POST['system_alerts'] === 'on') : false;
$_SESSION['app_settings']['profile_visibility']  = isset($_POST['profile_visibility']) ? ($_POST['profile_visibility'] === 'true' || $_POST['profile_visibility'] === '1' || $_POST['profile_visibility'] === 'on') : false;
$_SESSION['app_settings']['activity_status']     = isset($_POST['activity_status']) ? ($_POST['activity_status'] === 'true' || $_POST['activity_status'] === '1' || $_POST['activity_status'] === 'on') : false;

echo json_encode([
    'status'  => 'success',
    'message' => 'Settings saved successfully.',
    'data'    => $_SESSION['app_settings']
]);
exit;
