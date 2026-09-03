<?php

include_once __DIR__ . '/DB.php';

/**
 * Create today's presence record for the authenticated employee.
 * Employment status and daily activity are intentionally separate concepts.
 */
function update_daily_employee_presence()
{
    if (session_status() !== PHP_SESSION_ACTIVE || empty($_SESSION['user_id'])) {
        return false;
    }

    $role = strtolower(trim((string)($_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '')));
    if ($role === '' || strpos($role, 'admin') !== false || strpos($role, 'employee') === false) {
        return false;
    }

    $userId = (int)$_SESSION['user_id'];
    if ($userId <= 0) {
        return false;
    }

    $db = new DataBase();
    $db->get_result("CREATE TABLE IF NOT EXISTS `daily_employee_presence` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `employee_profile_id` int DEFAULT NULL,
        `presence_date` date NOT NULL,
        `first_seen_at` datetime NOT NULL,
        `last_seen_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_user_presence_date` (`user_id`, `presence_date`),
        KEY `idx_presence_date` (`presence_date`),
        KEY `idx_presence_profile` (`employee_profile_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $profileId = 0;
    $profileResult = $db->get_result("SELECT id FROM `employee_profiles` WHERE user_id = {$userId} LIMIT 1");
    if ($profileResult && ($profile = $profileResult->fetch_assoc())) {
        $profileId = (int)$profile['id'];
    }

    $now = date('Y-m-d H:i:s');
    $today = date('Y-m-d');
    $db->get_result("INSERT INTO `daily_employee_presence`
        (`user_id`, `employee_profile_id`, `presence_date`, `first_seen_at`, `last_seen_at`)
        VALUES ({$userId}, " . ($profileId > 0 ? $profileId : 'NULL') . ", '{$today}', '{$now}', '{$now}')
        ON DUPLICATE KEY UPDATE `last_seen_at` = '{$now}',
        `employee_profile_id` = COALESCE(`employee_profile_id`, VALUES(`employee_profile_id`))");

    // Keep the existing device list useful for the online-device page as well.
    $token = isset($_SESSION['session_token']) ? addslashes((string)$_SESSION['session_token']) : '';
    if ($token !== '') {
        $db->get_result("UPDATE `main_user_login_device`
            SET `last_activity` = '{$now}'
            WHERE `main_user_login_id` = {$userId} AND `session_token` = '{$token}'");
    }

    return true;
}

?>