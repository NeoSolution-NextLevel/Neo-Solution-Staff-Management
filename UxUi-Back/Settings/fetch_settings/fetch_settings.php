<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$default_settings = [
    'email_notifications' => true,
    'task_updates'        => true,
    'leave_status'        => true,
    'system_alerts'       => false,
    'profile_visibility'  => true,
    'activity_status'     => false
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

    // 2. Determine target table based on requested role or session
    $role_param = isset($_GET['role']) ? strtolower(trim($_GET['role'])) : (isset($_GET['type']) ? strtolower(trim($_GET['type'])) : '');
    if (empty($role_param)) {
        $sess_role = strtolower($_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '');
        $role_param = (strpos($sess_role, 'admin') !== false) ? 'admin' : 'employee';
    }

    $target_table = ($role_param === 'admin') ? 'admin_settings' : 'employee_settings';

    // 3. Identify user
    $user_id = $_SESSION['user_id'] ?? $_SESSION['main_user_login_id'] ?? $_SESSION['user_name'] ?? $_SESSION['user'] ?? '';
    $user_id_esc = !empty($user_id) ? $conn->real_escape_string((string)$user_id) : '';

    // Fetch user settings from respective table
    $query = !empty($user_id_esc) 
        ? "SELECT * FROM `$target_table` WHERE `user_id` = '$user_id_esc' LIMIT 1"
        : "SELECT * FROM `$target_table` ORDER BY `id` ASC LIMIT 1";
    $res = $conn->query($query);

    if ($res && $res->num_rows > 0 && $row = $res->fetch_assoc()) {
        $settings = [
            'email_notifications' => isset($row['email_notifications']) ? (bool)$row['email_notifications'] : true,
            'task_updates'        => isset($row['task_updates']) ? (bool)$row['task_updates'] : true,
            'leave_status'        => isset($row['leave_status']) ? (bool)$row['leave_status'] : true,
            'system_alerts'       => isset($row['system_alerts']) ? (bool)$row['system_alerts'] : false,
            'profile_visibility'  => isset($row['profile_visibility']) ? (bool)$row['profile_visibility'] : true,
            'activity_status'     => isset($row['activity_status']) ? (bool)$row['activity_status'] : false
        ];
    } else {
        $settings = $default_settings;
        $insert_uid = !empty($user_id_esc) ? $user_id_esc : '1';
        $ins = "INSERT INTO `$target_table` 
                (`user_id`, `email_notifications`, `task_updates`, `leave_status`, `system_alerts`, `profile_visibility`, `activity_status`, `created_at`, `updated_at`) 
                VALUES ('$insert_uid', 1, 1, 1, 0, 1, 0, NOW(), NOW())";
        @$conn->query($ins);
    }

    $_SESSION['app_settings'] = $settings;

    // 4. Fetch live user account information from main_user_login table
    $default_type = ($role_param === 'admin') ? 'Administrator' : 'Employee';
    $account_info = [
        'account_type'   => $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? $default_type,
        'account_status' => 'Active',
        'last_login'     => date('Y-m-d'),
        'member_since'   => date('Y-m-d')
    ];

    $found_user_id = 0;
    $found_user_name = '';

    $u_query = !empty($user_id_esc) 
        ? "SELECT `id`, `user_name`, `ac_type`, `account_active_state`, `last_login`, `sdt` FROM `main_user_login` WHERE `id` = '$user_id_esc' OR `user_name` = '$user_id_esc' LIMIT 1"
        : ($role_param === 'admin' 
            ? "SELECT `id`, `user_name`, `ac_type`, `account_active_state`, `last_login`, `sdt` FROM `main_user_login` WHERE `ac_type` LIKE '%Admin%' OR `main_user_account_access_level_list_id` = '1' ORDER BY `id` ASC LIMIT 1"
            : "SELECT `id`, `user_name`, `ac_type`, `account_active_state`, `last_login`, `sdt` FROM `main_user_login` ORDER BY `id` ASC LIMIT 1");

    $u_res = $conn->query($u_query);
    if ($u_res && $u_row = $u_res->fetch_assoc()) {
        $found_user_id = (int)$u_row['id'];
        $found_user_name = $u_row['user_name'];

        if (!empty($u_row['ac_type'])) {
            $account_info['account_type'] = $u_row['ac_type'];
        }
        $account_info['account_status'] = ($u_row['account_active_state'] == 1 || $u_row['account_active_state'] === null) ? 'Active' : 'Inactive';
        if (!empty($u_row['last_login'])) {
            $account_info['last_login'] = date('Y-m-d', strtotime($u_row['last_login']));
        }
        if (!empty($u_row['sdt'])) {
            $account_info['member_since'] = date('Y-m-d', strtotime($u_row['sdt']));
        }
    }

    // Check if custom join_date is set in employee_profiles
    $ep_q = "SELECT `join_date` FROM `employee_profiles` WHERE `user_id` = '$found_user_id' OR `user_id` = '$user_id_esc' OR `email` = '$user_id_esc' OR `email` = '$found_user_name' LIMIT 1";
    $ep_res = $conn->query($ep_q);
    if ($ep_res && $ep_row = $ep_res->fetch_assoc()) {
        if (!empty($ep_row['join_date'])) {
            $account_info['member_since'] = date('Y-m-d', strtotime($ep_row['join_date']));
        }
    } else {
        // Fallback to employees table joined_date
        $emp_q = "SELECT `joined_date` FROM `employees` WHERE `id` = '$found_user_id' OR `id` = '$user_id_esc' OR `email_address` = '$user_id_esc' OR `email_address` = '$found_user_name' LIMIT 1";
        $emp_res = $conn->query($emp_q);
        if ($emp_res && $emp_row = $emp_res->fetch_assoc()) {
            if (!empty($emp_row['joined_date'])) {
                $account_info['member_since'] = date('Y-m-d', strtotime($emp_row['joined_date']));
            }
        }
    }

    echo json_encode([
        'status'       => 'success',
        'table'        => $target_table,
        'role'         => $role_param,
        'data'         => $settings,
        'account_info' => $account_info
    ]);
} catch (Exception $e) {
    if (!isset($_SESSION['app_settings'])) {
        $_SESSION['app_settings'] = $default_settings;
    }
    echo json_encode([
        'status'       => 'success',
        'data'         => $_SESSION['app_settings'],
        'account_info' => [
            'account_type'   => $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? 'User',
            'account_status' => 'Active',
            'last_login'     => date('Y-m-d'),
            'member_since'   => date('Y-m-d')
        ]
    ]);
}
exit;
