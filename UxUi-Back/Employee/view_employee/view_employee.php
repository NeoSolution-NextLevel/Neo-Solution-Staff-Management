<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_SINGLE_DATA.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if ($id > 0) {
    try {
        $single_obj = new employee_SINGLE_DATA($id);
        if ($single_obj->get_state()) {
            echo json_encode([
                'status' => 'success',
                'data'   => $single_obj->to_array()
            ]);
            exit;
        }
    } catch (\Throwable $e) {
        // Fallback to session
    }

    if (isset($_SESSION['employee_list']) && is_array($_SESSION['employee_list'])) {
        foreach ($_SESSION['employee_list'] as $emp) {
            if ((int)$emp['id'] === $id) {
                echo json_encode([
                    'status' => 'success',
                    'data'   => $emp
                ]);
                exit;
            }
        }
    }
}

echo json_encode([
    'status'  => 'error',
    'message' => 'Employee record not found.'
]);
exit;
