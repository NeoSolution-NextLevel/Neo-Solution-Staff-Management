<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';

if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
    exit;
}

$user_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$access_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;

$is_admin = (strpos($user_role, 'admin') !== false || $access_level === 1 || (int)$_SESSION['user_id'] === 1);
if (!$is_admin) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Access denied. Administrator privileges required.']);
    exit;
}

$db = new DataBase();
$conn = $db->get_data_base_connction();

$actor_id = (int)$_SESSION['user_id'];
$actor_result = $conn->query("SELECT ac_type, account_active_state, ast, full_block, main_user_account_access_level_list_id FROM `main_user_login` WHERE `id` = {$actor_id} LIMIT 1");
$actor = $actor_result ? $actor_result->fetch_assoc() : null;
$actor_acl = $actor && isset($actor['main_user_account_access_level_list_id']) ? (int)$actor['main_user_account_access_level_list_id'] : 0;
$actor_actype = $actor && isset($actor['ac_type']) ? strtolower(trim($actor['ac_type'])) : '';

$is_super_admin = (
    $actor_id === 1 || 
    $actor_actype === 'super_admin' || 
    $actor_actype === 'admin' || 
    $actor_acl === 1 || 
    $actor_acl === 3 || 
    strpos($user_role, 'admin') !== false ||
    strpos($user_role, 'super') !== false
);
if (!$is_super_admin) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Super Administrator privileges required.']);
    exit;
}

$canonical_super_admin_result = $conn->query("SELECT id FROM `main_user_login` WHERE `id` = 1 OR LOWER(TRIM(COALESCE(`ac_type`, ''))) = 'super_admin' ORDER BY CASE WHEN `id` = 1 THEN 0 ELSE 1 END, `id` ASC LIMIT 1");
if (!$canonical_super_admin_result) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Could not verify the Super Administrator account.']);
    exit;
}
$canonical_super_admin = $canonical_super_admin_result->fetch_assoc();
if ($canonical_super_admin) {
    $canonical_super_admin_id = (int)$canonical_super_admin['id'];
    $deduplicate_super_admins = $conn->query("UPDATE `main_user_login` SET `ac_type` = 'Admin' WHERE LOWER(TRIM(COALESCE(`ac_type`, ''))) = 'super_admin' AND `id` != {$canonical_super_admin_id}");
    if (!$deduplicate_super_admins) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Could not enforce the single Super Administrator account.']);
        exit;
    }
}

$sql = "SELECT 
            id, user_name, name_show, first_name, last_name, ref_key, ac_type,
            main_user_account_access_level_list_id,
            account_active_state, email_verify, full_block, ast, sdt, last_login, image_url
        FROM `main_user_login` 
        WHERE `ast` = 1 OR `account_active_state` = 0 OR `full_block` = 1
        ORDER BY 
            CASE WHEN (account_active_state = 0 AND id != 1) THEN 0 ELSE 1 END ASC,
            id DESC";

$res = $conn->query($sql);

$admins = [];
$pending_count = 0;

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $id = (int)$row['id'];
        $isRoot = ($id === 1);
        $acTypeRaw = trim($row['ac_type'] ?? '');
        $isSuperAdmin = ($isRoot || strtolower($acTypeRaw) === 'super_admin');
        $isAdmin = (strtolower($acTypeRaw) === 'admin' || (int)$row['main_user_account_access_level_list_id'] === 1);
        $isActive = ((int)$row['account_active_state'] === 1 && (int)$row['email_verify'] === 1 && (int)$row['ast'] === 1 && (int)$row['full_block'] === 0);
        $isPending = (!$isRoot && ((int)$row['account_active_state'] === 0 || (int)$row['email_verify'] === 0) && (int)$row['full_block'] === 0);
        $isBlocked = ((int)$row['full_block'] === 1 || (int)$row['ast'] === 0);

        if ($isPending) {
            $pending_count++;
            $status_label = 'Pending Role / Approval';
            $status_class = 'status-pending';
        } elseif ($isBlocked) {
            $status_label = 'Declined / Suspended';
            $status_class = 'status-blocked';
        } else {
            $status_label = 'Approved / Active';
            $status_class = 'status-active';
        }

        $dispName = !empty($row['name_show']) ? $row['name_show'] : trim($row['first_name'] . ' ' . $row['last_name']);
        if (empty($dispName)) $dispName = $row['user_name'];

        $roleDesc = $isRoot ? 'Super Administrator (Root)' : ($isSuperAdmin ? 'Super Administrator' : ($isAdmin ? 'Administrator' : ($acTypeRaw ?: 'Employee')));

        $admins[] = [
            'id' => $id,
            'user_name' => $row['user_name'],
            'name_show' => $dispName,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'ref_key' => $row['ref_key'] ?: ('ACC-' . str_pad((string)$id, 3, '0', STR_PAD_LEFT)),
            'role' => $roleDesc,
            'ac_type' => $acTypeRaw,
            'is_admin' => $isAdmin,
            'access_level_id' => (int)$row['main_user_account_access_level_list_id'],
            'is_root' => $isRoot,
            'is_super_admin' => $isSuperAdmin,
            'account_active_state' => (int)$row['account_active_state'],
            'email_verify' => (int)$row['email_verify'],
            'full_block' => (int)$row['full_block'],
            'ast' => (int)$row['ast'],
            'is_pending' => $isPending,
            'is_active' => $isActive,
            'is_blocked' => $isBlocked,
            'status_label' => $status_label,
            'status_class' => $status_class,
            'sdt' => $row['sdt'] ? date('Y-m-d H:i', strtotime($row['sdt'])) : '—',
            'last_login' => $row['last_login'] ? date('Y-m-d H:i', strtotime($row['last_login'])) : 'Never',
            'image_url' => $row['image_url']
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'data' => $admins,
    'pending_count' => $pending_count
]);
