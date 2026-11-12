<?php

include_once __DIR__ . '/../need/DB.php';
include_once __DIR__ . '/../Company_Info/Company_Info_Variable_List.php';
include_once __DIR__ . '/../email/Email_Send.php';
include_once __DIR__ . '/../sms/SMS_Sending.php';
include_once __DIR__ . '/../../Controllers/notification/notifications_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/notification/notification_inbox_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/notification/fcm_tokens_LIST.php';
include_once __DIR__ . '/../../Controllers/site_settings/site_settings_SINGLE_DATA.php';
include_once __DIR__ . '/../../Controllers/users/member_list/member_list_SINGLE_DATA.php';
include_once __DIR__ . '/../../Controllers/users/managers_list/managers_list_SINGLE_DATA.php';
include_once __DIR__ . '/../../Controllers/users/cash_owner_list/cash_owner_list_SINGLE_DATA.php';
include_once __DIR__ . '/fcm.php';
include_once __DIR__ . '/notification-config.php';

class App_Notification_Service {

    public static function get_currency_symbol() {
        try {
            if (class_exists('site_settings_SINGLE_DATA')) {
                $ss = new site_settings_SINGLE_DATA();
                if ($ss->get_state() && !empty($ss->get_currencySymbol())) {
                    return $ss->get_currencySymbol();
                }
            }
        } catch (\Throwable $e) {
        }
        return 'Rs.';
    }

    public static function get_company_data() {
        $comp = new Company_Info_Variable_List();
        $name = $comp->get_compnay_name();
        try {
            if (class_exists('site_settings_SINGLE_DATA')) {
                $ss = new site_settings_SINGLE_DATA();
                if ($ss->get_state() && !empty($ss->get_companyName())) {
                    $name = $ss->get_companyName();
                }
            }
        } catch (\Throwable $e) {
        }

        $web = $comp->get_compnay_full_web() ?: $comp->get_compnay_web();
        if (empty($web)) {
            $web = 'https://ems.neosolution.lk';
        }
        if (strpos($web, 'http') !== 0) {
            $web = 'https://' . $web;
        }

        return [
            'name'       => $name ?: 'Neo Solution',
            'short_name' => $comp->get_compnay_short_name() ?: 'NEO',
            'email'      => $comp->get_default_sending_email() ?: 'ems@neosolution.lk',
            'phone'      => $comp->get_compnay_phone() ?: '0112263355',
            'phone_02'   => $comp->get_compnay_phone_02() ?: '0777892822',
            'web'        => rtrim($web, '/'),
            'logo'       => $comp->get_compnay_logo_url() ?: 'https://ems.neosolution.lk/assets/images/neo_logo.png',
            'footer_txt' => $comp->get_compnay_footer_txt() ?: ($name . ' | 0112263355 | info@neosolution.lk'),
            'sms_app_id' => $comp->get_SMS_APP_id()
        ];
    }

    public static function get_cash_owner_official_info($cash_owner_id = 0) {
        $comp = self::get_company_data();
        try {
            $db = new DataBase();
            $target_id = (int)$cash_owner_id;
            $sql = "SELECT id, name_M, email, moible_no, main_user_login_id FROM cash_owner_list WHERE ast = 1 ";
            if ($target_id > 0) {
                $sql .= "AND (id = '" . $target_id . "' OR main_user_login_id = '" . $target_id . "') ";
            }
            $sql .= "ORDER BY id ASC LIMIT 1";

            $res = $db->get_result($sql);
            if ($res && $row = $res->fetch_assoc()) {
                return [
                    'id'      => (int)$row['id'],
                    'user_id' => (int)$row['main_user_login_id'],
                    'name'    => !empty($row['name_M']) ? trim($row['name_M']) : $comp['name'],
                    'email'   => !empty($row['email']) ? trim($row['email']) : $comp['email'],
                    'phone'   => !empty($row['moible_no']) ? trim($row['moible_no']) : $comp['phone']
                ];
            }
        } catch (\Throwable $e) {
        }

        return [
            'id'      => 1,
            'user_id' => 1,
            'name'    => $comp['name'],
            'email'   => $comp['email'],
            'phone'   => $comp['phone']
        ];
    }

    public static function resolve_member_manager($member_list_id, $cash_owner_id = 0) {
        $target_mem_id = (int)$member_list_id;
        if ($target_mem_id <= 0) {
            return null;
        }

        try {
            $db = new DataBase();
            $sql = "SELECT mm.managers_list_id, m.name_M, m.email, m.moible_no, m.main_user_login_id 
                    FROM member_manager mm
                    JOIN managers_list m ON mm.managers_list_id = m.id
                    WHERE mm.member_list_id = '" . $target_mem_id . "' 
                      AND mm.ast = 1 AND m.ast = 1
                    ORDER BY mm.id DESC LIMIT 1";
            $res = $db->get_result($sql);
            if ($res && $row = $res->fetch_assoc()) {
                return [
                    'id'      => (int)$row['managers_list_id'],
                    'user_id' => (int)$row['main_user_login_id'],
                    'name'    => !empty($row['name_M']) ? trim($row['name_M']) : 'Manager',
                    'email'   => !empty($row['email']) ? trim($row['email']) : '',
                    'phone'   => !empty($row['moible_no']) ? trim($row['moible_no']) : ''
                ];
            }

            if ((int)$cash_owner_id > 0) {
                $sql2 = "SELECT id, name_M, email, moible_no, main_user_login_id 
                         FROM managers_list 
                         WHERE cash_owner_list_id = '" . (int)$cash_owner_id . "' AND ast = 1 
                         ORDER BY id ASC LIMIT 1";
                $res2 = $db->get_result($sql2);
                if ($res2 && $row2 = $res2->fetch_assoc()) {
                    return [
                        'id'      => (int)$row2['id'],
                        'user_id' => (int)$row2['main_user_login_id'],
                        'name'    => !empty($row2['name_M']) ? trim($row2['name_M']) : 'Manager',
                        'email'   => !empty($row2['email']) ? trim($row2['email']) : '',
                        'phone'   => !empty($row2['moible_no']) ? trim($row2['moible_no']) : ''
                    ];
                }
            }
        } catch (\Throwable $e) {
        }

        return null;
    }

    public static function get_member_official_info($member_list_id) {
        $target_id = (int)$member_list_id;
        if ($target_id <= 0) {
            return null;
        }
        try {
            $db = new DataBase();
            $sql = "SELECT id, name_M, email, moible_no, main_user_login_id, cash_owner_list_id 
                    FROM member_list WHERE id = '" . $target_id . "' AND ast = 1 LIMIT 1";
            $res = $db->get_result($sql);
            if ($res && $row = $res->fetch_assoc()) {
                return [
                    'id'            => (int)$row['id'],
                    'user_id'       => (int)$row['main_user_login_id'],
                    'cash_owner_id' => (int)$row['cash_owner_list_id'],
                    'name'          => !empty($row['name_M']) ? trim($row['name_M']) : 'Member #' . $target_id,
                    'email'         => !empty($row['email']) ? trim($row['email']) : '',
                    'phone'         => !empty($row['moible_no']) ? trim($row['moible_no']) : ''
                ];
            }
        } catch (\Throwable $e) {
        }
        return null;
    }

    public static function build_creative_html_email(
        $headline,
        $badge_text,
        $badge_color,
        $greeting,
        $primary_message,
        $details_rows,
        $cta_text = '',
        $cta_url = '',
        $notice_box_html = ''
    ) {
        $comp = self::get_company_data();
        $curr_year = date('Y');

        $rows_html = '';
        $i = 0;
        foreach ($details_rows as $label => $val) {
            $row_bg = ($i % 2 === 0) ? '#ffffff' : '#f8fafc';
            $rows_html .= "
            <tr style='background-color: " . $row_bg . ";'>
                <td style='padding: 12px 16px; font-size: 13px; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; width: 38%; vertical-align: top;'>" . htmlspecialchars($label) . "</td>
                <td style='padding: 12px 16px; font-size: 14px; color: #0f172a; font-weight: 700; border-bottom: 1px solid #e2e8f0; text-align: right;'>" . $val . "</td>
            </tr>";
            $i++;
        }

        $cta_button_html = '';
        if (!empty($cta_text) && !empty($cta_url)) {
            $cta_button_html = "
            <div style='text-align: center; margin: 32px 0 16px 0;'>
                <a href='" . htmlspecialchars($cta_url) . "' target='_blank' style='display: inline-block; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #ffffff; text-decoration: none; padding: 14px 36px; font-size: 15px; font-weight: 800; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35); letter-spacing: 0.3px;'>
                    " . htmlspecialchars($cta_text) . " &rarr;
                </a>
            </div>";
        }

        $logo_html = '';
        if (!empty($comp['logo'])) {
            $logo_html = "<img src='" . htmlspecialchars($comp['logo']) . "' alt='" . htmlspecialchars($comp['name']) . "' style='height: 38px; max-width: 140px; vertical-align: middle; margin-right: 12px;' />";
        }

        return "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>" . htmlspecialchars($headline) . "</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;'>
            <div style='background-color: #f1f5f9; padding: 30px 15px;'>
                <table cellpadding='0' cellspacing='0' border='0' width='100%' style='max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0;'>
                    <tr>
                        <td style='background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 26px 32px;'>
                            <table cellpadding='0' cellspacing='0' border='0' width='100%'>
                                <tr>
                                    <td style='vertical-align: middle;'>
                                        " . ($logo_html ? "<div style='margin-bottom: 6px;'>" . $logo_html . "</div>" : "") . "
                                        <div style='color: #ffffff; font-size: 21px; font-weight: 800; letter-spacing: -0.3px;'>" . htmlspecialchars($comp['name']) . "</div>
                                        <div style='color: #94a3b8; font-size: 12px; margin-top: 3px; font-weight: 500;'>Automated Financial Operations &bull; Expense Management</div>
                                    </td>
                                    <td style='text-align: right; vertical-align: middle;'>
                                        <span style='display: inline-block; background: " . $badge_color . "; color: #ffffff; font-size: 11px; font-weight: 800; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.6px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);'>
                                            " . htmlspecialchars($badge_text) . "
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 34px 32px 24px 32px;'>
                            <h2 style='margin: 0 0 16px 0; font-size: 19px; font-weight: 800; color: #0f172a; line-height: 1.3;'>
                                " . htmlspecialchars($headline) . "
                            </h2>
                            <p style='margin: 0 0 16px 0; font-size: 14.5px; color: #475569; line-height: 1.6;'>
                                " . $greeting . "
                            </p>
                            <div style='background: #f8fafc; border-left: 4px solid " . $badge_color . "; padding: 16px 20px; border-radius: 0 10px 10px 0; margin: 20px 0; font-size: 15px; color: #1e293b; font-weight: 600; line-height: 1.55;'>
                                " . $primary_message . "
                            </div>
                            <table cellpadding='0' cellspacing='0' border='0' width='100%' style='margin: 24px 0; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; background: #ffffff;'>
                                " . $rows_html . "
                            </table>
                            " . $notice_box_html . "
                            " . $cta_button_html . "
                        </td>
                    </tr>
                    <tr>
                        <td style='background: #f8fafc; padding: 24px 32px; border-top: 1px solid #e2e8f0; text-align: center;'>
                            <div style='font-size: 12.5px; color: #64748b; line-height: 1.6;'>
                                Sent on behalf of <strong>" . htmlspecialchars($comp['name']) . "</strong>.<br>
                                Contact Support: <a href='mailto:" . htmlspecialchars($comp['email']) . "' style='color: #2563eb; text-decoration: none; font-weight: 600;'>" . htmlspecialchars($comp['email']) . "</a> | Hotline: <strong>" . htmlspecialchars($comp['phone']) . "</strong>
                            </div>
                            <div style='font-size: 11.5px; color: #94a3b8; margin-top: 10px;'>
                                " . htmlspecialchars($comp['footer_txt']) . "<br>
                                &copy; " . $curr_year . " " . htmlspecialchars($comp['name']) . ". All rights reserved.
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </body>
        </html>";
    }

    public static function dispatch_direct_email($to_email, $subject, $html_body, $from_email = null, $from_name = null) {
        try {
            $to_email = trim((string)$to_email);
            if (empty($to_email) || !filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            $comp = self::get_company_data();
            $effective_from_email = !empty($from_email) ? $from_email : $comp['email'];
            $effective_from_name  = !empty($from_name) ? $from_name : $comp['name'];

            $mail = new Email($to_email, $subject, $html_body);
            if (method_exists($mail, 'set_raw_html')) {
                $mail->set_raw_html($html_body);
            }
            if (method_exists($mail, 'set_from_email')) {
                $mail->set_from_email($effective_from_email, $effective_from_name);
            }
            return @$mail->send_email();
        } catch (\Throwable $e) {
            error_log("Email dispatch failed: " . $e->getMessage());
            return false;
        }
    }

    public static function dispatch_direct_sms($phone, $message) {
        try {
            $clean_phone = preg_replace('/[^0-9]/', '', (string)$phone);
            if (empty($clean_phone) || strlen($clean_phone) < 9) {
                return false;
            }
            $sms = new SMS_Sending($clean_phone, $message);
            return $sms->send_message();
        } catch (\Throwable $e) {
            error_log("SMS dispatch failed: " . $e->getMessage());
            return false;
        }
    }

    public static function dispatch_fcm_push_notification(array $tokens, $title, $body, array $payload = []) {
        try {
            $unique_tokens = array_values(array_unique(array_filter($tokens)));
            if (empty($unique_tokens)) {
                return false;
            }

            if (!function_exists('ems_fcm_notify_tokens') && !function_exists('bmjm_fcm_notify_tokens')) {
                require_once __DIR__ . '/fcm.php';
            }

            if (function_exists('ems_fcm_notify_tokens')) {
                $image_pth = $payload['image_pth'] ?? '';
                ems_fcm_notify_tokens($unique_tokens, $title, $body, $payload, $image_pth);
                return true;
            }

            if (function_exists('bmjm_fcm_notify_tokens')) {
                $image_pth = $payload['image_pth'] ?? '';
                bmjm_fcm_notify_tokens($unique_tokens, $title, $body, $payload, $image_pth);
                return true;
            }

            $server_key = defined('FCM_SERVER_KEY') ? FCM_SERVER_KEY : '';
            if (empty($server_key)) {
                return false;
            }

            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = [
                'registration_ids' => $unique_tokens,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                    'sound' => 'default',
                    'badge' => 1
                ],
                'data' => array_merge([
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'title'        => $title,
                    'body'         => $body
                ], $payload)
            ];
            $headers = [
                'Authorization: key=' . $server_key,
                'Content-Type: application/json'
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            @curl_exec($ch);
            curl_close($ch);
            return true;
        } catch (\Throwable $e) {
            error_log("FCM push dispatch failed: " . $e->getMessage());
            return false;
        }
    }

    public static function dispatch_direct_app_notification($type, $title, $body, $member_list_id = 0, $main_user_login_id = 0, array $extra_data = []) {
        if (!class_exists('notifications_ADD_UPDATE')) {
            return false;
        }
        try {
            $notif = new notifications_ADD_UPDATE();
            $notif->set_data($type, $title, $body, '', (int)$main_user_login_id);
            if ($notif->process_new_record()) {
                $notif_id = $notif->get_id();

                $target_member_id = (int)$member_list_id;
                $target_user_id = (int)$main_user_login_id;

                if ($target_user_id <= 0 && $target_member_id > 0) {
                    $db = new DataBase();
                    $res = $db->get_result("SELECT main_user_login_id FROM member_list WHERE id = '" . $target_member_id . "' LIMIT 1");
                    if ($res && $row = $res->fetch_assoc()) {
                        $target_user_id = (int)$row['main_user_login_id'];
                    } else {
                        $res_m = $db->get_result("SELECT main_user_login_id FROM managers_list WHERE id = '" . $target_member_id . "' LIMIT 1");
                        if ($res_m && $row_m = $res_m->fetch_assoc()) {
                            $target_user_id = (int)$row_m['main_user_login_id'];
                        }
                    }
                }

                if ($target_user_id > 0 && class_exists('notification_inbox_ADD_UPDATE')) {
                    $inbox = new notification_inbox_ADD_UPDATE();
                    $inbox->set_data($notif_id, $target_user_id);
                    $inbox->process_new_record();
                }

                if (class_exists('fcm_tokens_LIST')) {
                    $fcm = new fcm_tokens_LIST();
                    $tokens = $fcm->get_tokens_for_target($target_member_id, $target_user_id);
                    if (!empty($tokens)) {
                        self::dispatch_fcm_push_notification($tokens, $title, $body, array_merge(['notification_id' => (string)$notif_id, 'type' => $type], $extra_data));
                    }
                }
                return true;
            }
        } catch (\Throwable $e) {
            error_log("App notification dispatch failed: " . $e->getMessage());
        }
        return false;
    }

    public static function notify_money_disbursed(
        $recipient_type,
        $recipient_name,
        $recipient_email,
        $recipient_phone,
        $amount,
        $channel = 'Bank Transfer',
        $cash_owner_id = 0,
        $sender_type = 'company',
        $sender_name = '',
        $member_list_id = 0,
        $main_user_login_id = 0,
        $notes = '',
        $managers_list_id = 0
    ) {
        $comp = self::get_company_data();
        $owner = self::get_cash_owner_official_info($cash_owner_id);
        $curr_sym = self::get_currency_symbol();
        $formatted_amt = $curr_sym . ' ' . number_format((float)$amount, 2);

        $from_email = $comp['email'];
        $from_name  = $comp['name'];

        $company_display_name = $comp['name'];
        $owner_display_name = !empty($owner['name']) ? $owner['name'] : $company_display_name;
        $purpose_text = !empty($notes) ? $notes : 'Float disbursement for operations';

        if ($recipient_type === 'member') {

            if ($member_list_id > 0 && (empty($recipient_email) || empty($recipient_phone) || empty($recipient_name))) {
                $mem_data = self::get_member_official_info($member_list_id);
                if ($mem_data) {
                    $recipient_name = $recipient_name ?: $mem_data['name'];
                    $recipient_email = $recipient_email ?: $mem_data['email'];
                    $recipient_phone = $recipient_phone ?: $mem_data['phone'];
                    $main_user_login_id = $main_user_login_id ?: $mem_data['user_id'];
                }
            }

            $mem_subject = "Payment Notice: " . $formatted_amt . " sent by " . $company_display_name . " - Please Collect Payment";
            $mem_headline = "Payment Sent by " . $company_display_name . " &bull; Action Required";
            $mem_greeting = "Dear <strong>" . htmlspecialchars($recipient_name) . "</strong>,";

            $sender_credit = ($sender_type === 'manager' && !empty($sender_name))
                ? "Manager <strong>" . htmlspecialchars($sender_name) . "</strong> on behalf of <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>)"
                : "company <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>)";

            $mem_primary = "You have received a payment of <strong>" . $formatted_amt . "</strong> sent by " . $sender_credit . ".<br><br><strong>Action Required:</strong> You have to collect this payment in your member portal to confirm receipt and credit your available float balance.";

            $mem_details = [
                'Beneficiary Member'  => htmlspecialchars($recipient_name),
                'Disbursed Amount'   => "<span style='color: #10b981; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
                'Company Name'       => "<strong>" . htmlspecialchars($company_display_name) . "</strong>",
                'Cash Owner'         => htmlspecialchars($owner_display_name),
                'Disbursed By'       => ($sender_type === 'manager' && !empty($sender_name) ? "Manager " . htmlspecialchars($sender_name) : "Company " . htmlspecialchars($company_display_name)),
                'Payment Channel'    => htmlspecialchars($channel),
                'Purpose / Voucher'  => htmlspecialchars($purpose_text),
                'Disbursement Date'  => date('Y-m-d H:i'),
                'Collection Status'  => "<span style='color: #f59e0b; font-weight: 800;'>Pending Collection &bull; Action Required</span>"
            ];

            $mem_instructions = "
            <div style='background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 20px; margin: 22px 0; font-size: 13.5px; color: #1e40af; line-height: 1.65;'>
                <strong style='font-size: 14px;'>📋 How to collect your payment:</strong>
                <ol style='margin: 8px 0 0 18px; padding: 0;'>
                    <li>Sign in to your <strong>" . htmlspecialchars($company_display_name) . "</strong> portal.</li>
                    <li>Navigate to your <strong>My Float / Payments</strong> section.</li>
                    <li>Click the <strong>Collect Payment</strong> button to acknowledge receipt and update your balance.</li>
                </ol>
            </div>";

            $mem_html_email = self::build_creative_html_email(
                $mem_headline,
                "Action Required &bull; Collect Payment",
                "#10b981",
                $mem_greeting,
                $mem_primary,
                $mem_details,
                "Log In & Collect Payment",
                $comp['web'] . "/UxUi/Member_Dashboard.php",
                $mem_instructions
            );

            $mem_sms = $company_display_name . ": Payment of " . $formatted_amt . " has been sent by company " . $company_display_name . " for you to collect. Please log in to your portal to collect payment. (Cash Owner: " . $owner_display_name . ")";
            $mem_app_title = "Payment to Collect: " . $formatted_amt;
            $mem_app_body  = "You have to collect payment of " . $formatted_amt . " sent by company " . $company_display_name . " (Cash Owner: " . $owner_display_name . "). Please log in to confirm.";

            self::dispatch_direct_email($recipient_email, $mem_subject, $mem_html_email, $from_email, $from_name);
            self::dispatch_direct_sms($recipient_phone, $mem_sms);
            self::dispatch_direct_app_notification('payment', $mem_app_title, $mem_app_body, $member_list_id, $main_user_login_id);

            $mgr_info = null;
            if ($managers_list_id > 0) {
                try {
                    $m_single = new managers_list_SINGLE_DATA($managers_list_id);
                    if ($m_single->get_state()) {
                        $mgr_info = [
                            'id'      => $managers_list_id,
                            'name'    => $m_single->get_name_M(),
                            'email'   => $m_single->get_email(),
                            'phone'   => $m_single->get_moible_no(),
                            'user_id' => $m_single->get_main_user_login_id()
                        ];
                    }
                } catch (\Throwable $e) {
                }
            }
            if (!$mgr_info && $member_list_id > 0) {
                $mgr_info = self::resolve_member_manager($member_list_id, $cash_owner_id);
            }

            if ($mgr_info && !empty($mgr_info['name'])) {
                $mgr_subject = "Disbursement Alert: " . $company_display_name . " sent " . $formatted_amt . " to " . $recipient_name . " - Pending Collection";
                $mgr_headline = "Member Float Disbursed &bull; Management Oversight";
                $mgr_greeting = "Dear Manager <strong>" . htmlspecialchars($mgr_info['name']) . "</strong>,";
                $mgr_primary  = "A payment disbursement of <strong>" . $formatted_amt . "</strong> has been issued to Member <strong>" . htmlspecialchars($recipient_name) . "</strong> under your team by company <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>).<br><br>The disbursement is currently <strong>Pending Member Collection</strong>.";

                $mgr_details = [
                    'Beneficiary Member' => htmlspecialchars($recipient_name) . " (ID: #" . $member_list_id . ")",
                    'Disbursed Amount'  => "<span style='color: #2563eb; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
                    'Company Name'      => "<strong>" . htmlspecialchars($company_display_name) . "</strong>",
                    'Cash Owner'        => htmlspecialchars($owner_display_name),
                    'Payment Channel'   => htmlspecialchars($channel),
                    'Purpose / Voucher' => htmlspecialchars($purpose_text),
                    'Date & Time'       => date('Y-m-d H:i'),
                    'Collection Status' => "<span style='color: #f59e0b; font-weight: 800;'>Pending Member Collection</span>"
                ];

                $mgr_instructions = "
                <div style='background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 16px 20px; margin: 22px 0; font-size: 13.5px; color: #92400e; line-height: 1.65;'>
                    <strong style='font-size: 14px;'>📌 Management Oversight:</strong><br>
                    Please ensure Member <strong>" . htmlspecialchars($recipient_name) . "</strong> collects the funds in their portal and that all subsequent expenditures are documented with valid receipts.
                </div>";

                $mgr_html_email = self::build_creative_html_email(
                    $mgr_headline,
                    "Management Notice",
                    "#2563eb",
                    $mgr_greeting,
                    $mgr_primary,
                    $mgr_details,
                    "Open Manager Dashboard",
                    $comp['web'] . "/UxUi/Manager_Dashboard.php",
                    $mgr_instructions
                );

                $mgr_sms = $company_display_name . " Alert: Payment of " . $formatted_amt . " sent to member " . $recipient_name . " by company " . $company_display_name . " (Cash Owner: " . $owner_display_name . "). Status: Pending Collection. Please oversee.";
                $mgr_app_title = "Member Payment: " . $formatted_amt;
                $mgr_app_body  = "Payment of " . $formatted_amt . " sent to member " . $recipient_name . " by company " . $company_display_name . ". Pending collection.";

                if (!empty($mgr_info['email'])) {
                    self::dispatch_direct_email($mgr_info['email'], $mgr_subject, $mgr_html_email, $from_email, $from_name);
                }
                if (!empty($mgr_info['phone'])) {
                    self::dispatch_direct_sms($mgr_info['phone'], $mgr_sms);
                }
                self::dispatch_direct_app_notification('payment', $mgr_app_title, $mgr_app_body, 0, (int)$mgr_info['user_id']);
            }

            if (!empty($owner['email']) || !empty($owner['phone']) || !empty($owner['user_id'])) {
                $co_subject = "Disbursement Confirmation: " . $formatted_amt . " issued to " . $recipient_name . " from " . $company_display_name;
                $co_headline = "Disbursement Recorded &bull; " . $company_display_name;
                $co_greeting = "Dear <strong>" . htmlspecialchars($owner_display_name) . "</strong> (" . htmlspecialchars($company_display_name) . " Cash Owner),";
                $co_primary  = "A disbursement payment of <strong>" . $formatted_amt . "</strong> has been successfully recorded and sent to Member <strong>" . htmlspecialchars($recipient_name) . "</strong> from company <strong>" . htmlspecialchars($company_display_name) . "</strong> via " . htmlspecialchars($channel) . ".<br><br>The transaction is pending collection by the member.";

                $co_details = [
                    'Company (Cash Owner)' => "<strong>" . htmlspecialchars($company_display_name) . "</strong> (" . htmlspecialchars($owner_display_name) . ")",
                    'Beneficiary'          => htmlspecialchars($recipient_name) . " (Member #" . $member_list_id . ")",
                    'Disbursed Amount'     => "<span style='color: #059669; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
                    'Source Channel'       => htmlspecialchars($channel),
                    'Purpose / Voucher'    => htmlspecialchars($purpose_text),
                    'Transaction Date'     => date('Y-m-d H:i'),
                    'Collection Status'    => "<span style='color: #f59e0b; font-weight: 800;'>Pending Collection</span>"
                ];

                $co_instructions = "
                <div style='background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin: 22px 0; font-size: 13.5px; color: #475569; line-height: 1.65;'>
                    <strong style='font-size: 14px;'>💼 Financial Audit Log:</strong><br>
                    Disbursing vault balance will be debited and available float credited once member confirms collection in portal.
                </div>";

                $co_html_email = self::build_creative_html_email(
                    $co_headline,
                    "Disbursement Confirmation",
                    "#059669",
                    $co_greeting,
                    $co_primary,
                    $co_details,
                    "View Disbursements in Dashboard",
                    $comp['web'] . "/UxUi/Cash_Owner_Dashboard.php?tab=disbursements",
                    $co_instructions
                );

                $co_sms = $company_display_name . ": Disbursement of " . $formatted_amt . " to " . $recipient_name . " successfully recorded from company " . $company_display_name . " (Cash Owner: " . $owner_display_name . "). Channel: " . $channel . ". Pending collection.";
                $co_app_title = "Disbursement Issued: " . $formatted_amt;
                $co_app_body  = "Payment of " . $formatted_amt . " sent to " . $recipient_name . " from company " . $company_display_name . ". Pending collection.";

                if (!empty($owner['email'])) {
                    self::dispatch_direct_email($owner['email'], $co_subject, $co_html_email, $from_email, $from_name);
                }
                if (!empty($owner['phone'])) {
                    self::dispatch_direct_sms($owner['phone'], $co_sms);
                }
                self::dispatch_direct_app_notification('payment', $co_app_title, $co_app_body, 0, (int)$owner['user_id']);
            }

            return true;
        }

        if ($recipient_type === 'manager') {

            $mgr_subject = "Float Payment Notice: " . $formatted_amt . " sent by " . $company_display_name . " - Please Collect Payment";
            $mgr_headline = "Float Payment Sent by " . $company_display_name . " &bull; Action Required";
            $mgr_greeting = "Dear Manager <strong>" . htmlspecialchars($recipient_name) . "</strong>,";
            $mgr_primary  = "You have received a float advance of <strong>" . $formatted_amt . "</strong> sent by company <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>).<br><br><strong>Action Required:</strong> You have to collect this payment in your manager portal to credit your operational float balance.";

            $mgr_details = [
                'Beneficiary Manager' => htmlspecialchars($recipient_name),
                'Disbursed Amount'   => "<span style='color: #10b981; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
                'Company Name'       => "<strong>" . htmlspecialchars($company_display_name) . "</strong>",
                'Cash Owner'         => htmlspecialchars($owner_display_name),
                'Payment Channel'    => htmlspecialchars($channel),
                'Purpose / Voucher'  => htmlspecialchars($purpose_text),
                'Disbursement Date'  => date('Y-m-d H:i'),
                'Collection Status'  => "<span style='color: #f59e0b; font-weight: 800;'>Pending Collection &bull; Action Required</span>"
            ];

            $mgr_instructions = "
            <div style='background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 20px; margin: 22px 0; font-size: 13.5px; color: #1e40af; line-height: 1.65;'>
                <strong style='font-size: 14px;'>📋 How to collect your float:</strong><br>
                Please sign in to your manager portal, visit your Payments section, and click <strong>Collect Payment</strong> to confirm receipt.
            </div>";

            $mgr_html_email = self::build_creative_html_email(
                $mgr_headline,
                "Action Required &bull; Collect Float",
                "#10b981",
                $mgr_greeting,
                $mgr_primary,
                $mgr_details,
                "Collect Float in Portal",
                $comp['web'] . "/UxUi/Manager_Dashboard.php",
                $mgr_instructions
            );

            $mgr_sms = $company_display_name . ": Float payment of " . $formatted_amt . " sent by company " . $company_display_name . " for you to collect. Please log in to your portal to collect. (Cash Owner: " . $owner_display_name . ")";
            $mgr_app_title = "Float to Collect: " . $formatted_amt;
            $mgr_app_body  = "You have to collect float payment of " . $formatted_amt . " sent by company " . $company_display_name . " (Cash Owner: " . $owner_display_name . "). Please log in to confirm.";

            self::dispatch_direct_email($recipient_email, $mgr_subject, $mgr_html_email, $from_email, $from_name);
            self::dispatch_direct_sms($recipient_phone, $mgr_sms);
            self::dispatch_direct_app_notification('payment', $mgr_app_title, $mgr_app_body, 0, $main_user_login_id);

            if (!empty($owner['email']) || !empty($owner['phone']) || !empty($owner['user_id'])) {
                $co_subject = "Disbursement Confirmation: " . $formatted_amt . " sent to Manager " . $recipient_name . " from " . $company_display_name;
                $co_headline = "Float Disbursed to Manager &bull; " . $company_display_name;
                $co_greeting = "Dear <strong>" . htmlspecialchars($owner_display_name) . "</strong> (" . htmlspecialchars($company_display_name) . " Cash Owner),";
                $co_primary  = "A float disbursement of <strong>" . $formatted_amt . "</strong> has been issued to Manager <strong>" . htmlspecialchars($recipient_name) . "</strong> from company <strong>" . htmlspecialchars($company_display_name) . "</strong> via " . htmlspecialchars($channel) . ". Awaiting collection.";

                $co_details = [
                    'Company (Cash Owner)' => "<strong>" . htmlspecialchars($company_display_name) . "</strong> (" . htmlspecialchars($owner_display_name) . ")",
                    'Beneficiary Manager'  => htmlspecialchars($recipient_name),
                    'Disbursed Amount'     => "<span style='color: #059669; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
                    'Source Channel'       => htmlspecialchars($channel),
                    'Purpose / Voucher'    => htmlspecialchars($purpose_text),
                    'Transaction Date'     => date('Y-m-d H:i'),
                    'Collection Status'    => "<span style='color: #f59e0b; font-weight: 800;'>Pending Collection</span>"
                ];

                $co_html_email = self::build_creative_html_email(
                    $co_headline,
                    "Disbursement Confirmation",
                    "#059669",
                    $co_greeting,
                    $co_primary,
                    $co_details,
                    "View Disbursements in Dashboard",
                    $comp['web'] . "/UxUi/Cash_Owner_Dashboard.php?tab=disbursements"
                );

                $co_sms = $company_display_name . ": Float of " . $formatted_amt . " to Manager " . $recipient_name . " recorded from company " . $company_display_name . " (Cash Owner: " . $owner_display_name . "). Pending collection.";
                $co_app_title = "Manager Float Sent: " . $formatted_amt;
                $co_app_body  = "Float of " . $formatted_amt . " sent to Manager " . $recipient_name . " from company " . $company_display_name . ".";

                if (!empty($owner['email'])) {
                    self::dispatch_direct_email($owner['email'], $co_subject, $co_html_email, $from_email, $from_name);
                }
                if (!empty($owner['phone'])) {
                    self::dispatch_direct_sms($owner['phone'], $co_sms);
                }
                self::dispatch_direct_app_notification('payment', $co_app_title, $co_app_body, 0, (int)$owner['user_id']);
            }

            return true;
        }

        return false;
    }

    public static function notify_payment_collected(
        $recipient_type,
        $recipient_name,
        $amount,
        $channel = 'Bank Transfer',
        $cash_owner_id = 0,
        $member_list_id = 0,
        $main_user_login_id = 0,
        $managers_list_id = 0
    ) {
        $comp = self::get_company_data();
        $owner = self::get_cash_owner_official_info($cash_owner_id);
        $curr_sym = self::get_currency_symbol();
        $formatted_amt = $curr_sym . ' ' . number_format((float)$amount, 2);

        $from_email = $comp['email'];
        $from_name  = $comp['name'];

        $company_display_name = $comp['name'];
        $owner_display_name = !empty($owner['name']) ? $owner['name'] : $company_display_name;

        $rec_subject = "Payment Collected Successfully: " . $formatted_amt . " from " . $company_display_name;
        $rec_headline = "Payment Collected &bull; Float Balance Credited";
        $rec_greeting = "Dear <strong>" . htmlspecialchars($recipient_name) . "</strong>,";
        $rec_primary  = "You have successfully collected the payment of <strong>" . $formatted_amt . "</strong> sent by company <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>).<br><br>The amount has been added to your available float balance.";

        $rec_details = [
            'Collected By'     => htmlspecialchars($recipient_name),
            'Amount Credited'  => "<span style='color: #10b981; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
            'Company Name'     => "<strong>" . htmlspecialchars($company_display_name) . "</strong>",
            'Cash Owner'       => htmlspecialchars($owner_display_name),
            'Payment Channel'  => htmlspecialchars($channel),
            'Collection Time'  => date('Y-m-d H:i'),
            'Status'           => "<span style='color: #10b981; font-weight: 800;'>Collected &amp; Credited</span>"
        ];

        $target_portal = ($recipient_type === 'manager') ? "/UxUi/Manager_Dashboard.php" : "/UxUi/Member_Dashboard.php";
        $rec_html = self::build_creative_html_email(
            $rec_headline,
            "Collected Successfully",
            "#10b981",
            $rec_greeting,
            $rec_primary,
            $rec_details,
            "View Float Balance",
            $comp['web'] . $target_portal
        );

        $rec_sms = $company_display_name . ": You have successfully collected payment of " . $formatted_amt . " from company " . $company_display_name . ". Float balance credited.";
        $rec_app_title = "Payment Collected: " . $formatted_amt;
        $rec_app_body  = "Payment of " . $formatted_amt . " successfully collected. Your float balance has been credited.";

        if ($recipient_type === 'member' && $member_list_id > 0) {
            $mem_info = self::get_member_official_info($member_list_id);
            if ($mem_info) {
                if (!empty($mem_info['email'])) {
                    self::dispatch_direct_email($mem_info['email'], $rec_subject, $rec_html, $from_email, $from_name);
                }
                if (!empty($mem_info['phone'])) {
                    self::dispatch_direct_sms($mem_info['phone'], $rec_sms);
                }
            }
        }
        self::dispatch_direct_app_notification('payment', $rec_app_title, $rec_app_body, $member_list_id, $main_user_login_id);

        if ($recipient_type === 'member') {
            $mgr_info = null;
            if ($managers_list_id > 0) {
                try {
                    $m_single = new managers_list_SINGLE_DATA($managers_list_id);
                    if ($m_single->get_state()) {
                        $mgr_info = [
                            'name'    => $m_single->get_name_M(),
                            'email'   => $m_single->get_email(),
                            'phone'   => $m_single->get_moible_no(),
                            'user_id' => $m_single->get_main_user_login_id()
                        ];
                    }
                } catch (\Throwable $e) {
                }
            }
            if (!$mgr_info && $member_list_id > 0) {
                $mgr_info = self::resolve_member_manager($member_list_id, $cash_owner_id);
            }

            if ($mgr_info) {
                $mgr_sms = $company_display_name . " Notice: Member " . $recipient_name . " has collected payment of " . $formatted_amt . ".";
                $mgr_app_title = "Member Payment Collected: " . $formatted_amt;
                $mgr_app_body  = "Member " . $recipient_name . " has collected payment of " . $formatted_amt . ".";

                if (!empty($mgr_info['phone'])) {
                    self::dispatch_direct_sms($mgr_info['phone'], $mgr_sms);
                }
                self::dispatch_direct_app_notification('payment', $mgr_app_title, $mgr_app_body, 0, (int)$mgr_info['user_id']);
            }
        }

        $co_sms = $company_display_name . ": " . $recipient_name . " has collected payment of " . $formatted_amt . " from " . $company_display_name . " (Cash Owner: " . $owner_display_name . "). Safe/Bank balance debited.";
        $co_app_title = "Payment Collected by " . $recipient_name;
        $co_app_body  = $recipient_name . " has collected payment of " . $formatted_amt . " from " . $company_display_name . ".";

        if (!empty($owner['phone'])) {
            self::dispatch_direct_sms($owner['phone'], $co_sms);
        }
        self::dispatch_direct_app_notification('payment', $co_app_title, $co_app_body, 0, (int)$owner['user_id']);

        return true;
    }

    public static function notify_expense_submitted(
        $member_name,
        $amount,
        $category_name,
        $description,
        $date,
        $cash_owner_id = 0,
        $member_list_id = 0
    ) {
        $comp = self::get_company_data();
        $owner = self::get_cash_owner_official_info($cash_owner_id);
        $curr_sym = self::get_currency_symbol();
        $formatted_amt = $curr_sym . ' ' . number_format((float)$amount, 2);

        $from_email = $comp['email'];
        $from_name  = $comp['name'];

        $company_display_name = $comp['name'];
        $owner_display_name = !empty($owner['name']) ? $owner['name'] : $company_display_name;

        $subject = "New Expense Claim: " . $member_name . " submitted " . $formatted_amt . " to " . $company_display_name;
        $headline = "New Expense Claim Awaiting Approval &bull; " . $company_display_name;
        $primary = "Member <strong>" . htmlspecialchars($member_name) . "</strong> has submitted a new expense claim of <strong>" . $formatted_amt . "</strong> for company <strong>" . htmlspecialchars($company_display_name) . "</strong>.<br><br>Please review and approve or reject it in your dashboard.";

        $details = [
            'Member Name'  => htmlspecialchars($member_name) . ($member_list_id > 0 ? " (#" . $member_list_id . ")" : ""),
            'Claim Amount' => "<span style='color: #ef4444; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
            'Company'      => "<strong>" . htmlspecialchars($company_display_name) . "</strong>",
            'Category'     => htmlspecialchars($category_name ?: 'General Expense'),
            'Description'  => htmlspecialchars($description ?: 'Operational claim'),
            'Claim Date'   => htmlspecialchars($date ?: date('Y-m-d')),
            'Audit Status' => "<span style='color: #f59e0b; font-weight: 800;'>Pending Audit Approval</span>"
        ];

        $html_email = self::build_creative_html_email(
            $headline,
            "Approval Required",
            "#f59e0b",
            "Dear <strong>" . htmlspecialchars($owner_display_name) . "</strong>,",
            $primary,
            $details,
            "Review & Approve Claim",
            $comp['web'] . "/UxUi/Cash_Owner_Dashboard.php?tab=expenses"
        );

        $sms_msg = $company_display_name . ": " . $member_name . " submitted an expense of " . $formatted_amt . ". Please review in your dashboard. (Cash Owner: " . $owner_display_name . ")";
        $app_title = "New Expense Claim: " . $formatted_amt;
        $app_body  = $member_name . " submitted an expense of " . $formatted_amt . " to " . $company_display_name . ". Review required.";

        if (!empty($owner['email'])) {
            self::dispatch_direct_email($owner['email'], $subject, $html_email, $from_email, $from_name);
        }
        if (!empty($owner['phone'])) {
            self::dispatch_direct_sms($owner['phone'], $sms_msg);
        }
        self::dispatch_direct_app_notification('expense', $app_title, $app_body, $member_list_id, (int)$owner['user_id']);

        if ($member_list_id > 0) {
            $mgr_info = self::resolve_member_manager($member_list_id, $cash_owner_id);
            if ($mgr_info) {
                $mgr_sms = $company_display_name . " Notice: Member " . $member_name . " submitted an expense of " . $formatted_amt . " (" . $category_name . ").";
                $mgr_app_title = "Member Expense Claim: " . $formatted_amt;
                $mgr_app_body  = "Member " . $member_name . " submitted an expense claim of " . $formatted_amt . ".";

                if (!empty($mgr_info['phone'])) {
                    self::dispatch_direct_sms($mgr_info['phone'], $mgr_sms);
                }
                self::dispatch_direct_app_notification('expense', $mgr_app_title, $mgr_app_body, 0, (int)$mgr_info['user_id']);
            }
        }

        if ($member_list_id > 0) {
            $mem_info = self::get_member_official_info($member_list_id);
            if ($mem_info) {
                $mem_sms = $company_display_name . ": Your expense claim of " . $formatted_amt . " has been received and is awaiting approval.";
                $mem_app_title = "Expense Claim Submitted: " . $formatted_amt;
                $mem_app_body  = "Your claim of " . $formatted_amt . " was submitted to " . $company_display_name . ". Awaiting approval.";

                if (!empty($mem_info['phone'])) {
                    self::dispatch_direct_sms($mem_info['phone'], $mem_sms);
                }
                self::dispatch_direct_app_notification('expense', $mem_app_title, $mem_app_body, $member_list_id, (int)$mem_info['user_id']);
            }
        }

        return true;
    }

    public static function notify_expense_status_changed(
        $expense_id,
        $status,
        $amount,
        $member_list_id,
        $ref_no = '',
        $cash_owner_id = 0,
        $reason = ''
    ) {
        $comp = self::get_company_data();
        $owner = self::get_cash_owner_official_info($cash_owner_id);
        $curr_sym = self::get_currency_symbol();
        $formatted_amt = $curr_sym . ' ' . number_format((float)$amount, 2);

        $from_email = $comp['email'];
        $from_name  = $comp['name'];

        $company_display_name = $comp['name'];
        $owner_display_name = !empty($owner['name']) ? $owner['name'] : $company_display_name;
        $is_approved = ($status === 'approved' || $status === 1 || $status === '1');

        $status_label = $is_approved ? 'Approved' : 'Rejected';
        $badge_color  = $is_approved ? '#10b981' : '#ef4444';

        $mem_info = self::get_member_official_info($member_list_id);
        $member_name = $mem_info ? $mem_info['name'] : 'Member #' . $member_list_id;

        if ($mem_info) {
            $subject = "Expense Claim " . $status_label . ": " . $formatted_amt . " by " . $company_display_name;
            $headline = "Expense Claim " . $status_label . " &bull; " . $company_display_name;
            $greeting = "Dear <strong>" . htmlspecialchars($member_name) . "</strong>,";
            $primary  = $is_approved
                ? "Your expense claim of <strong>" . $formatted_amt . "</strong> (Claim #" . $expense_id . ") has been <strong>APPROVED</strong> by company <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>).<br><br>The corresponding float amount has been deducted from your available balance."
                : "Your expense claim of <strong>" . $formatted_amt . "</strong> (Claim #" . $expense_id . ") was <strong>REJECTED</strong> by company <strong>" . htmlspecialchars($company_display_name) . "</strong> (Cash Owner: <strong>" . htmlspecialchars($owner_display_name) . "</strong>)." . (!empty($reason) ? "<br><br><strong>Reason:</strong> " . htmlspecialchars($reason) : "");

            $details = [
                'Claim ID'      => "#" . $expense_id . (!empty($ref_no) ? " (" . htmlspecialchars($ref_no) . ")" : ""),
                'Claim Amount'  => "<span style='color: " . $badge_color . "; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
                'Company Name'  => "<strong>" . htmlspecialchars($company_display_name) . "</strong>",
                'Cash Owner'    => htmlspecialchars($owner_display_name),
                'Decision'      => "<span style='color: " . $badge_color . "; font-weight: 800;'>" . $status_label . "</span>",
                'Updated On'    => date('Y-m-d H:i')
            ];

            $html_email = self::build_creative_html_email(
                $headline,
                "Claim " . $status_label,
                $badge_color,
                $greeting,
                $primary,
                $details,
                "View Expense Claims",
                $comp['web'] . "/UxUi/Member_Dashboard.php"
            );

            $sms_msg = $company_display_name . ": Your expense claim #" . $expense_id . " (" . $formatted_amt . ") has been " . strtoupper($status_label) . " by " . $company_display_name . ".";
            $app_title = "Expense Claim " . $status_label . ": " . $formatted_amt;
            $app_body  = "Your claim #" . $expense_id . " of " . $formatted_amt . " has been " . strtolower($status_label) . " by " . $company_display_name . ".";

            if (!empty($mem_info['email'])) {
                self::dispatch_direct_email($mem_info['email'], $subject, $html_email, $from_email, $from_name);
            }
            if (!empty($mem_info['phone'])) {
                self::dispatch_direct_sms($mem_info['phone'], $sms_msg);
            }
            self::dispatch_direct_app_notification('expense', $app_title, $app_body, $member_list_id, (int)$mem_info['user_id']);
        }

        $mgr_info = self::resolve_member_manager($member_list_id, $cash_owner_id);
        if ($mgr_info) {
            $mgr_sms = $company_display_name . " Notice: Claim #" . $expense_id . " (" . $formatted_amt . ") for member " . $member_name . " has been " . strtoupper($status_label) . ".";
            $mgr_app_title = "Member Claim " . $status_label . ": " . $formatted_amt;
            $mgr_app_body  = "Claim #" . $expense_id . " (" . $formatted_amt . ") for " . $member_name . " was " . strtolower($status_label) . ".";

            if (!empty($mgr_info['phone'])) {
                self::dispatch_direct_sms($mgr_info['phone'], $mgr_sms);
            }
            self::dispatch_direct_app_notification('expense', $mgr_app_title, $mgr_app_body, 0, (int)$mgr_info['user_id']);
        }

        return true;
    }

    public static function notify_scheduled_check(
        $check_number,
        $amount,
        $bank_name,
        $receiver,
        $realesed_date,
        $cash_owner_id = 0,
        $payee_email = '',
        $payee_phone = '',
        $due_type = 'due'
    ) {
        $comp = self::get_company_data();
        $owner = self::get_cash_owner_official_info($cash_owner_id);
        $curr_sym = self::get_currency_symbol();
        $formatted_amt = $curr_sym . ' ' . number_format((float)$amount, 2);

        $from_email = $comp['email'];
        $from_name  = $comp['name'];

        $badge_text = "Cheque Schedule";
        $badge_color = "#0284c7";
        $subject = "Scheduled Cheque Notice: Cheque #" . $check_number . " due (" . $realesed_date . ") - " . $comp['name'];
        $headline = "Cheque Notice &bull; " . $comp['name'];
        $primary = "Cheque <strong>#" . htmlspecialchars($check_number) . "</strong> for <strong>" . $formatted_amt . "</strong> is scheduled for release on <strong>" . htmlspecialchars($realesed_date) . "</strong> from company <strong>" . htmlspecialchars($comp['name']) . "</strong>.";
        $sms_msg = $comp['name'] . ": Reminder: Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is scheduled for release on " . $realesed_date . ".";
        $app_title = "Cheque Notice: " . $formatted_amt;
        $app_body = "Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is scheduled for release on " . $realesed_date . ".";

        if ($due_type === 'today') {
            $badge_text = "Due Today";
            $badge_color = "#ef4444";
            $subject = "Cheque Due Today: Cheque #" . $check_number . " (" . $formatted_amt . ") - " . $comp['name'];
            $headline = "Cheque Due Today &bull; " . $comp['name'];
            $primary = "Cheque <strong>#" . htmlspecialchars($check_number) . "</strong> for <strong>" . $formatted_amt . "</strong> is <strong>DUE TODAY</strong> (" . htmlspecialchars($realesed_date) . ") for <strong>" . htmlspecialchars($receiver) . "</strong>.";
            $sms_msg = $comp['name'] . ": Alert: Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is DUE TODAY (" . $realesed_date . ").";
            $app_title = "Today Cheque: " . $formatted_amt;
            $app_body = "Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is due today.";
        } elseif ($due_type === 'overdue' || $due_type === 'due') {
            $badge_text = "Cheque Due";
            $badge_color = "#dc2626";
            $subject = "Cheque Due Notice: Cheque #" . $check_number . " (" . $formatted_amt . ") - " . $comp['name'];
            $headline = "Cheque Due Alert &bull; " . $comp['name'];
            $primary = "Cheque <strong>#" . htmlspecialchars($check_number) . "</strong> for <strong>" . $formatted_amt . "</strong> is due / overdue (" . htmlspecialchars($realesed_date) . ") for <strong>" . htmlspecialchars($receiver) . "</strong>.";
            $sms_msg = $comp['name'] . ": Due Cheque Alert: Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is due (" . $realesed_date . ").";
            $app_title = "Cheque Due: " . $formatted_amt;
            $app_body = "Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is due (" . $realesed_date . ").";
        } elseif ($due_type === 'tomorrow') {
            $badge_text = "Due Tomorrow";
            $badge_color = "#f59e0b";
            $subject = "Cheque Due Tomorrow: Cheque #" . $check_number . " (" . $formatted_amt . ") - " . $comp['name'];
            $headline = "Cheque Due Tomorrow &bull; " . $comp['name'];
            $primary = "Cheque <strong>#" . htmlspecialchars($check_number) . "</strong> for <strong>" . $formatted_amt . "</strong> is scheduled for release tomorrow on <strong>" . htmlspecialchars($realesed_date) . "</strong>.";
            $sms_msg = $comp['name'] . ": Reminder: Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is scheduled for release tomorrow (" . $realesed_date . ").";
            $app_title = "Cheque Tomorrow: " . $formatted_amt;
            $app_body = "Cheque #" . $check_number . " (" . $formatted_amt . ") for " . $receiver . " is due tomorrow.";
        }

        $details = [
            'Company Name'  => "<strong>" . htmlspecialchars($comp['name']) . "</strong>",
            'Cheque Number' => "<strong>#" . htmlspecialchars($check_number) . "</strong>",
            'Amount'        => "<span style='color: " . $badge_color . "; font-size: 18px; font-weight: 800;'>" . $formatted_amt . "</span>",
            'Bank Account'  => htmlspecialchars($bank_name),
            'Beneficiary'   => htmlspecialchars($receiver),
            'Release Date'  => htmlspecialchars($realesed_date)
        ];

        $html_email = self::build_creative_html_email(
            $headline,
            $badge_text,
            $badge_color,
            "Dear <strong>" . htmlspecialchars($owner['name']) . "</strong>,",
            $primary,
            $details,
            "View Cheques Register",
            $comp['web'] . "/UxUi/Cash_Owner_Dashboard.php?tab=checks"
        );

        if (!empty($owner['email'])) {
            self::dispatch_direct_email($owner['email'], $subject, $html_email, $from_email, $from_name);
        }
        if (!empty($owner['phone'])) {
            self::dispatch_direct_sms($owner['phone'], $sms_msg);
        }
        if (!empty($payee_email)) {
            self::dispatch_direct_email($payee_email, $subject, $html_email, $from_email, $from_name);
        }
        if (!empty($payee_phone)) {
            self::dispatch_direct_sms($payee_phone, $sms_msg);
        }

        self::dispatch_direct_app_notification('check', $app_title, $app_body, 0, (int)$owner['user_id'], ['due_type' => $due_type]);

        return true;
    }

    public static function notify_due_checks_for_cash_owner($cash_owner_id = 0) {
        $db = new DataBase();
        $target_id = (int)$cash_owner_id;
        $sql = "SELECT c.*, b.name AS bank_name, b.bank_name AS bank_institution 
                FROM bank_check_data c 
                LEFT JOIN bank_account b ON b.id = c.bank_account_id 
                WHERE c.ast = 1 
                AND c.is_completed = 0 
                AND c.realesed_date IS NOT NULL";
        if ($target_id > 0) {
            $sql .= " AND c.cash_owner_list_id = '" . $target_id . "'";
        }
        $sql .= " ORDER BY c.realesed_date ASC";

        $res = $db->get_result($sql);
        $notified = [];
        $curdate = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $chk_no = !empty($row['check_number']) ? $row['check_number'] : $row['id'];
                $b_name = !empty($row['bank_name']) ? $row['bank_name'] : ($row['bank_institution'] ?? 'Bank Account');
                $amt = (float)$row['amount'];
                $recv = $row['receiver'] ?: 'Beneficiary';
                $rel_date = substr($row['realesed_date'], 0, 10);
                $co_id = (int)$row['cash_owner_list_id'];

                $due_type = 'due';
                if ($rel_date === $curdate) {
                    $due_type = 'today';
                } elseif ($rel_date < $curdate) {
                    $due_type = 'overdue';
                } elseif ($rel_date === $tomorrow) {
                    $due_type = 'tomorrow';
                } else {
                    continue;
                }

                self::notify_scheduled_check(
                    $chk_no,
                    $amt,
                    $b_name,
                    $recv,
                    $rel_date,
                    $co_id,
                    '',
                    '',
                    $due_type
                );

                $notified[] = [
                    'id' => $row['id'],
                    'check_number' => $chk_no,
                    'amount' => $amt,
                    'receiver' => $recv,
                    'realesed_date' => $rel_date,
                    'type' => $due_type
                ];
            }
        }
        return $notified;
    }

    public static function notify_user_created(
        $user_name,
        $password,
        $full_name,
        $user_email,
        $user_phone,
        $role = 'Member',
        $cash_owner_id = 0,
        $member_list_id = 0,
        $main_user_login_id = 0
    ) {
        $comp = self::get_company_data();
        $owner = self::get_cash_owner_official_info($cash_owner_id);

        $from_email = $comp['email'];
        $from_name  = $comp['name'];

        $subject = "Welcome to " . $comp['name'] . " - Your Login Credentials";
        $headline = "Welcome to " . $comp['name'];
        $primary = "Your user account has been created successfully. Below are your official system login credentials to access the <strong>" . htmlspecialchars($comp['name']) . "</strong> financial management portal:";

        $details = [
            'Company Name'  => "<strong>" . htmlspecialchars($comp['name']) . "</strong>",
            'Full Name'     => htmlspecialchars($full_name),
            'Assigned Role' => "<span style='color: #2563eb; font-weight: 800;'>" . htmlspecialchars(ucfirst($role)) . "</span>",
            'Username'      => "<code style='background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-weight: 700; color: #0f172a;'>" . htmlspecialchars($user_name) . "</code>",
            'Password'      => "<code style='background: #fef2f2; padding: 4px 8px; border-radius: 4px; font-weight: 700; color: #dc2626;'>" . htmlspecialchars($password) . "</code>",
            'Portal Link'   => "<a href='" . htmlspecialchars($comp['web']) . "' style='color: #2563eb; font-weight: 600;'>" . htmlspecialchars($comp['web']) . "</a>"
        ];

        $html_email = self::build_creative_html_email(
            $headline,
            "Account Created",
            "#2563eb",
            "Dear <strong>" . htmlspecialchars($full_name) . "</strong>,",
            $primary,
            $details,
            "Sign In to Your Portal",
            $comp['web'] . "/Login.php"
        );

        $sms_msg = "Welcome to " . $comp['name'] . "! Login credentials: Username: " . $user_name . ", Password: " . $password . ". Portal: " . $comp['web'];
        $app_title = "Welcome to " . $comp['name'];
        $app_body = "Your account has been created. Please sign in with your credentials.";

        self::dispatch_direct_email($user_email, $subject, $html_email, $from_email, $from_name);
        self::dispatch_direct_sms($user_phone, $sms_msg);
        self::dispatch_direct_app_notification('user', $app_title, $app_body, $member_list_id, $main_user_login_id);

        return true;
    }

    /**
     * Resolve employee email, phone, and name from employees / employee_profiles / main_user_login
     */
    public static function resolve_staff_contact_info($identifier, $fallbackEmail = '', $fallbackPhone = '') {
        $info = [
            'name'       => is_string($identifier) ? trim($identifier) : 'Employee',
            'email'      => trim((string)$fallbackEmail),
            'phone'      => trim((string)$fallbackPhone),
            'user_id'    => 0,
            'department' => '',
            'job_title'  => ''
        ];

        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();

            // If numeric identifier, treat as user_id or employee_id
            if (is_numeric($identifier) && (int)$identifier > 0) {
                $uid = (int)$identifier;
                $q = $conn->query("SELECT p.*, u.user_name AS login_email FROM `employee_profiles` p LEFT JOIN `main_user_login` u ON u.id = p.user_id WHERE p.user_id = {$uid} OR p.id = {$uid} LIMIT 1");
                if ($q && $r = $q->fetch_assoc()) {
                    if (!empty($r['full_name'])) $info['name'] = trim($r['full_name']);
                    if (!empty($r['email']) && filter_var($r['email'], FILTER_VALIDATE_EMAIL)) $info['email'] = trim($r['email']);
                    elseif (!empty($r['login_email']) && filter_var($r['login_email'], FILTER_VALIDATE_EMAIL)) $info['email'] = trim($r['login_email']);
                    if (!empty($r['phone_number'])) $info['phone'] = trim($r['phone_number']);
                    $info['user_id'] = (int)($r['user_id'] ?? $uid);
                    $info['department'] = $r['department'] ?? '';
                    $info['job_title'] = $r['job_title'] ?? '';
                    return $info;
                }

                $q2 = $conn->query("SELECT * FROM `employees` WHERE id = {$uid} OR user_id = {$uid} LIMIT 1");
                if ($q2 && $r2 = $q2->fetch_assoc()) {
                    if (!empty($r2['fullname'])) $info['name'] = trim($r2['fullname']);
                    elseif (!empty($r2['name'])) $info['name'] = trim($r2['name']);
                    if (!empty($r2['email_address']) && filter_var($r2['email_address'], FILTER_VALIDATE_EMAIL)) $info['email'] = trim($r2['email_address']);
                    if (!empty($r2['phone_number'])) $info['phone'] = trim($r2['phone_number']);
                    $info['user_id'] = (int)($r2['user_id'] ?? $uid);
                    $info['department'] = $r2['department'] ?? '';
                    $info['job_title'] = $r2['role'] ?? '';
                    return $info;
                }
            }

            // String identifier (name or email)
            if (is_string($identifier) && trim($identifier) !== '') {
                $clean = trim($identifier);
                $escaped = mysqli_real_escape_string($conn, $clean);

                $q = $conn->query("SELECT p.*, u.user_name AS login_email FROM `employee_profiles` p LEFT JOIN `main_user_login` u ON u.id = p.user_id WHERE p.full_name LIKE '{$escaped}' OR p.email = '{$escaped}' LIMIT 1");
                if ($q && $r = $q->fetch_assoc()) {
                    if (!empty($r['full_name'])) $info['name'] = trim($r['full_name']);
                    if (!empty($r['email']) && filter_var($r['email'], FILTER_VALIDATE_EMAIL)) $info['email'] = trim($r['email']);
                    elseif (!empty($r['login_email']) && filter_var($r['login_email'], FILTER_VALIDATE_EMAIL)) $info['email'] = trim($r['login_email']);
                    if (!empty($r['phone_number'])) $info['phone'] = trim($r['phone_number']);
                    $info['user_id'] = (int)($r['user_id'] ?? 0);
                    $info['department'] = $r['department'] ?? '';
                    $info['job_title'] = $r['job_title'] ?? '';
                    return $info;
                }

                $q2 = $conn->query("SELECT * FROM `employees` WHERE fullname LIKE '{$escaped}' OR name LIKE '{$escaped}' OR email_address = '{$escaped}' LIMIT 1");
                if ($q2 && $r2 = $q2->fetch_assoc()) {
                    if (!empty($r2['fullname'])) $info['name'] = trim($r2['fullname']);
                    elseif (!empty($r2['name'])) $info['name'] = trim($r2['name']);
                    if (!empty($r2['email_address']) && filter_var($r2['email_address'], FILTER_VALIDATE_EMAIL)) $info['email'] = trim($r2['email_address']);
                    if (!empty($r2['phone_number'])) $info['phone'] = trim($r2['phone_number']);
                    $info['user_id'] = (int)($r2['user_id'] ?? 0);
                    $info['department'] = $r2['department'] ?? '';
                    $info['job_title'] = $r2['role'] ?? '';
                    return $info;
                }
            }
        } catch (\Throwable $e) {}

        return $info;
    }

    /**
     * Resolve admin contact info
     */
    public static function resolve_admin_contact_info() {
        $info = [
            'name'    => 'Administrator',
            'email'   => '',
            'phone'   => '',
            'user_id' => 1
        ];

        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $q = $conn->query("SELECT id, user_name, first_name, last_name, phone_number FROM `main_user_login` WHERE `main_user_account_access_level_list_id` = 1 AND `ast` = 1 ORDER BY `id` ASC LIMIT 1");
            if ($q && $r = $q->fetch_assoc()) {
                $info['user_id'] = (int)$r['id'];
                if (!empty($r['user_name']) && filter_var($r['user_name'], FILTER_VALIDATE_EMAIL)) {
                    $info['email'] = trim($r['user_name']);
                }
                $fname = trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? ''));
                if ($fname !== '') $info['name'] = $fname;
                if (!empty($r['phone_number'])) $info['phone'] = trim($r['phone_number']);
            }
        } catch (\Throwable $e) {}

        if (empty($info['email'])) {
            $comp = self::get_company_data();
            $info['email'] = $comp['email'];
        }

        return $info;
    }

    /**
     * Notify Admin when an employee submits a new Leave Request
     */
    public static function notify_leave_requested(array $leaveData) {
        $comp = self::get_company_data();
        $admin = self::resolve_admin_contact_info();

        $empName   = !empty($leaveData['employee']) ? $leaveData['employee'] : 'Employee';
        $leaveType = !empty($leaveData['type']) ? $leaveData['type'] : 'Annual Leave';
        $from      = !empty($leaveData['from']) ? $leaveData['from'] : date('Y-m-d');
        $to        = !empty($leaveData['to']) ? $leaveData['to'] : $from;
        $days      = !empty($leaveData['days']) ? (int)$leaveData['days'] : 1;
        $reason    = !empty($leaveData['reason']) ? $leaveData['reason'] : 'Personal Leave';
        $leaveId   = !empty($leaveData['id']) ? (int)$leaveData['id'] : 0;

        $fromFmt = date('M d, Y', strtotime($from));
        $toFmt   = date('M d, Y', strtotime($to));
        $durationStr = ($from === $to) ? "$fromFmt ($days day)" : "$fromFmt to $toFmt ($days days)";

        $subject  = "[{$comp['short_name']} HR] New Leave Request: {$empName} ({$leaveType})";
        $headline = "New Leave Request Submitted";
        $badgeText = "Approval Required";
        $badgeColor = "#f59e0b";
        $greeting = "Dear <strong>" . htmlspecialchars($admin['name']) . "</strong>,";
        $primary = "Employee <strong>" . htmlspecialchars($empName) . "</strong> has submitted a new leave request and is awaiting your review.";

        $details = [
            'Employee Name' => htmlspecialchars($empName),
            'Leave Type'    => "<span style='color: #2563eb; font-weight: 700;'>" . htmlspecialchars($leaveType) . "</span>",
            'Duration'      => htmlspecialchars($durationStr),
            'Total Days'    => $days . ' day(s)',
            'Reason'        => htmlspecialchars($reason),
            'Submitted On'  => date('M d, Y h:i A')
        ];

        $html = self::build_creative_html_email(
            $headline,
            $badgeText,
            $badgeColor,
            $greeting,
            $primary,
            $details,
            "Review in Leave Requests",
            $comp['web'] . "/UxUi/Admin_user_dashboard.php#leave_requests"
        );

        $app_title = "New Leave Request: {$empName}";
        $app_body = "{$empName} requested {$days} day(s) {$leaveType} from {$from} to {$to}.";

        // Dispatch Email to Admin
        if (!empty($admin['email'])) {
            self::dispatch_direct_email($admin['email'], $subject, $html);
        }

        // Dispatch In-app notification
        self::dispatch_direct_app_notification('leave_request', $app_title, $app_body, 0, (int)$admin['user_id']);

        // System notification table
        if (class_exists('SystemNotifications')) {
            SystemNotifications::create($app_title, $app_body, 'leave_request', 'admin', 'Admin');
        }

        return true;
    }

    /**
     * Notify Employee when a Leave Request is Approved or Rejected
     */
    public static function notify_leave_status_changed($leaveId, $status = 'Approved', $adminComment = '') {
        $comp = self::get_company_data();
        $db = new DataBase();
        $conn = $db->get_data_base_connction();
        $leaveId = (int)$leaveId;

        $q = $conn->query("SELECT * FROM `leave_requests` WHERE `id` = '{$leaveId}' LIMIT 1");
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

        $staff = self::resolve_staff_contact_info($empName, $leave['employee_email'] ?? '');

        $fromFmt = date('M d, Y', strtotime($from));
        $toFmt   = date('M d, Y', strtotime($to));
        $durationStr = ($from === $to) ? "$fromFmt ($days day)" : "$fromFmt to $toFmt ($days days)";

        $isApproved = (strtolower($status) === 'approved');
        $badgeText  = $isApproved ? 'Approved' : 'Rejected';
        $badgeColor = $isApproved ? '#10b981' : '#ef4444';

        $subject  = $isApproved
            ? "[{$comp['short_name']} HR] Leave Request Approved: {$leaveType}"
            : "[{$comp['short_name']} HR] Leave Request Update: Rejected ({$leaveType})";
        $headline = "Leave Request " . ($isApproved ? "Approved" : "Rejected");
        $greeting = "Dear <strong>" . htmlspecialchars($staff['name']) . "</strong>,";
        $primary = $isApproved
            ? "Your request for <strong>" . htmlspecialchars($leaveType) . "</strong> has been <span style='color: #10b981; font-weight: 700;'>APPROVED</span> by management."
            : "Your request for <strong>" . htmlspecialchars($leaveType) . "</strong> has been <span style='color: #ef4444; font-weight: 700;'>NOT APPROVED</span> by management.";

        $details = [
            'Leave Type'     => htmlspecialchars($leaveType),
            'Duration'       => htmlspecialchars($durationStr),
            'Total Days'     => $days . ' day(s)',
            'Status'         => "<span style='color: {$badgeColor}; font-weight: 700; text-transform: uppercase;'>{$status}</span>",
            'Processed Date' => date('M d, Y h:i A')
        ];
        if (!empty($adminComment)) {
            $details['Admin Comment'] = htmlspecialchars($adminComment);
        }

        $html = self::build_creative_html_email(
            $headline,
            $badgeText,
            $badgeColor,
            $greeting,
            $primary,
            $details,
            "View in Employee Portal",
            $comp['web'] . "/UxUi/Employee_user_dashboard.php#leave"
        );

        $app_title = "Leave Request " . ($isApproved ? "Approved" : "Rejected");
        $app_body = "Your {$leaveType} request ({$durationStr}) has been {$status}." . (!empty($adminComment) ? " Note: {$adminComment}" : "");

        // Dispatch Email to Employee
        if (!empty($staff['email'])) {
            self::dispatch_direct_email($staff['email'], $subject, $html);
        }

        // Dispatch In-app notification
        self::dispatch_direct_app_notification('leave_' . strtolower($status), $app_title, $app_body, 0, (int)$staff['user_id']);

        // System notification table
        if (class_exists('SystemNotifications')) {
            SystemNotifications::create($app_title, $app_body, 'leave_' . strtolower($status), 'employee', $staff['name']);
        }

        return true;
    }

    /**
     * Notify Employee(s) when Admin requests a special document
     */
    public static function notify_document_requested(array $docData) {
        $comp = self::get_company_data();
        $targetType = !empty($docData['target_type']) ? strtolower(trim($docData['target_type'])) : 'employee';
        $targetEmp  = !empty($docData['target_employee_name']) ? trim($docData['target_employee_name']) : '';
        $targetUid  = !empty($docData['target_employee_user_id']) ? (int)$docData['target_employee_user_id'] : 0;
        $docType    = !empty($docData['doc_type']) ? trim($docData['doc_type']) : 'Required Document';
        $notes      = !empty($docData['notes']) ? trim($docData['notes']) : '';
        $deadline   = !empty($docData['deadline']) ? trim($docData['deadline']) : '';
        $adminName  = !empty($docData['requested_by']) ? trim($docData['requested_by']) : 'Management';

        $recipients = [];
        $db = new DataBase();
        $conn = $db->get_data_base_connction();

        if ($targetType === 'employee') {
            $staff = self::resolve_staff_contact_info($targetUid > 0 ? $targetUid : $targetEmp);
            if (!empty($staff['email'])) {
                $recipients[] = $staff;
            }
        } elseif ($targetType === 'department') {
            $deptEsc = mysqli_real_escape_string($conn, $targetEmp);
            $q = $conn->query("SELECT id, fullname, name, email_address, phone_number, user_id FROM `employees` WHERE `department` = '{$deptEsc}' AND `ast` = 1");
            if ($q) {
                while ($r = $q->fetch_assoc()) {
                    $em = !empty($r['email_address']) ? trim($r['email_address']) : '';
                    if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                        $recipients[] = [
                            'name'    => !empty($r['fullname']) ? $r['fullname'] : ($r['name'] ?? 'Team Member'),
                            'email'   => $em,
                            'phone'   => $r['phone_number'] ?? '',
                            'user_id' => (int)($r['user_id'] ?? 0)
                        ];
                    }
                }
            }
        } elseif ($targetType === 'all') {
            $q = $conn->query("SELECT id, fullname, name, email_address, phone_number, user_id FROM `employees` WHERE `ast` = 1");
            if ($q) {
                while ($r = $q->fetch_assoc()) {
                    $em = !empty($r['email_address']) ? trim($r['email_address']) : '';
                    if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                        $recipients[] = [
                            'name'    => !empty($r['fullname']) ? $r['fullname'] : ($r['name'] ?? 'Team Member'),
                            'email'   => $em,
                            'phone'   => $r['phone_number'] ?? '',
                            'user_id' => (int)($r['user_id'] ?? 0)
                        ];
                    }
                }
            }
        }

        $deadlineFmt = !empty($deadline) ? date('M d, Y', strtotime($deadline)) : 'As soon as possible';
        $subject  = "[{$comp['short_name']} HR] Document Request: {$docType}";
        $headline = "Action Required: Document Submission Requested";
        $badgeText = "Upload Required";
        $badgeColor = "#2563eb";

        $details = [
            'Document Requested' => "<span style='color: #2563eb; font-weight: 700;'>" . htmlspecialchars($docType) . "</span>",
            'Submission Deadline' => htmlspecialchars($deadlineFmt),
            'Requested By'       => htmlspecialchars($adminName)
        ];
        if (!empty($notes)) {
            $details['Instructions / Notes'] = htmlspecialchars($notes);
        }

        $app_title = "Document Requested: {$docType}";
        $app_body = "Please upload required document: {$docType}." . (!empty($notes) ? " Note: {$notes}." : "") . (!empty($deadline) ? " Due by {$deadline}." : "");

        foreach ($recipients as $rec) {
            $greeting = "Dear <strong>" . htmlspecialchars($rec['name']) . "</strong>,";
            $primary = "Management has requested that you upload a <strong>" . htmlspecialchars($docType) . "</strong> to your employee documents folder.";

            $html = self::build_creative_html_email(
                $headline,
                $badgeText,
                $badgeColor,
                $greeting,
                $primary,
                $details,
                "Upload Document Now",
                $comp['web'] . "/UxUi/Employee_user_dashboard.php#documents"
            );

            // Send direct email
            if (!empty($rec['email'])) {
                self::dispatch_direct_email($rec['email'], $subject, $html);
            }

            // Direct in-app
            self::dispatch_direct_app_notification('document_request', $app_title, $app_body, 0, (int)$rec['user_id']);

            // System notifications
            if (class_exists('SystemNotifications')) {
                SystemNotifications::create($app_title, $app_body, 'document_request', 'employee', $rec['name']);
            }
        }

        return true;
    }

    /**
     * Notify Admin when an employee submits Daily Work Plan or Shift Wrap-up
     */
    public static function notify_daily_plan_submitted(array $planData) {
        $comp = self::get_company_data();
        $admin = self::resolve_admin_contact_info();

        $empName  = !empty($planData['employee_name']) ? trim($planData['employee_name']) : 'Employee';
        $dept     = !empty($planData['department']) ? trim($planData['department']) : 'General';
        $jobTitle = !empty($planData['job_title']) ? trim($planData['job_title']) : 'Staff';
        $type     = !empty($planData['update_type']) ? $planData['update_type'] : 'morning_plan'; // 'morning_plan' or 'shift_end'
        $date     = !empty($planData['date']) ? $planData['date'] : date('Y-m-d');
        $dateFmt  = date('M d, Y', strtotime($date));

        if ($type === 'morning_plan') {
            $subject  = "[{$comp['short_name']} HR] Daily Work Plan: {$empName} ({$dateFmt})";
            $headline = "Daily Morning Work Plan Submitted";
            $badgeText = "Morning Plan";
            $badgeColor = "#2563eb";
            $greeting = "Dear <strong>" . htmlspecialchars($admin['name']) . "</strong>,";
            $primary = "Employee <strong>" . htmlspecialchars($empName) . "</strong> ({$jobTitle} &bull; {$dept}) has started work and submitted today's planned tasks.";

            $tasks = !empty($planData['tasks']) && is_array($planData['tasks']) ? $planData['tasks'] : [];
            $planText = !empty($planData['plan_text']) ? $planData['plan_text'] : '';

            $tasksListHtml = '';
            if (!empty($tasks)) {
                $tasksListHtml = "<ul style='margin: 4px 0; padding-left: 18px; text-align: left; font-size: 13px; color: #1e293b;'>";
                foreach ($tasks as $t) {
                    $item = is_array($t) ? ($t['title'] ?? '') : (string)$t;
                    if (trim($item) !== '') {
                        $tasksListHtml .= "<li style='margin-bottom: 4px;'>" . htmlspecialchars(trim($item)) . "</li>";
                    }
                }
                $tasksListHtml .= "</ul>";
            } else if (!empty($planText)) {
                $tasksListHtml = "<div style='text-align: left; font-size: 13px; color: #1e293b; white-space: pre-line;'>" . htmlspecialchars($planText) . "</div>";
            } else {
                $tasksListHtml = "<em>Standard daily operations</em>";
            }

            $details = [
                'Employee Name' => htmlspecialchars($empName),
                'Department'    => htmlspecialchars($dept),
                'Job Title'     => htmlspecialchars($jobTitle),
                'Plan Date'     => htmlspecialchars($dateFmt),
                'Planned Tasks' => $tasksListHtml
            ];

            $app_title = "Daily Plan: {$empName}";
            $app_body = "{$empName} ({$dept}) submitted daily work plan for {$dateFmt}.";
        } else {
            // Shift wrap-up
            $taskTitle  = !empty($planData['task_title']) ? $planData['task_title'] : 'Daily Tasks';
            $taskStatus = !empty($planData['task_status']) ? $planData['task_status'] : 'Completed';
            $evening    = !empty($planData['evening_update']) ? $planData['evening_update'] : 'Shift ended successfully.';

            $subject  = "[{$comp['short_name']} HR] Shift Wrap-up: {$empName} ({$dateFmt})";
            $headline = "Shift End Update & Task Status";
            $badgeText = "Shift Wrap-up";
            $badgeColor = "#10b981";
            $greeting = "Dear <strong>" . htmlspecialchars($admin['name']) . "</strong>,";
            $primary = "Employee <strong>" . htmlspecialchars($empName) . "</strong> has completed their shift and submitted their daily progress wrap-up.";

            $details = [
                'Employee Name' => htmlspecialchars($empName),
                'Department'    => htmlspecialchars($dept),
                'Task Summary'  => htmlspecialchars($taskTitle),
                'Task Status'   => "<span style='color: #10b981; font-weight: 700; text-transform: uppercase;'>" . htmlspecialchars($taskStatus) . "</span>",
                'Shift Summary' => "<div style='text-align: left; font-size: 13px; color: #1e293b; white-space: pre-line;'>" . htmlspecialchars($evening) . "</div>",
                'Date'          => htmlspecialchars($dateFmt)
            ];

            $app_title = "Shift End Update: {$empName}";
            $app_body = "{$empName} submitted shift wrap-up for '{$taskTitle}' [{$taskStatus}].";
        }

        $html = self::build_creative_html_email(
            $headline,
            $badgeText,
            $badgeColor,
            $greeting,
            $primary,
            $details,
            "View Daily Plans in Admin Portal",
            $comp['web'] . "/UxUi/Admin_user_dashboard.php#daily_plans"
        );

        // Dispatch Email to Admin
        if (!empty($admin['email'])) {
            self::dispatch_direct_email($admin['email'], $subject, $html);
        }

        // Dispatch In-app
        self::dispatch_direct_app_notification('daily_plan', $app_title, $app_body, 0, (int)$admin['user_id']);

        // System notifications table
        if (class_exists('SystemNotifications')) {
            SystemNotifications::create($app_title, $app_body, 'daily_plan', 'admin', 'Admin');
        }

        return true;
    }
}
