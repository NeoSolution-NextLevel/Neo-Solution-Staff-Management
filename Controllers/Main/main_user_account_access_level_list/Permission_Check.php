<?php
include_once __DIR__ . '/main_user_account_access_level_list_SINGLE_DATA.php';

class Permission_Check
{
    public static function checkAccess($accessLevelId, $requiredRole = 'Admin')
    {
        $level = new main_user_account_access_level_list_SINGLE_DATA($accessLevelId);
        if (!$level->get_state()) {
            return false;
        }

        $typeOfAccess = strtolower(trim($level->get_type_of_access()));
        $required = strtolower(trim($requiredRole));

        if ($typeOfAccess === 'admin' || $typeOfAccess === 'super admin' || $typeOfAccess === 'manager') {
            return true;
        }

        return ($typeOfAccess === $required);
    }
}
?>
