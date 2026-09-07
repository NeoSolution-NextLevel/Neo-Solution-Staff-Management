<?php
if (!function_exists('sync_job_role_employee_counts')) {
    function sync_job_role_employee_counts($conn) {
        if (!$conn) return;

        // 1. Calculate live employee counts grouped by lowercase department and role from employee_profiles
        $sql = "SELECT LOWER(TRIM(department)) as dept, LOWER(TRIM(job_title)) as role, COUNT(*) as cnt 
                FROM employee_profiles 
                WHERE department IS NOT NULL AND TRIM(department) != '' 
                  AND job_title IS NOT NULL AND TRIM(job_title) != ''
                GROUP BY LOWER(TRIM(department)), LOWER(TRIM(job_title))";
        $res = $conn->query($sql);
        $counts = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $key = $row['dept'] . ':::' . $row['role'];
                $counts[$key] = (int)$row['cnt'];
            }
        }

        // 2. Also account for employees in the legacy/companion `employees` table that aren't duplicate in employee_profiles
        $existing_res = $conn->query("SELECT LOWER(TRIM(email)) as em, LOWER(TRIM(full_name)) as fn FROM employee_profiles");
        $existing = [];
        if ($existing_res) {
            while ($erow = $existing_res->fetch_assoc()) {
                if (!empty($erow['em'])) $existing[$erow['em']] = true;
                if (!empty($erow['fn'])) $existing[$erow['fn']] = true;
            }
        }

        $sql2 = "SELECT LOWER(TRIM(departments)) as dept, LOWER(TRIM(job_roles)) as role, email_address, fullname 
                 FROM employees 
                 WHERE departments IS NOT NULL AND TRIM(departments) != '' 
                   AND job_roles IS NOT NULL AND TRIM(job_roles) != ''";
        $res2 = $conn->query($sql2);
        if ($res2) {
            while ($row2 = $res2->fetch_assoc()) {
                $em = strtolower(trim($row2['email_address'] ?? ''));
                $fn = strtolower(trim($row2['fullname'] ?? ''));
                if ((!empty($em) && isset($existing[$em])) || (!empty($fn) && isset($existing[$fn]))) {
                    continue;
                }
                $key = $row2['dept'] . ':::' . $row2['role'];
                $counts[$key] = ($counts[$key] ?? 0) + 1;
            }
        }

        // 3. Update the job_roles table so its `number_of_employees` column stays synchronized
        $roles_res = $conn->query("SELECT id, departments, job_title FROM job_roles");
        if ($roles_res) {
            while ($r = $roles_res->fetch_assoc()) {
                $r_dept = strtolower(trim($r['departments'] ?? ''));
                $r_title = strtolower(trim($r['job_title'] ?? ''));
                $key = $r_dept . ':::' . $r_title;
                $cnt = isset($counts[$key]) ? (int)$counts[$key] : 0;
                $conn->query("UPDATE job_roles SET number_of_employees = $cnt WHERE id = " . (int)$r['id']);
            }
        }
    }
}
