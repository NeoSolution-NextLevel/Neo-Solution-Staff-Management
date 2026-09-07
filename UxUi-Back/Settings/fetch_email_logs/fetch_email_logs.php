<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';

try {
    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Ensure table exists
    $conn->query("CREATE TABLE IF NOT EXISTS `system_email_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `recipient_email` varchar(255) NOT NULL,
        `recipient_name` varchar(150) DEFAULT '',
        `subject` varchar(255) NOT NULL,
        `event_type` varchar(50) NOT NULL DEFAULT 'general',
        `status` varchar(50) NOT NULL DEFAULT 'Sent',
        `error_info` text DEFAULT NULL,
        `body_html` longtext DEFAULT NULL,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $res = $conn->query("SELECT `id`, `recipient_email`, `recipient_name`, `subject`, `event_type`, `status`, `error_info`, `created_at` 
                         FROM `system_email_logs` 
                         ORDER BY `id` DESC 
                         LIMIT 30");

    $logs = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $logs[] = [
                'id'         => (int)$row['id'],
                'recipient'  => $row['recipient_email'] . (!empty($row['recipient_name']) ? " (" . $row['recipient_name'] . ")" : ""),
                'subject'    => $row['subject'],
                'event_type' => $row['event_type'],
                'status'     => $row['status'],
                'info'       => $row['error_info'],
                'created_at' => $row['created_at']
            ];
        }
    }

    echo json_encode([
        'status' => 'success',
        'data'   => $logs
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
}
exit;
