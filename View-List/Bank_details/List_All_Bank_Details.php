<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_LIST.php';

$controller = new Bank_Details_List();
$response = $controller->getAllBankDetails();

echo json_encode($response);
exit;
