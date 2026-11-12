<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notification_inbox_LIST
{
    private $main_user_login_id = 0;
    private $start_point = 0;
    private $data_limit = 100;
    private $unread_only = false;
    private $search_text = '';

    public function set_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = (int) $get_main_user_login_id;
    }

    public function set_user_id($get_user_id)
    {
        $this->main_user_login_id = (int) $get_user_id;
    }

    public function set_member_list_id($get_member_list_id)
    {
        $mem_id = (int) $get_member_list_id;
        if ($mem_id <= 0) {
            return;
        }
        $db = new DataBase();
        $res = $db->get_result("select main_user_login_id from member_list where id='" . $mem_id . "' limit 1");
        if ($res && $row = $res->fetch_assoc()) {
            $this->main_user_login_id = (int) $row['main_user_login_id'];
        } else {
            $this->main_user_login_id = $mem_id;
        }
    }

    public function set_unread_only($flag = true)
    {
        $this->unread_only = (bool)$flag;
    }

    public function set_search_text($text)
    {
        $this->search_text = trim((string)$text);
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->start_point = max(0, (int) $start_point);
        $this->data_limit = max(1, (int) $per_page_data_count);
    }

    public function set_data_limit($get_limit)
    {
        $this->set_data_limits(0, $get_limit);
    }

    private function get_search_sql()
    {
        if ($this->search_text === '') {
            return '';
        }
        $s = addslashes($this->search_text);
        return " and (n.title like '%" . $s . "%' or n.body like '%" . $s . "%' or n.type like '%" . $s . "%')";
    }

    private function get_user_sql()
    {
        if ($this->main_user_login_id <= 0) {
            return '';
        }
        return " and i.main_user_login_id='" . (int)$this->main_user_login_id . "'";
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $unread_sql = $this->unread_only ? " and i.is_read='0'" : "";

        $get_sql_query = "select i.id as inbox_id,
                          n.id,
                          n.type,
                          n.title,
                          n.body,
                          n.image_pth,
                          n.sdt as created_at,
                          i.sdt as inbox_sdt,
                          i.is_read,
                          i.main_user_login_id
                          from notification_inbox i
                          inner join notifications n on n.id = i.notifications_id
                          where i.ast='1'
                          and n.ast='1'
                          " . $this->get_user_sql() . "
                          " . $unread_sql . "
                          " . $this->get_search_sql() . "
                          order by n.sdt desc, n.id desc, i.id desc
                          limit " . (int)$this->start_point . ", " . (int)$this->data_limit;

        return $data_base_obj->get_result($get_sql_query);
    }

    public function get_notifications_array()
    {
        $result = $this->get_result();
        $items = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = [
                    'inbox_id'           => (int) $row['inbox_id'],
                    'id'                 => (int) $row['id'],
                    'notification_id'    => (int) $row['id'],
                    'type'               => $row['type'],
                    'title'              => $row['title'],
                    'body'               => $row['body'],
                    'message'            => $row['body'],
                    'subscription_id'    => $row['type'],
                    'image_pth'          => $row['image_pth'],
                    'is_read'            => (int) $row['is_read'] === 1,
                    'created_at'         => $row['created_at'],
                    'sdt'                => $row['created_at'],
                    'inbox_sdt'          => $row['inbox_sdt'],
                    'main_user_login_id' => (int) $row['main_user_login_id']
                ];
            }
        }

        return $items;
    }

    public function get_total_count()
    {
        $data_base_obj = new DataBase();
        $unread_sql = $this->unread_only ? " and i.is_read='0'" : "";

        $query = "select count(i.id) as total_count 
                  from notification_inbox i 
                  inner join notifications n on n.id = i.notifications_id
                  where i.ast='1' 
                  and n.ast='1'
                  " . $this->get_user_sql() . "
                  " . $unread_sql . "
                  " . $this->get_search_sql();

        $result = $data_base_obj->get_result($query);
        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['total_count'];
        }
        return 0;
    }

    public function get_unread_count()
    {
        $data_base_obj = new DataBase();
        $query = "select count(i.id) as unread_count 
                  from notification_inbox i 
                  inner join notifications n on n.id = i.notifications_id
                  where i.ast='1' 
                  and n.ast='1'
                  and i.is_read='0'
                  " . $this->get_user_sql();

        $result = $data_base_obj->get_result($query);
        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['unread_count'];
        }
        return 0;
    }
}
