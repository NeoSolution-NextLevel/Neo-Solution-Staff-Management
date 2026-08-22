<?php



class Company_Info_Variable_List
{

    //-----------------------------------------------------------------------------------------------------------
    private $company_logo_icon = "/UxUi-Back/assets/neo_icon.svg";
    private $company_logo_url = "/UxUi-Back/assets/neo_solution_logo.svg";
    private $footer_txt = "NEO Solution (Pvt) Ltd | www.neosolution.lk | 0112263355 | info@neosolution.lk";
    private $company_name = "NEO Solution (Pvt) Ltd";
    private $company_web = "neosolution.lk";
    private $full_company_web = "http://localhost:3000/";
    private $default_sending_email = "info@neosolution.lk";
    private $system_problem_sending_email = "info@neosolution.lk";
    private $company_short_name = "NEO Solution";
    //-----------------------------------------------------------------------------------------------------------   
    private $company_whatup_number = "94773401876";
    private $whatusp_url_to_revice_message = "";
    private $sms_app_id = "a1pqSzBnVTZtjMHR4T1lDeHJoRVFvUT09"; //neo soluiton
    //    private $sms_app_id = "SE83YUw0RkNtU2ZnK1ZQNFNsL092dz09"; //shadow shine
    private $company_data_id = "1";
    private $company_phone_no = "0112263355";
    private $company_phone_no_02 = "0777892822";
    private $compnay_notification_mobile_no = "0777892822";
    private $key_for_email_and_sms_encription = "lkdfjakfjjjakljkljkljfaklj";
    private $branch_id = "1";
    private $default_currency = "USD";

    private $currency_type_country_name = "USA";
    //    ---------------------------------------
    private $address_line_01 = "No.30 New Arrival Djuty Free Complex(2nd floor),";
    private $address_line_02 = "Arrival Terminal";
    private $address_line_03 = "B.I.A Katunayake,";
    private $address_street = "";
    private $address_city = "";
    private $country_name = "Sri Lanka";
    private $payment_gateway_onepay_APP_ID = "QX6F1j18C1FA35F732B108";
    private $payment_gateway_onepay_App_Token = "b348j470e551b638fbd640551c03b1c88e82b79c85ac954c85c5734dc006969c75bca84b26797946a.R5EQ118C1FA35F732B145";
    private $payment_gateway_onepay_Hash_Salt = "MY9P1j18C1FA35F732B12F";
    //    private $payment_gateway_onepay_APP_ID = "";
    //    private $payment_gateway_onepay_App_Token = "";
    //    private $payment_gateway_onepay_Hash_Salt = "";

    private $payment_gateway_finance_email = "finanjce@neosolution.lk";
    private $API_data_neosolution_lk = "SytZd3ZycVRFjRWlOOGMydFdWMkNMZz09";
    private $app_URL = "https://www.NEO LOGINdutyfreje.lk/";
    private $finanace_admin_email_for_notification = "finjance@neosolution.lk";
    private $API_SEO_KEY = "d38ea6125fd05ccj31ed7d05b5c1a05d0";
    private $Propety_NO = "98000j2";

    //for NEO LOGIN only 
    private $shop_hotline_no_01 = "+94 11 226 3355";
    private $shop_hotline_no_02 = "+94 77 340 1876";
    private $office_mobile_no_01 = "+94 11 243 5386";
    private $office_mobile_no_02 = "+94 11 247 1909";
    private $after_sales_service_mobile_no = "+94 77 789 2822";

    private $sales_email = " sales@NEO LOGINdutyjhfree.lk";
    private $support_email = "support@NEO LOGINdhkjutjyfree.lk";

    private $google_authentication_client_id = "77492483276-jjdfdq48iil8gu6of5d05ulhglgdntn965.apps.googleusercontent.com";
    private $google_authentication_clent_secret_id = "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9d";

    private $microsoft_login_client_id = "ebd9ecc2-4fed-405jje-9j82c-270564df56f0";
    private $microsoft_login_client_secret_id = "5G18Q~8jjNwmaEh9bregS6T1qqYV0fMgYozYWAtccB";



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
    //    it@shadowshine.com.lk  
    public function get_compnay_logo_icon_url()
    {
        return $this->company_logo_icon;
    }


    public function get_support_email()
    {
        return $this->support_email;
    }

    public function get_sales_email()
    {
        return $this->sales_email;
    }


    public function get_API_data_neosolution_lk()
    {
        return $this->API_data_neosolution_lk;
    }

    public function get_payment_gateway_one_pay_App_ID()
    {
        return $this->payment_gateway_onepay_APP_ID;
    }

    public function get_payment_gateway_one_pay_App_Token()
    {
        return $this->payment_gateway_onepay_App_Token;
    }

    public function get_payment_gateway_one_pay_Hash_Salt()
    {
        return $this->payment_gateway_onepay_Hash_Salt;
    }

    public function get_payment_gateway_finance_email()
    {
        return $this->payment_gateway_finance_email;
    }

    public function get_address_line_01()
    {
        return $this->address_line_01;
    }

    public function get_address_line_02()
    {
        return $this->address_line_02;
    }

    public function get_address_line_03()
    {
        return $this->address_line_03;
    }

    public function get_address_street()
    {
        return $this->address_street;
    }

    public function get_address_city()
    {
        return $this->address_city;
    }

    public function get_default_currency()
    {
        // echo 'crrency';
        return $this->default_currency;
    }

    public function get_currency_type_country_name()
    {
        return $this->currency_type_country_name;
    }

    public function get_default_country_name()
    {
        return $this->country_name;
    }

    public function get_compnay_logo_url()
    {
        return $this->company_logo_url;
    }

    public function get_compnay_footer_txt()
    {
        return $this->footer_txt;
    }

    public function get_compnay_name()
    {
        return $this->company_name;
    }

    public function get_compnay_short_name()
    {
        return $this->company_short_name;
    }

    public function get_compnay_web()
    {
        return $this->company_web;
    }

    public function get_compnay_full_web()
    {
        return $this->full_company_web;
    }

    public function get_compnay_default_sending_email()
    {

        return $this->default_sending_email;
    }

    public function get_system_infom_email()
    {
        return $this->system_problem_sending_email;
    }

    public function get_SMS_APP_id()
    {
        return $this->sms_app_id;
    }

    public function get_whatsup_number()
    {
        return $this->company_whatup_number;
    }

    public function get_whatsup_recive_message_url()
    {
        return $this->whatusp_url_to_revice_message;
    }

    public function get_compnay_id()
    {
        return $this->company_data_id;
    }

    public function get_compnay_phone()
    {
        return $this->company_phone_no;
    }

    public function get_compnay_phone_02()
    {
        return $this->company_phone_no;
    }

    public function get_sms_notifiction_mobile_no()
    {
        return $this->compnay_notification_mobile_no;
    }

    public function get_email_sms_encryption_key()
    {
        return $this->key_for_email_and_sms_encription;
    }

    public function get_branch_id()
    {
        return $this->branch_id;
    }

    public function get_system_problem_sending_email()
    {
        return $this->system_problem_sending_email;
    }

    public function get_default_sending_email()
    {
        return $this->default_sending_email;
    }

    public function get_finanace_admin_emial()
    {
        return $this->finanace_admin_email_for_notification;
    }

    public function infom_error_for_developer($get_error_msg)
    {
        date_default_timezone_set('Indian/Chagos');
        $date_and_time = date('m/d/Y h:i:s a', time());
        $email_obj = new Email("support@neosolution.lk", "Error Message " . $date_and_time, getcwd() . "  ----  " . $get_error_msg);
        $email_obj->send_email();
    }

    private $url_fb = "";
    private $url_instagram = "";
    private $url_tiktok = "";
    private $url_x = "";
    private $url_linkin = "";

    public function get_url_fb()
    {
        return $this->url_fb;
    }

    public function get_url_intragram()
    {
        return $this->url_instagram;
    }

    public function get_url_tiktok()
    {
        return $this->url_tiktok;
    }

    public function get_url_x()
    {
        return $this->url_x;
    }

    public function get_url_linkin()
    {
        return $this->url_linkin;
    }

    public function get_app_URL()
    {
        return $this->app_URL;
    }



    //for NEO LOGIN duty free only  
    public function get_shop_hotline_no_01()
    {
        return $this->shop_hotline_no_01;
    }

    public function get_shop_hotline_no_02()
    {
        return $this->shop_hotline_no_02;
    }

    public function get_office_mobile_no_01()
    {
        return $this->office_mobile_no_01;
    }

    public function get_office_mobile_no_02()
    {
        return $this->office_mobile_no_02;
    }

    public function get_after_sales_service_mobile_no()
    {
        return $this->after_sales_service_mobile_no;
    }
    public function get_API_SEO_KEY()
    {
        return $this->API_SEO_KEY;
    }
    public function get_Propety_NO()
    {
        return $this->Propety_NO;
    }
}