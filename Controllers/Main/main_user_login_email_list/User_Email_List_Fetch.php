<?php
include_once __DIR__ . '/main_user_login_email_list_LIST.php';

class User_Email_List_Fetch
{
    public static function fetch($userId = null)
    {
        $list = new main_user_login_email_list_LIST();
        if ($userId !== null) {
            $list->filter_by_main_user_login_id($userId);
        }
        $res = $list->get_result();
        $emails = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $emails[] = $row;
            }
        }
        return $emails;
    }
}
?>
