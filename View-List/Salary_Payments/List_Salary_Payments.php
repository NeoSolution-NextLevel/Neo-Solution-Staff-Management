<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Salary_Payments/salary_payments_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

$salary_payments_LIST_obj = new salary_payments_LIST();

if (isset($_GET['employee_id']) && !empty($_GET['employee_id'])) {
    $salary_payments_LIST_obj->filter_by_employee_id($_GET['employee_id']);
}

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $salary_payments_LIST_obj->filter_by_user_id($_GET['user_id']);
}

if (isset($_GET['receipt_no']) && !empty($_GET['receipt_no'])) {
    $salary_payments_LIST_obj->filter_by_receipt_no($_GET['receipt_no']);
}

if (isset($_GET['payment_month']) && !empty($_GET['payment_month'])) {
    $salary_payments_LIST_obj->filter_by_payment_month($_GET['payment_month']);
}

$res = $salary_payments_LIST_obj->get_all_payments();

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
