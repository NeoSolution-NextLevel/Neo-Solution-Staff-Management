<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Departments/departments_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

// Auto-heal table columns: ensure departments table has both `head` and `head_name` columns
try {
    $dbInit = new DataBase();
    $conn = $dbInit->get_data_base_connction();
    if ($conn) {
        $colsExisting = [];
        $resCols = @$conn->query("SHOW COLUMNS FROM `departments`");
        if ($resCols) {
            while ($c = $resCols->fetch_assoc()) {
                $colsExisting[strtolower($c['Field'])] = true;
            }
        }
        if (!isset($colsExisting['head'])) {
            @$conn->query("ALTER TABLE `departments` ADD COLUMN `head` varchar(255) DEFAULT '' AFTER `name`");
        }
        if (!isset($colsExisting['head_name'])) {
            @$conn->query("ALTER TABLE `departments` ADD COLUMN `head_name` varchar(255) DEFAULT '' AFTER `name`");
        }
    }
} catch (\Throwable $e) {}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$name      = isset($_POST['name']) ? trim($_POST['name']) : '';
$head      = isset($_POST['head']) && !empty($_POST['head']) ? trim($_POST['head']) : 'Unassigned';
$employees = isset($_POST['employees']) ? (int)$_POST['employees'] : 0;
$color     = isset($_POST['color']) && !empty($_POST['color']) ? strtolower(trim($_POST['color'])) : strtolower(substr($name, 0, 3));

if (empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Department name is required.']);
    exit;
}

$add_obj = new departments_ADD_UPDATE();
$add_obj->set_data($name, $head, $employees, $color);
$res = $add_obj->process_new_record();

if ($res) {
    // Trigger notification for Admin & All
    SystemNotifications::create(
        "Department Created",
        "New department '$name' was created (Head: $head).",
        "department_add",
        "admin"
    );

    echo json_encode([
        'status'  => 'success',
        'message' => 'Department created successfully in database.',
        'data'    => [
            'id'        => (int)$add_obj->get_id(),
            'name'      => $name,
            'head'      => $head,
            'employees' => $employees,
            'color'     => $color
        ]
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $add_obj->get_error()
    ]);
}
exit;
?>
