<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
error_reporting(E_ALL);
ob_start();

header('Content-Type: application/json; charset=utf-8');

function admin_login_as_employee_respond($payload)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode(array($payload));
    exit;
}

function admin_login_as_employee_fail($code)
{
    admin_login_as_employee_respond(array('error' => $code));
}

register_shutdown_function(function () {
    $err = error_get_last();
    if ($err === null) {
        return;
    }
    $fatalTypes = array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR);
    if (!in_array($err['type'], $fatalTypes, true)) {
        return;
    }
    if (headers_sent() === false) {
        header('Content-Type: application/json; charset=utf-8');
    }
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode(array(array(
        'error' => 'SERVER_ERROR',
        'detail' => basename($err['file']) . ':' . $err['line']
    )));
});

if (!isset($_SERVER['REMOTE_ADDR'])) {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}

try {
    include_once __DIR__ . '/../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../imports/need/DB.php';
    include_once __DIR__ . '/../../imports/security/encrypt_decrypt.php';
    include_once __DIR__ . '/../../imports/Company_Info/Company_Info_Variable_List.php';
} catch (Throwable $ex) {
    admin_login_as_employee_fail('BOOTSTRAP_FAILED');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    admin_login_as_employee_fail('INVALID_REQUEST');
}

$is_impersonating = !empty($_SESSION['admin_impersonating']) && $_SESSION['admin_impersonating'] === true;
$caller_user_id   = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$caller_role      = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$caller_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;

$is_admin = (strpos($caller_role, 'admin') !== false) || $caller_level === 1 || $is_impersonating;

if ($caller_user_id === 0 || !$is_admin) {
    admin_login_as_employee_fail('ACCESS_DENIED');
}

$target_id = isset($_POST['employee_user_id']) && (int)$_POST['employee_user_id'] > 0
    ? (int)$_POST['employee_user_id']
    : (isset($_POST['employee_id']) && (int)$_POST['employee_id'] > 0 ? (int)$_POST['employee_id'] : 0);

if ($target_id === 0) {
    admin_login_as_employee_fail('INVALID_EMPLOYEE_ID');
}

function admin_login_as_employee_table_columns($db, $table)
{
    static $cache = array();
    if (isset($cache[$table])) {
        return $cache[$table];
    }
    $cols = array();
    $res = $db->get_result('SHOW COLUMNS FROM `' . str_replace('`', '', $table) . '`');
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            if (!empty($row['Field'])) {
                $cols[strtolower($row['Field'])] = true;
            }
        }
    }
    $cache[$table] = $cols;
    return $cols;
}

function admin_login_as_employee_has_col($db, $table, $column)
{
    $cols = admin_login_as_employee_table_columns($db, $table);
    return isset($cols[strtolower($column)]);
}

function admin_login_as_employee_clip($value, $max)
{
    $value = (string)$value;
    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $max);
    }
    return substr($value, 0, $max);
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
} catch (Throwable $ex) {
    admin_login_as_employee_fail('DB_CONNECTION_FAILED');
}

$emp_profile_id = $target_id;
$emp_user_id    = $target_id;
$emp_name       = '';
$emp_email      = '';
$emp_code       = '';

$prof_res = $db->get_result("SELECT * FROM `employee_profiles` WHERE `id` = '{$target_id}' OR `user_id` = '{$target_id}' LIMIT 1");
if ($prof_res && $prof_res->num_rows > 0) {
    $p = $prof_res->fetch_assoc();
    $emp_profile_id = (int)$p['id'];
    $emp_user_id    = !empty($p['user_id']) ? (int)$p['user_id'] : 0;
    $emp_name       = !empty($p['full_name']) ? trim($p['full_name']) : '';
    $emp_email      = !empty($p['email']) ? trim($p['email']) : '';
    $emp_code       = !empty($p['employee_id_code']) ? trim($p['employee_id_code']) : ('EMP-' . str_pad((string)$emp_profile_id, 3, '0', STR_PAD_LEFT));
}

if ($emp_name === '') {
    $emp_res = $db->get_result("SELECT * FROM `employees` WHERE `id` = '{$target_id}' LIMIT 1");
    if ($emp_res && $emp_res->num_rows > 0) {
        $e = $emp_res->fetch_assoc();
        $emp_profile_id = (int)$e['id'];
        $emp_user_id    = !empty($e['main_user_login_id']) ? (int)$e['main_user_login_id'] : 0;
        $emp_name       = !empty($e['fullname']) ? trim($e['fullname']) : (!empty($e['name']) ? trim($e['name']) : '');
        $emp_email      = !empty($e['email_address']) ? trim($e['email_address']) : (!empty($e['email']) ? trim($e['email']) : '');
        $emp_code       = 'EMP-' . str_pad((string)$emp_profile_id, 3, '0', STR_PAD_LEFT);
    }
}

if ($emp_name === '') {
    $login_res = $db->get_result("SELECT * FROM `main_user_login` WHERE `id` = '{$target_id}' AND `ast` = 1 LIMIT 1");
    if ($login_res && $login_res->num_rows > 0) {
        $u = $login_res->fetch_assoc();
        $emp_profile_id = (int)$u['id'];
        $emp_user_id    = (int)$u['id'];
        $emp_name       = !empty($u['name_show']) ? trim($u['name_show']) : trim((isset($u['first_name']) ? $u['first_name'] : '') . ' ' . (isset($u['last_name']) ? $u['last_name'] : ''));
        $emp_email      = !empty($u['user_name']) ? trim($u['user_name']) : '';
        $emp_code       = 'EMP-' . str_pad((string)$emp_profile_id, 3, '0', STR_PAD_LEFT);
    }
}

if ($emp_name === '') {
    admin_login_as_employee_fail('EMPLOYEE_NOT_FOUND');
}

$valid_login = false;
if ($emp_user_id > 0) {
    $uChk = $db->get_result("SELECT id, main_user_account_access_level_list_id FROM `main_user_login` WHERE `id` = '{$emp_user_id}' LIMIT 1");
    if ($uChk && ($uRow = $uChk->fetch_assoc())) {
        if ((int)$uRow['main_user_account_access_level_list_id'] === 2) {
            $valid_login = true;
        }
    }
}

if (!$valid_login && $emp_email !== '') {
    $safeEmail = addslashes($emp_email);
    $uChk2 = $db->get_result("SELECT id FROM `main_user_login` WHERE `user_name` = '{$safeEmail}' AND `main_user_account_access_level_list_id` = 2 LIMIT 1");
    if ($uChk2 && ($uRow2 = $uChk2->fetch_assoc())) {
        $emp_user_id = (int)$uRow2['id'];
        $valid_login = true;
        if ($emp_profile_id > 0 && admin_login_as_employee_has_col($db, 'employee_profiles', 'user_id')) {
            $db->get_result("UPDATE `employee_profiles` SET `user_id` = '{$emp_user_id}' WHERE `id` = '{$emp_profile_id}'");
        }
    }
}

if (!$valid_login) {
    $login_uname = $emp_email !== '' ? $emp_email : ('emp_' . str_pad((string)$emp_profile_id, 3, '0', STR_PAD_LEFT) . '@neosolution.com');
    $chkAdmin = $db->get_result("SELECT id FROM `main_user_login` WHERE `user_name` = '" . addslashes($login_uname) . "' AND `main_user_account_access_level_list_id` = 1 LIMIT 1");
    if ($chkAdmin && $chkAdmin->num_rows > 0) {
        $parts = explode('@', $login_uname);
        $login_uname = $parts[0] . '.emp@' . (isset($parts[1]) ? $parts[1] : 'neosolution.com');
    }

    $name_parts = explode(' ', $emp_name);
    $first_name = array_shift($name_parts);
    $last_name  = implode(' ', $name_parts);
    if (!class_exists('Advance_Security')) {
        admin_login_as_employee_fail('SERVER_ERROR');
    }
    $sec = new Advance_Security();
    $raw_pass = 'NeoEmp@' . date('Y');
    $enc_pass = $sec->get_data_encrypt($login_uname, $raw_pass);

    $safeUser  = addslashes($login_uname);
    $safeName  = addslashes(admin_login_as_employee_clip($emp_name, 45));
    $safeFirst = addslashes(admin_login_as_employee_clip($first_name !== '' ? $first_name : 'Employee', 45));
    $safeLast  = addslashes(admin_login_as_employee_clip($last_name, 45));
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
        $emp_user_id = (int)$db->get_id();
        if ($emp_user_id > 0) {
            $valid_login = true;
            if ($emp_profile_id > 0 && admin_login_as_employee_has_col($db, 'employee_profiles', 'user_id')) {
                $db->get_result("UPDATE `employee_profiles` SET `user_id` = '{$emp_user_id}' WHERE `id` = '{$emp_profile_id}'");
            }
        }
    }
}

if (!$valid_login || $emp_user_id <= 0) {
    admin_login_as_employee_fail('EMPLOYEE_LOGIN_MISSING');
}

$epChk = $db->get_result("SELECT id FROM `employee_profiles` WHERE `user_id` = '{$emp_user_id}' OR `id` = '{$emp_profile_id}' LIMIT 1");
if (!$epChk || $epChk->num_rows === 0) {
    $fields = array('user_id', 'full_name', 'email', 'department', 'job_title');
    $values = array(
        "'" . $emp_user_id . "'",
        "'" . addslashes($emp_name) . "'",
        "'" . addslashes($emp_email) . "'",
        "'Engineering'",
        "'Staff'"
    );
    if (admin_login_as_employee_has_col($db, 'employee_profiles', 'status')) {
        $fields[] = 'status';
        $values[] = "'active'";
    }
    if (admin_login_as_employee_has_col($db, 'employee_profiles', 'created_at')) {
        $fields[] = 'created_at';
        $values[] = 'NOW()';
    }
    $db->get_result('INSERT INTO `employee_profiles` (`' . implode('`, `', $fields) . '`) VALUES (' . implode(', ', $values) . ')');
    $emp_profile_id = (int)$db->get_id();
} else {
    $epRow = $epChk->fetch_assoc();
    $emp_profile_id = (int)$epRow['id'];
}

if (empty($_SESSION['admin_original_session'])) {
    $_SESSION['admin_original_session'] = array(
        'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1,
        'main_user_login_id' => isset($_SESSION['main_user_login_id']) ? $_SESSION['main_user_login_id'] : (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1),
        'user_name' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin',
        'fullname' => isset($_SESSION['fullname']) ? $_SESSION['fullname'] : (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin'),
        'session_token' => isset($_SESSION['session_token']) ? $_SESSION['session_token'] : '',
        'main_user_account_access_level_list_id' => isset($_SESSION['main_user_account_access_level_list_id']) ? $_SESSION['main_user_account_access_level_list_id'] : 1,
        'url_home' => isset($_SESSION['url_home']) ? $_SESSION['url_home'] : 'UxUi/Admin_user_dashboard.php',
        'user_role' => isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'admin',
        'ac_type' => isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : 'admin',
        'user_main_cook_id' => isset($_SESSION['user_main_cook_id']) ? $_SESSION['user_main_cook_id'] : null,
        'otp_pending' => isset($_SESSION['otp_pending']) ? $_SESSION['otp_pending'] : false,
    );
}

$admin_display_name = !empty($_SESSION['admin_impersonating_name'])
    ? $_SESSION['admin_impersonating_name']
    : (isset($_SESSION['user_name']) && $_SESSION['user_name'] !== '' ? $_SESSION['user_name'] : 'Admin');

$_SESSION['admin_impersonating']      = true;
$_SESSION['admin_impersonating_name'] = $admin_display_name;
$_SESSION['admin_target_emp_name']    = $emp_name;
$_SESSION['admin_target_emp_code']    = $emp_code;

$_SESSION['user_id']                               = $emp_user_id;
$_SESSION['main_user_login_id']                    = $emp_user_id;
$_SESSION['employee_profile_id']                   = $emp_profile_id;
$_SESSION['user_name']                             = $emp_email !== '' ? $emp_email : $emp_name;
$_SESSION['fullname']                              = $emp_name;
$_SESSION['full_name']                             = $emp_name;
$_SESSION['user_role']                             = 'Employee';
$_SESSION['ac_type']                               = 'Employee';
$_SESSION['main_user_account_access_level_list_id'] = 2;
$_SESSION['url_home']                              = 'UxUi/Employee_user_dashboard.php';
$_SESSION['otp_pending']                           = false;
$_SESSION['session_token']                         = bin2hex(random_bytes(16));

try {
    include_once __DIR__ . '/../../Controllers/Main/main_user_login_device/main_user_login_device_ADD_UPDATE.php';
    include_once __DIR__ . '/../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';
    include_once __DIR__ . '/../../Controllers/Main/User_Accout_Check_Device.php';
    if (class_exists('User_Accout_Check_Device')) {
        $device_check = new User_Accout_Check_Device();
        $device_check->set_main_user_login_id($emp_user_id);
        $device_check->check_main_user_login_device();
        $tok = $device_check->get_session_token();
        if (!empty($tok)) {
            $_SESSION['session_token'] = $tok;
        }
    }
} catch (Throwable $ex) {
}

try {
    include_once __DIR__ . '/../../Controllers/Main/Cook_Managment/Cook_Createing.php';
    if (class_exists('Cook_Createing')) {
        $cook_obj = new Cook_Createing($emp_user_id);
        $_SESSION['user_main_cook_id'] = $cook_obj->get_cook_id();
    }
} catch (Throwable $ex) {
}

try {
    include_once __DIR__ . '/../../imports/need/daily_presence.php';
    if (function_exists('update_daily_employee_presence')) {
        update_daily_employee_presence();
    }
} catch (Throwable $ex) {
}

$base = isset($home_page) ? rtrim($home_page, '/') : '';
$redirect_url = $base . '/UxUi/Employee_user_dashboard.php';

admin_login_as_employee_respond(array(
    'error' => '0',
    'redirect_url' => $redirect_url,
    'emp_name' => $emp_name,
    'emp_code' => $emp_code
));

