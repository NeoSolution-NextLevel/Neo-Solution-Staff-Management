<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class bank_details_SINGLE_DATA
{
    private $id;
    private $user_id;
    private $employee_id;
    private $employee_name;
    private $holder_name;
    private $bank_name;
    private $branch;
    private $bank_account_number;
    private $status;
    private $ast = "1";
    private $sdt;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM bank_details WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id                  = $row['id'];
                $this->user_id             = isset($row['user_id']) ? $row['user_id'] : 1;
                $this->employee_id         = isset($row['employee_id']) ? $row['employee_id'] : '';
                $this->employee_name       = isset($row['employee_name']) ? $row['employee_name'] : '';
                $this->holder_name         = isset($row['holder_name']) ? $row['holder_name'] : '';
                $this->bank_name           = isset($row['bank_name']) ? $row['bank_name'] : '';
                $this->branch              = isset($row['branch']) ? $row['branch'] : '';
                $this->bank_account_number = isset($row['bank_account_number']) ? $row['bank_account_number'] : (isset($row['account_number']) ? $row['account_number'] : '');
                $this->status              = isset($row['status']) ? $row['status'] : 'Active';
                $this->ast                 = isset($row['ast']) ? $row['ast'] : '1';
                $this->sdt                 = isset($row['sdt']) ? $row['sdt'] : date('Y-m-d H:i:s');
            }
        }
    }

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function is_state_of_data()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function get_employee_id()
    {
        return $this->employee_id;
    }

    public function get_employee_name()
    {
        return $this->employee_name;
    }

    public function get_holder_name()
    {
        return $this->holder_name;
    }

    public function get_bank_name()
    {
        return $this->bank_name;
    }

    public function get_branch()
    {
        return $this->branch;
    }

    public function get_bank_account_number()
    {
        return $this->bank_account_number;
    }

    public function get_status()
    {
        return $this->status;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }
}

if (!class_exists('Bank_Details_Single_Data')) {
    class Bank_Details_Single_Data extends bank_details_SINGLE_DATA {}
}
?>
