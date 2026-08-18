<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class dashboard_ADD_UPDATE
{
    private $id;
    private $user_id = 0;
    private $activity_description = "";
    private $ast = "1";
    private $sdt;

    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->company_obj = new Company_Info_Variable_List();
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data(
        $get_activity_description,
        $get_user_id = 0
    ) {
        $this->activity_description = addslashes($get_activity_description);
        $this->user_id              = (int)$get_user_id;

        $this->sql_update_query .=
            ", dis='" . $this->activity_description . "'" .
            ", main_user_login_email_list_id='" . $this->user_id . "'";
    }

    public function set_description(
        $get_dis)
    {
        $this->activity_description = addslashes($get_dis);
        $this->sql_update_query .= ", dis='" . $this->activity_description . "'";
    }

    public function set_user_id($get_user_id)
    {
        $this->user_id = (int)$get_user_id;
    
        $this->sql_update_query .=
         ", main_user_login_email_list_id='" . $this->user_id . "'";
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

    public function set_id($get_id)
    {
        $this->id = (int)$get_id;
    }

    public function get_error()
    {
        return $this->error_msg;
    }

    // --- Database Processing Methods ---

    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "
            INSERT INTO audit_trail_report (
                ast, 
                sdt, 
                dis, 
                main_user_login_email_list_id
            )
            VALUES (
                '" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->activity_description . "',
                '" . $this->user_id . "'
            )";

        $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "
            UPDATE audit_trail_report 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}

// Backward compatibility class aliases
if (!class_exists('data_ADD_UPDATE')) {
    class data_ADD_UPDATE extends dashboard_ADD_UPDATE {}
}
if (!class_exists('Dashboard_ADD_UPDATE')) {
    class Dashboard_ADD_UPDATE extends dashboard_ADD_UPDATE {}
}
?>