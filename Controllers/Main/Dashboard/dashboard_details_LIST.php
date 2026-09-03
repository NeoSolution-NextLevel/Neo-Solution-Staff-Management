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

    // --- Dynamic KPI Summary purely from Database ---
    public function get_kpi_summary()
    {
        $data_base_obj = new DataBase();

        $stats = [
            'total_employees'   => 0,
            'active_employees'  => 0,
            'inactive_today'    => 0,
            'pending_tasks'     => 0,
            'completed_tasks'   => 0,
            'in_progress_tasks' => 0,
            'pending_leaves'    => 0,
            'total_departments' => 0,
            'total_job_roles'   => 0
        ];

        // 1. Employees Count from employees or main_user_login table
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total, SUM(CASE WHEN LOWER(status) = 'active' OR status = '1' OR status IS NULL THEN 1 ELSE 0 END) AS active_cnt FROM `employees`");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['total_employees'] = (int)($row['total'] ?? 0);
        }
        
        // Fallback to main_user_login if employees table is empty
        if ($stats['total_employees'] === 0) {
            $res_user = $data_base_obj->get_result("SELECT COUNT(*) AS total, SUM(CASE WHEN account_active_state = 1 OR account_active_state IS NULL THEN 1 ELSE 0 END) AS active_cnt FROM `main_user_login`");
            if ($res_user && $row_user = $res_user->fetch_assoc()) {
                $stats['total_employees'] = (int)($row_user['total'] ?? 0);
            }
        }

        // Daily activity is based on a presence row created by the employee portal today.
        $daily = $this->get_daily_active_members();
        $stats['active_employees'] = count($daily);
        $stats['inactive_today'] = max(0, $stats['total_employees'] - $stats['active_employees']);

        // 2. Tasks Count strictly from task_management table
        $res = $data_base_obj->get_result("SELECT 
            SUM(CASE WHEN LOWER(TRIM(status)) = 'pending' THEN 1 ELSE 0 END) AS pending_cnt,
            SUM(CASE WHEN LOWER(TRIM(status)) = 'completed' OR LOWER(TRIM(status)) = 'done' THEN 1 ELSE 0 END) AS completed_cnt,
            SUM(CASE WHEN LOWER(TRIM(status)) = 'in progress' OR LOWER(TRIM(status)) = 'in-progress' OR LOWER(TRIM(status)) = 'inprogress' THEN 1 ELSE 0 END) AS in_prog_cnt
            FROM `task_management`");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['pending_tasks']     = (int)($row['pending_cnt'] ?? 0);
            $stats['completed_tasks']   = (int)($row['completed_cnt'] ?? 0);
            $stats['in_progress_tasks'] = (int)($row['in_prog_cnt'] ?? 0);
        }

        // 3. Leave Requests Count strictly from leave_requests table
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM `leave_requests` WHERE LOWER(TRIM(status)) = 'pending'");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['pending_leaves'] = (int)($row['total'] ?? 0);
        }

        // 4. Departments Count strictly from departments table
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM `departments`");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['total_departments'] = (int)($row['total'] ?? 0);
        }

        // 5. Job Roles Count strictly from job_roles table
        $res = $data_base_obj->get_result("SELECT COUNT(*) AS total FROM `job_roles`");
        if ($res && $row = $res->fetch_assoc()) {
            $stats['total_job_roles'] = (int)($row['total'] ?? 0);
        }

        return $stats;
    }

    public function get_daily_active_members()
    {
        $data_base_obj = new DataBase();
        $members = [];
        $query = "SELECT p.id AS profile_id, p.user_id, p.full_name, p.email, p.department,
                p.job_title, p.profile_pic, d.first_seen_at, d.last_seen_at
            FROM `daily_employee_presence` d
            INNER JOIN `employee_profiles` p ON p.id = d.employee_profile_id
            INNER JOIN `main_user_login` l ON l.id = d.user_id
            INNER JOIN `main_user_account_access_level_list` a
                ON a.id = l.main_user_account_access_level_list_id
            WHERE d.presence_date = CURDATE()
                AND l.account_active_state = 1 AND l.ast = 1
                AND LOWER(a.type_of_access) = 'employee'
            ORDER BY d.last_seen_at DESC, p.full_name ASC";

        $res = $data_base_obj->get_result($query);
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $members[] = [
                    'profile_id' => (int)$row['profile_id'],
                    'user_id' => (int)$row['user_id'],
                    'name' => $row['full_name'] ?? 'Employee',
                    'email' => $row['email'] ?? '',
                    'department' => $row['department'] ?? '',
                    'role' => $row['job_title'] ?? '',
                    'profile_pic' => $row['profile_pic'] ?? '',
                    'first_seen_at' => $row['first_seen_at'] ?? '',
                    'last_seen_at' => $row['last_seen_at'] ?? ''
                ];
            }
        }
        return $members;
    }

    public function get_daily_work_plans()
    {
        $data_base_obj = new DataBase();
        $plans = [];
        $data_base_obj->get_result("CREATE TABLE IF NOT EXISTS `daily_employee_work_plans` (
            `id` int NOT NULL AUTO_INCREMENT, `user_id` int NOT NULL,
            `employee_profile_id` int DEFAULT NULL,
            `employee_name` varchar(255) DEFAULT NULL,
            `department` varchar(150) DEFAULT NULL,
            `job_title` varchar(150) DEFAULT NULL,
            `plan_date` date NOT NULL,
            `plan_text` text NOT NULL, `status` varchar(30) NOT NULL DEFAULT 'submitted',
            `started_at` datetime DEFAULT NULL, `submitted_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL, PRIMARY KEY (`id`),
            UNIQUE KEY `unique_user_plan_date` (`user_id`, `plan_date`), KEY `idx_work_plan_date` (`plan_date`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $today = date('Y-m-d');
        $query = "SELECT w.id, w.user_id, w.plan_text, w.status, w.started_at,
                w.submitted_at, w.updated_at, w.plan_date,
                COALESCE(NULLIF(w.employee_name, ''), NULLIF(p.full_name, ''), NULLIF(e.fullname, ''), NULLIF(l.name_show, ''),
                    NULLIF(CONCAT_WS(' ', l.first_name, l.last_name), ''), l.user_name, 'Employee') AS full_name,
                COALESCE(NULLIF(w.department, ''), NULLIF(p.department, ''), NULLIF(e.departments, ''), '') AS department,
                COALESCE(NULLIF(w.job_title, ''), NULLIF(p.job_title, ''), NULLIF(e.job_roles, ''), '') AS job_title,
                COALESCE(p.id, e.id, w.employee_profile_id, w.user_id) AS profile_id
            FROM `daily_employee_work_plans` w
            LEFT JOIN `employee_profiles` p ON (p.id = w.employee_profile_id OR p.user_id = w.user_id)
            LEFT JOIN `employees` e ON (e.id = w.employee_profile_id OR e.id = w.user_id OR e.main_user_login_id = w.user_id)
            LEFT JOIN `main_user_login` l ON l.id = w.user_id
            WHERE (w.plan_date = '{$today}' OR w.plan_date = CURDATE() OR DATE(w.updated_at) = '{$today}' OR DATE(w.updated_at) = CURDATE())
            GROUP BY w.id
            ORDER BY w.updated_at DESC, w.id DESC";
        $res = $data_base_obj->get_result($query);
        if (!$res || $res->num_rows === 0) {
            $fallbackQuery = "SELECT w.id, w.user_id, w.plan_text, w.status, w.started_at,
                    w.submitted_at, w.updated_at, w.plan_date,
                    COALESCE(NULLIF(w.employee_name, ''), NULLIF(p.full_name, ''), NULLIF(e.fullname, ''), NULLIF(l.name_show, ''),
                        NULLIF(CONCAT_WS(' ', l.first_name, l.last_name), ''), l.user_name, 'Employee') AS full_name,
                    COALESCE(NULLIF(w.department, ''), NULLIF(p.department, ''), NULLIF(e.departments, ''), '') AS department,
                    COALESCE(NULLIF(w.job_title, ''), NULLIF(p.job_title, ''), NULLIF(e.job_roles, ''), '') AS job_title,
                    COALESCE(p.id, e.id, w.employee_profile_id, w.user_id) AS profile_id
                FROM `daily_employee_work_plans` w
                LEFT JOIN `employee_profiles` p ON (p.id = w.employee_profile_id OR p.user_id = w.user_id)
                LEFT JOIN `employees` e ON (e.id = w.employee_profile_id OR e.id = w.user_id OR e.main_user_login_id = w.user_id)
                LEFT JOIN `main_user_login` l ON l.id = w.user_id
                GROUP BY w.id
                ORDER BY w.updated_at DESC, w.id DESC LIMIT 20";
            $res = $data_base_obj->get_result($fallbackQuery);
        }

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $plans[] = [
                    'id' => (int)$row['id'],
                    'profile_id' => (int)$row['profile_id'],
                    'name' => $row['full_name'] ?? 'Employee',
                    'department' => $row['department'] ?? '',
                    'role' => $row['job_title'] ?? '',
                    'plan_text' => $row['plan_text'] ?? '',
                    'status' => $row['status'] ?? 'submitted',
                    'started_at' => $row['started_at'] ?? '',
                    'submitted_at' => $row['submitted_at'] ?? '',
                    'updated_at' => $row['updated_at'] ?? '',
                    'plan_date' => $row['plan_date'] ?? $today
                ];
            }
        }
        return $plans;
    }

    // --- Task Completion Statistics (12 Calendar Months strictly from database) ---
    public function get_task_completion_statistics($months_count = 12)
    {
        $data_base_obj = new DataBase();
        $monthly_data = [];

        $monthsList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $currentYear = date('Y');

        foreach ($monthsList as $idx => $m_str) {
            $m_int = $idx + 1;
            $m_num = str_pad($m_int, 2, '0', STR_PAD_LEFT);

            $query = "SELECT 
                COUNT(*) AS total_tasks,
                SUM(CASE WHEN LOWER(TRIM(status)) = 'completed' OR LOWER(TRIM(status)) = 'done' THEN 1 ELSE 0 END) AS completed_tasks
                FROM `task_management` 
                WHERE (
                    deadline LIKE '%$currentYear-$m_num%' 
                    OR deadline LIKE '%-$m_num-%' 
                    OR deadline LIKE '%/$m_num/%'
                    OR deadline LIKE '%$m_str%'
                    OR ((deadline IS NULL OR deadline = '') AND MONTH(sdt) = $m_int AND YEAR(sdt) = $currentYear)
                )";

            $res = $data_base_obj->get_result($query);

            $light = 0;
            $dark = 0;
            if ($res && $row = $res->fetch_assoc()) {
                $light = (int)($row['total_tasks'] ?? 0);
                $dark = (int)($row['completed_tasks'] ?? 0);
            }

            $monthly_data[] = [
                'm' => $m_str,
                'light' => $light,
                'dark' => $dark
            ];
        }

        return $monthly_data;
    }

    // --- Task Status Distribution purely from database ---
    public function get_task_status_distribution()
    {
        $kpi = $this->get_kpi_summary();

        return [
            ['label' => 'Completed',   'count' => (int)$kpi['completed_tasks'],   'color' => '#12b76a'],
            ['label' => 'In Progress', 'count' => (int)$kpi['in_progress_tasks'], 'color' => '#3b5bdb'],
            ['label' => 'Pending',     'count' => (int)$kpi['pending_tasks'],     'color' => '#f5a623']
        ];
    }

    // --- Department Distribution purely from database tables ---
    public function get_department_distribution()
    {
        $data_base_obj = new DataBase();
        $departments = [];

        // 1. Group employees by department if available
        $res = $data_base_obj->get_result("SELECT departments AS name, COUNT(*) AS count FROM `employees` WHERE departments IS NOT NULL AND departments != '' GROUP BY departments ORDER BY count DESC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $departments[] = [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }
        }

        // 2. Otherwise read from departments table
        if (empty($departments)) {
            $res = $data_base_obj->get_result("SELECT name, employees AS count FROM `departments` ORDER BY id ASC");
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

    // --- Live System Activities purely from database tables ---
    public function get_recent_activities($limit = 10)
    {
        $data_base_obj = new DataBase();
        $activities = [];

        // 1. Try system_notifications table
        $res = $data_base_obj->get_result("SELECT id, title, message, type, created_at FROM `system_notifications` ORDER BY id DESC LIMIT " . (int)$limit);
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $activities[] = [
                    'id'      => (int)$row['id'],
                    'title'   => !empty($row['title']) ? $row['title'] : 'System Notification',
                    'message' => !empty($row['message']) ? $row['message'] : '',
                    'type'    => !empty($row['type']) ? $row['type'] : 'notification',
                    'date'    => !empty($row['created_at']) ? date('M j, H:i', strtotime($row['created_at'])) : date('M j'),
                    'icon'    => 'blue'
                ];
            }
        }

        // 2. Also check audit_trail_report table
        if (count($activities) < $limit) {
            $rem = $limit - count($activities);
            $res_audit = $data_base_obj->get_result("SELECT id, dis, sdt FROM `audit_trail_report` ORDER BY id DESC LIMIT " . (int)$rem);
            if ($res_audit && $res_audit->num_rows > 0) {
                while ($row_a = $res_audit->fetch_assoc()) {
                    $activities[] = [
                        'id'      => (int)$row_a['id'],
                        'title'   => !empty($row_a['dis']) ? $row_a['dis'] : 'Activity Log',
                        'message' => '',
                        'type'    => 'audit',
                        'date'    => !empty($row_a['sdt']) ? date('M j, H:i', strtotime($row_a['sdt'])) : date('M j'),
                        'icon'    => 'blue'
                    ];
                }
            }
        }

        return $activities;
    }

    // --- Full Dashboard Data Payload ---
    public function get_full_dashboard_data()
    {
        return [
            'kpi'           => $this->get_kpi_summary(),
            'active_members'=> $this->get_daily_active_members(),
            'daily_work_plans' => $this->get_daily_work_plans(),
            'monthly_tasks' => $this->get_task_completion_statistics(12),
            'task_status'   => $this->get_task_status_distribution(),
            'departments'   => $this->get_department_distribution(),
            'activities'    => $this->get_recent_activities()
        ];
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT " . $this->sql_process_data .
            " FROM audit_trail_report WHERE 1=1 " .
            $this->sql_search_data .
            $this->pagination_data_result;

        return $data_base_obj->get_result($get_sql_query);
    }
}

// Backward compatibility class aliases
if (!class_exists('dashboard_LIST')) {
    class dashboard_LIST extends dashboard_details_LIST {}
}
?>
