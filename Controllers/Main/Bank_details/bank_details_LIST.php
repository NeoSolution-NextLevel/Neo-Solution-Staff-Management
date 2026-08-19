<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class bank_details_LIST
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

    public function filter_by_user_id($get_user_id)
    {
        $this->sql_search_data .= " AND user_id='" . $get_user_id . "'";
    }

    public function filter_by_employee_id($get_employee_id)
    {
        $this->sql_search_data .= " AND employee_id='" . $get_employee_id . "'";
    }

    public function filter_by_bank_name($get_bank_name)
    {
        $this->sql_search_data .= " AND bank_name='" . $get_bank_name . "'";
    }

    public function filter_by_status($get_status)
    {
        $this->sql_search_data .= " AND status='" . $get_status . "'";
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
        $query = "SELECT " . $this->sql_process_data . " FROM bank_details WHERE (ast='" . $this->ast_state . "' OR ast IS NULL OR ast='')" . $this->sql_search_data . $this->pagination_data_result;
        return $db->get_result($query);
    }

    public function getAllBankDetails()
    {
        $db = new DataBase();
        $query = "SELECT * FROM bank_details WHERE (ast='1' OR ast IS NULL OR ast='') ORDER BY id DESC";
        $res = $db->get_result($query);

        $list = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $empName = !empty($row['employee_name']) ? $row['employee_name'] : (!empty($row['holder_name']) ? $row['holder_name'] : 'Employee');
                $list[] = [
                    'id' => (int)$row['id'],
                    'user_id' => isset($row['user_id']) ? (int)$row['user_id'] : 1,
                    'employee_id' => !empty($row['employee_id']) ? $row['employee_id'] : ('EMP-' . str_pad($row['id'], 3, '0', STR_PAD_LEFT)),
                    'employee_name' => $empName,
                    'holder_name' => !empty($row['holder_name']) ? $row['holder_name'] : $empName,
                    'account_holder_name' => !empty($row['holder_name']) ? $row['holder_name'] : $empName,
                    'bank_name' => !empty($row['bank_name']) ? $row['bank_name'] : '-',
                    'branch' => !empty($row['branch']) ? $row['branch'] : '-',
                    'bank_account_number' => !empty($row['bank_account_number']) ? $row['bank_account_number'] : (!empty($row['account_number']) ? $row['account_number'] : '-'),
                    'account_number' => !empty($row['bank_account_number']) ? $row['bank_account_number'] : (!empty($row['account_number']) ? $row['account_number'] : '-'),
                    'status' => !empty($row['status']) ? $row['status'] : 'Active',
                    'sdt' => !empty($row['sdt']) ? $row['sdt'] : date('Y-m-d H:i:s')
                ];
            }
        }

        return [
            'status' => 'success',
            'count' => count($list),
            'data' => $list
        ];
    }
}

if (!class_exists('Bank_Details_List')) {
    class Bank_Details_List extends bank_details_LIST {}
}
?>
