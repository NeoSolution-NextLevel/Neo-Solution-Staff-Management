<?php
ob_start();

require_once "../../../imports/need/session_setup.php";
require_once "../../../imports/Company_Info/Company_Info_Variable_List.php";
require_once "../../../imports/need/DB.php";
require_once "Main_User_Microsoft_Login_Config.php";

include_once "../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_LIST.php";
include_once "../../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_LIST.php";
include_once "../../../Controllers/Main/Cook_Managment/Cook_Createing.php";


include_once "../../../imports/security/encrypt_decrypt.php";
include_once "../../../imports/security/key_list.php";

if (isset($_GET['error'])) {

    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention);
}

if (!isset($_GET['code'])) {
    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention);
    exit;
}

$is_google_authentication_enable = "0";


unset(
    $_SESSION['user'],
    $_SESSION['user_id'],
    $_SESSION['temp_user'],
    $_SESSION['otp_pending']
);

$post = [
    'client_id'     => $client_id,
    'client_secret' => $client_secret,
    'code'          => $_GET['code'],
    'redirect_uri'  => $redirect_uri,
    'grant_type'    => 'authorization_code',
    'scope'         => $scope
];

$ch = curl_init($token_url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_POSTFIELDS     => http_build_query($post)
]);
$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);

if (!isset($token['access_token'])) {
    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention . "?error=OAuth-Token-Failed");
    exit;
}

/* Get user info */
$ch = curl_init("https://graph.microsoft.com/v1.0/me");
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $token['access_token']
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$userInfo = curl_exec($ch);
curl_close($ch);

$user_raw = json_decode($userInfo, true);

if (!$user_raw || (!isset($user_raw['id']) && !isset($user_raw['mail']) && !isset($user_raw['userPrincipalName']))) {
    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention . "?error=User-Info-Failed");
    exit;
}

$ms_id  = $user_raw['id'] ?? ('MS_' . md5($user_raw['mail'] ?? $user_raw['userPrincipalName'] ?? time()));
$name   = $user_raw['displayName'] ?? (!empty($user_raw['mail']) ? explode('@', $user_raw['mail'])[0] : 'Microsoft User');
$email  = $user_raw['mail'] ?? ($user_raw['userPrincipalName'] ?? '');

// Check DB: find existing user by microsoft_id OR email
$db = new DataBase();
$conn = $db->get_data_base_connction();
$escaped_ms_id = $conn->real_escape_string($ms_id);
$escaped_email = $conn->real_escape_string($email);
$escaped_name = $conn->real_escape_string($name);
$now = date('Y-m-d H:i:s');

$check_query = "SELECT * FROM main_user_login WHERE ast='1' AND (microsoft_id='{$escaped_ms_id}' OR user_name='{$escaped_email}') LIMIT 1";
$check_res = $conn->query($check_query);

if ($check_res && $check_res->num_rows > 0) {
    $user = $check_res->fetch_assoc();
    $uid = $user['id'];
    
    // Auto-link Microsoft ID and update profile
    $update_query = "UPDATE main_user_login SET microsoft_id='{$escaped_ms_id}', name_show='{$escaped_name}', last_login='{$now}' WHERE id='{$uid}'";
    $conn->query($update_query);
} else {
    // Determine default access level
    $access_level_id = 2; // Default Employee
    $access_type = "Employee";
    $acc_check = $conn->query("SELECT id, type_of_access FROM main_user_account_access_level_list WHERE ast='1' AND (type_of_access='Employee' OR type_of_access='employee') LIMIT 1");
    if ($acc_check && $acc_check->num_rows > 0) {
        $acc_row = $acc_check->fetch_assoc();
        $access_level_id = $acc_row['id'];
        $access_type = $acc_row['type_of_access'];
    } else {
        $first_acc = $conn->query("SELECT id, type_of_access FROM main_user_account_access_level_list WHERE ast='1' LIMIT 1");
        if ($first_acc && $first_acc->num_rows > 0) {
            $acc_row = $first_acc->fetch_assoc();
            $access_level_id = $acc_row['id'];
            $access_type = $acc_row['type_of_access'];
        }
    }

    $company_id = 1;
    $insert_sql = "INSERT INTO main_user_login (
        ast, sdt, user_name, password, account_active_state, last_login, name_show,
        email_verify, moible_verfiy, very_first_login, cook_key, ref_key,
        temp_lock, full_block, ac_type, company_id, control_account_state,
        main_user_account_access_level_list_id, image_url, google_id,
        is_google_authentication_enable, microsoft_id, first_name, last_name,
        dis, phone_number, is_two_factor_auth_enable, wrong_login_count
    ) VALUES (
        '1', '{$now}', '{$escaped_email}', '', '1', '{$now}', '{$escaped_name}',
        '1', '0', '0', '', '',
        '0', '0', '{$access_type}', '{$company_id}', '0',
        '{$access_level_id}', '', 'Microsoft Login User',
        '0', '{$escaped_ms_id}', '{$escaped_name}', '',
        '', '', '0', '0'
    )";
    $conn->query($insert_sql);
    $new_id = $conn->insert_id;

    $fetch_new = $conn->query("SELECT * FROM main_user_login WHERE id='{$new_id}' LIMIT 1");
    if ($fetch_new && $fetch_new->num_rows > 0) {
        $user = $fetch_new->fetch_assoc();
    } else {
        $fetch_fallback = $conn->query("SELECT * FROM main_user_login WHERE user_name='{$escaped_email}' ORDER BY id DESC LIMIT 1");
        if ($fetch_fallback && $fetch_fallback->num_rows > 0) {
            $user = $fetch_fallback->fetch_assoc();
        } else {
            $user = [
                'id' => $new_id ?: 1,
                'user_name' => $email,
                'name_show' => $name,
                'first_name' => $name,
                'last_name' => '',
                'ac_type' => $access_type,
                'main_user_account_access_level_list_id' => $access_level_id,
                'is_google_authentication_enable' => '0'
            ];
        }
    }
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['user_name'];
$_SESSION['name_show'] = $user['name_show'] ?? $name;
$_SESSION['first_name'] = $user['first_name'] ?? $name;
$_SESSION['last_name'] = $user['last_name'] ?? '';
$_SESSION['user_role'] = $user['ac_type'] ?? 'Employee';
$_SESSION['ac_type'] = $user['ac_type'] ?? 'Employee';
$_SESSION['main_user_account_access_level_list_id'] = $user['main_user_account_access_level_list_id'] ?? '2';

$user_id = $_SESSION['user_id'];
$is_google_authentication_enable = $user['is_google_authentication_enable'] ?? "0";

$Cook_Createing = new Cook_Createing($user_id);
$_SESSION['user_main_cook_id'] = $Cook_Createing->get_cook_id();

if ($is_google_authentication_enable == "1") {
    $_SESSION['otp_pending'] = true;
    header("Location: " . $home_page . $User_login_url . "OTP-Two-step-Verification" . $online_offline_extention);
    exit;
} else {
    unset($_SESSION['otp_pending']);
    header("Location: " . $home_page . $User_login_url . "Successful-Page" . $online_offline_extention . "?message=User-Login-Successful");
    exit;
}
