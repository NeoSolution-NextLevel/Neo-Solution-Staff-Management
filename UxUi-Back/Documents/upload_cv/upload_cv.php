<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$employee_name = isset($_POST['employee']) ? trim($_POST['employee']) : (isset($_POST['fullname']) ? trim($_POST['fullname']) : (isset($_POST['name']) ? trim($_POST['name']) : ''));
$doc_category  = isset($_POST['category']) ? trim($_POST['category']) : (isset($_POST['doc_type']) ? trim($_POST['doc_type']) : (isset($_POST['type']) ? trim($_POST['type']) : 'Document'));
$status        = isset($_POST['status']) ? trim($_POST['status']) : 'uploaded';

if (empty($employee_name)) {
    // If logged in as employee, fallback to session employee name
    if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
        $employee_name = $_SESSION['user_name'];
    } elseif (isset($_SESSION['fullname']) && !empty($_SESSION['fullname'])) {
        $employee_name = $_SESSION['fullname'];
    } else {
        $employee_name = 'Employee';
    }
}

if (!isset($_FILES['document_file']) && !isset($_FILES['file']) && !isset($_FILES['cv_file'])) {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
    exit;
}

$file_field = isset($_FILES['document_file']) ? $_FILES['document_file'] : (isset($_FILES['file']) ? $_FILES['file'] : $_FILES['cv_file']);

if ($file_field['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'File upload error code: ' . $file_field['error']]);
    exit;
}

// Upload directory setup
$upload_dir = __DIR__ . '/../../../uploads/documents/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$original_name = basename($file_field['name']);
$file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
$clean_name = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $original_name);
$new_filename = time() . '_' . $clean_name;
$target_file = $upload_dir . $new_filename;
$relative_url = 'uploads/documents/' . $new_filename;

// Format file size
$bytes = $file_field['size'];
if ($bytes >= 1048576) {
    $size_formatted = number_format($bytes / 1048576, 1) . ' MB';
} elseif ($bytes >= 1024) {
    $size_formatted = number_format($bytes / 1024, 1) . ' KB';
} else {
    $size_formatted = $bytes . ' B';
}

if (move_uploaded_file($file_field['tmp_name'], $target_file)) {
    $uploaded_date = date('Y-m-d');
    
    // Save to Database if table exists
    $inserted_id = time();
    try {
        $db = new DataBase();
        $conn = $db->get_data_base_connction();
        if ($conn) {
            $check_table = $db->get_result("SHOW TABLES LIKE 'documents'");
            if ($check_table && $check_table->num_rows > 0) {
                $safe_title    = addslashes($original_name);
                $safe_emp      = addslashes($employee_name);
                $safe_cat      = addslashes($doc_category);
                $safe_url      = addslashes($relative_url);
                $safe_size     = addslashes($size_formatted);
                $safe_status   = addslashes($status);
                $safe_ext      = strtoupper($file_ext);
                $safe_uploaded = $uploaded_date;

                $sql = "INSERT INTO documents (title, type, category, employee, size, uploaded, status, url, ast) 
                        VALUES ('$safe_title', '$safe_ext', '$safe_cat', '$safe_emp', '$safe_size', '$safe_uploaded', '$safe_status', '$safe_url', '1')";
                $db->get_result($sql);
                $db_id = $db->get_id();
                if ($db_id > 0) {
                    $inserted_id = (int)$db_id;
                }
            }
        }
    } catch (Exception $e) {
        // Fallback to session
    }

    $new_doc = [
        'id'       => $inserted_id,
        'title'    => $original_name,
        'type'     => strtoupper($file_ext),
        'category' => $doc_category,
        'employee' => $employee_name,
        'size'     => $size_formatted,
        'uploaded' => $uploaded_date,
        'status'   => $status,
        'url'      => $relative_url
    ];

    if (!isset($_SESSION['document_list']) || !is_array($_SESSION['document_list'])) {
        $_SESSION['document_list'] = [];
    }

    $_SESSION['document_list'][] = $new_doc;

    echo json_encode([
        'status'  => 'success',
        'message' => 'Document uploaded and saved successfully.',
        'data'    => $new_doc
    ]);
    exit;
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to save uploaded file on server.'
    ]);
    exit;
}
