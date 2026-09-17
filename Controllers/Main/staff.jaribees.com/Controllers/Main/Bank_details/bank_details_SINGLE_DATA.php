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
    private $account_number;
    private $status;
    private $ast;
    private $sdt;

    private $state_of_data = false;

    public function __construct($id = 0)
    {
        if (!empty($id)) {
            $this->id = $id;
            $data_base_obj = new DataBase();
            $get_sql_query = "SELECT * FROM bank_details WHERE id = '" . $this->id . "'";
            $result = $data_base_obj->get_result($get_sql_query);

            if (!$result || $result->num_rows == 0) {
                $this->state_of_data = false;
            } else {
                $this->state_of_data = true;
                while ($result && $row = $result->fetch_assoc()) {
                    $this->id                  = $row['id'];
                    $this->user_id             = $row['user_id'];
                    $this->employee_id         = $row['employee_id'];
                    $this->employee_name       = $row['employee_name'];
                    $this->holder_name         = $row['holder_name'];
                    $this->bank_name           = $row['bank_name'];
                    $this->branch              = $row['branch'];
                    $this->bank_account_number = $row['bank_account_number'];
                    $this->account_number      = $row['account_number'];
                    $this->status              = $row['status'];
                    $this->ast                 = $row['ast'];
                    $this->sdt                 = $row['sdt'];
                }
            }
        }
    }

    public function getBankDetailsByEmployee($employeeId = '', $userId = 1)
    {
        $data_base_obj = new DataBase();
        $safeEmpId = !empty($employeeId) ? addslashes(trim($employeeId)) : '';
        $safeUserId = (int)$userId > 0 ? (int)$userId : 1;

        $row = null;

        if (!empty($safeEmpId)) {
            $sql1 = "SELECT * FROM bank_details WHERE (ast='1' OR ast IS NULL OR ast='') AND employee_id = '{$safeEmpId}' ORDER BY id DESC LIMIT 1";
            $res1 = $data_base_obj->get_result($sql1);
            if ($res1 && $res1->num_rows > 0) {
                $row = $res1->fetch_assoc();
            }
        }

        if (!$row && $safeUserId > 0) {
            $sql2 = "SELECT * FROM bank_details WHERE (ast='1' OR ast IS NULL OR ast='') AND user_id = '{$safeUserId}' ORDER BY id DESC LIMIT 1";
            $res2 = $data_base_obj->get_result($sql2);
            if ($res2 && $res2->num_rows > 0) {
                $row = $res2->fetch_assoc();
            }
        }

        if (!$row) {
            $sql3 = "SELECT * FROM bank_details WHERE (ast='1' OR ast IS NULL OR ast='') ORDER BY id DESC LIMIT 1";
            $res3 = $data_base_obj->get_result($sql3);
            if ($res3 && $res3->num_rows > 0) {
                $row = $res3->fetch_assoc();
            }
        }

        if ($row) {
            $this->state_of_data       = true;
            $this->id                  = $row['id'];
            $this->user_id             = $row['user_id'];
            $this->employee_id         = $row['employee_id'];
            $this->employee_name       = $row['employee_name'];
            $this->holder_name         = $row['holder_name'];
            $this->bank_name           = $row['bank_name'];
            $this->branch              = $row['branch'];
            $this->bank_account_number = $row['bank_account_number'];
            $this->account_number      = $row['account_number'];
            $this->status              = $row['status'];
            $this->ast                 = $row['ast'];
            $this->sdt                 = $row['sdt'];

include_once __DIR__ . '/Bank_Security.php';

            $decrypted = Bank_Security::decrypt($this->bank_account_number);
            $masked = Bank_Security::mask($decrypted);

            return [
                'status' => 'success',
                'data' => [
                    'id' => $this->id,
                    'user_id' => $this->user_id,
                    'employee_id' => $this->employee_id,
                    'employee_name' => $this->employee_name,
                    'holder_name' => $this->holder_name,
                    'account_holder_name' => $this->holder_name,
                    'bank_name' => $this->bank_name,
                    'branch' => $this->branch,
                    'account_number' => $decrypted,
                    'bank_account_number' => $decrypted,
                    'masked_account_number' => $masked,
                    'status' => $this->status,
                    'sdt' => $this->sdt
                ]
            ];
        } else {
            $this->state_of_data = false;
            return [
                'status' => 'error',
                'message' => 'No bank details found.',
                'data' => null
            ];
        }
    }

    // --- Getter functions ---

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

    public function get_account_number()
    {
        return $this->account_number;
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
