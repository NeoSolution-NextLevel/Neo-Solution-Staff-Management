<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$documents = [];

try {
    $db = new DataBase();
    $res = $db->get_result("SELECT * FROM documents WHERE ast = '1' ORDER BY id DESC");
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $documents[] = [
                'id'            => (int)$row['id'],
                'title'         => !empty($row['title']) ? $row['title'] : (!empty($row['file_name']) ? $row['file_name'] : ''),
                'file_name'     => !empty($row['file_name']) ? $row['file_name'] : (!empty($row['title']) ? $row['title'] : ''),
                'type'          => !empty($row['type']) ? $row['type'] : 'PDF',
                'category'      => !empty($row['category']) ? $row['category'] : (!empty($row['doc_type']) ? $row['doc_type'] : ''),
                'doc_type'      => !empty($row['doc_type']) ? $row['doc_type'] : (!empty($row['category']) ? $row['category'] : ''),
                'employee'      => !empty($row['employee']) ? $row['employee'] : (!empty($row['employee_name']) ? $row['employee_name'] : ''),
                'employee_name' => !empty($row['employee_name']) ? $row['employee_name'] : (!empty($row['employee']) ? $row['employee'] : ''),
                'employee_id'   => !empty($row['employee_id']) ? $row['employee_id'] : '',
                'size'          => !empty($row['size']) ? $row['size'] : (!empty($row['file_size']) ? $row['file_size'] : ''),
                'file_size'     => !empty($row['file_size']) ? $row['file_size'] : (!empty($row['size']) ? $row['size'] : ''),
                'uploaded'      => !empty($row['uploaded']) ? $row['uploaded'] : (!empty($row['uploaded_date']) ? $row['uploaded_date'] : ''),
                'uploaded_date' => !empty($row['uploaded_date']) ? $row['uploaded_date'] : (!empty($row['uploaded']) ? $row['uploaded'] : ''),
                'status'        => !empty($row['status']) ? $row['status'] : 'uploaded',
                'url'           => !empty($row['url']) ? $row['url'] : (!empty($row['file_path']) ? $row['file_path'] : ''),
                'file_path'     => !empty($row['file_path']) ? $row['file_path'] : (!empty($row['url']) ? $row['url'] : '')
            ];
        }
    }
} catch (Exception $e) {
    // Database query error handled gracefully
}

echo json_encode([
    'status' => 'success',
    'total'  => count($documents),
    'data'   => $documents
]);
exit;
