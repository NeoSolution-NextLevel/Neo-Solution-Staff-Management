<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class dashboard_SINGLE_DATA
{
    private $id;
    private $user_id;
    private $total_employees = 0;
    private $active_employees = 0;
    private $pending_tasks = 0;
    private $completed_tasks = 0;
    private $in_progress_tasks = 0;
    private $pending_leaves = 0;
    private $total_departments = 0;
    private $total_job_roles = 0;

    private $user_assigned_tasks = 0;
    private $user_completed_tasks = 0;
    private $user_pending_tasks = 0;
    private $user_leaves_count = 0;

    private $ast = "1";
    private $sdt;
    private $state_of_data = false;

    public function __construct($id = null)
    {
        $this->id = $id;
        $this->user_id = $id;
        $this->sdt = date('Y-m-d H:i:s');

        $data_base_obj = new DataBase();

        // 1. Fetch system-wide employee counts
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total, SUM(CASE WHEN LOWER(status) = 'active' OR status IS NULL THEN 1 ELSE 0 END) AS active_cnt FROM employees");
        if ($res && $row = $res->fetch_assoc()) {
            $this->total_employees = (int)$row['total'];
            $this->active_employees = (int)($row['active_cnt'] ?: $row['total']);
        }

        // 2. Fetch tasks stats
        $res = $data_base_obj->get_result("SELECT 
            SUM(CASE WHEN LOWER(status) = 'pending' THEN 1 ELSE 0 END) AS pending_cnt,
            SUM(CASE WHEN LOWER(status) = 'completed' OR LOWER(status) = 'done' THEN 1 ELSE 0 END) AS completed_cnt,
            SUM(CASE WHEN LOWER(status) = 'in progress' OR LOWER(status) = 'in-progress' THEN 1 ELSE 0 END) AS in_prog_cnt
            FROM task_management");
        if ($res && $row = $res->fetch_assoc()) {
            $this->pending_tasks     = (int)($row['pending_cnt'] ?? 0);
            $this->completed_tasks   = (int)($row['completed_cnt'] ?? 0);
            $this->in_progress_tasks = (int)($row['in_prog_cnt'] ?? 0);
        }

        // 3. Fetch leaves stats
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM leave_requests WHERE actions LIKE '%pending%' OR actions IS NOT NULL");
        if ($res && $row = $res->fetch_assoc()) {
            $this->pending_leaves = (int)$row['total'];
        }

        // 4. Fetch department counts
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM departments WHERE ast='1'");
        if ($res && $row = $res->fetch_assoc()) {
            $this->total_departments = (int)$row['total'];
        }

        // 5. Fetch job roles counts
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM job_roles");
        if ($res && $row = $res->fetch_assoc()) {
            $this->total_job_roles = (int)$row['total'];
        }

        // If a specific user ID is passed, fetch user-specific metrics
        if (!empty($this->user_id)) {
            $user_id_escaped = (int)$this->user_id;
            $res = $data_base_obj->get_result("SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN LOWER(status) = 'completed' OR LOWER(status) = 'done' THEN 1 ELSE 0 END) AS completed_cnt,
                SUM(CASE WHEN LOWER(status) = 'pending' THEN 1 ELSE 0 END) AS pending_cnt
                FROM task_management WHERE assigned_employee = '$user_id_escaped' OR assigned_employee LIKE '%$user_id_escaped%'");
            if ($res && $row = $res->fetch_assoc()) {
                $this->user_assigned_tasks  = (int)$row['total'];
                $this->user_completed_tasks = (int)$row['completed_cnt'];
                $this->user_pending_tasks   = (int)$row['pending_cnt'];
            }
        }

        $this->state_of_data = true;
    }

    // --- Getter methods ---

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_state_of_data()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_total_employees()
    {
        return $this->total_employees;
    }

    public function get_active_employees()
    {
        return $this->active_employees;
    }

    public function get_pending_tasks()
    {
        return $this->pending_tasks;
    }

    public function get_completed_tasks()
    {
        return $this->completed_tasks;
    }

    public function get_in_progress_tasks()
    {
        return $this->in_progress_tasks;
    }

    public function get_pending_leaves()
    {
        return $this->pending_leaves;
    }

    public function get_total_departments()
    {
        return $this->total_departments;
    }

    public function get_total_job_roles()
    {
        return $this->total_job_roles;
    }

    public function get_user_assigned_tasks()
    {
        return $this->user_assigned_tasks;
    }

    public function get_user_completed_tasks()
    {
        return $this->user_completed_tasks;
    }

    public function get_user_pending_tasks()
    {
        return $this->user_pending_tasks;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function to_array()
    {
        return [
            'id'                => $this->id,
            'total_employees'   => $this->total_employees,
            'active_employees'  => $this->active_employees,
            'pending_tasks'     => $this->pending_tasks,
            'completed_tasks'   => $this->completed_tasks,
            'in_progress_tasks' => $this->in_progress_tasks,
            'pending_leaves'    => $this->pending_leaves,
            'total_departments' => $this->total_departments,
            'total_job_roles'   => $this->total_job_roles,
            'state'             => $this->state_of_data
        ];
    }
}

// Backward compatibility class aliases
if (!class_exists('data_SINGLE_DATA')) {
    class data_SINGLE_DATA extends dashboard_SINGLE_DATA {}
}
if (!class_exists('Dashboard_SINGLE_DATA')) {
    class Dashboard_SINGLE_DATA extends dashboard_SINGLE_DATA {}
}
?>
