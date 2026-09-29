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
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/Bank_Security.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/Main/Bank_Details/bank_details_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

// Auto-ensure bank_details table exists in MySQL database with TEXT for encrypted ciphertext
function ensureBankDetailsTable() {
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
    @$db->get_result("ALTER TABLE `bank_details` ADD COLUMN IF NOT EXISTS `basic_salary` DECIMAL(12,2) DEFAULT 0.00");
    @$db->get_result("ALTER TABLE `bank_details` ADD COLUMN IF NOT EXISTS `allowances` DECIMAL(12,2) DEFAULT 0.00");
    @$db->get_result("ALTER TABLE `bank_details` ADD COLUMN IF NOT EXISTS `deductions` DECIMAL(12,2) DEFAULT 0.00");
    @$db->get_result("ALTER TABLE `bank_details` ADD COLUMN IF NOT EXISTS `net_salary` DECIMAL(12,2) DEFAULT 0.00");
}

try {
    ensureBankDetailsTable();
} catch (Exception $e) {}

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    @session_start();
}

$sessionUid = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$sessionName = !empty($_SESSION['full_name']) && $_SESSION['full_name'] !== 'Guest' ? trim($_SESSION['full_name']) : ($logged_user_name ?? '');
$sessionCode = !empty($_SESSION['employee_id_code']) ? trim($_SESSION['employee_id_code']) : ($logged_user_emp_code ?? '');

$db = new DataBase();
$conn = $db->get_data_base_connction();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $holder_name    = isset($_POST['val_01']) ? trim($_POST['val_01']) : (isset($_POST['account_holder_name']) ? trim($_POST['account_holder_name']) : (isset($_POST['holder_name']) ? trim($_POST['holder_name']) : ""));
    $bank_name      = isset($_POST['val_02']) ? trim($_POST['val_02']) : (isset($_POST['bank_name']) ? trim($_POST['bank_name']) : "");
    $branch         = isset($_POST['val_03']) ? trim($_POST['val_03']) : (isset($_POST['branch']) ? trim($_POST['branch']) : "");
    $raw_account_no = isset($_POST['val_04']) ? trim($_POST['val_04']) : (isset($_POST['account_number']) ? trim($_POST['account_number']) : (isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : ""));
    
    $employee_id    = isset($_POST['val_05']) ? trim($_POST['val_05']) : (isset($_POST['employee_id']) ? trim($_POST['employee_id']) : "");
    if ((empty($employee_id) || $employee_id === 'EMP-001') && !empty($sessionCode)) {
        $employee_id = $sessionCode;
    }
    if (empty($employee_id)) $employee_id = 'EMP-001';

    $user_id        = isset($_POST['val_06']) ? trim($_POST['val_06']) : (isset($_POST['user_id']) ? trim($_POST['user_id']) : "");
    if ((empty($user_id) || (int)$user_id <= 0) && $sessionUid > 0) {
        $user_id = $sessionUid;
    }
    $user_id_int    = (int)$user_id;

    $employee_name  = isset($_POST['employee_name']) ? trim($_POST['employee_name']) : $holder_name;
    if (empty($employee_name) && !empty($sessionName)) {
        $employee_name = $sessionName;
    }

    $basic_salary   = isset($_POST['basic_salary']) ? (float)$_POST['basic_salary'] : 0.00;
    $allowances     = isset($_POST['allowances']) ? (float)$_POST['allowances'] : 0.00;
    $deductions     = isset($_POST['deductions']) ? (float)$_POST['deductions'] : 0.00;
    $net_salary     = isset($_POST['net_salary']) ? (float)$_POST['net_salary'] : ($basic_salary + $allowances - $deductions);

    if (empty($holder_name) || empty($bank_name) || empty($branch) || empty($raw_account_no)) {
        $state = [
            'status' => 'error',
            'error' => 'Missing required bank details.',
            'message' => 'Please fill in Account Holder, Bank Name, Branch, and Account Number.'
        ];
        $json[] = $state;
    } else {
        $encrypted_acc = Bank_Security::encrypt($raw_account_no);
        $masked_acc = Bank_Security::mask($raw_account_no);

        $safeHolder   = $conn->real_escape_string($holder_name);
        $safeBank     = $conn->real_escape_string($bank_name);
        $safeBranch   = $conn->real_escape_string($branch);
        $safeRawAcc   = $conn->real_escape_string($raw_account_no);
        $safeEncAcc   = $conn->real_escape_string($encrypted_acc);
        $safeEmpId    = $conn->real_escape_string($employee_id);
        $safeEmpName  = $conn->real_escape_string($employee_name);

        // Find existing record matching this employee
        $chkWhere = [];
        if (!empty($safeEmpId) && $safeEmpId !== 'EMP-001') {
            $chkWhere[] = "`employee_id` = '{$safeEmpId}'";
        }
        if ($user_id_int > 0) {
            $chkWhere[] = "`user_id` = {$user_id_int}";
        }
        if (!empty($safeEmpName)) {
            $chkWhere[] = "`employee_name` = '{$safeEmpName}'";
            $chkWhere[] = "`holder_name` = '{$safeEmpName}'";
        }
        if (!empty($safeHolder)) {
            $chkWhere[] = "`holder_name` = '{$safeHolder}'";
        }

        $existing_id = 0;
        if (!empty($chkWhere)) {
            $chkSql = "SELECT `id` FROM `bank_details` WHERE (" . implode(" OR ", $chkWhere) . ") ORDER BY `id` DESC LIMIT 1";
            $chkRes = $conn->query($chkSql);
            if ($chkRes && $r = $chkRes->fetch_assoc()) {
                $existing_id = (int)$r['id'];
            }
        }

        if ($existing_id > 0) {
            $updateSql = "UPDATE `bank_details` SET
                `user_id` = {$user_id_int},
                `employee_id` = '{$safeEmpId}',
                `employee_name` = '{$safeEmpName}',
                `holder_name` = '{$safeHolder}',
                `bank_name` = '{$safeBank}',
                `branch` = '{$safeBranch}',
                `bank_account_number` = '{$safeEncAcc}',
                `account_number` = '{$safeRawAcc}',
                `basic_salary` = {$basic_salary},
                `allowances` = {$allowances},
                `deductions` = {$deductions},
                `net_salary` = {$net_salary},
                `status` = 'Active',
                `ast` = '1'
                WHERE `id` = {$existing_id}";

            $updOk = $conn->query($updateSql);
            if ($updOk) {
                $savedId = $existing_id;
            } else {
                $savedId = 0;
            }
        } else {
            $insertSql = "INSERT INTO `bank_details` (
                `ast`, `sdt`, `user_id`, `employee_id`, `employee_name`, `holder_name`,
                `bank_name`, `branch`, `bank_account_number`, `account_number`,
                `basic_salary`, `allowances`, `deductions`, `net_salary`, `status`
            ) VALUES (
                '1', NOW(), {$user_id_int}, '{$safeEmpId}', '{$safeEmpName}', '{$safeHolder}',
                '{$safeBank}', '{$safeBranch}', '{$safeEncAcc}', '{$safeRawAcc}',
                {$basic_salary}, {$allowances}, {$deductions}, {$net_salary}, 'Active'
            )";

            $insOk = $conn->query($insertSql);
            if ($insOk) {
                $savedId = (int)$conn->insert_id;
            } else {
                $savedId = 0;
            }
        }

        if ($savedId > 0) {
            $state = [
                'error' => '0',
                'status' => 'success',
                'message' => 'Bank details saved successfully.',
                'id' => $savedId,
                'data' => [
                    'id' => $savedId,
                    'account_holder_name' => $holder_name,
                    'holder_name' => $holder_name,
                    'bank_name' => $bank_name,
                    'branch' => $branch,
                    'account_number' => $raw_account_no,
                    'bank_account_number' => $raw_account_no,
                    'masked_account_number' => $masked_acc,
                    'basic_salary' => $basic_salary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'net_salary' => $net_salary,
                    'employee_id' => $employee_id,
                    'user_id' => $user_id_int
                ]
            ];
        } else {
            $errMsg = $conn->error ?: 'Database error saving bank details.';
            $state = [
                'error' => $errMsg,
                'status' => 'error',
                'message' => $errMsg
            ];
        }
        $json[] = $state;
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    $employee_id = isset($_GET['employee_id']) ? trim($_GET['employee_id']) : (isset($_GET['val_01']) ? trim($_GET['val_01']) : "");
    if (empty($employee_id) && !empty($sessionCode)) {
        $employee_id = $sessionCode;
    }

    $name = isset($_GET['name']) ? trim($_GET['name']) : '';
    if (empty($name) && !empty($sessionName)) {
        $name = $sessionName;
    }

    $user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';
    if ((empty($user_id) || (int)$user_id <= 0) && $sessionUid > 0) {
        $user_id = $sessionUid;
    }

    $where_clauses = [];
    if (!empty($employee_id) && $employee_id !== 'EMP-001') {
        $esc_id = $conn->real_escape_string($employee_id);
        $where_clauses[] = "`employee_id` = '{$esc_id}'";
    }
    if (!empty($name) && strtolower($name) !== 'employee' && strtolower($name) !== 'guest') {
        $esc_name = $conn->real_escape_string($name);
        $where_clauses[] = "`holder_name` = '{$esc_name}'";
        $where_clauses[] = "`employee_name` = '{$esc_name}'";
        $where_clauses[] = "`holder_name` LIKE '%{$esc_name}%'";
        $where_clauses[] = "`employee_name` LIKE '%{$esc_name}%'";
    }
    if (!empty($user_id) && is_numeric($user_id) && (int)$user_id > 1) {
        $where_clauses[] = "`user_id` = " . (int)$user_id;
    }

    $row = null;
    if (!empty($where_clauses)) {
        $sql = "SELECT * FROM `bank_details` 
            WHERE (`ast` = '1' OR `ast` IS NULL OR `ast` = '' OR `ast` = 'Active') 
              AND (" . implode(" OR ", $where_clauses) . ") 
            ORDER BY `id` DESC LIMIT 1";
        $get_result = $conn->query($sql);
        if ($get_result && $get_result->num_rows > 0) {
            $row = $get_result->fetch_assoc();
        }
    }

    // Fallback: If still not found, search with employee_id alone
    if (!$row && !empty($employee_id)) {
        $esc_id = $conn->real_escape_string($employee_id);
        $sql2 = "SELECT * FROM `bank_details` 
            WHERE (`ast` = '1' OR `ast` IS NULL OR `ast` = '' OR `ast` = 'Active') 
              AND `employee_id` = '{$esc_id}' 
            ORDER BY `id` DESC LIMIT 1";
        $get_result2 = $conn->query($sql2);
        if ($get_result2 && $get_result2->num_rows > 0) {
            $row = $get_result2->fetch_assoc();
        }
    }

    if ($row) {
        $stored_raw = !empty($row['account_number']) ? trim((string)$row['account_number']) : '';
        $stored_enc = !empty($row['bank_account_number']) ? trim((string)$row['bank_account_number']) : '';

        $plain_acc = '';
        if (!empty($stored_raw) && $stored_raw !== '-') {
            $plain_acc = $stored_raw;
        } elseif (!empty($stored_enc) && $stored_enc !== '-') {
            $plain_acc = Bank_Security::decrypt($stored_enc);
        }

        if (empty($plain_acc) || $plain_acc === '-') {
            $plain_acc = !empty($stored_enc) ? $stored_enc : $stored_raw;
        }

        $masked_acc = Bank_Security::mask($plain_acc);

        $state = [
            'error' => '0',
            'status' => 'success',
            'data' => [
                'id' => isset($row['id']) ? (int)$row['id'] : 0,
                'account_holder_name' => !empty($row['holder_name']) ? $row['holder_name'] : (!empty($row['employee_name']) ? $row['employee_name'] : ''),
                'holder_name' => !empty($row['holder_name']) ? $row['holder_name'] : (!empty($row['employee_name']) ? $row['employee_name'] : ''),
                'bank_name' => !empty($row['bank_name']) ? $row['bank_name'] : '-',
                'branch' => !empty($row['branch']) ? $row['branch'] : '-',
                'account_number' => $plain_acc,
                'bank_account_number' => $plain_acc,
                'masked_account_number' => $masked_acc,
                'basic_salary' => isset($row['basic_salary']) ? (float)$row['basic_salary'] : 0.00,
                'allowances' => isset($row['allowances']) ? (float)$row['allowances'] : 0.00,
                'deductions' => isset($row['deductions']) ? (float)$row['deductions'] : 0.00,
                'net_salary' => isset($row['net_salary']) ? (float)$row['net_salary'] : 0.00,
                'employee_id' => isset($row['employee_id']) ? $row['employee_id'] : 'EMP-001',
                'status' => isset($row['status']) ? $row['status'] : 'Active'
            ]
        ];
    } else {
        $state = [
            'error' => 'No bank records found',
            'status' => 'not_found',
            'data' => null
        ];
    }
    $json[] = $state;
} else {
    $state = [
        'error' => 'Invalid request method',
        'status' => 'error'
    ];
    $json[] = $state;
}

ob_clean();
echo json_encode($json);
exit;
?>
