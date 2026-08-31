<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Salary_Payments/salary_payments_LIST.php';

header('Content-Type: application/json; charset=utf-8');

function convertNumberToWords($num) {
    $num = (float)$num;
    $ones = array(
        0 => "Zero", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four", 5 => "Five", 6 => "Six",
        7 => "Seven", 8 => "Eight", 9 => "Nine", 10 => "Ten", 11 => "Eleven", 12 => "Twelve",
        13 => "Thirteen", 14 => "Fourteen", 15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen",
        18 => "Eighteen", 19 => "Nineteen"
    );
    $tens = array(
        2 => "Twenty", 3 => "Thirty", 4 => "Forty", 5 => "Fifty",
        6 => "Sixty", 7 => "Seventy", 8 => "Eighty", 9 => "Ninety"
    );

    if ($num < 0) return "Negative " . convertNumberToWords(-$num);
    if ($num < 20) return $ones[(int)$num];
    if ($num < 100) return $tens[(int)($num / 10)] . (($num % 10 != 0) ? " " . $ones[(int)($num % 10)] : "");
    if ($num < 1000) return $ones[(int)($num / 100)] . " Hundred" . (($num % 100 != 0) ? " and " . convertNumberToWords($num % 100) : "");
    if ($num < 1000000) return convertNumberToWords((int)($num / 1000)) . " Thousand" . (($num % 1000 != 0) ? " " . convertNumberToWords($num % 1000) : "");
    if ($num < 1000000000) return convertNumberToWords((int)($num / 1000000)) . " Million" . (($num % 1000000 != 0) ? " " . convertNumberToWords($num % 1000000) : "");
    return number_format($num, 2);
}

$json = array();
$receipt_no = isset($_GET['receipt_no']) ? trim($_GET['receipt_no']) : "";
$payment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$salary_payments_LIST_obj = new salary_payments_LIST();
if (!empty($receipt_no)) {
    $salary_payments_LIST_obj->filter_by_receipt_no($receipt_no);
} elseif ($payment_id > 0) {
    // filter by id
}

$res = $salary_payments_LIST_obj->get_all_payments();

if ($res['status'] === 'success' && count($res['data']) > 0) {
    $data = $res['data'][0];
    if ($payment_id > 0) {
        foreach ($res['data'] as $item) {
            if ($item['id'] === $payment_id) {
                $data = $item;
                break;
            }
        }
    }

    $net = (float)$data['net_salary'];
    $whole = floor($net);
    $cents = round(($net - $whole) * 100);
    $words = convertNumberToWords($whole) . " Rupees";
    if ($cents > 0) {
        $words .= " and " . convertNumberToWords($cents) . " Cents";
    }
    $words .= " Only";

    $data['amount_in_words'] = $words;

    $state['error']  = "0";
    $state['status'] = "success";
    $state['data']   = $data;
    $json[] = $state;
} else {
    $state['error']   = "1";
    $state['status']  = "error";
    $state['message'] = "Receipt not found.";
    $json[] = $state;
}

ob_clean();
echo json_encode($json);
exit;
?>
