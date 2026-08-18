<?php
include_once "../../../imports/need/session_setup.php";
include_once "../../../imports/security/GoogleAuthenticator.php";
include_once "../../../imports/Company_Info/Company_Info_Variable_List.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA_By_Email.php";
include_once "../../../imports/need/DB.php";

// $user_id    = $_SESSION['user']['id'];
// $user_email = $_SESSION['user']['email'];

// $user_id    = 1;                      // <-- existing user ID in DB
// $user_email = "ramithneosolution@gmail.com";   // <-- same user's email

$is_enable = isset($_POST['is_enable']) ? $_POST['is_enable'] : ""; // is_enable
$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ""; // user_email




$main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();

$main_user_login_SINGLE_DATA_By_Email_obj = new main_user_login_SINGLE_DATA_By_Email($user_email);
$user_id = $main_user_login_SINGLE_DATA_By_Email_obj->get_id();
$main_user_login_ADD_UPDATE_obj->set_id($user_id);

if (isset($_POST['is_enable'])) {

    $ga = new PHPGangsta_GoogleAuthenticator();

    // generate secret
    $secret = $ga->createSecret();

    // create QR
    $qrCodeUrl = $ga->getQRCodeGoogleUrl(
        'ERP System (' . $user_email . ')',
        $secret
    );


    $main_user_login_ADD_UPDATE_obj->set_google_authentication_secret($secret);

    // $main_user_login_ADD_UPDATE_obj->is_is_google_authentication_enable();
}

if (isset($_POST['is_disable'])) {
    $main_user_login_ADD_UPDATE_obj->set_google_authentication_secret("No Secret Set");
    $main_user_login_ADD_UPDATE_obj->is_not_is_google_authentication_enable();
}


if ($user_id) {
    if ($main_user_login_ADD_UPDATE_obj->process_update()) {
        $state['error'] = "0";
        $state['id'] = $user_id;
    } else {
        $state['error'] = $main_user_login_ADD_UPDATE_obj->get_error();
    }
} else {
    $state['error'] = "1";
    $state['id'] = "User Id Not Found";
}

if (isset($_POST['is_enable'])) {
    echo json_encode([
        'status' => 'success',
        'qr' => $qrCodeUrl
    ]);
} else {
    echo json_encode([
        'status' => 'success'
    ]);
}
