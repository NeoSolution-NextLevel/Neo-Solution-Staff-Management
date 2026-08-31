<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class salary_payments_LIST
{
    private $sql_search = "";
    private $order_by = " ORDER BY id DESC";
    private $limit = "";

    public function filter_by_employee_id($emp_id) {
        if (!empty($emp_id)) {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $clean = mysqli_real_escape_string($conn, $emp_id);
            $this->sql_search .= " AND (employee_id = '$clean' OR employee_name LIKE '%$clean%')";
        }
    }

    public function filter_by_user_id($user_id) {
        if (!empty($user_id)) {
            $this->sql_search .= " AND user_id = " . (int)$user_id;
        }
    }

    public function filter_by_receipt_no($rec_no) {
        if (!empty($rec_no)) {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $clean = mysqli_real_escape_string($conn, $rec_no);
            $this->sql_search .= " AND receipt_no = '$clean'";
        }
    }

    public function filter_by_payment_month($month) {
        if (!empty($month)) {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $clean = mysqli_real_escape_string($conn, $month);
            $this->sql_search .= " AND payment_month = '$clean'";
        }
    }

    public function set_limit($start, $count) {
        $this->limit = " LIMIT " . (int)$start . ", " . (int)$count;
    }

    public function ensure_table_exists() {
        $db = new DataBase();
        $conn = $db->get_data_base_connction();
        $sql = "CREATE TABLE IF NOT EXISTS `salary_payments` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `receipt_no` VARCHAR(50) NOT NULL,
            `employee_id` VARCHAR(50) DEFAULT 'EMP-001',
            `user_id` INT DEFAULT 1,
            `employee_name` VARCHAR(255) DEFAULT '',
            `department` VARCHAR(100) DEFAULT 'General',
            `job_title` VARCHAR(100) DEFAULT 'Staff',
            `bank_name` VARCHAR(255) DEFAULT '',
            `branch` VARCHAR(255) DEFAULT '',
            `account_number` VARCHAR(100) DEFAULT '',
            `basic_salary` DECIMAL(12,2) DEFAULT 0.00,
            `allowances` DECIMAL(12,2) DEFAULT 0.00,
            `bonus` DECIMAL(12,2) DEFAULT 0.00,
            `deductions` DECIMAL(12,2) DEFAULT 0.00,
            `epf_employee` DECIMAL(12,2) DEFAULT 0.00,
            `net_salary` DECIMAL(12,2) DEFAULT 0.00,
            `payment_month` VARCHAR(50) DEFAULT '',
            `payment_date` DATE DEFAULT NULL,
            `payment_method` VARCHAR(50) DEFAULT 'Bank Transfer',
            `reference_no` VARCHAR(100) DEFAULT '',
            `notes` TEXT DEFAULT NULL,
            `receipt_image` VARCHAR(500) DEFAULT '',
            `status` VARCHAR(50) DEFAULT 'Paid',
            `paid_by` VARCHAR(100) DEFAULT 'Admin',
            `ast` VARCHAR(10) DEFAULT '1',
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_receipt_no` (`receipt_no`),
            KEY `idx_emp_id` (`employee_id`),
            KEY `idx_user_id` (`user_id`),
            KEY `idx_pay_month` (`payment_month`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $conn->query($sql);
        @$conn->query("ALTER TABLE `salary_payments` ADD COLUMN IF NOT EXISTS `receipt_image` VARCHAR(500) DEFAULT ''");
    }

    public function get_all_payments() {
        $this->ensure_table_exists();
        $db = new DataBase();
        $conn = $db->get_data_base_connction();

        $query = "SELECT * FROM salary_payments WHERE (ast = '1' OR ast IS NULL) " . $this->sql_search . $this->order_by . $this->limit;
        $res = $conn->query($query);

        $list = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $acc = !empty($row['account_number']) ? $row['account_number'] : '-';
                $maskedAcc = ($acc !== '-' && strlen($acc) > 4) ? str_repeat('•', strlen($acc) - 4) . substr($acc, -4) : $acc;
                
                $list[] = [
                    'id'              => (int)$row['id'],
                    'receipt_no'      => $row['receipt_no'],
                    'employee_id'     => $row['employee_id'],
                    'user_id'         => (int)$row['user_id'],
                    'employee_name'   => $row['employee_name'],
                    'department'      => !empty($row['department']) ? $row['department'] : 'General',
                    'job_title'       => !empty($row['job_title']) ? $row['job_title'] : 'Staff',
                    'bank_name'       => $row['bank_name'],
                    'branch'          => $row['branch'],
                    'account_number'  => $row['account_number'],
                    'masked_account'  => $maskedAcc,
                    'basic_salary'    => (float)$row['basic_salary'],
                    'allowances'      => (float)$row['allowances'],
                    'bonus'           => (float)$row['bonus'],
                    'deductions'      => (float)$row['deductions'],
                    'epf_employee'    => (float)$row['epf_employee'],
                    'gross_salary'    => (float)($row['basic_salary'] + $row['allowances'] + $row['bonus']),
                    'net_salary'      => (float)$row['net_salary'],
                    'payment_month'   => $row['payment_month'],
                    'payment_date'    => $row['payment_date'],
                    'payment_method'  => $row['payment_method'],
                    'reference_no'    => $row['reference_no'],
                    'notes'           => $row['notes'],
                    'receipt_image'   => !empty($row['receipt_image']) ? $row['receipt_image'] : '',
                    'status'          => $row['status'],
                    'paid_by'         => $row['paid_by'],
                    'created_at'      => $row['created_at']
                ];
            }
        }

        return [
            'status' => 'success',
            'count'  => count($list),
            'data'   => $list
        ];
    }
}
?>
