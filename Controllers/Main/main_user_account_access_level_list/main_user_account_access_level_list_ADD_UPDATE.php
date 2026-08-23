<?php
class main_user_account_access_level_list_ADD_UPDATE
{
    private $id;
    private $type_of_access;
    private $ast = "1";
    private $sdt;
    private $url_home;
    private $company_id;
    private $show_custoer_account = 0;
    private $dis;
    private $job_role;


    private $error_msg;
    private $sql_update_query = "";


    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }


    public function set_data(
        $get_type_of_access,
        $get_url_home,
        $get_company_id,
        $get_dis,
        $get_job_role
    ) {
        $this->type_of_access = $get_type_of_access;
        $this->url_home = $get_url_home;
        $this->company_id = $get_company_id;
        $this->dis = $get_dis;
        $this->job_role = $get_job_role;

        $this->sql_update_query .=
            ", type_of_access='" . $this->type_of_access . "'" .
            ", url_home='" . $this->url_home . "'" .
            ", company_id='" . $this->company_id . "'" .
            ", dis='" . $this->dis . "'" .
            ", job_role='" . $this->job_role . "'";
    }



    public function set_type_of_access($get_type_of_access)
    {
        $this->type_of_access = $get_type_of_access;
        $this->sql_update_query .= ", type_of_access='" . $this->type_of_access . "'";
    }

    public function set_url_home($get_url_home)
    {
        $this->url_home = $get_url_home;
        $this->sql_update_query .= ", url_home='" . $this->url_home . "'";
    }

    public function set_company_id($get_company_id)
    {
        $this->company_id = $get_company_id;
        $this->sql_update_query .= ", company_id='" . $this->company_id . "'";
    }

    public function set_dis($get_dis)
    {
        $this->dis = $get_dis;
        $this->sql_update_query .= ", dis='" . $this->dis . "'";
    }

    public function set_job_role($get_job_role)
    {
        $this->job_role = $get_job_role;
        $this->sql_update_query .= ", job_role='" . $this->job_role . "'";
    }


    // SHOW CUSTOMER ACCOUNT
    public function is_show_custoer_account()
    {
        $this->show_custoer_account = 1;
        $this->sql_update_query .= ", show_custoer_account='" . $this->show_custoer_account . "'";
    }
    public function is_not_show_custoer_account()
    {
        $this->show_custoer_account = 0;
        $this->sql_update_query .= ", show_custoer_account='" . $this->show_custoer_account . "'";
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
        $this->id = $get_id;
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
            INSERT INTO main_user_account_access_level_list (
                ast, 
                sdt, 
                type_of_access, 
                url_home, 
                company_id, 
                show_custoer_account, 
                dis,
                job_role
            )
            VALUES (
                '" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->type_of_access . "',
                '" . $this->url_home . "',
                '" . $this->company_id . "',
                '" . $this->show_custoer_account . "',
                '" . $this->dis . "',
                '" . $this->job_role . "'
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
            UPDATE main_user_account_access_level_list 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}
