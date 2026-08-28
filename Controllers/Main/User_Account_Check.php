<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../database.php')) {
        include_once __DIR__ . '/../../database.php';
    }
}
if (!class_exists('Advance_Security')) {
    if (file_exists(__DIR__ . '/../../imports/security/encrypt_decrypt.php')) {
        include_once __DIR__ . '/../../imports/security/encrypt_decrypt.php';
    }
}
if (!class_exists('User_Account_Check_Device')) {
    include_once __DIR__ . '/User_Account_Check_Device.php';
}

class User_Account_Check
{
    private $input_user_name;
    private $input_password;

    private $id = 0;
    private $user_name = "";
    private $password_db = "";
    private $account_active_state = 0;
    private $ast = 1;
    private $name_show = "";
    private $temp_lock = 0;
    private $full_block = 0;
    private $ac_type = "";
    private $main_user_account_access_level_list_id = 1;
    private $company_id = 1;
    private $google_authentication_secret = "";
    private $is_google_authentication_enable = 0;
    private $is_two_factor_auth_enable = 0;
    private $phone_number = "";
    private $wrong_login_count = 0;
    private $session_token = "";

    private $error = "";
    private $user_found = false;

    public function __construct($user_name, $password)
    {
        $this->input_user_name = trim($user_name);
        $this->input_password  = trim($password);
    }

    public function check_user_name()
    {
        if (empty($this->input_user_name)) {
            $this->error = "Username/Email is required.";
            return false;
        }

        $db = new DataBase();
        $safe_user = addslashes($this->input_user_name);
        $sql = "SELECT * FROM `main_user_login` WHERE `user_name` = '{$safe_user}' AND (`ast` = 1 OR `ast` = '1' OR `ast` IS NULL) LIMIT 1";
        $res = $db->get_result($sql);

        if (!$res || $res->num_rows === 0) {
            $this->error = "Account not found.";
            $this->user_found = false;
            return false;
        }

        $row = $res->fetch_assoc();
        $this->user_found = true;

        $this->id                                      = (int)$row['id'];
        $this->user_name                               = $row['user_name'];
        $this->password_db                             = $row['password'];
        $this->account_active_state                   = (int)$row['account_active_state'];
        $this->ast                                     = $row['ast'];
        $this->name_show                               = $row['name_show'];
        $this->temp_lock                               = (int)$row['temp_lock'];
        $this->full_block                              = (int)$row['full_block'];
        $this->ac_type                                 = !empty($row['ac_type']) ? $row['ac_type'] : 'Admin';
        $this->main_user_account_access_level_list_id  = isset($row['main_user_account_access_level_list_id']) ? (int)$row['main_user_account_access_level_list_id'] : 1;
        $this->company_id                              = isset($row['company_id']) ? (int)$row['company_id'] : 1;
        $this->google_authentication_secret            = isset($row['google_authentication_secret']) ? $row['google_authentication_secret'] : '';
        $this->is_google_authentication_enable         = isset($row['is_google_authentication_enable']) ? (int)$row['is_google_authentication_enable'] : 0;
        $this->is_two_factor_auth_enable               = isset($row['is_two_factor_auth_enable']) ? (int)$row['is_two_factor_auth_enable'] : 0;
        $this->phone_number                            = isset($row['phone_number']) ? $row['phone_number'] : '';
        $this->wrong_login_count                       = isset($row['wrong_login_count']) ? (int)$row['wrong_login_count'] : 0;

        if ($this->full_block === 1) {
            $this->error = "Your account has been permanently blocked. Please contact administrator.";
            return false;
        }

        if ($this->account_active_state !== 1) {
            $this->error = "Account is currently inactive.";
            return false;
        }

        return true;
    }

    public function check_temp_lock_state()
    {
        return ($this->temp_lock === 1);
    }

    public function check_password()
    {
        if (!$this->user_found) {
            $this->error = "User not found.";
            return false;
        }

        $pw_matched = false;

        // 1. Check direct match or decryptPass / encryptPass
        if ($this->password_db === $this->input_password) {
            $pw_matched = true;
        } elseif (function_exists('encryptPass') && $this->password_db === encryptPass($this->input_password)) {
            $pw_matched = true;
        } elseif (function_exists('decryptPass') && decryptPass($this->password_db) === $this->input_password) {
            $pw_matched = true;
        } elseif (class_exists('Advance_Security')) {
            $adv = new Advance_Security();
            if ($adv->get_data_decrypt($this->user_name, $this->password_db) === $this->input_password) {
                $pw_matched = true;
            } elseif ($adv->get_data_encrypt($this->user_name, $this->input_password) === $this->password_db) {
                $pw_matched = true;
            }
        }

        // 2. Check standard password_verify fallback
        if (!$pw_matched && (password_verify($this->input_password, $this->password_db) || md5($this->input_password) === $this->password_db || sha1($this->input_password) === $this->password_db)) {
            $pw_matched = true;
        }

        $db = new DataBase();

        if ($pw_matched) {
            // Reset wrong login count & update last_login
            $db->get_result("UPDATE `main_user_login` SET `wrong_login_count` = 0, `last_login` = NOW() WHERE `id` = '{$this->id}'");

            // Generate session token and register device
            $this->session_token = bin2hex(random_bytes(24));
            $device_handler = new User_Account_Check_Device();
            $device_handler->register_device($this->id, $this->session_token);

            return true;
        } else {
            $new_wrong_count = $this->wrong_login_count + 1;
            $lock_sql = "";
            if ($new_wrong_count >= 5) {
                $lock_sql = ", `temp_lock` = 1";
            }
            $db->get_result("UPDATE `main_user_login` SET `wrong_login_count` = '{$new_wrong_count}' {$lock_sql} WHERE `id` = '{$this->id}'");

            $this->error = "Invalid password.";
            return false;
        }
    }

    public function get_session_token()
    {
        return $this->session_token;
    }

    public function get_ac_type()
    {
        return $this->ac_type;
    }

    public function get_main_user_account_access_level_list_id()
    {
        return $this->main_user_account_access_level_list_id;
    }

    public function get_user_id()
    {
        return $this->id;
    }

    public function get_user_name()
    {
        return $this->user_name;
    }

    public function get_name_show()
    {
        return $this->name_show;
    }

    public function get_google_authentication()
    {
        return ($this->is_google_authentication_enable === 1);
    }

    public function get_is_two_factor_auth_enable()
    {
        return $this->is_two_factor_auth_enable;
    }

    public function get_phone_number()
    {
        return $this->phone_number;
    }

    public function get_error()
    {
        return $this->error;
    }
}

// Backward compatibility alias
if (!class_exists('User_Accout_Check')) {
    class User_Accout_Check extends User_Account_Check {}
}
?>
