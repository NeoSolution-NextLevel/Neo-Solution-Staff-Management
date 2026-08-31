<?php


class Company_Info_Variable_List {

//-----------------------------------------------------------------------------------------------------------
    private $company_logo_icon = "https://www.neosolution.lk/assets/finalLogo_02.png";
    private $company_logo_url = "https://www.neosolution.lk/assets/finalLogo_02.png";
    private $footer_txt = "Neo Solution | www.neosolution.lk | +94(0) 11 77 108 77 | hullo@neosolution.lk";
    private $company_name = "Neo Solution";
    private $company_web = "neosolution.lk";
    private $full_company_web = "https://www.neosolution.lk";
    private $default_sending_email = "admin@neosolution.lk";
    private $system_problem_sending_email = "admin@neosolution.lk";
    private $company_short_name = "Neo Solution";
//-----------------------------------------------------------------------------------------------------------   
    private $company_whatup_number = "";
    private $whatusp_url_to_revice_message = "";
    private $sms_app_id = "a1pqSzBnVTZtMHR4T1lDeHJoRVFvUT09"; //neo soluiton

    private $company_data_id = "1";
    private $company_phone_no = "0117710877";
    private $company_phone_no_02 = "";
    private $compnay_notification_mobile_no = "0770384444";
    private $key_for_email_and_sms_encription = "lkdfjakfjakljkljkljfaklj";
    private $branch_id = "1";
    private $default_currency = "LKR";
//    ---------------------------------------
    private $address_line_01 = "No 16, Station Road";
    private $address_line_02 = "Bambalapitiya";
    private $address_line_03 = "Colombo 04";
    private $address_street = "";
    private $address_city = "Sri Lanka";
    private $payment_gateway_onepay_APP_ID = "QYML118A029A051BB1BAF";
    private $payment_gateway_onepay_App_Token = "0fb01d7cd9852c8be0bed02701f08c4ba2eb7162c36f3d294823c94de130649daba462536b20dfcd.A0WU118C0215D5198CAB3";
    private $payment_gateway_onepay_Hash_Salt = "3UEC118A029A051BB1BDD";
    private $API_SEO_KEY = "bdd295eefda5f217196b571ec2984321_000fdslh";
    private $Propety_NO = "980014";

    private $google_authentication_client_id = "77492483276-jjdfdq48iil8gu6of5d05ulhglgdntn965.apps.googleusercontent.com";
    private $google_authentication_clent_secret_id = "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9d";

    private $microsoft_login_client_id = "ebd9ecc2-4fed-405jje-9j82c-270564df56f0";
    private $microsoft_login_client_secret_id = "5G18Q~8jjNwmaEh9bregS6T1qqYV0fMgYozYWAtccB";

    private $payment_gateway_finance_email = "finance@neosolution.lk";
    private $API_data_neosolution_lk = "SytZd3ZycVRFRWlOOGMydFdWMkNMZz09";
    private $app_URL = "https://www.neosolution.lk/";
    private $finanace_admin_email_for_notification = "finance@neosolution.lk";

  public function get_API_SEO_KEY()
    {
        return $this->API_SEO_KEY;
    }
    public function get_Propety_NO()
    {
        return $this->Propety_NO;
    }
    public function get_API_data_neosolution_lk() {
        return $this->API_data_neosolution_lk;
    }

    public function get_payment_gateway_one_pay_App_ID() {
        return $this->payment_gateway_onepay_APP_ID;
    }

    public function get_payment_gateway_one_pay_App_Token() {
        return $this->payment_gateway_onepay_App_Token;
    }

    public function get_payment_gateway_one_pay_Hash_Salt() {
        return $this->payment_gateway_onepay_Hash_Salt;
    }

    public function get_payment_gateway_finance_email() {
        return $this->payment_gateway_finance_email;
    }

     public function get_microsoft_login_client_id()
    {
        return $this->microsoft_login_client_id;
    }




    public function get_microsoft_login_client_secret_id()
    {
        return $this->microsoft_login_client_secret_id;
    }


        public function get_google_authentication_client_id()
    {
        return $this->google_authentication_client_id;
    }

     public function get_google_authentication_clent_secret_id()
    {
        return $this->google_authentication_clent_secret_id;
    }

    public function get_address_line_01() {
        return $this->address_line_01;
    }

    public function get_address_line_02() {
        return $this->address_line_02;
    }

    public function get_address_line_03() {
        return $this->address_line_03;
    }

    public function get_address_street() {
        return $this->address_street;
    }

    public function get_address_city() {
        return $this->address_city;
    }

    public function get_default_currency() {
        return $this->default_currency;
    }

    

    public function get_compnay_logo_icon_url() {
        return $this->company_logo_icon;
    }

    public function get_compnay_logo_url() {
        return $this->company_logo_url;
    }

    public function get_compnay_footer_txt() {
        return $this->footer_txt;
    }

    public function get_compnay_name() {
        return $this->company_name;
    }

    public function get_compnay_short_name() {
        return $this->company_short_name;
    }

    public function get_compnay_web() {
        return $this->company_web;
    }

    public function get_compnay_full_web() {
        return $this->full_company_web;
    }

    public function get_compnay_default_sending_email() {

        return $this->default_sending_email;
    }

    public function get_system_infom_email() {
        return $this->system_problem_sending_email;
    }

    public function get_SMS_APP_id() {
        return $this->sms_app_id;
    }

    public function get_whatsup_number() {
        return $this->company_whatup_number;
    }

    public function get_whatsup_recive_message_url() {
        return $this->whatusp_url_to_revice_message;
    }

    public function get_compnay_id() {
        return $this->company_data_id;
    }

    public function get_compnay_phone() {
        return $this->company_phone_no;
    }

    public function get_compnay_phone_02() {
        return $this->company_phone_no;
    }

    public function get_sms_notifiction_mobile_no() {
        return $this->compnay_notification_mobile_no;
    }

    public function get_email_sms_encryption_key() {
        return $this->key_for_email_and_sms_encription;
    }

    public function get_branch_id() {
        return $this->branch_id;
    }

    public function get_system_problem_sending_email() {
        return $this->system_problem_sending_email;
    }

    public function get_default_sending_email() {
        return $this->default_sending_email;
    }

    public function get_finanace_admin_emial() {
        return $this->finanace_admin_email_for_notification;
    }

    public function infom_error_for_developer($get_error_msg) {
        date_default_timezone_set('Indian/Chagos');
        $date_and_time = date('m/d/Y h:i:s a', time());
        $email_obj = new Email("nethminirathuge4@gmail.com", "Error Message " . $date_and_time, getcwd() . "  ----  " . $get_error_msg);
        $email_obj->send_email();
    }

    private $url_fb = "https://web.facebook.com/BusinessNextLevelNeoSolution";
    private $url_instagram = "https://www.instagram.com/neooopz/";
    private $url_tiktok = "https://www.tiktok.com/@neooopz";
    private $url_x = "https://twitter.com/YourUsername";
    private $url_linkin = "https://www.linkedin.com/company/neo-solution-it-solution/";

    public function get_url_fb() {
        return $this->url_fb;
    }

    public function get_url_intragram() {
        return $this->url_instagram;
    }

    public function get_url_tiktok() {
        return $this->url_tiktok;
    }

    public function get_url_x() {
        return $this->url_x;
    }

    public function get_url_linkin() {
        return $this->url_linkin;
    }

    public function get_app_URL() {
        return $this->app_URL;
    }

  
}
