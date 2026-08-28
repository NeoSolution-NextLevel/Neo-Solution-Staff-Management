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
    private $id = 0;
    private $modified_fields = [];

    private $employee_id = "";
    private $employee_name = "";
    private $leave_type = "";
    private $from_date = "";
    private $to_date = "";
    private $days = 1;
    private $reason = "";
    private $status = "";
    private $approved_by = "";
    private $approved_date = "";
    
    private $ast = "1";
    private $sdt = "";

    private $error_msg = "";

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
        $get_status = "",
        $get_employee_id = ""
    ) {
        $this->set_employee_name($get_employee_name);
        $this->set_leave_type($get_leave_type);
        $this->set_from_date($get_from_date);
        $this->set_to_date($get_to_date);
        $this->set_days($get_days);
        $this->set_reason($get_reason);
        $this->set_status($get_status);
        if (!empty($get_employee_id)) {
            $this->set_employee_id($get_employee_id);
        }
    }

    public function set_employee_id($get_employee_id)
    {
        $this->employee_id = $get_employee_id;
        $this->modified_fields['employee_id'] = addslashes($get_employee_id);
    }

    public function set_employee_name($get_employee_name)
    {
        $this->employee_name = $get_employee_name;
        $this->modified_fields['employee_name'] = addslashes($get_employee_name);
    }

    public function set_leave_type($get_leave_type)
    {
        $this->leave_type = $get_leave_type;
        $this->modified_fields['leave_type'] = addslashes($get_leave_type);
    }

    public function set_from_date($get_from_date)
    {
        $this->from_date = $get_from_date;
        $this->modified_fields['from_date'] = addslashes($get_from_date);
    }

    public function set_to_date($get_to_date)
    {
        $this->to_date = $get_to_date;
        $this->modified_fields['to_date'] = addslashes($get_to_date);
    }

    public function set_days($get_days)
    {
        $this->days = (int)$get_days;
        $this->modified_fields['days'] = (int)$get_days;
    }

    public function set_reason($get_reason)
    {
        $this->reason = $get_reason;
        $this->modified_fields['reason'] = addslashes($get_reason);
    }

    public function set_status($get_status)
    {
        $this->status = $get_status;
        $this->modified_fields['status'] = addslashes($get_status);
    }

    public function set_approved_by($get_approved_by)
    {
        $this->approved_by = $get_approved_by;
        $this->approved_date = date('Y-m-d H:i:s');
        $this->modified_fields['approved_by'] = addslashes($get_approved_by);
        $this->modified_fields['approved_date'] = $this->approved_date;
    }

    // --- Status Helper Methods ---
    public function approve()
    {
        $this->set_status("Approved");
        $this->approved_date = date('Y-m-d H:i:s');
        $this->modified_fields['approved_date'] = $this->approved_date;
    }

    public function reject()
    {
        $this->set_status("Rejected");
    }

    public function remove()
    {
        $this->ast = "0";
        $this->modified_fields['ast'] = "0";
    }

    // --- Utility and Getter Methods ---
    public function get_id()
    {
        return $this->id;
    }

    public function set_id($get_id)
    {
        $this->id = (int)$get_id;
    }

    public function get_error()
    {
        return $this->error_msg;
    }

    private function get_existing_table_columns_info($conn)
    {
        $info = [
            'cols'         => [],
            'has_auto_inc' => false
        ];
        $col_res = $conn->query("SHOW COLUMNS FROM `leave_requests`");
        if ($col_res && ($col_res instanceof mysqli_result)) {
            while ($row = $col_res->fetch_assoc()) {
                if (isset($row['Field'])) {
                    $cName = strtolower($row['Field']);
                    $info['cols'][] = $cName;
                    if ($cName === 'id' && strpos(strtolower($row['Extra'] ?? ''), 'auto_increment') !== false) {
                        $info['has_auto_inc'] = true;
                    }
                }
            }
        }
        return $info;
    }

    // --- Database Processing Methods ---
    public function process_new_record()
    {
        $data_base_obj = new DataBase();
        $conn = $data_base_obj->get_data_base_connction();

        $info = $this->get_existing_table_columns_info($conn);
        $cols = $info['cols'];
        $has_auto_inc = $info['has_auto_inc'];

        $fields = [];
        $values = [];

        // If table doesn't have auto_increment, compute and insert sequential ID
        if (!$has_auto_inc) {
            $id_res = $conn->query("SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM `leave_requests`");
            if ($id_res && ($row = $id_res->fetch_assoc())) {
                $this->id = (int)$row['next_id'];
            } else {
                $this->id = 1;
            }
            $fields[] = "`id`";
            $values[] = "'" . (int)$this->id . "'";
        }

        $field_map = [
            'employee_name' => addslashes($this->employee_name),
            'leave_type'    => addslashes($this->leave_type),
            'from_date'     => !empty($this->from_date) ? addslashes($this->from_date) : date('Y-m-d'),
            'to_date'       => !empty($this->to_date) ? addslashes($this->to_date) : date('Y-m-d'),
            'days'          => (int)$this->days > 0 ? (int)$this->days : 1,
            'reason'        => addslashes($this->reason),
            'status'        => !empty($this->status) ? addslashes($this->status) : 'Pending',
            'employee_id'   => addslashes($this->employee_id),
            'approved_by'   => addslashes($this->approved_by),
            'approved_date' => addslashes($this->approved_date),
            'ast'           => addslashes($this->ast),
            'sdt'           => date('Y-m-d H:i:s'),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        foreach ($field_map as $fName => $fVal) {
            if (empty($cols) || in_array(strtolower($fName), $cols)) {
                $fields[] = "`$fName`";
                $values[] = "'$fVal'";
            }
        }

        if (empty($fields)) {
            $this->error_msg = "No matching columns found in leave_requests table.";
            return false;
        }

        $get_sql_query = "INSERT INTO `leave_requests` (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";

        $res = $conn->query($get_sql_query);
        if (!$res) {
            $this->error_msg = $conn->error;
            return false;
        }

        $new_insert_id = $conn->insert_id;
        if ((int)$new_insert_id > 0) {
            $this->id = (int)$new_insert_id;
        }
        return true;
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();
        $conn = $data_base_obj->get_data_base_connction();

        $info = $this->get_existing_table_columns_info($conn);
        $cols = $info['cols'];

        if (empty($this->id)) {
            $this->error_msg = "No ID provided for update.";
            return false;
        }

        $updates = [];

        foreach ($this->modified_fields as $fName => $fVal) {
            if (empty($cols) || in_array(strtolower($fName), $cols)) {
                $updates[] = "`$fName`='$fVal'";
            }
        }

        if (empty($updates)) {
            return true; // Nothing changed
        }

        $get_sql_query = "UPDATE `leave_requests` SET " . implode(", ", $updates) . " WHERE `id`='" . (int)$this->id . "'";

        $res = $conn->query($get_sql_query);
        if (!$res) {
            $this->error_msg = $conn->error;
            return false;
        }
        return true;
    }
}
?>
