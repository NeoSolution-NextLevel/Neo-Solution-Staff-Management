<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../Company_Info/Company_Info_Variable_List.php';

date_default_timezone_set('Asia/Colombo');
$company_info_obj = new Company_Info_Variable_List();
$firebaseProjectId = (method_exists($company_info_obj, 'get_firebase_project_id')) 
    ? ($company_info_obj->get_firebase_project_id() ?: 'ems-app-ea702') 
    : 'ems-app-ea702';
$firebaseServiceAccountJson = '';
$firebaseServiceAccountCandidates = [
    __DIR__ . DIRECTORY_SEPARATOR . 'firebase-service-account.json',
    dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'firebase-service-account.json',
    dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'firebase-service-account.json',
    dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'firebase-service-account.json',
    __DIR__ . DIRECTORY_SEPARATOR . 'ems-firebase-adminsdk.json',
];
foreach ($firebaseServiceAccountCandidates as $candidate) {
    if (is_file($candidate)) {
        $firebaseServiceAccountJson = $candidate;
        break;
    }
}

$sessionMemberIdKey = 'member_list_id';
$sessionAccessLevelKey = 'main_user_account_access_level_list_id';

$superAdminAccessId = '1';
$adminAccessId = '1';
$employeeAccessId = '2';
$cashOwnerAccessId = '2';
$managerAccessId = '3';
$memberAccessId = '4';

$fcmAllTopic = (method_exists($company_info_obj, 'get_fcm_all_topic')) 
    ? ($company_info_obj->get_fcm_all_topic() ?: 'ems_all') 
    : 'ems_all';
$fcmSubscriptionTopicPrefix = (method_exists($company_info_obj, 'get_fcm_subscription_topic_prefix')) 
    ? ($company_info_obj->get_fcm_subscription_topic_prefix() ?: 'ems_sub_') 
    : 'ems_sub_';

require_once __DIR__ . '/../../Controllers/notification/notification_member_SINGLE_DATA.php';

if (!function_exists('ems_restore_login_from_cookie')) {
    function ems_restore_login_from_cookie() {
        if ((int) ($_SESSION['user_id'] ?? 0) > 0) {
            return;
        }

        $cookId = trim((string) ($_COOKIE['main_user_account_cook'] ?? $_COOKIE['Web_View_Cookie_Yes_No'] ?? ''));
        if ($cookId === '' || $cookId === 'NO_DATA') {
            return;
        }

        include_once __DIR__ . '/../need/DB.php';
        if (!class_exists('Cook_Management', false)) {
            include_once __DIR__ . '/../../Controllers/Main/Cook_Managment/Cook_Managing.php';
        }

        $cookie_check_obj = new Cook_Management($cookId);
        if (!$cookie_check_obj->check_login_availability()) {
            return;
        }

        $_SESSION['user_id'] = $cookie_check_obj->get_user_id();
        $_SESSION['user_main_cook_id'] = $cookId;
        $_SESSION['access_control_id'] = $cookie_check_obj->get_access_level_id();
    }
}

if (!function_exists('bmjm_restore_login_from_cookie')) {
    function bmjm_restore_login_from_cookie() {
        ems_restore_login_from_cookie();
    }
}

ems_restore_login_from_cookie();

if (!function_exists('ems_json')) {
    function ems_json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('bmjm_json')) {
    function bmjm_json($data, $status = 200) {
        ems_json($data, $status);
    }
}

if (!function_exists('ems_current_main_user_login_id')) {
    function ems_current_main_user_login_id() {
        $value = $_SESSION['user_id'] ?? $_SESSION['Main_User_Account_List_Id'] ?? 0;
        return (int) $value;
    }
}

if (!function_exists('bmjm_current_main_user_login_id')) {
    function bmjm_current_main_user_login_id() {
        return ems_current_main_user_login_id();
    }
}

if (!function_exists('ems_current_member_id')) {
    function ems_current_member_id() {
        global $sessionMemberIdKey;
        $memberId = (int) ($_SESSION[$sessionMemberIdKey] ?? $_SESSION['member_id'] ?? 0);
        if ($memberId > 0) {
            return $memberId;
        }

        $mainUserLoginId = ems_current_main_user_login_id();
        if ($mainUserLoginId <= 0) {
            return 0;
        }

        $member_data_obj = new notification_member_SINGLE_DATA();
        return $member_data_obj->get_member_list_id_from_main_user_login_id($mainUserLoginId);
    }
}

if (!function_exists('bmjm_current_member_id')) {
    function bmjm_current_member_id() {
        return ems_current_member_id();
    }
}

if (!function_exists('ems_current_cash_owner_id')) {
    function ems_current_cash_owner_id() {
        $co_id = (int) ($_SESSION['cash_owner_id'] ?? $_SESSION['cash_owner_list_id'] ?? 0);
        if ($co_id > 0) {
            return $co_id;
        }
        $mainUserLoginId = ems_current_main_user_login_id();
        if ($mainUserLoginId <= 0) {
            return 0;
        }
        $member_data_obj = new notification_member_SINGLE_DATA();
        return $member_data_obj->get_cash_owner_list_id_from_main_user_login_id($mainUserLoginId);
    }
}

if (!function_exists('bmjm_current_cash_owner_id')) {
    function bmjm_current_cash_owner_id() {
        return ems_current_cash_owner_id();
    }
}

if (!function_exists('ems_current_manager_id')) {
    function ems_current_manager_id() {
        $mgr_id = (int) ($_SESSION['manager_id'] ?? 0);
        if ($mgr_id > 0) {
            return $mgr_id;
        }
        $mainUserLoginId = ems_current_main_user_login_id();
        if ($mainUserLoginId <= 0) {
            return 0;
        }
        $member_data_obj = new notification_member_SINGLE_DATA();
        return $member_data_obj->get_manager_list_id_from_main_user_login_id($mainUserLoginId);
    }
}

if (!function_exists('bmjm_current_manager_id')) {
    function bmjm_current_manager_id() {
        return ems_current_manager_id();
    }
}

if (!function_exists('ems_current_access_id')) {
    function ems_current_access_id() {
        global $sessionAccessLevelKey;
        return (string) ($_SESSION['access_control_id'] ?? $_SESSION[$sessionAccessLevelKey] ?? $_SESSION['ems_access_id'] ?? $_SESSION['bmjm_access_id'] ?? '');
    }
}

if (!function_exists('bmjm_current_access_id')) {
    function bmjm_current_access_id() {
        return ems_current_access_id();
    }
}

if (!function_exists('ems_require_main_user_login')) {
    function ems_require_main_user_login() {
        $mainUserLoginId = ems_current_main_user_login_id();
        if ($mainUserLoginId <= 0) {
            ems_json(['ok' => false, 'error' => 'Please sign in'], 401);
        }
        return $mainUserLoginId;
    }
}

if (!function_exists('bmjm_require_main_user_login')) {
    function bmjm_require_main_user_login() {
        return ems_require_main_user_login();
    }
}

if (!function_exists('ems_require_member_login')) {
    function ems_require_member_login() {
        $memberId = ems_current_member_id();
        if ($memberId <= 0) {
            ems_json(['ok' => false, 'error' => 'Please sign in'], 401);
        }
        return $memberId;
    }
}

if (!function_exists('bmjm_require_member_login')) {
    function bmjm_require_member_login() {
        return ems_require_member_login();
    }
}

if (!function_exists('ems_require_login')) {
    function ems_require_login() {
        return ems_require_member_login();
    }
}

if (!function_exists('bmjm_require_login')) {
    function bmjm_require_login() {
        return ems_require_login();
    }
}

if (!function_exists('ems_is_admin')) {
    function ems_is_admin() {
        global $adminAccessId, $superAdminAccessId;
        $role = strtolower(trim((string) ($_SESSION['role'] ?? $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '')));
        $access = (string) ems_current_access_id();
        $uid = (int) ems_current_main_user_login_id();
        return $access === (string) $adminAccessId || $access === (string) $superAdminAccessId || strpos($role, 'admin') !== false || ($uid === 1 && empty($_SESSION['admin_impersonating']));
    }
}

if (!function_exists('bmjm_is_admin')) {
    function bmjm_is_admin() {
        return ems_is_admin();
    }
}

if (!function_exists('ems_is_superadmin')) {
    function ems_is_superadmin() {
        global $superAdminAccessId;
        $role = strtolower(trim((string) ($_SESSION['role'] ?? $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '')));
        $access = (string) ems_current_access_id();
        $uid = (int) ems_current_main_user_login_id();
        return strpos($role, 'super') !== false || ($access === (string) $superAdminAccessId && $uid === 1);
    }
}

if (!function_exists('bmjm_is_superadmin')) {
    function bmjm_is_superadmin() {
        return ems_is_superadmin();
    }
}

if (!function_exists('ems_is_employee')) {
    function ems_is_employee() {
        global $employeeAccessId;
        $role = strtolower(trim((string) ($_SESSION['role'] ?? $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '')));
        $access = (string) ems_current_access_id();
        $uid = (int) ems_current_main_user_login_id();
        if ($uid === 1 && empty($_SESSION['admin_impersonating'])) {
            return false;
        }
        return $access === (string) $employeeAccessId || $access === '3' || strpos($role, 'employee') !== false || $role === 'staff';
    }
}

if (!function_exists('bmjm_is_employee')) {
    function bmjm_is_employee() {
        return ems_is_employee();
    }
}

if (!function_exists('neo_current_user_id')) {
    function neo_current_user_id() {
        return ems_current_main_user_login_id();
    }
}

if (!function_exists('neo_is_admin')) {
    function neo_is_admin() {
        return ems_is_admin();
    }
}

if (!function_exists('neo_is_superadmin')) {
    function neo_is_superadmin() {
        return ems_is_superadmin();
    }
}

if (!function_exists('neo_is_employee')) {
    function neo_is_employee() {
        return ems_is_employee();
    }
}

if (!function_exists('neo_current_user_role')) {
    function neo_current_user_role() {
        if (function_exists('get_user_role_value')) {
            return get_user_role_value();
        }
        if (ems_is_superadmin()) return 'superadmin';
        if (ems_is_admin()) return 'admin';
        if (ems_is_employee()) return 'employee';
        return 'guest';
    }
}

if (!function_exists('ems_is_cash_owner')) {
    function ems_is_cash_owner() {
        global $adminAccessId, $cashOwnerAccessId;
        $access = ems_current_access_id();
        $role = (string) ($_SESSION['role'] ?? '');
        return $access === (string) $adminAccessId || $access === (string) $cashOwnerAccessId || $role === 'cash_owner' || $role === 'admin';
    }
}

if (!function_exists('bmjm_is_cash_owner')) {
    function bmjm_is_cash_owner() {
        return ems_is_cash_owner();
    }
}

if (!function_exists('ems_is_manager')) {
    function ems_is_manager() {
        global $managerAccessId;
        $access = ems_current_access_id();
        $role = (string) ($_SESSION['role'] ?? '');
        return $access === (string) $managerAccessId || $role === 'manager';
    }
}

if (!function_exists('bmjm_is_manager')) {
    function bmjm_is_manager() {
        return ems_is_manager();
    }
}

if (!function_exists('ems_notification_public_image_pth')) {
    function ems_notification_public_image_pth($image_pth) {
        $image_pth = trim((string) $image_pth);
        if ($image_pth === '' || preg_match('/^https?:\/\//i', $image_pth)) {
            return $image_pth;
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if ($host === '' || preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/i', $host)) {
            $scheme = 'https';
            $host = 'ems.neosolution.lk';
        }

        return $scheme . '://' . $host . '/' . ltrim($image_pth, '/');
    }
}

if (!function_exists('bmjm_notification_public_image_pth')) {
    function bmjm_notification_public_image_pth($image_pth) {
        return ems_notification_public_image_pth($image_pth);
    }
}
