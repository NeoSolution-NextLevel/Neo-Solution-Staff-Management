<?php
/**
 * Fetch_Document_Requests.php
 * GET ?for=admin                        → all requests
 * GET ?for=employee&user_id=X           → pending/uploaded requests for that employee
 */
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Documents/document_requests_ADD_UPDATE.php'; // ensures table exists
include_once __DIR__ . '/../../Controllers/Main/Documents/document_requests_LIST.php';

$for     = isset($_GET['for'])     ? trim($_GET['for'])  : 'admin';
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : (isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0);

$db = new DataBase();

if ($for === 'employee') {
    // Resolve employee details
    $emp_prof_id = $user_id;
    $emp_uid     = $user_id;
    $emp_name    = '';
    $emp_dept    = '';

    if ($user_id > 0) {
        $pRes = $db->get_result("SELECT * FROM `employee_profiles` WHERE `id` = '{$user_id}' OR `user_id` = '{$user_id}' LIMIT 1");
        if ($pRes && $pRes->num_rows > 0) {
            $p = $pRes->fetch_assoc();
            $emp_prof_id = (int)$p['id'];
            $emp_uid     = !empty($p['user_id']) ? (int)$p['user_id'] : $emp_prof_id;
            $emp_name    = !empty($p['full_name']) ? trim($p['full_name']) : '';
            $emp_dept    = !empty($p['department']) ? trim($p['department']) : '';
        }
    }

    if (empty($emp_name) && !empty($_SESSION['user_name'])) {
        $emp_name = trim($_SESSION['user_name']);
    }

    $safe_name = addslashes($emp_name);
    $safe_dept = addslashes($emp_dept);

    $sql = "SELECT * FROM `document_requests`
            WHERE `ast` = '1'
              AND (
                (`target_type` = 'employee' AND (`target_employee_user_id` = '{$emp_uid}' OR `target_employee_user_id` = '{$emp_prof_id}'" . (!empty($safe_name) ? " OR `target_employee_name` = '{$safe_name}'" : "") . "))
                " . (!empty($safe_dept) ? " OR (`target_type` = 'department' AND `target_employee_name` = '{$safe_dept}')" : "") . "
                OR `target_type` = 'all'
              )
            ORDER BY id DESC";

    $rRes = $db->get_result($sql);
    $rows = [];
    if ($rRes && $rRes->num_rows > 0) {
        while ($r = $rRes->fetch_assoc()) {
            $rows[] = $r;
        }
    }
} else {
    // for=admin
    $lister = new document_requests_LIST();
    $lister->filter_by_ast('1');
    $rows = $lister->get_as_array();
}

// Enrich with document file info if linked
$db = new DataBase();
foreach ($rows as &$row) {
    if (!empty($row['document_id'])) {
        $dRes = $db->get_result("SELECT file_name, file_path, file_size FROM `documents` WHERE id='" . (int)$row['document_id'] . "' LIMIT 1");
        if ($dRes && $dRes->num_rows > 0) {
            $d = $dRes->fetch_assoc();
            $row['file_name'] = $d['file_name'];
            $row['file_path'] = $d['file_path'];
            $row['file_size'] = $d['file_size'];
        }
    }
}
unset($row);

echo json_encode([
    'status' => 'success',
    'total'  => count($rows),
    'data'   => $rows
]);
?>
