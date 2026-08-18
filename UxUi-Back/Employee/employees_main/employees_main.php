<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Employee Modules
 */
$employee_action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : 'fetch');

switch ($employee_action) {
    case 'add':
        include_once __DIR__ . '/../add_employee/add_employee.php';
        break;
    case 'view':
        include_once __DIR__ . '/../view_employee/view_employee.php';
        break;
    case 'edit':
        include_once __DIR__ . '/../edit_employee/edit_employee.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_employee/delete_employee.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_employee/fetch_employee.php';
        break;
}
