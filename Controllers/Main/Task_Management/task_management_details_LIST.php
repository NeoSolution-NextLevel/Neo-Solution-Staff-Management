<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class task_management_details_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_ast($get_ast)
    {
        $this->ast_state = $get_ast;
    }

    public function filter_by_id($get_id)
    {
        $this->sql_search_data .= " AND id='" . (int)$get_id . "'";
    }

    public function filter_by_status($status)
    {
        $this->sql_search_data .= " AND status='" . addslashes($status) . "'";
    }

    public function filter_by_department($dept)
    {
        $this->sql_search_data .= " AND department='" . addslashes($dept) . "'";
    }

    public function filter_by_employee($emp)
    {
        $this->sql_search_data .= " AND assigned_employee LIKE '%" . addslashes($emp) . "%'";
    }

    public function filter_by_priority($priority)
    {
        $this->sql_search_data .= " AND priority='" . addslashes($priority) . "'";
    }

    public function filter_by_search($get_search)
    {
        $s = addslashes($get_search);
        $this->sql_search_data .= " AND (task_title LIKE '%" . $s . "%' OR department LIKE '%" . $s . "%' OR assigned_employee LIKE '%" . $s . "%')";
    }

    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id)";
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . (int)$start_point . ", " . (int)$per_page_data_count;
    }

    public function remove_list()
    {
        $this->ast_state = "0";
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT " . $this->sql_process_data .
            " FROM task_management WHERE 1=1 " .
            $this->sql_search_data .
            $this->pagination_data_result;

        return $data_base_obj->get_result($get_sql_query);
    }
}

// Backward compatibility class aliases
if (!class_exists('task_management_LIST')) {
    class task_management_LIST extends task_management_details_LIST {}
}
?>
