<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Job_Roles/job_roles_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$id        = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title     = isset($_POST['title']) ? trim($_POST['title']) : (isset($_POST['job_title']) ? trim($_POST['job_title']) : '');
$dept      = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['departments']) ? trim($_POST['departments']) : '');
$employees = isset($_POST['employees']) ? (int)$_POST['employees'] : (isset($_POST['number_of_employees']) ? (int)$_POST['number_of_employees'] : 0);

if ($id <= 0 || empty($title)) {
    echo json_encode(['status' => 'error', 'message' => 'Role ID and Job Title are required.']);
    exit;
}

$update_obj = new job_roles_ADD_UPDATE();
$update_obj->set_id($id);
$update_obj->set_data($title, $dept, $employees);
$success = $update_obj->process_update();

if ($success) {
    echo json_encode([
        'status'  => 'success',
        'message' => 'Job role updated successfully in database.',
        'data'    => [
            'id'        => $id,
            'title'     => $title,
            'dept'      => $dept,
            'employees' => $employees
        ]
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $update_obj->get_error()
    ]);
}
exit;
?>
