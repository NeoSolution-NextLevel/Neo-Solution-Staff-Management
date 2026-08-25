<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';

$db = new DataBase();

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
            'deadline'    => $row['deadline'] ? $row['deadline'] : '',
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
