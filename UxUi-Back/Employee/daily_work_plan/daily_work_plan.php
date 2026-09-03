<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';

function daily_plan_employee_session()
{
    $role = strtolower(trim((string)($_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '')));
    return !empty($_SESSION['user_id']) && strpos($role, 'employee') !== false && strpos($role, 'admin') === false;
}

if (!daily_plan_employee_session()) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Employee login required.']);
    exit;
}

$db = new DataBase();
$db->get_result("CREATE TABLE IF NOT EXISTS `daily_employee_work_plans` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `employee_profile_id` int DEFAULT NULL,
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

$userId = (int)$_SESSION['user_id'];
$profileId = 0;
$profileResult = $db->get_result("SELECT id FROM `employee_profiles` WHERE user_id = {$userId} LIMIT 1");
if ($profileResult && ($profile = $profileResult->fetch_assoc())) {
    $profileId = (int)$profile['id'];
}

$today = date('Y-m-d');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->get_result("SELECT id, plan_text, status, started_at, submitted_at, updated_at
        FROM `daily_employee_work_plans` WHERE user_id = {$userId} AND plan_date = '{$today}' LIMIT 1");
    $plan = $result ? $result->fetch_assoc() : null;
    echo json_encode(['status' => 'success', 'data' => $plan ?: null, 'date' => $today]);
    exit;
}

$planText = trim((string)($_POST['plan_text'] ?? ''));
$startWork = isset($_POST['start_work']) && (string)$_POST['start_work'] === '1';
if ($planText === '') {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Add your daily work plan before starting work.']);
    exit;
}

$planTextSql = addslashes($planText);
$now = date('Y-m-d H:i:s');
$profileSql = $profileId > 0 ? (string)$profileId : 'NULL';
$status = $startWork ? 'active' : 'submitted';
$statusSql = addslashes($status);
$startedSql = $startWork ? "'{$now}'" : 'NULL';

$query = "INSERT INTO `daily_employee_work_plans`
    (`user_id`, `employee_profile_id`, `plan_date`, `plan_text`, `status`, `started_at`, `submitted_at`, `updated_at`)
    VALUES ({$userId}, {$profileSql}, '{$today}', '{$planTextSql}', '{$statusSql}', {$startedSql}, '{$now}', '{$now}')
    ON DUPLICATE KEY UPDATE `plan_text` = '{$planTextSql}', `status` = IF(`started_at` IS NULL, '{$statusSql}', `status`),
    `started_at` = COALESCE(`started_at`, {$startedSql}), `updated_at` = '{$now}'";

if (!$db->get_result($query)) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Unable to save the daily work plan.']);
    exit;
}

if ($startWork) {
    // Explicit start-work action also records the employee as active today.
    update_daily_employee_presence();
}

$result = $db->get_result("SELECT id, plan_text, status, started_at, submitted_at, updated_at
    FROM `daily_employee_work_plans` WHERE user_id = {$userId} AND plan_date = '{$today}' LIMIT 1");
echo json_encode(['status' => 'success', 'data' => $result ? $result->fetch_assoc() : null, 'date' => $today]);
?>
