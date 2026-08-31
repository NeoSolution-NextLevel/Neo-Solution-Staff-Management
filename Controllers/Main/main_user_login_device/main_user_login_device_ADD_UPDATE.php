<?php
class main_user_login_device_ADD_UPDATE
{
    private $id;
    private $ast = "1";
    private $sdt;

    private $device_type;
    private $browser;
    private $os;
    private $ip_address;
    private $last_activity;
    private $login_time;
    private $is_active = "0";
    private $main_user_login_id;
    private $session_token;
    private $location;

    private $sql_update_query = "";


    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }




    public function set_data(
        $get_device_type,
        $get_browser,
        $get_os,
        $get_ip_address,
        $get_last_activity,
        $get_login_time,
        $get_main_user_login_id,
        $get_session_token,
        $get_location



    ) {
        $this->device_type = $get_device_type;
        $this->browser = $get_browser;
        $this->os = $get_os;
        $this->ip_address = $get_ip_address;
        $this->last_activity = $get_last_activity;
        $this->login_time = $get_login_time;
        $this->main_user_login_id = $get_main_user_login_id;
        $this->session_token = $get_session_token;
        $this->location = $get_location;


        $this->sql_update_query .=
            " device_type = '" . $this->device_type . "'"
            . ", browser = '" . $this->browser . "'"
            . ", os = '" . $this->os . "'"
            . ", ip_address = '" . $this->ip_address . "'"
            . ", last_activity = '" . $this->last_activity . "'"
            . ", login_time = '" . $this->login_time . "'"
            . ", main_user_login_id = '" . $this->main_user_login_id . "'"
            . ", session_token = '" . $this->session_token . "'"
            . ", location = '" . $this->location . "'";
    }



    public function is_is_active()
    {
        $this->is_active = 1;
        $this->sql_update_query .= ", is_active = '" . $this->is_active . "'";
    }
    public function is_not_is_active()
    {
        $this->is_active = 0;
        $this->sql_update_query .= ", is_active = '" . $this->is_active . "'";
    }



    public function set_device_type($get_device_type)
    {
        $this->device_type = $get_device_type;
        $this->sql_update_query .= ", device_type = '" . $this->device_type . "'";
    }
    public function set_location($get_location)
    {
        $this->location = $get_location;
        $this->sql_update_query .= ", location = '" . $this->location . "'";
    }
    public function set_session_token($get_session_token)
    {
        $this->session_token = $get_session_token;
        $this->sql_update_query .= ", session_token = '" . $this->session_token . "'";
    }

    public function set_browser($get_browser)
    {
        $this->browser = $get_browser;
        $this->sql_update_query .= ", browser = '" . $this->browser . "'";
    }
    public function set_os($get_os)
    {
        $this->os = $get_os;
        $this->sql_update_query .= ", os = '" . $this->os . "'";
    }
    public function set_ip_address($get_ip_address)
    {
        $this->ip_address = $get_ip_address;
        $this->sql_update_query .= ", ip_address = '" . $this->ip_address . "'";
    }
    public function set_last_activity($get_last_activity)
    {
        $this->last_activity = $get_last_activity;
        $this->sql_update_query .= ", last_activity = '" . $this->last_activity . "'";
    }
    public function set_login_time($get_login_time)
    {
        $this->login_time = $get_login_time;
        $this->sql_update_query .= ", login_time = '" . $this->login_time . "'";
    }
    public function set_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = $get_main_user_login_id;
        $this->sql_update_query .= ", main_user_login_id = '" . $this->main_user_login_id . "'";
    }



    public function get_id()
    {
        return $this->id;
    }

    public function set_id($get_id)
    {
        $this->id = $get_id;
    }

    public function remove()
    {
        $this->ast = "0";
    }


    private $error_msg;
    public function get_error_msg()
    {
        return $this->error_msg;
    }

    public function log_out_all_device_except_current_one($get_main_user_login_id)
    {
        $data_base_obj = new Database();


        $get_sql_query = "
        UPDATE main_user_login_device
        SET ast = 0
        WHERE is_active!=1  AND main_user_login_id = '" . $get_main_user_login_id . "'
    ";
        $data_base_obj->get_result($get_sql_query);
        return $data_base_obj->get_error_state_boolean();
    }



    public function process_new_record()
    {
        $data_base_obj = new Database();
        $get_sql_query = "
                INSERT INTO main_user_login_device
                (ast, 
                sdt,
                device_type,
                browser,
                os,
                ip_address,
                last_activity,
                login_time,
                is_active,
                main_user_login_id,
                session_token,
                location)
                VALUES
                ('" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->device_type . "',
                '" . $this->browser . "',
                '" . $this->os . "',
                '" . $this->ip_address . "',
                '" . $this->last_activity . "',
                '" . $this->login_time . "',
                '" . $this->is_active . "',
                '" . $this->main_user_login_id . "',
                '" . $this->session_token . "',
                '" . $this->location . "'
                )";

        $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }


    public function process_update()
    {
        $data_base_obj = new Database();
        $get_sql_query = "
            UPDATE main_user_login_device 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}
