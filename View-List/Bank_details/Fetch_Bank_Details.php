<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_SINGLE_DATA.php';

$employeeId = isset($_REQUEST['employee_id']) ? trim($_REQUEST['employee_id']) : 'EMP-002';
$userId = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 1;

$controller = new Bank_Details_Single_Data();
$response = $controller->getBankDetailsByEmployee($employeeId, $userId);

echo json_encode($response);
exit;
