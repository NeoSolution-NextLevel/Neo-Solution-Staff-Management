<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$name   = isset($_POST['name']) ? trim($_POST['name']) : (isset($_POST['fullname']) ? trim($_POST['fullname']) : '');
$email  = isset($_POST['email']) ? trim($_POST['email']) : (isset($_POST['email_address']) ? trim($_POST['email_address']) : '');
$dept   = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['departments']) ? trim($_POST['departments']) : (isset($_POST['department']) ? trim($_POST['department']) : 'Engineering'));
$role   = isset($_POST['role']) ? trim($_POST['role']) : (isset($_POST['job_roles']) ? trim($_POST['job_roles']) : (isset($_POST['job_role']) ? trim($_POST['job_role']) : 'Staff'));
$status = isset($_POST['status']) ? trim($_POST['status']) : 'active';
$joined = isset($_POST['joined']) && !empty($_POST['joined']) ? trim($_POST['joined']) : (isset($_POST['joined_date']) && !empty($_POST['joined_date']) ? trim($_POST['joined_date']) : date('Y-m-d'));

if (empty($name) || empty($email)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Full name and Email address are required.'
    ]);
    exit;
}

$add_obj = new employee_ADD_UPDATE();
$add_obj->set_data($name, $email, $dept, $role, $status, $joined);
$res = $add_obj->process_new_record();

if ($res) {
    echo json_encode([
        'status'  => 'success',
        'message' => 'Employee added successfully in database.',
        'data'    => [
            'id'       => (int)$add_obj->get_id(),
            'initials' => $add_obj->get_initials(),
            'name'     => $name,
            'email'    => $email,
            'dept'     => $dept,
            'role'     => $role,
            'status'   => strtolower($status),
            'joined'   => $joined
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
