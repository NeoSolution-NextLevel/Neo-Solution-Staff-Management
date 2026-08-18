<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Job_Roles/job_roles_ADD_UPDATE.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : (isset($_POST['val_01']) ? $_POST['val_01'] : '');
    $departments = isset($_POST['departments']) ? $_POST['departments'] : (isset($_POST['department']) ? $_POST['department'] : (isset($_POST['val_02']) ? $_POST['val_02'] : ''));
    $number_of_employees = isset($_POST['number_of_employees']) ? $_POST['number_of_employees'] : (isset($_POST['val_03']) ? $_POST['val_03'] : 0);

    $obj = new job_roles_ADD_UPDATE();

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

    $obj->set_data($job_title, $departments, $number_of_employees);

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
