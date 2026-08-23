<?php
class main_user_login_device_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_device_type($get_device_type)
    {
        $this->sql_search_data .= " AND device_type='" . $get_device_type . "'";
    }

    public function filter_by_browser($get_browser)
    {
        $this->sql_search_data .= " AND browser='" . $get_browser . "'";
    }

    public function filter_by_os($get_os)
    {
        $this->sql_search_data .= " AND os='" . $get_os . "'";
    }

    public function filter_by_ast()
    {

        $this->sql_search_data .= " AND ast='" . $this->ast_state . "'";
    }

    public function filter_by_ip_address($get_ip_address)
    {
        $this->sql_search_data .= " AND ip_address='" . $get_ip_address . "'";
    }

    public function filter_by_main_user_login_id($get_main_user_login_id)
    {
        $this->sql_search_data .= " AND main_user_login_id='" . $get_main_user_login_id . "'";
    }



    public function filter_by_is_active()
    {
        $this->sql_search_data .= " AND is_active=1";
    }




    public function filter_by_session_token($get_session_token)
    {
        $this->sql_search_data .= " AND session_token='" . $get_session_token . "'";
    }


    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id) AS total_count";
    }

    public function set_data_limits($start, $count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . $start . ", " . $count;
    }

    public function remove_list()
    {
        $this->ast_state = "0";
    }

    public function get_result()
    {
        $db = new DataBase();
        $query = "SELECT " . $this->sql_process_data . " FROM main_user_login_device WHERE ast='" . $this->ast_state . "'" . $this->sql_search_data . $this->pagination_data_result;
        return $db->get_result($query);
    }
}
