<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../Controllers/Main/Salary_Payments/salary_payments_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/Main/Salary_Payments/salary_payments_LIST.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id    = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : "EMP-001";
    $user_id        = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;
    $employee_name  = isset($_POST['employee_name']) ? trim($_POST['employee_name']) : "";
    $department     = isset($_POST['department']) ? trim($_POST['department']) : "General";
    $job_title      = isset($_POST['job_title']) ? trim($_POST['job_title']) : "Staff";
    $bank_name      = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : "-";
    $branch         = isset($_POST['branch']) ? trim($_POST['branch']) : "-";
    $account_number = isset($_POST['account_number']) ? trim($_POST['account_number']) : "-";
    $basic_salary   = isset($_POST['basic_salary']) ? (float)$_POST['basic_salary'] : 0.00;
    $allowances     = isset($_POST['allowances']) ? (float)$_POST['allowances'] : 0.00;
    $bonus          = isset($_POST['bonus']) ? (float)$_POST['bonus'] : 0.00;
    $deductions     = isset($_POST['deductions']) ? (float)$_POST['deductions'] : 0.00;
    $epf_employee   = isset($_POST['epf_employee']) ? (float)$_POST['epf_employee'] : 0.00;
    $payment_month  = isset($_POST['payment_month']) && !empty(trim($_POST['payment_month'])) ? trim($_POST['payment_month']) : date('F Y');
    $payment_date   = isset($_POST['payment_date']) && !empty(trim($_POST['payment_date'])) ? trim($_POST['payment_date']) : date('Y-m-d');
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : "Bank Transfer";
    $reference_no   = isset($_POST['reference_no']) ? trim($_POST['reference_no']) : ("TXN-" . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8)));
    $notes          = isset($_POST['notes']) ? trim($_POST['notes']) : "Payment receipt uploaded";
    $status         = "Paid";
    $paid_by        = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Admin";

    $net_salary     = isset($_POST['net_salary']) ? (float)$_POST['net_salary'] : 0.00;

    // Handle Receipt Image / PNG Upload
    $receipt_image_path = "";
    $uploadDir = __DIR__ . '/../../uploads/receipts/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['receipt_image']) && !empty($_FILES['receipt_image']['name']) && $_FILES['receipt_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmp  = $_FILES['receipt_image']['tmp_name'];
        $fileName = $_FILES['receipt_image']['name'];
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed  = ['png', 'jpg', 'jpeg', 'webp', 'pdf'];

        if (in_array($ext, $allowed)) {
            $newFileName = 'receipt_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $employee_id) . '_' . time() . '.' . $ext;
            $destPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmp, $destPath)) {
                $receipt_image_path = 'uploads/receipts/' . $newFileName;
            }
        }
    } elseif (!empty($_POST['receipt_image_base64'])) {
        $base64 = $_POST['receipt_image_base64'];
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
            $ext = strtolower($type[1]);
            $decoded = base64_decode($base64);
            if ($decoded !== false) {
                $newFileName = 'receipt_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $employee_id) . '_' . time() . '.' . $ext;
                file_put_contents($uploadDir . $newFileName, $decoded);
                $receipt_image_path = 'uploads/receipts/' . $newFileName;
            }
        }
    }

    if (empty($employee_name)) {
        $state['error']   = "1";
        $state['status']  = "error";
        $state['message'] = "Please select an employee.";
        $json[] = $state;
    } else {
        $payment_ADD_UPDATE_obj = new salary_payments_ADD_UPDATE();
        $receipt_no = $payment_ADD_UPDATE_obj->generate_receipt_no();

        $payment_ADD_UPDATE_obj->set_data(
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
            $receipt_image_path,
            $status,
            $paid_by
        );

        $saveRes = $payment_ADD_UPDATE_obj->save();

        if ($saveRes['status'] === 'success') {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();

            // 1. Auto-insert receipt into `documents` table
            try {
                $conn->query("CREATE TABLE IF NOT EXISTS `documents` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `user_id` int DEFAULT 1,
                    `employee_id` varchar(50) DEFAULT 'EMP-001',
                    `employee_name` varchar(255) DEFAULT '',
                    `doc_type` varchar(255) DEFAULT 'Salary Slip / Payment Receipt',
                    `file_name` varchar(255) DEFAULT '',
                    `file_path` varchar(500) DEFAULT '',
                    `file_size` varchar(50) DEFAULT '1.2 MB',
                    `status` varchar(50) DEFAULT 'Approved',
                    `uploaded_date` datetime DEFAULT CURRENT_TIMESTAMP,
                    `ast` varchar(10) DEFAULT '1',
                    `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

                $docFileName = !empty($receipt_image_path) ? basename($receipt_image_path) : ("Payment_Receipt_" . str_replace([' ', '/', '-'], '_', $payment_month) . "_" . $receipt_no . ".png");
                $docFilePath = !empty($receipt_image_path) ? $receipt_image_path : ("uploads/receipts/" . $docFileName);
                $escEmpName  = mysqli_real_escape_string($conn, $employee_name);
                $escEmpId    = mysqli_real_escape_string($conn, $employee_id);
                $escDocType  = "Salary Slip / Payment Receipt";
                $escFileName = mysqli_real_escape_string($conn, $docFileName);
                $escFilePath = mysqli_real_escape_string($conn, $docFilePath);

                $conn->query("INSERT INTO `documents` (
                    `user_id`, `employee_id`, `employee_name`, `doc_type`, `file_name`, `file_path`, `file_size`, `status`, `uploaded_date`, `ast`, `sdt`
                ) VALUES (
                    $user_id, '$escEmpId', '$escEmpName', '$escDocType', '$escFileName', '$escFilePath', '1.2 MB', 'Approved', NOW(), '1', NOW()
                )");

                if ($net_salary > 0) {
                    @$conn->query("UPDATE `bank_details` SET `net_salary` = $net_salary, `basic_salary` = $net_salary WHERE `employee_id` = '$escEmpId' OR `user_id` = $user_id");
                }
            } catch (Exception $e) {}

            // 2. Auto-insert notification into `system_notifications` table for the employee
            try {
                $conn->query("CREATE TABLE IF NOT EXISTS `system_notifications` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `recipient_role` varchar(50) DEFAULT 'employee',
                    `recipient_name` varchar(150) DEFAULT NULL,
                    `title` varchar(255) NOT NULL,
                    `message` text NOT NULL,
                    `type` varchar(50) DEFAULT 'payment',
                    `is_read` tinyint(1) DEFAULT 0,
                    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

                $notifTitle   = "Payment Receipt Received (" . $payment_date . ")";
                $notifMessage = "Your payment receipt for " . $payment_month . " (Disbursed Date: " . $payment_date . ") has been uploaded. You can view the PNG receipt in your dashboard.";
                $escTitle     = mysqli_real_escape_string($conn, $notifTitle);
                $escMsg       = mysqli_real_escape_string($conn, $notifMessage);
                $escRecName   = mysqli_real_escape_string($conn, $employee_name);

                $conn->query("INSERT INTO `system_notifications` (
                    `recipient_role`, `recipient_name`, `title`, `message`, `type`, `is_read`, `created_at`
                ) VALUES (
                    'employee', '$escRecName', '$escTitle', '$escMsg', 'payment', 0, NOW()
                )");
            } catch (Exception $e) {}

            $state['error']         = "0";
            $state['status']        = "success";
            $state['message']       = "Receipt uploaded and sent to employee successfully!";
            $state['receipt_no']    = $receipt_no;
            $state['receipt_image'] = $receipt_image_path;
            $state['payment_id']    = $saveRes['id'];
            $state['data']          = [
                'id'              => $saveRes['id'],
                'receipt_no'      => $receipt_no,
                'employee_id'     => $employee_id,
                'user_id'         => $user_id,
                'employee_name'   => $employee_name,
                'department'      => $department,
                'job_title'       => $job_title,
                'bank_name'       => $bank_name,
                'branch'          => $branch,
                'account_number'  => $account_number,
                'basic_salary'    => $basic_salary,
                'allowances'      => $allowances,
                'bonus'           => $bonus,
                'deductions'      => $deductions,
                'epf_employee'    => $epf_employee,
                'net_salary'      => $net_salary,
                'payment_month'   => $payment_month,
                'payment_date'    => $payment_date,
                'payment_method'  => $payment_method,
                'reference_no'    => $reference_no,
                'notes'           => $notes,
                'receipt_image'   => $receipt_image_path,
                'status'          => $status,
                'paid_by'         => $paid_by,
                'created_at'      => date('Y-m-d H:i:s')
            ];
            $json[] = $state;
        } else {
            $state['error']   = "1";
            $state['status']  = "error";
            $state['message'] = "Database error: " . $saveRes['message'];
            $json[] = $state;
        }
    }
} else {
    $state['error']   = "1";
    $state['status']  = "error";
    $state['message'] = "Invalid request method.";
    $json[] = $state;
}

ob_clean();
echo json_encode($json);
exit;
?>
