<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class leave_requests_LIST
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

    public function filter_by_employee_id($get_employee_id)
    {
        $this->sql_search_data .= " AND employee_id='" . $get_employee_id . "'";
    }

    public function filter_for_employee($employee_id, $employee_name)
    {
        $data_base_obj = new DataBase();
        $conn = $data_base_obj->get_data_base_connction();
        $conditions = [];

        if (!empty($employee_id)) {
            $safe_employee_id = mysqli_real_escape_string($conn, trim($employee_id));
            $conditions[] = "employee_id='" . $safe_employee_id . "'";
        }

        if (!empty($employee_name)) {
            $safe_employee_name = mysqli_real_escape_string($conn, trim($employee_name));
            $conditions[] = "((employee_id IS NULL OR employee_id='') AND employee_name='" . $safe_employee_name . "')";
        }

        $this->sql_search_data .= !empty($conditions)
            ? " AND (" . implode(" OR ", $conditions) . ")"
            : " AND 1=0";
    }

    public function filter_by_employee_name($get_employee_name)
    {
        $this->sql_search_data .= " AND employee_name LIKE '%" . $get_employee_name . "%'";
    }

    public function filter_by_leave_type($get_leave_type)
    {
        $this->sql_search_data .= " AND leave_type='" . $get_leave_type . "'";
    }

    public function filter_by_status($get_status)
    {
        $this->sql_search_data .= " AND status='" . $get_status . "'";
    }

    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id)";
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . (int)$start_point . ", " . (int)$per_page_data_count;
    }

   

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $order_clause = !empty($this->pagination_data_result) ? $this->pagination_data_result : " ORDER BY id DESC";
        $get_sql_query = "SELECT " . $this->sql_process_data .
            " FROM leave_requests WHERE 1=1 " .
            $this->sql_search_data .
            $order_clause;

        return $data_base_obj->get_result($get_sql_query);
    }
}

if (!class_exists('leave_requests_details_LIST')) {
    class leave_requests_details_LIST extends leave_requests_LIST {}
}
?>
