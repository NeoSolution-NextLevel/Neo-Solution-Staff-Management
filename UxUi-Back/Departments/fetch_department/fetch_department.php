<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Departments/departments_details_LIST.php';

$departments = [];

$dept_list_obj = new departments_details_LIST();
$dept_list_obj->filter_by_ast("1");

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $dept_list_obj->filter_by_search($_GET['search']);
}

$result = $dept_list_obj->get_result();

if ($result && $result->num_rows > 0) {
    $db = new DataBase();

    // Fetch live employee counts per department
    $emp_counts = [];

    // 1. Check employee_profiles table (main profiles table)
    try {
        $check_prof_table = $db->get_result("SHOW TABLES LIKE 'employee_profiles'");
        if ($check_prof_table && $check_prof_table->num_rows > 0) {
            $prof_res = $db->get_result("SELECT `department`, COUNT(*) as count FROM `employee_profiles` WHERE `department` IS NOT NULL AND TRIM(`department`) != '' GROUP BY `department`");
            if ($prof_res && $prof_res->num_rows > 0) {
                while ($pr = $prof_res->fetch_assoc()) {
                    if (!empty($pr['department'])) {
                        $k = strtolower(trim($pr['department']));
                        $emp_counts[$k] = (int)$pr['count'];
                    }
                }
            }
        }
    } catch (\Throwable $e) {}

    // 2. Check employees table (fallback or legacy table)
    try {
        $check_emp_table = $db->get_result("SHOW TABLES LIKE 'employees'");
        if ($check_emp_table && $check_emp_table->num_rows > 0) {
            $col_res = $db->get_result("SHOW COLUMNS FROM `employees`");
            $emp_cols = [];
            if ($col_res && $col_res->num_rows > 0) {
                while ($c = $col_res->fetch_assoc()) {
                    $emp_cols[] = strtolower($c['Field']);
                }
            }
            $dept_col = in_array('department', $emp_cols) ? 'department' : (in_array('departments', $emp_cols) ? 'departments' : '');
            if (!empty($dept_col)) {
                $has_ast = in_array('ast', $emp_cols);
                $where_ast = $has_ast ? "WHERE (ast = '1' OR ast IS NULL)" : "";
                $emp_count_res = $db->get_result("SELECT `{$dept_col}`, COUNT(*) as count FROM `employees` {$where_ast} GROUP BY `{$dept_col}`");
                if ($emp_count_res && $emp_count_res->num_rows > 0) {
                    while ($ec = $emp_count_res->fetch_assoc()) {
                        if (!empty($ec[$dept_col])) {
                            $k = strtolower(trim($ec[$dept_col]));
                            if (!isset($emp_counts[$k])) {
                                $emp_counts[$k] = (int)$ec['count'];
                            }
                        }
                    }
                }
            }
        }
    } catch (\Throwable $e) {}

    while ($row = $result->fetch_assoc()) {
        $id        = (int)$row['id'];
        $name      = isset($row['name']) ? $row['name'] : '';
        $head      = isset($row['head']) && !empty($row['head']) ? $row['head'] : 'Unassigned';
        $color     = isset($row['color']) && !empty($row['color']) ? $row['color'] : strtolower(substr($name, 0, 3));
        
        $dept_key = strtolower(trim($name));
        $emp_count = isset($emp_counts[$dept_key]) ? $emp_counts[$dept_key] : (isset($row['employees']) ? (int)$row['employees'] : 0);

        $departments[] = [
            'id'        => $id,
            'name'      => $name,
            'head'      => $head,
            'employees' => $emp_count,
            'color'     => $color
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'total'  => count($departments),
    'data'   => $departments
]);
exit;
?>
