<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notification_inbox_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

$check_login_obj = new Cook_Management($user_main_cook_id ?? '');
$logged_user_id = ($check_login_obj->check_login_availability()) ? (int)$check_login_obj->get_user_id() : (isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0);

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_POST['inbox_id']) ? (int)$_POST['inbox_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : (isset($_GET['inbox_id']) ? (int)$_GET['inbox_id'] : 0)));
$notifications_id = isset($_POST['notifications_id']) ? (int)$_POST['notifications_id'] : (isset($_POST['notification_id']) ? (int)$_POST['notification_id'] : (isset($_GET['notifications_id']) ? (int)$_GET['notifications_id'] : (isset($_GET['notification_id']) ? (int)$_GET['notification_id'] : 0)));
$user_id = isset($_POST['main_user_login_id']) ? (int)$_POST['main_user_login_id'] : (isset($_GET['main_user_login_id']) ? (int)$_GET['main_user_login_id'] : $logged_user_id);

$inbox_obj = new notification_inbox_ADD_UPDATE();

// Mark all as read for user
if (isset($_POST['mark_all_read']) || isset($_GET['mark_all_read'])) {
    if ($user_id > 0) {
        if ($inbox_obj->mark_all_read($user_id)) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['msg'] = "All notifications marked as read.";
        } else {
            $state['error'] = "Failed to mark all as read.";
        }
    } else {
        $state['error'] = "User login ID is required.";
    }
}
// Remove or delete single notification inbox item
elseif (isset($_POST['remove']) || isset($_POST['del']) || isset($_GET['remove']) || isset($_GET['del'])) {
    if ($id > 0) {
        if ($inbox_obj->remove_by_id($id)) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $id;
            $state['msg'] = "Notification removed from inbox.";
        } else {
            $state['error'] = "Failed to remove notification.";
        }
    } elseif ($notifications_id > 0 && $user_id > 0) {
        $db = new DataBase();
        $db->get_result("UPDATE notification_inbox SET ast='0' WHERE notifications_id='" . $notifications_id . "' AND main_user_login_id='" . $user_id . "'");
        if ($db->get_error_state_boolean()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['msg'] = "Notification removed from inbox.";
        } else {
            $state['error'] = "Failed to remove notification.";
        }
    } else {
        $state['error'] = "Inbox ID or Notification ID is required.";
    }
}
// Mark single item as read (default action)
else {
    if ($id > 0) {
        if ($inbox_obj->mark_read_by_id($id)) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $id;
            $state['msg'] = "Notification marked as read.";
        } else {
            $state['error'] = "Failed to update notification status.";
        }
    } elseif ($notifications_id > 0 && $user_id > 0) {
        if ($inbox_obj->mark_read($notifications_id, $user_id)) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['notifications_id'] = $notifications_id;
            $state['msg'] = "Notification marked as read.";
        } else {
            $state['error'] = "Failed to update notification status.";
        }
    } else {
        $state['error'] = "Inbox ID or Notification ID is required.";
    }
}

$json[] = $state;
echo json_encode($json);
