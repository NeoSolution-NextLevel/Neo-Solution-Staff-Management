<?php

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Dashboard/dashboard_details_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$dashboard_obj = new dashboard_details_LIST();
$full_data = $dashboard_obj->get_full_dashboard_data();

echo json_encode([
    'status' => 'success',
    'error' => '0',
    'data' => $full_data
]);
?>
