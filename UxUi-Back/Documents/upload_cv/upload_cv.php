<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$db = new DataBase();

// Ensure documents table has correct schema & auto-increment primary key
$db->get_result("CREATE TABLE IF NOT EXISTS `documents` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) DEFAULT 1,
    `employee_id` varchar(50) DEFAULT 'EMP-001',
    `employee_name` varchar(255) DEFAULT '',
    `doc_type` varchar(255) DEFAULT 'Document',
    `file_name` varchar(255) DEFAULT '',
    `file_path` varchar(500) DEFAULT '',
    `file_size` varchar(50) DEFAULT '1.0 MB',
    `status` varchar(50) DEFAULT 'Uploaded',
    `uploaded_date` datetime DEFAULT CURRENT_TIMESTAMP,
    `ast` varchar(10) DEFAULT '1',
    `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$user_id       = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;
$employee_id   = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
$employee_name = isset($_POST['employee_name']) ? trim($_POST['employee_name']) : (isset($_POST['employee']) ? trim($_POST['employee']) : (isset($_POST['name']) ? trim($_POST['name']) : ''));
$doc_type      = isset($_POST['doc_type']) ? trim($_POST['doc_type']) : (isset($_POST['category']) ? trim($_POST['category']) : (isset($_POST['type']) ? trim($_POST['type']) : 'Document'));
$status        = isset($_POST['status']) && !empty($_POST['status']) ? trim($_POST['status']) : 'Uploaded';

// If employee_name or employee_id is empty, lookup from employee_profiles or employees table
if (empty($employee_name) || empty($employee_id)) {
    $prof_res = $db->get_result("SELECT * FROM `employee_profiles` WHERE `user_id` = '$user_id' OR `id` = '$user_id' LIMIT 1");
    if ($prof_res && $prof_res->num_rows > 0) {
        $p = $prof_res->fetch_assoc();
        if (empty($employee_name) && !empty($p['full_name'])) $employee_name = $p['full_name'];
        if (empty($employee_id) && !empty($p['employee_id_code'])) $employee_id = $p['employee_id_code'];
    }
    
    if (empty($employee_name)) {
        $emp_res = $db->get_result("SELECT * FROM `employees` WHERE `id` = '$user_id' OR `ast` = '1' LIMIT 1");
        if ($emp_res && $emp_res->num_rows > 0) {
            $e = $emp_res->fetch_assoc();
            if (!empty($e['fullname'])) $employee_name = $e['fullname'];
            elseif (!empty($e['name'])) $employee_name = $e['name'];
        }
    }
}

if (empty($employee_name)) {
    $employee_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : (isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Employee');
}
if (empty($employee_id)) {
    $employee_id = 'EMP-' . str_pad($user_id, 3, '0', STR_PAD_LEFT);
}

// 1. Identify files to process (Supports single file or Front+Back PNG pair)
$files_to_process = [];

if (isset($_FILES['document_file_front']) && $_FILES['document_file_front']['error'] === UPLOAD_ERR_OK) {
    $files_to_process[] = [
        'file'     => $_FILES['document_file_front'],
        'doc_type' => 'National ID (Front)',
        'side'     => 'front'
    ];
}
if (isset($_FILES['document_file_back']) && $_FILES['document_file_back']['error'] === UPLOAD_ERR_OK) {
    $files_to_process[] = [
        'file'     => $_FILES['document_file_back'],
        'doc_type' => 'National ID (Back)',
        'side'     => 'back'
    ];
}

if (empty($files_to_process)) {
    $single_field = isset($_FILES['document_file']) ? $_FILES['document_file'] : (isset($_FILES['file']) ? $_FILES['file'] : (isset($_FILES['cv_file']) ? $_FILES['cv_file'] : null));
    if ($single_field && $single_field['error'] === UPLOAD_ERR_OK) {
        $files_to_process[] = [
            'file'     => $single_field,
            'doc_type' => $doc_type,
            'side'     => 'main'
        ];
    }
}

if (empty($files_to_process)) {
    echo json_encode(['status' => 'error', 'message' => 'No valid document file was selected.']);
    exit;
}

// Upload directory
$upload_dir = __DIR__ . '/../../../uploads/documents/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$uploaded_records = [];
$primary_id = 0;
$primary_path = '';
$primary_name = '';

foreach ($files_to_process as $idx => $item) {
    $file_field    = $item['file'];
    $item_doc_type = $item['doc_type'];

    $original_name = basename($file_field['name']);
    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $clean_name = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $original_name);
    $new_filename = time() . '_' . ($idx + 1) . '_' . $clean_name;
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

    if (move_uploaded_file($file_field['tmp_name'], $target_file) || copy($file_field['tmp_name'], $target_file)) {
        $safe_emp_id    = addslashes($employee_id);
        $safe_emp_name  = addslashes($employee_name);
        $safe_doc_type  = addslashes($item_doc_type);
        $safe_file_name = addslashes($original_name);
        $safe_file_path = addslashes($relative_url);
        $safe_file_size = addslashes($size_formatted);
        $safe_status    = addslashes($status);

        $sql = "INSERT INTO `documents` (`user_id`, `employee_id`, `employee_name`, `doc_type`, `file_name`, `file_path`, `file_size`, `status`, `uploaded_date`, `ast`, `sdt`) 
                VALUES ('$user_id', '$safe_emp_id', '$safe_emp_name', '$safe_doc_type', '$safe_file_name', '$safe_file_path', '$safe_file_size', '$safe_status', NOW(), '1', NOW())";
        $db->get_result($sql);
        
        $inserted_id = (int)$db->get_id();
        if ($inserted_id <= 0) {
            $last_res = $db->get_result("SELECT id FROM documents ORDER BY id DESC LIMIT 1");
            if ($last_res && $last_res->num_rows > 0) {
                $inserted_id = (int)$last_res->fetch_assoc()['id'];
            }
        }

        if ($primary_id === 0) {
            $primary_id = $inserted_id;
            $primary_path = $relative_url;
            $primary_name = $original_name;
        }

        $uploaded_records[] = [
            'id'            => $inserted_id,
            'file_name'     => $original_name,
            'title'         => $original_name,
            'file_path'     => $relative_url,
            'url'           => $relative_url,
            'doc_type'      => $item_doc_type,
            'category'      => $doc_type,
            'employee_name' => $employee_name,
            'employee'      => $employee_name,
            'employee_id'   => $employee_id,
            'file_size'     => $size_formatted,
            'size'          => $size_formatted,
            'status'        => $status,
            'uploaded_date' => date('Y-m-d H:i:s')
        ];
    }
}

if (!empty($uploaded_records)) {
    // Trigger system notification for Admin
    if (class_exists('SystemNotifications')) {
        SystemNotifications::create(
            "New Document Uploaded",
            "$employee_name ($employee_id) uploaded $doc_type (" . count($uploaded_records) . " file(s))",
            "document_upload",
            "admin",
            "Admin"
        );
    }

    echo json_encode([
        'status'    => 'success',
        'message'   => 'Document(s) uploaded and saved to admin documents successfully.',
        'id'        => $primary_id,
        'file_name' => $primary_name,
        'title'     => $primary_name,
        'file_path' => $primary_path,
        'url'       => $primary_path,
        'doc_type'  => $doc_type,
        'category'  => $doc_type,
        'employee'  => $employee_name,
        'employee_id' => $employee_id,
        'files'     => $uploaded_records,
        'data'      => $uploaded_records[0]
    ]);
    exit;
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to save uploaded files to server directory.'
    ]);
    exit;
}
?>
