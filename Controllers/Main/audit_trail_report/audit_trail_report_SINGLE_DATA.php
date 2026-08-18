<?php
class audit_trail_report_SINGLE_DATA
{
    private $id;
    private $ast = "1";
    private $sdt;
    private $dis;
    private $main_user_login_id;
    private $company_id;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = $id;
        $database_obj = new DataBase();
        $get_sql_query = "SELECT * FROM audit_trail_report WHERE id='" . $this->id . "'";
        $database_obj->get_result($get_sql_query);
        $result = $database_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id = $row['id'];
                $this->ast = $row['ast'];
                $this->sdt = $row['sdt'];
                $this->dis = $row['dis'];
                $this->main_user_login_id = $row['main_user_login_id'];
                $this->company_id = $row['company_id'];

            }
        }
    }
    public function get_state()
    {
        return $this->state_of_data;
    }
    
    public function get_id()
    {
        return $this->id;
    }
    public function get_ast()
    {
        return $this->ast;
    }
    public function get_sdt()
    {
        return $this->sdt;
    }
    public function get_dis()
    {
        return $this->dis;
    }
    public function get_main_user_login_id()
    {
        return $this->main_user_login_id;
    }
    public function get_company_id()
    {
        return $this->company_id;
    }
}

    
                




