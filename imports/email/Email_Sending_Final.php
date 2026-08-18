<?php


class Email_Sender {
    private $email_address;
    private $subject;
    private $html_header_n_footer;
    private $cc_emails = [];
    private $bcc_emails = [];
    private $company_info_obj;

    public function __construct($email_address, $subject, $html_code_data) {
        $this->email_address = $email_address;
        $this->subject = $subject;
        $this->html_header_n_footer = $html_code_data;
        $this->company_info_obj = new Company_Info_Variable_List();
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

    public function send() {
        $to = $this->email_address;
        $subject = $this->subject;
        $message = $this->html_header_n_footer;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $this->company_info_obj->get_compnay_short_name() . "<" . $this->company_info_obj->get_default_sending_email() . ">" . "\r\n";
        $headers .= "Reply-To: " . $this->company_info_obj->get_compnay_short_name() . "<" . $this->company_info_obj->get_default_sending_email() . ">" . "\r\n";

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

       if (mail($to, $subject, $message, $headers)) {
            return true;
       } else {
//            
           return false;
       }
    }
}