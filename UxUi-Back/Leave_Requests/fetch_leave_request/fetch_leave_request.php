<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Leave_Requests/leave_requests_LIST.php';

$session_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
if ($session_user_id === 0 || !empty($_SESSION['otp_pending'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
    exit;
}

$user_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$access_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;
$is_admin = ($user_role === 'admin' || $access_level === 1 || ($session_user_id === 1 && empty($_SESSION['admin_impersonating'])));

$list_obj = new leave_requests_LIST();
if (!$is_admin) {
    $current_user = get_current_logged_user_info();
    $employee_id = !empty($current_user['emp_code']) ? $current_user['emp_code'] : '';
    $employee_name = !empty($current_user['full_name']) && $current_user['full_name'] !== 'Guest'
        ? $current_user['full_name']
        : '';
    $list_obj->filter_for_employee($employee_id, $employee_name);
}

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

// Ensure leave requests are always returned newest first (newest at the top, oldest at the bottom)
usort($leaves, function ($a, $b) {
    return (int)$b['id'] - (int)$a['id'];
});

echo json_encode([
    'status' => 'success',
    'total'  => count($leaves),
    'data'   => $leaves
]);
exit;
?>
