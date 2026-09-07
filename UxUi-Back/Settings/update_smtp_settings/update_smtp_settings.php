<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    $smtp_host   = isset($_POST['smtp_host']) ? trim($_POST['smtp_host']) : 'smtp.gmail.com';
    $smtp_port   = isset($_POST['smtp_port']) ? (int)$_POST['smtp_port'] : 587;
    $smtp_secure = isset($_POST['smtp_secure']) ? strtolower(trim($_POST['smtp_secure'])) : 'tls';
    $smtp_user   = isset($_POST['smtp_user']) ? trim($_POST['smtp_user']) : '';
    $smtp_pass   = isset($_POST['smtp_pass']) ? trim($_POST['smtp_pass']) : '';
    $from_email  = isset($_POST['from_email']) ? trim($_POST['from_email']) : '';
    $from_name   = isset($_POST['from_name']) ? trim($_POST['from_name']) : 'NEO Solution HR';
    $admin_email = isset($_POST['admin_email']) ? trim($_POST['admin_email']) : 'admin@neosolution.com';
    $is_enabled  = isset($_POST['is_enabled']) ? (($_POST['is_enabled'] === '1' || $_POST['is_enabled'] === 'true' || $_POST['is_enabled'] === 'on') ? 1 : 0) : 0;

    $host_esc   = $conn->real_escape_string($smtp_host);
    $sec_esc    = $conn->real_escape_string($smtp_secure);
    $user_esc   = $conn->real_escape_string($smtp_user);
    $fromE_esc  = $conn->real_escape_string($from_email);
    $fromN_esc  = $conn->real_escape_string($from_name);
    $admE_esc   = $conn->real_escape_string($admin_email);

    $passSql = "";
    if (!empty($smtp_pass) && $smtp_pass !== '••••••••') {
        $pass_esc = $conn->real_escape_string($smtp_pass);
        $passSql = ", `smtp_pass` = '$pass_esc'";
    }

    $chk = $conn->query("SELECT `id` FROM `system_smtp_settings` LIMIT 1");
    if ($chk && $chk->num_rows > 0) {
        $sql = "UPDATE `system_smtp_settings` SET 
            `smtp_host`   = '$host_esc',
            `smtp_port`   = $smtp_port,
            `smtp_secure` = '$sec_esc',
            `smtp_user`   = '$user_esc',
            `from_email`  = '$fromE_esc',
            `from_name`   = '$fromN_esc',
            `admin_email` = '$admE_esc',
            `is_enabled`  = $is_enabled
            $passSql,
            `updated_at`  = NOW()
            WHERE `id` = 1";
    } else {
        $pass_esc = !empty($smtp_pass) ? $conn->real_escape_string($smtp_pass) : '';
        $sql = "INSERT INTO `system_smtp_settings` 
            (`smtp_host`, `smtp_port`, `smtp_secure`, `smtp_user`, `smtp_pass`, `from_email`, `from_name`, `admin_email`, `is_enabled`, `updated_at`)
            VALUES ('$host_esc', $smtp_port, '$sec_esc', '$user_esc', '$pass_esc', '$fromE_esc', '$fromN_esc', '$admE_esc', $is_enabled, NOW())";
    }

    $res = $conn->query($sql);
    if (!$res) {
        throw new Exception($conn->error);
    }

    echo json_encode([
        'status'  => 'success',
        'message' => 'Email & SMTP settings saved successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to save settings: ' . $e->getMessage()
    ]);
}
exit;
