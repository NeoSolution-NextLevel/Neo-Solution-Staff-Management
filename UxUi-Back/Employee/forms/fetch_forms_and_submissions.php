<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../../imports/need/session_setup.php';
    include_once __DIR__ . '/../../../imports/need/DB.php';

    if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Authentication required.']);
        exit;
    }

    $db = new DataBase();
    $conn = $db->get_data_base_connction();

    // Ensure tables exist
    $conn->query("CREATE TABLE IF NOT EXISTS `employee_registration_forms` (
      `id` int NOT NULL AUTO_INCREMENT,
      `form_token` varchar(64) NOT NULL,
      `title` varchar(255) NOT NULL DEFAULT 'Employee Registration Form',
      `department` varchar(100) DEFAULT 'Engineering',
      `job_title` varchar(100) DEFAULT 'Staff',
      `target_email` varchar(255) DEFAULT NULL,
      `created_by` int NOT NULL DEFAULT 1,
      `status` varchar(30) DEFAULT 'active',
      `allow_multiple` tinyint(1) DEFAULT 1,
      `expires_at` datetime DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `unique_form_token` (`form_token`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $conn->query("CREATE TABLE IF NOT EXISTS `employee_form_submissions` (
      `id` int NOT NULL AUTO_INCREMENT,
      `form_id` int DEFAULT NULL,
      `form_token` varchar(64) DEFAULT NULL,
      `first_name` varchar(100) NOT NULL,
      `last_name` varchar(100) NOT NULL,
      `email` varchar(255) NOT NULL,
      `phone_number` varchar(50) NOT NULL,
      `password_hash` varchar(450) NOT NULL,
      `department` varchar(100) NOT NULL DEFAULT 'Engineering',
      `job_title` varchar(100) NOT NULL DEFAULT 'Staff',
      `nic` varchar(50) DEFAULT NULL,
      `dob` date DEFAULT NULL,
      `gender` varchar(20) DEFAULT 'Male',
      `address` text DEFAULT NULL,
      `emergency_contact_name` varchar(255) DEFAULT NULL,
      `emergency_contact_phone` varchar(50) DEFAULT NULL,
      `status` varchar(30) DEFAULT 'pending',
      `admin_notes` text DEFAULT NULL,
      `reviewed_by` int DEFAULT NULL,
      `reviewed_at` datetime DEFAULT NULL,
      `otp_code` varchar(10) DEFAULT NULL,
      `otp_expires_at` datetime DEFAULT NULL,
      `is_otp_verified` tinyint(1) DEFAULT 0,
      `otp_verified_at` datetime DEFAULT NULL,
      `created_user_id` int DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_form_token` (`form_token`),
      KEY `idx_email` (`email`),
      KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $base_url = rtrim($GLOBALS['home_page'], '/');

    // Fetch Forms
    $forms = [];
    $forms_res = $conn->query("SELECT * FROM `employee_registration_forms` ORDER BY `id` DESC");
    if ($forms_res && $forms_res->num_rows > 0) {
        while ($f = $forms_res->fetch_assoc()) {
            $f['form_url'] = $base_url . '/UxUi/Main/Employee-Registration-Form.php?token=' . urlencode($f['form_token']);
            $forms[] = $f;
        }
    }

    // Fetch Submissions
    $submissions = [];
    $pending_count = 0;
    $approved_count = 0;
    $rejected_count = 0;

    $sub_res = $conn->query("SELECT 
        s.*, 
        f.title AS form_title
    FROM `employee_form_submissions` s
    LEFT JOIN `employee_registration_forms` f ON s.form_id = f.id
    ORDER BY s.id DESC");

    if ($sub_res && $sub_res->num_rows > 0) {
        while ($s = $sub_res->fetch_assoc()) {
            unset($s['password_hash']); // Security: do not expose password hashes
            $st = strtolower($s['status']);
            if ($st === 'pending') $pending_count++;
            elseif ($st === 'approved') $approved_count++;
            elseif ($st === 'rejected') $rejected_count++;

            $submissions[] = $s;
        }
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'data' => [
            'forms' => $forms,
            'submissions' => $submissions,
            'stats' => [
                'total_forms' => count($forms),
                'total_submissions' => count($submissions),
                'pending_count' => $pending_count,
                'approved_count' => $approved_count,
                'rejected_count' => $rejected_count
            ]
        ]
    ]);
    exit;

} catch (\Throwable $e) {
    ob_end_clean();
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error: ' . $e->getMessage()
    ]);
    exit;
}
