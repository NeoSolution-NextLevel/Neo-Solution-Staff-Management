<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Departments/departments_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$id        = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name      = isset($_POST['name']) ? trim($_POST['name']) : '';
$head      = isset($_POST['head']) && !empty($_POST['head']) ? trim($_POST['head']) : 'Unassigned';
$employees = isset($_POST['employees']) ? (int)$_POST['employees'] : 0;
$color     = isset($_POST['color']) && !empty($_POST['color']) ? strtolower(trim($_POST['color'])) : strtolower(substr($name, 0, 3));

if ($id <= 0 || empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Valid Department ID and Name are required.']);
    exit;
}

$update_obj = new departments_ADD_UPDATE();
$update_obj->set_id($id);
$update_obj->set_data($name, $head, $employees, $color);
$res = $update_obj->process_update();

if ($res) {
    echo json_encode([
        'status'  => 'success',
        'message' => 'Department updated successfully in database.',
        'data'    => [
            'id'        => $id,
            'name'      => $name,
            'head'      => $head,
            'employees' => $employees,
            'color'     => $color
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
