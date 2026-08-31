<?php
// session_start();
include_once "../../../imports/need/session_setup.php";
include_once "../../../imports/need/DB.php";
include_once "../../../imports/security/GoogleAuthenticator.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_SINGLE_DATA_By_Email.php";
include_once "../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php";
include_once "../../../imports/Company_Info/Company_Info_Variable_List.php";

$json = [];
$state = [];

$ga = new PHPGangsta_GoogleAuthenticator();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // $user_id = $_SESSION['user_id'] ?? null;
    $otp_pending = $_SESSION['otp_pending'] ?? false;
    $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ""; // user_email


    if (!$user_email) {
        $user_email = $_SESSION['user_name'] ?? null;
    }

    if (!$user_email) {
        echo json_encode([['error' => 'Unauthorized']]);
        exit;
    }

    $code    = $_POST['auth_code'] ?? null;



    if (!$user_email || !$code) {
        $state['error'] = "Missing required fields";
        echo json_encode([$state]);
        exit;
    }


    $userObj = new main_user_login_SINGLE_DATA_By_Email($user_email);

    if (!$userObj->get_state()) {
        $state['error'] = "User not found";
        echo json_encode([$state]);
        exit;
    }

    // Check if Google Auth is enabled


    $secret = $userObj->get_google_authentication_secret();

    if (empty($secret)) {
        $state['error'] = "Authenticator secret missing";
        echo json_encode([$state]);
        exit;
    }

    // Verify OTP
    $isValid = $ga->verifyCode($secret, $code, 2);

    if ($isValid) {

        if ($userObj->get_is_google_authentication_enable() != 1) {

            if (isset($_POST['google_authentication_enable'])) {
                $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();
                $main_user_login_ADD_UPDATE_obj->set_id($userObj->get_id());
                $main_user_login_ADD_UPDATE_obj->is_is_google_authentication_enable();
                $main_user_login_ADD_UPDATE_obj->process_update();
            }
        }

        $_SESSION['user'] = [
            'id' => $userObj->get_id()
        ];

        unset($_SESSION['google_auth_user_id']);




        $state['error'] = "0";
        echo json_encode([$state]);
        exit;
    } else {
        $state['error'] = "Invalid Google Authentication Code";
        echo json_encode([$state]);
        exit;
    }
} else {
    $state['error'] = "Invalid request method";
    echo json_encode([$state]);
    exit;
}
