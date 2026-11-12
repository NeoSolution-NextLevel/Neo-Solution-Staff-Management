<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class fcm_tokens_ADD_UPDATE
{
    private $id;
    private $main_user_login_id = 0;
    private $user_role = 'member';
    private $token = '';
    private $platform = 'android';
    private $ast = "1";
    private $sdt;
    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date("Y-m-d H:i:s");
    }

    public function set_data($get_main_user_login_id, $get_token, $get_platform = 'android', $get_user_role = 'member')
    {
        $this->main_user_login_id = (int) $get_main_user_login_id;
        $this->token = trim((string) $get_token);
        $this->platform = !empty($get_platform) ? trim((string)$get_platform) : 'android';
        $this->user_role = !empty($get_user_role) ? trim((string)$get_user_role) : 'member';
        $this->sdt = date("Y-m-d H:i:s");

        $this->sql_update_query =
            ", main_user_login_id='" . (int)$this->main_user_login_id . "'" .
            ", token='" . addslashes($this->token) . "'" .
            ", platform='" . addslashes($this->platform) . "'" .
            ", user_role='" . addslashes($this->user_role) . "'" .
            ", sdt='" . addslashes($this->sdt) . "'";
    }

    public function set_data_with_user($get_member_list_id, $get_token, $get_platform = 'android', $get_main_user_login_id = 0, $get_user_role = '')
    {
        $user_id = (int) $get_main_user_login_id;
        $member_id = (int) $get_member_list_id;
        $role = trim((string) $get_user_role);

        $db = new DataBase();

        // If user_id is 0 but member_list_id is given, resolve main_user_login_id
        if ($user_id <= 0 && $member_id > 0) {
            $res = $db->get_result("select main_user_login_id from member_list where ast='1' and id='" . $member_id . "' limit 1");
            if ($res && $row = $res->fetch_assoc()) {
                $user_id = (int) $row['main_user_login_id'];
                if ($role === '') $role = 'member';
            } else {
                $res_mgr = $db->get_result("select main_user_login_id from managers_list where ast='1' and id='" . $member_id . "' limit 1");
                if ($res_mgr && $row_mgr = $res_mgr->fetch_assoc()) {
                    $user_id = (int) $row_mgr['main_user_login_id'];
                    if ($role === '') $role = 'manager';
                } else {
                    $user_id = $member_id;
                }
            }
        }

        // If role is still empty, detect it from main_user_login
        if ($role === '' && $user_id > 0) {
            $u_res = $db->get_result("select ac_type, main_user_account_access_level_list_id from main_user_login where id='" . $user_id . "' limit 1");
            if ($u_res && $u_row = $u_res->fetch_assoc()) {
                $ac_type = strtolower(trim((string)$u_row['ac_type']));
                $access_level = (int)$u_row['main_user_account_access_level_list_id'];
                if ($ac_type === 'cash_owner' || $access_level === 2) {
                    $role = 'cash_owner';
                } elseif ($ac_type === 'manager' || $access_level === 3) {
                    $role = 'manager';
                } else {
                    $role = 'member';
                }
            } else {
                $role = 'member';
            }
        }

        if ($role === '') {
            $role = 'member';
        }

        $this->set_data($user_id, $get_token, $get_platform, $role);
    }

    public function set_id($get_id)
    {
        $this->id = (int)$get_id;
    }

    public function get_id()
    {
        return $this->id;
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
        if ($this->main_user_login_id <= 0 || $this->token === '') {
            $this->error_msg = 'Missing user login ID or token';
            return false;
        }

        $data_base_obj = new DataBase();
        $token = addslashes($this->token);
        $platform = addslashes($this->platform);
        $role = addslashes($this->user_role);
        $sdt = addslashes($this->sdt);
        $userId = (int) $this->main_user_login_id;

        $existingId = $this->find_id($data_base_obj, "select id from fcm_tokens where token='" . $token . "' limit 1");

        if ($existingId > 0) {
            $data_base_obj->get_result(
                "update fcm_tokens set token='" . $token . "', platform='" . $platform . "', sdt='" . $sdt . "', ast='1', user_role='" . $role . "', main_user_login_id='" . $userId . "' where id='" . $existingId . "'"
            );
            $this->id = $existingId;
        } else {
            $data_base_obj->get_result(
                "insert into fcm_tokens (token, platform, sdt, ast, user_role, main_user_login_id) values ('" . $token . "', '" . $platform . "', '" . $sdt . "', '1', '" . $role . "', '" . $userId . "')"
            );
            $this->id = (int) $data_base_obj->get_id();
        }

        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        if ($this->id <= 0) {
            $this->error_msg = "Token ID is required for update.";
            return false;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE fcm_tokens SET ast='" . $this->ast . "'" . $this->sql_update_query . " WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_remove()
    {
        if ($this->id <= 0) {
            $this->error_msg = "Token ID is required for deletion.";
            return false;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "UPDATE fcm_tokens SET ast='0' WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }

    public function deactivate_token($token)
    {
        $token = trim((string)$token);
        if ($token === '') {
            return false;
        }
        $data_base_obj = new DataBase();
        $data_base_obj->get_result("UPDATE fcm_tokens SET ast='0' WHERE token='" . addslashes($token) . "'");
        return $data_base_obj->get_error_state_boolean();
    }

    private function find_id(DataBase $data_base_obj, $sql)
    {
        $result = $data_base_obj->get_result($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['id'];
        }
        return 0;
    }
}
