<?php
require_once __DIR__ . '/notification-config.php';
require_once __DIR__ . '/fcm.php';
require_once __DIR__ . '/../../Controllers/notification/notifications_ADD_UPDATE.php';
require_once __DIR__ . '/../../Controllers/notification/notification_inbox_ADD_UPDATE.php';
require_once __DIR__ . '/../../Controllers/notification/fcm_tokens_LIST.php';

function ems_notification_audiences()
{
    return [
        'all' => 'All Staff & Admins',
        'members' => 'Only Members',
        'member' => 'Only Members',
        'managers' => 'Only Managers',
        'manager' => 'Only Managers',
        'assigned_members' => 'Assigned Members Only',
        'employees' => 'All Employees',
        'employee' => 'All Employees',
        'admins' => 'Administrators',
        'admin' => 'Administrators',
        'leave' => 'Leave Notifications',
        'daily_plan' => 'Daily Work Plan Notifications',
        'document' => 'Document Request Notifications',
        'payment' => 'Payment Notifications',
        'expense' => 'Expense Notifications',
        'check_due' => 'Check Due Notifications',
        'check' => 'Check Notifications',
    ];
}

function ems_subscription_audiences()
{
    return ems_notification_audiences();
}

function bmjm_subscription_audiences()
{
    return ems_notification_audiences();
}

function ems_normalize_audience($audience, $category_or_audience = '')
{
    $audience = trim((string) $audience);
    $category_or_audience = trim((string) $category_or_audience);

    if (in_array($audience, ['members', 'member'], true) || in_array($category_or_audience, ['members', 'member'], true)) {
        return ['members', 'members'];
    }

    if (in_array($audience, ['managers', 'manager'], true) || in_array($category_or_audience, ['managers', 'manager'], true)) {
        return ['managers', 'managers'];
    }

    if ($audience === 'assigned_members' || $category_or_audience === 'assigned_members') {
        return ['assigned_members', 'assigned_members'];
    }

    if (in_array($audience, ['payment', 'expense', 'check', 'check_due'], true)) {
        return [$audience, $audience];
    }

    if ($category_or_audience !== '' && isset(ems_notification_audiences()[$category_or_audience])) {
        return [$category_or_audience, $category_or_audience];
    }

    return ['all', ''];
}

function bmjm_normalize_audience($audience, $category_or_audience = '')
{
    return ems_normalize_audience($audience, $category_or_audience);
}

function ems_dispatch_admin_notification($type, $title, $body, $category_or_audience = '', $senderId = 0, $image_pth = '', $cashOwnerId = 0, $targetMemberUserId = 0)
{
    $type = trim((string) $type);
    $title = trim((string) $title);
    $body = trim((string) $body);
    $category_or_audience = trim((string) $category_or_audience);
    $image_pth = trim((string) $image_pth);
    $senderId = (int) $senderId;
    $cashOwnerId = (int) $cashOwnerId;
    $targetMemberUserId = (int) $targetMemberUserId;

    if ($senderId <= 0) {
        $senderId = ems_current_main_user_login_id();
    }
    if ($cashOwnerId <= 0) {
        $cashOwnerId = ems_current_cash_owner_id();
    }

    if ($title === '' || $body === '') {
        return ['ok' => false, 'error' => 'Title and body are required'];
    }

    if ($targetMemberUserId > 0 || $type === 'specific_member' || $category_or_audience === 'specific_member') {
        $type = 'specific_member';
        $category_or_audience = 'specific_member';
    } else {
        list($normalizedType, $normalizedSub) = ems_normalize_audience($type, $category_or_audience);
        if (!empty($normalizedSub) && empty($category_or_audience)) {
            $category_or_audience = $normalizedSub;
        }
        if ($normalizedType !== 'all') {
            $type = $normalizedType;
        }
    }

    $notification_obj = new notifications_ADD_UPDATE();
    $notification_obj->set_data($type, $title, $body, $category_or_audience, $senderId, $image_pth);
    if (!$notification_obj->process_new_record()) {
        return ['ok' => false, 'error' => 'Notification save failed'];
    }

    $notificationId = (int) $notification_obj->get_id();
    if ($notificationId <= 0) {
        return ['ok' => false, 'error' => 'Notification saved without an id.'];
    }

    $token_list_obj = new fcm_tokens_LIST();
    $targetUserIds = [];

    if ($targetMemberUserId > 0 || $type === 'specific_member' || $type === 'specific_employee') {
        $targetUserIds = $targetMemberUserId > 0 ? [$targetMemberUserId] : [];
    } elseif ($type === 'employees' || $type === 'employee' || $category_or_audience === 'employees' || $category_or_audience === 'employee') {
        // Query employees from main_user_login (access_level 2 or role 'employee') or employees table
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $res = $conn->query("SELECT id FROM `main_user_login` WHERE `ast` = 1 AND (`main_user_account_access_level_list_id` = 2 OR `main_user_account_access_level_list_id` = 3 OR `ac_type` = 'Employee')");
            if ($res && $res->num_rows > 0) {
                while ($r = $res->fetch_assoc()) {
                    $targetUserIds[] = (int)$r['id'];
                }
            }
        } catch (\Throwable $e) {}
        if (empty($targetUserIds)) {
            $targetUserIds = $token_list_obj->get_all_member_user_ids();
        }
    } elseif ($type === 'admins' || $type === 'admin' || $category_or_audience === 'admins' || $category_or_audience === 'admin') {
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $res = $conn->query("SELECT id FROM `main_user_login` WHERE `ast` = 1 AND (`main_user_account_access_level_list_id` = 1 OR `ac_type` = 'Admin')");
            if ($res && $res->num_rows > 0) {
                while ($r = $res->fetch_assoc()) {
                    $targetUserIds[] = (int)$r['id'];
                }
            }
        } catch (\Throwable $e) {}
        if (empty($targetUserIds)) {
            $targetUserIds = [1];
        }
    } elseif ($type === 'leave' || $category_or_audience === 'leave' || $type === 'daily_plan' || $category_or_audience === 'daily_plan') {
        // Leave / daily plan notices for admin review
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $res = $conn->query("SELECT id FROM `main_user_login` WHERE `ast` = 1 AND `main_user_account_access_level_list_id` = 1");
            if ($res && $res->num_rows > 0) {
                while ($r = $res->fetch_assoc()) {
                    $targetUserIds[] = (int)$r['id'];
                }
            }
        } catch (\Throwable $e) {}
        if (empty($targetUserIds)) $targetUserIds = [1];
    } elseif ($type === 'document' || $category_or_audience === 'document') {
        // Document requests go to all employees
        try {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $res = $conn->query("SELECT id FROM `main_user_login` WHERE `ast` = 1 AND (`main_user_account_access_level_list_id` = 2 OR `main_user_account_access_level_list_id` = 3)");
            if ($res && $res->num_rows > 0) {
                while ($r = $res->fetch_assoc()) {
                    $targetUserIds[] = (int)$r['id'];
                }
            }
        } catch (\Throwable $e) {}
        if (empty($targetUserIds)) {
            $targetUserIds = $token_list_obj->get_all_member_user_ids();
        }
    } elseif ($type === 'members' || $type === 'all_members' || $category_or_audience === 'members' || $category_or_audience === 'member' || $category_or_audience === 'all_members') {
        $targetUserIds = $cashOwnerId > 0 
            ? $token_list_obj->get_cash_owner_member_user_ids($cashOwnerId)
            : $token_list_obj->get_all_member_user_ids();
    } elseif ($type === 'managers' || $category_or_audience === 'managers' || $category_or_audience === 'manager') {
        $targetUserIds = $cashOwnerId > 0 
            ? $token_list_obj->get_cash_owner_manager_user_ids($cashOwnerId)
            : $token_list_obj->get_all_manager_user_ids();
    } elseif ($type === 'cash_owners' || $category_or_audience === 'cash_owners' || $category_or_audience === 'cash_owner') {
        $targetUserIds = $token_list_obj->get_all_cash_owner_user_ids();
    } elseif ($type === 'assigned_members' || $category_or_audience === 'assigned_members') {
        $mgrId = ems_current_manager_id();
        $targetUserIds = $token_list_obj->get_manager_assigned_member_ids($mgrId);
        if (!$targetUserIds && $cashOwnerId > 0) {
            $targetUserIds = $token_list_obj->get_cash_owner_member_user_ids($cashOwnerId);
        }
    } else {
        if ($cashOwnerId > 0) {
            $targetUserIds = $token_list_obj->get_cash_owner_member_user_ids($cashOwnerId);
            if (empty($targetUserIds)) {
                $targetUserIds = $token_list_obj->get_cash_owner_all_recipient_ids($cashOwnerId);
            }
        } else {
            $all_mems = $token_list_obj->get_all_member_user_ids();
            $all_mgrs = $token_list_obj->get_all_manager_user_ids();
            $all_owners = $token_list_obj->get_all_cash_owner_user_ids();
            $targetUserIds = array_values(array_unique(array_merge($all_mems, $all_mgrs, $all_owners)));
        }
    }

    $targetUserIds = array_values(array_unique(array_filter(array_map('intval', $targetUserIds))));

    $inbox_obj = new notification_inbox_ADD_UPDATE();
    $inboxSaved = false;
    $inboxCount = 0;
    if (!empty($targetUserIds)) {
        $inboxSaved = $inbox_obj->process_user_list($notificationId, $targetUserIds);
        $inboxCount = $inbox_obj->get_processed_count();
    }

    $tokens = $token_list_obj->get_tokens_from_user_ids($targetUserIds);

    $push_image_pth = ems_notification_public_image_pth($image_pth);
    $push = [
        'stored' => true,
        'sent' => false,
        'token_count' => count($tokens),
        'inbox_saved' => (bool) $inboxSaved,
    ];

    try {
        if ($tokens) {
            ems_fcm_notify_tokens($tokens, $title, $body, [
                'type' => $type,
                'notification_id' => (string) $notificationId,
                'category' => $category_or_audience,
                'subscription_id' => $category_or_audience,
            ], $push_image_pth);
            $push['sent'] = true;
        } else {
            $push['note'] = 'Saved to inbox. No app tokens registered yet.';
        }
    } catch (Throwable $e) {
        $push['error'] = $e->getMessage();
    }

    return [
        'ok' => true,
        'notification_id' => $notificationId,
        'image_pth' => $image_pth,
        'recipients' => count($targetUserIds),
        'inbox_count' => $inboxCount,
        'token_count' => count($tokens),
        'push' => $push,
    ];
}

function bmjm_dispatch_admin_notification($type, $title, $body, $category_or_audience = '', $senderId = 0, $image_pth = '', $cashOwnerId = 0, $targetMemberUserId = 0)
{
    return ems_dispatch_admin_notification($type, $title, $body, $category_or_audience, $senderId, $image_pth, $cashOwnerId, $targetMemberUserId);
}
