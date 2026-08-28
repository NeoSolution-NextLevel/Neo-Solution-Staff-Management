<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_SINGLE_DATA.php';

header('Content-Type: application/json; charset=utf-8');

$id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : 0);
$obj = new employee_SINGLE_DATA($id);

if ($obj->get_state()) {
    echo json_encode([
        'status' => 'success',
        'error'  => '0',
        'data'   => [
            'id'            => $obj->get_id(),
            'fullname'      => $obj->get_fullname(),
            'email_address' => $obj->get_email_address(),
            'department'    => $obj->get_department(),
            'job_role'      => $obj->get_job_role(),
            'status'        => $obj->get_status(),
            'joined_date'   => $obj->get_joined_date(),
            'initials'      => $obj->get_initials()
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'error'  => 'Employee not found'
    ]);
}
?>
