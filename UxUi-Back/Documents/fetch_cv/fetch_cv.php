<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$documents = [];

// 1. Try fetching from Database if table exists
try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    if ($conn) {
        // Check if documents table exists
        $check_table = $db->get_result("SHOW TABLES LIKE 'documents'");
        if ($check_table && $check_table->num_rows > 0) {
            $res = $db->get_result("SELECT * FROM documents WHERE ast = '1' ORDER BY id DESC");
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $documents[] = [
                        'id'        => (int)$row['id'],
                        'title'     => isset($row['title']) ? $row['title'] : (isset($row['file_name']) ? $row['file_name'] : 'document.pdf'),
                        'type'      => isset($row['type']) ? $row['type'] : 'PDF',
                        'category'  => isset($row['category']) ? $row['category'] : (isset($row['document_type']) ? $row['document_type'] : 'Document'),
                        'employee'  => isset($row['employee']) ? $row['employee'] : (isset($row['employee_name']) ? $row['employee_name'] : 'Employee'),
                        'size'      => isset($row['size']) ? $row['size'] : '1.0 MB',
                        'uploaded'  => isset($row['uploaded']) ? $row['uploaded'] : (isset($row['uploaded_date']) ? $row['uploaded_date'] : date('Y-m-d')),
                        'status'    => isset($row['status']) ? $row['status'] : 'uploaded',
                        'url'       => isset($row['url']) ? $row['url'] : (isset($row['file_path']) ? $row['file_path'] : '')
                    ];
                }
            }
        }
    }
} catch (Exception $e) {
    // Database fallback
}

// 2. If DB had no documents, check session
if (empty($documents) && isset($_SESSION['document_list']) && is_array($_SESSION['document_list'])) {
    $documents = array_values($_SESSION['document_list']);
}

echo json_encode([
    'status' => 'success',
    'total'  => count($documents),
    'data'   => $documents
]);
exit;
