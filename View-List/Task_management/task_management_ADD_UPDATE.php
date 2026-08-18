<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Task_Management/task_management_ADD_UPDATE.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $task_title = isset($_POST['task_title']) ? $_POST['task_title'] : (isset($_POST['val_01']) ? $_POST['val_01'] : '');
    $department = isset($_POST['department']) ? $_POST['department'] : (isset($_POST['val_02']) ? $_POST['val_02'] : '');
    $assigned_employee = isset($_POST['assigned_employee']) ? $_POST['assigned_employee'] : (isset($_POST['val_03']) ? $_POST['val_03'] : '');
    $work_mode = isset($_POST['work_mode']) ? $_POST['work_mode'] : (isset($_POST['val_04']) ? $_POST['val_04'] : 'Onsite');
    $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : (isset($_POST['val_05']) ? $_POST['val_05'] : '');
    $priority = isset($_POST['priority']) ? $_POST['priority'] : (isset($_POST['val_06']) ? $_POST['val_06'] : 'Medium');
    $status = isset($_POST['status']) ? $_POST['status'] : (isset($_POST['val_07']) ? $_POST['val_07'] : 'Pending');

    $obj = new task_management_ADD_UPDATE();

    // Delete
    if (isset($_POST['id']) && isset($_POST['del']) && $_POST['del'] == '1') {
        $obj->set_id($_POST['id']);
        $obj->remove();
        if ($obj->process_update()) {
            $state['error'] = "0";
            $state['id'] = $_POST['id'];
        } else {
            $state['error'] = $obj->get_error();
        }
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    $obj->set_data($task_title, $department, $assigned_employee, $work_mode, $deadline, $priority, $status);

    // Update
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $get_id = $_POST['id'];
        $obj->set_id($get_id);
        if ($obj->process_update()) {
            $state['error'] = "0";
            $state['id'] = $get_id;
        } else {
            $state['error'] = $obj->get_error();
        }
    } else {
        // New record
        if ($obj->process_new_record()) {
            $state['error'] = "0";
            $state['id'] = $obj->get_id();
        } else {
            $state['error'] = $obj->get_error();
        }
    }
    $json[] = $state;
} else {
    $state['error'] = "Invalid request method";
    $json[] = $state;
}

echo json_encode($json);
?>
