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
    private $employee_id = "";
    private $employee_name = "";
    private $holder_name = "";
    private $bank_name = "";
    private $branch = "";
    private $bank_account_number = "";
    private $status = "";

    private $ast = "1";
    private $sdt;

    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data(
        $get_holder_name,
        $get_bank_name,
        $get_branch,
        $get_bank_account_number,
        $get_employee_id = "EMP-001",
        $get_employee_name = "",
        $get_user_id = 1,
        $get_status = "Active"
    ) {
        $this->holder_name         = $get_holder_name;
        $this->bank_name           = $get_bank_name;
        $this->branch              = $get_branch;
        $this->bank_account_number = $get_bank_account_number;
        $this->employee_id         = $get_employee_id;
        $this->employee_name       = $get_employee_name;
        $this->user_id             = (int)$get_user_id;
        $this->status              = $get_status;

        $this->sql_update_query .=
            ", holder_name='" . $this->holder_name . "'" .
            ", bank_name='" . $this->bank_name . "'" .
            ", branch='" . $this->branch . "'" .
            ", bank_account_number='" . $this->bank_account_number . "'" .
            ", account_number='" . $this->bank_account_number . "'" .
            ", employee_id='" . $this->employee_id . "'" .
            ", employee_name='" . $this->employee_name . "'" .
            ", user_id='" . $this->user_id . "'" .
            ", status='" . $this->status . "'";
    }

    public function set_holder_name($get_holder_name)
    {
        $this->holder_name = $get_holder_name;
        $this->sql_update_query .= ", holder_name='" . $this->holder_name . "'";
    }

    public function set_bank_name($get_bank_name)
    {
        $this->bank_name = $get_bank_name;
        $this->sql_update_query .= ", bank_name='" . $this->bank_name . "'";
    }

    public function set_branch($get_branch)
    {
        $this->branch = $get_branch;
        $this->sql_update_query .= ", branch='" . $this->branch . "'";
    }

    public function set_bank_account_number($get_bank_account_number)
    {
        $this->bank_account_number = $get_bank_account_number;
        $this->sql_update_query .= ", bank_account_number='" . $this->bank_account_number . "', account_number='" . $this->bank_account_number . "'";
    }

    public function set_employee_id($get_employee_id)
    {
        $this->employee_id = $get_employee_id;
        $this->sql_update_query .= ", employee_id='" . $this->employee_id . "'";
    }

    public function set_employee_name($get_employee_name)
    {
        $this->employee_name = $get_employee_name;
        $this->sql_update_query .= ", employee_name='" . $this->employee_name . "'";
    }

    public function set_status($get_status)
    {
        $this->status = $get_status;
        $this->sql_update_query .= ", status='" . $this->status . "'";
    }

    public function remove()
    {
        $this->ast = "0";
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($get_id)
    {
        $this->id = $get_id;
    }

    public function get_error()
    {
        return $this->error_msg;
    }

    // Backward compatibility helper
    public function saveBankDetails($holderName, $bankName, $branch, $accountNumber, $userId = 1, $employeeId = 'EMP-001')
    {
        $this->set_data($holderName, $bankName, $branch, $accountNumber, $employeeId, '', $userId, 'Active');
        $res = $this->process_new_record();
        if ($res) {
            return ['status' => 'success', 'message' => 'Bank details saved successfully.'];
        } else {
            return ['status' => 'error', 'message' => $this->error_msg];
        }
    }

    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "
            INSERT INTO bank_details (
                ast, 
                sdt, 
                user_id,
                employee_id,
                holder_name, 
                bank_name, 
                branch, 
                bank_account_number, 
                status
            )
            VALUES (
                '" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->user_id . "',
                '" . $this->employee_id . "',
                '" . $this->holder_name . "',
                '" . $this->bank_name . "',
                '" . $this->branch . "',
                '" . $this->bank_account_number . "',
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

        $get_sql_query = "
            UPDATE bank_details 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}

if (!class_exists('Bank_Details_Add_Update')) {
    class Bank_Details_Add_Update extends bank_details_ADD_UPDATE {}
}
?>
