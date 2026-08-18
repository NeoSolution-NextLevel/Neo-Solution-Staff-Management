<?php
class email_sms_link_manament_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_company_id($get_company_id)
    {
        $this->sql_search_data .= " AND company_id='" . $get_company_id . "'";
    }

    public function filter_by_branch_id($get_branch_id)
    {
        $this->sql_search_data .= " AND branch_id='" . $get_branch_id . "'";
    }

    public function filter_by_state_of_view($get_state_of_view)
    {
        $this->sql_search_data .= " AND state_of_view='" . $get_state_of_view . "'";
    }

    public function filter_by_on_short_lock($get_on_short_lock)
    {
        $this->sql_search_data .= " AND on_short_lock='" . $get_on_short_lock . "'";
    }

    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id)";
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
        $query = "SELECT " . $this->sql_process_data . " FROM email_sms_link_manament WHERE ast='" . $this->ast_state . "'" . $this->sql_search_data . $this->pagination_data_result;
        return $db->get_result($query);
    }

}