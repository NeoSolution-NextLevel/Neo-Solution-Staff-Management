<?php

include_once __DIR__ . '/../Company_Info/Company_Info_Variable_List.php';
include_once __DIR__ . '/Email_Sending_Final.php';
include_once __DIR__ . '/../need/DB.php';

class Email {

    private $email_address;
    private $subject;
    private $html_header_n_footer;
    private $html_data;
    private $heder_name = "";
    private $company_variable_list;
//    ===============================================================
    private $compnay_name;
    private $default_system_mail;
    private $event_type = 'general';

    public function __construct($email_address, $subject, $html_data, $event_type = 'general') {
        $this->email_address = $email_address;
        $this->subject = $subject;
        $this->html_data = $html_data;
        $this->event_type = $event_type;
        $this->company_variable_list = new Company_Info_Variable_List();
        $this->compnay_name = $this->company_variable_list->get_compnay_name();
        $this->default_system_mail = $this->company_variable_list->get_compnay_default_sending_email();

        $this->set_html_header_n_footer();
    }

    public function set_header_name($name) {
        $this->heder_name = $name;
    }

    public function set_event_type($type) {
        $this->event_type = $type;
    }

    private function set_html_header_n_footer() {
        $this->html_header_n_footer = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>" . htmlspecialchars($this->subject) . "</title>
    <style type='text/css'>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body style='margin:0; padding:0; background-color:#f1f5f9; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;'>
    <table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#f1f5f9' style='padding: 30px 15px;'>
    <tr>
      <td align='center'>

        <!-- Wrapper -->
        <table width='100%' max-width='600' cellpadding='0' cellspacing='0' border='0' style='max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;'>

          <!-- Header / Brand -->
          <tr>
            <td bgcolor='#0f172a' style='padding: 26px 32px; border-bottom: 3px solid #2563eb;'>
              <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                <tr>
                  <td>
                    <div style='display: flex; align-items: center;'>
                      <span style='color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: -0.5px;'>" . htmlspecialchars($this->compnay_name) . "</span>
                      <span style='color: #94a3b8; font-size: 13px; margin-left: 8px; font-weight: 500;'>| Staff Management</span>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style='padding: 32px; color: #334155; font-size: 15px; line-height: 1.6;'>
              " . $this->html_data . "
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align='center' bgcolor='#f8fafc' style='padding: 20px 32px; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0;'>
              <p style='margin: 0 0 4px 0;'><strong>" . $this->company_variable_list->get_compnay_footer_txt() . "</strong></p>
              <p style='margin: 0; color: #94a3b8;'>This is an automated system notification from the NEO HR Staff Portal.</p>
            </td>
          </tr>

        </table>
        <!-- End Wrapper -->

      </td>
    </tr>
  </table>
</body>
</html>";
    }

    private $cc_emails = [];
    private $bcc_emails = [];

    public function set_cc_email($get_name, $get_email) {
        $this->cc_emails[] = ['name' => $get_name, 'email' => $get_email];
    }

    public function set_bcc_email($get_name, $get_email) {
        $this->bcc_emails[] = ['name' => $get_name, 'email' => $get_email];
    }

    public function add_cc_email_data_bunch(array $recipients) {
        foreach ($recipients as $recipient) {
            if (isset($recipient['name']) && isset($recipient['email'])) {
                $this->cc_emails[] = $recipient;
            }
        }
    }

    public function add_bcc_email_data_bunch(array $recipients) {
        foreach ($recipients as $recipient) {
            if (isset($recipient['name']) && isset($recipient['email'])) {
                $this->bcc_emails[] = $recipient;
            }
        }
    }

    private $last_error = '';

    public function get_last_error() {
        return $this->last_error;
    }

    public function send_email() {
        $get_email_sending_obj = new Email_Sender($this->email_address, $this->subject, $this->html_header_n_footer, $this->event_type);
        $get_email_sending_obj->add_bcc_email_data_bunch($this->bcc_emails);
        $get_email_sending_obj->add_cc_email_data_bunch($this->cc_emails);

        $result = $get_email_sending_obj->send();
        $this->last_error = $get_email_sending_obj->get_last_error();
        return $result;
    }

    // =========================================================================
    // Leave Management Email Dispatchers (Built directly in imports/email)
    // =========================================================================

    /**
     * Resolve Employee Email by name or username
     */
    public static function resolve_employee_email($employeeName, $fallbackEmail = '') {
        if (!empty($fallbackEmail) && filter_var($fallbackEmail, FILTER_VALIDATE_EMAIL)) {
            return trim($fallbackEmail);
        }

        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $name_esc = $conn->real_escape_string(trim((string)$employeeName));

            // 1. Try employees table
            $q1 = $conn->query("SELECT `email_address` FROM `employees` WHERE `fullname` = '$name_esc' OR `fullname` LIKE '%$name_esc%' LIMIT 1");
            if ($q1 && $r1 = $q1->fetch_assoc()) {
                if (!empty($r1['email_address']) && filter_var($r1['email_address'], FILTER_VALIDATE_EMAIL)) {
                    return trim($r1['email_address']);
                }
            }

            // 2. Try main_user_login table
            $q2 = $conn->query("SELECT `user_name` FROM `main_user_login` WHERE (`name_show` = '$name_esc' OR CONCAT(`first_name`, ' ', `last_name`) = '$name_esc' OR `first_name` = '$name_esc') LIMIT 1");
            if ($q2 && $r2 = $q2->fetch_assoc()) {
                if (!empty($r2['user_name']) && filter_var($r2['user_name'], FILTER_VALIDATE_EMAIL)) {
                    return trim($r2['user_name']);
                }
            }

            // 3. Try employee_profiles table
            $q3 = $conn->query("SELECT `email` FROM `employee_profiles` WHERE `full_name` = '$name_esc' OR `first_name` = '$name_esc' OR `full_name` LIKE '%$name_esc%' LIMIT 1");
            if ($q3 && $r3 = $q3->fetch_assoc()) {
                if (!empty($r3['email']) && filter_var($r3['email'], FILTER_VALIDATE_EMAIL)) {
                    return trim($r3['email']);
                }
            }

            // 4. Fallback to first active employee in database
            $q4 = $conn->query("SELECT `email` FROM `employee_profiles` WHERE `email` IS NOT NULL AND `email` != '' LIMIT 1");
            if ($q4 && $r4 = $q4->fetch_assoc()) {
                if (!empty($r4['email']) && filter_var($r4['email'], FILTER_VALIDATE_EMAIL)) {
                    return trim($r4['email']);
                }
            }
        } catch (Exception $e) {}

        return !empty($fallbackEmail) ? $fallbackEmail : 'rathugedn@gmail.com';
    }

    /**
     * Resolve Admin Email address from system_smtp_settings or main_user_login
     */
    public static function resolve_admin_email() {
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $res = $conn->query("SELECT `admin_email` FROM `system_smtp_settings` ORDER BY `id` ASC LIMIT 1");
            if ($res && $row = $res->fetch_assoc()) {
                if (!empty($row['admin_email']) && filter_var($row['admin_email'], FILTER_VALIDATE_EMAIL)) {
                    return trim($row['admin_email']);
                }
            }

            $q = $conn->query("SELECT `user_name` FROM `main_user_login` WHERE `ac_type` LIKE '%Admin%' OR `main_user_account_access_level_list_id` = '1' ORDER BY `id` ASC LIMIT 1");
            if ($q && $r = $q->fetch_assoc()) {
                if (!empty($r['user_name']) && filter_var($r['user_name'], FILTER_VALIDATE_EMAIL)) {
                    return trim($r['user_name']);
                }
            }
        } catch (Exception $e) {}

        return 'rathugedn@gmail.com';
    }

    public static function is_notification_enabled($role = 'admin', $key = 'email_notifications', $userId = '') {
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $tbl = ($role === 'admin') ? 'admin_settings' : 'employee_settings';
            $keyEsc = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
            
            if (!empty($userId)) {
                $uidEsc = $conn->real_escape_string((string)$userId);
                $res = $conn->query("SELECT `$keyEsc` FROM `$tbl` WHERE `user_id` = '$uidEsc' LIMIT 1");
                if ($res && $row = $res->fetch_assoc()) {
                    if (isset($row[$keyEsc])) {
                        return ((int)$row[$keyEsc] === 1);
                    }
                }
            } else if ($role === 'admin') {
                $res = $conn->query("SELECT `$keyEsc` FROM `$tbl` ORDER BY `id` ASC LIMIT 1");
                if ($res && $row = $res->fetch_assoc()) {
                    if (isset($row[$keyEsc])) {
                        return ((int)$row[$keyEsc] === 1);
                    }
                }
            }
        } catch (Exception $e) {}
        return true;
    }

    /**
     * Send email to Admin when employee submits a leave request
     */
    public static function send_leave_request_notification(array $leaveData) {
        try {
            // Check Admin notification preferences
            if (!self::is_notification_enabled('admin', 'email_notifications') || !self::is_notification_enabled('admin', 'leave_status')) {
                return true; // Admin opted out of email notifications
            }

            $adminEmail = self::resolve_admin_email();
            $empName    = !empty($leaveData['employee']) ? $leaveData['employee'] : 'Employee';
            $leaveType  = !empty($leaveData['type']) ? $leaveData['type'] : 'Annual Leave';
            $from       = !empty($leaveData['from']) ? $leaveData['from'] : date('Y-m-d');
            $to         = !empty($leaveData['to']) ? $leaveData['to'] : $from;
            $days       = !empty($leaveData['days']) ? (int)$leaveData['days'] : 1;
            $reason     = !empty($leaveData['reason']) ? $leaveData['reason'] : 'Not specified';
            $submitTime = date('M d, Y h:i A');

            $fromFmt = date('M d, Y', strtotime($from));
            $toFmt   = date('M d, Y', strtotime($to));
            $durationStr = ($from === $to) ? $fromFmt : "$fromFmt to $toFmt";

            $subject = "[NEO HR] New Leave Request: $empName ($leaveType)";

            $body = "
                <div style='margin-bottom: 20px;'>
                  <span style='background:#fef3c7; color:#92400e; font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; text-transform:uppercase;'>Action Required</span>
                </div>
                <h2 style='margin: 0 0 16px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>New Leave Request Submitted</h2>
                <p style='margin: 0 0 18px 0; color: #475569;'>
                  Employee <strong>" . htmlspecialchars($empName) . "</strong> has requested leave and is awaiting your approval.
                </p>
                <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px; margin: 16px 0 24px 0;'>
                  <table width='100%' cellpadding='6' cellspacing='0' style='font-size: 14px;'>
                    <tr>
                      <td style='color: #64748b; width: 35%; font-weight: 600;'>Employee Name:</td>
                      <td style='color: #0f172a; font-weight: 700;'>" . htmlspecialchars($empName) . "</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Leave Type:</td>
                      <td style='color: #2563eb; font-weight: 600;'>" . htmlspecialchars($leaveType) . "</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Duration:</td>
                      <td style='color: #0f172a;'>" . htmlspecialchars($durationStr) . " <span style='background:#e2e8f0; padding:2px 8px; border-radius:12px; font-size:12px; font-weight:600; margin-left:6px;'>" . (int)$days . " Day(s)</span></td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Reason:</td>
                      <td style='color: #334155; font-style: italic;'>&ldquo;" . htmlspecialchars($reason) . "&rdquo;</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Submitted On:</td>
                      <td style='color: #64748b;'>" . htmlspecialchars($submitTime) . "</td>
                    </tr>
                  </table>
                </div>
                <div style='text-align: center; margin: 28px 0 10px;'>
                  <a href='http://localhost:3000/UxUi/Admin_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>Review in Admin Portal</a>
                </div>
            ";

            $emailObj = new self($adminEmail, $subject, $body, 'leave_requested');
            return $emailObj->send_email();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send email to Employee when leave is Approved or Rejected
     */
    public static function send_leave_status_notification($leaveId, $status = 'Approved', $adminComment = '') {
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $leaveId = (int)$leaveId;

            $q = $conn->query("SELECT * FROM `leave_requests` WHERE `id` = '$leaveId' LIMIT 1");
            if (!$q || $q->num_rows === 0) {
                return false;
            }
            $leave = $q->fetch_assoc();

            $empUserId = !empty($leave['user_id']) ? $leave['user_id'] : '';
            if (!self::is_notification_enabled('employee', 'email_notifications', $empUserId) || !self::is_notification_enabled('employee', 'leave_status', $empUserId)) {
                return true; // Employee opted out of leave email notifications
            }

            $empName   = !empty($leave['employee_name']) ? $leave['employee_name'] : 'Employee';
            $leaveType = !empty($leave['leave_type']) ? $leave['leave_type'] : 'Leave';
            $from      = !empty($leave['from_date']) ? $leave['from_date'] : date('Y-m-d');
            $to        = !empty($leave['to_date']) ? $leave['to_date'] : $from;
            $days      = !empty($leave['days']) ? (int)$leave['days'] : 1;
            $reason    = !empty($leave['reason']) ? $leave['reason'] : '';

            $empEmail  = self::resolve_employee_email($empName, $leave['employee_email'] ?? '');
            $decisionTime = date('M d, Y h:i A');

            $fromFmt = date('M d, Y', strtotime($from));
            $toFmt   = date('M d, Y', strtotime($to));
            $durationStr = ($from === $to) ? $fromFmt : "$fromFmt to $toFmt";

            $isApproved = (strtolower($status) === 'approved');
            $badgeText  = $isApproved ? 'Approved' : 'Rejected';
            $statusBg   = $isApproved ? '#ecfdf5' : '#fef2f2';
            $statusText = $isApproved ? '#065f46' : '#991b1b';

            $subject = $isApproved 
                ? "[NEO HR] Leave Request Approved: $leaveType"
                : "[NEO HR] Leave Request Update: Rejected ($leaveType)";

            $commentHtml = '';
            if (!empty($adminComment)) {
                $commentHtml = "
                  <tr>
                    <td style='color: #64748b; font-weight: 600;'>Admin Remark:</td>
                    <td style='color: #0f172a;'>&ldquo;" . htmlspecialchars($adminComment) . "&rdquo;</td>
                  </tr>
                ";
            }

            $body = "
                <div style='margin-bottom: 20px;'>
                  <span style='background: {$statusBg}; color: {$statusText}; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                    {$badgeText}
                  </span>
                </div>
                <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                  " . ($isApproved ? "Your Leave Request Has Been Approved" : "Your Leave Request Was Not Approved") . "
                </h2>
                <p style='margin: 0 0 18px 0; color: #475569;'>
                  Dear <strong>" . htmlspecialchars($empName) . "</strong>,<br>
                  This is to inform you that your <strong>" . htmlspecialchars($leaveType) . "</strong> request has been <strong>" . strtolower($badgeText) . "</strong> by management.
                </p>
                <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px; margin: 16px 0 24px 0;'>
                  <table width='100%' cellpadding='6' cellspacing='0' style='font-size: 14px;'>
                    <tr>
                      <td style='color: #64748b; width: 35%; font-weight: 600;'>Status:</td>
                      <td>
                        <span style='background: {$statusBg}; color: {$statusText}; font-weight: 700; font-size: 12.5px; padding: 3px 10px; border-radius: 12px;'>
                          {$badgeText}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Leave Type:</td>
                      <td style='color: #0f172a; font-weight: 600;'>" . htmlspecialchars($leaveType) . "</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Duration:</td>
                      <td style='color: #0f172a;'>" . htmlspecialchars($durationStr) . " (" . (int)$days . " Day(s))</td>
                    </tr>
                    " . (!empty($reason) ? "<tr><td style='color: #64748b; font-weight: 600;'>Reason:</td><td style='color: #64748b; font-style: italic;'>&ldquo;" . htmlspecialchars($reason) . "&rdquo;</td></tr>" : "") . "
                    {$commentHtml}
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Processed Date:</td>
                      <td style='color: #64748b;'>" . htmlspecialchars($decisionTime) . "</td>
                    </tr>
                  </table>
                </div>
                <div style='text-align: center; margin: 28px 0 10px;'>
                  <a href='http://localhost:3000/UxUi/Employee_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>View in Employee Portal</a>
                </div>
            ";

            $eventType = $isApproved ? 'leave_approved' : 'leave_rejected';
            $emailObj = new self($empEmail, $subject, $body, $eventType);
            return $emailObj->send_email();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send email to Employee when salary payment receipt / voucher is processed
     */
    public static function send_salary_payment_notification(array $paymentData) {
        try {
            $empName        = !empty($paymentData['employee_name']) ? trim($paymentData['employee_name']) : 'Employee';
            $empId          = !empty($paymentData['employee_id']) ? trim($paymentData['employee_id']) : '';
            $userId         = !empty($paymentData['user_id']) ? $paymentData['user_id'] : '';
            $fallbackEmail  = !empty($paymentData['employee_email']) ? trim($paymentData['employee_email']) : '';
            
            // Check preference
            if (!self::is_notification_enabled('employee', 'email_notifications', $userId)) {
                return true;
            }

            $recipientEmail = self::resolve_employee_email($empName, $fallbackEmail);
            if (empty($recipientEmail)) {
                return false;
            }

            $month          = !empty($paymentData['payment_month']) ? htmlspecialchars($paymentData['payment_month']) : date('F Y');
            $date           = !empty($paymentData['payment_date']) ? htmlspecialchars($paymentData['payment_date']) : date('Y-m-d');
            $paymentMethod  = !empty($paymentData['payment_method']) ? htmlspecialchars($paymentData['payment_method']) : 'Bank Transfer';
            $receiptNo      = !empty($paymentData['receipt_no']) ? htmlspecialchars($paymentData['receipt_no']) : '-';
            $referenceNo    = !empty($paymentData['reference_no']) ? htmlspecialchars($paymentData['reference_no']) : '-';
            $bankName       = !empty($paymentData['bank_name']) ? htmlspecialchars($paymentData['bank_name']) : '';
            $branch         = !empty($paymentData['branch']) ? htmlspecialchars($paymentData['branch']) : '';
            $rawAccount     = !empty($paymentData['account_number']) ? trim($paymentData['account_number']) : '';
            $maskedAccount  = strlen($rawAccount) > 4 ? str_repeat('•', max(0, strlen($rawAccount) - 4)) . substr($rawAccount, -4) : ($rawAccount ?: 'N/A');

            $basicSalary    = isset($paymentData['basic_salary']) ? (float)$paymentData['basic_salary'] : 0.0;
            $allowances     = isset($paymentData['allowances']) ? (float)$paymentData['allowances'] : 0.0;
            $bonus          = isset($paymentData['bonus']) ? (float)$paymentData['bonus'] : 0.0;
            $deductions     = isset($paymentData['deductions']) ? (float)$paymentData['deductions'] : 0.0;
            $epfEmployee    = isset($paymentData['epf_employee']) ? (float)$paymentData['epf_employee'] : 0.0;
            $netSalary      = isset($paymentData['net_salary']) ? (float)$paymentData['net_salary'] : ($basicSalary + $allowances + $bonus - $deductions - $epfEmployee);

            $subject = "[NEO HR] Salary Disbursed: {$month} Pay Slip Receipt";

            $bankInfoRow = '';
            if (!empty($bankName) && $bankName !== '-') {
                $bankDesc = $bankName . (!empty($branch) && $branch !== '-' ? " ({$branch})" : "") . " - A/C: {$maskedAccount}";
                $bankInfoRow = "
                    <tr>
                      <td style='color: #64748b; font-weight: 600; padding: 6px 0;'>Remitted To:</td>
                      <td style='color: #0f172a; text-align: right; padding: 6px 0; font-weight: 500;'>" . htmlspecialchars($bankDesc) . "</td>
                    </tr>";
            }

            $body = "
                <div style='margin-bottom: 20px;'>
                  <span style='background: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                    Payment Processed
                  </span>
                </div>
                <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                  Salary Disbursed for {$month}
                </h2>
                <p style='margin: 0 0 18px 0; color: #475569;'>
                  Dear <strong>" . htmlspecialchars($empName) . "</strong>,<br>
                  We are pleased to inform you that your salary for <strong>{$month}</strong> has been successfully processed and transferred.
                </p>

                <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin: 18px 0;'>
                  <table width='100%' cellpadding='0' cellspacing='0' style='font-size: 14px;'>
                    <tr>
                      <td style='color: #64748b; font-weight: 600; padding: 6px 0;'>Receipt No:</td>
                      <td style='color: #0f172a; font-weight: 700; text-align: right; padding: 6px 0;'>{$receiptNo}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600; padding: 6px 0;'>Disbursed Date:</td>
                      <td style='color: #0f172a; text-align: right; padding: 6px 0;'>{$date}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600; padding: 6px 0;'>Payment Method:</td>
                      <td style='color: #0f172a; text-align: right; padding: 6px 0;'>{$paymentMethod}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600; padding: 6px 0;'>Transaction Ref:</td>
                      <td style='color: #64748b; font-family: monospace; text-align: right; padding: 6px 0;'>{$referenceNo}</td>
                    </tr>
                    {$bankInfoRow}
                  </table>

                  <div style='border-top: 1px dashed #cbd5e1; margin: 14px 0 10px 0;'></div>

                  <table width='100%' cellpadding='0' cellspacing='0' style='font-size: 14px;'>
                    <tr>
                      <td style='color: #64748b; padding: 4px 0;'>Basic Salary:</td>
                      <td style='color: #334155; text-align: right; padding: 4px 0;'>LKR " . number_format($basicSalary, 2) . "</td>
                    </tr>
                    " . ($allowances > 0 ? "<tr><td style='color: #64748b; padding: 4px 0;'>Allowances:</td><td style='color: #16a34a; text-align: right; padding: 4px 0;'>+ LKR " . number_format($allowances, 2) . "</td></tr>" : "") . "
                    " . ($bonus > 0 ? "<tr><td style='color: #64748b; padding: 4px 0;'>Bonus / Incentive:</td><td style='color: #16a34a; text-align: right; padding: 4px 0;'>+ LKR " . number_format($bonus, 2) . "</td></tr>" : "") . "
                    " . ($deductions > 0 ? "<tr><td style='color: #64748b; padding: 4px 0;'>Deductions:</td><td style='color: #dc2626; text-align: right; padding: 4px 0;'>- LKR " . number_format($deductions, 2) . "</td></tr>" : "") . "
                    " . ($epfEmployee > 0 ? "<tr><td style='color: #64748b; padding: 4px 0;'>EPF (Employee 8%):</td><td style='color: #dc2626; text-align: right; padding: 4px 0;'>- LKR " . number_format($epfEmployee, 2) . "</td></tr>" : "") . "
                    <tr>
                      <td style='color: #0f172a; font-weight: 700; font-size: 16px; padding: 12px 0 4px 0;'>Net Disbursed Amount:</td>
                      <td style='color: #2563eb; font-weight: 800; font-size: 18px; text-align: right; padding: 12px 0 4px 0;'>LKR " . number_format($netSalary, 2) . "</td>
                    </tr>
                  </table>
                </div>

                <div style='text-align: center; margin: 26px 0 10px;'>
                  <a href='http://localhost:3000/UxUi/Employee_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>Download Receipt in Portal</a>
                </div>
            ";

            $emailObj = new self($recipientEmail, $subject, $body, 'salary_paid');
            return $emailObj->send_email();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send email to Admin when an employee submits daily work plan or shift wrap-up update
     */
    public static function send_daily_update_notification(array $updateData) {
        try {
            if (!self::is_notification_enabled('admin', 'email_notifications')) {
                return true;
            }

            $adminEmail = self::resolve_admin_email();
            $empName    = !empty($updateData['employee_name']) ? trim($updateData['employee_name']) : 'Employee';
            $dept       = !empty($updateData['department']) ? trim($updateData['department']) : 'General';
            $jobTitle   = !empty($updateData['job_title']) ? trim($updateData['job_title']) : 'Staff';
            $type       = !empty($updateData['update_type']) ? $updateData['update_type'] : 'shift_end'; // 'morning_plan' or 'shift_end'
            $date       = !empty($updateData['date']) ? $updateData['date'] : date('Y-m-d');
            $timeNow    = date('h:i A');

            if ($type === 'morning_plan') {
                $subject = "[NEO HR] Daily Work Plan: {$empName} ({$date})";
                $planText = !empty($updateData['plan_text']) ? $updateData['plan_text'] : '';
                $tasks    = !empty($updateData['tasks']) && is_array($updateData['tasks']) ? $updateData['tasks'] : [];

                $tasksHtml = '';
                if (!empty($tasks)) {
                    $tasksHtml = "<ul style='margin: 8px 0; padding-left: 20px; color: #334155; line-height: 1.8;'>";
                    foreach ($tasks as $t) {
                        $tTitle = is_array($t) ? ($t['title'] ?? '') : (string)$t;
                        if (!empty(trim($tTitle))) {
                            $tasksHtml .= "<li>" . htmlspecialchars(trim($tTitle)) . "</li>";
                        }
                    }
                    $tasksHtml .= "</ul>";
                } else if (!empty($planText)) {
                    $tasksHtml = "<p style='margin: 8px 0; color: #334155; white-space: pre-line; line-height: 1.6;'>" . htmlspecialchars($planText) . "</p>";
                } else {
                    $tasksHtml = "<p style='margin: 8px 0; color: #94a3b8; font-style: italic;'>No task items specified.</p>";
                }

                $body = "
                    <div style='margin-bottom: 20px;'>
                      <span style='background: #e0e7ff; color: #3730a3; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                        Work Started &bull; Daily Plan
                      </span>
                    </div>
                    <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                      Daily Work Plan Submitted
                    </h2>
                    <p style='margin: 0 0 18px 0; color: #475569;'>
                      Employee <strong>" . htmlspecialchars($empName) . "</strong> ({$jobTitle}, {$dept}) has started work and logged their planned tasks for today.
                    </p>
                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 20px; margin: 16px 0 22px 0;'>
                      <table width='100%' cellpadding='4' cellspacing='0' style='font-size: 14px; margin-bottom: 12px;'>
                        <tr>
                          <td style='color: #64748b; font-weight: 600; width: 30%;'>Employee:</td>
                          <td style='color: #0f172a; font-weight: 700;'>" . htmlspecialchars($empName) . "</td>
                        </tr>
                        <tr>
                          <td style='color: #64748b; font-weight: 600;'>Department / Role:</td>
                          <td style='color: #334155;'>" . htmlspecialchars($dept) . " &bull; " . htmlspecialchars($jobTitle) . "</td>
                        </tr>
                        <tr>
                          <td style='color: #64748b; font-weight: 600;'>Logged At:</td>
                          <td style='color: #334155;'>{$date} at {$timeNow}</td>
                        </tr>
                      </table>
                      <div style='border-top: 1px solid #e2e8f0; padding-top: 12px;'>
                        <strong style='font-size: 13px; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;'>Planned Activities for Today:</strong>
                        {$tasksHtml}
                      </div>
                    </div>
                    <div style='text-align: center; margin: 26px 0 10px;'>
                      <a href='http://localhost:3000/UxUi/Admin_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>View Daily Plans in Admin Portal</a>
                    </div>
                ";
            } else {
                // Shift end wrap up
                $taskTitle   = !empty($updateData['task_title']) ? $updateData['task_title'] : 'Daily Tasks';
                $taskStatus  = !empty($updateData['task_status']) ? $updateData['task_status'] : 'Completed';
                $note        = !empty($updateData['evening_update']) ? $updateData['evening_update'] : (!empty($updateData['note']) ? $updateData['note'] : '');

                $statusColor = (strtolower($taskStatus) === 'completed') ? '#059669' : '#2563eb';
                $statusBg    = (strtolower($taskStatus) === 'completed') ? '#ecfdf5' : '#eff6ff';

                $subject = "[NEO HR] Shift End Update: {$empName} [{$taskStatus}]";

                $body = "
                    <div style='margin-bottom: 20px;'>
                      <span style='background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                        Shift Wrap-Up Completed
                      </span>
                    </div>
                    <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                      Shift End Daily Update Submitted
                    </h2>
                    <p style='margin: 0 0 18px 0; color: #475569;'>
                      Employee <strong>" . htmlspecialchars($empName) . "</strong> ({$dept}) has submitted their end-of-day wrap-up report.
                    </p>
                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 20px; margin: 16px 0 22px 0;'>
                      <table width='100%' cellpadding='6' cellspacing='0' style='font-size: 14px;'>
                        <tr>
                          <td style='color: #64748b; font-weight: 600; width: 32%;'>Employee:</td>
                          <td style='color: #0f172a; font-weight: 700;'>" . htmlspecialchars($empName) . "</td>
                        </tr>
                        <tr>
                          <td style='color: #64748b; font-weight: 600;'>Main Task / Work:</td>
                          <td style='color: #0f172a; font-weight: 600;'>" . htmlspecialchars($taskTitle) . "</td>
                        </tr>
                        <tr>
                          <td style='color: #64748b; font-weight: 600;'>End Status:</td>
                          <td>
                            <span style='background: {$statusBg}; color: {$statusColor}; font-weight: 700; font-size: 12px; padding: 3px 10px; border-radius: 12px;'>
                              " . htmlspecialchars($taskStatus) . "
                            </span>
                          </td>
                        </tr>
                        " . (!empty($note) ? "
                        <tr>
                          <td style='color: #64748b; font-weight: 600; vertical-align: top;'>Wrap-Up Summary:</td>
                          <td style='color: #334155; line-height: 1.6;'>" . nl2br(htmlspecialchars($note)) . "</td>
                        </tr>" : "") . "
                        <tr>
                          <td style='color: #64748b; font-weight: 600;'>Completed At:</td>
                          <td style='color: #64748b;'>{$date} at {$timeNow}</td>
                        </tr>
                      </table>
                    </div>
                    <div style='text-align: center; margin: 26px 0 10px;'>
                      <a href='http://localhost:3000/UxUi/Admin_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>Review in Admin Portal</a>
                    </div>
                ";
            }

            $emailObj = new self($adminEmail, $subject, $body, 'daily_update');
            return $emailObj->send_email();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send email to Employee when a task is assigned
     */
    public static function send_task_assigned_notification(array $taskData) {
        try {
            $assignedTo = !empty($taskData['assigned_to']) ? trim($taskData['assigned_to']) : (!empty($taskData['employee']) ? trim($taskData['employee']) : '');
            if (empty($assignedTo) || strtolower($assignedTo) === 'unassigned') {
                return true;
            }

            $empEmail = self::resolve_employee_email($assignedTo, $taskData['employee_email'] ?? '');
            if (empty($empEmail)) {
                return false;
            }

            $title       = !empty($taskData['title']) ? htmlspecialchars($taskData['title']) : 'New Task';
            $description = !empty($taskData['description']) ? htmlspecialchars($taskData['description']) : '';
            $dept        = !empty($taskData['department']) ? htmlspecialchars($taskData['department']) : (!empty($taskData['dept']) ? htmlspecialchars($taskData['dept']) : 'Engineering');
            $mode        = !empty($taskData['mode']) ? htmlspecialchars($taskData['mode']) : 'Online';
            $deadline    = !empty($taskData['deadline']) ? htmlspecialchars($taskData['deadline']) : date('Y-m-d', strtotime('+7 days'));
            $status      = !empty($taskData['status']) ? htmlspecialchars($taskData['status']) : 'Pending';

            $deadlineFormatted = date('M d, Y', strtotime($deadline));

            $subject = "[NEO HR] New Task Assigned: {$title}";

            $body = "
                <div style='margin-bottom: 20px;'>
                  <span style='background: #eff6ff; color: #1e40af; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                    New Assignment
                  </span>
                </div>
                <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                  You Have Been Assigned a New Task
                </h2>
                <p style='margin: 0 0 18px 0; color: #475569;'>
                  Hello <strong>" . htmlspecialchars($assignedTo) . "</strong>,<br>
                  A new task has been assigned to you in the NEO Staff Portal. Please review the details below:
                </p>

                <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin: 16px 0 24px 0;'>
                  <div style='font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 10px;'>
                    {$title}
                  </div>
                  " . (!empty($description) ? "<p style='color: #475569; font-size: 14px; margin: 0 0 14px 0; line-height: 1.6;'>{$description}</p>" : "") . "
                  <table width='100%' cellpadding='5' cellspacing='0' style='font-size: 13.5px; border-top: 1px solid #e2e8f0; padding-top: 10px;'>
                    <tr>
                      <td style='color: #64748b; font-weight: 600; width: 30%;'>Department:</td>
                      <td style='color: #0f172a;'>{$dept}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Work Mode:</td>
                      <td style='color: #0f172a;'>{$mode}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Initial Status:</td>
                      <td style='color: #2563eb; font-weight: 600;'>{$status}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Due Date:</td>
                      <td style='color: #b91c1c; font-weight: 700;'>{$deadlineFormatted}</td>
                    </tr>
                  </table>
                </div>

                <div style='text-align: center; margin: 26px 0 10px;'>
                  <a href='http://localhost:3000/UxUi/Employee_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>View Task &amp; Update Progress</a>
                </div>
            ";

            $emailObj = new self($empEmail, $subject, $body, 'task_assigned');
            return $emailObj->send_email();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send email when a document is requested from employee(s)
     */
    public static function send_document_request_notification(array $docData) {
        try {
            $targetType = !empty($docData['target_type']) ? strtolower(trim($docData['target_type'])) : 'employee';
            $targetEmp  = !empty($docData['target_employee_name']) ? trim($docData['target_employee_name']) : '';
            $targetUid  = !empty($docData['target_employee_user_id']) ? (int)$docData['target_employee_user_id'] : 0;
            $docType    = !empty($docData['doc_type']) ? htmlspecialchars($docData['doc_type']) : 'Document';
            $notes      = !empty($docData['notes']) ? htmlspecialchars($docData['notes']) : '';
            $deadline   = !empty($docData['deadline']) ? htmlspecialchars($docData['deadline']) : '';
            $adminName  = !empty($docData['requested_by']) ? htmlspecialchars($docData['requested_by']) : 'Management';

            $db = new DataBase();
            $conn = $db->get_data_base_connction();

            $recipients = [];

            if ($targetType === 'employee') {
                $email = '';
                if ($targetUid > 0) {
                    $q = $conn->query("SELECT `user_name` FROM `main_user_login` WHERE `id` = {$targetUid} LIMIT 1");
                    if ($q && $r = $q->fetch_assoc()) {
                        if (filter_var($r['user_name'], FILTER_VALIDATE_EMAIL)) $email = trim($r['user_name']);
                    }
                }
                if (empty($email)) {
                    $email = self::resolve_employee_email($targetEmp, $docData['employee_email'] ?? '');
                }
                if (!empty($email)) {
                    $recipients[] = ['name' => $targetEmp ?: 'Employee', 'email' => $email];
                }
            } else if ($targetType === 'department') {
                $deptEsc = $conn->real_escape_string($targetEmp);
                $q = $conn->query("SELECT `fullname`, `email_address` FROM `employees` WHERE `department` = '{$deptEsc}' AND `email_address` IS NOT NULL");
                if ($q) {
                    while ($r = $q->fetch_assoc()) {
                        if (filter_var($r['email_address'], FILTER_VALIDATE_EMAIL)) {
                            $recipients[] = ['name' => $r['fullname'], 'email' => trim($r['email_address'])];
                        }
                    }
                }
            } else { // 'all'
                $q = $conn->query("SELECT `fullname`, `email_address` FROM `employees` WHERE `email_address` IS NOT NULL AND `email_address` != ''");
                if ($q) {
                    while ($r = $q->fetch_assoc()) {
                        if (filter_var($r['email_address'], FILTER_VALIDATE_EMAIL)) {
                            $recipients[] = ['name' => $r['fullname'], 'email' => trim($r['email_address'])];
                        }
                    }
                }
            }

            if (empty($recipients)) {
                $recipients[] = ['name' => $targetEmp ?: 'Employee', 'email' => self::resolve_employee_email($targetEmp)];
            }

            $deadlineStr = !empty($deadline) ? date('M d, Y', strtotime($deadline)) : 'As soon as possible';

            $subject = "[NEO HR] Document Requested: {$docType}";

            foreach ($recipients as $rec) {
                $empName = $rec['name'];
                $empMail = $rec['email'];

                $body = "
                    <div style='margin-bottom: 20px;'>
                      <span style='background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                        Document Submission Required
                      </span>
                    </div>
                    <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                      Action Required: Please Upload {$docType}
                    </h2>
                    <p style='margin: 0 0 18px 0; color: #475569;'>
                      Hello <strong>" . htmlspecialchars($empName) . "</strong>,<br>
                      {$adminName} has requested you to upload the following document to your NEO Staff Portal.
                    </p>

                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 20px; margin: 16px 0 24px 0;'>
                      <table width='100%' cellpadding='6' cellspacing='0' style='font-size: 14px;'>
                        <tr>
                          <td style='color: #64748b; font-weight: 600; width: 30%;'>Requested Document:</td>
                          <td style='color: #2563eb; font-weight: 700; font-size: 15px;'>{$docType}</td>
                        </tr>
                        " . (!empty($notes) ? "
                        <tr>
                          <td style='color: #64748b; font-weight: 600; vertical-align: top;'>Special Notes:</td>
                          <td style='color: #334155; line-height: 1.6;'>{$notes}</td>
                        </tr>" : "") . "
                        <tr>
                          <td style='color: #64748b; font-weight: 600;'>Submission Due:</td>
                          <td style='color: #b91c1c; font-weight: 700;'>{$deadlineStr}</td>
                        </tr>
                      </table>
                    </div>

                    <div style='text-align: center; margin: 26px 0 10px;'>
                      <a href='http://localhost:3000/UxUi/Employee_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>Upload Document in Portal</a>
                    </div>
                ";

                $emailObj = new self($empMail, $subject, $body, 'document_request');
                $emailObj->send_email();
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send email to Admin when employee uploads a requested document
     */
    public static function send_document_upload_notification(array $uploadData) {
        try {
            if (!self::is_notification_enabled('admin', 'email_notifications')) {
                return true;
            }

            $adminEmail = self::resolve_admin_email();
            $empName    = !empty($uploadData['employee_name']) ? htmlspecialchars($uploadData['employee_name']) : 'Employee';
            $empId      = !empty($uploadData['employee_id']) ? htmlspecialchars($uploadData['employee_id']) : '';
            $docType    = !empty($uploadData['doc_type']) ? htmlspecialchars($uploadData['doc_type']) : 'Document';
            $fileName   = !empty($uploadData['file_name']) ? htmlspecialchars($uploadData['file_name']) : 'File';
            $timeNow    = date('M d, Y h:i A');

            $subject = "[NEO HR] Document Uploaded: {$empName} ({$docType})";

            $body = "
                <div style='margin-bottom: 20px;'>
                  <span style='background: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;'>
                    Document Uploaded
                  </span>
                </div>
                <h2 style='margin: 0 0 14px 0; font-size: 20px; font-weight: 700; color: #0f172a;'>
                  New Employee Document Uploaded
                </h2>
                <p style='margin: 0 0 18px 0; color: #475569;'>
                  Employee <strong>{$empName}</strong>" . (!empty($empId) ? " ({$empId})" : "") . " has uploaded a document for review.
                </p>
                <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 20px; margin: 16px 0 24px 0;'>
                  <table width='100%' cellpadding='6' cellspacing='0' style='font-size: 14px;'>
                    <tr>
                      <td style='color: #64748b; font-weight: 600; width: 30%;'>Employee:</td>
                      <td style='color: #0f172a; font-weight: 700;'>{$empName}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Document Type:</td>
                      <td style='color: #2563eb; font-weight: 600;'>{$docType}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>File Name:</td>
                      <td style='color: #334155;'>{$fileName}</td>
                    </tr>
                    <tr>
                      <td style='color: #64748b; font-weight: 600;'>Uploaded At:</td>
                      <td style='color: #64748b;'>{$timeNow}</td>
                    </tr>
                  </table>
                </div>
                <div style='text-align: center; margin: 26px 0 10px;'>
                  <a href='http://localhost:3000/UxUi/Admin_user_dashboard.php' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;'>Review in Admin Portal</a>
                </div>
            ";

            $emailObj = new self($adminEmail, $subject, $body, 'document_upload');
            return $emailObj->send_email();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send test email
     */
    public static function send_test_email($targetEmail) {
        $targetEmail = trim($targetEmail);
        if (empty($targetEmail) || !filter_var($targetEmail, FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Invalid email address provided.'];
        }

        $now = date('Y-m-d H:i:s');
        $subject = "[NEO HR] Test Email - Verification";
        $body = "
            <h2 style='margin: 0 0 12px 0; color: #0f172a;'>SMTP Configuration Test</h2>
            <p style='color: #475569;'>This is a test email sent from the NEO Solution Staff Management System.</p>
            <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin: 16px 0;'>
              <p style='margin: 0 0 6px 0; font-size: 13px; color: #64748b;'><strong>Timestamp:</strong> {$now}</p>
              <p style='margin: 0; font-size: 13px; color: #64748b;'><strong>Recipient:</strong> {$targetEmail}</p>
            </div>
        ";

        $emailObj = new self($targetEmail, $subject, $body, 'smtp_test');
        $sent = $emailObj->send_email();
        if ($sent) {
            return ['status' => 'success', 'message' => 'Test email sent successfully! Please check your inbox / spam folder.'];
        }
        $err = !empty($emailObj->get_last_error()) ? $emailObj->get_last_error() : 'Failed to send test email.';
        return ['status' => 'error', 'message' => $err];
    }
}

