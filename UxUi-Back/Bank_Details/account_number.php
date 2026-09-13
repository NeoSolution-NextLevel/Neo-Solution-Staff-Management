<?php
/**
 * Bank Details - Account Number Management Endpoint (AES-256 Encrypted)
 * Neo Solution Staff Management System
 */

ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';

// Linux case-sensitivity support: try both Bank_details and Bank_Details
$bankCtrlDir = file_exists(__DIR__ . '/../../Controllers/Main/Bank_details/Bank_Security.php')
    ? __DIR__ . '/../../Controllers/Main/Bank_details/'
    : __DIR__ . '/../../Controllers/Main/Bank_Details/';

if (file_exists($bankCtrlDir . 'Bank_Security.php')) {
    include_once $bankCtrlDir . 'Bank_Security.php';
}
if (file_exists($bankCtrlDir . 'bank_details_ADD_UPDATE.php')) {
    include_once $bankCtrlDir . 'bank_details_ADD_UPDATE.php';
}
if (file_exists($bankCtrlDir . 'bank_details_LIST.php')) {
    include_once $bankCtrlDir . 'bank_details_LIST.php';
}

// Fallback Bank_Security helper so class is guaranteed to exist
if (!class_exists('Bank_Security')) {
    class Bank_Security
    {
        private static $encryption_key = "NeoSolution@SecuredBankEncryptionKey#2026";
        private static $cipher_method = "AES-256-CBC";

        public static function encrypt($plainText)
        {
            if (empty($plainText)) return "";
            if (!function_exists('openssl_cipher_iv_length')) return $plainText;
            $ivLength = openssl_cipher_iv_length(self::$cipher_method);
            $iv = openssl_random_pseudo_bytes($ivLength);
            $encrypted = openssl_encrypt($plainText, self::$cipher_method, self::$encryption_key, 0, $iv);
            return base64_encode($encrypted . "::" . $iv);
        }

        public static function decrypt($cipherText)
        {
            if (empty($cipherText)) return "";
            if (strpos($cipherText, "::") === false && base64_decode($cipherText, true) === false) {
                return $cipherText;
            }
            if (!function_exists('openssl_decrypt')) return $cipherText;
            $decoded = base64_decode($cipherText);
            if (strpos($decoded, "::") !== false) {
                list($encryptedData, $iv) = explode("::", $decoded, 2);
                $decrypted = openssl_decrypt($encryptedData, self::$cipher_method, self::$encryption_key, 0, $iv);
                return $decrypted !== false ? $decrypted : $cipherText;
            }
            return $cipherText;
        }

        public static function mask($accountNumber, $visibleDigits = 4)
        {
            if (empty($accountNumber) || $accountNumber === '-') return '-';
            $str = trim((string)$accountNumber);
            $len = strlen($str);
            if ($len <= $visibleDigits) return $str;
            $lastDigits = substr($str, -$visibleDigits);
            return str_repeat('•', max(4, $len - $visibleDigits)) . $lastDigits;
        }

        public static function sanitize($input)
        {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
    }
}

header('Content-Type: application/json; charset=utf-8');

$json = array();

// Auto-ensure bank_details table exists in MySQL database
function ensureBankDetailsTable() {
    try {
        $db = new DataBase();
        $create_table_sql = "
            CREATE TABLE IF NOT EXISTS `bank_details` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) DEFAULT '1',
                `employee_id` VARCHAR(50) DEFAULT 'EMP-001',
                `employee_name` VARCHAR(255) DEFAULT '',
                `holder_name` VARCHAR(255) DEFAULT '',
                `bank_name` VARCHAR(255) DEFAULT '',
                `branch` VARCHAR(255) DEFAULT '',
                `bank_account_number` TEXT,
                `account_number` TEXT,
                `basic_salary` DECIMAL(12,2) DEFAULT 0.00,
                `allowances` DECIMAL(12,2) DEFAULT 0.00,
                `deductions` DECIMAL(12,2) DEFAULT 0.00,
                `net_salary` DECIMAL(12,2) DEFAULT 0.00,
                `status` VARCHAR(50) DEFAULT 'Active',
                `ast` VARCHAR(10) DEFAULT '1',
                `sdt` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_emp_id` (`employee_id`),
                KEY `idx_user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $db->get_result($create_table_sql);

        $cols = [
            'basic_salary' => "DECIMAL(12,2) DEFAULT 0.00",
            'allowances'   => "DECIMAL(12,2) DEFAULT 0.00",
            'deductions'   => "DECIMAL(12,2) DEFAULT 0.00",
            'net_salary'   => "DECIMAL(12,2) DEFAULT 0.00"
        ];
        foreach ($cols as $c => $type) {
            try {
                $check = $db->get_result("SHOW COLUMNS FROM `bank_details` LIKE '{$c}'");
                if ($check && $check->num_rows === 0) {
                    $db->get_result("ALTER TABLE `bank_details` ADD COLUMN `{$c}` {$type}");
                }
            } catch (Throwable $t) {}
        }
    } catch (Throwable $e) {}
}

try {
    ensureBankDetailsTable();
} catch (Throwable $e) {}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $holder_name    = isset($_POST['val_01']) ? trim($_POST['val_01']) : (isset($_POST['account_holder_name']) ? trim($_POST['account_holder_name']) : (isset($_POST['holder_name']) ? trim($_POST['holder_name']) : ""));
    $bank_name      = isset($_POST['val_02']) ? trim($_POST['val_02']) : (isset($_POST['bank_name']) ? trim($_POST['bank_name']) : "");
    $branch         = isset($_POST['val_03']) ? trim($_POST['val_03']) : (isset($_POST['branch']) ? trim($_POST['branch']) : "");
    $raw_account_no = isset($_POST['val_04']) ? trim($_POST['val_04']) : (isset($_POST['account_number']) ? trim($_POST['account_number']) : (isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : ""));
    $employee_id    = isset($_POST['val_05']) ? trim($_POST['val_05']) : (isset($_POST['employee_id']) ? trim($_POST['employee_id']) : "EMP-001");
    $user_id        = isset($_POST['val_06']) ? trim($_POST['val_06']) : (isset($_POST['user_id']) ? trim($_POST['user_id']) : "1");
    $employee_name  = isset($_POST['employee_name']) ? trim($_POST['employee_name']) : $holder_name;

    $basic_salary   = isset($_POST['basic_salary']) ? (float)$_POST['basic_salary'] : 0.00;
    $allowances     = isset($_POST['allowances']) ? (float)$_POST['allowances'] : 0.00;
    $deductions     = isset($_POST['deductions']) ? (float)$_POST['deductions'] : 0.00;
    $net_salary     = isset($_POST['net_salary']) ? (float)$_POST['net_salary'] : ($basic_salary + $allowances - $deductions);

    if (empty($holder_name) || empty($bank_name) || empty($branch) || empty($raw_account_no)) {
        $state['error'] = "Missing required bank details.";
        $state['status'] = "error";
        $state['message'] = "Please fill in all required bank fields.";
        $json[] = $state;
    } else {
        $masked_acc = Bank_Security::mask($raw_account_no);

        $bank_details_ADD_UPDATE_obj = new bank_details_ADD_UPDATE();
        $bank_details_LIST_obj = new bank_details_LIST();
        $bank_details_LIST_obj->filter_by_employee_id($employee_id);

        $get_result = $bank_details_LIST_obj->get_result();

        $bank_details_ADD_UPDATE_obj->set_data(
            $user_id,
            $employee_id,
            $employee_name,
            $holder_name,
            $bank_name,
            $branch,
            $raw_account_no,
            "Active",
            $basic_salary,
            $allowances,
            $deductions,
            $net_salary
        );

        $existing_id = 0;
        if ($get_result && $get_result->num_rows > 0) {
            $row = $get_result->fetch_assoc();
            if (isset($row['id'])) {
                $existing_id = (int)$row['id'];
            } elseif (isset($row['ID'])) {
                $existing_id = (int)$row['ID'];
            }
        }

        if ($existing_id > 0) {
            $bank_details_ADD_UPDATE_obj->set_id($existing_id);

            if (isset($_POST['del'])) {
                $bank_details_ADD_UPDATE_obj->remove();
            }

            if ($bank_details_ADD_UPDATE_obj->process_update()) {
                $state['error'] = "0";
                $state['status'] = "success";
                $state['message'] = "Bank details and custom salary updated successfully.";
                $state['id'] = $existing_id;
                $state['data'] = [
                    'id' => $existing_id,
                    'account_holder_name' => $holder_name,
                    'holder_name' => $holder_name,
                    'bank_name' => $bank_name,
                    'branch' => $branch,
                    'account_number' => $masked_acc,
                    'bank_account_number' => $masked_acc,
                    'masked_account_number' => $masked_acc,
                    'basic_salary' => $basic_salary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'net_salary' => $net_salary,
                    'employee_id' => $employee_id,
                    'user_id' => $user_id
                ];
            } else {
                $state['error'] = $bank_details_ADD_UPDATE_obj->get_error_msg() ?: "Error updating bank details in database.";
                $state['status'] = "error";
                $state['message'] = $state['error'];
            }
        } else {
            if ($bank_details_ADD_UPDATE_obj->process_new_record()) {
                $state['error'] = "0";
                $state['status'] = "success";
                $state['message'] = "Bank details and custom salary saved successfully.";
                $state['id'] = $bank_details_ADD_UPDATE_obj->get_id();
                $state['data'] = [
                    'id' => $bank_details_ADD_UPDATE_obj->get_id(),
                    'account_holder_name' => $holder_name,
                    'holder_name' => $holder_name,
                    'bank_name' => $bank_name,
                    'branch' => $branch,
                    'account_number' => $masked_acc,
                    'bank_account_number' => $masked_acc,
                    'masked_account_number' => $masked_acc,
                    'basic_salary' => $basic_salary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'net_salary' => $net_salary,
                    'employee_id' => $employee_id,
                    'user_id' => $user_id
                ];
            } else {
                $state['error'] = $bank_details_ADD_UPDATE_obj->get_error_msg() ?: "Error creating bank details record.";
                $state['status'] = "error";
                $state['message'] = $state['error'];
            }
        }
        $json[] = $state;
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    $employee_id = isset($_GET['employee_id']) ? trim($_GET['employee_id']) : (isset($_GET['val_01']) ? trim($_GET['val_01']) : "");
    $name = isset($_GET['name']) ? trim($_GET['name']) : '';
    $user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';

    try {
        $db = new DataBase();
        $conn = $db->get_data_base_connction();

        $where_clauses = [];
        if (!empty($employee_id)) {
            $where_clauses[] = "`employee_id` = '" . $conn->real_escape_string($employee_id) . "'";
        }
        if (!empty($user_id) && is_numeric($user_id)) {
            $where_clauses[] = "`user_id` = '" . (int)$user_id . "'";
        }
        if (!empty($name)) {
            $esc_name = $conn->real_escape_string($name);
            $where_clauses[] = "`holder_name` LIKE '%$esc_name%'";
            $where_clauses[] = "`employee_name` LIKE '%$esc_name%'";
        }

        $row = null;
        if (!empty($where_clauses)) {
            $sql = "SELECT * FROM `bank_details` WHERE `ast` = '1' AND (" . implode(" OR ", $where_clauses) . ") ORDER BY id DESC LIMIT 1";
            $get_result = $conn->query($sql);
            if ($get_result && $get_result->num_rows > 0) {
                $row = $get_result->fetch_assoc();
            }
        }

        // Fallback: If still not found and employee_id was given, try fallback using bank_details_LIST
        if (!$row && !empty($employee_id) && class_exists('bank_details_LIST')) {
            try {
                $bank_details_LIST_obj = new bank_details_LIST();
                $bank_details_LIST_obj->filter_by_employee_id($employee_id);
                $get_result = $bank_details_LIST_obj->get_result();
                if ($get_result && $get_result->num_rows > 0) {
                    $row = $get_result->fetch_assoc();
                }
            } catch (Throwable $t) {}
        }

        if ($row) {
            $stored_acc = !empty($row['bank_account_number']) ? $row['bank_account_number'] : (!empty($row['account_number']) ? $row['account_number'] : '');
            $decrypted_acc = Bank_Security::decrypt($stored_acc);
            $masked_acc = Bank_Security::mask($decrypted_acc);

            $state['error'] = "0";
            $state['status'] = "success";
            $state['data'] = [
                'id' => isset($row['id']) ? (int)$row['id'] : 0,
                'account_holder_name' => !empty($row['holder_name']) ? $row['holder_name'] : (!empty($row['employee_name']) ? $row['employee_name'] : ''),
                'holder_name' => !empty($row['holder_name']) ? $row['holder_name'] : '',
                'bank_name' => !empty($row['bank_name']) ? $row['bank_name'] : '',
                'branch' => !empty($row['branch']) ? $row['branch'] : '',
                'account_number' => $decrypted_acc,
                'bank_account_number' => $decrypted_acc,
                'masked_account_number' => $masked_acc,
                'basic_salary' => isset($row['basic_salary']) ? (float)$row['basic_salary'] : 0.00,
                'allowances' => isset($row['allowances']) ? (float)$row['allowances'] : 0.00,
                'deductions' => isset($row['deductions']) ? (float)$row['deductions'] : 0.00,
                'net_salary' => isset($row['net_salary']) ? (float)$row['net_salary'] : 0.00,
                'employee_id' => isset($row['employee_id']) ? $row['employee_id'] : 'EMP-001',
                'status' => isset($row['status']) ? $row['status'] : 'Active'
            ];
        } else {
            $state['error'] = "No bank records found";
            $state['status'] = "not_found";
            $state['data'] = null;
        }
        $json[] = $state;
    } catch (Throwable $e) {
        $state['error'] = $e->getMessage();
        $state['status'] = "error";
        $state['data'] = null;
        $json[] = $state;
    }
} else {
    $state['error'] = "Invalid request method";
    $state['status'] = "error";
    $json[] = $state;
}

ob_clean();
echo json_encode($json);
exit;
?>
