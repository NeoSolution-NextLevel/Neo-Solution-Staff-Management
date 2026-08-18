<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class notifications_LIST
{
    private $sql_search_data = "";
    private $sql_process_data = "*";
    private $pagination_data_result = "";
    private $ast_state = "1";

    public function filter_by_role($role)
    {
        $this->sql_search_data .= " AND (recipient_role='" . addslashes($role) . "' OR recipient_role='all' OR recipient_role IS NULL)";
    }

    public function filter_by_is_read($is_read)
    {
        $this->sql_search_data .= " AND is_read='" . (int)$is_read . "'";
    }

    public function filter_by_type($type)
    {
        $this->sql_search_data .= " AND type='" . addslashes($type) . "'";
    }

    public function get_count_report()
    {
        $this->sql_process_data = "COUNT(id)";
    }

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->pagination_data_result = " ORDER BY id DESC LIMIT " . (int)$start_point . ", " . (int)$per_page_data_count;
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT " . $this->sql_process_data .
            " FROM system_notifications WHERE 1=1 " .
            $this->sql_search_data .
            $this->pagination_data_result;

        return $data_base_obj->get_result($get_sql_query);
    }
}

if (!class_exists('notifications_details_LIST')) {
    class notifications_details_LIST extends notifications_LIST {}
}
?>
