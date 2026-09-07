<?php

include_once '../../../imports/need/session_setup.php';
include_once '../../../imports/need/DB.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_ADD_UPDATE.php';
include_once '../../../Controllers/Main/main_user_login/main_user_login_LIST.php';
include_once '../../../imports/Company_Info/Company_Info_Variable_List.php';
include_once '../../../imports/security/encrypt_decrypt.php';
include_once '../../../imports/security/key_list.php';


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

    // Determine access level and account type
    if ((string)$access_level_req === "1") {
        $main_user_account_access_level_list_id = 1;
        $ac_type = 'admin';
    } else {
        $main_user_account_access_level_list_id = 2;
        $ac_type = 'Employee';
    }

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

                // If Employee account, ensure employee_profiles and employees records exist
                if ($ac_type === 'Employee') {
                    $db = new DataBase();
                    $conn = $db->get_data_base_connction();
                    $safe_email = addslashes($user_name);
                    $safe_name = addslashes($name_show);
                    $safe_job = addslashes($job_title ?: 'Staff');
                    $safe_ref = addslashes($ref_key);

                    // Insert into employee_profiles if not exists
                    $chk_ep = $conn->query("SELECT id FROM `employee_profiles` WHERE `user_id` = {$new_id} OR `email` = '{$safe_email}' LIMIT 1");
                    if (!$chk_ep || $chk_ep->num_rows === 0) {
                        $conn->query("INSERT INTO `employee_profiles` (
                            `user_id`, `full_name`, `email`, `department`, `job_title`, `status`, `join_date`,
                            `employee_id_code`, `employment_type`, `work_location`
                        ) VALUES (
                            {$new_id}, '{$safe_name}', '{$safe_email}', 'Engineering', '{$safe_job}', 'active', CURDATE(),
                            '{$safe_ref}', 'Full-Time', 'Colombo HQ'
                        )");
                    }

                    // Insert into employees if not exists
                    $chk_e = $conn->query("SELECT id FROM `employees` WHERE `email_address` = '{$safe_email}' LIMIT 1");
                    if (!$chk_e || $chk_e->num_rows === 0) {
                        $conn->query("INSERT INTO `employees` (
                            `name`, `email_address`, `departments`, `job_roles`, `status`, `joined_date`
                        ) VALUES (
                            '{$safe_name}', '{$safe_email}', 'Engineering', '{$safe_job}', 'active', CURDATE()
                        )");
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
