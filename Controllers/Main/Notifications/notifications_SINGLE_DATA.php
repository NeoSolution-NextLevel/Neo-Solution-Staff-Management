<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class notifications_SINGLE_DATA
{
    private $id;
    private $recipient_role;
    private $recipient_name;
    private $title;
    private $message;
    private $type;
    private $is_read;
    private $created_at;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM system_notifications WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id             = $row['id'];
                $this->recipient_role = isset($row['recipient_role']) ? $row['recipient_role'] : 'admin';
                $this->recipient_name = isset($row['recipient_name']) ? $row['recipient_name'] : '';
                $this->title          = isset($row['title']) ? $row['title'] : '';
                $this->message        = isset($row['message']) ? $row['message'] : '';
                $this->type           = isset($row['type']) ? $row['type'] : 'general';
                $this->is_read        = isset($row['is_read']) ? (int)$row['is_read'] : 0;
                $this->created_at     = isset($row['created_at']) ? $row['created_at'] : date('Y-m-d H:i:s');
            }
        }
    }

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function is_state_of_data()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_recipient_role()
    {
        return $this->recipient_role;
    }

    public function get_recipient_name()
    {
        return $this->recipient_name;
    }

    public function get_title()
    {
        return $this->title;
    }

    public function get_message()
    {
        return $this->message;
    }

    public function get_type()
    {
        return $this->type;
    }

    public function get_is_read()
    {
        return $this->is_read;
    }

    public function get_created_at()
    {
        return $this->created_at;
    }
}

if (!class_exists('notificatiosn_SINGLE_DATA')) {
    class notificatiosn_SINGLE_DATA extends notifications_SINGLE_DATA {}
}
?>
