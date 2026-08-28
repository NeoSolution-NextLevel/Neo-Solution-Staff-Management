<?php
        include_once __DIR__ . '/../../../imports/need/DB.php';
        include_once __DIR__ . '/../../../database.php';

    
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

    private $error_msg = "";
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

        $this->sql_update_query =
            ", user_id = '" . $this->user_id . "'"
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
        $this->sql_update_query .= ", bank_account_number = '" . $this->bank_account_number . "', account_number = '" . addslashes($this->account_number) . "'";
    }

    public function set_account_number($get_account_number)
    {
        $this->account_number = $get_account_number;
        $this->bank_account_number = $get_account_number;
        $this->sql_update_query .= ", account_number = '" . $this->account_number . "', bank_account_number = '" . addslashes($this->bank_account_number) . "'";
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

    public function set_sdt($get_sdt)
    {
        $this->sdt = $get_sdt;
    }

    public function remove()
    {
        $this->ast = "0";
        $this->sql_update_query .= ", ast = '0'";
    }

    public function set_id($get_id)
    {
        $this->id = (int)$get_id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_error_msg()
    {
        return $this->error_msg;
    }

    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        $create_sql = "
            CREATE TABLE IF NOT EXISTS `bank_details` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) DEFAULT '1',
                `employee_id` VARCHAR(50) DEFAULT 'EMP-001',
                `employee_name` VARCHAR(255) DEFAULT '',
                `holder_name` VARCHAR(255) DEFAULT '',
                `bank_name` VARCHAR(255) DEFAULT '',
                `branch` VARCHAR(255) DEFAULT '',
                `bank_account_number` TEXT,
                `account_number` TEXT,
                `status` VARCHAR(50) DEFAULT 'Active',
                `ast` VARCHAR(10) DEFAULT '1',
                `sdt` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_emp` (`employee_id`),
                KEY `idx_usr` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $data_base_obj->get_result($create_sql);

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
            '" . (int)$this->user_id . "',
            '" . $this->employee_id . "',
            '" . $this->employee_name . "',
            '" . $this->holder_name . "',
            '" . $this->bank_name . "',
            '" . $this->branch . "',
            '" . $this->bank_account_number . "',
            '" . $this->account_number . "',
            '" . $this->status . "'
            )";

        $res = $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        $this->id = $data_base_obj->get_id();
        return ($res !== false);
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE bank_details SET ast='" . $this->ast . "'" . $this->sql_update_query . " WHERE id='" . (int)$this->id . "'";

        $res = $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return ($res !== false);
    }
}

if (!class_exists('Bank_Details_Add_Update')) {
    class Bank_Details_Add_Update extends bank_details_ADD_UPDATE {}
}
?>
