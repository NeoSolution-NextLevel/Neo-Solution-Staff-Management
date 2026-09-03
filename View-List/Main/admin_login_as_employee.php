<?php
// =============================================================
// Admin "Login as Employee" Impersonation Endpoint
// =============================================================
// Validates that the caller is an admin, then builds a valid
// PHP session for the target employee — no password required.
// Only accessible to users whose user_role contains 'admin'.
// =============================================================

include_once '../../imports/need/session_setup.php';
include_once '../../imports/need/DB.php';
include_once '../../imports/Company_Info/Company_Info_Variable_List.php';
include_once '../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA.php';
include_once '../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_SINGLE_DATA.php';
include_once '../../Controllers/Main/Cook_Managment/Cook_Createing.php';
include_once '../../Controllers/Main/main_user_login_device/main_user_login_device_ADD_UPDATE.php';
include_once '../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';
include_once '../../Controllers/Main/User_Accout_Check_Device.php';

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

// ---- 2. Verify caller is an authenticated admin ----
$caller_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
if ($caller_user_id === 0) {
    $state['error'] = 'NOT_AUTHENTICATED';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

$caller_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));

if (strpos($caller_role, 'admin') === false) {
    $state['error'] = 'ACCESS_DENIED';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 3. Get target employee user_id ----
$target_user_id = isset($_POST['employee_user_id']) ? (int)$_POST['employee_user_id'] : 0;
if ($target_user_id === 0) {
    $state['error'] = 'INVALID_EMPLOYEE_ID';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// Prevent admin from impersonating themselves
if ($target_user_id === $caller_user_id) {
    $state['error'] = 'CANNOT_IMPERSONATE_SELF';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 4. Load target employee's login record ----
$emp_data = new main_user_login_SINGLE_DATA($target_user_id);
if (!$emp_data->get_state()) {
    $state['error'] = 'EMPLOYEE_NOT_FOUND';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 5. Save the admin's current session so they can return ----
$_SESSION['admin_original_session'] = [
    'user_id'                              => $_SESSION['user_id']                              ?? null,
    'user_name'                            => $_SESSION['user_name']                            ?? null,
    'session_token'                        => $_SESSION['session_token']                        ?? null,
    'main_user_account_access_level_list_id' => $_SESSION['main_user_account_access_level_list_id'] ?? null,
    'url_home'                             => $_SESSION['url_home']                             ?? null,
    'user_role'                            => $_SESSION['user_role']                            ?? null,
    'ac_type'                              => $_SESSION['ac_type']                              ?? null,
    'user_main_cook_id'                    => $_SESSION['user_main_cook_id']                    ?? null,
    'otp_pending'                          => $_SESSION['otp_pending']                          ?? null,
];
$_SESSION['admin_impersonating']      = true;
$_SESSION['admin_impersonating_name'] = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

// ---- 6. Build the employee session (same pattern as User_Login_Check.php) ----
$emp_access_level_id = $emp_data->get_main_user_account_access_level_list_id();
$url_home   = '';
$user_role  = '';

if (!empty($emp_access_level_id)) {
    $acl = new main_user_account_access_level_list_SINGLE_DATA($emp_access_level_id);
    if ($acl->get_state()) {
        $url_home  = trim($acl->get_url_home());
        $user_role = trim($acl->get_type_of_access());
    }
}

// Session token via device check
$device_check = new User_Accout_Check_Device();
$device_check->set_main_user_login_id($target_user_id);
$device_check->check_main_user_login_device();
$session_token = $device_check->get_session_token();

// Cookie
$cook_obj = new Cook_Createing($target_user_id);
$cook_id  = $cook_obj->get_cook_id();

// Overwrite session with employee values
$_SESSION['user_id']                              = $target_user_id;
$_SESSION['user_name']                            = $emp_data->get_user_name();
$_SESSION['session_token']                        = $session_token;
$_SESSION['main_user_account_access_level_list_id'] = $emp_access_level_id;
$_SESSION['url_home']                             = $url_home;
$_SESSION['user_role']                            = $user_role;
$_SESSION['ac_type']                              = $user_role;
$_SESSION['user_main_cook_id']                    = $cook_id;
$_SESSION['otp_pending']                          = false;

// Update last_login in DB
$login_db = new DataBase();
$login_db->get_result("UPDATE `main_user_login` SET `last_login` = NOW() WHERE `id` = " . $target_user_id);

// ---- 7. Resolve the employee dashboard URL ----
if (!empty($url_home)) {
    if (stripos($url_home, 'http://') === 0 || stripos($url_home, 'https://') === 0) {
        $redirect_url = $url_home;
    } else {
        $redirect_url = rtrim($home_page, '/') . '/' . ltrim($url_home, '/');
    }
} else {
    // Default employee dashboard
    $redirect_url = rtrim($home_page, '/') . '/UxUi/Employee_user_dashboard.php';
}

$state['error']        = '0';
$state['redirect_url'] = $redirect_url;
$state['emp_name']     = $emp_data->get_name_show() ?: ($emp_data->get_first_name() . ' ' . $emp_data->get_last_name());
$json[] = $state;
echo json_encode($json);
