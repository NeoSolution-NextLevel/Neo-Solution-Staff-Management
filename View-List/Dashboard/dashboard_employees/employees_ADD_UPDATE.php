<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_ADD_UPDATE.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : (isset($_POST['val_01']) ? trim($_POST['val_01']) : '');
    $email_address = isset($_POST['email_address']) ? trim($_POST['email_address']) : (isset($_POST['val_02']) ? trim($_POST['val_02']) : '');
    $department = isset($_POST['department']) ? trim($_POST['department']) : (isset($_POST['val_03']) ? trim($_POST['val_03']) : '');
    $job_roles = isset($_POST['job_roles']) ? trim($_POST['job_roles']) : (isset($_POST['job_role']) ? trim($_POST['job_role']) : (isset($_POST['val_04']) ? trim($_POST['val_04']) : ''));
    $status = isset($_POST['status']) ? trim($_POST['status']) : (isset($_POST['val_05']) ? trim($_POST['val_05']) : 'Active');
    $joined_date = isset($_POST['joined_date']) ? trim($_POST['joined_date']) : (isset($_POST['val_06']) ? trim($_POST['val_06']) : date('Y-m-d'));

    $obj = new employee_ADD_UPDATE();

    // Delete / Remove data
    if (!empty($id) && isset($_POST['del']) && $_POST['del'] == '1') {
        $obj->set_id($id);
        $obj->remove();
        if ($obj->process_update()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $id;
        } else {
            $state['error'] = $obj->get_error();
            $state['status'] = "error";
        }
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    $obj->set_data($fullname, $email_address, $department, $job_roles, $status, $joined_date);

    // Update data
    if (!empty($id)) {
        $obj->set_id($id);
        if ($obj->process_update()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $id;
        } else {
            $state['error'] = $obj->get_error();
            $state['status'] = "error";
        }
    } else {
        // New Record
        if ($obj->process_new_record()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $obj->get_id();
        } else {
            $state['error'] = $obj->get_error();
            $state['status'] = "error";
        }
    }
    $json[] = $state;
} else {
    $state['error'] = "Invalid request method";
    $state['status'] = "error";
    $json[] = $state;
}

echo json_encode($json);
?>