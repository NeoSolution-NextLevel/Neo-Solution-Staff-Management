<?php

class SMS_Sending
{
    private $get_phone_no;
    private $message;
    private $sms_app_id;
    private $last_response;
    private $last_http_code;

    public function __construct($get_phone_no, $get_message)
    {
        $this->get_phone_no = trim($get_phone_no);
        $this->message = $get_message;

        $company_obj = new Company_Info_Variable_List();
        $this->sms_app_id = $company_obj->get_SMS_APP_id();
    }

    public function send_message()
    {
        if (empty($this->get_phone_no) || empty($this->message)) {
            return false;
        }

        // Normalize phone number (handle Sri Lankan formats +947..., 947..., 07...)
        $phone = preg_replace('/[^\d+]/', '', $this->get_phone_no);
        $clean_phone = $phone;
        if (substr($clean_phone, 0, 3) === '+94') {
            $clean_phone = '0' . substr($clean_phone, 3);
        } elseif (substr($clean_phone, 0, 2) === '94') {
            $clean_phone = '0' . substr($clean_phone, 2);
        }

        // Primary modern endpoint: https://sms.neosolution.lk/api/send_sms.php (POST)
        $url = "https://sms.neosolution.lk/api/send_sms.php";
        $postData = [
            'app_id'    => $this->sms_app_id,
            'recipient' => $clean_phone,
            'message'   => $this->message
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->last_response = $response;
        $this->last_http_code = $http_code;

        // If 200 OK, return response
        if ($http_code === 200) {
            return $response;
        }

        // Fallback: try raw phone format (e.g. 947... or original)
        if ($clean_phone !== $phone) {
            $ch = curl_init($url);
            $postData['recipient'] = $phone;
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $this->last_response = $response;
            $this->last_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($this->last_http_code === 200) {
                return $response;
            }
        }

        return $response;
    }

    public function get_last_response()
    {
        return $this->last_response;
    }

    public function get_last_http_code()
    {
        return $this->last_http_code;
    }
}
