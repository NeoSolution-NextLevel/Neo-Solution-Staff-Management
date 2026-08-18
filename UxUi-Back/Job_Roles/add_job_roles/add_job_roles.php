<?php
@header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Job_Roles/job_roles_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$title     = isset($_POST['title']) ? trim($_POST['title']) : (isset($_POST['job_title']) ? trim($_POST['job_title']) : '');
$dept      = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['departments']) ? trim($_POST['departments']) : 'Engineering');
$employees = isset($_POST['employees']) ? (int)$_POST['employees'] : (isset($_POST['number_of_employees']) ? (int)$_POST['number_of_employees'] : 1);

if (empty($title)) {
    echo json_encode(['status' => 'error', 'message' => 'Job role title is required.']);
    exit;
}

$add_obj = new job_roles_ADD_UPDATE();
$add_obj->set_data($title, $dept, $employees);
$success = $add_obj->process_new_record();

if ($success) {
    // Trigger notification for Admin & All
    SystemNotifications::create(
        "Job Role Added",
        "New role '$title' was added to department '$dept'.",
        "job_role_add",
        "admin"
    );

    echo json_encode([
        'status'  => 'success',
        'message' => 'Job role created successfully in database.',
        'data'    => [
            'id'        => (int)$add_obj->get_id(),
            'title'     => $title,
            'dept'      => $dept,
            'employees' => $employees
        ]
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $add_obj->get_error()
    ]);
}
exit;
?>
