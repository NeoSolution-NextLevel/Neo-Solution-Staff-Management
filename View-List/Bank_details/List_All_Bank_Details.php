<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

$bank_details_LIST_obj = new bank_details_LIST();
$res = $bank_details_LIST_obj->getAllBankDetails();

if ($res['status'] === 'success') {
    $state['error']  = "0";
    $state['status'] = "success";
    $state['count']  = $res['count'];
    $state['data']   = $res['data'];
    $json[] = $state;
} else {
    $state['error']  = "1";
    $state['status'] = "error";
    $state['data']   = [];
    $json[] = $state;
}

ob_clean();
echo json_encode($json);
exit;
?>
