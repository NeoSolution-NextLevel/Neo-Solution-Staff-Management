<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/notification/notifications_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/Cook_Managment/Cook_Managing.php';
include_once __DIR__ . '/../../../imports/notification/notification-config.php';
include_once __DIR__ . '/../../../imports/notification/notification_dispatch.php';

header('Content-Type: application/json; charset=utf-8');

$json = array();
$state = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $check_login_obj = new Cook_Management($user_main_cook_id ?? '');
    $main_user_login_id = ($check_login_obj->check_login_availability()) ? (int)$check_login_obj->get_user_id() : (isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 1);

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $type = isset($_POST['type']) ? trim($_POST['type']) : (isset($_POST['audience']) ? trim($_POST['audience']) : (isset($_POST['category']) ? trim($_POST['category']) : "all"));
    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
    $body = isset($_POST['body']) ? trim($_POST['body']) : (isset($_POST['message']) ? trim($_POST['message']) : "");
    $category_or_audience = isset($_POST['category']) ? trim($_POST['category']) : (isset($_POST['subscription_id']) ? trim($_POST['subscription_id']) : (isset($_POST['target']) ? trim($_POST['target']) : ""));
    $image_pth = isset($_POST['image_pth']) ? trim($_POST['image_pth']) : (isset($_POST['image_path']) ? trim($_POST['image_path']) : "");
    $cash_owner_list_id = isset($_POST['cash_owner_list_id']) ? (int)$_POST['cash_owner_list_id'] : ems_current_cash_owner_id();
    $target_member_id = isset($_POST['target_member_id']) ? (int)$_POST['target_member_id'] : (isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0);
    $target_user_id = isset($_POST['target_user_id']) ? (int)$_POST['target_user_id'] : 0;

    // Handle file upload for notification image
    $uploaded_file = $_FILES['image_file'] ?? $_FILES['image'] ?? null;
    if ($uploaded_file && isset($uploaded_file['tmp_name']) && is_uploaded_file($uploaded_file['tmp_name']) && $uploaded_file['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../../assets/uploads/notifications/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0755, true);
        }
        $file_ext = strtolower(pathinfo($uploaded_file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($file_ext, $allowed)) {
            $f_name = 'notif_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
            if (move_uploaded_file($uploaded_file['tmp_name'], $upload_dir . $f_name)) {
                $image_pth = 'assets/uploads/notifications/' . $f_name;
            }
        }
    } elseif (!empty($_POST['image_base64']) && preg_match('/^data:image\/(\w+);base64,/', $_POST['image_base64'], $matches)) {
        $upload_dir = __DIR__ . '/../../../assets/uploads/notifications/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0755, true);
        }
        $data = substr($_POST['image_base64'], strpos($_POST['image_base64'], ',') + 1);
        $decoded = base64_decode($data);
        if ($decoded !== false) {
            $ext = strtolower($matches[1]);
            if ($ext === 'jpeg') $ext = 'jpg';
            $f_name = 'notif_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            if (file_put_contents($upload_dir . $f_name, $decoded)) {
                $image_pth = 'assets/uploads/notifications/' . $f_name;
            }
        }
    }

    // Resolve target member's main_user_login_id if member_id is provided
    if ($target_member_id > 0 && $target_user_id <= 0) {
        $db_tmp = new DataBase();
        $q_mem = $db_tmp->get_result("SELECT main_user_login_id FROM member_list WHERE id = '" . (int)$target_member_id . "' LIMIT 1");
        if ($q_mem && $r_mem = $q_mem->fetch_assoc()) {
            $target_user_id = (int)$r_mem['main_user_login_id'];
        }
    }

    if ($target_user_id > 0) {
        $type = 'specific_member';
        $category_or_audience = 'specific_member';
    }

    // Check for deletion
    if ((isset($_POST['del']) && $_POST['del'] == '1') || (isset($_POST['remove']) && $_POST['remove'] == '1')) {
        if ($id <= 0) {
            $state['error'] = "Notification ID is required for deletion.";
        } else {
            $notif_obj = new notifications_ADD_UPDATE();
            $notif_obj->set_id($id);
            if ($notif_obj->process_remove()) {
                $state['error'] = "0";
                $state['status'] = "success";
                $state['id'] = $id;
                $state['msg'] = "Notification deleted successfully.";
            } else {
                $state['error'] = $notif_obj->get_error() ?: "Failed to delete notification.";
            }
        }
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    if (empty($title)) {
        $state['error'] = "Notification title is required.";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    if (empty($body)) {
        $state['error'] = "Notification message body is required.";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    // Check for update of existing record
    if ($id > 0) {
        $notif_obj = new notifications_ADD_UPDATE();
        $notif_obj->set_id($id);
        $notif_obj->set_data($type, $title, $body, $main_user_login_id, $image_pth);

        if ($notif_obj->process_update()) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $id;
            $state['msg'] = "Notification updated successfully.";
        } else {
            $state['error'] = $notif_obj->get_error() ?: "Failed to update notification.";
        }
    } else {
        // Dispatch new notification to target audience and inbox
        $disp = ems_dispatch_admin_notification(
            $type,
            $title,
            $body,
            $category_or_audience,
            $main_user_login_id,
            $image_pth,
            $cash_owner_list_id,
            $target_user_id
        );

        if (!empty($disp['ok'])) {
            $state['error'] = "0";
            $state['status'] = "success";
            $state['id'] = $disp['notification_id'];
            $state['recipients'] = $disp['recipients'];
            $state['inbox_count'] = $disp['inbox_count'];
            $state['token_count'] = $disp['token_count'];
            $state['msg'] = "Notification created and sent successfully.";
        } else {
            $err = $disp['error'] ?? "Failed to dispatch notification.";
            $state['error'] = $err;
            $state['msg'] = $err;
        }
    }
} else {
    $state['error'] = "Invalid request method.";
}

$json[] = $state;
echo json_encode($json);
