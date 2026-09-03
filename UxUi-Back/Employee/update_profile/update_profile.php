<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$db = new DataBase();
$conn = $db->get_data_base_connction();

$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;
if ($userId <= 0) $userId = 1;

$fullName   = isset($_POST['full_name']) ? trim($_POST['full_name']) : (isset($_POST['name']) ? trim($_POST['name']) : '');
$email      = isset($_POST['email']) ? trim($_POST['email']) : (isset($_POST['email_address']) ? trim($_POST['email_address']) : '');
$phone      = isset($_POST['phone']) ? trim($_POST['phone']) : (isset($_POST['contact_number']) ? trim($_POST['contact_number']) : (isset($_POST['phone_number']) ? trim($_POST['phone_number']) : ''));
$dept       = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['department']) ? trim($_POST['department']) : '');
$role       = isset($_POST['role']) ? trim($_POST['role']) : (isset($_POST['job_title']) ? trim($_POST['job_title']) : (isset($_POST['job_roles']) ? trim($_POST['job_roles']) : ''));
$status     = isset($_POST['status']) ? trim($_POST['status']) : 'active';
$joined     = isset($_POST['joined']) ? trim($_POST['joined']) : (isset($_POST['join_date']) ? trim($_POST['join_date']) : (isset($_POST['joined_date']) ? trim($_POST['joined_date']) : ''));
$nic        = isset($_POST['nic']) ? trim($_POST['nic']) : (isset($_POST['nic_number']) ? trim($_POST['nic_number']) : '');
$dob        = isset($_POST['dob']) ? trim($_POST['dob']) : (isset($_POST['date_of_birth']) ? trim($_POST['date_of_birth']) : '');
$gender     = isset($_POST['gender']) ? trim($_POST['gender']) : '';
$address    = isset($_POST['address']) ? trim($_POST['address']) : '';
$emName     = isset($_POST['emergency_contact_name']) ? trim($_POST['emergency_contact_name']) : (isset($_POST['emergency_name']) ? trim($_POST['emergency_name']) : '');
$emPhone    = isset($_POST['emergency_contact_phone']) ? trim($_POST['emergency_contact_phone']) : (isset($_POST['emergency_phone']) ? trim($_POST['emergency_phone']) : '');
$empCode    = isset($_POST['employee_id_code']) ? trim($_POST['employee_id_code']) : (isset($_POST['emp_code']) ? trim($_POST['emp_code']) : '');
$empType    = isset($_POST['employment_type']) ? trim($_POST['employment_type']) : '';
$location   = isset($_POST['work_location']) ? trim($_POST['work_location']) : (isset($_POST['location']) ? trim($_POST['location']) : '');
$workShift  = isset($_POST['work_shift']) ? trim($_POST['work_shift']) : '';
$workingDays= isset($_POST['working_days']) ? trim($_POST['working_days']) : '';
$weeklyRoster=isset($_POST['weekly_roster']) ? trim($_POST['weekly_roster']) : '';
$schedStart = isset($_POST['schedule_start_date']) ? trim($_POST['schedule_start_date']) : '';
$schedEnd   = isset($_POST['schedule_end_date']) ? trim($_POST['schedule_end_date']) : '';
$workMode   = isset($_POST['work_mode']) ? trim($_POST['work_mode']) : '';
$probation  = isset($_POST['probation_status']) ? trim($_POST['probation_status']) : (isset($_POST['probation']) ? trim($_POST['probation']) : '');
$probStart  = isset($_POST['probation_start_date']) ? trim($_POST['probation_start_date']) : '';
$probEnd    = isset($_POST['probation_end_date']) ? trim($_POST['probation_end_date']) : '';
$offStart   = isset($_POST['official_start_date']) ? trim($_POST['official_start_date']) : '';
$attDays    = isset($_POST['attendance_days']) ? (int)$_POST['attendance_days'] : null;
$source     = isset($_POST['source']) ? trim($_POST['source']) : '';
$isEmployeeSelf = ($source === 'employee_self');

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

// 1. Update or Insert into employee_profiles table
$prof_check = $conn->query("SELECT id FROM `employee_profiles` WHERE `user_id` = '$userId' OR `id` = '$userId' OR `email` = '" . addslashes($email) . "' LIMIT 1");
if ($prof_check && $prof_check->num_rows > 0) {
    $pRow = $prof_check->fetch_assoc();
    $prof_id = (int)$pRow['id'];

    $updates = [];
    if (!empty($fullName))  $updates[] = "`full_name` = '" . addslashes($fullName) . "'";
    if (!empty($email))     $updates[] = "`email` = '" . addslashes($email) . "'";
    if (!empty($phone))     $updates[] = "`phone` = '" . addslashes($phone) . "'";
    if (!empty($dept))      $updates[] = "`department` = '" . addslashes($dept) . "'";
    if (!empty($role))      $updates[] = "`job_title` = '" . addslashes($role) . "'";
    if (!empty($joined))    $updates[] = "`join_date` = '" . addslashes($joined) . "'";
    if (!empty($nic))       $updates[] = "`nic` = '" . addslashes($nic) . "'";
    if (!empty($dob))       $updates[] = "`dob` = '" . addslashes($dob) . "'";
    if (!empty($gender))    $updates[] = "`gender` = '" . addslashes($gender) . "'";
    if (!empty($address))   $updates[] = "`address` = '" . addslashes($address) . "'";
    if (!empty($emName))    $updates[] = "`emergency_contact_name` = '" . addslashes($emName) . "'";
    if (!empty($emPhone))   $updates[] = "`emergency_contact_phone` = '" . addslashes($emPhone) . "'";
    if (!empty($empCode))   $updates[] = "`employee_id_code` = '" . addslashes($empCode) . "'";
    if (!empty($empType))   $updates[] = "`employment_type` = '" . addslashes($empType) . "'";
    if (!empty($location))  $updates[] = "`work_location` = '" . addslashes($location) . "'";

    // Work schedule & shift timing can ONLY be updated by Administrator, never by employee self-service
    if (!$isEmployeeSelf) {
        if (!empty($workShift))   $updates[] = "`work_shift` = '" . addslashes($workShift) . "'";
        if (!empty($workingDays)) $updates[] = "`working_days` = '" . addslashes($workingDays) . "'";
        if (!empty($weeklyRoster))$updates[] = "`weekly_roster` = '" . addslashes($weeklyRoster) . "'";
        if (!empty($schedStart))  $updates[] = "`schedule_start_date` = '" . addslashes($schedStart) . "'";
        if (!empty($schedEnd))    $updates[] = "`schedule_end_date` = '" . addslashes($schedEnd) . "'";
        if (!empty($workMode))    $updates[] = "`work_mode` = '" . addslashes($workMode) . "'";
    }
    if (!empty($probation)) $updates[] = "`probation_status` = '" . addslashes($probation) . "'";
    if (!empty($probStart)) $updates[] = "`probation_start_date` = '" . addslashes($probStart) . "'";
    if (!empty($probEnd))   $updates[] = "`probation_end_date` = '" . addslashes($probEnd) . "'";
    if (!empty($offStart))  $updates[] = "`official_start_date` = '" . addslashes($offStart) . "'";
    if ($attDays !== null)  $updates[] = "`attendance_days` = " . (int)$attDays;

    if (!empty($updates)) {
        $conn->query("UPDATE `employee_profiles` SET " . implode(", ", $updates) . " WHERE `id` = '$prof_id'");
    }
} else {
    // Insert new record into employee_profiles
    $conn->query("INSERT INTO `employee_profiles` 
        (`user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `join_date`, `nic`, `dob`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`, `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`, `weekly_roster`, `schedule_start_date`, `schedule_end_date`, `work_mode`, `probation_status`, `probation_start_date`, `probation_end_date`, `official_start_date`, `attendance_days`, `created_at`) 
        VALUES 
        ('$userId', '" . addslashes($fullName) . "', '" . addslashes($email) . "', '" . addslashes($phone) . "', '" . addslashes($dept) . "', '" . addslashes($role) . "', '" . addslashes($joined) . "', '" . addslashes($nic) . "', '" . addslashes($dob) . "', '" . addslashes($gender) . "', '" . addslashes($address) . "', '" . addslashes($emName) . "', '" . addslashes($emPhone) . "', '" . addslashes($empCode) . "', '" . addslashes($empType) . "', '" . addslashes($location) . "', '" . addslashes($workShift) . "', '" . addslashes($workingDays) . "', '" . addslashes($weeklyRoster) . "', " . (!empty($schedStart) ? "'" . addslashes($schedStart) . "'" : "NULL") . ", " . (!empty($schedEnd) ? "'" . addslashes($schedEnd) . "'" : "NULL") . ", '" . addslashes($workMode) . "', '" . addslashes($probation) . "', " . (!empty($probStart) ? "'" . addslashes($probStart) . "'" : "NULL") . ", " . (!empty($probEnd) ? "'" . addslashes($probEnd) . "'" : "NULL") . ", " . (!empty($offStart) ? "'" . addslashes($offStart) . "'" : "NULL") . ", " . ($attDays !== null ? (int)$attDays : 0) . ", NOW())");
}

// 2. Also sync with employees table (phpMyAdmin exact table)
$emp_updates = [];
if (!empty($fullName)) $emp_updates[] = "`fullname` = '" . addslashes($fullName) . "'";
if (!empty($email))    $emp_updates[] = "`email_address` = '" . addslashes($email) . "'";
if (!empty($phone))    $emp_updates[] = "`phone_number` = '" . addslashes($phone) . "'";
if (!empty($dept))     $emp_updates[] = "`departments` = '" . addslashes($dept) . "'";
if (!empty($role))     $emp_updates[] = "`job_roles` = '" . addslashes($role) . "'";
if (!empty($status))   $emp_updates[] = "`status` = '" . addslashes($status) . "'";
if (!empty($joined))   $emp_updates[] = "`joined_date` = '" . addslashes($joined) . "'";

if (!empty($emp_updates)) {
    $conn->query("UPDATE `employees` SET " . implode(", ", $emp_updates) . " WHERE `id` = '$userId' OR `email_address` = '" . addslashes($email) . "' OR `fullname` = '" . addslashes($fullName) . "'");
}

// 3. Sync with main_user_login table
if (!empty($joined)) {
    $conn->query("UPDATE `main_user_login` SET `sdt` = '" . addslashes($joined) . " 00:00:00' WHERE `id` = '$userId' OR `user_name` = '" . addslashes($email) . "'");
}

// 4. Trigger Notification
$targetName = !empty($fullName) ? $fullName : 'Employee';
SystemNotifications::create(
    "Profile Updated",
    "Your employment details & profile information were successfully updated.",
    "profile_update",
    "employee",
    $targetName
);

echo json_encode([
    'status'  => 'success',
    'message' => 'Profile details saved successfully in database!',
    'data'    => [
        'full_name'               => $fullName,
        'email'                   => $email,
        'phone'                   => $phone,
        'department'              => $dept,
        'job_title'               => $role,
        'status'                  => $status,
        'join_date'               => $joined,
        'nic'                     => $nic,
        'dob'                     => $dob,
        'gender'                  => $gender,
        'address'                 => $address,
        'emergency_contact_name'  => $emName,
        'emergency_contact_phone' => $emPhone,
        'work_location'           => $location,
        'employment_type'         => $empType
    ]
]);
exit;
?>
