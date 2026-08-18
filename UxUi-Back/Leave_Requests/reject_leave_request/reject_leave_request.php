<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Leave_Requests/leave_requests_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    $db = new DataBase();
    $leave_info = $db->get_result("SELECT * FROM `leave_requests` WHERE `id` = '$id'");
    $emp_name = "Employee";
    $leave_type = "Annual Leave";
    if ($leave_info && $row = $leave_info->fetch_assoc()) {
        $emp_name = !empty($row['employee_name']) ? $row['employee_name'] : $emp_name;
        $leave_type = !empty($row['leave_type']) ? $row['leave_type'] : $leave_type;
    }

    $leave_obj = new leave_requests_ADD_UPDATE();
    $leave_obj->set_id($id);
    $leave_obj->set_status("Rejected");
    $res = $leave_obj->process_update();

    if ($res) {
        // Trigger notification for Employee
        SystemNotifications::create(
            "Leave Request Rejected",
            "Your $leave_type request was not approved by Admin.",
            "leave_rejected",
            "employee",
            $emp_name
        );

        echo json_encode([
            'status'  => 'success',
            'message' => 'Leave request rejected successfully in database.'
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Failed to reject leave request in database.']);
exit;
?>
