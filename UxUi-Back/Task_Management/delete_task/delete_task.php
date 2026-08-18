<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Task_Management/task_management_ADD_UPDATE.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    $del_obj = new task_management_ADD_UPDATE();
    $del_obj->set_id($id);
    $del_obj->remove();
    $res = $del_obj->process_update();

    if ($res) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Task deleted successfully from database.'
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Task could not be deleted from database.']);
exit;
?>
