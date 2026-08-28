<?php
include_once __DIR__ . '/../User_Account_Check.php';
include_once __DIR__ . '/main_user_login_SINGLE_DATA.php';
include_once __DIR__ . '/main_user_login_SINGLE_DATA_By_Email.php';
include_once __DIR__ . '/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/main_user_login_LIST.php';

class User_Login_Process
{
    public static function processLogin($username, $password)
    {
        $checker = new User_Account_Check($username, $password);
        if (!$checker->check_user_name()) {
            return [
                'status'  => 'error',
                'message' => $checker->get_error()
            ];
        }

        if ($checker->check_temp_lock_state()) {
            return [
                'status'  => 'error',
                'message' => 'Account is temporarily locked due to multiple failed login attempts.'
            ];
        }

        if ($checker->check_password()) {
            return [
                'status'        => 'success',
                'user_id'       => $checker->get_user_id(),
                'user_name'     => $checker->get_user_name(),
                'ac_type'       => $checker->get_ac_type(),
                'session_token' => $checker->get_session_token(),
                'two_factor'    => $checker->get_is_two_factor_auth_enable(),
                'google_auth'   => $checker->get_google_authentication()
            ];
        } else {
            return [
                'status'  => 'error',
                'message' => $checker->get_error()
            ];
        }
    }
}
?>
