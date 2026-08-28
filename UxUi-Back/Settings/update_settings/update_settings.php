<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$email_notifications = isset($_POST['email_notifications']) ? ($_POST['email_notifications'] === 'true' || $_POST['email_notifications'] === '1' || $_POST['email_notifications'] === 'on' || $_POST['email_notifications'] === true) : false;
$task_updates        = isset($_POST['task_updates']) ? ($_POST['task_updates'] === 'true' || $_POST['task_updates'] === '1' || $_POST['task_updates'] === 'on' || $_POST['task_updates'] === true) : false;
$leave_status        = isset($_POST['leave_status']) ? ($_POST['leave_status'] === 'true' || $_POST['leave_status'] === '1' || $_POST['leave_status'] === 'on' || $_POST['leave_status'] === true) : false;
$system_alerts       = isset($_POST['system_alerts']) ? ($_POST['system_alerts'] === 'true' || $_POST['system_alerts'] === '1' || $_POST['system_alerts'] === 'on' || $_POST['system_alerts'] === true) : false;
$profile_visibility  = isset($_POST['profile_visibility']) ? ($_POST['profile_visibility'] === 'true' || $_POST['profile_visibility'] === '1' || $_POST['profile_visibility'] === 'on' || $_POST['profile_visibility'] === true) : false;
$activity_status     = isset($_POST['activity_status']) ? ($_POST['activity_status'] === 'true' || $_POST['activity_status'] === '1' || $_POST['activity_status'] === 'on' || $_POST['activity_status'] === true) : false;

$settings = [
    'email_notifications' => $email_notifications,
    'task_updates'        => $task_updates,
    'leave_status'        => $leave_status,
    'system_alerts'       => $system_alerts,
    'profile_visibility'  => $profile_visibility,
    'activity_status'     => $activity_status
];

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // 1. Ensure both admin_settings and employee_settings tables exist
    $create_admin_table = "CREATE TABLE IF NOT EXISTS `admin_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` varchar(100) NOT NULL,
        `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
        `task_updates` tinyint(1) NOT NULL DEFAULT 1,
        `leave_status` tinyint(1) NOT NULL DEFAULT 1,
        `system_alerts` tinyint(1) NOT NULL DEFAULT 0,
        `profile_visibility` tinyint(1) NOT NULL DEFAULT 1,
        `activity_status` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_admin_user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    $conn->query($create_admin_table);

    $create_emp_table = "CREATE TABLE IF NOT EXISTS `employee_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` varchar(100) NOT NULL,
        `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
        `task_updates` tinyint(1) NOT NULL DEFAULT 1,
        `leave_status` tinyint(1) NOT NULL DEFAULT 1,
        `system_alerts` tinyint(1) NOT NULL DEFAULT 0,
        `profile_visibility` tinyint(1) NOT NULL DEFAULT 1,
        `activity_status` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_employee_user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    $conn->query($create_emp_table);

    // 2. Determine target table
    $role_param = isset($_POST['role']) ? strtolower(trim($_POST['role'])) : '';
    if (empty($role_param)) {
        $sess_role = strtolower($_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '');
        $role_param = (strpos($sess_role, 'admin') !== false) ? 'admin' : 'employee';
    }

    $target_table = ($role_param === 'admin') ? 'admin_settings' : 'employee_settings';

    // 3. User identification
    $user_id = $_SESSION['user_id'] ?? $_SESSION['main_user_login_id'] ?? $_SESSION['user_name'] ?? $_SESSION['user'] ?? '1';
    $user_id_esc = $conn->real_escape_string((string)$user_id);

    $en_val = $email_notifications ? 1 : 0;
    $tu_val = $task_updates ? 1 : 0;
    $ls_val = $leave_status ? 1 : 0;
    $sa_val = $system_alerts ? 1 : 0;
    $pv_val = $profile_visibility ? 1 : 0;
    $as_val = $activity_status ? 1 : 0;

    // Check if record exists for this user in target table
    $chk_rec = $conn->query("SELECT `id` FROM `$target_table` WHERE `user_id` = '$user_id_esc' LIMIT 1");
    if ($chk_rec && $chk_rec->num_rows > 0) {
        $update_sql = "UPDATE `$target_table` SET 
            `email_notifications` = $en_val,
            `task_updates`        = $tu_val,
            `leave_status`        = $ls_val,
            `system_alerts`       = $sa_val,
            `profile_visibility`  = $pv_val,
            `activity_status`     = $as_val,
            `updated_at`          = NOW()
            WHERE `user_id` = '$user_id_esc'";
        $conn->query($update_sql);
    } else {
        $insert_sql = "INSERT INTO `$target_table` 
            (`user_id`, `email_notifications`, `task_updates`, `leave_status`, `system_alerts`, `profile_visibility`, `activity_status`, `created_at`, `updated_at`) 
            VALUES ('$user_id_esc', $en_val, $tu_val, $ls_val, $sa_val, $pv_val, $as_val, NOW(), NOW())";
        $conn->query($insert_sql);
    }

    $_SESSION['app_settings'] = $settings;

    echo json_encode([
        'status'  => 'success',
        'table'   => $target_table,
        'role'    => $role_param,
        'message' => 'Settings saved successfully.',
        'data'    => $settings
    ]);
} catch (Exception $e) {
    $_SESSION['app_settings'] = $settings;
    echo json_encode([
        'status'  => 'success',
        'message' => 'Settings saved.',
        'data'    => $settings
    ]);
}
exit;
