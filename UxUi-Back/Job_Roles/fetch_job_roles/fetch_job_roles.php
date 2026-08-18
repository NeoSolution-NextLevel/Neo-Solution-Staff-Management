<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Job_Roles/job_roles_details_LIST.php';

$db = new DataBase();
$db->get_result("CREATE TABLE IF NOT EXISTS `job_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `departments` varchar(255) NOT NULL,
  `number_of_employees` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$list_obj = new job_roles_details_LIST();
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $list_obj->filter_by_search($_GET['search']);
}

$result = $list_obj->get_result();
$roles = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = [
            'id'        => (int)$row['id'],
            'title'     => $row['job_title'],
            'dept'      => $row['departments'],
            'employees' => (int)$row['number_of_employees']
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'total'  => count($roles),
    'data'   => $roles
]);
exit;
?>
