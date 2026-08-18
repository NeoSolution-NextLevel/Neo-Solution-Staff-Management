<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Main Loader Controller for Settings Modules
 */
$settings_action = isset($_GET['action']) ? $_GET['action'] : 'fetch';

switch ($settings_action) {
    case 'update':
    case 'save':
        include_once __DIR__ . '/../update_settings/update_settings.php';
        break;
    case 'fetch':
    default:
        include_once __DIR__ . '/../fetch_settings/fetch_settings.php';
        break;
}
