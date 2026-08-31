<?php

class User_Accout_Check_Device
{
    private $main_user_login_id;

    private $main_user_login_device_id;


    private $ip_address;
    private $os;
    private $browser;
    private $device_type;
    private $session_token;

    private $last_activity;
    private $location;

    private $is_main_user_login_device_status = false;
    private $config_main_user_login_device_state = false;

    public function __construct()
    {
        $this->last_activity = date('Y-m-d H:i:s');
    }

    public function get_session_token()
    {
        return $this->session_token;
    }

    private function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    function get_main_user_login_device_IP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    private function detectOS($ua)
    {
        if (preg_match('/Windows NT 10/i', $ua)) return 'Windows 10';
        if (preg_match('/Windows NT 6.1/i', $ua)) return 'Windows 7';
        if (preg_match('/Android/i', $ua)) return 'Android';
        if (preg_match('/iPhone|iPad/i', $ua)) return 'iOS';
        if (preg_match('/Mac OS X/i', $ua)) return 'macOS';
        if (preg_match('/Linux/i', $ua)) return 'Linux';

        return 'Unknown OS';
    }

    private function detectBrowser($ua)
    {
        if (strpos($ua, 'Edg') !== false) return 'Edge';
        if (strpos($ua, 'Chrome') !== false) return 'Chrome';
        if (strpos($ua, 'Firefox') !== false) return 'Firefox';
        if (strpos($ua, 'Safari') !== false) return 'Safari';
        if (strpos($ua, 'OPR') !== false) return 'Opera';

        return 'Unknown Browser';
    }

    private function detectDeviceType($ua)
    {
        if (preg_match('/tablet|ipad/i', $ua)) {
            return 'Tablet';
        }

        if (preg_match('/mobile|android|iphone/i', $ua)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    private function detectLocationByIP($ip)
    {
        if ($ip === "127.0.0.1" || $ip === "::1") {
            return "Localhost";
        }

        $url = "http://ip-api.com/json/" . $ip;
        $response = @file_get_contents($url);

        if ($response === false) {
            return "Unknown Location";
        }

        $data = json_decode($response, true);

        if (!isset($data['status']) || $data['status'] !== 'success') {
            return "Unknown Location";
        }

        $city = $data['city'] ?? '';
        $country = $data['country'] ?? '';

        return trim($city . ", " . $country, ", ");
    }


    private function generateSessionToken()
    {
        return bin2hex(random_bytes(32));
    }

    public function set_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = $get_main_user_login_id;
    }

    public function get_main_user_login_device_details()
    {
        $ua = $this->getUserAgent();

        $this->ip_address   = $this->get_main_user_login_device_IP();
        $this->os           = $this->detectOS($ua);
        $this->browser      = $this->detectBrowser($ua);
        $this->device_type  = $this->detectDeviceType($ua);
        $this->session_token = $this->generateSessionToken();
        $this->location = $this->detectLocationByIP($this->ip_address);
    }
    public function check_main_user_login_device()
    {
        //get user login device
        $this->get_main_user_login_device_details();

        $this->is_main_user_login_device_status = false;

        $main_user_login_device_LIST_obj = new main_user_login_device_LIST();

        $main_user_login_device_LIST_obj->filter_by_ast();
        $main_user_login_device_LIST_obj->filter_by_main_user_login_id($this->main_user_login_id);
        $main_user_login_device_LIST_obj->filter_by_browser($this->browser);
        $main_user_login_device_LIST_obj->filter_by_os($this->os);
        $main_user_login_device_LIST_obj->filter_by_ip_address($this->ip_address);

        $result = $main_user_login_device_LIST_obj->get_result();

        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $this->main_user_login_device_id = $row['id'];

                $this->is_main_user_login_device_status = true;
            }
        }

        $this->config_main_user_login_device();
    }




    public function config_main_user_login_device()
    {

        $this->config_main_user_login_device_state = false;

        $this->deactivate_other_devices();

        $main_user_login_device_ADD_UPDATE_obj = new main_user_login_device_ADD_UPDATE();
        if ($this->is_main_user_login_device_status) {

            $main_user_login_device_ADD_UPDATE_obj->set_id($this->main_user_login_device_id);
            $main_user_login_device_ADD_UPDATE_obj->set_session_token($this->session_token);
            $main_user_login_device_ADD_UPDATE_obj->set_last_activity($this->last_activity);
            $main_user_login_device_ADD_UPDATE_obj->is_is_active();

            if ($main_user_login_device_ADD_UPDATE_obj->process_update()) {
                $this->config_main_user_login_device_state = true;


                return true;
            } else {
                return false;
            }
        } else {

            $main_user_login_device_ADD_UPDATE_obj->set_data($this->device_type, $this->browser, $this->os, $this->ip_address, $this->last_activity, date('Y-m-d H:i:s'), $this->main_user_login_id, $this->session_token, $this->location);
            $main_user_login_device_ADD_UPDATE_obj->is_is_active();
            if ($main_user_login_device_ADD_UPDATE_obj->process_new_record()) {
                $this->config_main_user_login_device_state = true;

                return true;
            } else {
                return false;
            }
        }
    }

    public function deactivate_other_devices()
    {
        $data_base_obj = new Database();


        $get_sql_query = "
        UPDATE main_user_login_device
        SET is_active = 0
        WHERE main_user_login_id = '" . $this->main_user_login_id . "'
    ";
        $data_base_obj->get_result($get_sql_query);
        return $data_base_obj->get_error_state_boolean();
    }


    public function get_config_main_user_login_device_state()
    {
        return $this->config_main_user_login_device_state;
    }
}
