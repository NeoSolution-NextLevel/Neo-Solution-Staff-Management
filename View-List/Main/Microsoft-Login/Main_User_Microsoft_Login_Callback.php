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
    CURLOPT_POSTFIELDS     => http_build_query($post)
]);
$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);

if (!isset($token['access_token'])) {
    die("Microsoft login failed");
}

/* Get user info */
$ch = curl_init("https://graph.microsoft.com/v1.0/me");
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $token['access_token']
    ],
    CURLOPT_RETURNTRANSFER => true
]);

$userInfo = curl_exec($ch);
curl_close($ch);

$user = json_decode($userInfo, true);

if (!isset($user['id'])) {
    die("Failed to get Microsoft user");
}


$ms_id  = $user['id'];
$name   = $user['displayName'];
$email  = $user['mail'] ?? $user['userPrincipalName'];



$main_user_login_LIST_obj = new main_user_login_LIST();
$main_user_login_LIST_obj->filter_by_microsoft_id($ms_id);
$res = $main_user_login_LIST_obj->get_result();


if (!$res || $res->num_rows === 0) {

    $main_user_login_ADD_UPDATE_obj  = new main_user_login_ADD_UPDATE();

    $access    = "user";
    $image_url = "";

    $main_user_login_ADD_UPDATE_obj->set_main_user_login_google_microsoft_auth_login_data(
        $ms_id,
        $name,
        $email,
        $image_url,
        $access,
        false
    );

    $main_user_login_ADD_UPDATE_obj->process_new_record();

    $res = $main_user_login_LIST_obj->get_result();
}


if (!$res || $res->num_rows === 0) {
    header("Location: {$home_page}Failed-Page{$online_offline_extention}?error=User-Not-Found");

    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention . "?error=User-Not-Found");

    exit;
}

$user = $res->fetch_assoc();


$_SESSION['user_id'] = $user['id'];

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
