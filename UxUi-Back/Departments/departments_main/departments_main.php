<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Department Modules
 */
$department_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($department_action) {
    case 'add':
        include_once __DIR__ . '/../add_department/add_department.php';
        break;
    case 'edit':
        include_once __DIR__ . '/../edit_department/edit_department.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_department/delete_department.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_department/fetch_department.php';
        break;
}
