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
    $emp_user_id    = !empty($p['user_id']) ? (int)$p['user_id'] : 0;
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
        $emp_user_id    = 0;
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

// 4d. Ensure target has a genuine employee account in main_user_login (level 2)
$valid_login = false;
if ($emp_user_id > 0) {
    $uChk = $db->get_result("SELECT id, main_user_account_access_level_list_id FROM `main_user_login` WHERE `id` = '{$emp_user_id}' LIMIT 1");
    if ($uChk && ($uRow = $uChk->fetch_assoc())) {
        if ((int)$uRow['main_user_account_access_level_list_id'] === 2) {
            $valid_login = true;
        }
    }
}

if (!$valid_login && !empty($emp_email)) {
    $safeEmail = addslashes($emp_email);
    $uChk2 = $db->get_result("SELECT id FROM `main_user_login` WHERE `user_name` = '{$safeEmail}' AND `main_user_account_access_level_list_id` = 2 LIMIT 1");
    if ($uChk2 && ($uRow2 = $uChk2->fetch_assoc())) {
        $emp_user_id = (int)$uRow2['id'];
        $valid_login = true;
        if ($emp_profile_id > 0) {
            $db->get_result("UPDATE `employee_profiles` SET `user_id` = '{$emp_user_id}' WHERE `id` = '{$emp_profile_id}'");
        }
    }
}

// Auto-create login account on the fly if missing
if (!$valid_login) {
    $login_uname = $emp_email ?: ('emp_' . str_pad($emp_profile_id, 3, '0', STR_PAD_LEFT) . '@neosolution.com');
    $chkAdmin = $db->get_result("SELECT id FROM `main_user_login` WHERE `user_name` = '" . addslashes($login_uname) . "' AND `main_user_account_access_level_list_id` = 1 LIMIT 1");
    if ($chkAdmin && $chkAdmin->num_rows > 0) {
        $parts = explode('@', $login_uname);
        $login_uname = $parts[0] . '.emp@' . ($parts[1] ?? 'neosolution.com');
    }

    $name_parts = explode(' ', $emp_name);
    $first_name = array_shift($name_parts);
    $last_name  = implode(' ', $name_parts);
    $sec = new Advance_Security();
    $raw_pass = 'NeoEmp@' . date('Y');
    $enc_pass = $sec->get_data_encrypt($login_uname, $raw_pass);

    $safeUser  = addslashes($login_uname);
    $safeName  = addslashes($emp_name);
    $safeFirst = addslashes($first_name ?: 'Employee');
    $safeLast  = addslashes($last_name ?: '');
    $safePass  = addslashes($enc_pass);

    $insSql = "INSERT INTO `main_user_login` (
        `company_id`, `user_name`, `password`, `name_show`, `first_name`, `last_name`,
        `main_user_account_access_level_list_id`, `ac_type`, `ast`,
        `account_active_state`, `email_verify`, `sdt`
    ) VALUES (
        1, '{$safeUser}', '{$safePass}', '{$safeName}', '{$safeFirst}', '{$safeLast}',
        2, 'Employee', 1, 1, 1, NOW()
    )";
    if ($db->get_result($insSql)) {
        $conn = $db->get_data_base_connction();
        $emp_user_id = (int)$conn->insert_id;
        if ($emp_profile_id > 0) {
            $db->get_result("UPDATE `employee_profiles` SET `user_id` = '{$emp_user_id}' WHERE `id` = '{$emp_profile_id}'");
        }
    }
}

// 4e. Ensure employee_profiles record exists and is linked
$epChk = $db->get_result("SELECT id FROM `employee_profiles` WHERE `user_id` = '{$emp_user_id}' OR `id` = '{$emp_profile_id}' LIMIT 1");
if (!$epChk || $epChk->num_rows === 0) {
    $safeName = addslashes($emp_name);
    $safeEmail = addslashes($emp_email);
    $db->get_result("INSERT INTO `employee_profiles` (`user_id`, `full_name`, `email`, `department`, `job_title`, `status`, `created_at`)
                     VALUES ('{$emp_user_id}', '{$safeName}', '{$safeEmail}', 'Engineering', 'Staff', 'active', NOW())");
    $conn = $db->get_data_base_connction();
    $emp_profile_id = (int)$conn->insert_id;
} else {
    $epRow = $epChk->fetch_assoc();
    $emp_profile_id = (int)$epRow['id'];
}

// ---- 5. Save original admin session (only if not already impersonating) ----
if (empty($_SESSION['admin_original_session'])) {
    $_SESSION['admin_original_session'] = [
        'user_id'                                => $_SESSION['user_id']                                ?? 1,
        'main_user_login_id'                     => $_SESSION['main_user_login_id']                     ?? ($_SESSION['user_id'] ?? 1),
        'user_name'                              => $_SESSION['user_name']                              ?? 'Admin',
        'fullname'                               => $_SESSION['fullname']                               ?? ($_SESSION['user_name'] ?? 'Admin'),
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

// Record daily presence for this employee
include_once __DIR__ . '/../../imports/need/daily_presence.php';
if (function_exists('update_daily_employee_presence')) {
    update_daily_employee_presence();
}

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
