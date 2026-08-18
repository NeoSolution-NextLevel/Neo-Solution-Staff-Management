<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Task_Management/task_management_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$title     = isset($_POST['title']) ? trim($_POST['title']) : (isset($_POST['task_title']) ? trim($_POST['task_title']) : '');
$dept      = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['department']) ? trim($_POST['department']) : 'Engineering');
$employee  = isset($_POST['employee']) ? trim($_POST['employee']) : (isset($_POST['assigned_employee']) ? trim($_POST['assigned_employee']) : 'Unassigned');
$mode      = isset($_POST['mode']) ? trim($_POST['mode']) : (isset($_POST['work_mode']) ? trim($_POST['work_mode']) : 'Online');
$deadline  = isset($_POST['deadline']) ? trim($_POST['deadline']) : date('Y-m-d');
$priority  = isset($_POST['priority']) ? trim($_POST['priority']) : 'Medium';
$status    = isset($_POST['status']) ? trim($_POST['status']) : 'Pending';

if (empty($title)) {
    echo json_encode(['status' => 'error', 'message' => 'Task title is required.']);
    exit;
}

$task_obj = new task_management_ADD_UPDATE();
$task_obj->set_data($title, $dept, $employee, $mode, $deadline, $priority, $status);
$res = $task_obj->process_new_record();

if ($res) {
    echo json_encode([
        'status'  => 'success',
        'message' => 'Task created successfully in database.',
        'data'    => [
            'id'        => (int)$task_obj->get_id(),
            'title'     => $title,
            'dept'      => $dept,
            'employee'  => $employee,
            'mode'      => $mode,
            'deadline'  => $deadline,
            'priority'  => $priority,
            'status'    => $status
        ]
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $task_obj->get_error()
    ]);
}
exit;
?>
