<?php
include_once __DIR__ . '/main_user_login_device_LIST.php';

class Allowed_Devices_Fetch
{
    public static function fetch($userId)
    {
        $list = new main_user_login_device_LIST();
        $list->filter_by_main_user_login_id($userId);
        $res = $list->get_result();
        $devices = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $devices[] = $row;
            }
        }
        return $devices;
    }
}
?>
