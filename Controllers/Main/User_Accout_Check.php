<?php

class User_Account_Check
{

    private $user_name;
    private $password;
    private $error = "";
    private $data_basic_obj;
    private $user_id;
    private $account_login_state = false;
    private $passworg_state = false;

    private $is_two_factor_auth_enable;

    private $phone_number;
    private $wrong_login_count;
    private $wrong_login_attempt = 0;
    private $temp_lock = 0;
    private $temp_lock_state = 0;
    private $account_temp_lock_state = false;

    private $session_token;
    private $email;

    public function __construct($user_name, $password)
    {
        $this->user_name = $user_name;

        $advance_security_check = new Advance_Security();
        $this->password = $advance_security_check->get_data_encrypt($this->user_name, $password);
    }

    public function check_user_name()
    {
        $this->account_login_state = false;

        $main_user_login_LIST_obj = new main_user_login_LIST();
        $main_user_login_LIST_obj->filter_by_ast(1);
        $main_user_login_LIST_obj->filter_by_user_name($this->user_name);


        $result = $main_user_login_LIST_obj->get_result();

        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $this->user_id = $row['id'];
                $this->wrong_login_count = $row['wrong_login_count'];
                $this->temp_lock = $row['temp_lock'];
            }

            $this->account_login_state = true;
        } else {
            $this->set_error_data("Username Incorrect");
            $this->account_login_state = false;
        }

        return $this->account_login_state;
    }

    public function check_temp_lock_state()
    {

        if ($this->temp_lock == "1") {
            $this->temp_lock_state = true;
        } else {
            $this->temp_lock_state = false;
        }

        return $this->temp_lock_state;
    }



    private function set_error_data($get_error)
    {
        $this->error = $get_error;
    }

    public function get_error()
    {
        return $this->error;
    }

    public function process_account_login()
    {
        return $this->account_login_state;
    }
    public function get_password_wrong_state()
    {
        return $this->passworg_state;
    }

    private $is_google_authentication_enable = 0;

    public function check_password()
    {
        $this->account_login_state = false;

        $main_user_login_LIST_obj = new main_user_login_LIST();
        $main_user_login_LIST_obj->filter_by_ast(1);
        $main_user_login_LIST_obj->filter_by_user_name($this->user_name);
        $main_user_login_LIST_obj->filter_by_password($this->password);
        $result = $main_user_login_LIST_obj->get_result();

        $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();
        $main_user_login_ADD_UPDATE_obj->set_id($this->user_id);


        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $this->user_id = $row['id'];
                $this->email = $row['user_name'];
                $this->is_google_authentication_enable = $row['is_google_authentication_enable'];
                $this->is_two_factor_auth_enable = $row['is_two_factor_auth_enable'];
                $this->phone_number = $row['phone_number'];


                $User_Accout_Check_Device_obj = new User_Accout_Check_Device();
                $User_Accout_Check_Device_obj->set_main_user_login_id($this->user_id);
                $User_Accout_Check_Device_obj->check_main_user_login_device();
                $this->session_token = $User_Accout_Check_Device_obj->get_session_token();
                if ($User_Accout_Check_Device_obj->get_config_main_user_login_device_state()) {
                } else {
                    echo " login device error ";
                }
                $this->account_login_state = true;
            }

            $this->passworg_state = false;
        } else {
            $this->wrong_login_count  = $this->wrong_login_count + 1;
            $this->wrong_login_attempt = true;
            $this->passworg_state = true;
            $this->check_account_lock_states();
            $this->set_error_data("Password Incorrect");
            $this->account_login_state = false;
        }

        return $this->account_login_state;
    }

    public function check_account_lock_states()
    {


        $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();
        $main_user_login_ADD_UPDATE_obj->set_id($this->user_id);

        if ($this->wrong_login_attempt) {

            if ($this->wrong_login_count >= 3) {
                $main_user_login_ADD_UPDATE_obj->is_temp_lock();
            } else {
                $this->account_temp_lock_state = true;
            }


            $main_user_login_ADD_UPDATE_obj->set_wrong_login_count($this->wrong_login_count);
        } else {
            $main_user_login_ADD_UPDATE_obj->set_wrong_login_count(0);
        };


        if ($main_user_login_ADD_UPDATE_obj->process_update()) {
            $this->wrong_login_attempt = false;
            $this->account_temp_lock_state = true;
        } else {
            $this->set_error_data("User Wrong Login Update Error");
        };


        return $this->account_temp_lock_state;
    }


    public function get_session_token()
    {
        return $this->session_token;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function get_user_name()
    {
        return $this->user_name;
    }

    public function get_is_two_factor_auth_enable()
    {
        return $this->is_two_factor_auth_enable;
    }

    public function get_phone_number()
    {
        return $this->phone_number;
    }


    public function get_google_authentication()
    {
        return $this->is_google_authentication_enable;
    }
}
