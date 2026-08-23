<?php
class main_user_account_access_level_list_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_company_id($get_company_id)
    {
        $this->sql_search_data .= " AND company_id='" . $get_company_id . "'";
    }

    public function filter_by_type_of_access($get_type_of_access)
    {
        $this->sql_search_data .= " AND type_of_access='" . $get_type_of_access . "'";
    }

    public function filter_by_url_home($get_url_home)
    {
        $this->sql_search_data .= " AND url_home='" . $get_url_home . "'";
    }

    public function filter_by_show_custoer_account($get_show_custoer_account)
    {
        $this->sql_search_data .= " AND show_custoer_account='" . $get_show_custoer_account . "'";
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
        $query = "SELECT " . $this->sql_process_data . " FROM main_user_account_access_level_list WHERE ast='" . $this->ast_state . "'" . $this->sql_search_data . $this->pagination_data_result;
        return $db->get_result($query);
    }

}