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

// 1. Extract inputs matching exact employee_profiles table columns
$profileId              = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$userId                 = isset($_POST['user_id']) ? (int)$_POST['user_id'] : ($profileId > 0 ? $profileId : 1);
if ($userId <= 0) $userId = 1;

$fullName               = isset($_POST['full_name']) ? trim($_POST['full_name']) : (isset($_POST['name']) ? trim($_POST['name']) : '');
$jobTitle               = isset($_POST['job_title']) ? trim($_POST['job_title']) : (isset($_POST['role']) ? trim($_POST['role']) : (isset($_POST['job_roles']) ? trim($_POST['job_roles']) : ''));
$department             = isset($_POST['department']) ? trim($_POST['department']) : (isset($_POST['dept']) ? trim($_POST['dept']) : '');
$email                  = isset($_POST['email']) ? trim($_POST['email']) : (isset($_POST['email_address']) ? trim($_POST['email_address']) : '');
$phone                  = isset($_POST['phone']) ? trim($_POST['phone']) : (isset($_POST['contact_number']) ? trim($_POST['contact_number']) : (isset($_POST['phone_number']) ? trim($_POST['phone_number']) : ''));
$nic                    = isset($_POST['nic']) ? trim($_POST['nic']) : (isset($_POST['nic_number']) ? trim($_POST['nic_number']) : '');
$dob                    = isset($_POST['dob']) ? trim($_POST['dob']) : (isset($_POST['date_of_birth']) ? trim($_POST['date_of_birth']) : '');
$gender                 = isset($_POST['gender']) ? trim($_POST['gender']) : '';
$address                = isset($_POST['address']) ? trim($_POST['address']) : '';
$emergencyContactName   = isset($_POST['emergency_contact_name']) ? trim($_POST['emergency_contact_name']) : (isset($_POST['emergency_name']) ? trim($_POST['emergency_name']) : '');
$emergencyContactPhone  = isset($_POST['emergency_contact_phone']) ? trim($_POST['emergency_contact_phone']) : (isset($_POST['emergency_phone']) ? trim($_POST['emergency_phone']) : '');
$profilePic             = isset($_POST['profile_pic']) ? trim($_POST['profile_pic']) : (isset($_POST['avatar']) ? trim($_POST['avatar']) : '');
$joinDate               = isset($_POST['join_date']) ? trim($_POST['join_date']) : (isset($_POST['joined']) ? trim($_POST['joined']) : (isset($_POST['joined_date']) ? trim($_POST['joined_date']) : ''));
$employeeIdCode         = isset($_POST['employee_id_code']) ? trim($_POST['employee_id_code']) : (isset($_POST['emp_code']) ? trim($_POST['emp_code']) : '');
$workLocation           = isset($_POST['work_location']) ? trim($_POST['work_location']) : (isset($_POST['location']) ? trim($_POST['location']) : '');
$employmentType         = isset($_POST['employment_type']) ? trim($_POST['employment_type']) : '';
$attendanceDays         = isset($_POST['attendance_days']) ? (int)$_POST['attendance_days'] : null;
$lastAttendanceDate     = isset($_POST['last_attendance_date']) ? trim($_POST['last_attendance_date']) : '';
$probationStartDate     = isset($_POST['probation_start_date']) ? trim($_POST['probation_start_date']) : '';
$probationEndDate       = isset($_POST['probation_end_date']) ? trim($_POST['probation_end_date']) : '';
$officialStartDate      = isset($_POST['official_start_date']) ? trim($_POST['official_start_date']) : '';
$probationStatus        = isset($_POST['probation_status']) ? trim($_POST['probation_status']) : (isset($_POST['probation']) ? trim($_POST['probation']) : '');
$workShift              = isset($_POST['work_shift']) ? trim($_POST['work_shift']) : '';
$workingDays            = isset($_POST['working_days']) ? trim($_POST['working_days']) : '';
$scheduleStartDate      = isset($_POST['schedule_start_date']) ? trim($_POST['schedule_start_date']) : '';
$scheduleEndDate        = isset($_POST['schedule_end_date']) ? trim($_POST['schedule_end_date']) : '';
$workMode               = isset($_POST['work_mode']) ? trim($_POST['work_mode']) : '';
$weeklyRoster           = isset($_POST['weekly_roster']) ? trim($_POST['weekly_roster']) : '';
$status                 = isset($_POST['status']) ? trim($_POST['status']) : 'active';

$source                 = isset($_POST['source']) ? trim($_POST['source']) : '';
$isEmployeeSelf         = ($source === 'employee_self');

// Bank details extraction
$bankName   = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
$branch     = isset($_POST['branch']) ? trim($_POST['branch']) : '';
$accNumber  = isset($_POST['account_number']) ? trim($_POST['account_number']) : (isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : '');
$holderName = isset($_POST['holder_name']) ? trim($_POST['holder_name']) : (isset($_POST['account_holder_name']) ? trim($_POST['account_holder_name']) : $fullName);
$basicSal   = isset($_POST['basic_salary']) ? (float)$_POST['basic_salary'] : 0.00;
$netSal     = isset($_POST['net_salary']) ? (float)$_POST['net_salary'] : $basicSal;

// 0. Ensure all employee_profiles columns exist
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `job_title` VARCHAR(255) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `department` VARCHAR(255) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `nic` VARCHAR(50) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `dob` DATE DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `gender` VARCHAR(20) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `address` TEXT DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `emergency_contact_name` VARCHAR(255) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `emergency_contact_phone` VARCHAR(50) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `profile_pic` VARCHAR(255) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `join_date` DATE DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `employee_id_code` VARCHAR(50) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `work_location` VARCHAR(100) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `employment_type` VARCHAR(100) DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `attendance_days` INT DEFAULT 0");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `last_attendance_date` DATE DEFAULT NULL");
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
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `status` VARCHAR(50) DEFAULT 'active'");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

// 2. Update or Insert into employee_profiles table
$whereCheck = [];
if ($profileId > 0) {
    $whereCheck[] = "`id` = '$profileId'";
}
if ($userId > 0) {
    $whereCheck[] = "`user_id` = '$userId'";
    $whereCheck[] = "`id` = '$userId'";
}
if (!empty($email)) {
    $whereCheck[] = "`email` = '" . addslashes($email) . "'";
}
$whereSql = !empty($whereCheck) ? implode(' OR ', $whereCheck) : "`id` = '$userId'";
$prof_check = $conn->query("SELECT id FROM `employee_profiles` WHERE {$whereSql} LIMIT 1");

$prof_id = 0;
if ($prof_check && $prof_check->num_rows > 0) {
    $pRow = $prof_check->fetch_assoc();
    $prof_id = (int)$pRow['id'];

    $updates = [];
    $updates[] = "`updated_at` = NOW()";

    // Personal fields (editable by employee self or admin)
    if (!empty($fullName))                          $updates[] = "`full_name` = '" . addslashes($fullName) . "'";
    if (!empty($phone))                             $updates[] = "`phone` = '" . addslashes($phone) . "'";
    if (!empty($nic))                               $updates[] = "`nic` = '" . addslashes($nic) . "'";
    if (!empty($dob))                               $updates[] = "`dob` = '" . addslashes($dob) . "'";
    if (!empty($gender))                            $updates[] = "`gender` = '" . addslashes($gender) . "'";
    if (isset($_POST['address']))                   $updates[] = "`address` = '" . addslashes($address) . "'";
    if (isset($_POST['profile_pic']) && !empty($profilePic)) $updates[] = "`profile_pic` = '" . addslashes($profilePic) . "'";
    if (isset($_POST['emergency_contact_name']))    $updates[] = "`emergency_contact_name` = '" . addslashes($emergencyContactName) . "'";
    if (isset($_POST['emergency_contact_phone']))   $updates[] = "`emergency_contact_phone` = '" . addslashes($emergencyContactPhone) . "'";

    // Organization & Administration fields (only updated by Administrator, protected from self-service overwrite)
    if (!$isEmployeeSelf) {
        if (!empty($email))                $updates[] = "`email` = '" . addslashes($email) . "'";
        if (!empty($jobTitle))             $updates[] = "`job_title` = '" . addslashes($jobTitle) . "'";
        if (!empty($department))           $updates[] = "`department` = '" . addslashes($department) . "'";
        if (!empty($joinDate))             $updates[] = "`join_date` = '" . addslashes($joinDate) . "'";
        if (!empty($employeeIdCode))       $updates[] = "`employee_id_code` = '" . addslashes($employeeIdCode) . "'";
        if (!empty($employmentType))       $updates[] = "`employment_type` = '" . addslashes($employmentType) . "'";
        if (!empty($workLocation))         $updates[] = "`work_location` = '" . addslashes($workLocation) . "'";
        if (!empty($workShift))            $updates[] = "`work_shift` = '" . addslashes($workShift) . "'";
        if (!empty($workingDays))          $updates[] = "`working_days` = '" . addslashes($workingDays) . "'";
        if (!empty($weeklyRoster))         $updates[] = "`weekly_roster` = '" . addslashes($weeklyRoster) . "'";
        if (!empty($scheduleStartDate))    $updates[] = "`schedule_start_date` = '" . addslashes($scheduleStartDate) . "'";
        if (!empty($scheduleEndDate))      $updates[] = "`schedule_end_date` = '" . addslashes($scheduleEndDate) . "'";
        if (!empty($workMode))             $updates[] = "`work_mode` = '" . addslashes($workMode) . "'";
        if (!empty($probationStatus))      $updates[] = "`probation_status` = '" . addslashes($probationStatus) . "'";
        if (!empty($probationStartDate))   $updates[] = "`probation_start_date` = '" . addslashes($probationStartDate) . "'";
        if (!empty($probationEndDate))     $updates[] = "`probation_end_date` = '" . addslashes($probationEndDate) . "'";
        if (!empty($officialStartDate))    $updates[] = "`official_start_date` = '" . addslashes($officialStartDate) . "'";
        if ($attendanceDays !== null)      $updates[] = "`attendance_days` = " . (int)$attendanceDays;
        if (!empty($lastAttendanceDate))   $updates[] = "`last_attendance_date` = '" . addslashes($lastAttendanceDate) . "'";
        if (!empty($status))               $updates[] = "`status` = '" . addslashes($status) . "'";
    }

    if (!empty($updates)) {
        $conn->query("UPDATE `employee_profiles` SET " . implode(", ", $updates) . " WHERE `id` = '$prof_id'");
    }
} else {
    // Insert new record into employee_profiles using full column list
    $conn->query("INSERT INTO `employee_profiles` (
        `user_id`,
        `full_name`,
        `job_title`,
        `department`,
        `email`,
        `phone`,
        `nic`,
        `dob`,
        `gender`,
        `address`,
        `emergency_contact_name`,
        `emergency_contact_phone`,
        `profile_pic`,
        `join_date`,
        `employee_id_code`,
        `work_location`,
        `employment_type`,
        `attendance_days`,
        `last_attendance_date`,
        `probation_start_date`,
        `probation_end_date`,
        `official_start_date`,
        `probation_status`,
        `work_shift`,
        `working_days`,
        `schedule_start_date`,
        `schedule_end_date`,
        `work_mode`,
        `weekly_roster`,
        `status`,
        `updated_at`,
        `created_at`
    ) VALUES (
        '$userId',
        '" . addslashes($fullName) . "',
        '" . addslashes($jobTitle) . "',
        '" . addslashes($department) . "',
        '" . addslashes($email) . "',
        '" . addslashes($phone) . "',
        '" . addslashes($nic) . "',
        '" . addslashes($dob) . "',
        '" . addslashes($gender) . "',
        '" . addslashes($address) . "',
        '" . addslashes($emergencyContactName) . "',
        '" . addslashes($emergencyContactPhone) . "',
        '" . addslashes($profilePic) . "',
        '" . addslashes($joinDate) . "',
        '" . addslashes($employeeIdCode ?: ('EMP-' . $userId)) . "',
        '" . addslashes($workLocation) . "',
        '" . addslashes($employmentType) . "',
        " . ($attendanceDays !== null ? (int)$attendanceDays : 0) . ",
        " . (!empty($lastAttendanceDate) ? "'" . addslashes($lastAttendanceDate) . "'" : "NULL") . ",
        " . (!empty($probationStartDate) ? "'" . addslashes($probationStartDate) . "'" : "NULL") . ",
        " . (!empty($probationEndDate) ? "'" . addslashes($probationEndDate) . "'" : "NULL") . ",
        " . (!empty($officialStartDate) ? "'" . addslashes($officialStartDate) . "'" : "NULL") . ",
        '" . addslashes($probationStatus ?: 'In Progress') . "',
        '" . addslashes($workShift ?: '08:30 AM – 05:30 PM') . "',
        '" . addslashes($workingDays ?: 'Mon,Tue,Wed,Thu,Fri') . "',
        " . (!empty($scheduleStartDate) ? "'" . addslashes($scheduleStartDate) . "'" : "NULL") . ",
        " . (!empty($scheduleEndDate) ? "'" . addslashes($scheduleEndDate) . "'" : "NULL") . ",
        '" . addslashes($workMode ?: 'On-Site (Active)') . "',
        '" . addslashes($weeklyRoster) . "',
        '" . addslashes($status ?: 'active') . "',
        NOW(),
        NOW()
    )");
    $prof_id = (int)$conn->insert_id;
}

// 3. Also sync with companion `employees` table
$emp_updates = [];
if (!empty($fullName)) $emp_updates[] = "`fullname` = '" . addslashes($fullName) . "'";
if (!empty($phone))    $emp_updates[] = "`phone_number` = '" . addslashes($phone) . "'";

if (!$isEmployeeSelf) {
    if (!empty($email))      $emp_updates[] = "`email_address` = '" . addslashes($email) . "'";
    if (!empty($department)) $emp_updates[] = "`departments` = '" . addslashes($department) . "'";
    if (!empty($jobTitle))   $emp_updates[] = "`job_roles` = '" . addslashes($jobTitle) . "'";
    if (!empty($status))     $emp_updates[] = "`status` = '" . addslashes($status) . "'";
    if (!empty($joinDate))   $emp_updates[] = "`joined_date` = '" . addslashes($joinDate) . "'";
}

if (!empty($emp_updates)) {
    $conn->query("UPDATE `employees` SET " . implode(", ", $emp_updates) . " WHERE `id` = '$userId' OR `email_address` = '" . addslashes($email) . "' OR `fullname` = '" . addslashes($fullName) . "'");
}

// 4. Sync with main_user_login table
if (!$isEmployeeSelf && !empty($joinDate)) {
    $conn->query("UPDATE `main_user_login` SET `sdt` = '" . addslashes($joinDate) . " 00:00:00' WHERE `id` = '$userId' OR `user_name` = '" . addslashes($email) . "'");
}

// 5. Sync job roles employee count according to department
include_once __DIR__ . '/../../Job_Roles/sync_job_roles_count.php';
if (function_exists('sync_job_role_employee_counts')) {
    sync_job_role_employee_counts($conn);
}

// 6. Sync with bank_details table if bank information provided or salary updated
if (!empty($bankName) || !empty($accNumber) || (!$isEmployeeSelf && (isset($_POST['basic_salary']) || isset($_POST['net_salary'])))) {
    include_once __DIR__ . '/../../../Controllers/Main/Bank_Details/Bank_Security.php';
    $encAcc = !empty($accNumber) ? Bank_Security::encrypt($accNumber) : '';
    $bCheck = $conn->query("SELECT id, bank_account_number, account_number FROM `bank_details` WHERE `user_id` = '$userId' OR `employee_id` = '" . addslashes($employeeIdCode) . "' OR `employee_name` = '" . addslashes($fullName) . "' OR `holder_name` = '" . addslashes($fullName) . "' ORDER BY `id` DESC LIMIT 1");
    if ($bCheck && $bCheck->num_rows > 0) {
        $bRow = $bCheck->fetch_assoc();
        $bId = (int)$bRow['id'];
        $bUpdates = [];
        if (!empty($bankName) && $bankName !== 'Bank Name') $bUpdates[] = "`bank_name` = '" . addslashes($bankName) . "'";
        if (!empty($branch) && $branch !== 'Branch Name') $bUpdates[] = "`branch` = '" . addslashes($branch) . "'";
        if (!empty($encAcc)) {
            $bUpdates[] = "`bank_account_number` = '" . addslashes($encAcc) . "'";
            $bUpdates[] = "`account_number` = '" . addslashes($encAcc) . "'";
        }
        if (!empty($holderName) && $holderName !== 'Employee Account Holder') $bUpdates[] = "`holder_name` = '" . addslashes($holderName) . "'";
        if (!empty($fullName)) $bUpdates[] = "`employee_name` = '" . addslashes($fullName) . "'";
        if (!empty($employeeIdCode)) $bUpdates[] = "`employee_id_code` = '" . addslashes($employeeIdCode) . "'";
        if (!$isEmployeeSelf && isset($_POST['basic_salary'])) $bUpdates[] = "`basic_salary` = " . (float)$basicSal;
        if (!$isEmployeeSelf && isset($_POST['net_salary'])) $bUpdates[] = "`net_salary` = " . (float)$netSal;
        if (!empty($bUpdates)) {
            $conn->query("UPDATE `bank_details` SET " . implode(", ", $bUpdates) . " WHERE `id` = '$bId'");
        }
    } else if (!empty($bankName) && !empty($encAcc)) {
        $conn->query("INSERT INTO `bank_details` 
            (`user_id`, `employee_id`, `employee_name`, `holder_name`, `bank_name`, `branch`, `bank_account_number`, `account_number`, `basic_salary`, `net_salary`, `status`, `ast`, `sdt`) 
            VALUES 
            ('$userId', '" . addslashes($employeeIdCode ?: ('EMP-' . $userId)) . "', '" . addslashes($fullName) . "', '" . addslashes($holderName ?: $fullName) . "', '" . addslashes($bankName) . "', '" . addslashes($branch) . "', '" . addslashes($encAcc) . "', '" . addslashes($encAcc) . "', " . (float)$basicSal . ", " . (float)$netSal . ", 'Active', '1', NOW())");
    } else if (!$isEmployeeSelf && (isset($_POST['basic_salary']) || isset($_POST['net_salary']))) {
        $conn->query("INSERT INTO `bank_details` 
            (`user_id`, `employee_id`, `employee_name`, `holder_name`, `basic_salary`, `net_salary`, `status`, `ast`, `sdt`) 
            VALUES 
            ('$userId', '" . addslashes($employeeIdCode ?: ('EMP-' . $userId)) . "', '" . addslashes($fullName) . "', '" . addslashes($holderName ?: $fullName) . "', " . (float)$basicSal . ", " . (float)$netSal . ", 'Active', '1', NOW())");
    }
}

// 7. Trigger Notification
$targetName = !empty($fullName) ? $fullName : 'Employee';
SystemNotifications::create(
    "Profile Updated",
    "Your employment details & profile information were successfully updated.",
    "profile_update",
    "employee",
    $targetName
);

// 8. Output Complete JSON
echo json_encode([
    'status'  => 'success',
    'message' => 'Profile details saved successfully in database!',
    'data'    => [
        'id'                      => $prof_id,
        'user_id'                 => $userId,
        'full_name'               => $fullName,
        'job_title'               => $jobTitle,
        'department'              => $department,
        'email'                   => $email,
        'phone'                   => $phone,
        'nic'                     => $nic,
        'dob'                     => $dob,
        'gender'                  => $gender,
        'address'                 => $address,
        'emergency_contact_name'  => $emergencyContactName,
        'emergency_contact_phone' => $emergencyContactPhone,
        'profile_pic'             => $profilePic,
        'join_date'               => $joinDate,
        'employee_id_code'        => $employeeIdCode,
        'work_location'           => $workLocation,
        'employment_type'         => $employmentType,
        'updated_at'              => date('Y-m-d H:i:s'),
        'attendance_days'         => $attendanceDays,
        'last_attendance_date'    => $lastAttendanceDate,
        'probation_start_date'    => $probationStartDate,
        'probation_end_date'      => $probationEndDate,
        'official_start_date'     => $officialStartDate,
        'probation_status'        => $probationStatus,
        'work_shift'              => $workShift,
        'working_days'            => $workingDays,
        'schedule_start_date'     => $scheduleStartDate,
        'schedule_end_date'       => $scheduleEndDate,
        'work_mode'               => $workMode,
        'weekly_roster'           => $weeklyRoster,
        'status'                  => $status
    ]
]);
exit;
