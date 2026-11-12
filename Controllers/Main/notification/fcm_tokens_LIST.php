<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class fcm_tokens_LIST
{
    private $start_point = 0;
    private $data_limit = 100;
    private $search_text = '';
    private $user_id = 0;
    private $platform = '';
    private $user_role = '';
    private $ast = '1';

    public function set_data_limits($start_point, $per_page_data_count)
    {
        $this->start_point = max(0, (int) $start_point);
        $this->data_limit = max(1, (int) $per_page_data_count);
    }

    public function set_data_limit($get_limit)
    {
        $this->set_data_limits(0, $get_limit);
    }

    public function set_search_text($get_search_text)
    {
        $this->search_text = trim((string)$get_search_text);
    }

    public function filter_by_user_id($get_user_id)
    {
        $this->user_id = (int)$get_user_id;
    }

    public function filter_by_platform($get_platform)
    {
        $this->platform = trim((string)$get_platform);
    }

    public function filter_by_role($get_role)
    {
        $this->user_role = trim((string)$get_role);
    }

    public function set_ast($get_ast)
    {
        $this->ast = ((int)$get_ast === 1 || $get_ast === true || $get_ast === '1') ? '1' : '0';
    }

    public function get_user_ids()
    {
        return $this->get_ids_from_query("select distinct main_user_login_id as id from fcm_tokens where ast='1'");
    }

    public function get_all_member_user_ids()
    {
        return $this->get_ids_from_query("select main_user_login_id as id from member_list where ast='1' and main_user_login_id > 0");
    }

    public function get_all_manager_user_ids()
    {
        return $this->get_ids_from_query("select main_user_login_id as id from managers_list where ast='1' and main_user_login_id > 0");
    }

    public function get_all_cash_owner_user_ids()
    {
        return $this->get_ids_from_query("select main_user_login_id as id from cash_owner_list where ast='1' and main_user_login_id > 0");
    }

    public function get_all_member_ids()
    {
        return $this->get_all_member_user_ids();
    }

    public function get_cash_owner_member_user_ids($cash_owner_id)
    {
        $co_id = (int)$cash_owner_id;
        $sql = "select main_user_login_id as id from member_list where ast='1' and main_user_login_id > 0";
        if ($co_id > 0) {
            $sql .= " and cash_owner_list_id='" . $co_id . "'";
        }
        return $this->get_ids_from_query($sql);
    }

    public function get_cash_owner_manager_user_ids($cash_owner_id)
    {
        $co_id = (int)$cash_owner_id;
        $sql = "select main_user_login_id as id from managers_list where ast='1' and main_user_login_id > 0";
        if ($co_id > 0) {
            $sql .= " and cash_owner_list_id='" . $co_id . "'";
        }
        return $this->get_ids_from_query($sql);
    }

    public function get_cash_owner_member_ids($cash_owner_id)
    {
        return $this->get_cash_owner_member_user_ids($cash_owner_id);
    }

    public function get_cash_owner_manager_ids($cash_owner_id)
    {
        return $this->get_cash_owner_manager_user_ids($cash_owner_id);
    }

    public function get_cash_owner_all_recipient_ids($cash_owner_id)
    {
        $mem_ids = $this->get_cash_owner_member_user_ids($cash_owner_id);
        $mgr_ids = $this->get_cash_owner_manager_user_ids($cash_owner_id);
        return array_values(array_unique(array_merge($mem_ids, $mgr_ids)));
    }

    public function get_manager_assigned_member_ids($manager_id)
    {
        $mgr_id = (int)$manager_id;
        if ($mgr_id <= 0) {
            return [];
        }
        $sql = "select m.main_user_login_id as id 
                from member_manager mm
                inner join member_list m on m.id = mm.member_list_id
                where mm.ast='1' and m.ast='1' and mm.managers_list_id='" . $mgr_id . "' and m.main_user_login_id > 0";
        return $this->get_ids_from_query($sql);
    }

    public function get_tokens_from_user_ids(array $get_user_ids)
    {
        $user_ids = array_values(array_unique(array_filter(array_map('intval', $get_user_ids))));
        if (!$user_ids) {
            return [];
        }

        $data_base_obj = new DataBase();
        $in_clause = implode(',', $user_ids);
        $get_sql_query = "select token from fcm_tokens 
                          where ast='1' 
                          and main_user_login_id in (" . $in_clause . ")";
        $result = $data_base_obj->get_result($get_sql_query);
        $tokens = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['token'])) {
                    $tokens[] = $row['token'];
                }
            }
        }

        return array_values(array_unique(array_filter($tokens)));
    }

    public function get_tokens_from_member_ids(array $get_member_ids)
    {
        $member_ids = array_values(array_unique(array_filter(array_map('intval', $get_member_ids))));
        if (!$member_ids) {
            return [];
        }
        $data_base_obj = new DataBase();
        $in_clause = implode(',', $member_ids);

        // First check directly as main_user_login_id
        $tokens1 = $this->get_tokens_from_user_ids($member_ids);

        // Also check if they are member_list.id
        $q = "select main_user_login_id from member_list where id in (" . $in_clause . ") and ast='1' and main_user_login_id > 0";
        $res = $data_base_obj->get_result($q);
        $resolved_uids = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $resolved_uids[] = (int) $row['main_user_login_id'];
            }
        }
        $tokens2 = $resolved_uids ? $this->get_tokens_from_user_ids($resolved_uids) : [];

        return array_values(array_unique(array_merge($tokens1, $tokens2)));
    }

    public function get_tokens_from_role($role)
    {
        $role = trim((string) $role);
        if ($role === '') {
            return [];
        }
        $data_base_obj = new DataBase();
        $sql = "select token from fcm_tokens where ast='1' and user_role='" . addslashes($role) . "'";
        $result = $data_base_obj->get_result($sql);
        $tokens = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['token'])) {
                    $tokens[] = $row['token'];
                }
            }
        }
        return array_values(array_unique(array_filter($tokens)));
    }

    public function get_all_tokens()
    {
        $data_base_obj = new DataBase();
        $result = $data_base_obj->get_result("select token from fcm_tokens where ast='1'");
        $tokens = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['token'])) {
                    $tokens[] = $row['token'];
                }
            }
        }
        return array_values(array_unique(array_filter($tokens)));
    }

    public function get_tokens_for_target($member_list_id = 0, $main_user_login_id = 0)
    {
        $mem_id = (int) $member_list_id;
        $u_id = (int) $main_user_login_id;

        if ($u_id > 0) {
            return $this->get_tokens_from_user_ids([$u_id]);
        }
        if ($mem_id > 0) {
            return $this->get_tokens_from_member_ids([$mem_id]);
        }
        return [];
    }

    public function get_audience_member_ids($get_audience_key)
    {
        $key = trim((string) $get_audience_key);
        if ($key === '' || $key === 'all') {
            $mems = $this->get_all_member_user_ids();
            $mgrs = $this->get_all_manager_user_ids();
            $owners = $this->get_all_cash_owner_user_ids();
            return array_values(array_unique(array_merge($mems, $mgrs, $owners)));
        }

        if ($key === 'members' || $key === 'member' || $key === 'payment' || $key === 'expense' || $key === 'check' || $key === 'check_due') {
            return $this->get_all_member_user_ids();
        }

        if ($key === 'managers' || $key === 'manager') {
            return $this->get_all_manager_user_ids();
        }

        if ($key === 'cash_owners' || $key === 'cash_owner') {
            return $this->get_all_cash_owner_user_ids();
        }

        return $this->get_all_member_user_ids();
    }

    public function get_subscription_member_ids($get_subscription_id)
    {
        return $this->get_audience_member_ids($get_subscription_id);
    }

    private function get_ids_from_query($get_sql_query)
    {
        $data_base_obj = new DataBase();
        $result = $data_base_obj->get_result($get_sql_query);
        $ids = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $id = (int) ($row['id'] ?? $row['main_user_login_id'] ?? $row['member_list_id'] ?? 0);
                if ($id > 0) {
                    $ids[] = $id;
                }
            }
        }

        return array_values(array_unique(array_filter($ids)));
    }

    private function get_filter_sql()
    {
        $sql = "";
        if ($this->user_id > 0) {
            $sql .= " and f.main_user_login_id='" . (int)$this->user_id . "'";
        }
        if ($this->platform !== '') {
            $sql .= " and f.platform='" . addslashes($this->platform) . "'";
        }
        if ($this->user_role !== '') {
            $sql .= " and f.user_role='" . addslashes($this->user_role) . "'";
        }
        if ($this->search_text !== '') {
            $s = addslashes($this->search_text);
            $sql .= " and (f.token like '%" . $s . "%' or f.user_role like '%" . $s . "%' or u.user_name like '%" . $s . "%')";
        }
        return $sql;
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();
        $get_sql_query = "select f.id, f.token, f.platform, f.sdt, f.ast, f.user_role, f.main_user_login_id,
                                 u.user_name, u.first_name, u.last_name
                          from fcm_tokens f
                          left join main_user_login u on u.id = f.main_user_login_id
                          where f.ast='" . addslashes($this->ast) . "'
                          " . $this->get_filter_sql() . "
                          order by f.sdt desc, f.id desc
                          limit " . (int)$this->start_point . ", " . (int)$this->data_limit;

        return $data_base_obj->get_result($get_sql_query);
    }

    public function get_tokens_array()
    {
        $result = $this->get_result();
        $items = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = [
                    'id'                 => (int)$row['id'],
                    'token'              => $row['token'],
                    'platform'           => $row['platform'],
                    'sdt'                => $row['sdt'],
                    'ast'                => (int)$row['ast'],
                    'user_role'          => $row['user_role'],
                    'main_user_login_id' => (int)$row['main_user_login_id'],
                    'user_name'          => $row['user_name'] ?? null,
                    'first_name'         => $row['first_name'] ?? null,
                    'last_name'          => $row['last_name'] ?? null
                ];
            }
        }

        return $items;
    }

    public function get_count()
    {
        $data_base_obj = new DataBase();
        $result = $data_base_obj->get_result(
            "select count(f.id) as total_count from fcm_tokens f left join main_user_login u on u.id = f.main_user_login_id where f.ast='" . addslashes($this->ast) . "' " . $this->get_filter_sql()
        );

        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['total_count'];
        }

        return 0;
    }

    public function get_total_count()
    {
        return $this->get_count();
    }
}
