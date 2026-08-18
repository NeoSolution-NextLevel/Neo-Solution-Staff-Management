<?php

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

    public function __construct($email_address, $subject, $html_data) {
        $this->email_address = $email_address;
        $this->subject = $subject;
        $this->html_data = $html_data;
        $this->company_variable_list = new Company_Info_Variable_List();
        $this->compnay_name = $this->company_variable_list->get_compnay_name();
//        echo $this->company_variable_list->get_compnay_default_sending_email();
        $this->default_system_mail = $this->company_variable_list->get_compnay_default_sending_email();

        $this->set_html_header_n_footer();
    }

    private function set_html_header_n_footer() {
        $this->html_header_n_footer = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>" . $this->subject . "</title>
    <style type='text/css'>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            max-width: 700px;
            margin: 20px auto;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-size: 16px;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        td {
            
        }
        tr:last-child td {
            border-bottom: none;
        }
        .heading_name {
            font-weight: bold;
        }
        .order_info_left_val, .order_info_right_val, .order_info_center_val {
            padding: 10px;
        }
        .order_info_left_val {
            font-weight: bold;
            width: 40%;
        }
        .order_info_right_val {
            width: 50%;
            text-align: right;
        }
        .order_info_center_val {
            width: 10%;
        }
        .invoice_item_data {
            padding: 15px;
        }
        .total_val_heder, .total_val_answer {
            font-size: 16px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
        }
        .total_val_heder {
            width: 80%;
            text-align: right;
        }
        .total_val_answer {
            width: 20%;
            text-align: right;
            font-weight: bold;
        }
        .w3-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            
            margin: 20px 0;
        }
        .w3-button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            margin-top: 30px;
        }
        .footer small {
            color: #777;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
     <table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#eaeaea'>
    <tr>
      <td align='center'>

        <!-- Wrapper -->
        <table width='600' cellpadding='0' cellspacing='0' border='0' style='background-color: #ffffff; margin: 40px auto; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);'>

          <!-- Header / Logo -->
          <tr>
            <td align='center' bgcolor='#003366' style='padding: 30px;'>
              <img src='" . $this->company_variable_list->get_compnay_logo_url() . "' alt='Logo' style='width: 100px; display: block; margin-bottom: 10px;'>
              <h1 style='color: #ffffff; font-size: 24px; margin: 0;'>Welcome to " . $this->compnay_name . "</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style='color: #333333; font-size: 16px; line-height: 1.6;'>
              " . $this->html_data . "
            </td>
          </tr>

          <!-- CTA Button -->
          
          <!-- Divider -->
          <tr>
            <td style='padding: 0 40px;'>
              <hr style=' border-top: 1px solid #dddddd; margin: 30px 0;'>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align='center' style='padding: 20px; font-size: 13px; color: #999999;'>
              <div>
                <strong><small>" . $this->company_variable_list->get_compnay_footer_txt() . "</small></strong><br>
                <small>Design & Maintain by <a href='https://www.neosolution.lk' style='color: #007BFF; text-decoration: none;'>Neo Solution</a></small>
              </div>
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

    private $get_email_sending_obj;

    public function send_email() {
        $get_email_sending_obj = new Email_Sender($this->email_address, $this->subject, $this->html_header_n_footer);
        $get_email_sending_obj->add_bcc_email_data_bunch($this->bcc_emails);
        $get_email_sending_obj->add_cc_email_data_bunch($this->cc_emails);

        return $get_email_sending_obj->send();
    }
}
