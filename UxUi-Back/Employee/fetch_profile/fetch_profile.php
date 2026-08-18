<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

// Ensure employee_profiles table exists
$db->get_result("CREATE TABLE IF NOT EXISTS `employee_profiles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) DEFAULT 1,
    `full_name` varchar(255) DEFAULT '',
    `job_title` varchar(255) DEFAULT '',
    `department` varchar(255) DEFAULT '',
    `email` varchar(255) DEFAULT '',
    `phone` varchar(50) DEFAULT '',
    `nic` varchar(50) DEFAULT '',
    `dob` varchar(50) DEFAULT '',
    `gender` varchar(20) DEFAULT '',
    `address` varchar(255) DEFAULT '',
    `emergency_contact_name` varchar(255) DEFAULT '',
    `emergency_contact_phone` varchar(50) DEFAULT '',
    `profile_pic` varchar(255) DEFAULT '',
    `join_date` varchar(50) DEFAULT '',
    `employee_id_code` varchar(50) DEFAULT 'EMP-001',
    `work_location` varchar(100) DEFAULT 'Main Branch',
    `employment_type` varchar(100) DEFAULT 'Full-Time',
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// 1. Check if employees table has data to sync
$empCheck = $db->get_result("SELECT * FROM `employees` ORDER BY `id` ASC LIMIT 1");
$empData = ($empCheck && $empCheck->num_rows > 0) ? $empCheck->fetch_assoc() : null;

// 2. Fetch employee_profiles
$check = $db->get_result("SELECT * FROM `employee_profiles` WHERE `user_id` = 1 LIMIT 1");
if (!$check || $check->num_rows == 0) {
    $empName = $empData ? ($empData['fullname'] ?? ($empData['name'] ?? '')) : '';
    $empEmail = $empData ? ($empData['email_address'] ?? ($empData['email'] ?? '')) : '';
    $empDept = $empData ? ($empData['departments'] ?? ($empData['department'] ?? '')) : '';
    $empRole = $empData ? ($empData['job_roles'] ?? ($empData['role'] ?? '')) : '';
    $empJoined = $empData ? ($empData['joined_date'] ?? ($empData['join_date'] ?? '')) : '';
    $empPhone = $empData ? ($empData['contact_number'] ?? ($empData['phone'] ?? '')) : '';
    $empNic = $empData ? ($empData['nic_number'] ?? ($empData['nic'] ?? '')) : '';

    $db->get_result("INSERT INTO `employee_profiles` (
        `user_id`, `full_name`, `job_title`, `department`, `email`, `phone`, `nic`, `dob`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`, `profile_pic`, `join_date`, `employee_id_code`, `work_location`, `employment_type`
    ) VALUES (
        1, '" . addslashes($empName) . "', '" . addslashes($empRole) . "', '" . addslashes($empDept) . "', '" . addslashes($empEmail) . "', '" . addslashes($empPhone) . "', '" . addslashes($empNic) . "', '', '', '', '', '', '', '" . addslashes($empJoined) . "', 'EMP-001', 'HQ', 'Full-Time'
    )");
    $check = $db->get_result("SELECT * FROM `employee_profiles` WHERE `user_id` = 1 LIMIT 1");
}

$profile = $check ? $check->fetch_assoc() : [];

// If employees table has newer/active data, sync it dynamically
if ($empData && is_array($profile)) {
    if (!empty($empData['fullname']) && (!isset($profile['full_name']) || empty($profile['full_name']) || $profile['full_name'] === 'Amal Perera')) {
        $profile['full_name'] = $empData['fullname'];
        $db->get_result("UPDATE `employee_profiles` SET `full_name` = '" . addslashes($empData['fullname']) . "' WHERE `user_id` = 1");
    }
    if (!empty($empData['departments']) && (!isset($profile['department']) || empty($profile['department']) || $profile['department'] === 'Engineering')) {
        $profile['department'] = $empData['departments'];
        $db->get_result("UPDATE `employee_profiles` SET `department` = '" . addslashes($empData['departments']) . "' WHERE `user_id` = 1");
    }
    if (!empty($empData['job_roles']) && (!isset($profile['job_title']) || empty($profile['job_title']) || $profile['job_title'] === 'Senior Software Engineer')) {
        $profile['job_title'] = $empData['job_roles'];
        $db->get_result("UPDATE `employee_profiles` SET `job_title` = '" . addslashes($empData['job_roles']) . "' WHERE `user_id` = 1");
    }
    if (!empty($empData['email_address']) && (!isset($profile['email']) || empty($profile['email']))) {
        $profile['email'] = $empData['email_address'];
        $db->get_result("UPDATE `employee_profiles` SET `email` = '" . addslashes($empData['email_address']) . "' WHERE `user_id` = 1");
    }
}

echo json_encode([
    'status' => 'success',
    'data'   => $profile
]);
exit;
?>
