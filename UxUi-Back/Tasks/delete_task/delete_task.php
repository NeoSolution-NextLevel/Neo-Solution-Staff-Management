<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Task ID is required.']);
    exit;
}

$db = new DataBase();
$db->get_result("DELETE FROM `system_tasks` WHERE `id` = $id");

echo json_encode([
    'status'  => 'success',
    'message' => 'Task deleted successfully from database.'
]);
exit;
?>
