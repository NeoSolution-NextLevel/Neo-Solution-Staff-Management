<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Leave Requests Modules
 */
$leave_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($leave_action) {
    case 'create':
    case 'add':
        include_once __DIR__ . '/../create_leave_request/create_leave_request.php';
        break;
    case 'approve':
        include_once __DIR__ . '/../approve_leave_request/approve_leave_request.php';
        break;
    case 'reject':
        include_once __DIR__ . '/../reject_leave_request/reject_leave_request.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_leave_request/delete_leave_request.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_leave_request/fetch_leave_request.php';
        break;
}
