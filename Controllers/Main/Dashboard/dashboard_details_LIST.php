<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class dashboard_details_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_ast($get_ast)
    {
        $this->ast_state = $get_ast;
        $this->sql_search_data .= " AND ast='" . $this->ast_state . "'";
    }

    public function filter_by_id($get_id)
    {
        $this->sql_search_data .= " AND id='" . (int)$get_id . "'";
    }

    public function filter_by_search($get_search)
    {
        $s = addslashes($get_search);
        $this->sql_search_data .= " AND (dis LIKE '%" . $s . "%')";
    }

    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id)";
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . (int)$start_point . ", " . (int)$per_page_data_count;
    }

    public function remove_list()
    {
        $this->ast_state = "0";
    }

    // --- Dynamic KPI Summary from Database ---
    public function get_kpi_summary()
    {
        $data_base_obj = new DataBase();

        $stats = [
            'total_employees'   => 0,
            'active_employees'  => 0,
            'pending_tasks'     => 0,
            'completed_tasks'   => 0,
            'in_progress_tasks' => 0,
            'pending_leaves'    => 0,
            'total_departments' => 0,
            'total_job_roles'   => 0
        ];

        // 1. Employees Count from database
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total, SUM(CASE WHEN LOWER(status) = 'active' OR status IS NULL THEN 1 ELSE 0 END) AS active_cnt FROM employees");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['total_employees'] = (int)$row['total'];
            $stats['active_employees'] = (int)($row['active_cnt'] ?: $row['total']);
        }

        // 2. Tasks Count from database
        $res = $data_base_obj->get_result("SELECT 
            SUM(CASE WHEN LOWER(status) = 'pending' THEN 1 ELSE 0 END) AS pending_cnt,
            SUM(CASE WHEN LOWER(status) = 'completed' OR LOWER(status) = 'done' THEN 1 ELSE 0 END) AS completed_cnt,
            SUM(CASE WHEN LOWER(status) = 'in progress' OR LOWER(status) = 'in-progress' OR LOWER(status) = 'inprogress' THEN 1 ELSE 0 END) AS in_prog_cnt
            FROM task_management");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['pending_tasks']     = (int)($row['pending_cnt'] ?? 0);
            $stats['completed_tasks']   = (int)($row['completed_cnt'] ?? 0);
            $stats['in_progress_tasks'] = (int)($row['in_prog_cnt'] ?? 0);
        }

        // 3. Leave Requests Count from database
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM leave_requests WHERE (actions LIKE '%pending%' OR actions LIKE '%Pending%' OR actions IS NOT NULL)");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['pending_leaves'] = (int)$row['total'];
        }

        // 4. Departments Count from database
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM departments WHERE ast='1'");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['total_departments'] = (int)$row['total'];
        }

        // 5. Job Roles Count from database
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM job_roles");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['total_job_roles'] = (int)$row['total'];
        }

        return $stats;
    }

    // --- Task Statistics (Calculated dynamically from database) ---
    public function get_task_completion_statistics($months_count = 6)
    {
        $data_base_obj = new DataBase();
        $monthly_data = [];

        // Build last N months list dynamically
        for ($i = $months_count - 1; $i >= 0; $i--) {
            $m_str = date('M', strtotime("-$i months"));
            $m_num = date('m', strtotime("-$i months"));
            $y_num = date('Y', strtotime("-$i months"));

            $res = $data_base_obj->get_result("SELECT 
                COUNT(*) AS total_tasks,
                SUM(CASE WHEN LOWER(status) = 'completed' OR LOWER(status) = 'done' THEN 1 ELSE 0 END) AS completed_tasks
                FROM task_management 
                WHERE (deadline LIKE '%$m_str%' OR deadline LIKE '%-$m_num-%' OR deadline LIKE '%$y_num-$m_num%')");

            $light = 0;
            $dark = 0;
            if ($res && $row = $res->fetch_assoc()) {
                $light = (int)$row['total_tasks'];
                $dark = (int)$row['completed_tasks'];
            }

            $monthly_data[] = [
                'm' => $m_str,
                'light' => $light,
                'dark' => $dark
            ];
        }

        return $monthly_data;
    }

    // --- Task Status Distribution (Dynamically from database) ---
    public function get_task_status_distribution()
    {
        $kpi = $this->get_kpi_summary();

        return [
            ['label' => 'Completed',   'count' => (int)$kpi['completed_tasks'],   'color' => '#12b76a'],
            ['label' => 'In Progress', 'count' => (int)$kpi['in_progress_tasks'], 'color' => '#3b5bdb'],
            ['label' => 'Pending',     'count' => (int)$kpi['pending_tasks'],     'color' => '#f5a623']
        ];
    }

    // --- Department Distribution (Dynamically from database) ---
    public function get_department_distribution()
    {
        $data_base_obj = new DataBase();
        $departments = [];

        // Check if employees table has department grouping
        $res = $data_base_obj->get_result("SELECT departments AS name, COUNT(*) AS count FROM employees WHERE departments IS NOT NULL AND departments != '' GROUP BY departments ORDER BY count DESC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $departments[] = [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }
        }

        // Also check departments table
        if (empty($departments)) {
            $res = $data_base_obj->get_result("SELECT name, employees AS count FROM departments WHERE ast='1' ORDER BY id ASC");
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $departments[] = [
                        'name' => $row['name'],
                        'count' => (int)$row['count']
                    ];
                }
            }
        }

        return $departments;
    }

    // --- Recent Activities Stream (Dynamically from audit_trail_report database table) ---
    public function get_recent_activities($limit = 10)
    {
        $data_base_obj = new DataBase();
        $activities = [];

        $res = $data_base_obj->get_result("SELECT * FROM audit_trail_report WHERE ast='1' ORDER BY id DESC LIMIT " . (int)$limit);
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $activities[] = [
                    'id' => (int)$row['id'],
                    'title' => $row['dis'],
                    'date' => !empty($row['sdt']) ? date('M j', strtotime($row['sdt'])) : date('M j'),
                    'icon' => 'blue'
                ];
            }
        }

        return $activities;
    }

    // --- Full Dashboard Data Payload ---
    public function get_full_dashboard_data()
    {
        return [
            'kpi' => $this->get_kpi_summary(),
            'monthly_tasks' => $this->get_task_completion_statistics(),
            'task_status' => $this->get_task_status_distribution(),
            'departments' => $this->get_department_distribution(),
            'activities' => $this->get_recent_activities()
        ];
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT " . $this->sql_process_data .
            " FROM audit_trail_report WHERE ast='" . $this->ast_state . "'" .
            $this->sql_search_data .
            $this->pagination_data_result;

        return $data_base_obj->get_result($get_sql_query);
    }
}

// Backward compatibility class aliases
if (!class_exists('dashboard_LIST')) {
    class dashboard_LIST extends dashboard_details_LIST {}
}
if (!class_exists('Dashboard_details_LIST')) {
    class Dashboard_details_LIST extends dashboard_details_LIST {}
}
if (!class_exists('Dashboard_LIST')) {
    class Dashboard_LIST extends dashboard_details_LIST {}
}
?>
