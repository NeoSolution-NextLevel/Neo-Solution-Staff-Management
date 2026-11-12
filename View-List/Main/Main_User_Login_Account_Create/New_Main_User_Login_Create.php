<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();

include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/../../../Controllers/Main/main_user_login/main_user_login_LIST.php';
include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';
include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
include_once __DIR__ . '/../../../imports/security/key_list.php';


$json = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name_show = isset($_POST['val_01']) ? trim($_POST['val_01']) : ""; // show name 
    $user_name = isset($_POST['val_02']) ? trim($_POST['val_02']) : ""; // user name ( email ) 
    $ref_key = isset($_POST['val_03']) ? trim($_POST['val_03']) : ""; // employee id 
    $password = isset($_POST['val_04']) ? trim($_POST['val_04']) : ""; // password
    $access_level_req = isset($_POST['val_05']) ? trim($_POST['val_05']) : ""; // access level list id
    $job_title = isset($_POST['val_06']) ? trim($_POST['val_06']) : ""; // job title
    $first_name = isset($_POST['val_07']) ? trim($_POST['val_07']) : ""; // first name
    $last_name = isset($_POST['val_08']) ? trim($_POST['val_08']) : ""; // last name
    $department = isset($_POST['val_09']) && !empty($_POST['val_09']) ? trim($_POST['val_09']) : 'Engineering'; // department

    if (empty($user_name) || empty($password)) {
        $state['error'] = "Missing required fields";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }

    if (empty($name_show)) {
        $name_show = trim($first_name . ' ' . $last_name);
        if (empty($name_show)) {
            $name_show = $user_name;
        }
    }

    if (empty($ref_key)) {
        $ref_key = 'ADM-' . strtoupper(substr(md5($user_name . time()), 0, 6));
    }

    // Employees can only register via Onboarding Forms created and issued by Super Admin.
    $main_user_account_access_level_list_id = 1;
    $requested_role = isset($_POST['val_05']) ? trim($_POST['val_05']) : 'Admin';
    if ($requested_role === '1' || $requested_role === '') {
        $requested_role = 'Admin';
    }
    if ($requested_role !== 'Admin') {
        $state['error'] = "Invalid account role";
        $json[] = $state;
        echo json_encode($json);
        exit;
    }
    $ac_type = 'Admin';

    $main_user_login_ADD_UPDATE_obj = new main_user_login_ADD_UPDATE();
    $main_user_login_LIST_obj = new main_user_login_LIST();
    $main_user_login_LIST_obj->filter_by_user_name($user_name);

    $get_result = $main_user_login_LIST_obj->get_result();

    // check email
    if ($get_result && $get_result->num_rows == 0) {

        $advance_security_check = new Advance_Security();
        $enc_password = $advance_security_check->get_data_encrypt($user_name, $password);

        $main_user_login_ADD_UPDATE_obj->set_registration_from_data(
            $user_name,
            $enc_password,
            $name_show,
            " ",
            $ref_key,
            $ac_type,
            $main_user_account_access_level_list_id,
            $first_name,
            $last_name
        );
        $main_user_login_ADD_UPDATE_obj->is_not_account_active_state();
        $main_user_login_ADD_UPDATE_obj->is_not_email_verify();

        if (isset($_POST['id'])) {
            $get_id = $_POST['id'];
            $main_user_login_ADD_UPDATE_obj->set_id($get_id);

            if (isset($_POST['del'])) {
                $main_user_login_ADD_UPDATE_obj->remove();
            }

            if ($main_user_login_ADD_UPDATE_obj->process_update()) {
                $state['error'] = "0";
                $state['id'] = $get_id;
            } else {
                $state['error'] = $main_user_login_ADD_UPDATE_obj->get_error();
            }
        } else {
            $db = new DataBase();
            $conn = $db->get_data_base_connction();
            $lock_res = $conn->query("SELECT GET_LOCK('neo_staff_super_admin_registration', 10) AS lock_acquired");
            $lock_row = $lock_res ? $lock_res->fetch_assoc() : null;

            if (!$lock_row || (int)$lock_row['lock_acquired'] !== 1) {
                $state['error'] = "Could not safely create the administrator account. Please try again.";
            } elseif ($main_user_login_ADD_UPDATE_obj->process_new_record()) {
                $new_id = (int)$main_user_login_ADD_UPDATE_obj->get_id();
                $state['error'] = "0";
                $state['id'] = $new_id;
                
                // Keep the root account, or otherwise the oldest existing Super Admin, as the sole Super Admin.
                $canonicalSuperAdminResult = $conn->query("SELECT id FROM `main_user_login` WHERE `id` = 1 OR LOWER(TRIM(COALESCE(`ac_type`, ''))) = 'super_admin' ORDER BY CASE WHEN `id` = 1 THEN 0 ELSE 1 END, `id` ASC LIMIT 1");
                if (!$canonicalSuperAdminResult) {
                    $conn->query("SELECT RELEASE_LOCK('neo_staff_super_admin_registration')");
                    $state['error'] = "Could not verify the Super Administrator account. Please try again.";
                    $json[] = $state;
                    echo json_encode($json);
                    exit;
                }
                $canonicalSuperAdmin = $canonicalSuperAdminResult->fetch_assoc();
                $canonicalSuperAdminId = $canonicalSuperAdmin ? (int)$canonicalSuperAdmin['id'] : 0;
                if ($canonicalSuperAdminId > 0) {
                    $deduplicateSuperAdmins = $conn->query("UPDATE `main_user_login` SET `ac_type` = 'Admin' WHERE LOWER(TRIM(COALESCE(`ac_type`, ''))) = 'super_admin' AND `id` != {$canonicalSuperAdminId}");
                    if (!$deduplicateSuperAdmins) {
                        $conn->query("SELECT RELEASE_LOCK('neo_staff_super_admin_registration')");
                        $state['error'] = "Could not enforce the single Super Administrator account. Please try again.";
                        $json[] = $state;
                        echo json_encode($json);
                        exit;
                    }
                }
                $superAdminExists = ($canonicalSuperAdminId > 0);

                if (!$superAdminExists) {
                    $promote = $conn->query("UPDATE `main_user_login` SET `account_active_state` = 1, `email_verify` = 1, `moible_verfiy` = 1, `ast` = 1, `ac_type` = 'Super Admin', `main_user_account_access_level_list_id` = 1 WHERE `id` = {$new_id}");
                    if (!$promote) {
                        $conn->query("SELECT RELEASE_LOCK('neo_staff_super_admin_registration')");
                        $state['error'] = "Failed to create the Super Administrator account.";
                        $json[] = $state;
                        echo json_encode($json);
                        exit;
                    }
                    $state['status'] = "super_admin_created";
                    $state['message'] = "The first administrator has been set up as the Super Administrator. You can log in immediately.";
                } else {
                    $pending = $conn->query("UPDATE `main_user_login` SET `account_active_state` = 0, `email_verify` = 0, `moible_verfiy` = 0, `ast` = 1, `ac_type` = 'Admin', `main_user_account_access_level_list_id` = 1 WHERE `id` = {$new_id}");
                    if (!$pending) {
                        $conn->query("SELECT RELEASE_LOCK('neo_staff_super_admin_registration')");
                        $state['error'] = "Failed to save the administrator account for approval.";
                        $json[] = $state;
                        echo json_encode($json);
                        exit;
                    }
                    $state['status'] = "pending_approval";
                    $state['message'] = "Administrator registration submitted. Pending Super Admin approval.";
                }
                $conn->query("SELECT RELEASE_LOCK('neo_staff_super_admin_registration')");

                if ($superAdminExists) {
                    // Send Email Notification to Super Admin and Acknowledgment to Applicant
                    include_once __DIR__ . '/../../../imports/email/Email_Send.php';
                    include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

                    $comp_info = new Company_Info_Variable_List();
                    $company_name = $comp_info->get_compnay_name();
                    $super_admin_email = Email_Send::resolve_admin_email();
                    $base_url = isset($home_page) ? rtrim($home_page, '/') : '';
                    $approval_url = $base_url . '/UxUi/Admin_user_dashboard.php';

                    // 1. Dispatch Email to Super Admin
                    $sa_subject = "Action Required: New Admin Registration Pending Approval - {$company_name}";
                    $sa_html = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                        <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #2563eb;'>
                            <h2 style='color: #14204d; margin: 0;'>{$company_name}</h2>
                            <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Super Administrator Approval Alert</p>
                        </div>
                        <p style='font-size: 15px; color: #1e293b; font-weight: 700;'>New Administrator Account Registration Pending Review</p>
                        <p style='font-size: 14px; color: #475569;'>A new user has registered for an Administrator account on the portal and requires your review and approval before they can access the system:</p>
                        
                        <table style='width: 100%; border-collapse: collapse; margin: 20px 0; background: #f8fafc; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;'>
                            <tr><td style='padding: 10px 14px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0; width: 35%;'>Full Name:</td><td style='padding: 10px 14px; font-weight: 700; color: #1e293b; border-bottom: 1px solid #e2e8f0;'>{$name_show}</td></tr>
                            <tr><td style='padding: 10px 14px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;'>Email Address:</td><td style='padding: 10px 14px; font-weight: 700; color: #2563eb; border-bottom: 1px solid #e2e8f0;'>{$user_name}</td></tr>
                            <tr><td style='padding: 10px 14px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;'>Department:</td><td style='padding: 10px 14px; color: #1e293b; border-bottom: 1px solid #e2e8f0;'>{$department}</td></tr>
                            <tr><td style='padding: 10px 14px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;'>Job Role / Title:</td><td style='padding: 10px 14px; color: #1e293b; border-bottom: 1px solid #e2e8f0;'>{$job_title}</td></tr>
                            <tr><td style='padding: 10px 14px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;'>Admin Ref ID:</td><td style='padding: 10px 14px; font-family: monospace; font-weight: 700; color: #0f172a; border-bottom: 1px solid #e2e8f0;'>{$ref_key}</td></tr>
                            <tr><td style='padding: 10px 14px; font-weight: 600; color: #64748b;'>Submitted At:</td><td style='padding: 10px 14px; color: #1e293b;'>" . date('Y-m-d H:i:s') . "</td></tr>
                        </table>

                        <div style='text-align: center; margin: 26px 0;'>
                            <a href='{$approval_url}' style='display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 14px; padding: 12px 28px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37,99,235,0.25);'>
                                Open Admin Portal to Review &amp; Approve
                            </a>
                        </div>
                        
                        <p style='font-size: 12px; color: #64748b; line-height: 1.5;'>
                            <strong>Security Notice:</strong> The applicant's account is currently inactive (Pending Approval). They cannot log in until approved.
                        </p>
                        <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
                            &copy; " . date('Y') . " {$company_name}. All rights reserved.
                        </p>
                    </div>";

                    try {
                        $sa_mailer = new Email_Send($super_admin_email, $sa_subject, $sa_html, 'admin_approval_request');
                        $sa_mailer->send_email();
                    } catch (\Throwable $e) {}

                    // 2. Dispatch Acknowledgment Email to Applicant
                    $app_subject = "Admin Registration Received - Pending Super Admin Approval - {$company_name}";
                    $app_html = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                        <div style='text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #2563eb;'>
                            <h2 style='color: #14204d; margin: 0;'>{$company_name}</h2>
                            <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Administrator Account Registration</p>
                        </div>
                        <p style='font-size: 15px; color: #1e293b;'>Hello <strong>{$name_show}</strong>,</p>
                        <p style='font-size: 14px; color: #475569;'>Thank you for registering an Administrator account with {$company_name}.</p>
                        <div style='background: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 16px; margin: 20px 0;'>
                            <p style='margin: 0; font-size: 14px; font-weight: 700; color: #92400e;'>Account Pending Super Admin Approval</p>
                            <p style='margin: 6px 0 0; font-size: 13px; color: #b45309;'>
                                In accordance with company security policy, administrator accounts require verification and approval by the Super Administrator before access is granted. Auto-registration and auto-login are strictly disabled.
                            </p>
                        </div>
                        <p style='font-size: 14px; color: #475569;'>
                            An approval request has been dispatched to the Super Administrator. Once reviewed and approved, you will receive an email confirmation and will be able to log in to the portal.
                        </p>
                        <p style='font-size: 12px; color: #94a3b8; text-align: center; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 12px;'>
                            &copy; " . date('Y') . " {$company_name}. All rights reserved.
                        </p>
                    </div>";

                    try {
                        $app_mailer = new Email_Send($user_name, $app_subject, $app_html, 'admin_registration_ack');
                        $app_mailer->send_email();
                    } catch (\Throwable $e) {}

                    // 3. Log In-App System Notification for Super Admin
                    try {
                        SystemNotifications::create(
                            "New Admin Pending Approval: {$name_show}",
                            "Admin account registration for {$name_show} ({$user_name}) requires Super Admin review and approval.",
                            "admin_approval",
                            "admin",
                            "Super Admin"
                        );
                    } catch (\Throwable $e) {}
                }

                // If Employee account, ensure employee_profiles, employees, and bank_details records exist
                if ($ac_type === 'Employee') {
                    $safe_email = addslashes($user_name);
                    $safe_name = addslashes($name_show);
                    $safe_job = addslashes($job_title ?: 'Staff');
                    $safe_dept = addslashes($department ?: 'Engineering');
                    $safe_ref = addslashes($ref_key);

                    // 1. Insert into employee_profiles if not exists
                    $chk_ep = $conn->query("SELECT id FROM `employee_profiles` WHERE `user_id` = {$new_id} OR `email` = '{$safe_email}' LIMIT 1");
                    if (!$chk_ep || $chk_ep->num_rows === 0) {
                        $default_roster = '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';
                        $conn->query("INSERT INTO `employee_profiles` (
                            `user_id`, `full_name`, `email`, `department`, `job_title`, `status`, `join_date`,
                            `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`,
                            `weekly_roster`, `work_mode`, `updated_at`
                        ) VALUES (
                            {$new_id}, '{$safe_name}', '{$safe_email}', '{$safe_dept}', '{$safe_job}', 'active', CURDATE(),
                            '{$safe_ref}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri',
                            '" . addslashes($default_roster) . "', 'On-Site (Active)', NOW()
                        )");
                    }

                    // 2. Insert into employees if not exists (phpMyAdmin exact table schema)
                    $chk_e = $conn->query("SELECT id FROM `employees` WHERE `email_address` = '{$safe_email}' OR `main_user_login_id` = {$new_id} LIMIT 1");
                    if (!$chk_e || $chk_e->num_rows === 0) {
                        $conn->query("INSERT INTO `employees` (
                            `fullname`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`, `main_user_login_id`
                        ) VALUES (
                            '{$safe_name}', '{$safe_email}', '{$safe_dept}', '{$safe_job}', 'active', CURDATE(), {$new_id}
                        )");
                    }

                    // 3. Create default bank_details entry
                    $chk_b = $conn->query("SELECT id FROM `bank_details` WHERE `user_id` = {$new_id} OR `employee_id` = '{$safe_ref}' LIMIT 1");
                    if (!$chk_b || $chk_b->num_rows === 0) {
                        $conn->query("INSERT INTO `bank_details` (
                            `user_id`, `employee_id`, `employee_name`, `holder_name`, `status`, `ast`, `sdt`
                        ) VALUES (
                            {$new_id}, '{$safe_ref}', '{$safe_name}', '{$safe_name}', 'Active', '1', NOW()
                        )");
                    }

                    // 4. Sync job roles count
                    $syncJrPath = __DIR__ . '/../../../UxUi-Back/Job_Roles/sync_job_roles_count.php';
                    if (file_exists($syncJrPath)) {
                        include_once $syncJrPath;
                        if (function_exists('sync_job_role_employee_counts')) {
                            sync_job_role_employee_counts($conn);
                        }
                    }
                }
            } else {
                $conn->query("SELECT RELEASE_LOCK('neo_staff_super_admin_registration')");
                $state['error'] = $main_user_login_ADD_UPDATE_obj->get_error();
            }
        }
        $json[] = $state;
    } else {
        $state['error'] = "Already have this email";
        $json[] = $state;
    }
} else {
    $state['error'] = "Missing required fields";
    $json[] = $state;
}

if (ob_get_length()) {
    ob_clean();
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
exit;
