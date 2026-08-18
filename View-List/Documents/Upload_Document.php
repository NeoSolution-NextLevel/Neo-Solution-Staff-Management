<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Controllers/Main/Documents/documents_ADD_UPDATE.php';
include_once __DIR__ . '/../../imports/need/SystemNotifications.php';

$response = [
    'status' => 'error',
    'message' => 'Invalid request method.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['document_file']) || $_FILES['document_file']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = 'Please select a valid file to upload.';
        if (isset($_FILES['document_file'])) {
            switch ($_FILES['document_file']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errorMsg = 'File exceeds maximum allowed size (10MB).';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errorMsg = 'No file was uploaded.';
                    break;
            }
        }
        $response = ['status' => 'error', 'message' => $errorMsg];
    } else {
        $file = $_FILES['document_file'];
        $docType = isset($_POST['doc_type']) ? trim($_POST['doc_type']) : 'Document';
        $employeeName = isset($_POST['employee_name']) && !empty($_POST['employee_name']) ? trim($_POST['employee_name']) : 'Employee';
        $employeeId = isset($_POST['employee_id']) && !empty($_POST['employee_id']) ? trim($_POST['employee_id']) : 'EMP-001';
        $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 1;

        $originalName = basename($file['name']);
        $fileSize = $file['size'];
        $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $allowedExts = ['pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx'];
        if (!in_array($fileExt, $allowedExts)) {
            $response = ['status' => 'error', 'message' => 'Invalid file format. Allowed: PDF, PNG, JPG, DOC, DOCX.'];
        } elseif ($fileSize > 10 * 1024 * 1024) {
            $response = ['status' => 'error', 'message' => 'File size exceeds 10MB limit.'];
        } else {
            // Generate unique filename
            $uploadDir = __DIR__ . '/../../uploads/documents/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $safeFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalName);
            $targetPath = $uploadDir . $safeFileName;
            $relativeUrl = 'uploads/documents/' . $safeFileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Calculate readable file size
                $fileSizeFormatted = ($fileSize >= 1048576) 
                    ? number_format($fileSize / 1048576, 2) . ' MB' 
                    : number_format($fileSize / 1024, 1) . ' KB';

                $controller = new Documents_Add_Update();
                $res = $controller->saveDocument(
                    $employeeName,
                    $docType,
                    $originalName,
                    $relativeUrl,
                    $fileSizeFormatted,
                    $employeeId,
                    $userId
                );

                $response = $res;
                if ($res['status'] === 'success') {
                    $response['file_name'] = $originalName;
                    $response['file_path'] = $relativeUrl;
                    $response['file_size'] = $fileSizeFormatted;
                    $response['doc_type'] = $docType;

                    // Trigger notification for Admin
                    SystemNotifications::create(
                        "Document Uploaded",
                        "$employeeName uploaded '$originalName' ($docType).",
                        "document_upload",
                        "admin"
                    );
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to save uploaded file to storage.'];
            }
        }
    }
}

echo json_encode($response);
exit;
?>
