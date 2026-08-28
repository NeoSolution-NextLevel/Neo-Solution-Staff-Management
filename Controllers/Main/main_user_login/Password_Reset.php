<?php
include_once __DIR__ . '/main_user_login_SINGLE_DATA_By_Email.php';
include_once __DIR__ . '/main_user_login_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';

class Password_Reset
{
    public static function resetPassword($email, $newPassword)
    {
        $userObj = new main_user_login_SINGLE_DATA_By_Email($email);
        if (!$userObj->get_state()) {
            return [
                'status'  => 'error',
                'message' => 'User account not found.'
            ];
        }

        $userId = $userObj->get_id();
        $encryptedPw = encryptPass($newPassword);

        $updater = new main_user_login_ADD_UPDATE();
        $updater->set_id($userId);
        $updater->set_password($encryptedPw);
        $updater->set_temp_lock(0);
        $updater->set_wrong_login_count(0);

        if ($updater->process_update()) {
            return [
                'status'  => 'success',
                'message' => 'Password reset successfully.'
            ];
        } else {
            return [
                'status'  => 'error',
                'message' => $updater->get_error() ?: 'Failed to update password.'
            ];
        }
    }
}
?>
