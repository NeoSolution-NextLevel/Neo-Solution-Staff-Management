<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notification_inbox_LIST.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

$check_login_obj = new Cook_Management($user_main_cook_id ?? '');
$logged_user_id = ($check_login_obj->check_login_availability()) ? (int)$check_login_obj->get_user_id() : (isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0);
if ($logged_user_id <= 0) {
    $cookId = trim((string) ($_COOKIE['main_user_account_cook'] ?? $_COOKIE['Web_View_Cookie_Yes_No'] ?? ''));
    if ($cookId !== '' && $cookId !== 'NO_DATA') {
        $check_login_obj = new Cook_Management($cookId);
        if ($check_login_obj->check_login_availability()) {
            $logged_user_id = (int)$check_login_obj->get_user_id();
        }
    }
}

$user_id = isset($_POST['main_user_login_id']) && (int)$_POST['main_user_login_id'] > 0
    ? (int)$_POST['main_user_login_id']
    : (isset($_GET['main_user_login_id']) && (int)$_GET['main_user_login_id'] > 0
        ? (int)$_GET['main_user_login_id']
        : $logged_user_id);

$inbox_list_obj = new notification_inbox_LIST();

if ($user_id > 0) {
    $inbox_list_obj->set_main_user_login_id($user_id);
} elseif (isset($_POST['member_list_id']) || isset($_GET['member_list_id'])) {
    $mem_id = isset($_POST['member_list_id']) ? (int)$_POST['member_list_id'] : (int)$_GET['member_list_id'];
    $inbox_list_obj->set_member_list_id($mem_id);
}

if (isset($_POST['unread_only']) && ($_POST['unread_only'] == '1' || $_POST['unread_only'] == 'true')) {
    $inbox_list_obj->set_unread_only(true);
} elseif (isset($_GET['unread_only']) && ($_GET['unread_only'] == '1' || $_GET['unread_only'] == 'true')) {
    $inbox_list_obj->set_unread_only(true);
}

if (isset($_POST['search_txt']) && !empty($_POST['search_txt'])) {
    $inbox_list_obj->set_search_text($_POST['search_txt']);
} elseif (isset($_GET['search_txt']) && !empty($_GET['search_txt'])) {
    $inbox_list_obj->set_search_text($_GET['search_txt']);
}

if (isset($_POST['st_count']) && isset($_POST['per_page'])) {
    $inbox_list_obj->set_data_limits((int)$_POST['st_count'], (int)$_POST['per_page']);
} elseif (isset($_GET['st_count']) && isset($_GET['per_page'])) {
    $inbox_list_obj->set_data_limits((int)$_GET['st_count'], (int)$_GET['per_page']);
} elseif (isset($_POST['limit'])) {
    $inbox_list_obj->set_data_limit((int)$_POST['limit']);
} elseif (isset($_GET['limit'])) {
    $inbox_list_obj->set_data_limit((int)$_GET['limit']);
}

if (isset($_POST['count']) || isset($_GET['count'])) {
    $total = $inbox_list_obj->get_total_count();
    $unread = $inbox_list_obj->get_unread_count();
    $json[] = [
        "total_count"  => $total,
        "unread_count" => $unread,
        "count"        => $total
    ];
} elseif (isset($_POST['unread_count']) || isset($_GET['unread_count'])) {
    $unread = $inbox_list_obj->get_unread_count();
    $json[] = [
        "unread_count" => $unread,
        "count"        => $unread
    ];
} else {
    $json = $inbox_list_obj->get_notifications_array();
}

echo json_encode($json);
