<?php

include_once __DIR__ . '/../../imports/need/DB.php';

class notifications_LIST
{
    private $start_point = 0;
    private $data_limit = 100;
    private $search_text = '';
    private $audience_filter = 'all';
    private $sort_key = 'newest';
    private $main_user_login_id = 0;
    private $cash_owner_id = 0;
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

    public function filter_by_main_user_login_id($get_main_user_login_id)
    {
        $this->main_user_login_id = (int)$get_main_user_login_id;
    }

    public function filter_by_cash_owner_id($get_cash_owner_id)
    {
        $this->cash_owner_id = (int)$get_cash_owner_id;
    }

    public function set_ast($get_ast)
    {
        $this->ast = ((int)$get_ast === 1 || $get_ast === true || $get_ast === '1') ? '1' : '0';
    }

    public function set_audience_filter($get_audience_filter)
    {
        $allowed_filters = [
            'all',
            'all_members',
            'specific_member',
            'members',
            'member',
            'managers',
            'manager',
            'assigned_members',
            'payment',
            'disbursement',
            'payment_collected',
            'expense',
            'expense_status',
            'check',
            'check_due',
            'user',
            'user_created',
            'auto',
            'automatic',
            'subscription',
            'cash_owners',
            'cash_owner'
        ];
        $audience_filter = trim((string) $get_audience_filter);
        $this->audience_filter = in_array($audience_filter, $allowed_filters, true) ? $audience_filter : 'all';
    }

    public function set_sort_key($get_sort_key)
    {
        $allowed_sorts = ['newest', 'oldest', 'title_az', 'title_za', 'recipients_high', 'recipients_low'];
        $sort_key = trim((string) $get_sort_key);
        $this->sort_key = in_array($sort_key, $allowed_sorts, true) ? $sort_key : 'newest';
    }

    private function get_search_sql()
    {
        if ($this->search_text === '') {
            return '';
        }

        $search_text = addslashes($this->search_text);
        return " and (n.title like '%" . $search_text . "%' or n.body like '%" . $search_text . "%' or n.type like '%" . $search_text . "%')";
    }

    private function get_user_sql()
    {
        if ($this->main_user_login_id <= 0) {
            return '';
        }
        return " and n.main_user_login_id='" . (int)$this->main_user_login_id . "'";
    }

    private function get_cash_owner_sql()
    {
        if ($this->cash_owner_id <= 0) {
            return '';
        }

        $co_id = (int)$this->cash_owner_id;
        return " and (
            n.main_user_login_id = '{$co_id}'
            or n.main_user_login_id in (select main_user_login_id from cash_owner_list where id = '{$co_id}')
            or exists (
                select 1 from notification_inbox ni 
                inner join member_list ml on ml.main_user_login_id = ni.main_user_login_id 
                where ni.notifications_id = n.id and (ml.cash_owner_list_id = '{$co_id}' or ml.cash_owner_list_id in (select id from cash_owner_list where main_user_login_id = '{$co_id}'))
            )
            or exists (
                select 1 from notification_inbox ni 
                where ni.notifications_id = n.id and (ni.main_user_login_id = '{$co_id}' or ni.main_user_login_id in (select main_user_login_id from cash_owner_list where id = '{$co_id}'))
            )
            or n.type in ('all', 'all_members')
        )";
    }

    private function get_audience_sql()
    {
        switch ($this->audience_filter) {
            case 'all':
                return '';
            case 'specific_member':
            case 'member':
                return " and (n.type='specific_member' or n.type='member')";
            case 'all_members':
                return " and (n.type='all' or n.type='broadcast' or n.type='all_members' or n.type='members')";
            case 'members':
                return " and (n.type='members' or n.type='member' or n.type='specific_member' or n.type='all_members')";
            case 'managers':
            case 'manager':
                return " and (n.type='managers' or n.type='manager')";
            case 'cash_owners':
            case 'cash_owner':
                return " and (n.type='cash_owners' or n.type='cash_owner')";
            case 'assigned_members':
                return " and n.type='assigned_members'";
            case 'payment':
            case 'disbursement':
                return " and (n.type='payment' or n.type='disbursement' or (n.type='auto' and (n.title like '%payment%' or n.title like '%disburs%' or n.title like '%float%' or n.title like '%money%')))";
            case 'payment_collected':
                return " and (n.type='payment_collected' or (n.type='auto' and (n.title like '%collect%' or n.title like '%return%')))";
            case 'expense':
                return " and (n.type='expense' or n.type='expense_submitted' or (n.type='auto' and (n.title like '%expense%' or n.title like '%claim%')))";
            case 'expense_status':
                return " and (n.type='expense_status_changed' or (n.type='auto' and (n.title like '%approved%' or n.title like '%rejected%' or n.title like '%status%')))";
            case 'check':
            case 'check_due':
                return " and (n.type='check' or n.type='check_due' or n.type='scheduled_check' or (n.type='auto' and (n.title like '%cheque%' or n.title like '%check%')))";
            case 'user':
            case 'user_created':
                return " and (n.type='user' or n.type='user_created' or (n.type='auto' and (n.title like '%welcome%' or n.title like '%account%')))";
            case 'automatic':
            case 'auto':
                return " and (n.type in ('auto', 'payment', 'disbursement', 'payment_collected', 'expense', 'expense_submitted', 'expense_status_changed', 'check', 'check_due', 'scheduled_check', 'user', 'user_created'))";
            case 'subscription':
                return " and n.type='subscription'";
            default:
                return '';
        }
    }

    private function get_filter_sql()
    {
        return $this->get_search_sql() . $this->get_user_sql() . $this->get_audience_sql() . $this->get_cash_owner_sql();
    }

    private function get_order_sql()
    {
        switch ($this->sort_key) {
            case 'oldest':
                return ' order by n.sdt asc, n.id asc';
            case 'title_az':
                return ' order by n.title asc, n.sdt desc';
            case 'title_za':
                return ' order by n.title desc, n.sdt desc';
            case 'recipients_high':
                return ' order by target_count desc, n.sdt desc';
            case 'recipients_low':
                return ' order by target_count asc, n.sdt desc';
            case 'newest':
            default:
                return ' order by n.sdt desc, n.id desc';
        }
    }

    public function get_result()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "select n.id, n.type, n.title, n.body, n.image_pth, n.main_user_login_id, n.sdt, n.ast,
                          (select count(id) from notification_inbox where notifications_id=n.id and ast='1') as target_count,
                          (select ml.name_M from notification_inbox ni inner join member_list ml on ml.main_user_login_id = ni.main_user_login_id where ni.notifications_id=n.id and ni.ast='1' limit 1) as recipient_member_name
                          from notifications n
                          where n.ast='" . addslashes($this->ast) . "'
                          " . $this->get_filter_sql() . "
                          " . $this->get_order_sql() . "
                          limit " . (int)$this->start_point . ", " . (int)$this->data_limit;

        return $data_base_obj->get_result($get_sql_query);
    }

    public function get_notifications_array()
    {
        $result = $this->get_result();
        $items = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $recipient_name = !empty($row['recipient_member_name']) ? trim($row['recipient_member_name']) : '';
                $type = $row['type'];
                $title_lower = strtolower($row['title']);
                $audience_label = 'All Members';

                if ($type === 'specific_member' || $type === 'member') {
                    $audience_label = $recipient_name ? $recipient_name : 'Specific Member';
                } elseif ($type === 'payment' || $type === 'disbursement') {
                    $audience_label = 'Auto: Payment';
                } elseif ($type === 'payment_collected') {
                    $audience_label = 'Auto: Return Float';
                } elseif ($type === 'expense' || $type === 'expense_submitted') {
                    $audience_label = 'Auto: Expense';
                } elseif ($type === 'expense_status_changed') {
                    $audience_label = 'Auto: Expense Status';
                } elseif ($type === 'check' || $type === 'check_due' || $type === 'scheduled_check') {
                    $audience_label = 'Auto: Cheque';
                } elseif ($type === 'user' || $type === 'user_created') {
                    $audience_label = 'Auto: User Welcome';
                } elseif ($type === 'auto') {
                    if (strpos($title_lower, 'payment') !== false || strpos($title_lower, 'disburs') !== false || strpos($title_lower, 'float') !== false) {
                        $audience_label = 'Auto: Payment';
                    } elseif (strpos($title_lower, 'expense') !== false || strpos($title_lower, 'claim') !== false) {
                        $audience_label = 'Auto: Expense';
                    } elseif (strpos($title_lower, 'cheque') !== false || strpos($title_lower, 'check') !== false) {
                        $audience_label = 'Auto: Cheque';
                    } elseif (strpos($title_lower, 'welcome') !== false || strpos($title_lower, 'account') !== false) {
                        $audience_label = 'Auto: Welcome';
                    } else {
                        $audience_label = 'Auto Notification';
                    }
                } elseif ($type === 'managers' || $type === 'manager') {
                    $audience_label = 'Managers';
                } elseif ($type === 'cash_owners' || $type === 'cash_owner') {
                    $audience_label = 'Cash Owners';
                } elseif ($type === 'all' || $type === 'all_members' || $type === 'members') {
                    $audience_label = 'All Members';
                }

                $items[] = [
                    'id' => (int) $row['id'],
                    'type' => $row['type'],
                    'title' => $row['title'],
                    'message' => $row['body'],
                    'body' => $row['body'],
                    'audience' => $row['type'] === 'all' ? 'all_members' : $row['type'],
                    'audience_label' => $audience_label,
                    'recipient_member_name' => $recipient_name,
                    'status' => 'sent',
                    'subscription_id' => $row['type'],
                    'image_pth' => $row['image_pth'],
                    'main_user_login_id' => $row['main_user_login_id'] !== null ? (int)$row['main_user_login_id'] : null,
                    'target_count' => (int) $row['target_count'],
                    'ast' => (int) $row['ast'],
                    'sdt' => $row['sdt'],
                ];
            }
        }

        return $items;
    }

    public function get_count()
    {
        $data_base_obj = new DataBase();
        $result = $data_base_obj->get_result(
            "select count(n.id) as total_count from notifications n where n.ast='" . addslashes($this->ast) . "' " . $this->get_filter_sql()
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
