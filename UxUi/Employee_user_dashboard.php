<?php 
include_once '../imports/need/session_setup.php';
require_login();

// --- Admin Impersonation Banner ---
// $is_impersonating  = !empty($_SESSION['admin_impersonating']) && $_SESSION['admin_impersonating'] === true;
// $admin_name        = $is_impersonating && !empty($_SESSION['admin_impersonating_name'])
//                      ? htmlspecialchars($_SESSION['admin_impersonating_name'])
//                      : 'Admin';
// $restore_url       = rtrim($home_page, '/') . '/View-List/Main/admin_restore_session.php';
// $admin_dash_url    = rtrim($home_page, '/') . '/UxUi/Admin_user_dashboard.php';
// if (!empty($_SESSION['admin_original_session']['url_home'])) {
//     $orig_url = trim($_SESSION['admin_original_session']['url_home']);
//     if (stripos($orig_url, 'http') === 0) {
//         $admin_dash_url = $orig_url;
//     } else {
//         $admin_dash_url = rtrim($home_page, '/') . '/' . ltrim($orig_url, '/');
//     }
// }
// ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal | NEO Solution</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/erp-theme.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/sidebar-user.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/employee-portal.css">
</head>


<body>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            Employee_user_dashboard_close_all();
            Employee_user_dashboard_01_OPEN();
        });
    </script>

    <?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/sidebar_user.php';
    ?>

    <?php
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_JS.php';

    // 01 Dashboard
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/Employee_user_dashboard_01_dashboard.php';
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/JS/Employee_user_dashboard_01_dashboard_JS.php';

    // 02 My Profile
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/Employee_user_dashboard_02_my_profile.php';
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/JS/Employee_user_dashboard_02_my_profile_JS.php';

    // 03 Personal Details
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/Employee_user_dashboard_03_personal_details.php';
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/JS/Employee_user_dashboard_03_personal_details_JS.php';

    // 04 Documents
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_04_documents/Employee_user_dashboard_04_documents.php';

    // 05 Bank Details
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_05_bank_details/Employee_user_dashboard_05_bank_details.php';

    // 06 Job Information
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_06_job_information/Employee_user_dashboard_06_job_information.php';

    // 07 Daily Work Plan
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_07_daily_work_plan/Employee_user_dashboard_07_daily_work_plan.php';

    // 08 Leave Requests
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_08_leave_request/Employee_user_dashboard_08_leave_request.php';

    // 09 Notifications
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_09_notifications/Employee_user_dashboard_09_notifications.php';

    // 10 Settings
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_10_settings/Employee_user_dashboard_10_settings.php';
    ?>

    <?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/footer.php'; 
    ?>
</body>

</html>