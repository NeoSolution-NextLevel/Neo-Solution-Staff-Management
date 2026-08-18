<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Cook_Management
{

    private $cook_id;
    private $email;
    private $user_id;
    private $error = "";
    private $account_cook_fouse_remove_staet = false;
    private $name_show;
    private $access_control_id;


    public function __construct($get_cook_id)
    {
        $this->cook_id = $get_cook_id;
    }

    public function cook_remove_fouse_state()
    {
        return $this->account_cook_fouse_remove_staet;
    }

    public function check_login_availability()
    {
        $state = false;
        $data_base_obj = new DataBase();
        $data_base = $data_base_obj->get_data_base_connction();
        $sql_query = "select * from main_user_login where cook_key='" . $this->cook_id . "'";
        $result = $data_base->query($sql_query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->user_id = $row['id'];
                $this->email = $row['user_name'];
                $this->name_show = $row['name_show'];
                $this->access_control_id = $row['main_user_account_access_level_list_id'];
                if ($row['account_active_state'] == "1") {
                    if ($row['full_block'] == "1") {
                        $state = false;
                        $this->account_cook_fouse_remove_staet = true;
                        $this->set_error_data("We regret to inform you that your account has been blocked. Please contact the system administrator for further assistance.");
                    } else if ($row['temp_lock'] == "1") {
                        $state = false;
                        $this->account_cook_fouse_remove_staet = false;
                        $this->set_error_data("We kindly ask you to check your email inbox for further instructions. If you have received a temporary block notification, please follow the instructions provided in the email to resolve the issue.");
                    } else {
                        $this->account_cook_fouse_remove_staet = false;
                        $state = true;
                    }
                } else {
                    $this->account_cook_fouse_remove_staet = true;
                    $state = false;
                    $this->set_error_data("We regret to inform you that your account is currently inactive. Please contact our support team for further assistance.");
                }
            }
        } else {
            $this->account_cook_fouse_remove_staet = true;
            $this->error = "cookie ID is invalid";
            $state = false;
        }
        return $state;
    }

    public function main_user_login_logout($main_user_login_id)
    {
        $this->user_id  = $main_user_login_id;
        $state = false;

        $data_base_obj = new DataBase();
        $data_base = $data_base_obj->get_data_base_connction();

        $sql_query = "UPDATE main_user_login 
                  SET cook_key = 'NO_DATA' 
                  WHERE id = '" . $this->user_id . "'";

        $result = $data_base->query($sql_query);

        if ($result === true && $data_base->affected_rows > 0) {
            $state = true;
        }

        return $state;
    }


    private function set_error_data($get_error)
    {
        $this->error = $get_error;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function get_name_show()
    {
        return $this->name_show;
    }

    public function get_access_level_id()
    {
        return $this->access_control_id;
    }

    public function get_error_msg()
    {
        return $this->error;
    }
    public function get_email()
    {
        return $this->email;
    }
}
