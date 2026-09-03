<?php
// =============================================================
// Admin "Restore Session" Endpoint
// =============================================================
// Called when the admin clicks "Return to Admin Panel" from the
// employee dashboard. Restores the original admin session that
// was saved before impersonation started.
// =============================================================

include_once '../../imports/need/session_setup.php';

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

// ---- 2. Verify this is an active impersonation session ----
if (empty($_SESSION['admin_impersonating']) || $_SESSION['admin_impersonating'] !== true) {
    $state['error'] = 'NOT_IMPERSONATING';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

if (empty($_SESSION['admin_original_session'])) {
    $state['error'] = 'NO_ORIGINAL_SESSION';
    $json[] = $state;
    echo json_encode($json);
    exit;
}

// ---- 3. Restore the original admin session ----
$orig = $_SESSION['admin_original_session'];

$_SESSION['user_id']                              = $orig['user_id'];
$_SESSION['user_name']                            = $orig['user_name'];
$_SESSION['session_token']                        = $orig['session_token'];
$_SESSION['main_user_account_access_level_list_id'] = $orig['main_user_account_access_level_list_id'];
$_SESSION['url_home']                             = $orig['url_home'];
$_SESSION['user_role']                            = $orig['user_role'];
$_SESSION['ac_type']                              = $orig['ac_type'];
$_SESSION['user_main_cook_id']                    = $orig['user_main_cook_id'];
$_SESSION['otp_pending']                          = $orig['otp_pending'];

// ---- 4. Clean up impersonation flags ----
unset(
    $_SESSION['admin_impersonating'],
    $_SESSION['admin_impersonating_name'],
    $_SESSION['admin_original_session']
);

// ---- 5. Determine admin dashboard URL ----
$admin_url = rtrim($home_page, '/') . '/UxUi/Admin_user_dashboard.php';

if (!empty($orig['url_home'])) {
    $url_home = trim($orig['url_home']);
    if (stripos($url_home, 'http://') === 0 || stripos($url_home, 'https://') === 0) {
        $admin_url = $url_home;
    } else {
        $admin_url = rtrim($home_page, '/') . '/' . ltrim($url_home, '/');
    }
}

$state['error']       = '0';
$state['redirect_url'] = $admin_url;
$json[] = $state;
echo json_encode($json);
