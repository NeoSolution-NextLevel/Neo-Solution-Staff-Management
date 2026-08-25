<?php
header('Content-Type: application/json; charset=utf-8');

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

        $employees[] = [
            'id'              => (int)$p['id'],
            'initials'        => $initials,
            'name'            => $name,
            'email'           => !empty($p['email']) ? $p['email'] : '',
            'dept'            => !empty($p['department']) ? $p['department'] : '',
            'role'            => !empty($p['job_title']) ? $p['job_title'] : '',
            'status'          => 'active',
            'joined'          => !empty($p['join_date']) ? $p['join_date'] : '',
            'phone'           => !empty($p['phone']) ? $p['phone'] : '',
            'nic'             => !empty($p['nic']) ? $p['nic'] : '',
            'dob'             => !empty($p['dob']) ? $p['dob'] : '',
            'gender'          => !empty($p['gender']) ? $p['gender'] : '',
            'address'         => !empty($p['address']) ? $p['address'] : '',
            'profile_pic'     => !empty($p['profile_pic']) ? $p['profile_pic'] : '',
            'emp_code'        => !empty($p['employee_id_code']) ? $p['employee_id_code'] : 'EMP-' . str_pad($p['id'], 3, '0', STR_PAD_LEFT),
            'location'        => !empty($p['work_location']) ? $p['work_location'] : ''
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
            'location'        => ''
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'total'  => count($employees),
    'data'   => $employees
]);
exit;
?>
