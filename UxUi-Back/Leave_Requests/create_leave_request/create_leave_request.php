<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Leave_Requests/leave_requests_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$employee = isset($_POST['employee']) && !empty($_POST['employee']) ? trim($_POST['employee']) : 'Employee';
$type     = isset($_POST['type']) && !empty($_POST['type']) ? trim($_POST['type']) : 'Annual Leave';
$from     = isset($_POST['from']) && !empty($_POST['from']) ? trim($_POST['from']) : date('Y-m-d');
$to       = isset($_POST['to']) && !empty($_POST['to']) ? trim($_POST['to']) : $from;
$days     = isset($_POST['days']) ? (int)$_POST['days'] : 1;
$reason   = isset($_POST['reason']) ? trim($_POST['reason']) : 'Personal Leave';

if ($days <= 0) $days = 1;

$leave_obj = new leave_requests_ADD_UPDATE();
$leave_obj->set_data("", $employee, $type, $from, $to, $days, $reason, "Pending");
$res = $leave_obj->process_new_record();

if ($res) {
    // Automatically trigger notification for Admin
    SystemNotifications::create(
        "New Leave Request",
        "$employee submitted a $type request for $days day(s) from $from to $to.",
        "leave_request",
        "admin"
    );

    echo json_encode([
        'status'  => 'success',
        'message' => 'Leave request submitted successfully in database.',
        'data'    => [
            'id'        => (int)$leave_obj->get_id(),
            'employee'  => $employee,
            'type'      => $type,
            'from'      => $from,
            'to'        => $to,
            'days'      => $days,
            'reason'    => $reason,
            'submitted' => date('Y-m-d'),
            'status'    => 'Pending'
        ]
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $leave_obj->get_error()
    ]);
}
exit;
?>
