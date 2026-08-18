<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class task_management_ADD_UPDATE
{
    private $id;
    private $task_title;
    private $department;
    private $assigned_employee;
    private $work_mode = "Onsite";
    private $deadline;
    private $priority = "Medium";
    private $status = "Pending";
    private $ast = "1";
    private $error_msg = "";
    private $sql_update_query = "";

    public function __construct()
    {
    }

    public function set_id($id)
    {
        $this->id = (int)$id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_data(
        $task_title,
        $department,
        $assigned_employee,
        $work_mode = "Onsite",
        $deadline = "",
        $priority = "Medium",
        $status = "Pending"
    ) {
        $this->task_title        = addslashes($task_title);
        $this->department        = addslashes($department);
        $this->assigned_employee = addslashes($assigned_employee);
        $this->work_mode         = addslashes($work_mode);
        $this->deadline          = addslashes($deadline);
        $this->priority          = addslashes($priority);
        $this->status            = addslashes($status);

        $this->sql_update_query .=
            ", task_title='" . $this->task_title . "'" .
            ", department='" . $this->department . "'" .
            ", assigned_employee='" . $this->assigned_employee . "'" .
            ", work_mode='" . $this->work_mode . "'" .
            ", deadline='" . $this->deadline . "'" .
            ", priority='" . $this->priority . "'" .
            ", status='" . $this->status . "'";
    }

    public function set_task_title($task_title)
    {
        $this->task_title = addslashes($task_title);
        $this->sql_update_query .= ", task_title='" . $this->task_title . "'";
    }

    public function set_department($department)
    {
        $this->department = addslashes($department);
        $this->sql_update_query .= ", department='" . $this->department . "'";
    }

    public function set_assigned_employee($assigned_employee)
    {
        $this->assigned_employee = addslashes($assigned_employee);
        $this->sql_update_query .= ", assigned_employee='" . $this->assigned_employee . "'";
    }

    public function set_work_mode($work_mode)
    {
        $this->work_mode = addslashes($work_mode);
        $this->sql_update_query .= ", work_mode='" . $this->work_mode . "'";
    }

    public function set_deadline($deadline)
    {
        $this->deadline = addslashes($deadline);
        $this->sql_update_query .= ", deadline='" . $this->deadline . "'";
    }

    public function set_priority($priority)
    {
        $this->priority = addslashes($priority);
        $this->sql_update_query .= ", priority='" . $this->priority . "'";
    }

    public function set_status($status)
    {
        $this->status = addslashes($status);
        $this->sql_update_query .= ", status='" . $this->status . "'";
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
            $id_res = $data_base_obj->get_result("SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM task_management");
            if ($id_res && $row = $id_res->fetch_assoc()) {
                $this->id = (int)$row['next_id'];
            } else {
                $this->id = 1;
            }
        }

        $get_sql_query = "
            INSERT INTO task_management (
                id,
                task_title, 
                department, 
                assigned_employee,
                work_mode,
                deadline,
                priority,
                status
            )
            VALUES (
                '" . $this->id . "',
                '" . $this->task_title . "',
                '" . $this->department . "',
                '" . $this->assigned_employee . "',
                '" . $this->work_mode . "',
                '" . $this->deadline . "',
                '" . $this->priority . "',
                '" . $this->status . "'
            )";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();

        if ($this->ast == "0") {
            $get_sql_query = "DELETE FROM task_management WHERE id='" . $this->id . "'";
        } else {
            $update_part = ltrim($this->sql_update_query, ',');
            if (empty($update_part)) {
                $update_part = "task_title='" . $this->task_title . "', department='" . $this->department . "', assigned_employee='" . $this->assigned_employee . "', work_mode='" . $this->work_mode . "', deadline='" . $this->deadline . "', priority='" . $this->priority . "', status='" . $this->status . "'";
            }
            $get_sql_query = "UPDATE task_management SET " . $update_part . " WHERE id='" . $this->id . "'";
        }

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}

// Backward compatibility class aliases
if (!class_exists('data_ADD_UPDATE')) {
    class data_ADD_UPDATE extends task_management_ADD_UPDATE {}
}
?>
