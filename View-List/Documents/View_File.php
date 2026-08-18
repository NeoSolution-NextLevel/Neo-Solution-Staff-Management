<?php
include_once __DIR__ . '/../../database.php';

$fileParam = isset($_GET['file']) ? trim($_GET['file']) : '';
$idParam = isset($_GET['id']) ? intval($_GET['id']) : 0;

$filePath = '';
$originalName = 'document';

if ($idParam > 0) {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();
    $res = $conn->query("SELECT file_path, file_name FROM `documents` WHERE `id` = {$idParam} LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $filePath = __DIR__ . '/../../' . ltrim($row['file_path'], '/');
        $originalName = $row['file_name'];
    }
} elseif (!empty($fileParam)) {
    // Prevent directory traversal
    $safeName = basename($fileParam);
    $filePath = __DIR__ . '/../../uploads/documents/' . $safeName;
    $originalName = $safeName;
}

if (!empty($filePath) && file_exists($filePath)) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    $mime = 'application/octet-stream';
    if ($ext === 'pdf') {
        $mime = 'application/pdf';
    } elseif ($ext === 'png') {
        $mime = 'image/png';
    } elseif ($ext === 'jpg' || $ext === 'jpeg') {
        $mime = 'image/jpeg';
    } elseif ($ext === 'webp') {
        $mime = 'image/webp';
    } elseif ($ext === 'gif') {
        $mime = 'image/gif';
    }

    header('Content-Type: ' . $mime);
    header('Content-Disposition: inline; filename="' . basename($originalName) . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: public, max-age=86400');
    readfile($filePath);
    exit;
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Document file not found on server.';
    exit;
}
