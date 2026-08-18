<?php
class email_sms_link_manament_SINGLE_DATA
{
    private $id;
    private $state_of_view;
    private $on_short_lock;
    private $key_of_encript;
    private $url_after_process;
    private $id_of_value;
    private $view_count;
    private $state_email ;
    private $state_sms ;
    private $company_id;
    private $branch_id;


    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = $id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM email_sms_link_manament WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id                   = $row['id'];
                $this->state_of_view        = $row['state_of_view'];
                $this->on_short_lock        = $row['on_short_lock'];
                $this->key_of_encript       = $row['key_of_encript'];
                $this->url_after_process    = $row['url_after_process'];
                $this->id_of_value          = $row['id_of_value'];
                $this->view_count           = $row['view_count'];
                $this->state_email          = $row['state_email'];
                $this->state_sms            = $row['state_sms'];
                $this->company_id           = $row['company_id'];
                $this->branch_id            = $row['branch_id'];
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

    public function get_state_of_view()
    {
        return $this->state_of_view;
    }

    public function get_on_short_lock()
    {
        return $this->on_short_lock;
    }

    public function get_key_of_encript()
    {
        return $this->key_of_encript;
    }

    public function get_url_after_process()
    {
        return $this->url_after_process;
    }

    public function get_id_of_value()
    {
        return $this->id_of_value;
    }

    public function get_view_count()
    {
        return $this->view_count;
    }

    public function get_state_email()
    {
        return $this->state_email;
    }

    public function get_state_sms()
    {
        return $this->state_sms;
    }

    public function get_company_id()
    {
        return $this->company_id;
    }

    public function get_branch_id()
    {
        return $this->branch_id;
    }

}