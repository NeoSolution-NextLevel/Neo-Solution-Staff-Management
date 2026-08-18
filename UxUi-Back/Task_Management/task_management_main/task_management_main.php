<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Task Management Modules
 */
$task_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($task_action) {
    case 'create':
    case 'add':
        include_once __DIR__ . '/../create_task/create_task.php';
        break;
    case 'edit':
        include_once __DIR__ . '/../edit_task/edit_task.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_task/delete_task.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_task/fetch_task.php';
        break;
}
