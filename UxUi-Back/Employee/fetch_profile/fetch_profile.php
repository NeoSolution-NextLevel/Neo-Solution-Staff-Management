<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();
$conn = $db->get_data_base_connction();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if ($userId === 0 && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $userId = (int)$_SESSION['user_id'];
}
$mainUserId = isset($_SESSION['main_user_login_id']) && !empty($_SESSION['main_user_login_id'])
    ? (int)$_SESSION['main_user_login_id']
    : $userId;
$empProfileId = isset($_SESSION['employee_profile_id']) ? (int)$_SESSION['employee_profile_id'] : 0;
$userEmail = isset($_SESSION['user_name']) ? trim((string)$_SESSION['user_name']) : '';
$safeEmail = addslashes($userEmail);

$profile = null;

try {
    // 0. Ensure columns exist
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `probation_start_date` DATE DEFAULT NULL");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `probation_end_date` DATE DEFAULT NULL");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `official_start_date` DATE DEFAULT NULL");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `probation_status` VARCHAR(100) DEFAULT 'In Progress'");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `work_shift` VARCHAR(100) DEFAULT '08:30 AM – 05:30 PM'");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `working_days` VARCHAR(255) DEFAULT 'Mon,Tue,Wed,Thu,Fri'");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `weekly_roster` TEXT DEFAULT NULL");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `schedule_start_date` DATE DEFAULT NULL");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `schedule_end_date` DATE DEFAULT NULL");
    @$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `work_mode` VARCHAR(100) DEFAULT 'On-Site (Active)'");

    // 1. Try to find in employee_profiles table
    $whereClauses = [];
    if ($empProfileId > 0)  $whereClauses[] = "`id` = '{$empProfileId}'";
    if ($mainUserId > 0)    $whereClauses[] = "`user_id` = '{$mainUserId}'";
    if ($userId > 0)        $whereClauses[] = "(`user_id` = '{$userId}' OR `id` = '{$userId}')";
    if (!empty($safeEmail)) $whereClauses[] = "`email` = '{$safeEmail}'";

    $whereSql = !empty($whereClauses) ? implode(' OR ', $whereClauses) : "`id` = 1";
    $check = $conn->query("SELECT * FROM `employee_profiles` WHERE {$whereSql} LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $p = $check->fetch_assoc();
        $name = !empty($p['full_name']) ? $p['full_name'] : '';
        $profile = [
            'id'                      => (int)$p['id'],
            'user_id'                 => (int)($p['user_id'] ?? $userId),
            'full_name'               => $name,
            'email'                   => !empty($p['email']) ? $p['email'] : '',
            'phone'                   => !empty($p['phone']) ? $p['phone'] : '',
            'department'              => !empty($p['department']) ? $p['department'] : 'Engineering',
            'job_title'               => !empty($p['job_title']) ? $p['job_title'] : 'Staff',
            'status'                  => 'active',
            'join_date'               => !empty($p['join_date']) ? $p['join_date'] : date('Y-m-d'),
            'nic'                     => !empty($p['nic']) ? $p['nic'] : '',
            'dob'                     => !empty($p['dob']) ? $p['dob'] : '',
            'gender'                  => !empty($p['gender']) ? $p['gender'] : 'Male',
            'address'                 => !empty($p['address']) ? $p['address'] : '',
            'emergency_contact_name'  => !empty($p['emergency_contact_name']) ? $p['emergency_contact_name'] : '',
            'emergency_contact_phone' => !empty($p['emergency_contact_phone']) ? $p['emergency_contact_phone'] : '',
            'employee_id_code'        => !empty($p['employee_id_code']) ? $p['employee_id_code'] : 'EMP-' . str_pad($p['id'], 3, '0', STR_PAD_LEFT),
            'employment_type'         => !empty($p['employment_type']) ? $p['employment_type'] : 'Full-Time',
            'work_location'           => !empty($p['work_location']) ? $p['work_location'] : 'Colombo HQ',
            'work_shift'              => !empty($p['work_shift']) ? $p['work_shift'] : '08:30 AM – 05:30 PM',
            'working_days'            => !empty($p['working_days']) ? $p['working_days'] : 'Mon,Tue,Wed,Thu,Fri',
            'weekly_roster'           => !empty($p['weekly_roster']) ? $p['weekly_roster'] : '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"wfh","Sat":"leave","Sun":"leave"}',
            'schedule_start_date'     => !empty($p['schedule_start_date']) ? $p['schedule_start_date'] : date('Y-m-01'),
            'schedule_end_date'       => !empty($p['schedule_end_date']) ? $p['schedule_end_date'] : date('Y-12-31'),
            'work_mode'               => !empty($p['work_mode']) ? $p['work_mode'] : 'On-Site (Active)',
            'probation_status'        => !empty($p['probation_status']) ? $p['probation_status'] : 'In Progress',
            'probation_start_date'    => !empty($p['probation_start_date']) ? $p['probation_start_date'] : (!empty($p['join_date']) ? $p['join_date'] : ''),
            'probation_end_date'      => !empty($p['probation_end_date']) ? $p['probation_end_date'] : '',
            'official_start_date'     => !empty($p['official_start_date']) ? $p['official_start_date'] : '',
            'attendance_days'         => isset($p['attendance_days']) ? (int)$p['attendance_days'] : null,
            'profile_pic'             => !empty($p['profile_pic']) ? $p['profile_pic'] : ''
        ];
    } else {
        // 2. Fallback to employees table
        $empWhereClauses = [];
        if ($empProfileId > 0)  $empWhereClauses[] = "`id` = '{$empProfileId}'";
        if ($userId > 0)        $empWhereClauses[] = "`id` = '{$userId}'";
        if (!empty($safeEmail)) $empWhereClauses[] = "(`email_address` = '{$safeEmail}' OR `email` = '{$safeEmail}')";

        $empWhereSql = !empty($empWhereClauses) ? implode(' OR ', $empWhereClauses) : "`id` = '{$userId}'";
        $empCheck = $conn->query("SELECT * FROM `employees` WHERE {$empWhereSql} LIMIT 1");
        if ($empCheck && $empCheck->num_rows > 0) {
            $e = $empCheck->fetch_assoc();
            $fullname = !empty($e['fullname']) ? $e['fullname'] : (!empty($e['name']) ? $e['name'] : 'Employee');
            $email = !empty($e['email_address']) ? $e['email_address'] : (!empty($e['email']) ? $e['email'] : '');
            $dept = !empty($e['departments']) ? $e['departments'] : (!empty($e['department']) ? $e['department'] : 'Engineering');
            $role = !empty($e['job_roles']) ? $e['job_roles'] : (!empty($e['job_role']) ? $e['job_role'] : 'Staff');
            $phone = !empty($e['phone_number']) ? $e['phone_number'] : (!empty($e['phone']) ? $e['phone'] : '');
            $joined = !empty($e['joined_date']) ? $e['joined_date'] : (!empty($e['joined']) ? $e['joined'] : date('Y-m-d'));

            $profile = [
                'id'                      => (int)$e['id'],
                'user_id'                 => (int)$e['id'],
                'full_name'               => $fullname,
                'email'                   => $email,
                'phone'                   => $phone,
                'department'              => $dept,
                'job_title'               => $role,
                'status'                  => !empty($e['status']) ? strtolower($e['status']) : 'active',
                'join_date'               => $joined,
                'nic'                     => !empty($e['nic_number']) ? $e['nic_number'] : '',
                'dob'                     => !empty($e['date_of_birth']) ? $e['date_of_birth'] : '',
                'gender'                  => !empty($e['gender']) ? $e['gender'] : 'Male',
                'address'                 => !empty($e['address']) ? $e['address'] : '',
                'emergency_contact_name'  => '',
                'emergency_contact_phone' => '',
                'employee_id_code'        => 'EMP-' . str_pad($e['id'], 3, '0', STR_PAD_LEFT),
                'employment_type'         => 'Full-Time',
                'work_location'           => 'Colombo HQ',
                'profile_pic'             => ''
            ];
        }
    }
} catch (Exception $ex) {
    $profile = null;
}

echo json_encode([
    'status' => 'success',
    'data'   => $profile
]);
exit;
?>
