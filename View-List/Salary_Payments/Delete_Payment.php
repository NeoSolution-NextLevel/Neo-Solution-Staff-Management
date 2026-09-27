<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';

header('Content-Type: application/json; charset=utf-8');

$currentUser = get_current_logged_user_info();
$userRole = isset($_SESSION['user_role']) ? strtolower((string)$_SESSION['user_role']) : (isset($_SESSION['ac_type']) ? strtolower((string)$_SESSION['ac_type']) : '');
$accessLevel = isset($_SESSION['main_user_account_access_level_list_id']) ? (int)$_SESSION['main_user_account_access_level_list_id'] : 0;
$sessionUserId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$isAdmin = ($userRole === 'admin' || $accessLevel === 1 || ($sessionUserId === 1 && empty($_SESSION['admin_impersonating'])));

if (!$isAdmin) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized. Only Admin can delete payment receipts.'
    ]);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid payment receipt ID.'
    ]);
    exit;
}

$db = new DataBase();
$conn = $db->get_data_base_connction();

// Fetch payment details to delete associated slip file and document record
$stmt = $conn->query("SELECT * FROM `salary_payments` WHERE `id` = $id LIMIT 1");
if ($stmt && $row = $stmt->fetch_assoc()) {
    $recImage = $row['receipt_image'];
    $recNo = $row['receipt_no'];

    if (!empty($recImage) && file_exists(__DIR__ . '/../../' . $recImage)) {
        @unlink(__DIR__ . '/../../' . $recImage);
    }

    $conn->query("DELETE FROM `salary_payments` WHERE `id` = $id");
    if (!empty($recNo)) {
        $cleanRecNo = mysqli_real_escape_string($conn, $recNo);
        $conn->query("DELETE FROM `documents` WHERE `doc_type` = 'Salary Slip / Payment Receipt' AND (`file_name` LIKE '%$cleanRecNo%' OR `file_path` LIKE '%$cleanRecNo%')");
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Payment receipt deleted successfully.'
    ]);
    exit;
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Receipt not found.'
    ]);
    exit;
}
?>
