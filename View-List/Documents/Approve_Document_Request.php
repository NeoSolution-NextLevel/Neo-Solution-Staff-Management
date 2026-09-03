<?php
/**
 * Approve_Document_Request.php
 * Admin approves or ignores an uploaded document request.
 * POST: request_id, action ('approve' | 'ignore')
 */
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Documents/document_requests_ADD_UPDATE.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Caller identification
$caller_id = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] > 0
    ? (int)$_SESSION['user_id']
    : (isset($_SESSION['admin_original_session']['user_id']) ? (int)$_SESSION['admin_original_session']['user_id'] : 1);

$request_id = isset($_POST['request_id']) ? (int)$_POST['request_id'] : 0;
$action     = isset($_POST['action'])     ? strtolower(trim($_POST['action'])) : '';

if ($request_id <= 0 || !in_array($action, ['approve', 'ignore'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
    exit;
}

$new_status = $action === 'approve' ? 'Approved' : 'Ignored';

// Fetch current request row to get document_id
$db     = new DataBase();
$dqRes  = $db->get_result("SELECT * FROM `document_requests` WHERE id='{$request_id}' AND ast='1' LIMIT 1");
if (!$dqRes || $dqRes->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Request not found.']);
    exit;
}
$reqRow = $dqRes->fetch_assoc();

// Update request status
$updObj = new document_requests_ADD_UPDATE();
$updObj->set_id($request_id);
$updObj->set_status($new_status);
$updObj->set_reviewed_at();

if (!$updObj->process_update()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update request: ' . $updObj->get_error()]);
    exit;
}

// Also update the linked document's status in the documents table
if (!empty($reqRow['document_id'])) {
    $docStatus = $action === 'approve' ? 'Approved' : 'Ignored';
    $db->get_result("UPDATE `documents` SET `status`='" . addslashes($docStatus) . "' WHERE `id`='" . (int)$reqRow['document_id'] . "'");
}

echo json_encode([
    'status'  => 'success',
    'message' => 'Request ' . $new_status . ' successfully.',
    'new_status' => $new_status
]);
?>
