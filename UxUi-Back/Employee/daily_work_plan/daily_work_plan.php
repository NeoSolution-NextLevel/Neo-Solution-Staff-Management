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
    $result = $db->get_result("SELECT id, user_id, employee_profile_id, employee_name, department, job_title, plan_text, status, started_at, shift_ended_at, submitted_at, updated_at, evening_update, task_status, task_id
        FROM `daily_employee_work_plans` WHERE (user_id = {$userId} OR employee_profile_id = {$profileId}) AND plan_date = '{$today}' LIMIT 1");
    $plan = $result ? $result->fetch_assoc() : null;
    echo json_encode(['status' => 'success', 'data' => $plan ?: null, 'date' => $today]);
    exit;
}

// POST Handling
if (file_exists(__DIR__ . '/../../../imports/need/SystemNotifications.php')) {
    include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';
}
if (file_exists(__DIR__ . '/../../../Controllers/Main/Task_Management/task_management_ADD_UPDATE.php')) {
    include_once __DIR__ . '/../../../Controllers/Main/Task_Management/task_management_ADD_UPDATE.php';
}

$action = isset($_POST['action']) ? trim((string)$_POST['action']) : '';
$now = date('Y-m-d H:i:s');
$nameSql = addslashes($profileName);
$deptSql = addslashes($profileDept ?: 'Engineering');
$roleSql = addslashes($profileRole);
$profileSql = $profileId > 0 ? (string)$profileId : 'NULL';

// Action 1: Evening Shift End Wrap-Up (Simple, clean, sync to tasks)
if ($action === 'shift_end_update' || isset($_POST['evening_update'])) {
    $eveningUpdate = trim((string)($_POST['evening_update'] ?? ''));
    $taskStatus = trim((string)($_POST['task_status'] ?? 'Completed'));
    if ($taskStatus !== 'Pending' && $taskStatus !== 'Completed') {
        $taskStatus = 'Completed';
    }
    $progress = ($taskStatus === 'Completed') ? 100 : 0;

    // Check existing work plan
    $checkRes = $db->get_result("SELECT id, plan_text, task_id FROM `daily_employee_work_plans` WHERE (user_id = {$userId} OR employee_profile_id = {$profileId}) AND plan_date = '{$today}' LIMIT 1");
    $planRow = $checkRes ? $checkRes->fetch_assoc() : null;
    $planId = $planRow ? (int)$planRow['id'] : 0;
    $existingPlanText = $planRow ? trim((string)$planRow['plan_text']) : '';
    $existingTaskId = $planRow && !empty($planRow['task_id']) ? (int)$planRow['task_id'] : 0;

    $finalEveningText = $eveningUpdate !== '' ? $eveningUpdate : ($existingPlanText ?: 'Shift work wrapped up.');
    $eveningSql = addslashes($finalEveningText);
    $taskStatusSql = addslashes($taskStatus);

    // Derive concise task title from morning plan or default
    $firstLine = '';
    if ($existingPlanText !== '') {
        $lines = preg_split('/\r\n|\r|\n/', $existingPlanText);
        $firstLine = trim(preg_replace('/^[-*•\d\.\)]\s*/u', '', (string)$lines[0]));
    }
    $taskTitle = $firstLine !== '' ? $firstLine : ("Daily Work (" . date('M j') . ")");
    if (mb_strlen($taskTitle) > 50) {
        $taskTitle = mb_substr($taskTitle, 0, 47) . '...';
    }
    $taskTitleSql = addslashes($taskTitle);

    $fullDescription = "Plan: " . ($existingPlanText ?: 'Daily Work') . "\n\nShift End Update: " . $finalEveningText;
    $fullDescSql = addslashes($fullDescription);

    // 1. Update or create daily_employee_work_plans record
    if ($planId > 0) {
        $db->get_result("UPDATE `daily_employee_work_plans` SET
            `evening_update` = '{$eveningSql}',
            `shift_ended_at` = '{$now}',
            `task_status` = '{$taskStatusSql}',
            `status` = 'completed',
            `updated_at` = '{$now}'
            WHERE `id` = {$planId}");
    } else {
        $insPlanSql = "INSERT INTO `daily_employee_work_plans`
            (`user_id`, `employee_profile_id`, `employee_name`, `department`, `job_title`, `plan_date`, `plan_text`, `evening_update`, `status`, `started_at`, `shift_ended_at`, `submitted_at`, `updated_at`, `task_status`)
            VALUES
            ({$userId}, {$profileSql}, '{$nameSql}', '{$deptSql}', '{$roleSql}', '{$today}', '{$eveningSql}', '{$eveningSql}', 'completed', '{$now}', '{$now}', '{$now}', '{$now}', '{$taskStatusSql}')";
        $db->get_result($insPlanSql);
        $pRes = $db->get_result("SELECT LAST_INSERT_ID() AS id");
        if ($pRes && $pr = $pRes->fetch_assoc()) {
            $planId = (int)$pr['id'];
        }
    }

    // 2. Sync to system_tasks
    $taskId = 0;
    if ($existingTaskId > 0) {
        $chk = $db->get_result("SELECT id FROM `system_tasks` WHERE id = {$existingTaskId} LIMIT 1");
        if ($chk && $chk->num_rows > 0) {
            $taskId = $existingTaskId;
            $db->get_result("UPDATE `system_tasks` SET
                `title` = '{$taskTitleSql}',
                `description` = '{$fullDescSql}',
                `department` = '{$deptSql}',
                `assigned_to` = '{$nameSql}',
                `status` = '{$taskStatusSql}',
                `progress` = {$progress}
                WHERE id = {$taskId}");
        }
    }

    if ($taskId === 0) {
        $insSql = "INSERT INTO `system_tasks`
            (`title`, `description`, `department`, `assigned_to`, `mode`, `priority`, `status`, `deadline`, `progress`, `created_at`)
            VALUES
            ('{$taskTitleSql}', '{$fullDescSql}', '{$deptSql}', '{$nameSql}', 'Online', 'Medium', '{$taskStatusSql}', '{$today}', {$progress}, '{$now}')";
        if ($db->get_result($insSql)) {
            $tRes = $db->get_result("SELECT LAST_INSERT_ID() AS id");
            if ($tRes && $tr = $tRes->fetch_assoc()) {
                $taskId = (int)$tr['id'];
            }
        }
    }

    // Mirror to task_management
    if (class_exists('task_management_ADD_UPDATE')) {
        $taskMgmtObj = new task_management_ADD_UPDATE();
        $taskMgmtObj->set_data($taskTitle, $profileDept ?: 'Engineering', $profileName, 'Online', $today, 'Medium', $taskStatus);
        $taskMgmtObj->process_new_record();
    }

    // Link task_id in daily_employee_work_plans
    if ($taskId > 0 && $planId > 0) {
        $db->get_result("UPDATE `daily_employee_work_plans` SET `task_id` = {$taskId} WHERE id = {$planId}");
    }

    // Notify Admin
    if (class_exists('SystemNotifications')) {
        SystemNotifications::create(
            "Shift End Update: " . $profileName,
            "{$profileName} submitted shift wrap-up for '{$taskTitle}' [Status: {$taskStatus}].",
            "task_update",
            "admin",
            "Admin"
        );
    }

    $updatedPlanRes = $db->get_result("SELECT id, user_id, employee_profile_id, employee_name, department, job_title, plan_text, status, started_at, shift_ended_at, submitted_at, updated_at, evening_update, task_status, task_id
        FROM `daily_employee_work_plans` WHERE id = {$planId} LIMIT 1");

    echo json_encode([
        'status' => 'success',
        'message' => "Shift update saved and added to tasks as {$taskStatus}!",
        'task_id' => $taskId,
        'task_status' => $taskStatus,
        'data' => $updatedPlanRes ? $updatedPlanRes->fetch_assoc() : null
    ]);
    exit;
}


// Action 2: Morning Work Plan / Start Work
$planText = trim((string)($_POST['plan_text'] ?? ''));
$tasksRaw = isset($_POST['tasks']) ? $_POST['tasks'] : null;
$startWork = isset($_POST['start_work']) && ((string)$_POST['start_work'] === '1' || $_POST['start_work'] === true);

$tasksList = [];
if (is_string($tasksRaw)) {
    $tasksList = json_decode($tasksRaw, true) ?: [];
} elseif (is_array($tasksRaw)) {
    $tasksList = $tasksRaw;
}

// If tasksList is empty but planText is provided, parse lines into tasks
if (empty($tasksList) && $planText !== '') {
    $lines = preg_split('/\r\n|\r|\n/', $planText);
    $idx = 1;
    foreach ($lines as $line) {
        $line = trim(preg_replace('/^[-*•\d\.\)]\s*/u', '', $line));
        if ($line !== '') {
            $tasksList[] = [
                'id' => $idx++,
                'title' => $line,
                'status' => 'Pending',
                'note' => '',
                'priority' => 'Medium',
                'mode' => 'Online',
                'task_id' => 0
            ];
        }
    }
}

if ($planText === '' && empty($tasksList)) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Please add at least one planned task for today before starting work.']);
    exit;
}

// If planText was empty but tasksList provided, construct planText
if ($planText === '' && !empty($tasksList)) {
    $titles = array_map(function($t) { return '• ' . $t['title']; }, $tasksList);
    $planText = implode("\n", $titles);
}

$planTextSql = addslashes($planText);
$plannedTasksJsonSql = addslashes(json_encode($tasksList));
$status = $startWork ? 'active' : 'submitted';
$statusSql = addslashes($status);
$startedSql = $startWork ? "'{$now}'" : 'NULL';

$query = "INSERT INTO `daily_employee_work_plans`
    (`user_id`, `employee_profile_id`, `employee_name`, `department`, `job_title`, `plan_date`, `plan_text`, `planned_tasks_json`, `status`, `started_at`, `submitted_at`, `updated_at`)
    VALUES ({$userId}, {$profileSql}, '{$nameSql}', '{$deptSql}', '{$roleSql}', '{$today}', '{$planTextSql}', '{$plannedTasksJsonSql}', '{$statusSql}', {$startedSql}, '{$now}', '{$now}')
    ON DUPLICATE KEY UPDATE 
    `plan_text` = '{$planTextSql}',
    `planned_tasks_json` = '{$plannedTasksJsonSql}',
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

$result = $db->get_result("SELECT id, user_id, employee_profile_id, employee_name, department, job_title, plan_text, planned_tasks_json, status, started_at, shift_ended_at, submitted_at, updated_at, evening_update, task_status, task_id
    FROM `daily_employee_work_plans` WHERE (user_id = {$userId} OR employee_profile_id = {$profileId}) AND plan_date = '{$today}' LIMIT 1");
$plan = $result ? $result->fetch_assoc() : null;
if ($plan) {
    $plan['planned_tasks'] = $tasksList;
}

echo json_encode([
    'status' => 'success',
    'message' => $startWork ? 'Work started! You are active today with your planned tasks.' : 'Daily work plan saved successfully!',
    'data' => $plan,
    'date' => $today
]);
?>

