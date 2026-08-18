<?php
class main_user_login_email_list_SINGLE_DATA
{
    private $id;
    private $email_steate = 0;
    private $key_of_email;
    private $ast = "1";
    private $sdt;
    private $type_email;
    private $company_id;
    private $main_user_login_id;


    private $state_of_data = false;


    public function __construct($id)
    {
        $this->id = $id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM main_user_login_email_list WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id                   = $row['id'];
                $this->email_steate         = $row['email_steate'];
                $this->key_of_email         = $row['key_of_email'];
                $this->ast                  = $row['ast'];
                $this->sdt                  = $row['sdt'];
                $this->type_email           = $row['type_email'];
                $this->company_id           = $row['company_id'];
                $this->main_user_login_id   = $row['main_user_login_id'];
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

    public function get_email_steate()
    {
        return $this->email_steate;
    }

    public function get_key_of_email()
    {
        return $this->key_of_email;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_type_email()
    {
        return $this->type_email;
    }

    public function get_company_id()
    {
        return $this->company_id;
    }

    public function get_main_user_login_id()
    {
        return $this->main_user_login_id;
    }
}


