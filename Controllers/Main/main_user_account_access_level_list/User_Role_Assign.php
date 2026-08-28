<?php
include_once __DIR__ . '/../main_user_login/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/main_user_account_access_level_list_SINGLE_DATA.php';

class User_Role_Assign
{
    public static function assignRole($userId, $accessLevelId)
    {
        $level = new main_user_account_access_level_list_SINGLE_DATA($accessLevelId);
        if (!$level->get_state()) {
            return [
                'status'  => 'error',
                'message' => 'Access level role not found.'
            ];
        }

        $updater = new main_user_login_ADD_UPDATE();
        $updater->set_id($userId);
        $updater->set_main_user_account_access_level_list_id($accessLevelId);
        $updater->set_ac_type($level->get_type_of_access());

        if ($updater->process_update()) {
            return [
                'status'  => 'success',
                'message' => 'Role assigned successfully.'
            ];
        } else {
            return [
                'status'  => 'error',
                'message' => $updater->get_error() ?: 'Failed to assign role.'
            ];
        }
    }
}
?>
