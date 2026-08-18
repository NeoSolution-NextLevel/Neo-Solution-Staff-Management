<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class notifications_ADD_UPDATE
{
    private $id;
    private $recipient_role = "admin";
    private $recipient_name = "";
    private $title = "";
    private $message = "";
    private $type = "general";
    private $is_read = 0;
    
    private $ast = "1";
    private $sdt;

    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data(
        $get_title,
        $get_message,
        $get_type = "general",
        $get_recipient_role = "admin",
        $get_recipient_name = "",
        $get_is_read = 0
    ) {
        $this->title          = $get_title;
        $this->message        = $get_message;
        $this->type           = $get_type;
        $this->recipient_role = $get_recipient_role;
        $this->recipient_name = $get_recipient_name;
        $this->is_read        = (int)$get_is_read;

        $this->sql_update_query .=
            ", title='" . $this->title . "'" .
            ", message='" . $this->message . "'" .
            ", type='" . $this->type . "'" .
            ", recipient_role='" . $this->recipient_role . "'" .
            ", recipient_name='" . $this->recipient_name . "'" .
            ", is_read='" . $this->is_read . "'";
    }

    public function set_title($get_title)
    {
        $this->title = $get_title;
        $this->sql_update_query .= ", title='" . $this->title . "'";
    }

    public function set_message($get_message)
    {
        $this->message = $get_message;
        $this->sql_update_query .= ", message='" . $this->message . "'";
    }

    public function set_type($get_type)
    {
        $this->type = $get_type;
        $this->sql_update_query .= ", type='" . $this->type . "'";
    }

    public function set_recipient_role($get_recipient_role)
    {
        $this->recipient_role = $get_recipient_role;
        $this->sql_update_query .= ", recipient_role='" . $this->recipient_role . "'";
    }

    public function set_recipient_name($get_recipient_name)
    {
        $this->recipient_name = $get_recipient_name;
        $this->sql_update_query .= ", recipient_name='" . $this->recipient_name . "'";
    }

    public function set_is_read($get_is_read)
    {
        $this->is_read = (int)$get_is_read;
        $this->sql_update_query .= ", is_read='" . $this->is_read . "'";
    }

    public function mark_as_read()
    {
        $this->is_read = 1;
        $this->sql_update_query .= ", is_read='1'";
    }

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
            INSERT INTO system_notifications (
                recipient_role,
                recipient_name,
                title,
                message,
                type,
                is_read,
                created_at
            )
            VALUES (
                '" . $this->recipient_role . "',
                '" . $this->recipient_name . "',
                '" . $this->title . "',
                '" . $this->message . "',
                '" . $this->type . "',
                '" . $this->is_read . "',
                '" . $this->sdt . "'
            )";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();

        $update_part = ltrim($this->sql_update_query, ',');
        $get_sql_query = "
            UPDATE system_notifications 
            SET " . $update_part . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error_state_boolean();
        return $data_base_obj->get_error_state_boolean();
    }
}
?>
