<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/session_setup.php';

$updated = function_exists('update_daily_employee_presence')
    ? update_daily_employee_presence()
    : false;

echo json_encode([
    'status' => $updated ? 'success' : 'ignored',
    'date' => date('Y-m-d')
]);
?>
