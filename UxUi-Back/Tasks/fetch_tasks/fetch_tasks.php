<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

// Ensure system_tasks table exists
$db->get_result("CREATE TABLE IF NOT EXISTS `system_tasks` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` text DEFAULT '',
    `department` varchar(100) DEFAULT '',
    `assigned_to` varchar(255) DEFAULT '',
    `mode` varchar(50) DEFAULT 'Online',
    `priority` varchar(50) DEFAULT 'Medium',
    `status` varchar(50) DEFAULT 'Pending',
    `deadline` date DEFAULT NULL,
    `progress` int(11) DEFAULT 0,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$where = " WHERE 1=1 ";
if (isset($_GET['employee']) && !empty($_GET['employee'])) {
    $where .= " AND `assigned_to` = '" . addslashes($_GET['employee']) . "' ";
}
if (isset($_GET['department']) && !empty($_GET['department']) && $_GET['department'] !== 'All') {
    $where .= " AND `department` = '" . addslashes($_GET['department']) . "' ";
}
if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] !== 'All') {
    $where .= " AND `status` = '" . addslashes($_GET['status']) . "' ";
}

$sql = "SELECT * FROM `system_tasks` " . $where . " ORDER BY `id` DESC";
$result = $db->get_result($sql);

$tasks = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            'id'          => (int)$row['id'],
            'title'       => $row['title'],
            'description' => $row['description'],
            'dept'        => $row['department'],
            'department'  => $row['department'],
            'employee'    => $row['assigned_to'],
            'assigned_to' => $row['assigned_to'],
            'mode'        => $row['mode'],
            'priority'    => $row['priority'],
            'status'      => $row['status'],
            'deadline'    => $row['deadline'] ? $row['deadline'] : date('Y-m-d'),
            'progress'    => (int)$row['progress'],
            'created_at'  => $row['created_at']
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'total'  => count($tasks),
    'data'   => $tasks
]);
exit;
?>
