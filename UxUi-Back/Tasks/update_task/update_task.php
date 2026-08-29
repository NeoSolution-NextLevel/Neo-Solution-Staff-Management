<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title       = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$department  = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['department']) ? trim($_POST['department']) : '');
$assigned_to = isset($_POST['employee']) ? trim($_POST['employee']) : (isset($_POST['assigned_to']) ? trim($_POST['assigned_to']) : '');
$mode        = isset($_POST['mode']) ? trim($_POST['mode']) : '';
$priority    = isset($_POST['priority']) ? trim($_POST['priority']) : '';
$status      = isset($_POST['status']) ? trim($_POST['status']) : '';
$deadline    = isset($_POST['deadline']) ? trim($_POST['deadline']) : '';
$progress    = isset($_POST['progress']) ? (int)$_POST['progress'] : null;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Task ID is required.']);
    exit;
}

$db = new DataBase();

$updates = [];
if (!empty($title))       $updates[] = "`title` = '" . addslashes($title) . "'";
if (!empty($description)) $updates[] = "`description` = '" . addslashes($description) . "'";
if (!empty($department))  $updates[] = "`department` = '" . addslashes($department) . "'";
if (!empty($assigned_to)) $updates[] = "`assigned_to` = '" . addslashes($assigned_to) . "'";
if (!empty($mode))        $updates[] = "`mode` = '" . addslashes($mode) . "'";
if (!empty($priority))    $updates[] = "`priority` = '" . addslashes($priority) . "'";
if (!empty($status))      $updates[] = "`status` = '" . addslashes($status) . "'";
if (!empty($deadline))    $updates[] = "`deadline` = '" . addslashes($deadline) . "'";

if ($progress !== null) {
    $updates[] = "`progress` = " . (int)$progress;
} else if (!empty($status)) {
    if ($status === 'Completed') $updates[] = "`progress` = 100";
    else if ($status === 'In Progress') $updates[] = "`progress` = 50";
    else if ($status === 'Pending') $updates[] = "`progress` = 0";
}

if (!empty($updates)) {
    $sql = "UPDATE `system_tasks` SET " . implode(", ", $updates) . " WHERE `id` = $id";
    $db->get_result($sql);
}

// Check task details to send notification
$taskRes = $db->get_result("SELECT * FROM `system_tasks` WHERE `id` = $id LIMIT 1");
$updater_role = isset($_POST['updater_role']) ? trim($_POST['updater_role']) : '';

if ($taskRes && $taskRes->num_rows > 0) {
    $taskData = $taskRes->fetch_assoc();
    $taskTitle = $taskData['title'];
    $taskStatus = $taskData['status'];
    $taskEmp = $taskData['assigned_to'];

    if (!empty($status) && $updater_role !== 'admin') {
        // Notify admin if the update was NOT made by the admin
        SystemNotifications::create(
            "Task Status Updated: " . $taskTitle,
            "Task status is now '" . $taskStatus . "' for " . $taskEmp,
            "task_update",
            "admin",
            "Admin"
        );
    }
    
    // Notify the assigned employee if the update was NOT made by the employee
    if (!empty($taskEmp) && $updater_role !== 'employee') {
        SystemNotifications::create(
            "Task Updated: " . $taskTitle,
            "Your task '" . $taskTitle . "' has been updated.",
            "task_update",
            "employee",
            $taskEmp
        );
    }
}

echo json_encode([
    'status'  => 'success',
    'message' => 'Task updated successfully in database!'
]);
exit;
?>
