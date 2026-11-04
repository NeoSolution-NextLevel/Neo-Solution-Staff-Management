<?php
@ini_set('display_errors', '0');
@ini_set('html_errors', '0');
ob_start();

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../imports/Company_Info/Company_Info_Variable_List.php';

include_once __DIR__ . '/../../imports/security/encrypt_decrypt.php';
include_once __DIR__ . '/../../imports/security/key_list.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_login/main_user_login_LIST.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_login_device/main_user_login_device_ADD_UPDATE.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_login_device/main_user_login_device_LIST.php';
include_once __DIR__ . '/../../Controllers/Main/main_user_account_access_level_list/main_user_account_access_level_list_SINGLE_DATA.php';
include_once __DIR__ . '/../../Controllers/Main/Cook_Managment/Cook_Createing.php';
include_once __DIR__ . '/../../Controllers/Main/User_Accout_Check_Device.php';
include_once __DIR__ . '/../../Controllers/Main/User_Accout_Check.php';
include_once __DIR__ . '/../../imports/sms/SMS_Sending.php';
include_once __DIR__ . '/../../imports/email/Email_Send.php';

function send_json_exit($json_data) {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($json_data);
    exit;
}


$get_user_name = isset($_POST['val_01']) ? $_POST['val_01'] : "";
$get_password = isset($_POST['val_02']) ? $_POST['val_02'] : "";

$json = array();
$state = array();

$User_Account_Check_obj = new User_Account_Check($get_user_name, $get_password);

unset(
    $_SESSION['user'],
    $_SESSION['user_id'],
    $_SESSION['temp_user'],
    $_SESSION['otp_pending'],
    $_SESSION['otp_encrypt'],
    $_SESSION['session_token'],
    $_SESSION['user_main_cook_id'],
    $_SESSION['main_user_account_access_level_list_id'],
    $_SESSION['url_home'],
    $_SESSION['user_role'],
    $_SESSION['ac_type'],
    $_SESSION['full_name'],
    $_SESSION['first_name'],
    $_SESSION['last_name'],
    $_SESSION['name_show'],
    $_SESSION['department'],
    $_SESSION['job_title'],
    $_SESSION['profile_pic'],
    $_SESSION['employee_id_code'],
    $_SESSION['employee_profile_id']
);

if ($User_Account_Check_obj->check_user_name()) {

    if ($User_Account_Check_obj->check_temp_lock_state()) {
        $state['error'] = "temporary lock";
        $json[] = $state;
        send_json_exit($json);
    }

    if ($User_Account_Check_obj->check_password()) {

        $_SESSION['session_token'] = $User_Account_Check_obj->get_session_token();
        $_SESSION['user_id'] = $User_Account_Check_obj->get_user_id();
        $_SESSION['user_name'] = $User_Account_Check_obj->get_user_name();
        $_SESSION['first_name'] = $User_Account_Check_obj->get_first_name();
        $_SESSION['last_name'] = $User_Account_Check_obj->get_last_name();
        $_SESSION['name_show'] = $User_Account_Check_obj->get_name_show();
        $_SESSION['image_url'] = $User_Account_Check_obj->get_image_url();

        // Check main_user_account_access_level_list_id and get url_home
        $access_level_id = $User_Account_Check_obj->get_main_user_account_access_level_list_id();
        $acl_obj = new main_user_account_access_level_list_SINGLE_DATA($access_level_id);
        $url_home = "";
        $user_role = "";
        if ($acl_obj->get_state()) {
            $url_home = trim($acl_obj->get_url_home());
            $user_role = trim($acl_obj->get_type_of_access());
        }

        if (empty($user_role)) {
            $user_role = $User_Account_Check_obj->get_ac_type();
        }

        $isAdmin = (
            strpos(strtolower((string)$user_role), 'admin') !== false ||
            (int)$access_level_id === 1 ||
            strpos(strtolower((string)$User_Account_Check_obj->get_ac_type()), 'admin') !== false ||
            (int)$User_Account_Check_obj->get_user_id() === 1
        );

        if ($isAdmin) {
            // Super Admin approval check: Admin accounts must be approved by Super Admin
            $chkAdmQ = (new DataBase())->get_data_base_connction()->query(
                "SELECT id, account_active_state, email_verify, full_block FROM `main_user_login` WHERE `id` = " . (int)$User_Account_Check_obj->get_user_id() . " LIMIT 1"
            );
            if ($chkAdmQ && ($chkRow = $chkAdmQ->fetch_assoc())) {
                // Root Super Admin (id=1) is permanently approved; non-root admins require approval if account_active_state == 0
                if ((int)$chkRow['id'] !== 1) {
                    if ((int)$chkRow['full_block'] === 1) {
                        session_unset();
                        $state['error'] = "Admin-Account-Blocked";
                        $json[] = $state;
                        send_json_exit($json);
                    }
                    if ((int)$chkRow['account_active_state'] === 0) {
                        session_unset();
                        $state['error'] = "Admin-Pending-Approval";
                        $json[] = $state;
                        send_json_exit($json);
                    }
                }
            }

            $url_home = 'UxUi/Admin_user_dashboard.php';
            $user_role = 'admin';
            $admName = !empty($_SESSION['name_show']) ? $_SESSION['name_show'] : trim($_SESSION['first_name'] . ' ' . $_SESSION['last_name']);
            if (empty($admName)) $admName = 'Admin';
            $_SESSION['full_name'] = $admName;
            $_SESSION['first_name'] = !empty($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Admin';
            $_SESSION['last_name'] = !empty($_SESSION['last_name']) ? $_SESSION['last_name'] : 'User';
            $_SESSION['job_title'] = 'Administrator';
            $_SESSION['department'] = 'Administration';
            $_SESSION['employee_id_code'] = 'ADM-' . str_pad((string)$User_Account_Check_obj->get_user_id(), 3, '0', STR_PAD_LEFT);
            $_SESSION['user_role'] = 'admin';
            $_SESSION['ac_type'] = $User_Account_Check_obj->get_ac_type() ?: 'Admin';
        } else {
            if (empty($url_home)) {
                $url_home = 'UxUi/Employee_user_dashboard.php';
                $user_role = 'Employee';
            }
            $_SESSION['user_role'] = $user_role;
            $_SESSION['ac_type'] = $user_role;

            // Resolve display/full name and employee details
            $resolved_name = !empty($_SESSION['name_show']) ? $_SESSION['name_show'] : trim($_SESSION['first_name'] . ' ' . $_SESSION['last_name']);
            if (empty($resolved_name)) {
                $resolved_name = $_SESSION['user_name'];
            }
            $_SESSION['full_name'] = $resolved_name;

            try {
                $login_db = new DataBase();
                $lconn = $login_db->get_data_base_connction();
                $safeUid = (int)$_SESSION['user_id'];
                $safeUemail = addslashes($_SESSION['user_name']);

                // 0. Ensure employee_profiles table exists
                $lconn->query("CREATE TABLE IF NOT EXISTS `employee_profiles` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `user_id` int NOT NULL,
                    `full_name` varchar(255) DEFAULT NULL,
                    `email` varchar(255) DEFAULT NULL,
                    `phone` varchar(50) DEFAULT NULL,
                    `department` varchar(100) DEFAULT 'Engineering',
                    `job_title` varchar(100) DEFAULT 'Staff',
                    `join_date` date DEFAULT NULL,
                    `nic` varchar(50) DEFAULT NULL,
                    `dob` date DEFAULT NULL,
                    `gender` varchar(20) DEFAULT 'Male',
                    `address` text DEFAULT NULL,
                    `emergency_contact_name` varchar(255) DEFAULT NULL,
                    `emergency_contact_phone` varchar(50) DEFAULT NULL,
                    `employee_id_code` varchar(50) DEFAULT NULL,
                    `employment_type` varchar(50) DEFAULT 'Full-Time (Permanent)',
                    `work_location` varchar(100) DEFAULT 'Colombo HQ',
                    `work_shift` varchar(100) DEFAULT '08:30 AM – 05:30 PM',
                    `working_days` varchar(255) DEFAULT 'Mon,Tue,Wed,Thu,Fri',
                    `weekly_roster` text DEFAULT NULL,
                    `schedule_start_date` date DEFAULT NULL,
                    `schedule_end_date` date DEFAULT NULL,
                    `work_mode` varchar(100) DEFAULT 'On-Site (Active)',
                    `probation_status` varchar(100) DEFAULT 'In Progress',
                    `probation_start_date` date DEFAULT NULL,
                    `probation_end_date` date DEFAULT NULL,
                    `official_start_date` date DEFAULT NULL,
                    `attendance_days` int DEFAULT 0,
                    `last_attendance_date` date DEFAULT NULL,
                    `profile_pic` varchar(500) DEFAULT NULL,
                    `status` varchar(50) DEFAULT 'active',
                    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_user_id` (`user_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

                // Only query employee tables for non-admin accounts
                $chkEmpProf = $lconn->query("SELECT * FROM `employee_profiles` WHERE `user_id` = '{$safeUid}' OR (`email` != '' AND `email` = '{$safeUemail}') LIMIT 1");
                if ($chkEmpProf && $ep = $chkEmpProf->fetch_assoc()) {
                    if (!empty($ep['full_name'])) $_SESSION['full_name'] = $ep['full_name'];
                    if (!empty($ep['job_title'])) $_SESSION['job_title'] = $ep['job_title'];
                    if (!empty($ep['department'])) $_SESSION['department'] = $ep['department'];
                    if (!empty($ep['profile_pic'])) {
                        $_SESSION['profile_pic'] = $ep['profile_pic'];
                        if (empty($_SESSION['image_url'])) $_SESSION['image_url'] = $ep['profile_pic'];
                    }
                    if (empty($_SESSION['profile_pic']) && !empty($_SESSION['image_url'])) {
                        $_SESSION['profile_pic'] = $_SESSION['image_url'];
                    }
                    if (!empty($ep['employee_id_code'])) $_SESSION['employee_id_code'] = $ep['employee_id_code'];
                    if (!empty($ep['id'])) $_SESSION['employee_profile_id'] = (int)$ep['id'];
                } else {
                    $deptVal = 'Engineering';
                    $roleVal = 'Staff';
                    $phoneVal = '';
                    $chkEmp = $lconn->query("SELECT * FROM `employees` WHERE (`main_user_login_id` = '{$safeUid}' AND `main_user_login_id` > 1) OR (`email_address` != '' AND `email_address` = '{$safeUemail}') LIMIT 1");
                    if ($chkEmp && $emp = $chkEmp->fetch_assoc()) {
                        if (!empty($emp['fullname'])) $_SESSION['full_name'] = $emp['fullname'];
                        if (!empty($emp['job_roles'])) $roleVal = $emp['job_roles'];
                        if (!empty($emp['departments'])) $deptVal = $emp['departments'];
                        if (!empty($emp['phone_number'])) $phoneVal = $emp['phone_number'];
                        $_SESSION['job_title'] = $roleVal;
                        $_SESSION['department'] = $deptVal;
                    }

                    // Auto-provision in employee_profiles so employee appears everywhere in admin dashboard
                    $safeResolvedName = addslashes($_SESSION['full_name']);
                    $empCodeVal = 'EMP-' . str_pad($safeUid, 3, '0', STR_PAD_LEFT);
                    $default_roster = '{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}';
                    $lconn->query("INSERT INTO `employee_profiles` (
                        `user_id`, `full_name`, `email`, `phone`, `department`, `job_title`, `status`, `join_date`,
                        `employee_id_code`, `employment_type`, `work_location`, `work_shift`, `working_days`,
                        `weekly_roster`, `work_mode`, `emergency_contact_name`, `emergency_contact_phone`, `updated_at`
                    ) VALUES (
                        {$safeUid}, '{$safeResolvedName}', '{$safeUemail}', '{$phoneVal}', '{$deptVal}', '{$roleVal}', 'active', CURDATE(),
                        '{$empCodeVal}', 'Full-Time (Permanent)', 'Colombo HQ', '08:30 AM – 05:30 PM', 'Mon,Tue,Wed,Thu,Fri',
                        '" . addslashes($default_roster) . "', 'On-Site (Active)', NULL, NULL, NOW()
                    )");
                    $newId = (int)$lconn->insert_id;
                    if ($newId > 0) {
                        $_SESSION['employee_profile_id'] = $newId;
                        $_SESSION['employee_id_code'] = $empCodeVal;
                    }
                }

                if (function_exists('update_daily_employee_presence')) {
                    update_daily_employee_presence();
                }
            } catch (\Throwable $e) {}
        }

        $_SESSION['main_user_account_access_level_list_id'] = $access_level_id;
        $_SESSION['url_home'] = $url_home;
        $_SESSION['user_role'] = $user_role;
        $state['error'] = "0";
        $state['url_home'] = $url_home;
        $state['user_role'] = $user_role;

        // Check if employee account requires mobile OTP verification
        if (!$isAdmin) {
            try {
                $lconn = (new DataBase())->get_data_base_connction();
                $safeUid = (int)$User_Account_Check_obj->get_user_id();
                $safeEmail = addslashes($User_Account_Check_obj->get_user_name());
                $chkVer = $lconn->query("SELECT account_active_state, moible_verfiy, phone_number FROM `main_user_login` WHERE `id` = {$safeUid} LIMIT 1");
                if ($chkVer && ($vRow = $chkVer->fetch_assoc())) {
                    if ((int)$vRow['account_active_state'] === 0 || (int)$vRow['moible_verfiy'] === 0) {
                        // Generate fresh 6-digit OTP for login mobile verification
                        $otp_code = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
                        $phone = !empty($vRow['phone_number']) ? trim($vRow['phone_number']) : '';

                        // Update or locate in employee_form_submissions
                        $subQ = $lconn->query("SELECT id, phone_number FROM `employee_form_submissions` WHERE `email` = '{$safeEmail}' OR `created_user_id` = {$safeUid} ORDER BY `id` DESC LIMIT 1");
                        if ($subQ && ($sRow = $subQ->fetch_assoc())) {
                            $subId = (int)$sRow['id'];
                            if (empty($phone) && !empty($sRow['phone_number'])) {
                                $phone = trim($sRow['phone_number']);
                            }
                            $lconn->query("UPDATE `employee_form_submissions` SET 
                                `otp_code` = '{$otp_code}', 
                                `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 15 MINUTE),
                                `is_otp_verified` = 0 
                                WHERE `id` = {$subId}");
                        }

                        // Also persist directly in main_user_login
                        $lconn->query("UPDATE `main_user_login` SET 
                            `otp_code` = '{$otp_code}', 
                            `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 24 HOUR) 
                            WHERE `id` = {$safeUid}");

                        if (empty($phone)) {
                            $epQ = $lconn->query("SELECT phone FROM `employee_profiles` WHERE `user_id` = {$safeUid} AND `phone` != '' LIMIT 1");
                            if ($epQ && ($epR = $epQ->fetch_assoc())) {
                                $phone = trim($epR['phone']);
                            }
                        }
                        if (empty($phone)) {
                            $empQ = $lconn->query("SELECT phone_number FROM `employees` WHERE `main_user_login_id` = {$safeUid} AND `phone_number` != '' LIMIT 1");
                            if ($empQ && ($empR = $empQ->fetch_assoc())) {
                                $phone = trim($empR['phone_number']);
                            }
                        }
                        if (!empty($phone) && empty($vRow['phone_number'])) {
                            $lconn->query("UPDATE `main_user_login` SET `phone_number` = '" . addslashes($phone) . "' WHERE `id` = {$safeUid}");
                        }

                        $comp_info = new Company_Info_Variable_List();
                        $c_name = $comp_info->get_compnay_name();

                        // Send fresh OTP via SMS to candidate phone
                        if (!empty($phone)) {
                            try {
                                $sms_msg = "Your {$c_name} login OTP is: {$otp_code}. Valid for 15 minutes. Enter this code to verify your account.";
                                $sms = new SMS_Sending($phone, $sms_msg);
                                $sms->send_message();
                            } catch (\Throwable $sEx) {}
                        }

                        // Send fresh OTP via Email to employee inbox
                        try {
                            $user_email = $User_Account_Check_obj->get_user_name();
                            $mail_subj = "Your Login Verification OTP Code - {$c_name}";
                            $mail_html = "
                            <div style='font-family: Arial, sans-serif; max-width: 580px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                                <div style='text-align: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 2px solid #2563eb;'>
                                    <h2 style='color: #14204d; margin: 0;'>{$c_name}</h2>
                                    <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Staff Account Verification</p>
                                </div>
                                <p style='font-size: 15px; color: #1e293b;'>Hello,</p>
                                <p style='font-size: 14px; color: #334155;'>Here is your login verification code to complete sign in and activate your employee portal session:</p>
                                <div style='background: #f8fafc; border: 2px dashed #2563eb; border-radius: 10px; padding: 20px; text-align: center; margin: 20px 0;'>
                                    <span style='font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;'>6-Digit OTP Code</span>
                                    <div style='font-size: 34px; font-weight: 800; letter-spacing: 8px; color: #1e3a8a; font-family: monospace; margin-top: 6px;'>{$otp_code}</div>
                                    <p style='font-size: 12px; color: #64748b; margin: 8px 0 0;'>Valid for 15 minutes. Do not share this code.</p>
                                </div>
                                <p style='font-size: 12px; color: #94a3b8; text-align: center;'>© " . date('Y') . " {$c_name}. All rights reserved.</p>
                            </div>";
                            $m_sender = new Email_Send($user_email, $mail_subj, $mail_html, 'login_otp');
                            $m_sender->send_email();
                        } catch (\Throwable $emEx) {}

                        // Clear any authenticated session variables so user is NOT considered logged in!
                        unset(
                            $_SESSION['user'],
                            $_SESSION['user_id'],
                            $_SESSION['session_token'],
                            $_SESSION['user_main_cook_id'],
                            $_SESSION['main_user_account_access_level_list_id'],
                            $_SESSION['url_home']
                        );
                        $_SESSION['otp_pending'] = true;

                        // Store temporary verification session
                        $_SESSION['temp_otp_user_id'] = $safeUid;
                        $_SESSION['temp_otp_email'] = $User_Account_Check_obj->get_user_name();

                        $masked_phone = '';
                        if (strlen($phone) > 4) {
                            $masked_phone = substr($phone, 0, 3) . '****' . substr($phone, -3);
                        }

                        $state['error'] = "0";
                        $state['otp_verification_required'] = "1";
                        $state['email'] = $User_Account_Check_obj->get_user_name();
                        $state['phone_masked'] = $masked_phone;
                        $json[] = $state;
                        send_json_exit($json);
                    }
                }
            } catch (\Throwable $e) {}
        }

        if ($User_Account_Check_obj->get_google_authentication()) {
            $_SESSION['otp_pending'] = true;
            unset(
                $_SESSION['user'],
                $_SESSION['user_id'],
                $_SESSION['session_token'],
                $_SESSION['user_main_cook_id'],
                $_SESSION['url_home']
            );
            $state['google_authentication'] = "1";
            $state['is_two_factor_auth_enable'] = "0";
        } else {
            if ($User_Account_Check_obj->get_is_two_factor_auth_enable() == "1") {
                $_SESSION['otp_pending'] = true;
                unset(
                    $_SESSION['user'],
                    $_SESSION['user_id'],
                    $_SESSION['session_token'],
                    $_SESSION['user_main_cook_id'],
                    $_SESSION['url_home']
                );
                $state['google_authentication'] = "0";
                $phone_number = $User_Account_Check_obj->get_phone_number();
                $user_email = $User_Account_Check_obj->get_user_name();
                $safeUid = (int)$User_Account_Check_obj->get_user_id();

                $otp = random_int(100000, 999999);
                $comp_info = new Company_Info_Variable_List();
                $c_name = $comp_info->get_compnay_name();

                // Persist OTP in main_user_login
                try {
                    $lconn = (new DataBase())->get_data_base_connction();
                    $lconn->query("UPDATE `main_user_login` SET `otp_code` = '{$otp}', `otp_expires_at` = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE `id` = {$safeUid}");
                } catch (\Throwable $dbEx) {}

                // Send OTP via Email (reliable delivery)
                try {
                    $mail_subj = "Two-Factor Authentication OTP - {$c_name}";
                    $mail_html = "
                    <div style='font-family: Arial, sans-serif; max-width: 580px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
                        <div style='text-align: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 2px solid #2563eb;'>
                            <h2 style='color: #14204d; margin: 0;'>{$c_name}</h2>
                            <p style='color: #64748b; font-size: 13px; margin: 4px 0 0;'>Two-Factor Authentication</p>
                        </div>
                        <p style='font-size: 15px; color: #1e293b;'>Hello,</p>
                        <p style='font-size: 14px; color: #334155;'>Here is your Two-Factor Authentication login verification OTP code:</p>
                        <div style='background: #f8fafc; border: 2px dashed #2563eb; border-radius: 10px; padding: 20px; text-align: center; margin: 20px 0;'>
                            <span style='font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;'>6-Digit OTP Code</span>
                            <div style='font-size: 34px; font-weight: 800; letter-spacing: 8px; color: #1e3a8a; font-family: monospace; margin-top: 6px;'>{$otp}</div>
                            <p style='font-size: 12px; color: #64748b; margin: 8px 0 0;'>Valid for 15 minutes. Do not share this code.</p>
                        </div>
                        <p style='font-size: 12px; color: #94a3b8; text-align: center;'>© " . date('Y') . " {$c_name}. All rights reserved.</p>
                    </div>";
                    $m_sender = new Email_Send($user_email, $mail_subj, $mail_html, '2fa_otp');
                    $m_sender->send_email();
                } catch (\Throwable $emEx) {}

                // Send via SMS
                if (!empty($phone_number)) {
                    try {
                        $message = "Your {$c_name} verification OTP is: $otp. Valid for 15 minutes.";
                        $sms_obj = new SMS_Sending($phone_number, $message);
                        $sms_obj->send_message();
                    } catch (\Throwable $sEx) {}
                }

                $Advance_Security_Key_List_obj = new Advance_Security_Key_List();
                $Advance_Security_obj = new Advance_Security();
                $otp_encrypt = $Advance_Security_obj->get_data_encrypt($Advance_Security_Key_List_obj->get_two_step_varification(), $otp);

                $_SESSION['otp_encrypt'] = $otp_encrypt;
                $_SESSION['temp_otp_user_id'] = $safeUid;
                $_SESSION['temp_otp_email'] = $user_email;
                $state['is_two_factor_auth_enable'] = "1";
                $state['email'] = $user_email;
            } else {
                $_SESSION['otp_pending'] = false;
                $state['google_authentication'] = "0";
                $state['is_two_factor_auth_enable'] = "0";

                // Check cookies creating ONLY on successful complete login
                $Cook_Createing = new Cook_Createing($User_Account_Check_obj->get_user_id());
                $_SESSION['user_main_cook_id'] = $Cook_Createing->get_cook_id();
            }
        }

        $json[] = $state;
    } else {
        session_unset();
        $state['error'] = $User_Account_Check_obj->get_error();
        $json[] = $state;
    }
} else {
    session_unset();
    $err = $User_Account_Check_obj->get_error();
    if ($err === "Username Incorrect" && !empty($get_user_name)) {
        try {
            $lconn = (new DataBase())->get_data_base_connction();
            $safeUName = addslashes($get_user_name);
            
            // 1. Check if an administrator account exists that is pending Super Admin approval or blocked
            $admChk = $lconn->query("SELECT id, account_active_state, email_verify, full_block, ast FROM `main_user_login` WHERE `user_name` = '{$safeUName}' LIMIT 1");
            if ($admChk && ($aRow = $admChk->fetch_assoc())) {
                if ((int)$aRow['full_block'] === 1) {
                    $err = "Admin-Account-Blocked";
                } elseif ((int)$aRow['account_active_state'] === 0) {
                    $err = "Admin-Pending-Approval";
                }
            } else {
                // 2. Check employee onboarding application state
                $subChk = $lconn->query("SELECT status, is_otp_verified FROM `employee_form_submissions` WHERE `email` = '{$safeUName}' ORDER BY `id` DESC LIMIT 1");
                if ($subChk && ($sRow = $subChk->fetch_assoc())) {
                    if ($sRow['status'] === 'pending') {
                        $err = "Application-Pending-Approval";
                    } elseif ($sRow['status'] === 'rejected') {
                        $err = "Application-Declined";
                    } elseif ($sRow['status'] === 'approved' && (int)$sRow['is_otp_verified'] === 0) {
                        $err = "OTP-Verification-Pending";
                    }
                }
            }
        } catch (\Throwable $ex) {}
    }
    $state['error'] = $err;
    $json[] = $state;
}

send_json_exit($json);
