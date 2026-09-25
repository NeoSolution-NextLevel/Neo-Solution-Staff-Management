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

// Bank details extraction
$bankName   = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
$branch     = isset($_POST['branch']) ? trim($_POST['branch']) : '';
$accNumber  = isset($_POST['account_number']) ? trim($_POST['account_number']) : (isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : '');
$holderName = isset($_POST['holder_name']) ? trim($_POST['holder_name']) : (isset($_POST['account_holder_name']) ? trim($_POST['account_holder_name']) : $fullName);
$basicSal   = isset($_POST['basic_salary']) ? (float)$_POST['basic_salary'] : 0.00;
$netSal     = isset($_POST['net_salary']) ? (float)$_POST['net_salary'] : $basicSal;

// 1. Resolve employee identity across employee_profiles, main_user_login, and employees
$targetProf = null;
$targetEmp = null;
$targetUser = null;

$safeEmail    = addslashes($email);
$safeFullName = addslashes($fullName);

// Check employee_profiles
$profQ = "SELECT * FROM `employee_profiles` WHERE 1=0";
if ($userId > 0) $profQ .= " OR `id` = '$userId' OR `user_id` = '$userId'";
if (!empty($email)) $profQ .= " OR `email` = '{$safeEmail}'";
$prof_check = $conn->query($profQ . " LIMIT 1");
if ($prof_check && ($p = $prof_check->fetch_assoc())) {
    $targetProf = $p;
}

// Resolve main_user_login id (for employee accounts)
$main_user_id = (int)($targetProf['user_id'] ?? 0);
if ($main_user_id <= 0 && !empty($email)) {
    $uQ = $conn->query("SELECT id, name_show, first_name, last_name, user_name FROM `main_user_login` WHERE `user_name` = '{$safeEmail}' AND `main_user_account_access_level_list_id` = 2 LIMIT 1");
    if ($uQ && ($u = $uQ->fetch_assoc())) {
        $main_user_id = (int)$u['id'];
        $targetUser = $u;
    }
}
if ($main_user_id <= 0 && $userId > 1) {
    $uQ = $conn->query("SELECT id, name_show, first_name, last_name, user_name FROM `main_user_login` WHERE `id` = '$userId' AND `main_user_account_access_level_list_id` = 2 LIMIT 1");
    if ($uQ && ($u = $uQ->fetch_assoc())) {
        $main_user_id = (int)$u['id'];
        $targetUser = $u;
    }
}

// Resolve employees table row
$emp_table_id = 0;
$empQ = "SELECT * FROM `employees` WHERE 1=0";
if (!empty($email)) $empQ .= " OR `email_address` = '{$safeEmail}'";
if ($main_user_id > 0) $empQ .= " OR `main_user_login_id` = '{$main_user_id}'";
if ($userId > 0) $empQ .= " OR `id` = '$userId'";
if (!empty($fullName)) $empQ .= " OR `fullname` = '{$safeFullName}'";
$eChk = $conn->query($empQ . " LIMIT 1");
if ($eChk && ($e = $eChk->fetch_assoc())) {
    $targetEmp = $e;
    $emp_table_id = (int)$e['id'];
    if ($main_user_id <= 0 && !empty($e['main_user_login_id'])) {
        $main_user_id = (int)$e['main_user_login_id'];
    }
}

if ($main_user_id <= 0 && $userId > 1) {
    $main_user_id = $userId;
}

// Generate fallback employee code if empty
if (empty($empCode)) {
    $codeNum = $targetProf['id'] ?? ($emp_table_id > 0 ? $emp_table_id : ($main_user_id > 0 ? $main_user_id : $userId));
    $empCode = 'EMP-' . str_pad($codeNum, 3, '0', STR_PAD_LEFT);
}

// 2. Update or Insert employee_profiles record
$prof_id = (int)($targetProf['id'] ?? 0);
if ($prof_id > 0) {
    $updates = [];
    if (!empty($fullName))  $updates[] = "`full_name` = '{$safeFullName}'";
    if (!$isEmployeeSelf && !empty($email)) $updates[] = "`email` = '{$safeEmail}'";
    if (!empty($phone))     $updates[] = "`phone` = '" . addslashes($phone) . "'";
    if (!empty($nic))       $updates[] = "`nic` = '" . addslashes($nic) . "'";
    if (!empty($dob))       $updates[] = "`dob` = '" . addslashes($dob) . "'";
    if (!empty($gender))    $updates[] = "`gender` = '" . addslashes($gender) . "'";
    if (isset($_POST['address'])) $updates[] = "`address` = '" . addslashes($address) . "'";
    
    // Emergency contact (editable by both admin and employee)
    if (isset($_POST['emergency_contact_name']) && $_POST['emergency_contact_name'] !== '') {
        $updates[] = "`emergency_contact_name` = '" . addslashes($emName) . "'";
    }
    if (isset($_POST['emergency_contact_phone']) && $_POST['emergency_contact_phone'] !== '') {
        $updates[] = "`emergency_contact_phone` = '" . addslashes($emPhone) . "'";
    }

    // Admin-editable fields
    if (!$isEmployeeSelf) {
        if (!empty($dept))        $updates[] = "`department` = '" . addslashes($dept) . "'";
        if (!empty($role))        $updates[] = "`job_title` = '" . addslashes($role) . "'";
        if (!empty($status))      $updates[] = "`status` = '" . addslashes(strtolower($status)) . "'";
        if (!empty($joined))      $updates[] = "`join_date` = '" . addslashes($joined) . "'";
        if (!empty($empCode))     $updates[] = "`employee_id_code` = '" . addslashes($empCode) . "'";
        if (!empty($empType))     $updates[] = "`employment_type` = '" . addslashes($empType) . "'";
        if (!empty($location))    $updates[] = "`work_location` = '" . addslashes($location) . "'";
        if (!empty($workShift))   $updates[] = "`work_shift` = '" . addslashes($workShift) . "'";
        if (!empty($workingDays)) $updates[] = "`working_days` = '" . addslashes($workingDays) . "'";
        if (!empty($weeklyRoster))$updates[] = "`weekly_roster` = '" . addslashes($weeklyRoster) . "'";
        if (!empty($schedStart))  $updates[] = "`schedule_start_date` = '" . addslashes($schedStart) . "'";
        if (!empty($schedEnd))    $updates[] = "`schedule_end_date` = '" . addslashes($schedEnd) . "'";
        if (!empty($workMode))    $updates[] = "`work_mode` = '" . addslashes($workMode) . "'";
        if (!empty($probation))   $updates[] = "`probation_status` = '" . addslashes($probation) . "'";
        if (!empty($probStart))   $updates[] = "`probation_start_date` = '" . addslashes($probStart) . "'";
        if (!empty($probEnd))     $updates[] = "`probation_end_date` = '" . addslashes($probEnd) . "'";
        if (!empty($offStart))    $updates[] = "`official_start_date` = '" . addslashes($offStart) . "'";
        if ($attDays !== null)    $updates[] = "`attendance_days` = " . (int)$attDays;
        if ($main_user_id > 0 && empty($targetProf['user_id'])) {
            $updates[] = "`user_id` = '{$main_user_id}'";
        }
    }

    if (!empty($updates)) {
        $conn->query("UPDATE `employee_profiles` SET " . implode(", ", $updates) . " WHERE `id` = '$prof_id'");
    }
} else {
    // Insert new profile record
    $insShift = !empty($workShift) ? $workShift : '08:30 AM – 05:30 PM';
    $insDays = !empty($workingDays) ? $workingDays : 'Mon,Tue,Wed,Thu,Fri';
    $insRoster = !empty($weeklyRoster) ? $weeklyRoster : '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';
    $insLocation = !empty($location) ? $location : 'Colombo HQ';
    $insType = !empty($empType) ? $empType : 'Full-Time (Permanent)';
    $insStatus = !empty($status) ? strtolower($status) : 'active';
    $insJoined = !empty($joined) ? $joined : date('Y-m-d');
    $insMode = !empty($workMode) ? $workMode : 'On-Site (Active)';

    $conn->query("INSERT INTO `employee_profiles` (
        `user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `status`, `join_date`,
        `nic`, `dob`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`,
        `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`, `weekly_roster`,
        `work_mode`, `updated_at`
    ) VALUES (
        '$main_user_id', '{$safeFullName}', '{$safeEmail}', '" . addslashes($phone) . "', '" . addslashes($dept) . "', '" . addslashes($role) . "', '{$insStatus}', '{$insJoined}',
        '" . addslashes($nic) . "', '" . addslashes($dob) . "', '" . addslashes($gender) . "', '" . addslashes($address) . "', '" . addslashes($emName) . "', '" . addslashes($emPhone) . "',
        '" . addslashes($empCode) . "', '{$insType}', '{$insLocation}', '{$insShift}', '{$insDays}', '" . addslashes($insRoster) . "',
        '{$insMode}', NOW()
    )");
    $prof_id = (int)$conn->insert_id;
}

// 3. Synchronize with employees table (phpMyAdmin exact table schema)
$emp_updates = [];
if (!empty($fullName)) $emp_updates[] = "`fullname` = '{$safeFullName}'";
if (!empty($phone))    $emp_updates[] = "`phone_number` = '" . addslashes($phone) . "'";

if (!$isEmployeeSelf) {
    if (!empty($email))    $emp_updates[] = "`email_address` = '{$safeEmail}'";
    if (!empty($dept))     $emp_updates[] = "`departments` = '" . addslashes($dept) . "'";
    if (!empty($role))     $emp_updates[] = "`job_roles` = '" . addslashes($role) . "'";
    if (!empty($status))   $emp_updates[] = "`status` = '" . addslashes(strtolower($status)) . "'";
    if (!empty($joined))   $emp_updates[] = "`joined_date` = '" . addslashes($joined) . "'";
    if ($main_user_id > 0) $emp_updates[] = "`main_user_login_id` = '{$main_user_id}'";
}

if ($emp_table_id > 0) {
    if (!empty($emp_updates)) {
        $conn->query("UPDATE `employees` SET " . implode(", ", $emp_updates) . " WHERE `id` = '{$emp_table_id}'");
    }
} else {
    // Insert new row into employees table
    $insEmpDept = !empty($dept) ? $dept : 'Engineering';
    $insEmpRole = !empty($role) ? $role : 'Staff';
    $insEmpStatus = !empty($status) ? strtolower($status) : 'active';
    $insEmpJoined = !empty($joined) ? $joined : date('Y-m-d');
    $conn->query("INSERT INTO `employees` (
        `fullname`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`, `main_user_login_id`, `phone_number`
    ) VALUES (
        '{$safeFullName}', '{$safeEmail}', '" . addslashes($insEmpDept) . "', '" . addslashes($insEmpRole) . "', '{$insEmpStatus}', '{$insEmpJoined}', '{$main_user_id}', '" . addslashes($phone) . "'
    )");
}

// 4. Synchronize with main_user_login table (Never modify admin id = 1)
if ($main_user_id > 1) {
    $uUpdates = [];
    if (!$isEmployeeSelf && !empty($status)) {
        $uUpdates[] = "`account_active_state` = " . (strtolower($status) === 'active' ? 1 : 0);
    }
    if (!$isEmployeeSelf && !empty($email)) {
        $uUpdates[] = "`user_name` = '{$safeEmail}'";
    }
    if (!empty($joined)) {
        $uUpdates[] = "`sdt` = '{$joined} 00:00:00'";
    }
    if (!empty($fullName)) {
        $uUpdates[] = "`name_show` = '{$safeFullName}'";
        $nameParts = explode(' ', $fullName);
        $firstN = array_shift($nameParts);
        $lastN  = implode(' ', $nameParts);
        if (!empty($firstN)) $uUpdates[] = "`first_name` = '" . addslashes($firstN) . "'";
        if (!empty($lastN))  $uUpdates[] = "`last_name` = '" . addslashes($lastN) . "'";
    }
    if (!empty($uUpdates)) {
        $conn->query("UPDATE `main_user_login` SET " . implode(", ", $uUpdates) . " WHERE `id` = '{$main_user_id}'");
    }
}

// Sync job roles employee count according to department
include_once __DIR__ . '/../../Job_Roles/sync_job_roles_count.php';
sync_job_role_employee_counts($conn);

// 5. Sync with bank_details table
if (!empty($bankName) || !empty($accNumber) || (!$isEmployeeSelf && (isset($_POST['basic_salary']) || isset($_POST['net_salary'])))) {
    include_once __DIR__ . '/../../../Controllers/Main/Bank_Details/Bank_Security.php';
    $encAcc = !empty($accNumber) ? Bank_Security::encrypt($accNumber) : '';
    $bTargetUserId = $main_user_id > 0 ? $main_user_id : $userId;
    $bCheck = $conn->query("SELECT id, bank_account_number, account_number FROM `bank_details` 
        WHERE `user_id` = '{$bTargetUserId}' OR `employee_id` = '" . addslashes($empCode) . "' OR `employee_name` = '{$safeFullName}' OR `holder_name` = '{$safeFullName}' 
        ORDER BY `id` DESC LIMIT 1");
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
        if (!empty($fullName)) $bUpdates[] = "`employee_name` = '{$safeFullName}'";
        if (!empty($empCode))  $bUpdates[] = "`employee_id` = '" . addslashes($empCode) . "'";
        if (!$isEmployeeSelf && isset($_POST['basic_salary'])) $bUpdates[] = "`basic_salary` = " . (float)$basicSal;
        if (!$isEmployeeSelf && isset($_POST['net_salary']))   $bUpdates[] = "`net_salary` = " . (float)$netSal;
        if ($bTargetUserId > 0) $bUpdates[] = "`user_id` = '{$bTargetUserId}'";
        if (!empty($bUpdates)) {
            $conn->query("UPDATE `bank_details` SET " . implode(", ", $bUpdates) . " WHERE `id` = '$bId'");
        }
    } else {
        $bHolder = !empty($holderName) && $holderName !== 'Employee Account Holder' ? $holderName : $fullName;
        $conn->query("INSERT INTO `bank_details` 
            (`user_id`, `employee_id`, `employee_name`, `holder_name`, `bank_name`, `branch`, `bank_account_number`, `account_number`, `basic_salary`, `net_salary`, `status`, `ast`, `sdt`) 
            VALUES 
            ('{$bTargetUserId}', '" . addslashes($empCode) . "', '{$safeFullName}', '" . addslashes($bHolder) . "', '" . addslashes($bankName) . "', '" . addslashes($branch) . "', '" . addslashes($encAcc) . "', '" . addslashes($encAcc) . "', " . (float)$basicSal . ", " . (float)$netSal . ", 'Active', '1', NOW())");
    }
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
