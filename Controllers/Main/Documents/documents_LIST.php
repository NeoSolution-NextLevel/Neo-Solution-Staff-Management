<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class documents_LIST
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

    public function filter_by_id($get_id)
    {
        $this->sql_search_data .= " AND id='" . (int)$get_id . "'";
    }

    public function filter_by_employee_id($get_employee_id)
    {
        $this->sql_search_data .= " AND employee_id='" . $get_employee_id . "'";
    }

    public function filter_by_employee_name($get_employee_name)
    {
        $this->sql_search_data .= " AND employee_name LIKE '%" . $get_employee_name . "%'";
    }

    public function filter_by_doc_type($get_doc_type)
    {
        $this->sql_search_data .= " AND doc_type='" . $get_doc_type . "'";
    }

    public function filter_by_user_id($get_user_id)
    {
        $this->sql_search_data .= " AND user_id='" . (int)$get_user_id . "'";
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
        $get_sql_query = "SELECT " . $this->sql_process_data .
            " FROM documents WHERE ast='" . $this->ast_state . "'" .
            $this->sql_search_data .
            $this->pagination_data_result;

        return $data_base_obj->get_result($get_sql_query);
    }

    // Backward compatibility helper
    public function getDocuments($employeeId = null, $userId = null)
    {
        if ($employeeId !== null) {
            $this->filter_by_employee_id($employeeId);
        } elseif ($userId !== null) {
            $this->filter_by_user_id($userId);
        }
        $res = $this->get_result();
        $list = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $list[] = $row;
            }
        }
        return [
            'status' => 'success',
            'count' => count($list),
            'data' => $list
        ];
    }
}

if (!class_exists('Documents_List')) {
    class Documents_List extends documents_LIST {}
}
?>
