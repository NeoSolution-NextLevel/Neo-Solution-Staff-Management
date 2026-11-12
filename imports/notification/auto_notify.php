<?php
require_once __DIR__ . '/notification-config.php';
require_once __DIR__ . '/fcm.php';
require_once __DIR__ . '/../need/DB.php';
require_once __DIR__ . '/../../Controllers/notification/notifications_ADD_UPDATE.php';
require_once __DIR__ . '/../../Controllers/notification/notification_inbox_ADD_UPDATE.php';
require_once __DIR__ . '/../../Controllers/notification/fcm_tokens_LIST.php';
require_once __DIR__ . '/App_Notification_Service.php';

function ems_auto_notify(array $memberIds, $title, $body, $eventKey = '', $image_pth = '') {
    $memberIds = array_values(array_unique(array_filter(array_map('intval', $memberIds))));
    if (!$memberIds || trim($title) === '' || trim($body) === '') {
        return false;
    }

    $type = 'auto';
    $event = trim($eventKey);
    $image_pth = trim($image_pth);
    $senderId = ems_current_main_user_login_id();
    $notification_obj = new notifications_ADD_UPDATE();
    $notification_obj->set_data($type, $title, $body, $event, $senderId > 0 ? $senderId : null, $image_pth);
    if (!$notification_obj->process_new_record()) {
        return false;
    }
    $notificationId = (int) $notification_obj->get_id();

    $inbox_obj = new notification_inbox_ADD_UPDATE();
    $inbox_obj->process_member_list($notificationId, $memberIds);

    $token_list_obj = new fcm_tokens_LIST();
    $tokens1 = $token_list_obj->get_tokens_from_member_ids($memberIds);
    $tokens2 = $token_list_obj->get_tokens_from_user_ids($memberIds);
    $tokens = array_values(array_unique(array_filter(array_merge($tokens1, $tokens2))));
    $push_image_pth = ems_notification_public_image_pth($image_pth);

    if ($tokens) {
        try {
            ems_fcm_notify_tokens($tokens, $title, $body, [
                'type' => 'auto',
                'event' => $event,
                'notification_id' => (string) $notificationId,
            ], $push_image_pth);
        } catch (\Throwable $e) {
            error_log('Auto notify push failed: ' . $e->getMessage());
        }
    }

    return $notificationId;
}

function bmjm_auto_notify(array $memberIds, $title, $body, $eventKey = '', $image_pth = '') {
    return ems_auto_notify($memberIds, $title, $body, $eventKey, $image_pth);
}

function ems_notify_payment_disbursed($payment_id) {
    $pid = (int)$payment_id;
    if ($pid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select * from payment where id='" . $pid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }
    $amt = (float)$row['amount'];
    $uid = (int)$row['main_user_login_id'];
    $co_id = (int)$row['cash_owner_list_id'];
    $channel = ((int)$row['is_bank'] === 1) ? 'Bank Transfer' : 'Cash Safe';
    $notes = $row['description'] ?? '';

    $res_mem = $db->get_result("select id, name_M, email, moible_no from member_list where main_user_login_id='" . $uid . "' and ast='1' limit 1");
    if ($res_mem && $mem_row = $res_mem->fetch_assoc()) {
        return App_Notification_Service::notify_money_disbursed(
            'member',
            $mem_row['name_M'],
            $mem_row['email'],
            $mem_row['moible_no'],
            $amt,
            $channel,
            $co_id,
            'company',
            '',
            (int)$mem_row['id'],
            $uid,
            $notes
        );
    }
    return false;
}

function ems_notify_payment_cashowner_to_member($payment_id) {
    return ems_notify_payment_disbursed($payment_id);
}

function auto_notify_payment_cashowner_to_member($payment_id) {
    return ems_notify_payment_disbursed($payment_id);
}

function ems_notify_payment_collected($payment_id) {
    $pid = (int)$payment_id;
    if ($pid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select * from payment where id='" . $pid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }
    $amt = (float)$row['amount'];
    $uid = (int)$row['main_user_login_id'];
    $co_id = (int)$row['cash_owner_list_id'];
    $channel = ((int)$row['is_bank'] === 1) ? 'Bank Transfer' : 'Cash Safe';

    $res_mem = $db->get_result("select id, name_M from member_list where main_user_login_id='" . $uid . "' limit 1");
    $mem_name = 'Member';
    $mem_id = 0;
    if ($res_mem && $mem_row = $res_mem->fetch_assoc()) {
        $mem_name = $mem_row['name_M'];
        $mem_id = (int)$mem_row['id'];
    }

    return App_Notification_Service::notify_payment_collected(
        'member',
        $mem_name,
        $amt,
        $channel,
        $co_id,
        $mem_id,
        $uid
    );
}

function ems_notify_payment_member_to_cashowner($payment_id) {
    return ems_notify_payment_collected($payment_id);
}

function auto_notify_payment_member_to_cashowner($payment_id) {
    return ems_notify_payment_collected($payment_id);
}

function ems_notify_manager_payment_disbursed($manager_member_payment_id) {
    $pid = (int)$manager_member_payment_id;
    if ($pid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select * from manager_member_payment where id='" . $pid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }
    $amt = (float)$row['amount'];
    $mem_id = (int)$row['member_list_id'];
    $mgr_id = (int)$row['managers_list_id'];
    $notes = $row['description'] ?? '';

    $res_mgr = $db->get_result("select id, name_M, cash_owner_list_id from managers_list where id='" . $mgr_id . "' limit 1");
    $mgr_name = 'Manager';
    $co_id = 0;
    if ($res_mgr && $row_m = $res_mgr->fetch_assoc()) {
        $mgr_name = $row_m['name_M'];
        $co_id = (int)$row_m['cash_owner_list_id'];
    }

    $res_mem = $db->get_result("select id, name_M, email, moible_no, main_user_login_id from member_list where id='" . $mem_id . "' limit 1");
    if ($res_mem && $mem_row = $res_mem->fetch_assoc()) {
        return App_Notification_Service::notify_money_disbursed(
            'member',
            $mem_row['name_M'],
            $mem_row['email'],
            $mem_row['moible_no'],
            $amt,
            'Manager Float Advance',
            $co_id,
            'manager',
            $mgr_name,
            $mem_id,
            (int)$mem_row['main_user_login_id'],
            $notes,
            $mgr_id
        );
    }
    return false;
}

function ems_notify_payment_manager_to_member($manager_member_payment_id) {
    return ems_notify_manager_payment_disbursed($manager_member_payment_id);
}

function auto_notify_payment_manager_to_member($manager_member_payment_id) {
    return ems_notify_manager_payment_disbursed($manager_member_payment_id);
}

function ems_notify_manager_payment_collected($manager_member_payment_id) {
    $pid = (int)$manager_member_payment_id;
    if ($pid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select * from manager_member_payment where id='" . $pid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }
    $amt = (float)$row['amount'];
    $mem_id = (int)$row['member_list_id'];
    $mgr_id = (int)$row['managers_list_id'];

    $co_id = 0;
    $res_mgr = $db->get_result("select cash_owner_list_id from managers_list where id='" . $mgr_id . "' limit 1");
    if ($res_mgr && $row_m = $res_mgr->fetch_assoc()) {
        $co_id = (int)$row_m['cash_owner_list_id'];
    }

    $mem_name = 'Member';
    $mem_uid = 0;
    $res_mem = $db->get_result("select name_M, main_user_login_id from member_list where id='" . $mem_id . "' limit 1");
    if ($res_mem && $mem_row = $res_mem->fetch_assoc()) {
        $mem_name = $mem_row['name_M'];
        $mem_uid = (int)$mem_row['main_user_login_id'];
    }

    return App_Notification_Service::notify_payment_collected(
        'member',
        $mem_name,
        $amt,
        'Manager Float Advance',
        $co_id,
        $mem_id,
        $mem_uid,
        $mgr_id
    );
}

function ems_notify_payment_manager_to_cashowner($payment_id) {
    $pid = (int)$payment_id;
    if ($pid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select * from payment where id='" . $pid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }
    $amt = (float)$row['amount'];
    $uid = (int)$row['main_user_login_id'];
    $co_id = (int)$row['cash_owner_list_id'];
    $channel = ((int)$row['is_bank'] === 1) ? 'Bank Transfer' : 'Cash Safe';

    $res_mgr = $db->get_result("select id, name_M from managers_list where main_user_login_id='" . $uid . "' limit 1");
    $mgr_name = 'Manager';
    $mgr_id = 0;
    if ($res_mgr && $mgr_row = $res_mgr->fetch_assoc()) {
        $mgr_name = $mgr_row['name_M'];
        $mgr_id = (int)$mgr_row['id'];
    }

    return App_Notification_Service::notify_payment_collected(
        'manager',
        $mgr_name,
        $amt,
        $channel,
        $co_id,
        0,
        $uid,
        $mgr_id
    );
}

function auto_notify_payment_manager_to_cashowner($payment_id) {
    return ems_notify_payment_manager_to_cashowner($payment_id);
}

function ems_notify_expense_submitted($expense_id) {
    $eid = (int)$expense_id;
    if ($eid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select e.*, t.expence_type_name 
                           from expenses_data e 
                           left join expenses_type t on t.id = e.expenses_type_id 
                           where e.id='" . $eid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }

    $amt = (float)$row['total_amount'];
    $mem_id = (int)($row['member_list_id'] ?? 0);
    $mgr_id = (int)($row['managers_list_id'] ?? 0);
    $category = $row['expence_type_name'] ?? 'General Expense';
    $dis = $row['dis'] ?? '';
    $date = $row['date_of_doc'] ?? date('Y-m-d');

    $co_id = 0;
    $person_name = 'Member';
    if ($mem_id > 0) {
        $m_res = $db->get_result("select name_M, cash_owner_list_id from member_list where id='" . $mem_id . "' limit 1");
        if ($m_res && $m_row = $m_res->fetch_assoc()) {
            $person_name = $m_row['name_M'];
            $co_id = (int)$m_row['cash_owner_list_id'];
        }
    } elseif ($mgr_id > 0) {
        $mg_res = $db->get_result("select name_M, cash_owner_list_id from managers_list where id='" . $mgr_id . "' limit 1");
        if ($mg_res && $mg_row = $mg_res->fetch_assoc()) {
            $person_name = $mg_row['name_M'];
            $co_id = (int)$mg_row['cash_owner_list_id'];
        }
    }

    return App_Notification_Service::notify_expense_submitted(
        $person_name,
        $amt,
        $category,
        $dis,
        $date,
        $co_id,
        $mem_id
    );
}

function auto_notify_expense_submitted($expense_id) {
    return ems_notify_expense_submitted($expense_id);
}

function ems_notify_expense_status_changed($expense_id, $status, $reason = '') {
    $eid = (int)$expense_id;
    if ($eid <= 0) {
        return false;
    }
    $db = new DataBase();
    $res = $db->get_result("select * from expenses_data where id='" . $eid . "' limit 1");
    if (!$res || !($row = $res->fetch_assoc())) {
        return false;
    }

    $amt = (float)$row['total_amount'];
    $mem_id = (int)($row['member_list_id'] ?? 0);
    $co_id = 0;

    if ($mem_id > 0) {
        $m_res = $db->get_result("select cash_owner_list_id from member_list where id='" . $mem_id . "' limit 1");
        if ($m_res && $m_row = $m_res->fetch_assoc()) {
            $co_id = (int)$m_row['cash_owner_list_id'];
        }
    }

    return App_Notification_Service::notify_expense_status_changed(
        $eid,
        $status,
        $amt,
        $mem_id,
        (string)$eid,
        $co_id,
        $reason
    );
}

function auto_notify_expense_status_changed($expense_id, $status, $reason = '') {
    return ems_notify_expense_status_changed($expense_id, $status, $reason);
}

function ems_notify_expense_approved($expense_id, $reason = '') {
    return ems_notify_expense_status_changed($expense_id, 'approved', $reason);
}

function ems_notify_expense_rejected($expense_id, $reason = '') {
    return ems_notify_expense_status_changed($expense_id, 'rejected', $reason);
}

function ems_notify_scheduled_check($check_number, $amount, $bank_name, $receiver, $realesed_date, $cash_owner_id = 0, $payee_email = '', $payee_phone = '', $due_type = 'due') {
    return App_Notification_Service::notify_scheduled_check(
        $check_number,
        $amount,
        $bank_name,
        $receiver,
        $realesed_date,
        $cash_owner_id,
        $payee_email,
        $payee_phone,
        $due_type
    );
}

function ems_notify_check_reminders($cash_owner_id = 0) {
    return App_Notification_Service::notify_due_checks_for_cash_owner($cash_owner_id);
}

function ems_notify_check_reminders_for_cash_owner($cash_owner_id = 0) {
    return ems_notify_check_reminders($cash_owner_id);
}

function auto_notify_check_reminders_for_cash_owner($cash_owner_id = 0) {
    return ems_notify_check_reminders($cash_owner_id);
}

function ems_notify_today_check($cash_owner_id = 0) {
    return ems_notify_check_reminders($cash_owner_id);
}

function auto_notify_today_check($cash_owner_id = 0) {
    return ems_notify_today_check($cash_owner_id);
}

function ems_notify_check_due($cash_owner_id = 0) {
    return ems_notify_check_reminders($cash_owner_id);
}

function auto_notify_check_due($cash_owner_id = 0) {
    return ems_notify_check_due($cash_owner_id);
}

function ems_notify_payment_received($memberId, $amount = '')
{
    $memberId = (int) $memberId;
    if ($memberId <= 0) {
        return false;
    }

    $amount = trim((string) $amount);
    $body = 'Thank you. Your payment has been recorded.';
    if ($amount !== '') {
        $body .= ' Amount: Rs. ' . $amount . '.';
    }

    return ems_auto_notify([$memberId], 'Payment received', $body, 'payment_received');
}

function bmjm_notify_payment_received($memberId, $amount = '')
{
    return ems_notify_payment_received($memberId, $amount);
}

function ems_notify_payment_for_slip($paymentSlipId, $amount = '')
{
    $paymentSlipId = (int) $paymentSlipId;
    if ($paymentSlipId <= 0) {
        return false;
    }

    $data_base_obj = new DataBase();
    $result = $data_base_obj->get_result(
        "select main_user_login_id from payment where id='" . addslashes($paymentSlipId) . "' limit 1"
    );
    if (!$result || !($row = $result->fetch_assoc())) {
        return false;
    }

    $uid = (int)$row['main_user_login_id'];
    $mem_res = $data_base_obj->get_result("select id from member_list where main_user_login_id='" . $uid . "' limit 1");
    if ($mem_res && $mem_row = $mem_res->fetch_assoc()) {
        return ems_notify_payment_received($mem_row['id'], $amount);
    }

    return false;
}

function bmjm_notify_payment_for_slip($paymentSlipId, $amount = '')
{
    return ems_notify_payment_for_slip($paymentSlipId, $amount);
}

// =========================================================================
// EMS Staff & HR Management Notifications (Leave, Daily Plans, Documents)
// =========================================================================

/**
 * Triggered when an employee submits a new leave request.
 * Automatically dispatches HTML email to Admin, in-app notification, and log.
 */
function ems_notify_leave_requested(array $leaveData) {
    return App_Notification_Service::notify_leave_requested($leaveData);
}

function auto_notify_leave_requested(array $leaveData) {
    return ems_notify_leave_requested($leaveData);
}

/**
 * Triggered when Admin approves or rejects a leave request.
 * Dispatches HTML email with approval status to the employee, plus in-app notification.
 */
function ems_notify_leave_approved($leaveId, $adminComment = '') {
    return App_Notification_Service::notify_leave_status_changed($leaveId, 'Approved', $adminComment);
}

function auto_notify_leave_approved($leaveId, $adminComment = '') {
    return ems_notify_leave_approved($leaveId, $adminComment);
}

function ems_notify_leave_rejected($leaveId, $adminComment = '') {
    return App_Notification_Service::notify_leave_status_changed($leaveId, 'Rejected', $adminComment);
}

function auto_notify_leave_rejected($leaveId, $adminComment = '') {
    return ems_notify_leave_rejected($leaveId, $adminComment);
}

function ems_notify_leave_status_changed($leaveId, $status = 'Approved', $adminComment = '') {
    return App_Notification_Service::notify_leave_status_changed($leaveId, $status, $adminComment);
}

function auto_notify_leave_status_changed($leaveId, $status = 'Approved', $adminComment = '') {
    return ems_notify_leave_status_changed($leaveId, $status, $adminComment);
}

/**
 * Triggered when Admin creates a special document request for an employee / department.
 * Dispatches HTML email notice with deadline & requirements, plus in-app notification.
 */
function ems_notify_document_requested(array $docData) {
    return App_Notification_Service::notify_document_requested($docData);
}

function auto_notify_document_requested(array $docData) {
    return ems_notify_document_requested($docData);
}

/**
 * Triggered when an employee submits a daily morning work plan or shift wrap-up.
 * Dispatches HTML email to Admin, plus in-app notification.
 */
function ems_notify_daily_plan_submitted(array $planData) {
    return App_Notification_Service::notify_daily_plan_submitted($planData);
}

function auto_notify_daily_plan_submitted(array $planData) {
    return ems_notify_daily_plan_submitted($planData);
}

