<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/DB.php';
    include_once __DIR__ . '/../../../Controllers/Main/Employees/employee_details_LIST.php';

    $db = new DataBase();
$employees = [];

// 1. Fetch live employee profile(s) from employee_profiles table
$prof_res = $db->get_result("SELECT * FROM `employee_profiles` ORDER BY `id` ASC");
if ($prof_res && $prof_res->num_rows > 0) {
    while ($p = $prof_res->fetch_assoc()) {
        $name = !empty($p['full_name']) ? $p['full_name'] : '';
        if (empty($name)) continue;
        $initials = '';
        foreach (explode(' ', trim($name)) as $w) {
            if (!empty($w)) $initials .= strtoupper($w[0]);
        }
        $initials = substr($initials, 0, 2) ?: 'EM';

        $todayDate = date('Y-m-d');
        $todayDay = date('D');
        $dailyWorkMode = 'On-Site (Active)';
        $dailyModeType = 'onsite';

        $safeName = addslashes($name);
        $empIdVal = !empty($p['employee_id']) ? addslashes($p['employee_id']) : (!empty($p['id']) ? addslashes($p['id']) : '');
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

        $employees[] = [
            'id'              => (int)$p['id'],
            'account_id'      => (int)($p['user_id'] ?? 0),
            'initials'        => $initials,
            'name'            => $name,
            'email'           => !empty($p['email']) ? $p['email'] : '',
            'dept'            => !empty($p['department']) ? $p['department'] : 'Engineering',
            'role'            => !empty($p['job_title']) ? $p['job_title'] : 'Staff',
            'status'          => !empty($p['status']) ? strtolower($p['status']) : 'active',
            'joined'          => !empty($p['join_date']) ? $p['join_date'] : '',
            'phone'           => !empty($p['phone']) ? $p['phone'] : '',
            'nic'             => !empty($p['nic']) ? $p['nic'] : '',
            'dob'             => !empty($p['dob']) ? $p['dob'] : '',
            'gender'          => !empty($p['gender']) ? $p['gender'] : '',
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

// 2. Also check if there are additional rows in employees table
$emp_list_obj = new employee_details_LIST();
$emp_list_obj->filter_by_ast("1");
$result = $emp_list_obj->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullname = isset($row['fullname']) ? $row['fullname'] : (isset($row['name']) ? $row['name'] : '');
        $email = isset($row['email_address']) ? $row['email_address'] : (isset($row['email']) ? $row['email'] : '');
        
        // Avoid duplicate if email matches
        $exists = false;
        foreach ($employees as $ex) {
            if ((!empty($email) && strtolower($ex['email']) === strtolower($email)) || (!empty($fullname) && strtolower($ex['name']) === strtolower($fullname))) {
                $exists = true;
                break;
            }
        }
        if ($exists) continue;

        $dept = isset($row['departments']) ? $row['departments'] : (isset($row['department']) ? $row['department'] : '');
        $role = isset($row['job_roles']) ? $row['job_roles'] : (isset($row['job_role']) ? $row['job_role'] : '');
        $status = isset($row['status']) ? strtolower($row['status']) : 'active';
        $joined = isset($row['joined_date']) ? $row['joined_date'] : (isset($row['joined']) ? $row['joined'] : '');

        $initials = '';
        foreach (explode(' ', trim($fullname)) as $w) {
            if (!empty($w)) $initials .= strtoupper($w[0]);
        }
        $initials = substr($initials, 0, 2) ?: 'EM';

        $employees[] = [
            'id'              => (int)$row['id'],
            'initials'        => $initials,
            'name'            => $fullname,
            'email'           => $email,
            'dept'            => $dept,
            'role'            => $role,
            'status'          => $status,
            'joined'          => $joined,
            'phone'           => isset($row['contact_number']) ? $row['contact_number'] : '',
            'nic'             => isset($row['nic_number']) ? $row['nic_number'] : '',
            'dob'             => isset($row['date_of_birth']) ? $row['date_of_birth'] : '',
            'gender'          => isset($row['gender']) ? $row['gender'] : '',
            'address'         => isset($row['address']) ? $row['address'] : '',
            'profile_pic'     => '',
            'emp_code'        => 'EMP-' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
            'location'        => '',
            'work_shift'      => '08:30 AM – 05:30 PM',
            'working_days'    => 'Mon,Tue,Wed,Thu,Fri',
            'weekly_roster'   => '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"wfh","Sat":"leave","Sun":"leave"}',
            'employment_type' => 'Full-Time',
            'em_name'         => '',
            'em_phone'        => ''
        ];
    }
}

// 3. Include every employee login account, including accounts without a profile yet.
$account_res = $db->get_result("SELECT l.id, l.user_name, l.account_active_state, l.ast,
        l.name_show, l.first_name, l.last_name, l.phone_number,
        l.main_user_account_access_level_list_id
    FROM `main_user_login` l
    INNER JOIN `main_user_account_access_level_list` a
        ON a.id = l.main_user_account_access_level_list_id
    WHERE LOWER(a.type_of_access) = 'employee'
    ORDER BY l.id ASC");

if ($account_res && $account_res->num_rows > 0) {
    while ($account = $account_res->fetch_assoc()) {
        $accountName = trim((string)($account['name_show'] ?? ''));
        if ($accountName === '') {
            $accountName = trim((string)($account['first_name'] ?? '') . ' ' . (string)($account['last_name'] ?? ''));
        }
        if ($accountName === '') $accountName = (string)($account['user_name'] ?? 'Employee');
        $accountEmail = (string)($account['user_name'] ?? '');

        // Existing profile/employee rows are already displayed above.
        $exists = false;
        foreach ($employees as $employee) {
            if ((int)($employee['account_id'] ?? 0) === (int)$account['id'] ||
                ((int)($employee['account_id'] ?? 0) === 0 &&
                    ((!empty($accountEmail) && strtolower($employee['email']) === strtolower($accountEmail)) ||
                    (!empty($accountName) && strtolower($employee['name']) === strtolower($accountName))))) {
                $exists = true;
                break;
            }
        }
        if ($exists) continue;

        $initials = '';
        foreach (explode(' ', $accountName) as $word) {
            if ($word !== '') $initials .= strtoupper($word[0]);
        }
        $initials = substr($initials, 0, 2) ?: 'EM';
        $u_id = (int)$account['id'];
        $safe_u_email = addslashes($accountEmail);
        $safe_u_name = addslashes($accountName);
        $empCodeVal = 'EMP-' . str_pad($u_id, 3, '0', STR_PAD_LEFT);
        $accountActive = $account['account_active_state'] === null || (int)$account['account_active_state'] === 1;
        $default_status = $accountActive ? 'active' : 'inactive';
        $default_roster = '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';

        // Auto-provision profile row in employee_profiles
        $db->get_result("INSERT INTO `employee_profiles` (
            `user_id`, `full_name`, `email`, `department`, `job_title`, `status`, `join_date`,
            `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`,
            `weekly_roster`, `work_mode`, `updated_at`
        ) VALUES (
            {$u_id}, '{$safe_u_name}', '{$safe_u_email}', 'Engineering', 'Staff', '{$default_status}', CURDATE(),
            '{$empCodeVal}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri',
            '" . addslashes($default_roster) . "', 'On-Site (Active)', NOW()
        )");
        $profId = (int)$db->get_id();
        if ($profId <= 0) $profId = $u_id;

        // Auto-provision in employees table
        $chkE = $db->get_result("SELECT id FROM `employees` WHERE `email_address` = '{$safe_u_email}' OR `main_user_login_id` = {$u_id} LIMIT 1");
        if (!$chkE || $chkE->num_rows === 0) {
            $db->get_result("INSERT INTO `employees` (
                `fullname`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`, `main_user_login_id`
            ) VALUES (
                '{$safe_u_name}', '{$safe_u_email}', 'Engineering', 'Staff', '{$default_status}', CURDATE(), {$u_id}
            )");
        }

        // Auto-provision in bank_details table
        $chkB = $db->get_result("SELECT id FROM `bank_details` WHERE `user_id` = {$u_id} OR `employee_id` = '{$empCodeVal}' LIMIT 1");
        if (!$chkB || $chkB->num_rows === 0) {
            $db->get_result("INSERT INTO `bank_details` (
                `user_id`, `employee_id`, `employee_name`, `holder_name`, `status`, `ast`, `sdt`
            ) VALUES (
                {$u_id}, '{$empCodeVal}', '{$safe_u_name}', '{$safe_u_name}', 'Active', '1', NOW()
            )");
        }

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
            'phone'           => (string)($account['phone_number'] ?? ''),
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
