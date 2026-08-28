<?php
include_once __DIR__ . '/../../../imports/need/session_setup.php';
include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../Cook_Managment/Cook_Managing.php';

class User_Logout
{
    public static function processLogout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $cookId = isset($_SESSION['user_main_cook_id']) ? $_SESSION['user_main_cook_id'] : (isset($_COOKIE['main_user_account_cook']) ? $_COOKIE['main_user_account_cook'] : '');

        if (!empty($cookId)) {
            $cookManager = new Cook_Management($cookId);
            $cookManager->main_user_login_logout($userId);
        }

        // Unset session variables
        $_SESSION = [];

        // Clear session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Clear auth cookies
        setcookie("main_user_account_cook", '', time() - 3600, "/");

        @session_destroy();

        return [
            'status'  => 'success',
            'message' => 'Logged out successfully.'
        ];
    }
}
?>
