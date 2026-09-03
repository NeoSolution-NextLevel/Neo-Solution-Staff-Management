<?php
ob_start();
// =============================================================
// Admin "Login as Employee" Impersonation Endpoint
// =============================================================
// Validates that the caller is an admin (or already impersonating),
// then builds a valid PHP session for the target employee.
// Supports all employees registered in employee_profiles, employees,
// or main_user_login.
// =============================================================

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../imports/Company_Info/Company_Info_Variable_List.php';
include_once __DIR__ . '/../../imports/security/encrypt_decrypt.php';
include_once __DIR__ . '/../../imports/security/key_list.php';
include_once __DIR__ . '/../../Controllers/Main/Cook_Managment/Cook_Createing.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_login_device/main_user_login_device_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';
if (!isset($_SERVER['REMOTE_ADDR'])) {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}
include_once __DIR__ . '/../../Controllers/Main/User_Accout_Check_Device.php';

header('Content-Type: application/json');

$json  = [];
$state = [];

// ---- 1. Only allow POST ----
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $state['error'] = 'INVALID_REQUEST';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 2. Verify caller is an authenticated admin (or currently impersonating admin) ----
$is_impersonating = !empty($_SESSION['admin_impersonating']) && $_SESSION['admin_impersonating'] === true;
$caller_user_id   = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$caller_role      = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));

$is_admin = (strpos($caller_role, 'admin') !== false) || $is_impersonating;

if ($caller_user_id === 0 || !$is_admin) {
    $state['error'] = 'ACCESS_DENIED';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 3. Get target employee ID ----
$target_id = isset($_POST['employee_user_id']) && (int)$_POST['employee_user_id'] > 0
    ? (int)$_POST['employee_user_id']
    : (isset($_POST['employee_id']) && (int)$_POST['employee_id'] > 0 ? (int)$_POST['employee_id'] : 0);

if ($target_id === 0) {
    $state['error'] = 'INVALID_EMPLOYEE_ID';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 4. Find the employee across available tables ----
$db = new DataBase();

$emp_profile_id = $target_id;
$emp_user_id    = $target_id;
$emp_name       = '';
$emp_email      = '';
$emp_code       = '';

// 4a. Check employee_profiles first
$prof_res = $db->get_result("SELECT * FROM `employee_profiles` WHERE `id` = '{$target_id}' OR `user_id` = '{$target_id}' LIMIT 1");
if ($prof_res && $prof_res->num_rows > 0) {
    $p = $prof_res->fetch_assoc();
    $emp_profile_id = (int)$p['id'];
    $emp_user_id    = !empty($p['user_id']) ? (int)$p['user_id'] : (int)$p['id'];
    $emp_name       = !empty($p['full_name']) ? trim($p['full_name']) : '';
    $emp_email      = !empty($p['email']) ? trim($p['email']) : '';
    $emp_code       = !empty($p['employee_id_code']) ? trim($p['employee_id_code']) : ('EMP-' . str_pad($emp_profile_id, 3, '0', STR_PAD_LEFT));
}

// 4b. Check employees table if name is still empty
if (empty($emp_name)) {
    $emp_res = $db->get_result("SELECT * FROM `employees` WHERE `id` = '{$target_id}' LIMIT 1");
    if ($emp_res && $emp_res->num_rows > 0) {
        $e = $emp_res->fetch_assoc();
        $emp_profile_id = (int)$e['id'];
        $emp_user_id    = (int)$e['id'];
        $emp_name       = !empty($e['fullname']) ? trim($e['fullname']) : (!empty($e['name']) ? trim($e['name']) : '');
        $emp_email      = !empty($e['email_address']) ? trim($e['email_address']) : (!empty($e['email']) ? trim($e['email']) : '');
        $emp_code       = 'EMP-' . str_pad($emp_profile_id, 3, '0', STR_PAD_LEFT);
    }
}

// 4c. Check main_user_login table if name is still empty
if (empty($emp_name)) {
    $login_res = $db->get_result("SELECT * FROM `main_user_login` WHERE `id` = '{$target_id}' AND `ast` = 1 LIMIT 1");
    if ($login_res && $login_res->num_rows > 0) {
        $u = $login_res->fetch_assoc();
        $emp_profile_id = (int)$u['id'];
        $emp_user_id    = (int)$u['id'];
        $emp_name       = !empty($u['name_show']) ? trim($u['name_show']) : (trim($u['first_name'] . ' ' . $u['last_name']));
        $emp_email      = !empty($u['user_name']) ? trim($u['user_name']) : '';
        $emp_code       = 'EMP-' . str_pad($emp_profile_id, 3, '0', STR_PAD_LEFT);
    }
}

if (empty($emp_name)) {
    $state['error'] = 'EMPLOYEE_NOT_FOUND';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 5. Save original admin session (only if not already impersonating) ----
if (empty($_SESSION['admin_original_session'])) {
    $_SESSION['admin_original_session'] = [
        'user_id'                                => $_SESSION['user_id']                                ?? 1,
        'user_name'                              => $_SESSION['user_name']                              ?? 'Admin',
        'session_token'                          => $_SESSION['session_token']                          ?? '',
        'main_user_account_access_level_list_id'   => $_SESSION['main_user_account_access_level_list_id'] ?? 1,
        'url_home'                               => $_SESSION['url_home']                               ?? 'UxUi/Admin_user_dashboard.php',
        'user_role'                              => $_SESSION['user_role']                              ?? 'admin',
        'ac_type'                                => $_SESSION['ac_type']                                ?? 'admin',
        'user_main_cook_id'                      => $_SESSION['user_main_cook_id']                      ?? null,
        'otp_pending'                            => $_SESSION['otp_pending']                            ?? false,
    ];
}

$admin_display_name = !empty($_SESSION['admin_impersonating_name'])
    ? $_SESSION['admin_impersonating_name']
    : (isset($_SESSION['user_name']) && $_SESSION['user_name'] !== '' ? $_SESSION['user_name'] : 'Admin');

// ---- 6. Switch session to the target employee ----
$_SESSION['admin_impersonating']      = true;
$_SESSION['admin_impersonating_name'] = $admin_display_name;
$_SESSION['admin_target_emp_name']    = $emp_name;
$_SESSION['admin_target_emp_code']    = $emp_code;

$_SESSION['user_id']                                = $emp_user_id;
$_SESSION['main_user_login_id']                     = $emp_user_id;
$_SESSION['employee_profile_id']                    = $emp_profile_id;
$_SESSION['user_name']                              = $emp_email ?: $emp_name;
$_SESSION['fullname']                               = $emp_name;
$_SESSION['user_role']                              = 'Employee';
$_SESSION['ac_type']                                = 'Employee';
$_SESSION['main_user_account_access_level_list_id']  = 2;
$_SESSION['url_home']                               = 'UxUi/Employee_user_dashboard.php';
$_SESSION['otp_pending']                            = false;

// Optional: Device token and cook_id
$_SESSION['session_token'] = bin2hex(random_bytes(16));
try {
    if (class_exists('User_Accout_Check_Device')) {
        $device_check = new User_Accout_Check_Device();
        $device_check->set_main_user_login_id($emp_user_id);
        $device_check->check_main_user_login_device();
        $tok = $device_check->get_session_token();
        if (!empty($tok)) $_SESSION['session_token'] = $tok;
    }
} catch (Throwable $ex) {}

try {
    if (class_exists('Cook_Createing')) {
        $cook_obj = new Cook_Createing($emp_user_id);
        $_SESSION['user_main_cook_id'] = $cook_obj->get_cook_id();
    }
} catch (Throwable $ex) {}

// ---- 7. Return redirect URL to employee dashboard ----
$redirect_url = rtrim($home_page, '/') . '/UxUi/Employee_user_dashboard.php';

$state['error']        = '0';
$state['redirect_url'] = $redirect_url;
$state['emp_name']     = $emp_name;
$state['emp_code']     = $emp_code;
$json[] = $state;

if (ob_get_level() > 0) {
    ob_clean();
}
echo json_encode($json);
exit;
