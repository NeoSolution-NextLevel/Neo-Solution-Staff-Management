<?php

class Send_API_URL_Data
{
    private $API_KEY;
    private $Propety_ID;
    private $advance_key;
    private $url_data;
    private $compnay_obj;
    private $site_map_priority;
    private $stie_map_avbl = "0";
    private $error_mssage;
    private $state_of_API_send = true;
    private $sec_Propery_ID;
    private $Advance_Security_Key_List_obj;
    private $Advance_Security_obj;


    public function __construct()
    {
        $this->compnay_obj = new Company_Info_Variable_List();
        $this->API_KEY = $this->compnay_obj->get_API_SEO_KEY();
        $this->Propety_ID = $this->compnay_obj->get_Propety_NO();


        $this->Advance_Security_Key_List_obj = new Advance_Security_Key_List();
        $this->Advance_Security_obj = new Advance_Security();
        $this->sec_Propery_ID = $this->Advance_Security_obj->get_data_encrypt($this->API_KEY, $this->Propety_ID);
        $this->advance_key = $this->API_KEY . $this->Propety_ID;
    }


    public function set_url_data($get_url_data)
    {
        $this->url_data = $this->Advance_Security_obj->get_data_encrypt($this->advance_key, $get_url_data);
        // $this->url_data = $get_url_data;
    }
    public function is_Site_Map($get_priority)
    {
        $this->site_map_priority = $get_priority;
        $this->stie_map_avbl = "1";
    }
    public function is_Not_Site_Map()
    {
        $this->stie_map_avbl = "0";
    }

    public function send_url_data_to_data_center()
    {
        // echo 'state-01<br>';
        $target_url = "https://seo-tool.neosolution.lk/Controller/API/Operations-API/Recive-URL-Infomation-API.php";

        $post_data = array(
            'url'                => $this->url_data,
            'site_map'           => $this->stie_map_avbl,
            'site_map_priority'  => $this->site_map_priority,
            'api_key'            => $this->API_KEY,
            'property_id'        => $this->Propety_ID

        );
        $ch = curl_init();

        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // Convert the data array into a standard URL-encoded string for POST body
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        // Tell cURL to return the response as a string instead of outputting it directly
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Optional: Set a timeout (e.g., 10 seconds)
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // Optional: For HTTPS connections, you may need to disable peer verification 
        // if you run into certificate issues, though it's generally recommended to keep it enabled.
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        // Execute the request
        $response = curl_exec($ch);
        // echo $response;

        // Check for cURL errors
        if (curl_errno($ch)) {
            // An error occurred during the transfer (e.g., connection timeout, DNS failure)

            $error_message = curl_error($ch);
            // echo 'errr 01' . $error_message."<br>";
            $state_of_API_send = false;
            $this->error_mssage = "Error sending data. Check system logs for details.";
        } else {
            // The request was sent. Now check the HTTP status code.
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($http_code == 200) {
                $this->state_of_API_send = true;
                // echo 'errr 03'."<br>";;
            } else {
                $this->state_of_API_send = false;
                // echo 'errr 02'."<br>";;
                $this->error_mssage = "Error sending data. Check system logs for details.";
            }
        }
    }
}
