<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Task_Management/task_management_details_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$list_obj = new task_management_details_LIST();

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $list_obj->filter_by_search($_POST['search']);
}
if (isset($_POST['department']) && !empty($_POST['department'])) {
    $list_obj->filter_by_department($_POST['department']);
}
if (isset($_POST['status']) && !empty($_POST['status'])) {
    $list_obj->filter_by_status($_POST['status']);
}
if (isset($_POST['priority']) && !empty($_POST['priority'])) {
    $list_obj->filter_by_priority($_POST['priority']);
}

$res = $list_obj->get_result();
$data = array();

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            'id'                => (int)$row['id'],
            'task_title'        => $row['task_title'],
            'department'        => $row['department'],
            'assigned_employee' => $row['assigned_employee'],
            'work_mode'         => $row['work_mode'],
            'deadline'          => $row['deadline'],
            'priority'          => $row['priority'],
            'status'            => $row['status']
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'error' => '0',
    'data' => $data
]);
?>
