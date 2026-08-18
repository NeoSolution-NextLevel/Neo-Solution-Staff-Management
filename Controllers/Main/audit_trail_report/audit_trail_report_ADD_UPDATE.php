<?php
class audit_trail_report_ADD_UPDATE
{
    private $id;
    private $ast = "1";
    private $sdt;
    private $dis;
    private $main_user_login_id;
    private $company_id;

    private $sql_update_query = "";

    public function __construct($main_user_login_id)
    {
        $this->main_user_login_id = $main_user_login_id;
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data($get_dis,
                             $get_company_id)
                             {
                                $this->dis = $get_dis;
                                $this->company_id = $get_company_id;
                                $this->sql_update_query .= 
                                   " dis='" . $this->dis . 
                                   "', company_id='" . $this->company_id . "'";
                             } 
    public function set_dis($get_dis)
    {
        $this->dis = $get_dis;
        $this->sql_update_query .= " dis='" . $this->dis . "'";
    }
    public function set_company_id($get_company_id)
    {
        $this->company_id = $get_company_id;
        $this->sql_update_query .= ", company_id='" . $this->company_id . "'";
    }

    public function remove()
    {
        $this->ast = 0;
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
        $data_base_obj = new DataBase();
        $get_sql_query = "INSERT INTO audit_trail_report(dis, company_id, sdt, ast, main_user_login_id)
                          VALUES (
            '" . $this->dis . "',
            '" . $this->company_id . "',
            '" . $this->sdt ."',
            '" . $this->ast ."'
            '" . $this->main_user_login_id . "'
            )";
            $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }
    public function process_update()
    {
        $data_base_obj = new DataBase();
         $get_sql_query = "audit_trail_report set ast='" . $this->ast . "'" . $this->sql_update_query . " where id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}






    


                             





    


