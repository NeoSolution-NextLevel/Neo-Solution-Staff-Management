<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$name   = isset($_POST['name']) ? trim($_POST['name']) : (isset($_POST['fullname']) ? trim($_POST['fullname']) : '');
$email  = isset($_POST['email']) ? trim($_POST['email']) : (isset($_POST['email_address']) ? trim($_POST['email_address']) : '');
$dept   = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['departments']) ? trim($_POST['departments']) : (isset($_POST['department']) ? trim($_POST['department']) : 'Engineering'));
$role   = isset($_POST['role']) ? trim($_POST['role']) : (isset($_POST['job_roles']) ? trim($_POST['job_roles']) : (isset($_POST['job_role']) ? trim($_POST['job_role']) : 'Staff'));
$status = isset($_POST['status']) ? trim($_POST['status']) : 'active';
$joined = isset($_POST['joined']) && !empty($_POST['joined']) ? trim($_POST['joined']) : (isset($_POST['joined_date']) && !empty($_POST['joined_date']) ? trim($_POST['joined_date']) : date('Y-m-d'));

if (empty($name) || empty($email)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Full name and Email address are required.'
    ]);
    exit;
}

$add_obj = new employee_ADD_UPDATE();
$add_obj->set_data($name, $email, $dept, $role, $status, $joined);
$res = $add_obj->process_new_record();

if ($res) {
    $new_emp_id = (int)$add_obj->get_id();
    $work_shift = isset($_POST['work_shift']) && !empty($_POST['work_shift']) ? trim($_POST['work_shift']) : '08:30 AM – 05:30 PM';
    $working_days = isset($_POST['working_days']) && !empty($_POST['working_days']) ? trim($_POST['working_days']) : 'Mon,Tue,Wed,Thu,Fri';
    $weekly_roster = isset($_POST['weekly_roster']) && !empty($_POST['weekly_roster']) ? trim($_POST['weekly_roster']) : '';

    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `work_shift` VARCHAR(100) DEFAULT '08:30 AM – 05:30 PM'");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `working_days` VARCHAR(255) DEFAULT 'Mon,Tue,Wed,Thu,Fri'");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `weekly_roster` TEXT DEFAULT NULL");

    $conn->query("INSERT INTO `employee_profiles` (`user_id`, `full_name`, `email`, `department`, `job_title`, `join_date`, `work_shift`, `working_days`, `weekly_roster`, `created_at`) 
                  VALUES ('$new_emp_id', '" . addslashes($name) . "', '" . addslashes($email) . "', '" . addslashes($dept) . "', '" . addslashes($role) . "', '" . addslashes($joined) . "', '" . addslashes($work_shift) . "', '" . addslashes($working_days) . "', '" . addslashes($weekly_roster) . "', NOW())
                  ON DUPLICATE KEY UPDATE `join_date` = '" . addslashes($joined) . "', `work_shift` = '" . addslashes($work_shift) . "', `working_days` = '" . addslashes($working_days) . "', `weekly_roster` = '" . addslashes($weekly_roster) . "'");
    $conn->query("UPDATE `main_user_login` SET `sdt` = '" . addslashes($joined) . " 00:00:00' WHERE `id` = '$new_emp_id' OR `user_name` = '" . addslashes($email) . "'");

    echo json_encode([
        'status'  => 'success',
        'message' => 'Employee added successfully in database.',
        'data'    => [
            'id'       => $new_emp_id,
            'initials' => $add_obj->get_initials(),
            'name'     => $name,
            'email'    => $email,
            'dept'     => $dept,
            'role'     => $role,
            'status'   => strtolower($status),
            'joined'   => $joined
        ]
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $add_obj->get_error()
    ]);
}
exit;
?>
