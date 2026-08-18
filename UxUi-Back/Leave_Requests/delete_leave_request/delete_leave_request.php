<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Leave_Requests/leave_requests_ADD_UPDATE.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    $leave_obj = new leave_requests_ADD_UPDATE();
    $leave_obj->set_id($id);
    $leave_obj->remove();
    $res = $leave_obj->process_update();

    if ($res) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Leave request deleted successfully from database.'
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Failed to delete leave request from database.']);
exit;
?>
