<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$db = new DataBase();

$userId   = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;
if ($userId <= 0) $userId = 1;

$fullName   = isset($_POST['full_name']) ? trim($_POST['full_name']) : (isset($_POST['name']) ? trim($_POST['name']) : '');
$email      = isset($_POST['email']) ? trim($_POST['email']) : (isset($_POST['email_address']) ? trim($_POST['email_address']) : '');
$phone      = isset($_POST['phone']) ? trim($_POST['phone']) : (isset($_POST['contact_number']) ? trim($_POST['contact_number']) : '');
$dept       = isset($_POST['dept']) ? trim($_POST['dept']) : (isset($_POST['department']) ? trim($_POST['department']) : '');
$role       = isset($_POST['role']) ? trim($_POST['role']) : (isset($_POST['job_title']) ? trim($_POST['job_title']) : '');
$status     = isset($_POST['status']) ? trim($_POST['status']) : '';
$joined     = isset($_POST['joined']) ? trim($_POST['joined']) : (isset($_POST['join_date']) ? trim($_POST['join_date']) : '');
$nic        = isset($_POST['nic']) ? trim($_POST['nic']) : '';
$dob        = isset($_POST['dob']) ? trim($_POST['dob']) : '';
$gender     = isset($_POST['gender']) ? trim($_POST['gender']) : '';
$address    = isset($_POST['address']) ? trim($_POST['address']) : '';
$emName     = isset($_POST['emergency_contact_name']) ? trim($_POST['emergency_contact_name']) : '';
$emPhone    = isset($_POST['emergency_contact_phone']) ? trim($_POST['emergency_contact_phone']) : '';
$location   = isset($_POST['work_location']) ? trim($_POST['work_location']) : '';

// Build dynamic update for employee_profiles table
$updates = [];
if (!empty($fullName)) $updates[] = "`full_name` = '" . addslashes($fullName) . "'";
if (!empty($email))    $updates[] = "`email` = '" . addslashes($email) . "'";
if (!empty($phone))    $updates[] = "`phone` = '" . addslashes($phone) . "'";
if (!empty($dept))     $updates[] = "`department` = '" . addslashes($dept) . "'";
if (!empty($role))     $updates[] = "`job_title` = '" . addslashes($role) . "'";
if (!empty($joined))   $updates[] = "`join_date` = '" . addslashes($joined) . "'";
if (!empty($nic))      $updates[] = "`nic` = '" . addslashes($nic) . "'";
if (!empty($dob))      $updates[] = "`dob` = '" . addslashes($dob) . "'";
if (!empty($gender))   $updates[] = "`gender` = '" . addslashes($gender) . "'";
if (!empty($address))  $updates[] = "`address` = '" . addslashes($address) . "'";
if (!empty($emName))   $updates[] = "`emergency_contact_name` = '" . addslashes($emName) . "'";
if (!empty($emPhone))  $updates[] = "`emergency_contact_phone` = '" . addslashes($emPhone) . "'";
if (!empty($location)) $updates[] = "`work_location` = '" . addslashes($location) . "'";

if (!empty($updates)) {
    $sql = "UPDATE `employee_profiles` SET " . implode(", ", $updates) . " WHERE `user_id` = $userId OR `id` = $userId";
    $db->get_result($sql);
}

// Also sync with employees table if it exists
if (!empty($fullName) || !empty($email) || !empty($dept) || !empty($role)) {
    $emp_updates = [];
    if (!empty($fullName)) $emp_updates[] = "`fullname` = '" . addslashes($fullName) . "'";
    if (!empty($email))    $emp_updates[] = "`email_address` = '" . addslashes($email) . "'";
    if (!empty($dept))     $emp_updates[] = "`departments` = '" . addslashes($dept) . "'";
    if (!empty($role))     $emp_updates[] = "`job_roles` = '" . addslashes($role) . "'";
    if (!empty($status))   $emp_updates[] = "`status` = '" . addslashes($status) . "'";
    if (!empty($joined))   $emp_updates[] = "`joined_date` = '" . addslashes($joined) . "'";

    if (!empty($emp_updates)) {
        $db->get_result("UPDATE `employees` SET " . implode(", ", $emp_updates) . " WHERE `id` = $userId OR `fullname` = '" . addslashes($fullName) . "'");
    }
}

// Trigger notification for Employee
$targetName = !empty($fullName) ? $fullName : 'Amal Perera';
SystemNotifications::create(
    "Profile Updated by Admin",
    "Your employment details & department information were updated by Administrator.",
    "profile_update",
    "employee",
    $targetName
);

echo json_encode([
    'status'  => 'success',
    'message' => 'Employee & profile details updated successfully across all dashboards!',
    'data'    => [
        'full_name'  => $fullName,
        'email'      => $email,
        'department' => $dept,
        'job_title'  => $role,
        'status'     => $status,
        'join_date'  => $joined
    ]
]);
exit;
?>
