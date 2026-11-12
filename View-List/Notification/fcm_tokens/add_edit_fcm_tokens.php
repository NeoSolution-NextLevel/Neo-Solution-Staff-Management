<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/fcm_tokens_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $check_login_obj = new Cook_Management($user_main_cook_id ?? '');
    $logged_user_id = ($check_login_obj->check_login_availability()) ? (int)$check_login_obj->get_user_id() : (isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0);
    if ($logged_user_id <= 0) {
        $cookId = trim((string) ($_COOKIE['main_user_account_cook'] ?? $_COOKIE['Web_View_Cookie_Yes_No'] ?? ''));
        if ($cookId !== '' && $cookId !== 'NO_DATA') {
            $check_login_obj = new Cook_Management($cookId);
            if ($check_login_obj->check_login_availability()) {
                $logged_user_id = (int)$check_login_obj->get_user_id();
                $_SESSION['user_id'] = $logged_user_id;
                $_SESSION['user_main_cook_id'] = $cookId;
            }
        }
    }

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $token = isset($_POST['token']) ? trim($_POST['token']) : (isset($_POST['fcm_token']) ? trim($_POST['fcm_token']) : '');
    $platform = isset($_POST['platform']) ? trim($_POST['platform']) : 'android';
    $main_user_login_id = isset($_POST['main_user_login_id']) && (int)$_POST['main_user_login_id'] > 0 
        ? (int)$_POST['main_user_login_id'] 
        : $logged_user_id;

    // Check for deletion
    if ((isset($_POST['del']) && $_POST['del'] == '1') || (isset($_POST['remove']) && $_POST['remove'] == '1')) {
        $fcm_del = new fcm_tokens_ADD_UPDATE();
        if ($id > 0) {
            $fcm_del->set_id($id);
            $success = $fcm_del->process_remove();
        } elseif (!empty($token)) {
            $success = $fcm_del->deactivate_token($token);
        } else {
            $state['error'] = "Token ID or Token string required for removal.";
            $json[] = $state;
            echo json_encode($json);
            exit;
        }

        if ($success) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['msg'] = "FCM token removed successfully.";
        } else {
            $state['error'] = $fcm_del->get_error() ?: "Failed to remove FCM token.";
        }
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    if (empty($token)) {
        $state['error'] = "FCM token string is required.";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    if ($main_user_login_id <= 0) {
        $state['error'] = "Main user login ID is required.";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    $role = isset($_POST['user_role']) ? trim($_POST['user_role']) : (isset($_SESSION['role']) ? trim($_SESSION['role']) : '');
    if (empty($role)) {
        $db = new DataBase();
        $r_res = $db->get_result("select ac_type, main_user_account_access_level_list_id from main_user_login where id='" . $main_user_login_id . "' limit 1");
        if ($r_res && $r_row = $r_res->fetch_assoc()) {
            $access = (int)$r_row['main_user_account_access_level_list_id'];
            $ac = strtolower(trim((string)$r_row['ac_type']));
            if ($ac === 'cash_owner' || $access === 2) {
                $role = 'cash_owner';
            } elseif ($ac === 'manager' || $access === 3) {
                $role = 'manager';
            } else {
                $role = 'member';
            }
        } else {
            $role = 'member';
        }
    }

    $fcm_obj = new fcm_tokens_ADD_UPDATE();
    if ($id > 0) {
        $fcm_obj->set_id($id);
        $fcm_obj->set_data($main_user_login_id, $token, $platform, $role);
        $success = $fcm_obj->process_update();
    } else {
        $fcm_obj->set_data($main_user_login_id, $token, $platform, $role);
        $success = $fcm_obj->process_new_record();
        $id = $fcm_obj->get_id();
    }

    if ($success) {
        $state['error'] = "0";
        $state['status'] = "success";
        $state['id'] = $id;
        $state['token'] = $token;
        $state['platform'] = $platform;
        $state['user_role'] = $role;
        $state['main_user_login_id'] = $main_user_login_id;
        $state['msg'] = "FCM token saved successfully.";
    } else {
        $state['error'] = $fcm_obj->get_error() ?: "Failed to save FCM token.";
    }
} else {
    $state['error'] = "Invalid request method.";
}

$json[] = $state;
echo json_encode($json);

