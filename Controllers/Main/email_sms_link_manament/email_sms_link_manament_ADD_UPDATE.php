<?php
class email_sms_link_manament_ADD_UPDATE
{
    private $id;
    private $state_of_view = 0;
    private $on_short_lock = 0;
    private $key_of_encript;
    private $url_after_process;
    private $id_of_value;
    private $view_count;
    private $state_email = 0;
    private $state_sms = 0;
    private $company_id;
    private $branch_id;
    private $sql_update_query = "";

    

    public function set_data($get_key_of_encript,
                             $get_url_after_process,
                             $get_id_of_value,
                             $get_view_count,
                             $get_company_id,
                             $get_branch_id)
    {
        $this->key_of_encript = $get_key_of_encript;
        $this->url_after_process = $get_url_after_process;
        $this->id_of_value = $get_id_of_value;
        $this->view_count = $get_view_count;
        $this->company_id = $get_company_id;
        $this->branch_id = $get_branch_id;

        $this->sql_update_query .=
            " key_of_encript = '" . $this->key_of_encript . "'" 
            . ", url_after_process = '" . $this->url_after_process . "'" 
            . ", id_of_value = '" . $this->id_of_value . "'" 
            . ", view_count = '" . $this->view_count . "'" 
            . ", company_id = '" . $this->company_id . "'" 
            . ", branch_id = '" . $this->branch_id . "'";
    }



    public function is_state_of_view()
    {
        $this->state_of_view = 1;
        $this->sql_update_query .= ", state_of_view = '" . $this->state_of_view . "'";
    }
    public function is_not_state_of_view()
    {
        $this->state_of_view = 0;
        $this->sql_update_query .= ", state_of_view = '" . $this->state_of_view . "'";
    }




    public function is_on_short_lock()
    {
        $this->on_short_lock = 1;
        $this->sql_update_query .= ", on_short_lock = '" . $this->on_short_lock . "'";
    }
    public function is_not_on_short_lock()
    {
        $this->on_short_lock = 0;
        $this->sql_update_query .= ", on_short_lock = '" . $this->on_short_lock . "'";
    }



    public function is_state_email()
    {
        $this->state_email = 1;
        $this->sql_update_query .= ", state_email = '" . $this->state_email . "'";
    }
    public function is_not_state_email()
    {
        $this->state_email = 0;
        $this->sql_update_query .= ", state_email = '" . $this->state_email . "'";
    }



    public function is_state_sms()
    {
        $this->state_sms = 1;
        $this->sql_update_query .= ", state_sms = '" . $this->state_sms . "'";
    }
    public function is_not_state_sms()
    {
        $this->state_sms = 0;
        $this->sql_update_query .= ", state_sms = '" . $this->state_sms . "'";
    }




    public function set_key_of_encript($get_key_of_encript)
    {
        $this->key_of_encript = $get_key_of_encript;
        $this->sql_update_query .= ", key_of_encript = '" . $this->key_of_encript . "'";
    }

    public function set_url_after_process($get_url_after_process)
    { 
        $this->url_after_process = $get_url_after_process;
        $this->sql_update_query .= ", url_after_process = '" . $this->url_after_process . "'";
    }
    
    public function set_id_of_value($get_id_of_value)
    {
        $this->id_of_value = $get_id_of_value;
        $this->sql_update_query .= ", id_of_value = '" . $this->id_of_value . "'";
    }

    public function set_view_count($get_view_count)
    {
        $this->view_count = $get_view_count;
        $this->sql_update_query .= ", view_count = '" . $this->view_count . "'";
    }

    public function set_company_id($get_company_id)
    {
        $this->company_id = $get_company_id;
        $this->sql_update_query .= ", company_id = '" . $this->company_id . "'";
    }

    public function set_branch_id($get_branch_id)
    {
        $this->branch_id = $get_branch_id;
        $this->sql_update_query .= ", branch_id = '" . $this->branch_id . "'";
    }



    public function get_id()
    {
        return $this->id;
    }

    public function set_id($get_id)
    {
        $this->id = $get_id;
    }


    private $error_msg;
    public function get_error_msg()
    {
        return $this->error_msg;
    }


    public function process_new_record()
        {
            $data_base_obj = new Database();
            $get_sql_query = "
                INSERT INTO email_sms_link_manament
                (state_of_view, 
                on_short_lock,
                key_of_encript,
                url_after_process,
                id_of_value,
                view_count,
                state_email,
                state_sms,
                company_id,
                branch_id)
                VALUES
                ('" . $this->state_of_view . "',
                '" . $this->on_short_lock . "',
                '" . $this->key_of_encript . "',
                '" . $this->url_after_process . "',
                '" . $this->id_of_value . "',
                '" . $this->view_count . "',
                '" . $this->state_email . "',
                '" . $this->state_sms . "',
                '" . $this->company_id . "',
                '" . $this->branch_id . "'
                )";

                $data_base_obj->get_result($get_sql_query);

                $this->error_msg = $data_base_obj->get_error_state_boolean();
                $this->id = $data_base_obj->get_id();
                return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new Database();
        $get_sql_query = "update email_sms_link_manament set ast='". $this->sql_update_query . " where id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
    
}