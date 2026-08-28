<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../database.php')) {
        include_once __DIR__ . '/../../database.php';
    }
}

class User_Account_Check_Device
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        }
    }

    public function get_browser_name()
    {
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (stripos($agent, 'Firefox') !== false) {
            return 'Mozilla Firefox';
        } elseif (stripos($agent, 'Edg') !== false) {
            return 'Microsoft Edge';
        } elseif (stripos($agent, 'Chrome') !== false) {
            return 'Google Chrome';
        } elseif (stripos($agent, 'Safari') !== false) {
            return 'Apple Safari';
        } elseif (stripos($agent, 'Opera') !== false || stripos($agent, 'OPR') !== false) {
            return 'Opera';
        }
        return 'Unknown Browser';
    }

    public function get_os_name()
    {
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (stripos($agent, 'Windows') !== false) {
            return 'Windows';
        } elseif (stripos($agent, 'Macintosh') !== false || stripos($agent, 'Mac OS') !== false) {
            return 'Mac OS';
        } elseif (stripos($agent, 'Android') !== false) {
            return 'Android';
        } elseif (stripos($agent, 'iPhone') !== false || stripos($agent, 'iPad') !== false) {
            return 'iOS';
        } elseif (stripos($agent, 'Linux') !== false) {
            return 'Linux';
        }
        return 'Unknown OS';
    }

    public function get_device_type()
    {
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (stripos($agent, 'Mobile') !== false || stripos($agent, 'Android') !== false || stripos($agent, 'iPhone') !== false) {
            return 'Mobile';
        } elseif (stripos($agent, 'Tablet') !== false || stripos($agent, 'iPad') !== false) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    public function register_device($user_id, $session_token)
    {
        $ip = addslashes($this->get_client_ip());
        $browser = addslashes($this->get_browser_name());
        $os = addslashes($this->get_os_name());
        $device_type = addslashes($this->get_device_type());
        $token = addslashes($session_token);
        $user_id = (int)$user_id;
        $location = 'Local';

        // Check if device record exists for this user and IP/Browser
        $check_sql = "SELECT id FROM `main_user_login_device` WHERE `main_user_login_id` = '{$user_id}' AND `ip_address` = '{$ip}' AND `browser` = '{$browser}' LIMIT 1";
        $check_res = $this->db->get_result($check_sql);

        if ($check_res && $check_res->num_rows > 0) {
            $row = $check_res->fetch_assoc();
            $device_id = (int)$row['id'];
            $update_sql = "UPDATE `main_user_login_device` 
                SET `session_token` = '{$token}', 
                    `is_active` = 1, 
                    `last_activity` = NOW(), 
                    `login_time` = NOW(),
                    `ast` = 1 
                WHERE `id` = '{$device_id}'";
            $this->db->get_result($update_sql);
            return $device_id;
        } else {
            $insert_sql = "INSERT INTO `main_user_login_device` 
                (`ast`, `sdt`, `device_type`, `browser`, `os`, `ip_address`, `last_activity`, `login_time`, `is_active`, `main_user_login_id`, `session_token`, `location`)
                VALUES 
                (1, NOW(), '{$device_type}', '{$browser}', '{$os}', '{$ip}', NOW(), NOW(), 1, '{$user_id}', '{$token}', '{$location}')";
            $this->db->get_result($insert_sql);
            return $this->db->get_id();
        }
    }
}

// Backward compatibility alias
if (!class_exists('User_Accout_Check_Device')) {
    class User_Accout_Check_Device extends User_Account_Check_Device {}
}
?>
