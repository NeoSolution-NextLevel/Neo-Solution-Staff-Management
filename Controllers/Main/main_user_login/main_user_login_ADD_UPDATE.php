<?php
class main_user_login_ADD_UPDATE
{

    private $id;
    private $user_name;
    private $password;
    private $account_active_state = 1;
    private $ast = "1";
    private $sdt;
    private $last_login;
    private $name_show;
    private $email_verify = 0;
    private $moible_verfiy = 0;
    private $very_first_login = 0;
    private $cook_key;
    private $ref_key;
    private $temp_lock = 0;
    private $full_block = 0;
    private $ac_type;
    private $company_id;
    private $control_account_state = 0;
    private $main_user_account_access_level_list_id;

    private $image_url = "";

    private $google_id;
    private $google_authentication_secret;

    private $microsoft_id;
    private $first_name;
    private $last_name;
    private $is_google_authentication_enable = 0;

    private $company_obj;
    private $dis;
    private $phone_number;
    private $is_two_factor_auth_enable = 0;
    private $wrong_login_count = 0;


    private $error_msg;
    private $sql_update_query = "";


    public function __construct()
    {
        $this->company_obj = new Company_Info_Variable_List();
        $this->sdt = date('Y-m-d H:i:s');
    }


    public function set_user_profile_data(
        $get_user_name,
        $get_name_show,
        $get_first_name,
        $get_last_name,
        $get_dis,
        $get_phone_number
    ) {
        $this->user_name = $get_user_name;
        $this->name_show = $get_name_show;
        $this->first_name = $get_first_name;
        $this->last_name = $get_last_name;
        $this->dis = $get_dis;
        $this->phone_number = $get_phone_number;

        $this->sql_update_query .=
            ", user_name='" . $this->user_name . "'" .
            ", name_show='" . $this->name_show . "'" .
            ", first_name='" . $this->first_name . "'" .
            ", last_name='" . $this->last_name . "'" .
            ", dis='" . $this->dis . "'" .
            ", phone_number='" . $this->phone_number . "'";
    }


    public function set_data(
        $get_user_name,
        $get_password,
        $get_last_login,
        $get_name_show,
        $get_cook_key,
        $get_ref_key,
        $get_ac_type,
        $get_company_id,
        $get_image_url,
        $get_google_id,
        $get_google_authentication_secret,
        $get_main_user_account_access_level_list_id,
        $get_first_name,
        $get_last_name,
        $get_dis,
        $get_phone_number
    ) {
        $this->user_name = $get_user_name;
        $this->password = $get_password;
        $this->last_login = $get_last_login;
        $this->name_show = $get_name_show;
        $this->cook_key = $get_cook_key;
        $this->ref_key = $get_ref_key;
        $this->ac_type = $get_ac_type;
        $this->company_id = $get_company_id;
        $this->image_url = $get_image_url;
        $this->google_id = $get_google_id;
        $this->google_authentication_secret = $get_google_authentication_secret;
        $this->main_user_account_access_level_list_id = $get_main_user_account_access_level_list_id;
        $this->first_name = $get_first_name;
        $this->last_name = $get_last_name;
        $this->dis = $get_dis;
        $this->phone_number = $get_phone_number;

        $this->sql_update_query .=
            ", user_name='" . $this->user_name . "'" .
            ", password='" . $this->password . "'" .
            ", last_login='" . $this->last_login . "'" .
            ", name_show='" . $this->name_show . "'" .
            ", cook_key='" . $this->cook_key . "'" .
            ", ref_key='" . $this->ref_key . "'" .
            ", ac_type='" . $this->ac_type . "'" .
            ", company_id='" . $this->company_id . "'" .
            ", image_url='" . $this->image_url . "'" .
            ", google_id='" . $this->google_id . "'" .
            ", google_authentication_secret='" . $this->google_authentication_secret . "'" .
            ", main_user_account_access_level_list_id='" . $this->main_user_account_access_level_list_id . "'" .
            ", first_name='" . $this->first_name . "'" .
            ", last_name='" . $this->last_name . "'" .
            ", dis='" . $this->dis . "'" .
            ", phone_number='" . $this->phone_number . "'";
    }

    public function set_registration_from_data(
        $get_user_name,
        $get_password,
        $get_name_show,
        $get_cook_key,
        $get_ref_key,
        $get_ac_type,
        $get_main_user_account_access_level_list_id,
        $get_first_name,
        $get_last_name
    ) {
        $this->user_name = $get_user_name;
        $this->password = $get_password;
        $this->last_login = date('Y-m-d H:i:s');
        $this->name_show = $get_name_show;
        $this->cook_key = $get_cook_key;
        $this->ref_key = $get_ref_key;
        $this->ac_type = $get_ac_type;
        $this->company_id = $this->company_obj->get_compnay_id();
        $this->main_user_account_access_level_list_id = $get_main_user_account_access_level_list_id;
        $this->last_name = $get_last_name;
        $this->first_name = $get_first_name;

        $this->sql_update_query .=
            ", user_name='" . $this->user_name . "'" .
            ", password='" . $this->password . "'" .
            ", last_login='" . $this->last_login . "'" .
            ", name_show='" . $this->name_show . "'" .
            ", cook_key='" . $this->cook_key . "'" .
            ", ref_key='" . $this->ref_key . "'" .
            ", ac_type='" . $this->ac_type . "'" .
            ", company_id='" . $this->company_id . "'" .
            ", main_user_account_access_level_list_id='" . $this->main_user_account_access_level_list_id . "'" .
            ", first_name='" . $this->first_name . "'" .
            ", last_name='" . $this->last_name . "'";
    }


    public function set_main_user_login_google_microsoft_auth_login_data($get_google_microsoft_id, $get_name_show, $get_user_name, $get_image_url, $get_user_type_of_access, $is_google_login = false)
    {


        $this->user_name = $get_user_name;
        $this->password = "";
        $this->last_login = date('Y-m-d H:i:s');
        $this->name_show = $get_name_show;
        $this->cook_key = "";
        $this->ref_key = "";
        $this->ac_type = "";
        $this->company_id = $this->company_obj->get_compnay_id();
        $this->image_url = $get_image_url;
        $this->google_authentication_secret = "";

        // $this->main_user_account_access_level_list_id = "";

        $main_user_account_access_level_list_obj = new main_user_account_access_level_list_LIST();
        $main_user_account_access_level_list_obj->filter_by_type_of_access($get_user_type_of_access);

        $get_result = $main_user_account_access_level_list_obj->get_result();

        if ($get_result && $get_result->num_rows > 0) {
            $this->main_user_account_access_level_list_id = $get_result->fetch_assoc()['id'];
        } else {
            echo "User have no this type access level list.";
            exit;
        }



        if ($is_google_login) {
            $this->google_id = $get_google_microsoft_id;
            $this->microsoft_id = "Google Login User";

            $this->sql_update_query .=  ", google_id='" . $this->google_id . "'" .
                ", microsoft_id='" . $this->microsoft_id . "'";
        } else {
            $this->microsoft_id = $get_google_microsoft_id;
            $this->google_id = "Microsoft Login User";
            $this->sql_update_query .=  ", google_id='" . $this->google_id . "'" .
                ", microsoft_id='" . $this->microsoft_id . "'";
        }




        $this->sql_update_query .=
            ", user_name='" . $this->user_name . "'" .
            ", password='" . $this->password . "'" .
            ", last_login='" . $this->last_login . "'" .
            ", name_show='" . $this->name_show . "'" .
            ", cook_key='" . $this->cook_key . "'" .
            ", ref_key='" . $this->ref_key . "'" .
            ", ac_type='" . $this->ac_type . "'" .
            ", company_id='" . $this->company_id . "'" .
            ", image_url='" . $this->image_url . "'" .
            ", google_authentication_secret='" . $this->google_authentication_secret . "'" .
            ", main_user_account_access_level_list_id='" . $this->main_user_account_access_level_list_id . "'";
    }



    public function set_user_name($get_user_name)
    {
        $this->user_name = $get_user_name;
        $this->sql_update_query .= ", user_name='" . $this->user_name . "'";
    }
    public function set_password($get_password)
    {
        $this->password = $get_password;
        $this->sql_update_query .= ", password='" . $this->password . "'";
    }
    public function set_last_login($get_last_login)
    {
        $this->last_login = $get_last_login;
        $this->sql_update_query .= ", last_login='" . $this->last_login . "'";
    }
    public function set_name_show($get_name_show)
    {
        $this->name_show = $get_name_show;
        $this->sql_update_query .= ", name_show='" . $this->name_show . "'";
    }
    public function set_cook_key($get_cook_key)
    {
        $this->cook_key = $get_cook_key;
        $this->sql_update_query .= ", cook_key='" . $this->cook_key . "'";
    }
    public function set_ref_key($get_ref_key)
    {
        $this->ref_key = $get_ref_key;
        $this->sql_update_query .= ", ref_key='" . $this->ref_key . "'";
    }
    public function set_ac_type($get_ac_type)
    {
        $this->ac_type = $get_ac_type;
        $this->sql_update_query .= ", ac_type='" . $this->ac_type . "'";
    }
    public function set_company_id($get_company_id)
    {
        $this->company_id = $get_company_id;
        $this->sql_update_query .= ", company_id='" . $this->company_id . "'";
    }
    public function set_main_user_account_access_level_list_id($get_main_user_account_access_level_list_id)
    {
        $this->main_user_account_access_level_list_id = $get_main_user_account_access_level_list_id;
        $this->sql_update_query .= ", main_user_account_access_level_list_id='" . $this->main_user_account_access_level_list_id . "'";
    }


    public function set_image_url($get_image_url)
    {
        $this->image_url = $get_image_url;
        $this->sql_update_query .= ", image_url='" . $this->image_url . "'";
    }
    public function set_google_id($get_google_id)
    {
        $this->google_id = $get_google_id;
        $this->sql_update_query .= ", google_id='" . $this->google_id . "'";
    }
    public function set_google_authentication_secret($get_google_authentication_secret)
    {
        $this->google_authentication_secret = $get_google_authentication_secret;
        $this->sql_update_query .= ", google_authentication_secret='" . $this->google_authentication_secret . "'";
    }

    public function set_microsoft_id($get_microsoft_id)
    {
        $this->microsoft_id = $get_microsoft_id;
        $this->sql_update_query .= ", microsoft_id='" . $this->microsoft_id . "'";
    }

    public function set_dis($get_dis)
    {
        $this->dis = $get_dis;
        $this->sql_update_query .= ", dis='" . $this->dis . "'";
    }

    public function set_phone_number($get_phone_number)
    {
        $this->phone_number = $get_phone_number;
        $this->sql_update_query .= ", phone_number='" . $this->phone_number . "'";
    }

    public function set_first_name($get_first_name)
    {
        $this->first_name = $get_first_name;
        $this->sql_update_query .= ", first_name='" . $this->first_name . "'";
    }


    public function set_last_name($get_last_name)
    {
        $this->last_name = $get_last_name;
        $this->sql_update_query .= ", last_name='" . $this->last_name . "'";
    }
    public function set_wrong_login_count($get_wrong_login_count)
    {
        $this->wrong_login_count = $get_wrong_login_count;
        $this->sql_update_query .= ", wrong_login_count='" . $this->wrong_login_count . "'";
    }


    // ACCOUNT ACTIVE STATE
    public function is_account_active_state()
    {
        $this->account_active_state = 1;
        $this->sql_update_query .= ", account_active_state='" . $this->account_active_state . "'";
    }
    public function is_not_account_active_state()
    {
        $this->account_active_state = 0;
        $this->sql_update_query .= ", account_active_state='" . $this->account_active_state . "'";
    }

    // EMAIL VERIFY
    public function is_email_verify()
    {
        $this->email_verify = 1;
        $this->sql_update_query .= ", email_verify='" . $this->email_verify . "'";
    }
    public function is_not_email_verify()
    {
        $this->email_verify = 0;
        $this->sql_update_query .= ", email_verify='" . $this->email_verify . "'";
    }

    // MOBILE VERIFY
    public function is_moible_verfiy()
    {
        $this->moible_verfiy = 1;
        $this->sql_update_query .= ", moible_verfiy='" . $this->moible_verfiy . "'";
    }
    public function is_not_moible_verfiy()
    {
        $this->moible_verfiy = 0;
        $this->sql_update_query .= ", moible_verfiy='" . $this->moible_verfiy . "'";
    }

    // VERY FIRST LOGIN
    public function is_very_first_login()
    {
        $this->very_first_login = 1;
        $this->sql_update_query .= ", very_first_login='" . $this->very_first_login . "'";
    }
    public function is_not_very_first_login()
    {
        $this->very_first_login = 0;
        $this->sql_update_query .= ", very_first_login='" . $this->very_first_login . "'";
    }

    // TEMP LOCK
    public function is_temp_lock()
    {
        $this->temp_lock = 1;
        $this->sql_update_query .= ", temp_lock='" . $this->temp_lock . "'";
    }
    public function is_not_temp_lock()
    {
        $this->temp_lock = 0;
        $this->sql_update_query .= ", temp_lock='" . $this->temp_lock . "'";
    }

    // FULL BLOCK
    public function is_full_block()
    {
        $this->full_block = 1;
        $this->sql_update_query .= ", full_block='" . $this->full_block . "'";
    }
    public function is_not_full_block()
    {
        $this->full_block = 0;
        $this->sql_update_query .= ", full_block='" . $this->full_block . "'";
    }

    // CONTROL ACCOUNT STATE
    public function is_control_account_state()
    {
        $this->control_account_state = 1;
        $this->sql_update_query .= ", control_account_state='" . $this->control_account_state . "'";
    }
    public function is_not_control_account_state()
    {
        $this->control_account_state = 0;
        $this->sql_update_query .= ", control_account_state='" . $this->control_account_state . "'";
    }

    // is_google_authentication_enable
    public function is_is_google_authentication_enable()
    {
        $this->is_google_authentication_enable = 1;
        $this->sql_update_query .= ", is_google_authentication_enable='" . $this->is_google_authentication_enable . "'";
    }
    public function is_not_is_google_authentication_enable()
    {
        $this->is_google_authentication_enable = 0;
        $this->sql_update_query .= ", is_google_authentication_enable='" . $this->is_google_authentication_enable . "'";
    }



    // is_two_factor_auth_enables
    public function is_is_two_factor_auth_enable()
    {
        $this->is_two_factor_auth_enable = 1;
        $this->sql_update_query .= ", is_two_factor_auth_enable='" . $this->is_two_factor_auth_enable . "'";
    }
    public function is_not_is_two_factor_auth_enable()
    {
        $this->is_two_factor_auth_enable = 0;
        $this->sql_update_query .= ", is_two_factor_auth_enable='" . $this->is_two_factor_auth_enable . "'";
    }


    // --- Utility and Getter Methods ---

    public function remove()
    {
        $this->ast = "0";
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_google_id()
    {
        return $this->google_id;
    }

    public function set_id($get_id)
    {
        $this->id = $get_id;
    }

    public function get_error()
    {
        return $this->error_msg;
    }



    public function process_new_record()
    {

        $data_base_obj = new DataBase();

        $get_sql_query = "
        INSERT INTO main_user_login (
            ast, 
            sdt, 
            user_name, 
            password, 
            account_active_state, 
            last_login, name_show, 
            email_verify, 
            moible_verfiy, 
            very_first_login, 
            cook_key, ref_key, 
            temp_lock, 
            full_block, 
            ac_type, 
            company_id, 
            control_account_state, 
            main_user_account_access_level_list_id,
            image_url,
            google_id,
            is_google_authentication_enable,
            microsoft_id,
            first_name,
            last_name,
            dis,
            phone_number,
            is_two_factor_auth_enable,
            wrong_login_count
        )
        VALUES (
            '" . $this->ast . "',
            '" . $this->sdt . "',
            '" . $this->user_name . "',
            '" . $this->password . "',
            '" . $this->account_active_state . "',
            '" . $this->last_login . "',
            '" . $this->name_show . "',
            '" . $this->email_verify . "',
            '" . $this->moible_verfiy . "',
            '" . $this->very_first_login . "',
            '" . $this->cook_key . "',
            '" . $this->ref_key . "',
            '" . $this->temp_lock . "',
            '" . $this->full_block . "',
            '" . $this->ac_type . "',
            '" . $this->company_id . "',
            '" . $this->control_account_state . "',
            '" . $this->main_user_account_access_level_list_id . "',
            '" . $this->image_url . "',
            '" . $this->google_id . "',
            '" . $this->is_google_authentication_enable . "',
            '" . $this->microsoft_id . "',
            '" . $this->first_name . "',
            '" . $this->last_name . "',
            '" . $this->dis . "',
            '" . $this->phone_number . "',
            '" . $this->is_two_factor_auth_enable . "',
            '" . $this->wrong_login_count . "'
        )";

        // echo $get_sql_query;
        $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {

        $data_base_obj = new DataBase();
        $get_sql_query = "
            UPDATE main_user_login 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        // echo $get_sql_query;
        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}
