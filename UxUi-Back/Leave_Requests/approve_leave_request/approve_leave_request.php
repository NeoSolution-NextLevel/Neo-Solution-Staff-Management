<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Leave_Requests/leave_requests_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
$admin_comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($id > 0) {
    $db = new DataBase();
    // Get leave details for message
    $leave_info = $db->get_result("SELECT * FROM `leave_requests` WHERE `id` = '$id'");
    $emp_name = "Employee";
    $leave_type = "Annual Leave";
    if ($leave_info && $row = $leave_info->fetch_assoc()) {
        $emp_name = !empty($row['employee_name']) ? $row['employee_name'] : $emp_name;
        $leave_type = !empty($row['leave_type']) ? $row['leave_type'] : $leave_type;
    }

    $leave_obj = new leave_requests_ADD_UPDATE();
    $leave_obj->set_id($id);
    $leave_obj->set_status("Approved");
    $res = $leave_obj->process_update();

    if ($res) {
        // 1. In-app notification for Employee
        SystemNotifications::create(
            "Leave Request Approved",
            "Your $leave_type request has been approved by Admin.",
            "leave_approved",
            "employee",
            $emp_name
        );

        // 2. Email notification to Employee via imports/email/Email_Send.php
        try {
            Email::send_leave_status_notification($id, 'Approved', $admin_comment);
        } catch (Exception $mailEx) {}

        echo json_encode([
            'status'  => 'success',
            'message' => 'Leave request approved successfully in database.'
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Failed to approve leave request in database.']);
exit;
?>
