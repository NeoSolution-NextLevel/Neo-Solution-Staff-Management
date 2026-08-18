<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Dashboard/dashboard_SINGLE_DATA.php';

header('Content-Type: application/json; charset=utf-8');

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : (isset($_GET['user_id']) ? $_GET['user_id'] : null);
$dashboard_single = new dashboard_SINGLE_DATA($user_id);

echo json_encode([
    'status' => 'success',
    'error' => '0',
    'data' => $dashboard_single->to_array()
]);
?>
