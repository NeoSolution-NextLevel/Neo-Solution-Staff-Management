<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$title       = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$department  = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['department']) ? trim($_POST['department']) : '');
$assigned_to = isset($_POST['employee']) ? trim($_POST['employee']) : (isset($_POST['assigned_to']) ? trim($_POST['assigned_to']) : '');
$mode        = isset($_POST['mode']) ? trim($_POST['mode']) : 'Online';
$priority    = isset($_POST['priority']) ? trim($_POST['priority']) : 'Medium';
$status      = isset($_POST['status']) ? trim($_POST['status']) : 'Pending';
$deadline    = isset($_POST['deadline']) && !empty($_POST['deadline']) ? trim($_POST['deadline']) : date('Y-m-d', strtotime('+7 days'));
$progress    = isset($_POST['progress']) ? (int)$_POST['progress'] : ($status === 'Completed' ? 100 : ($status === 'In Progress' ? 50 : 0));

if (empty($title)) {
    echo json_encode(['status' => 'error', 'message' => 'Task title is required.']);
    exit;
}

$db = new DataBase();

$sql = "INSERT INTO `system_tasks` (
    `title`, `description`, `department`, `assigned_to`, `mode`, `priority`, `status`, `deadline`, `progress`
) VALUES (
    '" . addslashes($title) . "',
    '" . addslashes($description) . "',
    '" . addslashes($department) . "',
    '" . addslashes($assigned_to) . "',
    '" . addslashes($mode) . "',
    '" . addslashes($priority) . "',
    '" . addslashes($status) . "',
    '" . addslashes($deadline) . "',
    " . (int)$progress . "
)";

$result = $db->get_result($sql);

if ($result) {
    // Notify the assigned employee automatically
    SystemNotifications::create(
        "New Task Assigned",
        "You have been assigned a new task: " . $title . " (Deadline: " . $deadline . ")",
        "task_assigned",
        "employee",
        $assigned_to
    );

    echo json_encode([
        'status'  => 'success',
        'message' => 'Task assigned successfully in database!'
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create task in database.']);
}
exit;
?>
