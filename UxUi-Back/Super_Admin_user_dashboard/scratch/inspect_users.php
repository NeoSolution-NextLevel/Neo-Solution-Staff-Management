<?php
require_once __DIR__ . '/../../../imports/need/DB.php';
require_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
$db = new DataBase();
$conn = $db->get_data_base_connction();
$sec = new Advance_Security();

$res = $conn->query("SELECT id, user_name, password, name_show, ac_type, account_active_state, email_verify, ast, full_block, main_user_account_access_level_list_id FROM `main_user_login` WHERE `ac_type` = 'Admin' OR `main_user_account_access_level_list_id` = 1 OR `id` = 1");

$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = $r;
}
file_put_contents(__DIR__ . '/admin_list.json', json_encode($out, JSON_PRETTY_PRINT));
echo "Found " . count($out) . " admin users.\n";
