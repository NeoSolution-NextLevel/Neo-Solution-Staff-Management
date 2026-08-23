<?php
class main_user_login_device_SINGLE_DATA
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



    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = $id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM main_user_login_device WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id                   = $row['id'];
                $this->ast        = $row['ast'];
                $this->sdt        = $row['sdt'];
                $this->device_type       = $row['device_type'];
                $this->browser    = $row['browser'];
                $this->os          = $row['os'];
                $this->ip_address           = $row['ip_address'];
                $this->last_activity          = $row['last_activity'];
                $this->login_time            = $row['login_time'];
                $this->is_active           = $row['is_active'];
                $this->main_user_login_id            = $row['main_user_login_id'];
                $this->session_token            = $row['session_token'];
            }
        }
    }

    // --- Getter functions ---

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }
    public function get_device_type()
    {
        return $this->device_type;
    }

    public function get_session_token()
    {
        return $this->session_token;
    }
    public function get_browser()
    {
        return $this->browser;
    }
    public function get_os()
    {
        return $this->os;
    }
    public function get_ip_address()
    {
        return $this->ip_address;
    }
    public function get_last_activity()
    {
        return $this->last_activity;
    }
    public function get_login_time()
    {
        return $this->login_time;
    }
    public function get_is_active()
    {
        return $this->is_active;
    }
    public function get_main_user_login_id()
    {
        return $this->main_user_login_id;
    }
}
