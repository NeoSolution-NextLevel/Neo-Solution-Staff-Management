<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Leave_Requests/leave_requests_LIST.php';

$list_obj = new leave_requests_LIST();
$res = $list_obj->get_result();
$leaves = [];

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $id = (int)$row['id'];
        $employee = !empty($row['employee_name']) ? $row['employee_name'] : 'Employee #' . $id;
        $type = !empty($row['leave_type']) ? $row['leave_type'] : 'Leave Request';
        $from = !empty($row['from_date']) ? $row['from_date'] : '';
        $to = !empty($row['to_date']) ? $row['to_date'] : $from;
        $days = isset($row['days']) && (int)$row['days'] > 0 ? (int)$row['days'] : 1;
        $reason = !empty($row['reason']) ? $row['reason'] : '';
        $status = !empty($row['status']) ? $row['status'] : 'Pending';
        $submitted = isset($row['sdt']) ? substr($row['sdt'], 0, 10) : (isset($row['created_at']) ? $row['created_at'] : date('Y-m-d'));

        $leaves[] = [
            'id'        => $id,
            'employee'  => $employee,
            'type'      => $type,
            'from'      => $from,
            'to'        => $to,
            'days'      => $days,
            'reason'    => $reason,
            'submitted' => $submitted,
            'status'    => ucfirst(strtolower($status))
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'total'  => count($leaves),
    'data'   => $leaves
]);
exit;
?>
