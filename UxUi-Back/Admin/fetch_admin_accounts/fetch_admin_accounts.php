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
$actor_result = $conn->query("SELECT ac_type, account_active_state, ast, full_block FROM `main_user_login` WHERE `id` = {$actor_id} LIMIT 1");
$actor = $actor_result ? $actor_result->fetch_assoc() : null;
$is_super_admin = ($actor_id === 1 || (
    $actor &&
    strtolower(trim($actor['ac_type'])) === 'super admin' &&
    (int)$actor['account_active_state'] === 1 &&
    (int)$actor['ast'] === 1 &&
    (int)$actor['full_block'] === 0
));
if (!$is_super_admin) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Super Administrator privileges required.']);
    exit;
}

$sql = "SELECT 
            id, user_name, name_show, first_name, last_name, ref_key, ac_type,
            account_active_state, email_verify, full_block, ast, sdt, last_login, image_url
        FROM `main_user_login` 
        WHERE `ac_type` IN ('Admin', 'Super Admin')
           OR `main_user_account_access_level_list_id` = 1 
           OR `id` = 1
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
        $isSuperAdmin = ($isRoot || strtolower(trim($row['ac_type'])) === 'super admin');
        $isActive = ((int)$row['account_active_state'] === 1 && (int)$row['email_verify'] === 1 && (int)$row['ast'] === 1 && (int)$row['full_block'] === 0);
        $isPending = (!$isRoot && ((int)$row['account_active_state'] === 0 || (int)$row['email_verify'] === 0) && (int)$row['full_block'] === 0);
        $isBlocked = ((int)$row['full_block'] === 1 || (int)$row['ast'] === 0);

        if ($isPending) {
            $pending_count++;
            $status_label = 'Pending Approval';
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

        $admins[] = [
            'id' => $id,
            'user_name' => $row['user_name'],
            'name_show' => $dispName,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'ref_key' => $row['ref_key'] ?: ('ADM-' . str_pad((string)$id, 3, '0', STR_PAD_LEFT)),
            'role' => $isRoot ? 'Super Administrator (Root)' : ($isSuperAdmin ? 'Super Administrator' : 'Administrator'),
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
