<?php
include_once '../../imports/need/session_setup.php';

// If explicitly requesting relogin or returning from an alert/verification page, clean the auth session
if (isset($_GET['relogin']) || isset($_GET['logout']) || isset($_GET['action']) || !empty($_SESSION['otp_pending'])) {
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
        $_SESSION['employee_profile_id'],
        $_SESSION['temp_otp_user_id'],
        $_SESSION['temp_otp_email']
    );
    if (isset($_COOKIE['main_user_account_cook'])) {
        setcookie('main_user_account_cook', '', time() - 3600, '/');
    }
} else {
    redirect_if_logged_in();
}
$is_auth_page = true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Portal Login | NEO Solution</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../UxUi-Back/assets/css/portals/auth-portal.css?v=<?php echo filemtime(__DIR__ . '/../../UxUi-Back/assets/css/portals/auth-portal.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Header component -->
    <?php
    include_once '../../imports/Company_Info/Company_Info_Variable_List.php';
    include_once '../../View-List/Main/Google-Login/Main_User_Google_Login_Config.php';
    include_once '../../View-List/Main/Microsoft-Login/Main_User_Microsoft_Login_Config.php';
    include_once '../../UxUi-Back/Common/header.php';
    ?>

    <!-- Login content -->
    <?php
    include_once '../../UxUi-Back/Main/Main_User_Login/JS/User_Login_A_01_JS.php';
    include_once '../../UxUi-Back/Main/Main_User_Login/User_Login_A_01.php';
    ?>

    <!-- Footer component -->
    <?php include_once '../../UxUi-Back/Common/footer.php'; ?>
</body>

</html>