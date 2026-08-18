<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Dashboard/dashboard_ADD_UPDATE.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $activity_description = isset($_POST['dis']) ? $_POST['dis'] : (isset($_POST['val_01']) ? $_POST['val_01'] : '');
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : (isset($_POST['val_02']) ? $_POST['val_02'] : 0);

    $obj = new dashboard_ADD_UPDATE();
    $obj->set_data($activity_description, $user_id);

    // Delete / Remove
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
        // New Record
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
