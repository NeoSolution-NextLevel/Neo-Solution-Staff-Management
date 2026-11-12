<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notification_inbox_ADD_UPDATE
{
    private $id;
    private $notifications_id = 0;
    private $main_user_login_id = 0;
    private $is_read = 0;
    private $ast = "1";
    private $sdt;
    private $error_msg;
    private $processed_count = 0;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data($get_notifications_id, $get_main_user_login_id, $get_is_read = 0)
    {
        $this->notifications_id = (int) $get_notifications_id;
        $this->main_user_login_id = (int) $get_main_user_login_id;
        $this->is_read = ((int)$get_is_read === 1 || $get_is_read === true || $get_is_read === '1') ? 1 : 0;

        $this->sql_update_query =
            ", notifications_id='" . (int)$this->notifications_id . "'" .
            ", main_user_login_id='" . (int)$this->main_user_login_id . "'" .
            ", is_read='" . (int)$this->is_read . "'";
    }

    public function set_id($get_id)
    {
        $this->id = (int)$get_id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_notifications_id($get_notifications_id)
    {
        $this->notifications_id = (int)$get_notifications_id;
        $this->sql_update_query .= ", notifications_id='" . $this->notifications_id . "'";
    }

    public function set_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = (int)$get_main_user_login_id;
        $this->sql_update_query .= ", main_user_login_id='" . $this->main_user_login_id . "'";
    }

    public function set_is_read($get_is_read)
    {
        $this->is_read = ((int)$get_is_read === 1 || $get_is_read === true || $get_is_read === '1') ? 1 : 0;
        $this->sql_update_query .= ", is_read='" . $this->is_read . "'";
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

    public function get_processed_count()
    {
        return $this->processed_count;
    }

    public function process_new_record()
    {
        if ($this->notifications_id <= 0 || $this->main_user_login_id <= 0) {
            $this->error_msg = 'Notification ID and user login ID are required.';
            return false;
        }

        $data_base_obj = new DataBase();

        // Check if a record already exists for this notification and user
        $check_sql = "SELECT id FROM notification_inbox 
                      WHERE notifications_id='" . (int)$this->notifications_id . "' 
                      AND main_user_login_id='" . (int)$this->main_user_login_id . "' 
                      LIMIT 1";
        $check_res = $data_base_obj->get_result($check_sql);

        if ($check_res && $row = $check_res->fetch_assoc()) {
            $this->id = (int)$row['id'];
            $update_sql = "UPDATE notification_inbox 
                           SET ast='1', sdt='" . addslashes($this->sdt) . "' 
                           WHERE id='" . $this->id . "'";
            $data_base_obj->get_result($update_sql);
            $this->error_msg = $data_base_obj->get_error();
            return $data_base_obj->get_error_state_boolean();
        }

        $get_sql_query = "INSERT INTO notification_inbox (
            is_read,
            sdt,
            ast,
            notifications_id,
            main_user_login_id
        ) VALUES ("
            . "'" . (int)$this->is_read . "', "
            . "'" . addslashes($this->sdt) . "', "
            . "'" . addslashes($this->ast) . "', "
            . "'" . (int)$this->notifications_id . "', "
            . "'" . (int)$this->main_user_login_id . "'"
            . ");";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        $this->id = (int)$data_base_obj->get_id();

        if ($this->id <= 0 && $data_base_obj->get_error_state_boolean()) {
            $lastIdResult = $data_base_obj->get_result("SELECT LAST_INSERT_ID() AS id");
            if ($lastIdResult && ($lastIdRow = $lastIdResult->fetch_assoc())) {
                $this->id = (int)$lastIdRow['id'];
            }
        }

        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        if ($this->id <= 0) {
            $this->error_msg = "Inbox ID is required for update.";
            return false;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE notification_inbox SET ast='" . $this->ast . "'" . $this->sql_update_query . " WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_remove()
    {
        if ($this->id <= 0) {
            $this->error_msg = "Inbox ID is required for deletion.";
            return false;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE notification_inbox SET ast='0' WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_user_list($get_notification_id, array $get_user_ids)
    {
        $state = true;
        $first_error = '';
        $this->processed_count = 0;
        foreach (array_unique(array_map('intval', $get_user_ids)) as $user_id) {
            if ($user_id <= 0) {
                continue;
            }
            $this->set_data($get_notification_id, $user_id);
            if ($this->process_new_record()) {
                $this->processed_count++;
            } else {
                $state = false;
                if ($first_error === '') {
                    $first_error = (string) $this->error_msg;
                }
            }
        }
        if (!$state) {
            $this->error_msg = $first_error;
        }
        return $state;
    }

    public function process_member_list($get_notification_id, array $get_user_or_member_ids)
    {
        return $this->process_user_list($get_notification_id, $get_user_or_member_ids);
    }

    public function mark_read($get_notification_id, $get_main_user_login_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "UPDATE notification_inbox 
                          SET is_read='1' 
                          WHERE notifications_id='" . (int)$get_notification_id . "' 
                          AND main_user_login_id='" . (int)$get_main_user_login_id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function mark_read_by_id($get_inbox_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "UPDATE notification_inbox 
                          SET is_read='1' 
                          WHERE id='" . (int)$get_inbox_id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function mark_all_read($get_main_user_login_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "UPDATE notification_inbox 
                          SET is_read='1' 
                          WHERE main_user_login_id='" . (int)$get_main_user_login_id . "' 
                          AND ast='1'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function remove_by_id($get_inbox_id)
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "UPDATE notification_inbox 
                          SET ast='0' 
                          WHERE id='" . (int)$get_inbox_id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }
}
