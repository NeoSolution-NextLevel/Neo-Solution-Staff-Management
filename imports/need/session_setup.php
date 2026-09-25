<?php

include_once __DIR__ . '/daily_presence.php';

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    $timeout_duration = 3600 * 24; 
    @ini_set('session.gc_maxlifetime', $timeout_duration);
    @session_start();
}


$time = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
if (session_status() === PHP_SESSION_ACTIVE) {
    $_SESSION['LAST_ACTIVITY'] = $time;
}


$pth = "";
$online_state = true;
$online_exnction = "";
// $online_offline_extention = "";
$pth_php = "";

$online_offline_extention = ".php";

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$scriptUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$pathParts = explode('/', trim($scriptUri, '/'));
$projectPrefix = '';
$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])) : '';
$projectDir = str_replace('\\', '/', realpath(dirname(dirname(__DIR__))));
if ($docRoot !== '' && $projectDir && strpos($projectDir, $docRoot) === 0) {
    $relPath = trim(substr($projectDir, strlen($docRoot)), '/');
    $projectPrefix = $relPath !== '' ? $relPath . '/' : '';
} else {
    $folderName = basename(dirname(dirname(__DIR__)));
    $fIndex = array_search($folderName, $pathParts, true);
    if ($fIndex !== false) {
        $projectPrefix = implode('/', array_slice($pathParts, 0, $fIndex + 1)) . '/';
    } else {
        $uxIndex = array_search('UxUi', $pathParts, true);
        if ($uxIndex !== false && $uxIndex > 0) {
            $projectPrefix = implode('/', array_slice($pathParts, 0, $uxIndex)) . '/';
        }
    }
}
$home_page = $scheme . '://' . $host . '/' . $projectPrefix;
$User_login_url = "UxUi/Main/";
$home_page_url = $home_page . "index" . $online_offline_extention;

include_once __DIR__ . '/auth_guard.php';

//---------------local host-------------------------------------
$total_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''; // e.g.  /folder/sub/page.php
if (function_exists('parse_url')) {
    $pathOnly = parse_url($total_url, PHP_URL_PATH);
    if (is_string($pathOnly) && $pathOnly !== '') {
        $total_url = $pathOnly;
    }
}

$pth = "";

// split the path into parts
$parts = explode("/", trim($total_url, "/")); // ["folder", "sub", "page.php"]

// remove the last element (the file itself)
array_pop($parts);

// count how many folders deep
$count = count($parts);

// build ../
for ($i = 0; $i < $count; $i++) {
    $pth .= "../";
}

//-------------------online-------------------------------


$pth_php = dirname(__FILE__);

//---------------local host-------------------------------------
$_SESSION['pth'] = $pth;

$_SESSION['pth_php'] = $pth_php;

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "0";
$user_main_cook_id = isset($_SESSION['user_main_cook_id']) ? $_SESSION['user_main_cook_id'] : "0";

// Record one presence row per employee per calendar day on authenticated requests.
if ($user_id !== "0" && !empty($_SESSION['user_role'])) {
    update_daily_employee_presence();
}

function get_current_logged_user_info()
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }

    if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0) {
        return [
            'full_name'  => 'Guest',
            'first_name' => 'Guest',
            'role'       => 'Guest',
            'department' => '',
            'initials'   => 'GU',
            'pic'        => '',
            'emp_code'   => ''
        ];
    }

    $uid = (int)$_SESSION['user_id'];
    $uemail = isset($_SESSION['user_name']) ? trim((string)$_SESSION['user_name']) : '';
    $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : 'Staff');

    // Admin detection: system administrators must NEVER resolve to employee records
    $isAdmin = (
        (strtolower((string)$userRole) === 'admin') ||
        (isset($_SESSION['ac_type']) && strtolower((string)$_SESSION['ac_type']) === 'admin') ||
        (isset($_SESSION['main_user_account_access_level_list_id']) && (int)$_SESSION['main_user_account_access_level_list_id'] === 1) ||
        ($uid === 1 && empty($_SESSION['admin_impersonating']))
    );

    if ($isAdmin) {
        $adminName = 'Admin';
        $adminRole = 'System Administrator';
        $adminDept = 'Administration';
        $adminCode = 'ADM-001';
        $adminPic = !empty($_SESSION['image_url']) ? $_SESSION['image_url'] : (!empty($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : '');

        $_SESSION['full_name'] = $adminName;
        $_SESSION['first_name'] = $adminName;
        $_SESSION['job_title'] = $adminRole;
        $_SESSION['department'] = $adminDept;
        $_SESSION['employee_id_code'] = $adminCode;
        $_SESSION['user_role'] = 'admin';

        $cached = [
            'full_name'  => $adminName,
            'first_name' => $adminName,
            'role'       => $adminRole,
            'department' => $adminDept,
            'initials'   => 'AD',
            'pic'        => $adminPic,
            'emp_code'   => $adminCode
        ];
        return $cached;
    }

    $fullName = isset($_SESSION['full_name']) && !empty($_SESSION['full_name']) ? $_SESSION['full_name'] : '';
    $role = isset($_SESSION['job_title']) && !empty($_SESSION['job_title']) ? $_SESSION['job_title'] : $userRole;
    $dept = isset($_SESSION['department']) && !empty($_SESSION['department']) ? $_SESSION['department'] : '';
    $pic = isset($_SESSION['profile_pic']) && !empty($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : '';
    $empCode = isset($_SESSION['employee_id_code']) && !empty($_SESSION['employee_id_code']) ? $_SESSION['employee_id_code'] : '';

    if (empty($fullName)) {
        try {
            include_once __DIR__ . '/DB.php';
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $safeEmail = addslashes($uemail);

            // 1. employee_profiles (exclude admin user id 1)
            $chk1 = $conn->query("SELECT * FROM `employee_profiles` WHERE (`email` != '' AND `email` = '{$safeEmail}') OR (`user_id` = '{$uid}' AND `user_id` > 1" . (!empty($safeEmail) ? " AND (`email` = '' OR `email` IS NULL OR `email` = '{$safeEmail}')" : "") . ") LIMIT 1");
            if ($chk1 && $r1 = $chk1->fetch_assoc()) {
                $fullName = !empty($r1['full_name']) ? $r1['full_name'] : '';
                if (!empty($r1['job_title'])) $role = $r1['job_title'];
                if (!empty($r1['department'])) $dept = $r1['department'];
                if (!empty($r1['profile_pic'])) $pic = $r1['profile_pic'];
                if (!empty($r1['employee_id_code'])) $empCode = $r1['employee_id_code'];
            }

            // 2. employees (exclude admin user id 1)
            if (empty($fullName)) {
                $chk2 = $conn->query("SELECT * FROM `employees` WHERE (`email_address` != '' AND `email_address` = '{$safeEmail}') OR (`main_user_login_id` = '{$uid}' AND `main_user_login_id` > 1" . (!empty($safeEmail) ? " AND (`email_address` = '' OR `email_address` IS NULL OR `email_address` = '{$safeEmail}')" : "") . ") LIMIT 1");
                if ($chk2 && $r2 = $chk2->fetch_assoc()) {
                    $fullName = !empty($r2['fullname']) ? $r2['fullname'] : '';
                    if (!empty($r2['job_roles'])) $role = $r2['job_roles'];
                    if (!empty($r2['departments'])) $dept = $r2['departments'];
                }
            }

            // 3. main_user_login
            if (empty($fullName)) {
                $chk3 = $conn->query("SELECT * FROM `main_user_login` WHERE `id` = '{$uid}' LIMIT 1");
                if ($chk3 && $r3 = $chk3->fetch_assoc()) {
                    $fullName = !empty($r3['name_show']) ? $r3['name_show'] : trim(($r3['first_name'] ?? '') . ' ' . ($r3['last_name'] ?? ''));
                    if (empty($fullName)) {
                        $fullName = $r3['user_name'];
                    }
                    if (empty($role) && !empty($r3['ac_type'])) $role = $r3['ac_type'];
                    if (empty($pic) && !empty($r3['image_url'])) $pic = $r3['image_url'];
                }
            }
        } catch (\Throwable $e) {}
    }

    if (empty($fullName)) {
        $fullName = !empty($uemail) ? $uemail : 'Employee';
    }
    if (empty($dept)) {
        $dept = 'General';
    }
    if (empty($empCode)) {
        $empCode = 'EMP-' . str_pad((string)$uid, 3, '0', STR_PAD_LEFT);
    }

    $firstName = trim(explode(' ', trim($fullName))[0]);
    if (empty($firstName)) $firstName = 'Employee';

    $words = array_filter(explode(' ', trim($fullName)));
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= strtoupper(substr($w, 0, 1));
    }
    if (empty($initials)) $initials = 'EM';

    $_SESSION['full_name'] = $fullName;
    $_SESSION['first_name'] = $firstName;
    $_SESSION['job_title'] = $role;
    $_SESSION['department'] = $dept;
    $_SESSION['employee_id_code'] = $empCode;

    $cached = [
        'full_name'  => $fullName,
        'first_name' => $firstName,
        'role'       => $role,
        'department' => $dept,
        'initials'   => $initials,
        'pic'        => $pic,
        'emp_code'   => $empCode
    ];

    return $cached;
}

$current_logged_user = get_current_logged_user_info();
$logged_user_name = $current_logged_user['full_name'];
$logged_user_first_name = $current_logged_user['first_name'];
$logged_user_role = $current_logged_user['role'];
$logged_user_dept = $current_logged_user['department'];
$logged_user_pic = $current_logged_user['pic'];
$logged_user_initials = $current_logged_user['initials'];
$logged_user_emp_code = $current_logged_user['emp_code'];

//----------------------company data--------------------------------
