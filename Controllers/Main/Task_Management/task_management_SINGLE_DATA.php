<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class task_management_SINGLE_DATA
{
    private $id;
    private $task_title;
    private $department;
    private $assigned_employee;
    private $work_mode;
    private $deadline;
    private $priority;
    private $status;
    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM task_management WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id                = $row['id'];
                $this->task_title        = $row['task_title'];
                $this->department        = $row['department'];
                $this->assigned_employee = $row['assigned_employee'];
                $this->work_mode         = $row['work_mode'];
                $this->deadline          = $row['deadline'];
                $this->priority          = $row['priority'];
                $this->status            = $row['status'];
            }
        }
    }

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_task_title()
    {
        return $this->task_title;
    }

    public function get_department()
    {
        return $this->department;
    }

    public function get_assigned_employee()
    {
        return $this->assigned_employee;
    }

    public function get_work_mode()
    {
        return $this->work_mode;
    }

    public function get_deadline()
    {
        return $this->deadline;
    }

    public function get_priority()
    {
        return $this->priority;
    }

    public function get_status()
    {
        return $this->status;
    }

    public function to_array()
    {
        return [
            'id'                => (int)$this->id,
            'task_title'        => $this->task_title,
            'department'        => $this->department,
            'assigned_employee' => $this->assigned_employee,
            'work_mode'         => $this->work_mode,
            'deadline'          => $this->deadline,
            'priority'          => $this->priority,
            'status'            => $this->status
        ];
    }
}
?>
