<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_details_LIST.php';

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // 0. Ensure employee_profiles table exists on the database
    $db->get_result("CREATE TABLE IF NOT EXISTS `employee_profiles` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `full_name` varchar(255) DEFAULT NULL,
        `email` varchar(255) DEFAULT NULL,
        `phone` varchar(50) DEFAULT NULL,
        `department` varchar(100) DEFAULT 'Engineering',
        `job_title` varchar(100) DEFAULT 'Staff',
        `join_date` date DEFAULT NULL,
        `nic` varchar(50) DEFAULT NULL,
        `dob` date DEFAULT NULL,
        `gender` varchar(20) DEFAULT 'Male',
        `address` text DEFAULT NULL,
        `emergency_contact_name` varchar(255) DEFAULT NULL,
        `emergency_contact_phone` varchar(50) DEFAULT NULL,
        `employee_id_code` varchar(50) DEFAULT NULL,
        `employment_type` varchar(50) DEFAULT 'Full-Time (Permanent)',
        `work_location` varchar(100) DEFAULT 'Colombo HQ',
        `work_shift` varchar(100) DEFAULT '08:30 AM – 05:30 PM',
        `working_days` varchar(255) DEFAULT 'Mon,Tue,Wed,Thu,Fri',
        `weekly_roster` text DEFAULT NULL,
        `schedule_start_date` date DEFAULT NULL,
        `schedule_end_date` date DEFAULT NULL,
        `work_mode` varchar(100) DEFAULT 'On-Site (Active)',
        `probation_status` varchar(100) DEFAULT 'In Progress',
        `probation_start_date` date DEFAULT NULL,
        `probation_end_date` date DEFAULT NULL,
        `official_start_date` date DEFAULT NULL,
        `attendance_days` int DEFAULT 0,
        `last_attendance_date` date DEFAULT NULL,
        `profile_pic` varchar(500) DEFAULT NULL,
        `status` varchar(50) DEFAULT 'active',
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $employees = [];
    $seenAccountIds = [];
    $seenEmails = [];
    $seenNames = [];

    $todayDate = date('Y-m-d');
    $todayDay = date('D');

    // 1. Fetch live employee profile(s) from employee_profiles table
    $prof_res = $db->get_result("SELECT * FROM `employee_profiles` ORDER BY `id` ASC");
    if ($prof_res && $prof_res->num_rows > 0) {
        while ($p = $prof_res->fetch_assoc()) {
            $name = !empty($p['full_name']) ? trim($p['full_name']) : '';
            if (empty($name)) continue;

            $initials = '';
            foreach (explode(' ', $name) as $w) {
                if (!empty($w)) $initials .= strtoupper($w[0]);
            }
            $initials = substr($initials, 0, 2) ?: 'EM';

            $dailyWorkMode = 'On-Site (Active)';
            $dailyModeType = 'onsite';

            $safeName = addslashes($name);
            $empIdVal = !empty($p['employee_id']) ? addslashes($p['employee_id']) : (!empty($p['id']) ? addslashes($p['id']) : '');
            
            try {
                $chkLeave = $db->get_result("SELECT id FROM `leave_requests` 
                    WHERE (`employee_name` = '{$safeName}'" . (!empty($empIdVal) ? " OR `employee_id` = '{$empIdVal}'" : "") . ") 
                    AND `status` = 'Approved' 
                    AND '{$todayDate}' BETWEEN `from_date` AND `to_date` 
                    LIMIT 1");

                if ($chkLeave && $chkLeave->num_rows > 0) {
                    $dailyWorkMode = 'On Leave';
                    $dailyModeType = 'leave';
                } else {
                    $roster = ['Mon' => 'onsite', 'Tue' => 'onsite', 'Wed' => 'onsite', 'Thu' => 'onsite', 'Fri' => 'onsite', 'Sat' => 'leave', 'Sun' => 'leave'];
                    if (!empty($p['weekly_roster'])) {
                        $dec = json_decode($p['weekly_roster'], true);
                        if (is_array($dec)) {
                            $roster = array_merge($roster, $dec);
                        }
                    } elseif (!empty($p['working_days'])) {
                        $arr = array_map('trim', explode(',', $p['working_days']));
                        foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $d) {
                            $roster[$d] = in_array($d, $arr) ? 'onsite' : 'leave';
                        }
                    }

                    $todayMode = strtolower($roster[$todayDay] ?? 'onsite');
                    if ($todayMode === 'wfh') {
                        $dailyWorkMode = 'Work From Home (WFH)';
                        $dailyModeType = 'wfh';
                    } elseif ($todayMode === 'leave') {
                        $dailyWorkMode = 'On Leave';
                        $dailyModeType = 'leave';
                    } else {
                        $dailyWorkMode = 'On-Site (Active)';
                        $dailyModeType = 'onsite';
                    }
                }
            } catch (\Throwable $e) {}

            $uId = (int)($p['user_id'] ?? 0);
            $emailVal = !empty($p['email']) ? trim($p['email']) : '';

            if ($uId > 0) $seenAccountIds[$uId] = true;
            if (!empty($emailVal)) $seenEmails[strtolower($emailVal)] = true;
            $seenNames[strtolower($name)] = true;

            $employees[] = [
                'id'              => (int)$p['id'],
                'account_id'      => $uId,
                'initials'        => $initials,
                'name'            => $name,
                'email'           => $emailVal,
                'dept'            => !empty($p['department']) ? $p['department'] : 'Engineering',
                'role'            => !empty($p['job_title']) ? $p['job_title'] : 'Staff',
                'status'          => !empty($p['status']) ? strtolower($p['status']) : 'active',
                'joined'          => !empty($p['join_date']) ? $p['join_date'] : '',
                'phone'           => !empty($p['phone']) ? $p['phone'] : '',
                'nic'             => !empty($p['nic']) ? $p['nic'] : '',
                'dob'             => !empty($p['dob']) ? $p['dob'] : '',
                'gender'          => !empty($p['gender']) ? $p['gender'] : 'Male',
                'address'         => !empty($p['address']) ? $p['address'] : '',
                'profile_pic'     => !empty($p['profile_pic']) ? $p['profile_pic'] : '',
                'emp_code'        => !empty($p['employee_id_code']) ? $p['employee_id_code'] : 'EMP-' . str_pad($p['id'], 3, '0', STR_PAD_LEFT),
                'location'        => !empty($p['work_location']) ? $p['work_location'] : 'Colombo HQ',
                'work_shift'      => !empty($p['work_shift']) ? $p['work_shift'] : '08:30 AM – 05:30 PM',
                'working_days'    => !empty($p['working_days']) ? $p['working_days'] : 'Mon,Tue,Wed,Thu,Fri',
                'weekly_roster'   => !empty($p['weekly_roster']) ? $p['weekly_roster'] : '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}',
                'work_mode'       => $dailyWorkMode,
                'today_work_mode' => $dailyWorkMode,
                'today_mode_type' => $dailyModeType,
                'employment_type' => !empty($p['employment_type']) ? $p['employment_type'] : 'Full-Time (Permanent)',
                'em_name'         => !empty($p['emergency_contact_name']) ? $p['emergency_contact_name'] : '',
                'em_phone'        => !empty($p['emergency_contact_phone']) ? $p['emergency_contact_phone'] : ''
            ];
        }
    }

    // 2. Also check if there are additional rows in companion employees table
    try {
        $chkEmpTable = $db->get_result("SHOW TABLES LIKE 'employees'");
        if ($chkEmpTable && $chkEmpTable->num_rows > 0) {
            $emp_list_obj = new employee_details_LIST();
            $emp_list_obj->filter_by_ast("1");
            $result = $emp_list_obj->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fullname = trim((string)(isset($row['fullname']) ? $row['fullname'] : (isset($row['name']) ? $row['name'] : '')));
                    $email = trim((string)(isset($row['email_address']) ? $row['email_address'] : (isset($row['email']) ? $row['email'] : '')));
                    $uid = (int)($row['main_user_login_id'] ?? 0);

                    if (empty($fullname) && empty($email)) continue;
                    if ($uid > 0 && isset($seenAccountIds[$uid])) continue;
                    if (!empty($email) && isset($seenEmails[strtolower($email)])) continue;
                    if (!empty($fullname) && isset($seenNames[strtolower($fullname)])) continue;

                    if ($uid > 0) $seenAccountIds[$uid] = true;
                    if (!empty($email)) $seenEmails[strtolower($email)] = true;
                    if (!empty($fullname)) $seenNames[strtolower($fullname)] = true;

                    $dept = isset($row['departments']) ? $row['departments'] : (isset($row['department']) ? $row['department'] : 'Engineering');
                    $role = isset($row['job_roles']) ? $row['job_roles'] : (isset($row['job_role']) ? $row['job_role'] : 'Staff');
                    $status = isset($row['status']) ? strtolower($row['status']) : 'active';
                    $joined = isset($row['joined_date']) ? $row['joined_date'] : (isset($row['joined']) ? $row['joined'] : date('Y-m-d'));
                    $phone = isset($row['phone_number']) ? $row['phone_number'] : (isset($row['contact_number']) ? $row['contact_number'] : '');

                    $initials = '';
                    foreach (explode(' ', trim($fullname)) as $w) {
                        if (!empty($w)) $initials .= strtoupper($w[0]);
                    }
                    $initials = substr($initials, 0, 2) ?: 'EM';
                    $empCodeVal = 'EMP-' . str_pad($row['id'] ?? $uid, 3, '0', STR_PAD_LEFT);

                    // Auto-sync into employee_profiles
                    $newProfId = (int)$row['id'];
                    try {
                        $safeFn = addslashes($fullname);
                        $safeEm = addslashes($email);
                        $safePh = addslashes($phone);
                        $safeDp = addslashes($dept);
                        $safeRl = addslashes($role);
                        $db->get_result("INSERT INTO `employee_profiles` (
                            `user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `status`, `join_date`,
                            `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`,
                            `weekly_roster`, `work_mode`, `updated_at`
                        ) VALUES (
                            {$uid}, '{$safeFn}', '{$safeEm}', '{$safePh}', '{$safeDp}', '{$safeRl}', '{$status}', '{$joined}',
                            '{$empCodeVal}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri',
                            '{\"Mon\":\"onsite\",\"Tue\":\"onsite\",\"Wed\":\"onsite\",\"Thu\":\"onsite\",\"Fri\":\"onsite\",\"Sat\":\"leave\",\"Sun\":\"leave\"}', 'On-Site (Active)', NOW()
                        )");
                        $insId = (int)$db->get_id();
                        if ($insId > 0) $newProfId = $insId;
                    } catch (\Throwable $e) {}

                    $employees[] = [
                        'id'              => $newProfId,
                        'account_id'      => $uid,
                        'initials'        => $initials,
                        'name'            => $fullname,
                        'email'           => $email,
                        'dept'            => $dept ?: 'Engineering',
                        'role'            => $role ?: 'Staff',
                        'status'          => $status,
                        'joined'          => $joined,
                        'phone'           => $phone,
                        'nic'             => isset($row['nic_number']) ? $row['nic_number'] : '',
                        'dob'             => isset($row['date_of_birth']) ? $row['date_of_birth'] : '',
                        'gender'          => isset($row['gender']) ? $row['gender'] : 'Male',
                        'address'         => isset($row['address']) ? $row['address'] : '',
                        'profile_pic'     => '',
                        'emp_code'        => $empCodeVal,
                        'location'        => 'Colombo HQ',
                        'work_shift'      => '08:30 AM – 05:30 PM',
                        'working_days'    => 'Mon,Tue,Wed,Thu,Fri',
                        'weekly_roster'   => '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}',
                        'work_mode'       => (date('D') === 'Sat' || date('D') === 'Sun') ? 'On Leave' : 'On-Site (Active)',
                        'today_work_mode' => (date('D') === 'Sat' || date('D') === 'Sun') ? 'On Leave' : 'On-Site (Active)',
                        'today_mode_type' => (date('D') === 'Sat' || date('D') === 'Sun') ? 'leave' : 'onsite',
                        'employment_type' => 'Full-Time (Permanent)',
                        'em_name'         => '',
                        'em_phone'        => ''
                    ];
                }
            }
        }
    } catch (\Throwable $e) {}

    // 3. Include EVERY employee login account from main_user_login (except admin ID 1)
    try {
        $account_res = $db->get_result("SELECT l.id, l.user_name, l.account_active_state, l.ast,
                l.name_show, l.first_name, l.last_name, l.phone_number,
                l.main_user_account_access_level_list_id, l.ac_type,
                a.type_of_access
            FROM `main_user_login` l
            LEFT JOIN `main_user_account_access_level_list` a
                ON a.id = l.main_user_account_access_level_list_id
            WHERE l.id != 1
              AND (
                  LOWER(TRIM(COALESCE(a.type_of_access, ''))) != 'admin'
                  AND LOWER(TRIM(COALESCE(l.ac_type, ''))) != 'admin'
              )
            ORDER BY l.id ASC");

        if ($account_res && $account_res->num_rows > 0) {
            while ($account = $account_res->fetch_assoc()) {
                $u_id = (int)$account['id'];
                $accountEmail = trim((string)($account['user_name'] ?? ''));

                $accountName = trim((string)($account['name_show'] ?? ''));
                if ($accountName === '') {
                    $accountName = trim((string)($account['first_name'] ?? '') . ' ' . (string)($account['last_name'] ?? ''));
                }
                if ($accountName === '') $accountName = $accountEmail ?: 'Employee';

                // Check if already in list
                if ($u_id > 0 && isset($seenAccountIds[$u_id])) continue;
                if (!empty($accountEmail) && isset($seenEmails[strtolower($accountEmail)])) continue;
                if (!empty($accountName) && isset($seenNames[strtolower($accountName)])) continue;

                $seenAccountIds[$u_id] = true;
                if (!empty($accountEmail)) $seenEmails[strtolower($accountEmail)] = true;
                $seenNames[strtolower($accountName)] = true;

                $initials = '';
                foreach (explode(' ', $accountName) as $word) {
                    if ($word !== '') $initials .= strtoupper($word[0]);
                }
                $initials = substr($initials, 0, 2) ?: 'EM';
                $empCodeVal = 'EMP-' . str_pad($u_id, 3, '0', STR_PAD_LEFT);
                $accountActive = $account['account_active_state'] === null || (int)$account['account_active_state'] === 1;
                $default_status = $accountActive ? 'active' : 'inactive';
                $default_roster = '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';
                $userPhone = trim((string)($account['phone_number'] ?? ''));

                $profId = $u_id;
                // Auto-provision profile row in employee_profiles
                try {
                    $safe_u_email = addslashes($accountEmail);
                    $safe_u_name = addslashes($accountName);
                    $safe_u_phone = addslashes($userPhone);
                    $db->get_result("INSERT INTO `employee_profiles` (
                        `user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `status`, `join_date`,
                        `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`,
                        `weekly_roster`, `work_mode`, `updated_at`
                    ) VALUES (
                        {$u_id}, '{$safe_u_name}', '{$safe_u_email}', '{$safe_u_phone}', 'Engineering', 'Staff', '{$default_status}', CURDATE(),
                        '{$empCodeVal}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri',
                        '" . addslashes($default_roster) . "', 'On-Site (Active)', NOW()
                    )");
                    $insId = (int)$db->get_id();
                    if ($insId > 0) $profId = $insId;
                } catch (\Throwable $e) {}

                // Auto-provision in companion employees table if it exists
                try {
                    $chkTable = $db->get_result("SHOW TABLES LIKE 'employees'");
                    if ($chkTable && $chkTable->num_rows > 0) {
                        $chkE = $db->get_result("SELECT id FROM `employees` WHERE `email_address` = '{$safe_u_email}' OR `main_user_login_id` = {$u_id} LIMIT 1");
                        if (!$chkE || $chkE->num_rows === 0) {
                            $nextIdRes = $db->get_result("SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM `employees`");
                            $nextId = ($nextIdRes && $nr = $nextIdRes->fetch_assoc()) ? (int)$nr['next_id'] : $u_id;
                            $db->get_result("INSERT INTO `employees` (
                                `id`, `fullname`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`, `main_user_login_id`,
                                `department_id`, `department_department_name`, `department_department_head`, `department_numbers_of_employees`, `phone_number`
                            ) VALUES (
                                {$nextId}, '{$safe_u_name}', '{$safe_u_email}', 'Engineering', 'Staff', '{$default_status}', CURDATE(), {$u_id},
                                1, 'Engineering', 'Director', '1', '{$safe_u_phone}'
                            )");
                        }
                    }
                } catch (\Throwable $e) {}

                // Auto-provision in bank_details table
                try {
                    $db->get_result("CREATE TABLE IF NOT EXISTS `bank_details` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `user_id` int DEFAULT NULL,
                        `employee_id` varchar(50) DEFAULT NULL,
                        `employee_name` varchar(255) DEFAULT NULL,
                        `bank_name` varchar(100) DEFAULT '',
                        `branch_name` varchar(100) DEFAULT '',
                        `account_number` varchar(100) DEFAULT '',
                        `holder_name` varchar(255) DEFAULT '',
                        `account_type` varchar(50) DEFAULT 'Savings',
                        `routing_number` varchar(50) DEFAULT '',
                        `swift_code` varchar(50) DEFAULT '',
                        `status` varchar(20) DEFAULT 'Active',
                        `ast` tinyint DEFAULT 1,
                        `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

                    $chkB = $db->get_result("SELECT id FROM `bank_details` WHERE `user_id` = {$u_id} OR `employee_id` = '{$empCodeVal}' LIMIT 1");
                    if (!$chkB || $chkB->num_rows === 0) {
                        $db->get_result("INSERT INTO `bank_details` (
                            `user_id`, `employee_id`, `employee_name`, `holder_name`, `status`, `ast`, `sdt`
                        ) VALUES (
                            {$u_id}, '{$empCodeVal}', '{$safe_u_name}', '{$safe_u_name}', 'Active', '1', NOW()
                        )");
                    }
                } catch (\Throwable $e) {}

                $employees[] = [
                    'id'              => $profId,
                    'account_id'      => $u_id,
                    'initials'        => $initials,
                    'name'            => $accountName,
                    'email'           => $accountEmail,
                    'dept'            => 'Engineering',
                    'role'            => 'Staff',
                    'status'          => $default_status,
                    'joined'          => date('Y-m-d'),
                    'phone'           => $userPhone,
                    'nic'             => '',
                    'dob'             => '',
                    'gender'          => 'Male',
                    'address'         => '',
                    'profile_pic'     => '',
                    'emp_code'        => $empCodeVal,
                    'location'        => 'Colombo HQ',
                    'work_shift'      => '08:30 AM – 05:30 PM',
                    'working_days'    => 'Mon,Tue,Wed,Thu,Fri',
                    'weekly_roster'   => $default_roster,
                    'work_mode'       => (date('D') === 'Sat' || date('D') === 'Sun') ? 'On Leave' : 'On-Site (Active)',
                    'today_work_mode' => (date('D') === 'Sat' || date('D') === 'Sun') ? 'On Leave' : 'On-Site (Active)',
                    'today_mode_type' => (date('D') === 'Sat' || date('D') === 'Sun') ? 'leave' : 'onsite',
                    'employment_type' => 'Full-Time (Permanent)',
                    'em_name'         => '',
                    'em_phone'        => ''
                ];
            }
        }
    } catch (\Throwable $e) {}

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'total'  => count($employees),
        'data'   => $employees
    ], JSON_INVALID_UTF8_SUBSTITUTE);
    exit;

} catch (\Throwable $e) {
    ob_end_clean();
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error: ' . $e->getMessage()
    ]);
    exit;
}
?>
