<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class employee_ADD_UPDATE
{
    private $id = 0;
    private $initials = "";
    private $fullname = "";
    private $email_address = "";
    private $department = "";
    private $job_role = "";
    private $status = "";
    private $joined_date = "";

    private $main_user_login_id = 1;
    private $department_id = 1;
    private $department_department_name = "";
    private $department_department_head = "";
    private $department_numbers_of_employees = "";

    private $sdt;
    private $ast = "1";

    private $error_msg = "";
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date("Y-m-d H:i:s");
        $this->joined_date = date("Y-m-d");
    }

    public function set_id($id)
    {
        $this->id = (int)$id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_data($fullname, $email_address, $department, $job_role, $status, $joined_date)
    {
        $this->set_data($fullname, $email_address, $department, $job_role, $status, $joined_date);
    }

    public function set_data($fullname, $email_address, $department, $job_role, $status, $joined_date)
    {
        $this->fullname      = addslashes($fullname);
        $this->email_address = addslashes($email_address);
        $this->department    = addslashes($department);
        $this->job_role      = addslashes($job_role);
        $this->status        = addslashes($status);
        $this->joined_date   = addslashes($joined_date);

        $this->department_department_name = $this->department;

        if (empty($this->initials)) {
            $this->generate_initials();
        }
    }

    private function generate_initials()
    {
        $words = explode(' ', trim($this->fullname));
        $initials = '';
        foreach ($words as $w) {
            if (!empty($w)) {
                $initials .= strtoupper($w[0]);
            }
        }
        $initials = substr($initials, 0, 2);
        $this->initials = !empty($initials) ? $initials : 'EM';
    }

    public function get_fullname()
    {
        return $this->fullname;
    }

    public function set_fullname($fullname)
    {
        $this->fullname = addslashes($fullname);
        $this->generate_initials();
    }

    public function get_email_address()
    {
        return $this->email_address;
    }

    public function set_email_address($email_address)
    {
        $this->email_address = addslashes($email_address);
    }

    public function get_department()
    {
        return $this->department;
    }

    public function set_department($department)
    {
        $this->department = addslashes($department);
        $this->department_department_name = $this->department;
    }

    public function get_job_role()
    {
        return $this->job_role;
    }

    public function set_job_role($job_role)
    {
        $this->job_role = addslashes($job_role);
    }

    public function get_status()
    {
        return $this->status;
    }

    public function set_status($status)
    {
        $this->status = addslashes($status);
    }

    public function get_joined_date()
    {
        return $this->joined_date;
    }

    public function set_joined_date($joined_date)
    {
        $this->joined_date = addslashes($joined_date);
    }

    public function get_initials()
    {
        return $this->initials;
    }

    public function set_initials($initials)
    {
        $this->initials = addslashes($initials);
    }

    public function remove()
    {
        $this->ast = "0";
    }

    public function get_error()
    {
        return $this->error_msg;
    }

    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        // Detect available columns
        $columns = [];
        $col_res = $data_base_obj->get_result("SHOW COLUMNS FROM employees");
        if ($col_res) {
            while ($c = $col_res->fetch_assoc()) {
                $columns[] = strtolower($c['Field']);
            }
        }

        // Calculate next ID if not provided
        if (empty($this->id) || $this->id == 0) {
            $id_res = $data_base_obj->get_result("SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM employees");
            if ($id_res && $row = $id_res->fetch_assoc()) {
                $this->id = (int)$row['next_id'];
            } else {
                $this->id = 1;
            }
        }

        $fields = [];
        $values = [];

        if (in_array('id', $columns)) {
            $fields[] = '`id`';
            $values[] = "'" . $this->id . "'";
        }
        if (in_array('fullname', $columns)) {
            $fields[] = '`fullname`';
            $values[] = "'" . $this->fullname . "'";
        }
        if (in_array('email_address', $columns)) {
            $fields[] = '`email_address`';
            $values[] = "'" . $this->email_address . "'";
        }
        if (in_array('departments', $columns)) {
            $fields[] = '`departments`';
            $values[] = "'" . $this->department . "'";
        } elseif (in_array('department', $columns)) {
            $fields[] = '`department`';
            $values[] = "'" . $this->department . "'";
        }
        if (in_array('job_roles', $columns)) {
            $fields[] = '`job_roles`';
            $values[] = "'" . $this->job_role . "'";
        } elseif (in_array('job_role', $columns)) {
            $fields[] = '`job_role`';
            $values[] = "'" . $this->job_role . "'";
        }
        if (in_array('status', $columns)) {
            $fields[] = '`status`';
            $values[] = "'" . $this->status . "'";
        }
        if (in_array('joined_date', $columns)) {
            $fields[] = '`joined_date`';
            $values[] = "'" . $this->joined_date . "'";
        }

        if (in_array('main_user_login_id', $columns)) {
            $fields[] = '`main_user_login_id`';
            $values[] = "'" . $this->main_user_login_id . "'";
        }
        if (in_array('department_id', $columns)) {
            $fields[] = '`department_id`';
            $values[] = "'" . $this->department_id . "'";
        }
        if (in_array('department_department_name', $columns)) {
            $fields[] = '`department_department_name`';
            $values[] = "'" . $this->department_department_name . "'";
        }
        if (in_array('department_department_head', $columns)) {
            $fields[] = '`department_department_head`';
            $values[] = "'" . $this->department_department_head . "'";
        }
        if (in_array('department_numbers_of_employees', $columns)) {
            $fields[] = '`department_numbers_of_employees`';
            $values[] = "'" . $this->department_numbers_of_employees . "'";
        }

        if (in_array('initials', $columns)) {
            $fields[] = '`initials`';
            $values[] = "'" . $this->initials . "'";
        }
        if (in_array('sdt', $columns)) {
            $fields[] = '`sdt`';
            $values[] = "'" . $this->sdt . "'";
        }
        if (in_array('ast', $columns)) {
            $fields[] = '`ast`';
            $values[] = "'" . $this->ast . "'";
        }

        $get_sql_query = "INSERT INTO employees (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";

        $res = $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();

        return ($res !== false && empty($this->error_msg));
    }

    public function process_update()
    {
        $obj_database = new DataBase();

        $columns = [];
        $col_res = $obj_database->get_result("SHOW COLUMNS FROM employees");
        if ($col_res) {
            while ($c = $col_res->fetch_assoc()) {
                $columns[] = strtolower($c['Field']);
            }
        }

        if ($this->ast === "0") {
            if (in_array('ast', $columns)) {
                $get_sql_query = "UPDATE employees SET ast = '0' WHERE id = '" . $this->id . "'";
            } else {
                $get_sql_query = "DELETE FROM employees WHERE id = '" . $this->id . "'";
            }
            $res = $obj_database->get_result($get_sql_query);
            $this->error_msg = $obj_database->get_error();
            return ($res !== false && empty($this->error_msg));
        }

        $updates = [];
        if (in_array('fullname', $columns) && !empty($this->fullname)) {
            $updates[] = "`fullname` = '" . $this->fullname . "'";
        }
        if (in_array('email_address', $columns) && !empty($this->email_address)) {
            $updates[] = "`email_address` = '" . $this->email_address . "'";
        }
        if (in_array('departments', $columns) && !empty($this->department)) {
            $updates[] = "`departments` = '" . $this->department . "'";
        } elseif (in_array('department', $columns) && !empty($this->department)) {
            $updates[] = "`department` = '" . $this->department . "'";
        }
        if (in_array('job_roles', $columns) && !empty($this->job_role)) {
            $updates[] = "`job_roles` = '" . $this->job_role . "'";
        } elseif (in_array('job_role', $columns) && !empty($this->job_role)) {
            $updates[] = "`job_role` = '" . $this->job_role . "'";
        }
        if (in_array('status', $columns) && !empty($this->status)) {
            $updates[] = "`status` = '" . $this->status . "'";
        }
        if (in_array('joined_date', $columns) && !empty($this->joined_date)) {
            $updates[] = "`joined_date` = '" . $this->joined_date . "'";
        }
        if (in_array('department_department_name', $columns) && !empty($this->department)) {
            $updates[] = "`department_department_name` = '" . $this->department . "'";
        }

        if (empty($updates)) {
            return true;
        }

        $get_sql_query = "UPDATE employees SET " . implode(", ", $updates) . " WHERE id = '" . $this->id . "'";

        $res = $obj_database->get_result($get_sql_query);
        $this->error_msg = $obj_database->get_error();

        return ($res !== false && empty($this->error_msg));
    }

    public function delete_record()
    {
        $this->remove();
        return $this->process_update();
    }
}

// Backward compatibility class alias
if (!class_exists('data_ADD_UPDATE')) {
    class data_ADD_UPDATE extends employee_ADD_UPDATE {}
}
?>