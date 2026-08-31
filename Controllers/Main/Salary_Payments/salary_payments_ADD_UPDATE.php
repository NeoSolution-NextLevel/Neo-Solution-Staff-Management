<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class salary_payments_ADD_UPDATE
{
    private $id = 0;
    private $receipt_no = "";
    private $employee_id = "";
    private $user_id = 1;
    private $employee_name = "";
    private $department = "";
    private $job_title = "";
    private $bank_name = "";
    private $branch = "";
    private $account_number = "";
    private $basic_salary = 0.00;
    private $allowances = 0.00;
    private $bonus = 0.00;
    private $deductions = 0.00;
    private $epf_employee = 0.00;
    private $net_salary = 0.00;
    private $payment_month = "";
    private $payment_date = "";
    private $payment_method = "Bank Transfer";
    private $reference_no = "";
    private $notes = "";
    private $receipt_image = "";
    private $status = "Paid";
    private $paid_by = "Admin";
    private $ast = "1";

    public function set_id($get_id) {
        $this->id = (int)$get_id;
    }

    public function set_data(
        $receipt_no,
        $employee_id,
        $user_id,
        $employee_name,
        $department,
        $job_title,
        $bank_name,
        $branch,
        $account_number,
        $basic_salary,
        $allowances,
        $bonus,
        $deductions,
        $epf_employee,
        $net_salary,
        $payment_month,
        $payment_date,
        $payment_method,
        $reference_no,
        $notes,
        $receipt_image = "",
        $status = "Paid",
        $paid_by = "Admin"
    ) {
        $this->receipt_no     = trim($receipt_no);
        $this->employee_id    = trim($employee_id);
        $this->user_id        = (int)$user_id;
        $this->employee_name  = trim($employee_name);
        $this->department     = trim($department);
        $this->job_title      = trim($job_title);
        $this->bank_name      = trim($bank_name);
        $this->branch         = trim($branch);
        $this->account_number = trim($account_number);
        $this->basic_salary   = (float)$basic_salary;
        $this->allowances     = (float)$allowances;
        $this->bonus          = (float)$bonus;
        $this->deductions     = (float)$deductions;
        $this->epf_employee   = (float)$epf_employee;
        $this->net_salary     = (float)$net_salary;
        $this->payment_month  = trim($payment_month);
        $this->payment_date   = !empty($payment_date) ? trim($payment_date) : date('Y-m-d');
        $this->payment_method = !empty($payment_method) ? trim($payment_method) : "Bank Transfer";
        $this->reference_no   = trim($reference_no);
        $this->notes          = trim($notes);
        $this->receipt_image  = trim($receipt_image);
        $this->status         = !empty($status) ? trim($status) : "Paid";
        $this->paid_by        = !empty($paid_by) ? trim($paid_by) : "Admin";
    }

    public function generate_receipt_no() {
        $prefix = "REC-" . date('Ym') . "-";
        $db = new DataBase();
        $conn = $db->get_data_base_connction();
        $this->ensure_table_exists();
        $res = $conn->query("SELECT id FROM salary_payments ORDER BY id DESC LIMIT 1");
        $nextId = 1;
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $nextId = (int)$row['id'] + 1;
        }
        return $prefix . str_pad($nextId, 4, '0', STR_PAD_LEFT);
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

    public function save() {
        $this->ensure_table_exists();
        $db = new DataBase();
        $conn = $db->get_data_base_connction();

        if (empty($this->receipt_no)) {
            $this->receipt_no = $this->generate_receipt_no();
        }

        $receipt_no     = mysqli_real_escape_string($conn, $this->receipt_no);
        $employee_id    = mysqli_real_escape_string($conn, $this->employee_id);
        $user_id        = (int)$this->user_id;
        $employee_name  = mysqli_real_escape_string($conn, $this->employee_name);
        $department     = mysqli_real_escape_string($conn, $this->department);
        $job_title      = mysqli_real_escape_string($conn, $this->job_title);
        $bank_name      = mysqli_real_escape_string($conn, $this->bank_name);
        $branch         = mysqli_real_escape_string($conn, $this->branch);
        $account_number = mysqli_real_escape_string($conn, $this->account_number);
        $basic_salary   = (float)$this->basic_salary;
        $allowances     = (float)$this->allowances;
        $bonus          = (float)$this->bonus;
        $deductions     = (float)$this->deductions;
        $epf_employee   = (float)$this->epf_employee;
        $net_salary     = (float)$this->net_salary;
        $payment_month  = mysqli_real_escape_string($conn, $this->payment_month);
        $payment_date   = mysqli_real_escape_string($conn, $this->payment_date);
        $payment_method = mysqli_real_escape_string($conn, $this->payment_method);
        $reference_no   = mysqli_real_escape_string($conn, $this->reference_no);
        $notes          = mysqli_real_escape_string($conn, $this->notes);
        $receipt_image  = mysqli_real_escape_string($conn, $this->receipt_image);
        $status         = mysqli_real_escape_string($conn, $this->status);
        $paid_by        = mysqli_real_escape_string($conn, $this->paid_by);

        if ($this->id > 0) {
            $query = "UPDATE salary_payments SET 
                receipt_no = '$receipt_no',
                employee_id = '$employee_id',
                user_id = $user_id,
                employee_name = '$employee_name',
                department = '$department',
                job_title = '$job_title',
                bank_name = '$bank_name',
                branch = '$branch',
                account_number = '$account_number',
                basic_salary = $basic_salary,
                allowances = $allowances,
                bonus = $bonus,
                deductions = $deductions,
                epf_employee = $epf_employee,
                net_salary = $net_salary,
                payment_month = '$payment_month',
                payment_date = '$payment_date',
                payment_method = '$payment_method',
                reference_no = '$reference_no',
                notes = '$notes',
                receipt_image = '$receipt_image',
                status = '$status',
                paid_by = '$paid_by'
                WHERE id = " . $this->id;
            
            $res = $conn->query($query);
            return [
                'status' => $res ? 'success' : 'error',
                'id' => $this->id,
                'receipt_no' => $this->receipt_no,
                'receipt_image' => $this->receipt_image,
                'message' => $res ? 'Payment updated successfully' : $conn->error
            ];
        } else {
            $query = "INSERT INTO salary_payments (
                receipt_no,
                employee_id,
                user_id,
                employee_name,
                department,
                job_title,
                bank_name,
                branch,
                account_number,
                basic_salary,
                allowances,
                bonus,
                deductions,
                epf_employee,
                net_salary,
                payment_month,
                payment_date,
                payment_method,
                reference_no,
                notes,
                receipt_image,
                status,
                paid_by,
                ast,
                created_at
            ) VALUES (
                '$receipt_no',
                '$employee_id',
                $user_id,
                '$employee_name',
                '$department',
                '$job_title',
                '$bank_name',
                '$branch',
                '$account_number',
                $basic_salary,
                $allowances,
                $bonus,
                $deductions,
                $epf_employee,
                $net_salary,
                '$payment_month',
                '$payment_date',
                '$payment_method',
                '$reference_no',
                '$notes',
                '$receipt_image',
                '$status',
                '$paid_by',
                '1',
                NOW()
            )";

            $res = $conn->query($query);
            $insertedId = $conn->insert_id;

            return [
                'status' => $res ? 'success' : 'error',
                'id' => $insertedId,
                'receipt_no' => $this->receipt_no,
                'receipt_image' => $this->receipt_image,
                'message' => $res ? 'Payment processed successfully' : $conn->error
            ];
        }
    }
}
?>
