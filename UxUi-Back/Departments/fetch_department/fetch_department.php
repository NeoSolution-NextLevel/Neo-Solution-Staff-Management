<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Departments/departments_details_LIST.php';

$db = new DataBase();
$db->get_result("CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(150) NOT NULL,
  `head` varchar(150) DEFAULT 'Unassigned',
  `employees` int(11) DEFAULT 0,
  `color` varchar(50) DEFAULT 'blue',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$departments = [];

$dept_list_obj = new departments_details_LIST();
$dept_list_obj->filter_by_ast("1");

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $dept_list_obj->filter_by_search($_GET['search']);
}

$result = $dept_list_obj->get_result();

if ($result && $result->num_rows > 0) {
    $db = new DataBase();

    // Fetch live employee counts per department from employees table if available
    $emp_counts = [];
    $check_emp_table = $db->get_result("SHOW TABLES LIKE 'employees'");
    if ($check_emp_table && $check_emp_table->num_rows > 0) {
        $emp_count_res = $db->get_result("SELECT departments, COUNT(*) as count FROM employees WHERE (ast = '1' OR ast IS NULL) GROUP BY departments");
        if ($emp_count_res) {
            while ($ec = $emp_count_res->fetch_assoc()) {
                if (!empty($ec['departments'])) {
                    $emp_counts[strtolower(trim($ec['departments']))] = (int)$ec['count'];
                }
            }
        }
    }

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
