<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notifications_ADD_UPDATE
{
    private $id;
    private $type = 'all';
    private $title = '';
    private $body = '';
    private $ast = "1";
    private $main_user_login_id = 0;
    private $image_pth = '';
    private $sdt;
    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data($get_type, $get_title, $get_body, $arg4 = 0, $arg5 = null, $arg6 = null)
    {
        $this->type = !empty($get_type) ? trim((string)$get_type) : 'all';
        $this->title = trim((string)$get_title);
        $this->body = trim((string)$get_body);

        if (is_numeric($arg4) && (int)$arg4 > 0 && ($arg5 === null || is_string($arg5))) {
            $this->main_user_login_id = (int)$arg4;
            $this->image_pth = is_string($arg5) ? trim($arg5) : '';
        } else {
            if (!empty($arg4) && is_string($arg4) && ($this->type === 'all' || empty($this->type))) {
                $this->type = trim($arg4);
            }
            $this->main_user_login_id = !empty($arg5) ? (int)$arg5 : 0;
            $this->image_pth = !empty($arg6) ? trim((string)$arg6) : '';
        }

        $main_user_sql = ($this->main_user_login_id > 0)
            ? "'" . (int)$this->main_user_login_id . "'"
            : "NULL";

        $this->sql_update_query =
            ", type='" . addslashes($this->type) . "'" .
            ", title='" . addslashes($this->title) . "'" .
            ", body='" . addslashes($this->body) . "'" .
            ", main_user_login_id=" . $main_user_sql .
            ", image_pth='" . addslashes($this->image_pth) . "'";
    }

    public function set_id($get_id)
    {
        $this->id = (int)$get_id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_type($get_type)
    {
        $this->type = trim((string)$get_type);
        $this->sql_update_query .= ", type='" . addslashes($this->type) . "'";
    }

    public function set_title($get_title)
    {
        $this->title = trim((string)$get_title);
        $this->sql_update_query .= ", title='" . addslashes($this->title) . "'";
    }

    public function set_body($get_body)
    {
        $this->body = trim((string)$get_body);
        $this->sql_update_query .= ", body='" . addslashes($this->body) . "'";
    }

    public function set_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = (int)$get_main_user_login_id;
        $val = ($this->main_user_login_id > 0) ? "'" . $this->main_user_login_id . "'" : "NULL";
        $this->sql_update_query .= ", main_user_login_id=" . $val;
    }

    public function set_image_pth($get_image_pth)
    {
        $this->image_pth = trim((string)$get_image_pth);
        $this->sql_update_query .= ", image_pth='" . addslashes($this->image_pth) . "'";
    }

    public function set_ast($get_ast)
    {
        $this->ast = ((int)$get_ast === 1 || $get_ast === true || $get_ast === '1') ? '1' : '0';
        $this->sql_update_query .= ", ast='" . $this->ast . "'";
    }

    public function remove()
    {
        $this->ast = "0";
        $this->sql_update_query .= ", ast='0'";
    }

    public function get_error()
    {
        return $this->error_msg;
    }

    public function process_new_record()
    {
        $data_base_obj = new DataBase();
        $main_user_login_sql = ($this->main_user_login_id > 0)
            ? "'" . (int)$this->main_user_login_id . "'"
            : "NULL";

        $get_sql_query = "INSERT INTO notifications (
            type,
            title,
            body,
            ast,
            sdt,
            main_user_login_id,
            image_pth
        ) VALUES ("
            . "'" . addslashes($this->type) . "', "
            . "'" . addslashes($this->title) . "', "
            . "'" . addslashes($this->body) . "', "
            . "'" . addslashes($this->ast) . "', "
            . "'" . addslashes($this->sdt) . "', "
            . $main_user_login_sql . ", "
            . "'" . addslashes($this->image_pth) . "'"
            . ");";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        $this->id = (int) $data_base_obj->get_id();

        if ($this->id <= 0 && $data_base_obj->get_error_state_boolean()) {
            $lastIdResult = $data_base_obj->get_result("SELECT LAST_INSERT_ID() AS id");
            if ($lastIdResult && ($lastIdRow = $lastIdResult->fetch_assoc())) {
                $this->id = (int) $lastIdRow['id'];
            }
        }

        if ($this->id <= 0 && $data_base_obj->get_error_state_boolean()) {
            $lookup = $data_base_obj->get_result(
                "SELECT id FROM notifications
                 WHERE type='" . addslashes($this->type) . "'
                 AND title='" . addslashes($this->title) . "'
                 AND sdt='" . addslashes($this->sdt) . "'
                 ORDER BY id DESC
                 LIMIT 1"
            );
            if ($lookup && $row = $lookup->fetch_assoc()) {
                $this->id = (int) $row['id'];
            }
        }

        return $data_base_obj->get_error_state_boolean() && $this->id > 0;
    }

    public function process_update()
    {
        if ($this->id <= 0) {
            $this->error_msg = "Notification ID is required for update.";
            return false;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE notifications SET ast='" . $this->ast . "'" . $this->sql_update_query . " WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_remove()
    {
        if ($this->id <= 0) {
            $this->error_msg = "Notification ID is required for deletion.";
            return false;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE notifications SET ast='0' WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }
}
