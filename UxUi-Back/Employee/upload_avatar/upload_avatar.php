<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$fileKey = isset($_FILES['avatar_file']) ? 'avatar_file' : (isset($_FILES['profile_pic']) ? 'profile_pic' : null);

if (!$fileKey || !isset($_FILES[$fileKey])) {
    echo json_encode(['status' => 'error', 'message' => 'No image file was received. Please choose an image.']);
    exit;
}

$file = $_FILES[$fileKey];

if ($file['error'] !== UPLOAD_ERR_OK) {
    switch ($file['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo json_encode(['status' => 'error', 'message' => 'Image file is too large. Server limit exceeded.']);
            break;
        case UPLOAD_ERR_NO_FILE:
            echo json_encode(['status' => 'error', 'message' => 'Please select an image file to upload.']);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Upload error code: ' . $file['error']]);
            break;
    }
    exit;
}

$originalName = basename($file['name']);
$fileSize = $file['size'];
$fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

$allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
if (!in_array($fileExt, $allowedExts)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Allowed types: JPG, PNG, WEBP, GIF.']);
    exit;
}

if ($fileSize > 8 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'Image exceeds maximum 8MB limit.']);
    exit;
}

$uploadDir = __DIR__ . '/../../../uploads/avatars/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
}

$safeFileName = 'avatar_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
$targetPath = $uploadDir . $safeFileName;
$relativeUrl = 'uploads/avatars/' . $safeFileName;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save uploaded image to destination directory.']);
    exit;
}

$db = new DataBase();
$conn = $db->get_data_base_connction();
$safeRelUrl = addslashes($relativeUrl);

// Resolve target identity from POST or Session
$postProfId = isset($_POST['profile_id']) ? (int)$_POST['profile_id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$postUserId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : (isset($_POST['account_id']) ? (int)$_POST['account_id'] : 0);

$sessProfId = (int)($_SESSION['employee_profile_id'] ?? 0);
$sessUserId = (int)($_SESSION['user_id'] ?? ($_SESSION['main_user_login_id'] ?? 0));

$targetProfId = $postProfId > 0 ? $postProfId : $sessProfId;
$targetUserId = $postUserId > 0 ? $postUserId : $sessUserId;

$matchedProf = null;
if ($targetProfId > 0 || $targetUserId > 0) {
    $whereParts = [];
    if ($targetProfId > 0) {
        $whereParts[] = "`id` = {$targetProfId}";
        $whereParts[] = "`user_id` = {$targetProfId}";
    }
    if ($targetUserId > 0) {
        $whereParts[] = "`user_id` = {$targetUserId}";
        $whereParts[] = "`id` = {$targetUserId}";
    }
    $chkQ = "SELECT * FROM `employee_profiles` WHERE " . implode(" OR ", $whereParts) . " LIMIT 1";
    $chkRes = $conn->query($chkQ);
    if ($chkRes && ($p = $chkRes->fetch_assoc())) {
        $matchedProf = $p;
    }
}

if ($matchedProf) {
    $profId = (int)$matchedProf['id'];
    $uId    = (int)($matchedProf['user_id'] ?? 0);

    $conn->query("UPDATE `employee_profiles` SET `profile_pic` = '{$safeRelUrl}', `updated_at` = NOW() WHERE `id` = {$profId}");
    if ($uId > 0) {
        $conn->query("UPDATE `main_user_login` SET `image_url` = '{$safeRelUrl}' WHERE `id` = {$uId}");
    }

    // If updated user is current session user, update session
    if (($sessProfId > 0 && $sessProfId === $profId) || ($sessUserId > 0 && $sessUserId === $uId)) {
        $_SESSION['profile_pic'] = $relativeUrl;
        $_SESSION['image_url']   = $relativeUrl;
    }
} else {
    // Fallback: If no employee_profiles row matched, try updating main_user_login directly
    if ($targetUserId > 0) {
        $conn->query("UPDATE `main_user_login` SET `image_url` = '{$safeRelUrl}' WHERE `id` = {$targetUserId}");
        if ($sessUserId > 0 && $sessUserId === $targetUserId) {
            $_SESSION['profile_pic'] = $relativeUrl;
            $_SESSION['image_url']   = $relativeUrl;
        }
    }
}

try {
    SystemNotifications::create(
        "Profile Picture Updated",
        "Profile photo has been updated successfully.",
        "profile_update",
        "admin"
    );
} catch (\Throwable $e) {}

echo json_encode([
    'status'      => 'success',
    'message'     => 'Profile photo updated successfully!',
    'avatar_url'  => $relativeUrl,
    'profile_pic' => $relativeUrl,
    'image_url'   => $relativeUrl
]);
exit;
