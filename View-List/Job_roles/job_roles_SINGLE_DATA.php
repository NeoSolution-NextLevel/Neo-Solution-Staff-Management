<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Job_Roles/job_roles_SINGLE_DATA.php';

header('Content-Type: application/json; charset=utf-8');

$id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : 0);
$obj = new job_roles_SINGLE_DATA($id);

if ($obj->get_state()) {
    echo json_encode([
        'status' => 'success',
        'error' => '0',
        'data' => $obj->to_array()
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'error' => 'Job role not found'
    ]);
}
?>
