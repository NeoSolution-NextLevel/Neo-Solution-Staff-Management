<?php
class main_user_login_SINGLE_DATA
{
    private $id;
    private $user_name;
    private $password;
    private $account_active_state;
    private $ast = "1";
    private $sdt;
    private $last_login;
    private $name_show;
    private $email_verify;
    private $moible_verfiy;
    private $very_first_login;
    private $cook_key;
    private $ref_key;
    private $temp_lock;
    private $full_block;
    private $ac_type;
    private $company_id;
    private $control_account_state;

    private $image_url;

    private $google_id;
    private $google_authentication_secret;

    private $microsoft_id;
    private $first_name;
    private $last_name;
    private $dis;
    private $phone_number;
    private $is_google_authentication_enable = 0;
    private $is_two_factor_auth_enable = 0;
    private $main_user_account_access_level_list_id;

    private $wrong_login_count;


    private $state_of_data = false;


    public function __construct($id)
    {
        $this->id = $id;


        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM main_user_login WHERE id = '" . $this->id . "'";

        // echo $get_sql_query . "<br>";

        $result = $data_base_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id                       = $row['id'];
                $this->user_name                = $row['user_name'];
                $this->password                 = $row['password'];
                $this->account_active_state     = $row['account_active_state'];
                $this->ast                      = $row['ast'];
                $this->sdt                      = $row['sdt'];
                $this->last_login               = $row['last_login'];
                $this->name_show                = $row['name_show'];
                $this->email_verify             = $row['email_verify'];
                $this->moible_verfiy            = $row['moible_verfiy'];
                $this->very_first_login         = $row['very_first_login'];
                $this->cook_key                 = $row['cook_key'];
                $this->ref_key                  = $row['ref_key'];
                $this->temp_lock                = $row['temp_lock'];
                $this->full_block               = $row['full_block'];
                $this->ac_type                  = $row['ac_type'];
                $this->company_id               = $row['company_id'];
                $this->control_account_state    = $row['control_account_state'];
                $this->image_url    = $row['image_url'];
                $this->google_id    = $row['google_id'];
                $this->google_authentication_secret    = $row['google_authentication_secret'];
                $this->microsoft_id    = $row['microsoft_id'];
                $this->is_google_authentication_enable    = $row['is_google_authentication_enable'];
                $this->first_name    = $row['first_name'];
                $this->last_name    = $row['last_name'];
                $this->dis    = $row['dis'];
                $this->phone_number    = $row['phone_number'];
                $this->main_user_account_access_level_list_id    = $row['main_user_account_access_level_list_id'];
                $this->is_two_factor_auth_enable    = $row['is_two_factor_auth_enable'];
                $this->wrong_login_count    = $row['wrong_login_count'];
            }
        }
    }

    // --- Getter functions ---

    public function get_image_url()
    {
        return $this->image_url;
    }
    public function get_wrong_login_count()
    {
        return $this->wrong_login_count;
    }


    public function get_google_id()
    {
        return $this->google_id;
    }

    public function get_google_authentication_secret()
    {
        return $this->google_authentication_secret;
    }

    public function get_microsoft_id()
    {
        return $this->microsoft_id;
    }
    public function get_is_two_factor_auth_enable()
    {
        return $this->is_two_factor_auth_enable;
    }


    public function get_is_google_authentication_enable()
    {
        return $this->is_google_authentication_enable;
    }

    public function get_first_name()
    {
        return $this->first_name;
    }

    public function get_last_name()
    {
        return $this->last_name;
    }

    public function get_dis()
    {
        return $this->dis;
    }

    public function get_phone_number()
    {
        return $this->phone_number;
    }


    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_user_name()
    {
        return $this->user_name;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function get_account_active_state()
    {
        return $this->account_active_state;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_last_login()
    {
        return $this->last_login;
    }

    public function get_name_show()
    {
        return $this->name_show;
    }

    public function get_email_verify()
    {
        return $this->email_verify;
    }

    public function get_moible_verfiy()
    {
        return $this->moible_verfiy;
    }

    public function get_very_first_login()
    {
        return $this->very_first_login;
    }

    public function get_cook_key()
    {
        return $this->cook_key;
    }

    public function get_ref_key()
    {
        return $this->ref_key;
    }

    public function get_temp_lock()
    {
        return $this->temp_lock;
    }

    public function get_full_block()
    {
        return $this->full_block;
    }

    public function get_ac_type()
    {
        return $this->ac_type;
    }

    public function get_company_id()
    {
        return $this->company_id;
    }

    public function get_control_account_state()
    {
        return $this->control_account_state;
    }
    public function get_main_user_account_access_level_list_id()
    {
        return $this->main_user_account_access_level_list_id;
    }
}
