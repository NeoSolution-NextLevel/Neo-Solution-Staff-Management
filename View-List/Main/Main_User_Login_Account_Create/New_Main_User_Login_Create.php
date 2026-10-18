<?php

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
        $ref_key = 'EMP-' . strtoupper(substr(md5($user_name . time()), 0, 6));
    }

    // Public registration is strictly for Employees.
    // Admin accounts cannot be created via registration; only existing database admins can access admin portal.
    $main_user_account_access_level_list_id = 2;
    $ac_type = 'Employee';

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
            if ($main_user_login_ADD_UPDATE_obj->process_new_record()) {
                $new_id = $main_user_login_ADD_UPDATE_obj->get_id();
                $state['error'] = "0";
                $state['id'] = $new_id;

                // If Employee account, ensure employee_profiles, employees, and bank_details records exist
                if ($ac_type === 'Employee') {
                    $db = new DataBase();
                    $conn = $db->get_data_base_connction();
                    $safe_email = addslashes($user_name);
                    $safe_name = addslashes($name_show);
                    $safe_job = addslashes($job_title ?: 'Staff');
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
                            {$new_id}, '{$safe_name}', '{$safe_email}', 'Engineering', '{$safe_job}', 'active', CURDATE(),
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
                            '{$safe_name}', '{$safe_email}', 'Engineering', '{$safe_job}', 'active', CURDATE(), {$new_id}
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

echo json_encode($json);
