<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_details_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$list_obj = new employee_details_LIST();

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $list_obj->filter_by_search($_POST['search']);
}
if (isset($_POST['department']) && !empty($_POST['department'])) {
    $list_obj->filter_by_department($_POST['department']);
}

$res = $list_obj->get_result();
$data = array();

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode([
    'status' => 'success',
    'error'  => '0',
    'total'  => count($data),
    'data'   => $data
]);
?>
