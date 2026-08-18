<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0 && isset($_SESSION['document_list']) && is_array($_SESSION['document_list'])) {
    foreach ($_SESSION['document_list'] as $key => $doc) {
        if ((int)$doc['id'] === $id) {
            unset($_SESSION['document_list'][$key]);
            $_SESSION['document_list'] = array_values($_SESSION['document_list']);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Document deleted successfully.'
            ]);
            exit;
        }
    }
}

echo json_encode([
    'status'  => 'error',
    'message' => 'Document could not be deleted or not found.'
]);
exit;
