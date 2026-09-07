<?php

include_once __DIR__ . '/../Company_Info/Company_Info_Variable_List.php';
include_once __DIR__ . '/../need/DB.php';

class Email_Sender {
    private $email_address;
    private $subject;
    private $html_header_n_footer;
    private $cc_emails = [];
    private $bcc_emails = [];
    private $company_info_obj;
    private $event_type = 'general';

    public function __construct($email_address, $subject, $html_code_data, $event_type = 'general') {
        $this->email_address = $email_address;
        $this->subject = $subject;
        $this->html_header_n_footer = $html_code_data;
        $this->company_info_obj = new Company_Info_Variable_List();
        $this->event_type = $event_type;
    }

    public function set_event_type($type) {
        $this->event_type = $type;
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

    public function add_cc_email($name, $email) {
        $this->cc_emails[] = ['name' => $name, 'email' => $email];
    }

    public function add_bcc_email($name, $email) {
        $this->bcc_emails[] = ['name' => $name, 'email' => $email];
    }

    /**
     * Get system SMTP settings from database
     */
    private function get_smtp_settings() {
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $res = $conn->query("SELECT * FROM `system_smtp_settings` ORDER BY `id` ASC LIMIT 1");
            if ($res && $row = $res->fetch_assoc()) {
                return $row;
            }
        } catch (Exception $e) {}

        return [
            'smtp_host'   => 'smtp.gmail.com',
            'smtp_port'   => 587,
            'smtp_secure' => 'tls',
            'smtp_user'   => '',
            'smtp_pass'   => '',
            'from_email'  => '',
            'from_name'   => $this->company_info_obj->get_compnay_short_name(),
            'is_enabled'  => 0
        ];
    }

    /**
     * Log email to database
     */
    private function log_email($status, $error = '') {
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

            $to_esc    = $conn->real_escape_string((string)$this->email_address);
            $subj_esc  = $conn->real_escape_string((string)$this->subject);
            $body_esc  = $conn->real_escape_string((string)$this->html_header_n_footer);
            $ev_esc    = $conn->real_escape_string((string)$this->event_type);
            $st_esc    = $conn->real_escape_string((string)$status);
            $err_esc   = $conn->real_escape_string((string)$error);

            $conn->query("INSERT INTO `system_email_logs` 
                (`recipient_email`, `subject`, `event_type`, `status`, `error_info`, `body_html`, `created_at`) 
                VALUES ('$to_esc', '$subj_esc', '$ev_esc', '$st_esc', '$err_esc', '$body_esc', NOW())");
        } catch (Exception $e) {}
    }

    /**
     * Send email via SMTP socket
     */
    private function send_via_smtp($smtp_cfg, $fromEmail, $fromName) {
        $host   = trim($smtp_cfg['smtp_host']);
        $port   = (int)$smtp_cfg['smtp_port'];
        $secure = strtolower(trim($smtp_cfg['smtp_secure']));
        $user   = trim($smtp_cfg['smtp_user']);
        $pass   = trim($smtp_cfg['smtp_pass']);

        $timeout = 8;
        $context = stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ]);

        $transport = ($secure === 'ssl' || $port === 465) ? "ssl://{$host}:{$port}" : "tcp://{$host}:{$port}";
        $socket = @stream_socket_client($transport, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);

        if (!$socket) {
            return ['success' => false, 'error' => "Cannot connect to SMTP server $transport ($errstr)"];
        }

        stream_set_timeout($socket, $timeout);

        $readResponse = function () use ($socket) {
            $resp = '';
            while ($line = @fgets($socket, 515)) {
                $resp .= $line;
                if (substr($line, 3, 1) === ' ') break;
            }
            return $resp;
        };

        $sendCommand = function ($cmd, $expectedCode) use ($socket, $readResponse) {
            @fputs($socket, $cmd . "\r\n");
            $resp = $readResponse();
            $code = substr($resp, 0, 3);
            if ($code !== (string)$expectedCode) {
                return ['success' => false, 'resp' => $resp, 'code' => $code];
            }
            return ['success' => true, 'resp' => $resp];
        };

        $initResp = $readResponse();
        if (substr($initResp, 0, 3) !== '220') {
            @fclose($socket);
            return ['success' => false, 'error' => "Unexpected greeting: $initResp"];
        }

        $ehlo = $sendCommand("EHLO " . gethostname(), 250);
        if (!$ehlo['success']) {
            @fclose($socket);
            return ['success' => false, 'error' => "EHLO failed: " . $ehlo['resp']];
        }

        if ($secure === 'tls' || ($port === 587 && $secure !== 'ssl')) {
            $starttls = $sendCommand("STARTTLS", 220);
            if ($starttls['success']) {
                $crypto = @stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                if (!$crypto) {
                    @fclose($socket);
                    return ['success' => false, 'error' => "TLS crypto handshake failed"];
                }
                $sendCommand("EHLO " . gethostname(), 250);
            }
        }

        if (!empty($user)) {
            $auth = $sendCommand("AUTH LOGIN", 334);
            if (!$auth['success']) {
                @fclose($socket);
                return ['success' => false, 'error' => "AUTH LOGIN rejected: " . $auth['resp']];
            }

            $uRes = $sendCommand(base64_encode($user), 334);
            if (!$uRes['success']) {
                @fclose($socket);
                return ['success' => false, 'error' => "Username rejected: " . $uRes['resp']];
            }

            $pRes = $sendCommand(base64_encode($pass), 235);
            if (!$pRes['success']) {
                @fclose($socket);
                return ['success' => false, 'error' => "Password rejected: " . $pRes['resp']];
            }
        }

        $mailFrom = $sendCommand("MAIL FROM:<$fromEmail>", 250);
        if (!$mailFrom['success']) {
            @fclose($socket);
            return ['success' => false, 'error' => "MAIL FROM rejected: " . $mailFrom['resp']];
        }

        $rcptTo = $sendCommand("RCPT TO:<{$this->email_address}>", 250);
        if (!$rcptTo['success']) {
            @fclose($socket);
            return ['success' => false, 'error' => "RCPT TO rejected: " . $rcptTo['resp']];
        }

        // CC recipients
        foreach ($this->cc_emails as $cc) {
            if (!empty($cc['email'])) {
                $sendCommand("RCPT TO:<{$cc['email']}>", 250);
            }
        }

        // BCC recipients
        foreach ($this->bcc_emails as $bcc) {
            if (!empty($bcc['email'])) {
                $sendCommand("RCPT TO:<{$bcc['email']}>", 250);
            }
        }

        $dataCmd = $sendCommand("DATA", 354);
        if (!$dataCmd['success']) {
            @fclose($socket);
            return ['success' => false, 'error' => "DATA rejected: " . $dataCmd['resp']];
        }

        $mime = "MIME-Version: 1.0\r\n";
        $mime .= "Content-Type: text/html; charset=UTF-8\r\n";
        $mime .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
        $mime .= "To: <{$this->email_address}>\r\n";
        $mime .= "Subject: =?UTF-8?B?" . base64_encode($this->subject) . "?=\r\n";
        $mime .= "Date: " . date('r') . "\r\n";
        $mime .= "X-Mailer: NEO-Staff-Management-Mailer\r\n";

        if (!empty($this->cc_emails)) {
            $ccStrings = [];
            foreach ($this->cc_emails as $cc) {
                $ccStrings[] = "{$cc['name']} <{$cc['email']}>";
            }
            $mime .= "CC: " . implode(', ', $ccStrings) . "\r\n";
        }

        $mime .= "\r\n" . $this->html_header_n_footer . "\r\n.\r\n";

        @fputs($socket, $mime);
        $finalResp = $readResponse();
        $code = substr($finalResp, 0, 3);

        $sendCommand("QUIT", 221);
        @fclose($socket);

        if ($code === '250') {
            return ['success' => true];
        }

        return ['success' => false, 'error' => "Failed sending body: $finalResp"];
    }

    public function send() {
        $to = $this->email_address;
        $subject = $this->subject;
        $message = $this->html_header_n_footer;

        $smtp_cfg = $this->get_smtp_settings();
        $fromEmail = !empty($smtp_cfg['from_email']) ? trim($smtp_cfg['from_email']) : $this->company_info_obj->get_default_sending_email();
        $fromName  = !empty($smtp_cfg['from_name']) ? trim($smtp_cfg['from_name']) : $this->company_info_obj->get_compnay_short_name();
        $isEnabled = !empty($smtp_cfg['is_enabled']) && ((int)$smtp_cfg['is_enabled'] === 1);

        // 1. Try SMTP if enabled and configured
        if ($isEnabled && !empty($smtp_cfg['smtp_host']) && !empty($smtp_cfg['smtp_user'])) {
            $smtpRes = $this->send_via_smtp($smtp_cfg, $fromEmail, $fromName);
            if ($smtpRes['success']) {
                $this->log_email('Sent', 'Dispatched via SMTP (' . $smtp_cfg['smtp_host'] . ')');
                return true;
            }
        }

        // 2. Fallback: standard mail()
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $fromName . "<" . $fromEmail . ">" . "\r\n";
        $headers .= "Reply-To: " . $fromName . "<" . $fromEmail . ">" . "\r\n";

        if (!empty($this->cc_emails)) {
            $cc_string = [];
            foreach ($this->cc_emails as $cc) {
                $cc_string[] = "{$cc['name']} <{$cc['email']}>";
            }
            $headers .= "CC: " . implode(', ', $cc_string) . "\r\n";
        }

        if (!empty($this->bcc_emails)) {
            $bcc_string = [];
            foreach ($this->bcc_emails as $bcc) {
                $bcc_string[] = "{$bcc['name']} <{$bcc['email']}>";
            }
            $headers .= "BCC: " . implode(', ', $bcc_string) . "\r\n";
        }

        $headers .= "X-Mailer: PHP/" . phpversion();

        if (@mail($to, $subject, $message, $headers)) {
            $this->log_email('Sent', 'Dispatched via PHP mail()');
            return true;
        } else {
            // Local dev without live SMTP credentials: log to outbox
            $status = ($isEnabled && empty($smtp_cfg['smtp_user'])) ? 'Simulated' : 'Logged';
            $this->log_email($status, 'Local environment - Logged to system_email_logs');
            return true;
        }
    }
}