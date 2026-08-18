<?php
include_once '../../imports/need/session_setup.php';
include_once '../../imports/need/DB.php';
include_once '../../Controllers/Main/Cook_Managment/Cook_Managing.php';

$json = [];
$state = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($user_main_cook_id !== null) {

        $Cook_Management_obj = new Cook_Management($user_main_cook_id);

        if ($Cook_Management_obj->main_user_login_logout($user_id)) {

            unset(
                $_SESSION['user'],
                $_SESSION['user_id'],
                $_SESSION['temp_user'],
                $_SESSION['otp_pending'],
                $_SESSION['otp_encrypt']
            );

            session_destroy();

            $state['error'] = "0";
        } else {
            $state['error'] = "DB_LOGOUT_FAILED";
        }
    } else {
        $state['error'] = "INVALID_SESSION";
    }
} else {
    $state['error'] = "INVALID_REQUEST";
}

$json[] = $state;

header('Content-Type: application/json');
echo json_encode($json);
exit;
