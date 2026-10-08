<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';

$session_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$session_role = strtolower(trim(
    isset($_SESSION['user_role']) && $_SESSION['user_role'] !== ''
        ? $_SESSION['user_role']
        : (isset($_SESSION['ac_type']) ? $_SESSION['ac_type'] : '')
));
$access_level = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;
$is_admin = (strpos($session_role, 'admin') !== false || $access_level === 1 || ($session_user_id === 1 && empty($_SESSION['admin_impersonating'])));
if ($session_user_id === 0 || !$is_admin || !empty($_SESSION['otp_pending'])) {
    http_response_code($session_user_id === 0 || !empty($_SESSION['otp_pending']) ? 401 : 403);
    echo json_encode(['status' => 'error', 'message' => 'Administrator access required.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Ensure system_smtp_settings table exists
    $conn->query("CREATE TABLE IF NOT EXISTS `system_smtp_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `smtp_host` varchar(150) NOT NULL DEFAULT 'smtp.gmail.com',
        `smtp_port` int(11) NOT NULL DEFAULT 587,
        `smtp_secure` varchar(10) NOT NULL DEFAULT 'tls',
        `smtp_user` varchar(150) NOT NULL DEFAULT '',
        `smtp_pass` varchar(255) NOT NULL DEFAULT '',
        `from_email` varchar(150) NOT NULL DEFAULT '',
        `from_name` varchar(150) NOT NULL DEFAULT 'NEO Solution HR',
        `admin_email` varchar(150) NOT NULL DEFAULT 'admin@neosolution.com',
        `is_enabled` tinyint(1) NOT NULL DEFAULT 0,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    // Check if admin_email column exists
    $chkCol = $conn->query("SHOW COLUMNS FROM `system_smtp_settings` LIKE 'admin_email'");
    if ($chkCol && $chkCol->num_rows === 0) {
        @$conn->query("ALTER TABLE `system_smtp_settings` ADD COLUMN `admin_email` varchar(150) NOT NULL DEFAULT 'admin@neosolution.com' AFTER `from_name`");
    }

    $res = $conn->query("SELECT * FROM `system_smtp_settings` ORDER BY `id` ASC LIMIT 1");
    if ($res && $row = $res->fetch_assoc()) {
        $hasPass = !empty($row['smtp_pass']);
        $row['smtp_pass_masked'] = $hasPass ? '••••••••' : '';
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        $default = [
            'id'               => 1,
            'smtp_host'        => 'smtp.gmail.com',
            'smtp_port'        => 587,
            'smtp_secure'      => 'tls',
            'smtp_user'        => '',
            'smtp_pass'        => '',
            'smtp_pass_masked' => '',
            'from_email'       => '',
            'from_name'        => 'NEO Solution HR',
            'admin_email'      => 'admin@neosolution.com',
            'is_enabled'       => 0
        ];
        $conn->query("INSERT INTO `system_smtp_settings` 
            (`smtp_host`, `smtp_port`, `smtp_secure`, `smtp_user`, `smtp_pass`, `from_email`, `from_name`, `admin_email`, `is_enabled`, `updated_at`)
            VALUES ('smtp.gmail.com', 587, 'tls', '', '', '', 'NEO Solution HR', 'admin@neosolution.com', 0, NOW())");
        echo json_encode(['status' => 'success', 'data' => $default]);
    }
} catch (Throwable $e) {
    error_log('SMTP settings fetch failed: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
