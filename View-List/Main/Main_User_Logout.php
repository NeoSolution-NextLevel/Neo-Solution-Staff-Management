<?php
include_once '../../imports/need/session_setup.php';
include_once '../../imports/need/DB.php';
include_once '../../Controllers/Main/Cook_Managment/Cook_Managing.php';

$json = [];
$state = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" || $_SERVER["REQUEST_METHOD"] === "GET") {

    if (!empty($user_main_cook_id)) {
        try {
            $Cook_Management_obj = new Cook_Management($user_main_cook_id);
            $Cook_Management_obj->main_user_login_logout($user_id);
        } catch (\Throwable $e) {}
    }

    // Always clear the auth cookie
    if (isset($_COOKIE['main_user_account_cook'])) {
        setcookie('main_user_account_cook', '', time() - 86400, '/');
    }

    // Clear all session variables
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }

    $state['error'] = "0";
} else {
    $state['error'] = "INVALID_REQUEST";
}

$json[] = $state;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $loginUrl = rtrim($GLOBALS['home_page'] ?? '/', '/') . '/UxUi/Main/User-Login.php?logout=1';
    header('Location: ' . $loginUrl);
    exit;
}

header('Content-Type: application/json');
echo json_encode($json);
exit;
