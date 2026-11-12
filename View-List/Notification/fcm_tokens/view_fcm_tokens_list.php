<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/fcm_tokens_LIST.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

$list_obj = new fcm_tokens_LIST();

if (isset($_POST['search_txt']) && !empty($_POST['search_txt'])) {
    $list_obj->set_search_text($_POST['search_txt']);
} elseif (isset($_GET['search_txt']) && !empty($_GET['search_txt'])) {
    $list_obj->set_search_text($_GET['search_txt']);
}

if (isset($_POST['user_id']) && (int)$_POST['user_id'] > 0) {
    $list_obj->filter_by_user_id((int)$_POST['user_id']);
} elseif (isset($_GET['user_id']) && (int)$_GET['user_id'] > 0) {
    $list_obj->filter_by_user_id((int)$_GET['user_id']);
} elseif (isset($_POST['main_user_login_id']) && (int)$_POST['main_user_login_id'] > 0) {
    $list_obj->filter_by_user_id((int)$_POST['main_user_login_id']);
} elseif (isset($_GET['main_user_login_id']) && (int)$_GET['main_user_login_id'] > 0) {
    $list_obj->filter_by_user_id((int)$_GET['main_user_login_id']);
}

if (isset($_POST['platform']) && !empty($_POST['platform'])) {
    $list_obj->filter_by_platform($_POST['platform']);
} elseif (isset($_GET['platform']) && !empty($_GET['platform'])) {
    $list_obj->filter_by_platform($_GET['platform']);
}

if (isset($_POST['user_role']) && !empty($_POST['user_role'])) {
    $list_obj->filter_by_role($_POST['user_role']);
} elseif (isset($_GET['user_role']) && !empty($_GET['user_role'])) {
    $list_obj->filter_by_role($_GET['user_role']);
}

if (isset($_POST['ast'])) {
    $list_obj->set_ast($_POST['ast']);
} elseif (isset($_GET['ast'])) {
    $list_obj->set_ast($_GET['ast']);
}

if (isset($_POST['st_count']) && isset($_POST['per_page'])) {
    $list_obj->set_data_limits((int)$_POST['st_count'], (int)$_POST['per_page']);
} elseif (isset($_GET['st_count']) && isset($_GET['per_page'])) {
    $list_obj->set_data_limits((int)$_GET['st_count'], (int)$_GET['per_page']);
} elseif (isset($_POST['limit'])) {
    $list_obj->set_data_limit((int)$_POST['limit']);
} elseif (isset($_GET['limit'])) {
    $list_obj->set_data_limit((int)$_GET['limit']);
}

if (isset($_POST['count']) || isset($_GET['count'])) {
    $total = $list_obj->get_total_count();
    $json[] = [
        "total_count" => $total,
        "count" => $total
    ];
} else {
    $json = $list_obj->get_tokens_array();
}

echo json_encode($json);

