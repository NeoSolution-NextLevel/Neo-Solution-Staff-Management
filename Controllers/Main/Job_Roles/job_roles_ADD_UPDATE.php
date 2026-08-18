<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class job_roles_ADD_UPDATE
{
    private $id;
    private $job_title;
    private $departments;
    private $number_of_employees = 0;
    private $ast = "1";
    private $sdt;
    private $error_msg = "";
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_id($id)
    {
        $this->id = (int)$id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_data($job_title, $departments, $number_of_employees = 0)
    {
        $this->set_data($job_title, $departments, $number_of_employees);
    }

    public function set_data($job_title, $departments, $number_of_employees = 0)
    {
        $this->job_title = addslashes($job_title);
        $this->departments = addslashes($departments);
        $this->number_of_employees = (int)$number_of_employees;

        $this->sql_update_query .=
            ", job_title='" . $this->job_title . "'" .
            ", departments='" . $this->departments . "'" .
            ", number_of_employees='" . $this->number_of_employees . "'";
    }

    public function get_job_title()
    {
        return $this->job_title;
    }

    public function set_job_title($job_title)
    {
        $this->job_title = addslashes($job_title);
        $this->sql_update_query .= ", job_title='" . $this->job_title . "'";
    }

    public function get_departments()
    {
        return $this->departments;
    }

    public function set_departments($departments)
    {
        $this->departments = addslashes($departments);
        $this->sql_update_query .= ", departments='" . $this->departments . "'";
    }

    public function get_number_of_employees()
    {
        return $this->number_of_employees;
    }

    public function set_number_of_employees($number_of_employees)
    {
        $this->number_of_employees = (int)$number_of_employees;
        $this->sql_update_query .= ", number_of_employees='" . $this->number_of_employees . "'";
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

        if (empty($this->id) || $this->id == 0) {
            $id_res = $data_base_obj->get_result("SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM job_roles");
            if ($id_res && $row = $id_res->fetch_assoc()) {
                $this->id = (int)$row['next_id'];
            } else {
                $this->id = 1;
            }
        }

        $get_sql_query = "
            INSERT INTO job_roles (
                id,
                job_title, 
                departments, 
                number_of_employees
            )
            VALUES (
                '" . $this->id . "',
                '" . $this->job_title . "',
                '" . $this->departments . "',
                '" . $this->number_of_employees . "'
            )";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();

        if ($this->ast == "0") {
            $get_sql_query = "DELETE FROM job_roles WHERE id='" . $this->id . "'";
        } else {
            $update_part = ltrim($this->sql_update_query, ',');
            if (empty($update_part)) {
                $update_part = "job_title='" . $this->job_title . "', departments='" . $this->departments . "', number_of_employees='" . $this->number_of_employees . "'";
            }
            $get_sql_query = "UPDATE job_roles SET " . $update_part . " WHERE id='" . $this->id . "'";
        }

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}

// Backward compatibility class aliases
if (!class_exists('data_ADD_UPDATE')) {
    class data_ADD_UPDATE extends job_roles_ADD_UPDATE {}
}
?>