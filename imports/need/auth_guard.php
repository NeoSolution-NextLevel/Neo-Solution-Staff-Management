<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/session_setup.php';

function normalize_role_value($role)
{
    return trim(strtolower($role));
}

function get_user_role_value()
{
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== '') {
        return $_SESSION['user_role'];
    }

    if (isset($_SESSION['ac_type']) && $_SESSION['ac_type'] !== '') {
        return $_SESSION['ac_type'];
    }

    return '';
}

function get_user_access_level_id()
{
    return isset($_SESSION['main_user_account_access_level_list_id']) ? $_SESSION['main_user_account_access_level_list_id'] : '';
}

function get_access_level_redirect_url($accessLevelId)
{
    if (empty($accessLevelId)) {
        return '';
    }

    include_once __DIR__ . '/../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_SINGLE_DATA.php';

    $acl = new main_user_account_access_level_list_SINGLE_DATA($accessLevelId);
    if (!$acl->get_state()) {
        return '';
    }

    $urlHome = trim($acl->get_url_home());
    if ($urlHome !== '') {
        if (stripos($urlHome, 'http://') === 0 || stripos($urlHome, 'https://') === 0) {
            return $urlHome;
        }

        return rtrim($GLOBALS['home_page'], '/') . '/' . ltrim($urlHome, '/');
    }

    return $acl->get_type_of_access();
}

function get_dashboard_redirect_url()
{
    $default = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/Successful-Page.php';
    $roleValue = normalize_role_value(get_user_role_value());
    $accessLevelId = get_user_access_level_id();

    if ($accessLevelId !== '') {
        $accessLevelTarget = get_access_level_redirect_url($accessLevelId);
        if ($accessLevelTarget !== '') {
            $accessLevelTarget = trim($accessLevelTarget);
            if (stripos($accessLevelTarget, 'http://') === 0 || stripos($accessLevelTarget, 'https://') === 0) {
                return $accessLevelTarget;
            }

            $accessLevelTarget = normalize_role_value($accessLevelTarget);
            if (strpos($accessLevelTarget, 'admin') !== false) {
                return rtrim($GLOBALS['home_page'], '/') . '/UxUi/Admin_user_dashboard.php';
            }
            if (strpos($accessLevelTarget, 'employee') !== false || strpos($accessLevelTarget, 'user') !== false || strpos($accessLevelTarget, 'staff') !== false) {
                return rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main-Dashboard.php';
            }
        }
    }

    if ($roleValue !== '') {
        if (strpos($roleValue, 'admin') !== false || strpos($roleValue, 'manager') !== false || strpos($roleValue, 'super') !== false) {
            return rtrim($GLOBALS['home_page'], '/') . '/UxUi/Admin_user_dashboard.php';
        }
        if (strpos($roleValue, 'employee') !== false || strpos($roleValue, 'user') !== false || strpos($roleValue, 'staff') !== false) {
            return rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main-Dashboard.php';
        }
    }

    return $default;
}

function redirect_to_failed_page($error = 'Authentication-Required')
{
    $url = rtrim($GLOBALS['home_page'], '/') . '/UxUi/Main/Failed-Page.php?error=' . urlencode($error);
    header('Location: ' . $url);
    exit;
}

function require_auth_guard($allowedRolePatterns = [])
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
        redirect_to_failed_page('Authentication-Required');
    }

    if (!empty($allowedRolePatterns)) {
        $roleValue = normalize_role_value(get_user_role_value());
        foreach ($allowedRolePatterns as $pattern) {
            if (strpos($roleValue, normalize_role_value($pattern)) !== false) {
                return;
            }
        }

        redirect_to_failed_page('Access-Denied');
    }
}
