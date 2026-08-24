<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id <= 0) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid document ID.'
    ]);
    exit;
}

try {
    $db = new DataBase();

    // 1. Fetch file path from database to delete physical file
    $res = $db->get_result("SELECT * FROM `documents` WHERE `id` = '$id'");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $relative_url = !empty($row['url']) ? $row['url'] : (!empty($row['file_path']) ? $row['file_path'] : '');
        if (!empty($relative_url)) {
            $abs_file = __DIR__ . '/../../../' . ltrim($relative_url, '/');
            if (file_exists($abs_file) && is_file($abs_file)) {
                @unlink($abs_file);
            }
        }
    }

    // 2. Permanently delete from MySQL database
    $db->get_result("DELETE FROM `documents` WHERE `id` = '$id'");

    // 3. Also remove from session if present
    if (isset($_SESSION['document_list']) && is_array($_SESSION['document_list'])) {
        foreach ($_SESSION['document_list'] as $key => $doc) {
            if ((int)$doc['id'] === $id) {
                unset($_SESSION['document_list'][$key]);
            }
        }
        $_SESSION['document_list'] = array_values($_SESSION['document_list']);
    }

    echo json_encode([
        'status'  => 'success',
        'message' => 'Document deleted successfully from database.'
    ]);
    exit;
} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error during deletion: ' . $e->getMessage()
    ]);
    exit;
}
