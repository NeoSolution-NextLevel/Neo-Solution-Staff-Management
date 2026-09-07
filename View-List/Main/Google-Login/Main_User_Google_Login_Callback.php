<?php
ob_start();
require_once "../../../imports/need/session_setup.php";
require_once "../../../imports/Company_Info/Company_Info_Variable_List.php";
require_once "Main_User_Google_Login_Config.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_LIST.php";
include_once "../../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_LIST.php";
include_once "../../../Controllers/Main/Cook_Managment/Cook_Createing.php";
include_once "../../../imports/need/DB.php";

include_once "../../../imports/security/encrypt_decrypt.php";
include_once "../../../imports/security/key_list.php";



if (!isset($_GET['code'])) {
    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention);
    exit;
}

$is_google_authentication_enable = "0";


unset(
    $_SESSION['user_id'],
    $_SESSION['otp_pending']
);


// Exchange code for access token
$token_url = "https://oauth2.googleapis.com/token";
$post = [
    'code' => $_GET['code'],
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'grant_type' => 'authorization_code'
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);
if (!isset($token['access_token'])) {
    die("Google login failed!");
}

// Get user info
$access_token = $token['access_token'];
$ch = curl_init("https://www.googleapis.com/oauth2/v2/userinfo");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$userInfo = curl_exec($ch);
curl_close($ch);

$user = json_decode($userInfo, true);
if (!$user || !isset($user['id'])) {
    die("Failed to fetch Google user info");
}

// User data
$google_id = $user['id'];
$name      = $user['name'];
$email     = $user['email'];
$picture   = $user['picture'];

// Check DB
$main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();
$main_user_login_LIST_obj = new main_user_login_LIST();
$main_user_login_LIST_obj->filter_by_google_id($google_id);
$get_result = $main_user_login_LIST_obj->get_result();

if ($get_result && $get_result->num_rows == 0) {
    $main_user_account_access_type = "user";
    $main_user_login_ADD_UPDATE_obj->set_main_user_login_google_microsoft_auth_login_data($google_id, $name, $email, $picture, $main_user_account_access_type, true);
    $main_user_login_ADD_UPDATE_obj->process_new_record();
}

// Get user again
$main_user_login_LIST_obj = new main_user_login_LIST();
$main_user_login_LIST_obj->filter_by_google_id($google_id);
$get_result = $main_user_login_LIST_obj->get_result();

if (!$get_result || $get_result->num_rows === 0) {
    header("Location: " . $home_page . $User_login_url . "Failed-Page" . $online_offline_extention . "?error=User-Not-Found");

    exit;
}

$temp_user = $get_result->fetch_assoc();


$_SESSION['user_id'] = $temp_user['id'];

$user_id = $_SESSION['user_id'];

$is_google_authentication_enable = $temp_user['is_google_authentication_enable'] ?? "0";


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
