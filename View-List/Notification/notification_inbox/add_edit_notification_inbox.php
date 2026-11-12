<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notification_inbox_ADD_UPDATE.php';
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

    $id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_POST['inbox_id']) ? (int)$_POST['inbox_id'] : 0);
    $token = isset($_POST['token']) ? trim($_POST['token']) : (isset($_POST['fcm_token']) ? trim($_POST['fcm_token']) : '');
    $platform = isset($_POST['platform']) ? trim($_POST['platform']) : 'android';
    $notifications_id = isset($_POST['notifications_id']) ? (int)$_POST['notifications_id'] : (isset($_POST['notification_id']) ? (int)$_POST['notification_id'] : 0);
    $main_user_login_id = isset($_POST['main_user_login_id']) && (int)$_POST['main_user_login_id'] > 0 
        ? (int)$_POST['main_user_login_id'] 
        : $logged_user_id;

    // Check for deletion
    if ((isset($_POST['del']) && $_POST['del'] == '1') || (isset($_POST['remove']) && $_POST['remove'] == '1')) {
        $inbox_del = new notification_inbox_ADD_UPDATE();
        if ($id > 0) {
            $inbox_del->set_id($id);
            $success = $inbox_del->process_remove();
        } elseif ($notifications_id > 0 && $main_user_login_id > 0) {
            $db = new DataBase();
            $db->get_result("UPDATE notification_inbox SET ast='0' WHERE notifications_id='" . $notifications_id . "' AND main_user_login_id='" . $main_user_login_id . "'");
            $success = $db->get_error_state_boolean();
        } else {
            $state['error'] = "Inbox ID or Notification ID with User ID required for removal.";
            $json[] = $state;
            echo json_encode($json);
            exit;
        }

        if ($success) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['msg'] = "Notification inbox record removed successfully.";
        } else {
            $state['error'] = $inbox_del->get_error() ?: "Failed to remove notification inbox record.";
        }
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    // Detect user role (member, manager, cash_owner)
    $role = isset($_POST['user_role']) ? trim($_POST['user_role']) : (isset($_SESSION['role']) ? trim($_SESSION['role']) : '');
    if (empty($role) && $main_user_login_id > 0) {
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
    if (empty($role)) {
        $role = 'member';
    }

    // Save / update FCM token
    if (!empty($token)) {
        $fcm_up = new fcm_tokens_ADD_UPDATE();
        $fcm_up->set_data($main_user_login_id, $token, $platform, $role);
        if ($fcm_up->process_new_record()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['ok'] = true;
            $state['token_saved'] = true;
            $state['main_user_login_id'] = $main_user_login_id;
            $state['user_role'] = $role;
            $state['msg'] = "FCM token registered successfully.";
        } else {
            $state['error'] = $fcm_up->get_error() ?: "Failed to save FCM token.";
            $state['status'] = "error";
            $state['ok'] = false;
            $state['token_saved'] = false;
        }
    }

    //Mark as read if requested
    if (isset($_POST['mark_read']) && $_POST['mark_read'] == '1') {
        $inbox_obj = new notification_inbox_ADD_UPDATE();
        if ($id > 0) {
            $inbox_obj->mark_read_by_id($id);
        } elseif ($notifications_id > 0 && $main_user_login_id > 0) {
            $inbox_obj->mark_read($notifications_id, $main_user_login_id);
        }
        $state['error'] = "0";
        $state['status'] = "success";
        $state['msg'] = "Notification marked as read.";
    }
    //Save notification inbox record if notifications_id is passed
    elseif ($notifications_id > 0 && $main_user_login_id > 0) {
        $is_read = isset($_POST['is_read']) ? (int)$_POST['is_read'] : 0;
        $inbox_obj = new notification_inbox_ADD_UPDATE();
        $inbox_obj->set_data($notifications_id, $main_user_login_id, $is_read);

        if ($inbox_obj->process_new_record()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['inbox_saved'] = true;
            $state['id'] = $inbox_obj->get_id();
            $state['msg'] = "Notification inbox record created successfully.";
        } else {
            $err = $inbox_obj->get_error();
            $state['error'] = !empty($err) ? $err : "Failed to create inbox record.";
        }
    }

    if (empty($token) && ($notifications_id <= 0 || $main_user_login_id <= 0) && !isset($state['error'])) {
        $state['error'] = "Notification ID and User Login ID (or Token) are required.";
    }
} else {
    $state['error'] = "Invalid request method.";
}

$json[] = $state;
echo json_encode($json);
