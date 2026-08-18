<?php
class email_sms_link_view_history_SINGLE_DATA
{
    private $id;
    private $sdt;
    private $ast = "1";
    private $Email_SMS_link_manament_id;
    private $state_of_data = false;


    public function __construct($id)
    {
        $this->id = $id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM email_sms_link_view_history WHERE id='" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if ($result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id = $row['id'];
                $this->sdt = $row['sdt'];
                $this->ast = $row['ast'];
                $this->Email_SMS_link_manament_id = $row['Email_SMS_link_manament_id'];
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

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_ast()
    {
        return $this->ast;
    }
    public function get_Email_SMS_link_manament_id()
    {
        return $this->Email_SMS_link_manament_id;
    }

    

    
       
    

}