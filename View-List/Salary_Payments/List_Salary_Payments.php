<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Salary_Payments/salary_payments_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

$currentUser = get_current_logged_user_info();
$userRole = isset($_SESSION['user_role']) ? strtolower((string)$_SESSION['user_role']) : (isset($_SESSION['ac_type']) ? strtolower((string)$_SESSION['ac_type']) : '');
$accessLevel = isset($_SESSION['main_user_account_access_level_list_id']) ? (int)$_SESSION['main_user_account_access_level_list_id'] : 0;
$sessionUserId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$isAdmin = ($userRole === 'admin' || $accessLevel === 1 || ($sessionUserId === 1 && empty($_SESSION['admin_impersonating'])));

$salary_payments_LIST_obj = new salary_payments_LIST();

if (!$isAdmin) {
    // Current user is an employee!
    // They must ONLY EVER see their own payment receipts.
    $empId = !empty($currentUser['emp_code']) ? $currentUser['emp_code'] : (isset($_SESSION['employee_id_code']) ? $_SESSION['employee_id_code'] : '');
    $empName = !empty($currentUser['full_name']) && $currentUser['full_name'] !== 'Guest' ? $currentUser['full_name'] : (isset($_SESSION['full_name']) ? $_SESSION['full_name'] : '');
    
    if (isset($_GET['employee_id']) && !empty($_GET['employee_id']) && empty($empId)) {
        $empId = trim($_GET['employee_id']);
    }

    $salary_payments_LIST_obj->filter_for_employee($empId, $sessionUserId, $empName);
} else {
    // Admin user: can filter by employee or view all
    if (isset($_GET['employee_id']) && !empty($_GET['employee_id'])) {
        $salary_payments_LIST_obj->filter_by_employee_id($_GET['employee_id']);
    }

    if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
        $salary_payments_LIST_obj->filter_by_user_id($_GET['user_id']);
    }
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
