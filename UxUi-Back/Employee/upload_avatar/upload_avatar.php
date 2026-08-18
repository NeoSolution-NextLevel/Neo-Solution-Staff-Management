<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_FILES['avatar_file']) || $_FILES['avatar_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Please select a valid image file.']);
    exit;
}

$file = $_FILES['avatar_file'];
$originalName = basename($file['name']);
$fileSize = $file['size'];
$fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

$allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
if (!in_array($fileExt, $allowedExts)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid format. Allowed: JPG, PNG, WEBP, GIF.']);
    exit;
}

if ($fileSize > 5 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'Image exceeds 5MB limit.']);
    exit;
}

$uploadDir = __DIR__ . '/../../../uploads/avatars/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$safeFileName = 'avatar_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
$targetPath = $uploadDir . $safeFileName;
$relativeUrl = 'uploads/avatars/' . $safeFileName;

if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    $db = new DataBase();
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;
    $db->get_result("UPDATE `employee_profiles` SET `profile_pic` = '$relativeUrl' WHERE `user_id` = $userId");

    SystemNotifications::create(
        "Profile Picture Updated",
        "Employee updated their profile picture.",
        "profile_update",
        "admin"
    );

    echo json_encode([
        'status'     => 'success',
        'message'    => 'Profile photo updated successfully!',
        'avatar_url' => $relativeUrl
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save avatar image to server.']);
}
exit;
?>
