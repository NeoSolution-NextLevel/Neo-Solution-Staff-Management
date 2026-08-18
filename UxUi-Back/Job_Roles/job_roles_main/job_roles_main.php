<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Job Roles Modules
 */
$job_role_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($job_role_action) {
    case 'add':
        include_once __DIR__ . '/../add_job_roles/add_job_roles.php';
        break;
    case 'edit':
        include_once __DIR__ . '/../edit_job_roles/edit_job_roles.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_job_roles/delete_job_roles.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_job_roles/fetch_job_roles.php';
        break;
}
