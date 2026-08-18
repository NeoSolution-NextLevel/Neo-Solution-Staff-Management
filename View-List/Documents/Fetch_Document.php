<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Controllers/Main/Documents/documents_LIST.php';

$employeeId = isset($_REQUEST['employee_id']) ? trim($_REQUEST['employee_id']) : null;
$userId = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : null;

$controller = new Documents_List();
$response = $controller->getDocuments($employeeId, $userId);

echo json_encode($response);
exit;
