<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class bank_details_ADD_UPDATE
{
    private $id;
    private $user_id = 1;
    private $employee_id = "EMP-001";
    private $employee_name = "";
    private $holder_name = "";
    private $bank_name = "";
    private $branch = "";
    private $bank_account_number = "";
    private $account_number = "";
    private $status = "Active";
    private $ast = "1";
    private $sdt;

    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data(
        $get_user_id,
        $get_employee_id,
        $get_employee_name,
        $get_holder_name,
        $get_bank_name,
        $get_branch,
        $get_bank_account_number,
        $get_status = "Active"
    ) {
        $this->user_id             = $get_user_id;
        $this->employee_id         = $get_employee_id;
        $this->employee_name       = $get_employee_name;
        $this->holder_name         = $get_holder_name;
        $this->bank_name           = $get_bank_name;
        $this->branch              = $get_branch;
        $this->bank_account_number = $get_bank_account_number;
        $this->account_number      = $get_bank_account_number;
        $this->status              = $get_status;

        $this->sql_update_query .=
            " user_id = '" . $this->user_id . "'"
            . ", employee_id = '" . $this->employee_id . "'"
            . ", employee_name = '" . $this->employee_name . "'"
            . ", holder_name = '" . $this->holder_name . "'"
            . ", bank_name = '" . $this->bank_name . "'"
            . ", branch = '" . $this->branch . "'"
            . ", bank_account_number = '" . $this->bank_account_number . "'"
            . ", account_number = '" . $this->account_number . "'"
            . ", status = '" . $this->status . "'";
    }

    public function set_user_id($get_user_id)
    {
        $this->user_id = $get_user_id;
        $this->sql_update_query .= ", user_id = '" . $this->user_id . "'";
    }

    public function set_employee_id($get_employee_id)
    {
        $this->employee_id = $get_employee_id;
        $this->sql_update_query .= ", employee_id = '" . $this->employee_id . "'";
    }

    public function set_employee_name($get_employee_name)
    {
        $this->employee_name = $get_employee_name;
        $this->sql_update_query .= ", employee_name = '" . $this->employee_name . "'";
    }

    public function set_holder_name($get_holder_name)
    {
        $this->holder_name = $get_holder_name;
        $this->sql_update_query .= ", holder_name = '" . $this->holder_name . "'";
    }

    public function set_bank_name($get_bank_name)
    {
        $this->bank_name = $get_bank_name;
        $this->sql_update_query .= ", bank_name = '" . $this->bank_name . "'";
    }

    public function set_branch($get_branch)
    {
        $this->branch = $get_branch;
        $this->sql_update_query .= ", branch = '" . $this->branch . "'";
    }

    public function set_bank_account_number($get_bank_account_number)
    {
        $this->bank_account_number = $get_bank_account_number;
        $this->account_number = $get_bank_account_number;
        $this->sql_update_query .= ", bank_account_number = '" . $this->bank_account_number . "', account_number = '" . $this->account_number . "'";
    }

    public function set_status($get_status)
    {
        $this->status = $get_status;
        $this->sql_update_query .= ", status = '" . $this->status . "'";
    }

    public function set_ast($get_ast)
    {
        $this->ast = $get_ast;
        $this->sql_update_query .= ", ast = '" . $this->ast . "'";
    }

    public function remove()
    {
        $this->ast = "0";
        $this->sql_update_query .= ", ast = '0'";
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($get_id)
    {
        $this->id = $get_id;
    }

    public function get_error_msg()
    {
        return $this->error_msg;
    }

    public function process_new_record()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "
            INSERT INTO bank_details
            (ast,
            sdt,
            user_id,
            employee_id,
            employee_name,
            holder_name,
            bank_name,
            branch,
            bank_account_number,
            account_number,
            status)
            VALUES
            ('" . $this->ast . "',
            '" . $this->sdt . "',
            '" . $this->user_id . "',
            '" . $this->employee_id . "',
            '" . $this->employee_name . "',
            '" . $this->holder_name . "',
            '" . $this->bank_name . "',
            '" . $this->branch . "',
            '" . $this->bank_account_number . "',
            '" . $this->account_number . "',
            '" . $this->status . "'
            )";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE bank_details SET ast='" . $this->ast . "'" . $this->sql_update_query . " WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }

    // Helper for direct save / update
    public function saveBankDetails($holderName, $bankName, $branch, $accNum, $userId = 1, $employeeId = 'EMP-001', $empName = '')
    {
        $db = new DataBase();
        if (empty($empName)) {
            $empName = $holderName;
        }

        $check_sql = "SELECT id FROM bank_details WHERE (employee_id = '" . addslashes($employeeId) . "' OR user_id = '" . (int)$userId . "') AND (ast='1' OR ast IS NULL OR ast='') ORDER BY id DESC LIMIT 1";
        $check_res = $db->get_result($check_sql);

        if ($check_res && $check_res->num_rows > 0) {
            $row = $check_res->fetch_assoc();
            $this->set_id($row['id']);
            $this->set_data($userId, $employeeId, $empName, $holderName, $bankName, $branch, $accNum, 'Active');
            $this->process_update();
            return [
                'status' => 'success',
                'message' => 'Bank details updated successfully.',
                'data' => [
                    'id' => $this->id,
                    'user_id' => $userId,
                    'employee_id' => $employeeId,
                    'employee_name' => $empName,
                    'holder_name' => $holderName,
                    'bank_name' => $bankName,
                    'branch' => $branch,
                    'bank_account_number' => $accNum
                ]
            ];
        } else {
            $this->set_data($userId, $employeeId, $empName, $holderName, $bankName, $branch, $accNum, 'Active');
            $this->process_new_record();
            return [
                'status' => 'success',
                'message' => 'Bank details saved successfully.',
                'data' => [
                    'id' => $this->id,
                    'user_id' => $userId,
                    'employee_id' => $employeeId,
                    'employee_name' => $empName,
                    'holder_name' => $holderName,
                    'bank_name' => $bankName,
                    'branch' => $branch,
                    'bank_account_number' => $accNum
                ]
            ];
        }
    }
}

if (!class_exists('Bank_Details_Add_Update')) {
    class Bank_Details_Add_Update extends bank_details_ADD_UPDATE {}
}
?>
