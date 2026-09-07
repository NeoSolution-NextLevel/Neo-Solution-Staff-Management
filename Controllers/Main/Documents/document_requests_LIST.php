<?php
/**
 * document_requests_LIST.php
 * Query builder for listing document requests.
 */
include_once __DIR__ . '/../../../imports/need/DB.php';

class document_requests_LIST
{
    private $sql_search  = '';
    private $sql_orderby = ' ORDER BY id DESC';
    private $sql_limit   = '';

    public function filter_by_ast($v = '1')
    {
        $this->sql_search .= " AND ast='" . addslashes($v) . "'";
    }

    public function filter_by_status($v)
    {
        $this->sql_search .= " AND status='" . addslashes($v) . "'";
    }

    public function filter_by_target_employee_user_id($v)
    {
        $this->sql_search .= " AND target_employee_user_id='" . (int)$v . "'";
    }

    public function filter_by_requested_by_user_id($v)
    {
        $this->sql_search .= " AND requested_by_user_id='" . (int)$v . "'";
    }

    public function filter_by_doc_type($v)
    {
        $this->sql_search .= " AND doc_type='" . addslashes($v) . "'";
    }

    /** Only rows where status is NOT one of the excluded values */
    public function filter_exclude_status($v)
    {
        $this->sql_search .= " AND status != '" . addslashes($v) . "'";
    }

    public function set_limit($start, $count)
    {
        $this->sql_limit = ' LIMIT ' . (int)$start . ', ' . (int)$count;
    }

    public function get_result()
    {
        $db  = new DataBase();
        $sql = "SELECT * FROM `document_requests` WHERE 1=1"
             . $this->sql_search
             . $this->sql_orderby
             . $this->sql_limit;
        return $db->get_result($sql);
    }

    public function get_as_array()
    {
        $res  = $this->get_result();
        $list = [];
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>
