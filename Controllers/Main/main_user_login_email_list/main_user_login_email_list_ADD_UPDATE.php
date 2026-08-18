<?php
class main_user_login_email_list_ADD_UPDATE
{
    private $id;
    private $email_steate = 0;
    private $key_of_email;
    private $ast = "1";
    private $sdt;
    private $type_email;
    private $company_id;
    private $main_user_login_id;
    

    private $error_msg;
    private $sql_update_query = "";

    
    public function __construct($get_main_user_login_id) {
        $this->main_user_login_id = $get_main_user_login_id;
        $this->sdt = date('Y-m-d H:i:s');
    }

  
    public function set_data(
        $get_key_of_email, 
        $get_type_email, 
        $get_company_id, 
      
    )
    {
        $this->key_of_email = $get_key_of_email;
        $this->type_email = $get_type_email;
        $this->company_id = $get_company_id;
       
        
        
        $this->sql_update_query .=
            ", key_of_email='" . $this->key_of_email . "'" .
            ", type_email='" . $this->type_email . "'" .
            ", company_id='" . $this->company_id . "'" ;
           
    }

    // --- Individual Setter Methods ---
    
    public function set_key_of_email($get_key_of_email)
    {
        $this->key_of_email = $get_key_of_email;
        $this->sql_update_query .= ", key_of_email='" . $this->key_of_email . "'";
    }

    public function set_type_email($get_type_email)
    {
        $this->type_email = $get_type_email;
        $this->sql_update_query .= ", type_email='" . $this->type_email . "'";
    }

    public function set_company_id($get_company_id)
    {
        $this->company_id = $get_company_id;
        $this->sql_update_query .= ", company_id='" . $this->company_id . "'";
    }

    public function set_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = $get_main_user_login_id;
        $this->sql_update_query .= ", main_user_login_id='" . $this->main_user_login_id . "'";
    }

   

    // EMAIL STATE
    public function is_email_steate()
    {
        $this->email_steate = 1;
        $this->sql_update_query .= ", email_steate='" . $this->email_steate . "'";
    }
    public function is_not_email_steate()
    {
        $this->email_steate = 0;
        $this->sql_update_query .= ", email_steate='" . $this->email_steate . "'";
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

    

    public function process_new_record()
    {
     
        $data_base_obj = new DataBase(); 
        
        $get_sql_query = "
        INSERT INTO main_user_login_email_list (
            ast, 
            sdt, 
            email_steate, 
            key_of_email, 
            type_email, 
            company_id, 
            main_user_login_id
        )
        VALUES (
            '" . $this->ast . "',
            '" . $this->sdt . "',
            '" . $this->email_steate . "',
            '" . $this->key_of_email . "',
            '" . $this->type_email . "',
            '" . $this->company_id . "',
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

        $get_sql_query = "
            UPDATE main_user_login_email_list 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}
