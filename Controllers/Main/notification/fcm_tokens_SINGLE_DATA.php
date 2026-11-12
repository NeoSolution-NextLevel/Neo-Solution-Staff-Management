<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class fcm_tokens_SINGLE_DATA
{
    private $id;
    private $token;
    private $platform;
    private $sdt;
    private $ast;
    private $user_role;
    private $main_user_login_id;
    private $user_name;
    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        if ($this->id <= 0) {
            $this->state_of_data = false;
            return;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT f.*, u.user_name
                          FROM fcm_tokens f
                          LEFT JOIN main_user_login u ON u.id = f.main_user_login_id
                          WHERE f.id = '" . $this->id . "' LIMIT 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id                 = (int)$row['id'];
                $this->token              = $row['token'];
                $this->platform           = $row['platform'];
                $this->sdt                = $row['sdt'];
                $this->ast                = $row['ast'];
                $this->user_role          = $row['user_role'];
                $this->main_user_login_id = (int)$row['main_user_login_id'];
                $this->user_name          = $row['user_name'] ?? null;
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

    public function get_token()
    {
        return $this->token;
    }

    public function get_platform()
    {
        return $this->platform;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_user_role()
    {
        return $this->user_role;
    }

    public function get_main_user_login_id()
    {
        return $this->main_user_login_id;
    }

    public function get_user_name()
    {
        return $this->user_name;
    }

    public function get_data_array()
    {
        if (!$this->state_of_data) {
            return [];
        }

        return [
            'id'                 => $this->id,
            'token'              => $this->token,
            'platform'           => $this->platform,
            'sdt'                => $this->sdt,
            'ast'                => $this->ast,
            'user_role'          => $this->user_role,
            'main_user_login_id' => $this->main_user_login_id,
            'user_name'          => $this->user_name
        ];
    }
}

