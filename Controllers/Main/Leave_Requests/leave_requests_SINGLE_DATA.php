<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class leave_requests_SINGLE_DATA
{
    private $id;
    private $employee_id;
    private $employee_name;
    private $leave_type;
    private $from_date;
    private $to_date;
    private $days;
    private $reason;
    private $status;
    private $approved_by;
    private $approved_date;
    private $ast = "1";
    private $sdt;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM leave_requests WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id            = $row['id'];
                $this->employee_id   = isset($row['employee_id']) ? $row['employee_id'] : '';
                $this->employee_name = isset($row['employee_name']) ? $row['employee_name'] : '';
                $this->leave_type    = isset($row['leave_type']) ? $row['leave_type'] : '';
                $this->from_date     = isset($row['from_date']) ? $row['from_date'] : '';
                $this->to_date       = isset($row['to_date']) ? $row['to_date'] : '';
                $this->days          = isset($row['days']) ? $row['days'] : 1;
                $this->reason        = isset($row['reason']) ? $row['reason'] : '';
                $this->status        = isset($row['status']) ? $row['status'] : 'Pending';
                $this->approved_by   = isset($row['approved_by']) ? $row['approved_by'] : '';
                $this->approved_date = isset($row['approved_date']) ? $row['approved_date'] : '';
                $this->ast           = isset($row['ast']) ? $row['ast'] : '1';
                $this->sdt           = isset($row['sdt']) ? $row['sdt'] : (isset($row['created_at']) ? $row['created_at'] : date('Y-m-d H:i:s'));
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

    public function get_employee_id()
    {
        return $this->employee_id;
    }

    public function get_employee_name()
    {
        return $this->employee_name;
    }

    public function get_leave_type()
    {
        return $this->leave_type;
    }

    public function get_from_date()
    {
        return $this->from_date;
    }

    public function get_to_date()
    {
        return $this->to_date;
    }

    public function get_days()
    {
        return $this->days;
    }

    public function get_reason()
    {
        return $this->reason;
    }

    public function get_status()
    {
        return $this->status;
    }

    public function get_approved_by()
    {
        return $this->approved_by;
    }

    public function get_approved_date()
    {
        return $this->approved_date;
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
?>
