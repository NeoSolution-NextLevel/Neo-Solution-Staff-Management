<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$found_doc = null;

if ($id > 0 && isset($_SESSION['document_list']) && is_array($_SESSION['document_list'])) {
    foreach ($_SESSION['document_list'] as $doc) {
        if ((int)$doc['id'] === $id) {
            $found_doc = $doc;
            break;
        }
    }
}

if ($found_doc) {
    $filePath = __DIR__ . '/../../../' . $found_doc['url'];
    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($found_doc['title']) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status'   => 'success',
            'message'  => 'Document metadata retrieved for download',
            'filename' => $found_doc['title'],
            'data'     => $found_doc
        ]);
        exit;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'status'  => 'error',
        'message' => 'Document not found for download.'
    ]);
    exit;
}
