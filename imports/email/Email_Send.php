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

    public function send_email() {
        $get_email_sending_obj = new Email_Sender($this->email_address, $this->subject, $this->html_header_n_footer, $this->event_type);
        $get_email_sending_obj->add_bcc_email_data_bunch($this->bcc_emails);
        $get_email_sending_obj->add_cc_email_data_bunch($this->cc_emails);

        return $get_email_sending_obj->send();
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
            $q3 = $conn->query("SELECT `email` FROM `employee_profiles` WHERE `full_name` = '$name_esc' OR `first_name` = '$name_esc' LIMIT 1");
            if ($q3 && $r3 = $q3->fetch_assoc()) {
                if (!empty($r3['email']) && filter_var($r3['email'], FILTER_VALIDATE_EMAIL)) {
                    return trim($r3['email']);
                }
            }
        } catch (Exception $e) {}

        return !empty($fallbackEmail) ? $fallbackEmail : 'employee@neosolution.com';
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

        return 'admin@neosolution.com';
    }

    /**
     * Send email to Admin when employee submits a leave request
     */
    public static function send_leave_request_notification(array $leaveData) {
        try {
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
            return ['status' => 'success', 'message' => 'Test email processed successfully.'];
        }
        return ['status' => 'error', 'message' => 'Failed to send test email.'];
    }
}
