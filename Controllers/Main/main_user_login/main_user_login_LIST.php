<?php
class main_user_login_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_ast($get_ast)
    {
        $this->ast_state = $get_ast;
        $this->sql_search_data .= " AND ast='" . $this->ast_state . "'";
    }

    public function filter_by_user_name($get_user_name)
    {
        // $this->sql_search_data .= " AND LOWER(user_name) = LOWER('" . $get_user_name . "')";

        $this->sql_search_data .= " AND user_name='" . $get_user_name . "'";
    }

    public function filter_by_google_id($get_google_id)
    {
        $this->sql_search_data .= " AND google_id='" . $get_google_id . "'";
    }


    public function filter_by_password($get_password)
    {
        $this->sql_search_data .= " AND password='" . $get_password . "'";
    }



    public function filter_by_microsoft_id($get_microsoft_id)
    {
        $this->sql_search_data .= " AND microsoft_id='" . $get_microsoft_id . "'";
    }

    public function get_count_report()
    {
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
            " FROM main_user_login WHERE ast='" . $this->ast_state . "'" .
            $this->sql_search_data .
            $this->pagination_data_result;
        // echo $get_sql_query;

        return $data_base_obj->get_result($get_sql_query);
    }
    public function  user_login_check($get_user_name, $get_Password) {}
}
