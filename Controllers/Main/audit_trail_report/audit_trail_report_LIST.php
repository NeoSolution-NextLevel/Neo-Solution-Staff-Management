<?php

class audit_trail_report_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_company_id($get_company_id)
    {
        $this->sql_search_data .= " AND company_id='" . $get_company_id . "'";
    }

    public function filter_by_ast($get_ast)
    {
        $this->sql_search_data .= " AND ast='" . $get_ast . "'";
    }

    public function get_count_report() {
        $this->sql_process_data = "COUNT(id)";
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . $start_point . ", " . $per_page_data_count;
    }

    public function remove_list()
    {
        $this->ast_state = "0";
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT " . $this->sql_process_data . 
        " FROM audit_trail_report WHERE ast='" . $this->ast_state . "'" .
         
         $this->sql_search_data . 
         $this->pagination_data_result;
        return $data_base_obj->get_result($get_sql_query);
    }

}   
