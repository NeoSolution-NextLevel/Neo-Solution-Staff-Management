<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Task_Management/task_management_details_LIST.php';

$task_list_obj = new task_management_details_LIST();

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $task_list_obj->filter_by_search($_GET['search']);
}
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $task_list_obj->filter_by_status($_GET['status']);
}
if (isset($_GET['department']) && !empty($_GET['department'])) {
    $task_list_obj->filter_by_department($_GET['department']);
}

$res = $task_list_obj->get_result();
$tasks = [];

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $tasks[] = [
            'id'        => (int)$row['id'],
            'title'     => $row['task_title'],
            'dept'      => $row['department'],
            'employee'  => $row['assigned_employee'],
            'mode'      => $row['work_mode'],
            'deadline'  => $row['deadline'],
            'priority'  => $row['priority'],
            'status'    => $row['status']
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'total'  => count($tasks),
    'data'   => $tasks
]);
exit;
?>
