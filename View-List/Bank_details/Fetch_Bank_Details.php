<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_SINGLE_DATA.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_LIST.php';

$json = array();

$employee_id = isset($_POST['val_01']) ? $_POST['val_01'] : (isset($_GET['employee_id']) ? $_GET['employee_id'] : (isset($_POST['employee_id']) ? $_POST['employee_id'] : ""));
$user_id     = isset($_POST['val_02']) ? $_POST['val_02'] : (isset($_GET['user_id']) ? $_GET['user_id'] : (isset($_POST['user_id']) ? $_POST['user_id'] : "1"));

$bank_details_SINGLE_DATA_obj = new bank_details_SINGLE_DATA();
$res = $bank_details_SINGLE_DATA_obj->getBankDetailsByEmployee($employee_id, $user_id);

if ($res['status'] === 'success') {
    $state['error']  = "0";
    $state['status'] = "success";
    $state['data']   = $res['data'];
    $json[] = $state;
} else {
    $state['error']  = "1";
    $state['status'] = "error";
    $state['msg']    = "No bank details found";
    $state['data']   = null;
    $json[] = $state;
}

echo json_encode($json);
?>
