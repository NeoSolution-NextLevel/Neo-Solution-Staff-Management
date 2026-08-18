<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_ADD_UPDATE.php';

$response = [
    'status' => 'error',
    'message' => 'Invalid request method.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $holderName = isset($_POST['account_holder_name']) ? trim($_POST['account_holder_name']) : '';
    $bankName = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
    $branch = isset($_POST['branch']) ? trim($_POST['branch']) : '';
    $accountNumber = isset($_POST['account_number']) ? trim($_POST['account_number']) : '';
    $employeeId = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : 'EMP-002';
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 1;

    if (empty($holderName) || empty($bankName) || empty($branch) || empty($accountNumber)) {
        $response = [
            'status' => 'error',
            'message' => 'Please fill in all required bank detail fields.'
        ];
    } else {
        $controller = new Bank_Details_Add_Update();
        $res = $controller->saveBankDetails($holderName, $bankName, $branch, $accountNumber, $userId, $employeeId);
        $response = $res;
    }
}

echo json_encode($response);
exit;
