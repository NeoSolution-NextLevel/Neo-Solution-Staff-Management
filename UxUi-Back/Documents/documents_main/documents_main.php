<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Document / CV Modules
 */
$document_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($document_action) {
    case 'view':
        include_once __DIR__ . '/../view_cv/view_cv.php';
        break;
    case 'download':
        include_once __DIR__ . '/../download_cv/download_cv.php';
        break;
    case 'upload':
        include_once __DIR__ . '/../upload_cv/upload_cv.php';
        break;
    case 'delete':
        include_once __DIR__ . '/../delete_cv/delete_cv.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_cv/fetch_cv.php';
        break;
}
