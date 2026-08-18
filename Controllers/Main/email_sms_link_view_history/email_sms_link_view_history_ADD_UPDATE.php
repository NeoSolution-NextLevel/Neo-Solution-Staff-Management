<?php
class email_sms_link_view_history_ADD_UPDATE
{
    private $id;
    private $sdt;
    private $ast = "1";
    private $Email_SMS_link_manament_id;
    private $sql_update_query;
    

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }
    
    public function set_data($get_Email_SMS_link_manament_id)
    {
        $this->Email_SMS_link_manament_id = $get_Email_SMS_link_manament_id;
        $this->sql_update_query .=
             ",Email_SMS_link_manament_id'" . $this->Email_SMS_link_manament_id . "'";

        
    }

    public function set_Email_SMS_link_manament_id($get_Email_SMS_link_manament_id)
    {
        $this->Email_SMS_link_manament_id = $get_Email_SMS_link_manament_id;
        $this->sql_update_query .= ", Email_SMS_link_manament_id='" . $this->Email_SMS_link_manament_id . "'";
    }

    public function remove()
    {
        $this->ast = "0";
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

    public function get_error()
    {
        return $this->error_msg;
    }


    public function process_new_record()
    {
        $data_base_obj = new Database();
        $get_sql_query = "INSERT INTO email_sms_link_view_history
        (sdt,ast,Email_SMS_link_manament_id)
        VALUES
        ('" . $this->sdt . "','" . $this->ast . "','" . $this->Email_SMS_link_manament_id . "')";

         // echo $get_sql_query;
        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "update email_sms_link_view_historyset ast='" . $this->ast . "'" . $this->sql_update_query . " where id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }



        






    }
    



    



    
