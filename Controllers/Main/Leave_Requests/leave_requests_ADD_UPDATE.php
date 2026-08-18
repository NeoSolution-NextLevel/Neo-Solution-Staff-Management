<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class leave_requests_ADD_UPDATE
{
    private $id;
    private $employee_id = "";
    private $employee_name = "";
    private $leave_type = "Annual Leave";
    private $from_date;
    private $to_date;
    private $days = 1;
    private $reason = "";
    private $status = "Pending";
    private $approved_by = "";
    private $approved_date;
    
    private $ast = "1";
    private $sdt;

    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data(
        $get_employee_name,
        $get_leave_type,
        $get_from_date,
        $get_to_date,
        $get_days = 1,
        $get_reason = "",
        $get_status = "Pending",
        $get_employee_id = ""
    ) {
        $this->employee_name = $get_employee_name;
        $this->leave_type    = $get_leave_type;
        $this->from_date     = $get_from_date;
        $this->to_date       = $get_to_date;
        $this->days          = $get_days;
        $this->reason        = $get_reason;
        $this->status        = $get_status;
        $this->employee_id   = $get_employee_id;

        $this->sql_update_query .=
            ", employee_name='" . $this->employee_name . "'" .
            ", leave_type='" . $this->leave_type . "'" .
            ", from_date='" . $this->from_date . "'" .
            ", to_date='" . $this->to_date . "'" .
            ", days='" . $this->days . "'" .
            ", reason='" . $this->reason . "'" .
            ", status='" . $this->status . "'" .
            ", employee_id='" . $this->employee_id . "'";
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

    public function set_leave_type($get_leave_type)
    {
        $this->leave_type = $get_leave_type;
        $this->sql_update_query .= ", leave_type='" . $this->leave_type . "'";
    }

    public function set_from_date($get_from_date)
    {
        $this->from_date = $get_from_date;
        $this->sql_update_query .= ", from_date='" . $this->from_date . "'";
    }

    public function set_to_date($get_to_date)
    {
        $this->to_date = $get_to_date;
        $this->sql_update_query .= ", to_date='" . $this->to_date . "'";
    }

    public function set_days($get_days)
    {
        $this->days = $get_days;
        $this->sql_update_query .= ", days='" . $this->days . "'";
    }

    public function set_reason($get_reason)
    {
        $this->reason = $get_reason;
        $this->sql_update_query .= ", reason='" . $this->reason . "'";
    }

    public function set_status($get_status)
    {
        $this->status = $get_status;
        $this->sql_update_query .= ", status='" . $this->status . "'";
    }

    public function set_approved_by($get_approved_by)
    {
        $this->approved_by = $get_approved_by;
        $this->approved_date = date('Y-m-d H:i:s');
        $this->sql_update_query .= ", approved_by='" . $this->approved_by . "', approved_date='" . $this->approved_date . "'";
    }

    // --- Status Helper Methods ---
    public function approve()
    {
        $this->status = "Approved";
        $this->approved_date = date('Y-m-d H:i:s');
        $this->sql_update_query .= ", status='" . $this->status . "', approved_date='" . $this->approved_date . "'";
    }

    public function reject()
    {
        $this->status = "Rejected";
        $this->sql_update_query .= ", status='" . $this->status . "'";
    }

    public function remove()
    {
        $this->ast = "0";
    }

    // --- Utility and Getter Methods ---
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

    // --- Database Processing Methods ---
    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "
            INSERT INTO leave_requests (
                ast, 
                sdt, 
                employee_id,
                employee_name, 
                leave_type, 
                from_date, 
                to_date, 
                days, 
                reason, 
                status
            )
            VALUES (
                '" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->employee_id . "',
                '" . $this->employee_name . "',
                '" . $this->leave_type . "',
                '" . $this->from_date . "',
                '" . $this->to_date . "',
                '" . $this->days . "',
                '" . $this->reason . "',
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
            UPDATE leave_requests 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}
