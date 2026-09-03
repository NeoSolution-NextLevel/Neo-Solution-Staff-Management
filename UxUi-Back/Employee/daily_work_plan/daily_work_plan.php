<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

// Ensure table exists with all necessary columns
$db->get_result("CREATE TABLE IF NOT EXISTS `daily_employee_work_plans` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `employee_profile_id` int DEFAULT NULL,
    `employee_name` varchar(255) DEFAULT NULL,
    `department` varchar(150) DEFAULT NULL,
    `job_title` varchar(150) DEFAULT NULL,
    `plan_date` date NOT NULL,
    `plan_text` text NOT NULL,
    `status` varchar(30) NOT NULL DEFAULT 'submitted',
    `started_at` datetime DEFAULT NULL,
    `submitted_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_user_plan_date` (`user_id`, `plan_date`),
    KEY `idx_work_plan_date` (`plan_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

@$db->get_result("ALTER TABLE `daily_employee_work_plans` ADD COLUMN IF NOT EXISTS `employee_name` varchar(255) DEFAULT NULL");
@$db->get_result("ALTER TABLE `daily_employee_work_plans` ADD COLUMN IF NOT EXISTS `department` varchar(150) DEFAULT NULL");
@$db->get_result("ALTER TABLE `daily_employee_work_plans` ADD COLUMN IF NOT EXISTS `job_title` varchar(150) DEFAULT NULL");

// Determine user ID
$userId = 0;
if (!empty($_SESSION['user_id'])) {
    $userId = (int)$_SESSION['user_id'];
} elseif (!empty($_SESSION['main_user_login_id'])) {
    $userId = (int)$_SESSION['main_user_login_id'];
} elseif (isset($_REQUEST['user_id']) && (int)$_REQUEST['user_id'] > 0) {
    $userId = (int)$_REQUEST['user_id'];
} else {
    $userId = 1;
}

// Resolve profile information
$profileId = $userId;
$profileName = '';
$profileDept = '';
$profileRole = '';

$pRes = $db->get_result("SELECT id, full_name, department, job_title FROM `employee_profiles` WHERE user_id = {$userId} OR id = {$userId} LIMIT 1");
if ($pRes && ($p = $pRes->fetch_assoc())) {
    $profileId = (int)$p['id'];
    $profileName = trim((string)($p['full_name'] ?? ''));
    $profileDept = trim((string)($p['department'] ?? ''));
    $profileRole = trim((string)($p['job_title'] ?? ''));
} else {
    $eRes = $db->get_result("SELECT id, name, department, role FROM `employees` WHERE id = {$userId} LIMIT 1");
    if ($eRes && ($e = $eRes->fetch_assoc())) {
        $profileId = (int)$e['id'];
        $profileName = trim((string)($e['name'] ?? ''));
        $profileDept = trim((string)($e['department'] ?? ''));
        $profileRole = trim((string)($e['role'] ?? ''));
    }
}

if ($profileName === '' && !empty($_SESSION['user_name'])) {
    $profileName = (string)$_SESSION['user_name'];
}
if ($profileName === '') {
    $profileName = 'Employee';
}

$today = date('Y-m-d');

// GET: Retrieve today's work plan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->get_result("SELECT id, user_id, employee_profile_id, employee_name, department, job_title, plan_text, status, started_at, submitted_at, updated_at
        FROM `daily_employee_work_plans` WHERE (user_id = {$userId} OR employee_profile_id = {$profileId}) AND plan_date = '{$today}' LIMIT 1");
    $plan = $result ? $result->fetch_assoc() : null;
    echo json_encode(['status' => 'success', 'data' => $plan ?: null, 'date' => $today]);
    exit;
}

// POST: Save or Start work on daily plan
$planText = trim((string)($_POST['plan_text'] ?? ''));
$startWork = isset($_POST['start_work']) && ((string)$_POST['start_work'] === '1' || $_POST['start_work'] === true);

if ($planText === '') {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Add your daily work plan before starting work.']);
    exit;
}

$planTextSql = addslashes($planText);
$nameSql = addslashes($profileName);
$deptSql = addslashes($profileDept);
$roleSql = addslashes($profileRole);
$now = date('Y-m-d H:i:s');
$profileSql = $profileId > 0 ? (string)$profileId : 'NULL';
$status = $startWork ? 'active' : 'submitted';
$statusSql = addslashes($status);
$startedSql = $startWork ? "'{$now}'" : 'NULL';

$query = "INSERT INTO `daily_employee_work_plans`
    (`user_id`, `employee_profile_id`, `employee_name`, `department`, `job_title`, `plan_date`, `plan_text`, `status`, `started_at`, `submitted_at`, `updated_at`)
    VALUES ({$userId}, {$profileSql}, '{$nameSql}', '{$deptSql}', '{$roleSql}', '{$today}', '{$planTextSql}', '{$statusSql}', {$startedSql}, '{$now}', '{$now}')
    ON DUPLICATE KEY UPDATE 
    `plan_text` = '{$planTextSql}',
    `employee_name` = '{$nameSql}',
    `department` = '{$deptSql}',
    `job_title` = '{$roleSql}',
    `status` = IF(`started_at` IS NULL, '{$statusSql}', `status`),
    `started_at` = COALESCE(`started_at`, {$startedSql}),
    `updated_at` = '{$now}'";

if (!$db->get_result($query)) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Unable to save the daily work plan.']);
    exit;
}

if ($startWork && function_exists('update_daily_employee_presence')) {
    update_daily_employee_presence();
}

$result = $db->get_result("SELECT id, user_id, employee_profile_id, employee_name, department, job_title, plan_text, status, started_at, submitted_at, updated_at
    FROM `daily_employee_work_plans` WHERE (user_id = {$userId} OR employee_profile_id = {$profileId}) AND plan_date = '{$today}' LIMIT 1");
echo json_encode([
    'status' => 'success',
    'message' => $startWork ? 'Work started! You are active today.' : 'Daily work plan saved successfully!',
    'data' => $result ? $result->fetch_assoc() : null,
    'date' => $today
]);
?>
