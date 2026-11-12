<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notifications_SINGLE_DATA
{
    private $id;
    private $type;
    private $title;
    private $body;
    private $ast;
    private $sdt;
    private $main_user_login_id;
    private $image_pth;
    private $target_count = 0;
    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        if ($this->id <= 0) {
            $this->state_of_data = false;
            return;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT n.*,
                          (SELECT COUNT(id) FROM notification_inbox WHERE notifications_id=n.id AND ast='1') AS target_count
                          FROM notifications n
                          WHERE n.id = '" . $this->id . "' LIMIT 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id                 = (int)$row['id'];
                $this->type               = $row['type'];
                $this->title              = $row['title'];
                $this->body               = $row['body'];
                $this->ast                = $row['ast'];
                $this->sdt                = $row['sdt'];
                $this->main_user_login_id = $row['main_user_login_id'] !== null ? (int)$row['main_user_login_id'] : null;
                $this->image_pth          = $row['image_pth'];
                $this->target_count       = isset($row['target_count']) ? (int)$row['target_count'] : 0;
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

    public function get_type()
    {
        return $this->type;
    }

    public function get_title()
    {
        return $this->title;
    }

    public function get_body()
    {
        return $this->body;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_main_user_login_id()
    {
        return $this->main_user_login_id;
    }

    public function get_image_pth()
    {
        return $this->image_pth;
    }

    public function get_target_count()
    {
        return $this->target_count;
    }

    public function get_data_array()
    {
        if (!$this->state_of_data) {
            return [];
        }

        return [
            'id'                 => $this->id,
            'type'               => $this->type,
            'title'              => $this->title,
            'body'               => $this->body,
            'message'            => $this->body,
            'ast'                => $this->ast,
            'sdt'                => $this->sdt,
            'main_user_login_id' => $this->main_user_login_id,
            'image_pth'          => $this->image_pth,
            'target_count'       => $this->target_count,
            'audience'           => $this->type === 'all' ? 'all_members' : $this->type,
            'subscription_id'    => $this->type
        ];
    }
}

