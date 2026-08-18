<?php
include_once __DIR__ . '/DB.php';

class SystemNotifications
{
    public static function ensure_table()
    {
        $db = new DataBase();
        $db->get_result("CREATE TABLE IF NOT EXISTS `system_notifications` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `recipient_role` varchar(50) DEFAULT 'admin',
            `recipient_name` varchar(150) DEFAULT NULL,
            `title` varchar(255) NOT NULL,
            `message` text NOT NULL,
            `type` varchar(50) DEFAULT 'general',
            `is_read` tinyint(1) DEFAULT 0,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public static function create($title, $message, $type = 'general', $recipient_role = 'admin', $recipient_name = null)
    {
        self::ensure_table();
        $db = new DataBase();

        $title_esc = addslashes(trim($title));
        $msg_esc   = addslashes(trim($message));
        $type_esc  = addslashes(trim($type));
        $role_esc  = addslashes(trim($recipient_role));
        $name_esc  = $recipient_name ? "'" . addslashes(trim($recipient_name)) . "'" : "NULL";

        $sql = "INSERT INTO `system_notifications` (
            `recipient_role`,
            `recipient_name`,
            `title`,
            `message`,
            `type`,
            `is_read`,
            `created_at`
        ) VALUES (
            '$role_esc',
            $name_esc,
            '$title_esc',
            '$msg_esc',
            '$type_esc',
            0,
            NOW()
        )";

        return $db->get_result($sql);
    }
}
?>
