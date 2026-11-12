<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notification_inbox_SINGLE_DATA
{
    private $id;
    private $is_read;
    private $sdt;
    private $ast;
    private $notifications_id;
    private $main_user_login_id;

    // Joined notifications table data
    private $type;
    private $title;
    private $body;
    private $image_pth;
    private $notification_sdt;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        if ($this->id <= 0) {
            $this->state_of_data = false;
            return;
        }

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT i.id, i.is_read, i.sdt, i.ast, i.notifications_id, i.main_user_login_id,
                                 n.type, n.title, n.body, n.image_pth, n.sdt AS notification_sdt
                          FROM notification_inbox i
                          INNER JOIN notifications n ON n.id = i.notifications_id
                          WHERE i.id = '" . $this->id . "' LIMIT 1";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id                 = (int)$row['id'];
                $this->is_read            = (int)$row['is_read'];
                $this->sdt                = $row['sdt'];
                $this->ast                = $row['ast'];
                $this->notifications_id   = (int)$row['notifications_id'];
                $this->main_user_login_id = (int)$row['main_user_login_id'];
                $this->type               = $row['type'];
                $this->title              = $row['title'];
                $this->body               = $row['body'];
                $this->image_pth          = $row['image_pth'];
                $this->notification_sdt   = $row['notification_sdt'];
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

    public function get_is_read()
    {
        return $this->is_read;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_notifications_id()
    {
        return $this->notifications_id;
    }

    public function get_main_user_login_id()
    {
        return $this->main_user_login_id;
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

    public function get_image_pth()
    {
        return $this->image_pth;
    }

    public function get_notification_sdt()
    {
        return $this->notification_sdt;
    }

    public function get_data_array()
    {
        if (!$this->state_of_data) {
            return [];
        }

        return [
            'id'                 => $this->id,
            'inbox_id'           => $this->id,
            'notifications_id'   => $this->notifications_id,
            'notification_id'    => $this->notifications_id,
            'main_user_login_id' => $this->main_user_login_id,
            'is_read'            => $this->is_read === 1,
            'type'               => $this->type,
            'title'              => $this->title,
            'body'               => $this->body,
            'message'            => $this->body,
            'subscription_id'    => $this->type,
            'image_pth'          => $this->image_pth,
            'created_at'         => $this->notification_sdt,
            'sdt'                => $this->sdt,
            'ast'                => $this->ast
        ];
    }
}

