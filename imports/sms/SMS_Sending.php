<?php

class SMS_Sending
{

    private $get_phone_no;
    private $message;
    private $sms_app_id;

    public function __construct($get_phone_no, $get_message)
    {
        $this->get_phone_no = $get_phone_no;
        $this->message = str_replace(' ', '%20', $get_message);

        $company_obj = new Company_Info_Variable_List();
        $this->sms_app_id = $company_obj->get_SMS_APP_id();
    }

    public function send_message()
    {
        //echo "Sending sms to: " . $this->get_phone_no;
        $url = "https://sms.neosolution.lk/NEO-SMS-API/SMS-API.php?app_id=" . $this->sms_app_id . "&phone_no=" . $this->get_phone_no . "&msg=" . $this->message . "";
        $url_encode = urlencode($url);
        $response_clint = curl_init($url);
        curl_setopt($response_clint, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($response_clint);
        return $response;
    }
}
