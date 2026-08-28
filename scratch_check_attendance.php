<?php
include_once __DIR__ . '/../../imports/need/DB.php';

$db = new DataBase();
$conn = $db->get_data_base_connction();

if (!$conn) {
    echo "DB Connection Failed\n";
    exit;
}

echo "Testing mark_attendance.php...\n";

// Fetch current attendance
$res = $conn->query("SELECT id, full_name, attendance_days, last_attendance_date, probation_status FROM `employee_profiles` WHERE id=1 LIMIT 1");
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    echo "Current Profile Data: " . json_encode($row) . "\n";
} else {
    echo "No row for id=1\n";
}
