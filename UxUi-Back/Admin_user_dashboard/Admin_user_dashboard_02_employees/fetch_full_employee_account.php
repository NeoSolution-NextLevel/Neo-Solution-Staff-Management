<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

$empId = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0);
$empName = isset($_GET['name']) ? trim($_GET['name']) : '';

// 1. Fetch Profile
$profile = null;
if ($empId > 0) {
    $pRes = $db->get_result("SELECT * FROM `employee_profiles` WHERE `id` = {$empId} OR `user_id` = {$empId} LIMIT 1");
    if ($pRes && ($p = $pRes->fetch_assoc())) {
        $profile = $p;
    }
}
if (!$profile && !empty($empName)) {
    $safeName = addslashes($empName);
    $pRes = $db->get_result("SELECT * FROM `employee_profiles` WHERE `full_name` LIKE '%{$safeName}%' LIMIT 1");
    if ($pRes && ($p = $pRes->fetch_assoc())) {
        $profile = $p;
    }
}
if (!$profile && $empId > 0) {
    $eRes = $db->get_result("SELECT * FROM `employees` WHERE `id` = {$empId} LIMIT 1");
    if ($eRes && ($e = $eRes->fetch_assoc())) {
        $profile = [
            'id' => (int)$e['id'],
            'user_id' => (int)$e['id'],
            'full_name' => $e['fullname'] ?? $e['name'] ?? 'Employee',
            'email' => $e['email_address'] ?? $e['email'] ?? '',
            'phone' => $e['phone_number'] ?? '',
            'department' => $e['departments'] ?? 'General',
            'job_title' => $e['job_roles'] ?? 'Staff',
            'status' => 'active',
            'join_date' => $e['joined_date'] ?? date('Y-m-d'),
            'nic' => $e['nic_number'] ?? '',
            'dob' => $e['date_of_birth'] ?? '',
            'gender' => $e['gender'] ?? 'Male',
            'address' => $e['address'] ?? '',
            'employee_id_code' => 'EMP-' . str_pad($e['id'], 3, '0', STR_PAD_LEFT),
            'work_location' => 'Colombo HQ',
            'work_shift' => '08:30 AM – 05:30 PM',
            'working_days' => 'Mon,Tue,Wed,Thu,Fri',
            'weekly_roster' => '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"wfh","Sat":"leave","Sun":"leave"}',
            'employment_type' => 'Full-Time'
        ];
    }
}

// Employee login accounts can exist before an employee profile is created.
if (!$profile && $empId > 0) {
    $aRes = $db->get_result("SELECT l.* FROM `main_user_login` l
        INNER JOIN `main_user_account_access_level_list` a
            ON a.id = l.main_user_account_access_level_list_id
        WHERE l.id = {$empId} AND LOWER(a.type_of_access) = 'employee' LIMIT 1");
    if ($aRes && ($a = $aRes->fetch_assoc())) {
        $accountName = trim((string)($a['name_show'] ?? ''));
        if ($accountName === '') $accountName = trim((string)($a['first_name'] ?? '') . ' ' . (string)($a['last_name'] ?? ''));
        if ($accountName === '') $accountName = (string)($a['user_name'] ?? 'Employee');
        $profile = [
            'id' => (int)$a['id'], 'user_id' => (int)$a['id'], 'full_name' => $accountName,
            'email' => $a['user_name'] ?? '', 'phone' => $a['phone_number'] ?? '',
            'department' => '—', 'job_title' => 'Employee Account',
            'status' => ((int)($a['account_active_state'] ?? 1) === 1) ? 'active' : 'inactive',
            'join_date' => '', 'nic' => '', 'dob' => '', 'gender' => '', 'address' => '',
            'employee_id_code' => 'ACCOUNT-' . str_pad((int)$a['id'], 3, '0', STR_PAD_LEFT),
            'work_location' => '', 'work_shift' => '', 'working_days' => '',
            'weekly_roster' => '', 'employment_type' => 'Employee Account'
        ];
    }
}

if (!$profile) {
    echo json_encode(['status' => 'error', 'message' => 'Employee profile not found.']);
    exit;
}

$id = (int)$profile['id'];
$userId = (int)($profile['user_id'] ?? $id);
$fullName = $profile['full_name'] ?? '';
$safeFullName = addslashes($fullName);
$empCode = $profile['employee_id_code'] ?? ('EMP-' . str_pad($id, 3, '0', STR_PAD_LEFT));
$safeEmpCode = addslashes($empCode);

// 2. Daily Work Plans
$workPlans = [];
$wpRes = $db->get_result("SELECT * FROM `daily_employee_work_plans` 
    WHERE `user_id` = {$userId} OR `employee_profile_id` = {$id}
    ORDER BY `plan_date` DESC, `id` DESC LIMIT 10");
if ($wpRes && $wpRes->num_rows > 0) {
    while ($row = $wpRes->fetch_assoc()) {
        $workPlans[] = $row;
    }
}

// 3. Bank Details
$bank = null;
$bRes = $db->get_result("SELECT * FROM `bank_details` 
    WHERE `user_id` = {$userId} OR `employee_id` = '{$safeEmpCode}' OR `employee_name` = '{$safeFullName}' 
    ORDER BY `id` DESC LIMIT 1");
if ($bRes && ($b = $bRes->fetch_assoc())) {
    $bank = $b;
}

// 4. Documents
$documents = [];
$dRes = $db->get_result("SELECT * FROM `documents` 
    WHERE (`user_id` = {$userId} OR `employee_id` = '{$safeEmpCode}' OR `employee_name` = '{$safeFullName}') 
      AND (`ast` = '1' OR `ast` IS NULL) 
    ORDER BY `id` DESC");
if ($dRes && $dRes->num_rows > 0) {
    while ($row = $dRes->fetch_assoc()) {
        $documents[] = $row;
    }
}

// 5. Tasks
$tasks = [];
$tRes = $db->get_result("SELECT * FROM `system_tasks` 
    WHERE `assigned_to` = '{$safeFullName}' 
    ORDER BY `id` DESC LIMIT 20");
if ($tRes && $tRes->num_rows > 0) {
    while ($row = $tRes->fetch_assoc()) {
        $tasks[] = $row;
    }
}

// 6. Leaves
$leaves = [];
$lRes = $db->get_result("SELECT * FROM `leave_requests` 
    WHERE `employee_name` = '{$safeFullName}' 
    ORDER BY `id` DESC LIMIT 15");
if ($lRes && $lRes->num_rows > 0) {
    while ($row = $lRes->fetch_assoc()) {
        $leaves[] = $row;
    }
}

echo json_encode([
    'status' => 'success',
    'data' => [
        'profile'    => $profile,
        'work_plans' => $workPlans,
        'bank'       => $bank,
        'documents'  => $documents,
        'tasks'      => $tasks,
        'leaves'     => $leaves
    ]
]);
?>
