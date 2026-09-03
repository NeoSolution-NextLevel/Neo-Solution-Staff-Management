<?php
/**
 * Create_Document_Request.php
 * Admin creates a document request for an employee or department.
 * POST: target_type, target_employee_user_id, target_employee_name,
 *       doc_type, notes, deadline
 */
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Documents/document_requests_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Admin caller identification
$user_id = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] > 0
    ? (int)$_SESSION['user_id']
    : (isset($_SESSION['admin_original_session']['user_id']) ? (int)$_SESSION['admin_original_session']['user_id'] : 1);

$admin_name = !empty($_SESSION['admin_original_session']['user_name'])
    ? $_SESSION['admin_original_session']['user_name']
    : (!empty($_SESSION['user_name']) ? trim($_SESSION['user_name']) : 'Admin');

$target_type             = isset($_POST['target_type']) ? strtolower(trim($_POST['target_type'])) : 'employee';
$target_employee_user_id = isset($_POST['target_employee_user_id']) && $_POST['target_employee_user_id'] !== ''
                           ? (int)$_POST['target_employee_user_id'] : null;
$target_employee_name    = isset($_POST['target_employee_name']) ? trim($_POST['target_employee_name']) : '';
$doc_type                = isset($_POST['doc_type']) ? trim($_POST['doc_type']) : 'Document';
$notes                   = isset($_POST['notes']) ? trim($_POST['notes']) : '';
$deadline                = isset($_POST['deadline']) ? trim($_POST['deadline']) : null;

if ($target_type === 'employee' && empty($target_employee_name) && empty($target_employee_user_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Target employee is required.']);
    exit;
}
if ($target_type === 'department' && empty($target_employee_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Target department is required.']);
    exit;
}
if ($target_type === 'all') {
    $target_employee_name = 'All Employees';
    $target_employee_user_id = null;
}
if (empty($doc_type)) {
    echo json_encode(['status' => 'error', 'message' => 'Document type is required.']);
    exit;
}

$req = new document_requests_ADD_UPDATE();
$req->set_data(
    $user_id,
    $admin_name,
    $target_type,
    $target_employee_user_id,
    $target_employee_name,
    $doc_type,
    $notes,
    $deadline
);

if ($req->process_new_record()) {
    $req_id = $req->get_id();

    // Send notification to relevant employees
    include_once __DIR__ . '/../../imports/need/SystemNotifications.php';
    if (class_exists('SystemNotifications')) {
        $notif_msg = "Please upload required document: {$doc_type}." . (!empty($notes) ? " Note: {$notes}." : "") . (!empty($deadline) ? " Due by {$deadline}." : "");
        $recipient_name = ($target_type === 'employee') ? $target_employee_name : null;
        SystemNotifications::create(
            "Document Requested: " . $doc_type,
            $notif_msg,
            "document_request",
            "employee",
            $recipient_name
        );
    }

    echo json_encode([
        'status'  => 'success',
        'message' => 'Document request created successfully and sent to relevant employee(s).',
        'id'      => $req_id
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create request: ' . $req->get_error()]);
}
?>
