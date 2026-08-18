<?php

class Cook_Createing
{

    private $user_id;
    private $cook_id;
    private $email;
    private $error = "";

    public function __construct($get_user_id)
    {
        $this->user_id = $get_user_id;
    }

    private function get_current_cook_id()
    {
        $state = false;
        $data_base_obj = new DataBase();
        $data_base = $data_base_obj->get_data_base_connction();
        $sql_query = "select * from main_user_login where id='" . $this->user_id . "'";
        $result = $data_base->query($sql_query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->cook_id = $row['cook_key'];
                $this->email = $row['user_name'];
                $this->cook_id = trim($row['cook_key']);

                if ($this->cook_id === "NO_DATA" || $this->cook_id === "") {
                    $state = false;
                } else {
                    $state = true;
                }
            }
        } else {
            $state = false;
        }
        return $state;
    }

    public function create_new_cook_key()
    {
        $state = false;
        //        -----------------create ref_id----------------------
        $ref_id = "0";
        $val_of_long = floor(microtime(true) * 1000);
        $ref_id = substr($val_of_long, -7);

        //        -----------------create key----------------------
        $get_advance_sec_key = new Advance_Security();
        $this->cook_id = $get_advance_sec_key->get_data_encrypt($this->email, $ref_id);

        //        -----------------update key data----------------------

        $data_base_obj = new DataBase();
        $data_base = $data_base_obj->get_data_base_connction();
        $sql_query = "update main_user_login set cook_key='" . $this->cook_id . "',ref_key='" . $ref_id . "' where id='" . $this->user_id . "' ";
        $data_base->query($sql_query);
        if ($data_base->error == "") {
            $state = true;
        } else {
            $this->error = "cook someting went wrong " . $_SERVER['REQUEST_URI'];
            $state = false;
        }

        return $state;
    }

    public function get_cook_id()
    {
        if ($this->get_current_cook_id()) {
        } else {
            if ($this->create_new_cook_key()) {
            }
        }
        setcookie(
            "main_user_account_cook", // cookie name
            $this->cook_id,           // value
            time() + (86400 * 30),    // 30 days
            "/",                      // available everywhere
            "",                       // domain (auto)
            isset($_SERVER['HTTPS']), // secure (HTTPS only)
            true                      // httponly (JS can't access)
        );
        return $this->cook_id;
    }

    public function distroy_cookie_data()
    {
        $state = false;
        $data_base_obj = new DataBase();
        $get_sql_query = "update main_user_login set cook_key='NO_DATA' where id='" . $this->user_id . "'";
        //        echo $get_sql_query;
        $data_base_obj->get_result($get_sql_query);

        if ($data_base_obj->get_error_state_boolean()) {
            $state = true;
        } else {
            $this->error = $data_base_obj->get_error();
            $state = false;
        }
        return $state;
    }

    public function set_email($get_email)
    {
        $this->email = $get_email;
    }


    public function set_user_id($get_user_id)
    {
        $this->user_id = $get_user_id;
    }

    public function get_error()
    {
        return $this->error;
    }
}
