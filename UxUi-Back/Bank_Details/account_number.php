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
            `status` VARCHAR(50) DEFAULT 'Active',
            `ast` VARCHAR(10) DEFAULT '1',
            `sdt` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_emp_id` (`employee_id`),
            KEY `idx_user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $db->get_result($create_table_sql);
}

try {
    ensureBankDetailsTable();
} catch (Exception $e) {}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $holder_name    = isset($_POST['val_01']) ? trim($_POST['val_01']) : (isset($_POST['account_holder_name']) ? trim($_POST['account_holder_name']) : (isset($_POST['holder_name']) ? trim($_POST['holder_name']) : ""));
    $bank_name      = isset($_POST['val_02']) ? trim($_POST['val_02']) : (isset($_POST['bank_name']) ? trim($_POST['bank_name']) : "");
    $branch         = isset($_POST['val_03']) ? trim($_POST['val_03']) : (isset($_POST['branch']) ? trim($_POST['branch']) : "");
    $raw_account_no = isset($_POST['val_04']) ? trim($_POST['val_04']) : (isset($_POST['account_number']) ? trim($_POST['account_number']) : (isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : ""));
    $employee_id    = isset($_POST['val_05']) ? trim($_POST['val_05']) : (isset($_POST['employee_id']) ? trim($_POST['employee_id']) : "EMP-001");
    $user_id        = isset($_POST['val_06']) ? trim($_POST['val_06']) : (isset($_POST['user_id']) ? trim($_POST['user_id']) : "1");
    $employee_name  = isset($_POST['employee_name']) ? trim($_POST['employee_name']) : $holder_name;

    if (empty($holder_name) || empty($bank_name) || empty($branch) || empty($raw_account_no)) {
        $state['error'] = "Missing required bank details.";
        $state['status'] = "error";
        $state['message'] = "Please fill in all required bank fields.";
        $json[] = $state;
    } else {
        // Encrypt the sensitive bank account number with AES-256
        $encrypted_acc = Bank_Security::encrypt($raw_account_no);
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
            $encrypted_acc,
            "Active"
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
                $state['message'] = "Bank details updated and encrypted successfully.";
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
                $state['message'] = "Bank details saved and encrypted successfully.";
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
    $employee_id = isset($_GET['employee_id']) ? trim($_GET['employee_id']) : (isset($_GET['val_01']) ? trim($_GET['val_01']) : "EMP-001");
    
    $bank_details_LIST_obj = new bank_details_LIST();
    $bank_details_LIST_obj->filter_by_employee_id($employee_id);
    $get_result = $bank_details_LIST_obj->get_result();

    if ($get_result && $get_result->num_rows > 0) {
        $row = $get_result->fetch_assoc();
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
            'employee_id' => isset($row['employee_id']) ? $row['employee_id'] : 'EMP-001',
            'status' => isset($row['status']) ? $row['status'] : 'Active'
        ];
    } else {
        $state['error'] = "No bank records found";
        $state['status'] = "not_found";
        $state['data'] = null;
    }
    $json[] = $state;
} else {
    $state['error'] = "Invalid request method";
    $state['status'] = "error";
    $json[] = $state;
}

ob_clean();
echo json_encode($json);
exit;
?>
