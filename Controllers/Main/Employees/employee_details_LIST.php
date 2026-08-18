<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class employee_details_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast = "1";

    public function get_all_data()
    {
        $this->sql_process_data = "*";
    }

    public function get_count()
    {
        $this->sql_process_data = "COUNT(id)";
    }

    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id)";
    }

    public function set_pagination($starter_point, $per_page_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . (int)$starter_point . ", " . (int)$per_page_count;
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . (int)$start_point . ", " . (int)$per_page_data_count;
    }

    public function remove_list()
    {
        $this->ast = "0";
    }

    public function filter_by_ast($get_ast)
    {
        $this->ast = $get_ast;
    }

    public function filter_by_department($dept)
    {
        $d = addslashes($dept);
        $this->sql_search_data .= " AND (departments = '$d' OR department = '$d' OR department_department_name = '$d') ";
    }

    public function filter_by_status($status)
    {
        $this->sql_search_data .= " AND status = '" . addslashes($status) . "' ";
    }

    public function filter_by_email($email)
    {
        $this->sql_search_data .= " AND email_address = '" . addslashes($email) . "' ";
    }

    public function filter_by_search($search)
    {
        $s = addslashes($search);
        $this->sql_search_data .= " AND (fullname LIKE '%" . $s . "%' OR email_address LIKE '%" . $s . "%' OR departments LIKE '%" . $s . "%' OR job_roles LIKE '%" . $s . "%') ";
    }

    public function get_result()
    {
        $obj_database = new DataBase();

        $columns = [];
        $col_res = $obj_database->get_result("SHOW COLUMNS FROM employees");
        if ($col_res) {
            while ($c = $col_res->fetch_assoc()) {
                $columns[] = strtolower($c['Field']);
            }
        }

        $where = "WHERE 1=1";
        if (in_array('ast', $columns)) {
            $where .= " AND ast = '" . addslashes($this->ast) . "'";
        }
        $where .= $this->sql_search_data;
        $where .= $this->pagination_data_result;

        $get_sql_query = "SELECT " . $this->sql_process_data . " FROM employees " . $where;

        return $obj_database->get_result($get_sql_query);
    }
}

// Backward compatibility class alias
if (!class_exists('employee_details_List')) {
    class employee_details_List extends employee_details_LIST {}
}
?>