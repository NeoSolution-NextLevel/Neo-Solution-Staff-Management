<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_LIST.php';

$json = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $holder_name    = isset($_POST['val_01']) ? $_POST['val_01'] : (isset($_POST['account_holder_name']) ? $_POST['account_holder_name'] : "");
    $bank_name      = isset($_POST['val_02']) ? $_POST['val_02'] : (isset($_POST['bank_name']) ? $_POST['bank_name'] : "");
    $branch         = isset($_POST['val_03']) ? $_POST['val_03'] : (isset($_POST['branch']) ? $_POST['branch'] : "");
    $account_number = isset($_POST['val_04']) ? $_POST['val_04'] : (isset($_POST['account_number']) ? $_POST['account_number'] : (isset($_POST['bank_account_number']) ? $_POST['bank_account_number'] : ""));
    $employee_id    = isset($_POST['val_05']) ? $_POST['val_05'] : (isset($_POST['employee_id']) ? $_POST['employee_id'] : "EMP-001");
    $user_id        = isset($_POST['val_06']) ? $_POST['val_06'] : (isset($_POST['user_id']) ? $_POST['user_id'] : "1");

    if (empty($holder_name) || empty($bank_name) || empty($branch) || empty($account_number)) {
        $state['error'] = "Missing required fields";
        $state['status'] = "error";
        $json[] = $state;
    } else {
        $bank_details_ADD_UPDATE_obj = new bank_details_ADD_UPDATE();
        $bank_details_LIST_obj = new bank_details_LIST();
        $bank_details_LIST_obj->filter_by_employee_id($employee_id);

        $get_result = $bank_details_LIST_obj->get_result();

        $bank_details_ADD_UPDATE_obj->set_data($user_id, $employee_id, $holder_name, $holder_name, $bank_name, $branch, $account_number, "Active");

        if ($get_result && $get_result->num_rows > 0) {
            $row = $get_result->fetch_assoc();
            $get_id = $row['id'];
            $bank_details_ADD_UPDATE_obj->set_id($get_id);

            if (isset($_POST['del'])) {
                $bank_details_ADD_UPDATE_obj->remove();
            }

            if ($bank_details_ADD_UPDATE_obj->process_update()) {
                $state['error'] = "0";
                $state['status'] = "success";
                $state['id'] = $get_id;
            } else {
                $state['error'] = $bank_details_ADD_UPDATE_obj->get_error_msg();
                $state['status'] = "error";
            }
        } else {
            if ($bank_details_ADD_UPDATE_obj->process_new_record()) {
                $state['error'] = "0";
                $state['status'] = "success";
                $state['id'] = $bank_details_ADD_UPDATE_obj->get_id();
            } else {
                $state['error'] = $bank_details_ADD_UPDATE_obj->get_error_msg();
                $state['status'] = "error";
            }
        }
        $json[] = $state;
    }
} else {
    $state['error'] = "Missing required fields";
    $state['status'] = "error";
    $json[] = $state;
}

echo json_encode($json);
?>
