<?php
include_once __DIR__ . '/main_user_account_access_level_list_LIST.php';

class Access_Level_List_Fetch
{
    public static function fetchAll()
    {
        $list = new main_user_account_access_level_list_LIST();
        $res = $list->get_result();
        $levels = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $levels[] = $row;
            }
        }
        return $levels;
    }
}
?>
