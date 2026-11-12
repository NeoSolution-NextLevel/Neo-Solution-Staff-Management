<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notifications_LIST.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

$notif_list_obj = new notifications_LIST();

if (isset($_POST['search_txt']) && !empty($_POST['search_txt'])) {
    $notif_list_obj->set_search_text($_POST['search_txt']);
} elseif (isset($_GET['search_txt']) && !empty($_GET['search_txt'])) {
    $notif_list_obj->set_search_text($_GET['search_txt']);
}

if (isset($_POST['audience_filter']) && !empty($_POST['audience_filter'])) {
    $notif_list_obj->set_audience_filter($_POST['audience_filter']);
} elseif (isset($_GET['audience_filter']) && !empty($_GET['audience_filter'])) {
    $notif_list_obj->set_audience_filter($_GET['audience_filter']);
} elseif (isset($_POST['type']) && !empty($_POST['type'])) {
    $notif_list_obj->set_audience_filter($_POST['type']);
} elseif (isset($_GET['type']) && !empty($_GET['type'])) {
    $notif_list_obj->set_audience_filter($_GET['type']);
}

if (isset($_POST['main_user_login_id']) && (int)$_POST['main_user_login_id'] > 0) {
    $notif_list_obj->filter_by_main_user_login_id((int)$_POST['main_user_login_id']);
} elseif (isset($_GET['main_user_login_id']) && (int)$_GET['main_user_login_id'] > 0) {
    $notif_list_obj->filter_by_main_user_login_id((int)$_GET['main_user_login_id']);
}

if (isset($_POST['cash_owner_id']) && (int)$_POST['cash_owner_id'] > 0) {
    $notif_list_obj->filter_by_cash_owner_id((int)$_POST['cash_owner_id']);
} elseif (isset($_GET['cash_owner_id']) && (int)$_GET['cash_owner_id'] > 0) {
    $notif_list_obj->filter_by_cash_owner_id((int)$_GET['cash_owner_id']);
}

if (isset($_POST['ast'])) {
    $notif_list_obj->set_ast($_POST['ast']);
} elseif (isset($_GET['ast'])) {
    $notif_list_obj->set_ast($_GET['ast']);
}

if (isset($_POST['sort_key']) && !empty($_POST['sort_key'])) {
    $notif_list_obj->set_sort_key($_POST['sort_key']);
} elseif (isset($_GET['sort_key']) && !empty($_GET['sort_key'])) {
    $notif_list_obj->set_sort_key($_GET['sort_key']);
}

if (isset($_POST['st_count']) && isset($_POST['per_page'])) {
    $notif_list_obj->set_data_limits((int)$_POST['st_count'], (int)$_POST['per_page']);
} elseif (isset($_GET['st_count']) && isset($_GET['per_page'])) {
    $notif_list_obj->set_data_limits((int)$_GET['st_count'], (int)$_GET['per_page']);
} elseif (isset($_POST['limit'])) {
    $notif_list_obj->set_data_limit((int)$_POST['limit']);
} elseif (isset($_GET['limit'])) {
    $notif_list_obj->set_data_limit((int)$_GET['limit']);
}

if (isset($_POST['count']) || isset($_GET['count'])) {
    $total = $notif_list_obj->get_total_count();
    $json[] = [
        "total_count" => $total,
        "count" => $total
    ];
} else {
    $json = $notif_list_obj->get_notifications_array();
}

echo json_encode($json);
