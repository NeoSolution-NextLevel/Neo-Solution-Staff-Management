<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notification_member_SINGLE_DATA
{
    public function get_member_list_id_from_main_user_login_id($get_main_user_login_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select id
                          from member_list
                          where ast='1'
                          and main_user_login_id='" . addslashes((int) $get_main_user_login_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['id'];
        }

        return 0;
    }

    public function get_wwjm_member_list_id_from_main_user_login_id($get_main_user_login_id)
    {
        return $this->get_member_list_id_from_main_user_login_id($get_main_user_login_id);
    }

    public function get_manager_list_id_from_main_user_login_id($get_main_user_login_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select id
                          from managers_list
                          where ast='1'
                          and main_user_login_id='" . addslashes((int) $get_main_user_login_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['id'];
        }

        return 0;
    }

    public function get_cash_owner_list_id_from_main_user_login_id($get_main_user_login_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select id
                          from cash_owner_list
                          where ast='1'
                          and main_user_login_id='" . addslashes((int) $get_main_user_login_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['id'];
        }

        return 0;
    }

    public function get_cash_owner_id_of_member($member_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select cash_owner_list_id
                          from member_list
                          where ast='1'
                          and id='" . addslashes((int) $member_list_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['cash_owner_list_id'];
        }

        return 0;
    }

    public function get_cash_owner_id_of_manager($managers_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select cash_owner_list_id
                          from managers_list
                          where ast='1'
                          and id='" . addslashes((int) $managers_list_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['cash_owner_list_id'];
        }

        return 0;
    }

    public function get_assigned_manager_of_member($member_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select managers_list_id
                          from member_manager
                          where ast='1'
                          and member_list_id='" . addslashes((int) $member_list_id) . "'
                          order by id desc
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['managers_list_id'];
        }

        return 0;
    }

    public function get_assigned_members_of_manager($managers_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select member_list_id
                          from member_manager
                          where ast='1'
                          and managers_list_id='" . addslashes((int) $managers_list_id) . "'";
        $result = $data_base_obj->get_result($get_sql_query);
        $ids = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $ids[] = (int) $row['member_list_id'];
            }
        }

        return array_values(array_unique(array_filter($ids)));
    }

    public function get_user_id_of_member($member_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select main_user_login_id
                          from member_list
                          where id='" . addslashes((int) $member_list_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['main_user_login_id'];
        }

        return 0;
    }

    public function get_user_id_of_manager($managers_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select main_user_login_id
                          from managers_list
                          where id='" . addslashes((int) $managers_list_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['main_user_login_id'];
        }

        return 0;
    }

    public function get_user_id_of_cash_owner($cash_owner_list_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select main_user_login_id
                          from cash_owner_list
                          where id='" . addslashes((int) $cash_owner_list_id) . "'
                          limit 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['main_user_login_id'];
        }

        return 0;
    }
}
