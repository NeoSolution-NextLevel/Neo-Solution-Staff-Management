<?php
class main_user_account_access_level_list_SINGLE_DATA
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
    private $state_of_data = false;


    public function __construct($id)
    {
        $this->id = $id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM main_user_account_access_level_list WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id                   = $row['id'];
                $this->type_of_access       = $row['type_of_access'];
                $this->ast                  = $row['ast'];
                $this->sdt                  = $row['sdt'];
                $this->url_home             = $row['url_home'];
                $this->company_id           = $row['company_id'];
                // $this->show_custoer_account = $row['show_custoer_account'];
                $this->dis                  = $row['dis'];
                $this->job_role                  = $row['job_role'];
            }
        }
    }

    // --- Getter functions ---

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_type_of_access()
    {
        return $this->type_of_access;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_url_home()
    {
        return $this->url_home;
    }

    public function get_company_id()
    {
        return $this->company_id;
    }

    public function get_show_custoer_account()
    {
        return $this->show_custoer_account;
    }

    public function get_dis()
    {
        return $this->dis;
    }

    public function get_job_role()
    {
        return $this->job_role;
    }
}
