<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Controllers/Main/Documents/documents_DELETE.php';

$response = [
    'status' => 'error',
    'message' => 'Invalid request.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['id'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);

    if ($id > 0) {
        $controller = new Documents_Delete();
        $response = $controller->deleteDocument($id);
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid document ID.'];
    }
}

echo json_encode($response);
exit;
