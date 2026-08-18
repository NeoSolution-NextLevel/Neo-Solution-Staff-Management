<?php

//need to import  
//compnay variable list *****imports\Company_Info\Company_Info_Variable_List.php*****
//database conntion class

//
//include_once '../need/DB.php';

class Email_Notification {

    private $data_base_obj;
    private $subject;
    private $html_data;
    private $company_variable_list;
    private $get_department_key;
    private $email_sending_obj;
//    ------------------database------------------
    private $get_db_email_save_id;

    public function __construct($get_subject, $get_html_data, $get_department_key) {
        $this->subject = $get_subject;
        $this->html_data = $get_html_data;
        $this->company_variable_list = new Company_Info_Variable_List();
        $this->get_department_key = $get_department_key;
    }

    private function create_new_message_save_to_db() {
        $this->data_base_obj = new DataBase();
        $data_base = $this->data_base_obj->get_data_base_connction();
        $SQL_query = "INSERT INTO department_email_history(subject_value,message_body,ast,sdt) VALUES ('" . $this->subject . "','" . $this->html_data . "','1',now())";
        $data_base->query($SQL_query);
        $this->get_db_email_save_id = $data_base->insert_id;
        $this->get_email_sending_list();
    }

    private function get_email_sending_list() {
        $this->data_base_obj = new DataBase();
        $data_base = $this->data_base_obj->get_data_base_connction();
        $SQL_query = "select * from department_email_notification where dpt_name='" . $this->get_department_key . "' and ast='1'";
        $result = $data_base->query($SQL_query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->setup_connction($row['id'], $row['email']);
            }
        }
    }

    private function setup_connction($get_email_id, $get_email_address) {
        $this->data_base_obj = new DataBase();
        $data_base = $this->data_base_obj->get_data_base_connction();
        $sql_query = "INSERT INTO department_email_notification_has_email_history(department_email_notification_id,department_email_history_id,sdt) VALUES('" . $get_email_id . "','" . $this->get_db_email_save_id . "',now())";
        $data_base->query($sql_query);
        if ($data_base->error == "") {
            $email_obj=new Email($get_email_address, $this->subject, $this->html_data);
            $email_obj->set_header_name("System Notification");
            $email_obj->send_email();
        } else {
            
        }
    }

    public function send_email() {
        $this->create_new_message_save_to_db();
    }

    public function one_time_reminder() {
        
    }
}
