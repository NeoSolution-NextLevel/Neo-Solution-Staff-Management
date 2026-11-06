<?php 
include_once __DIR__ . '/../imports/need/session_setup.php';
require_login(['superadmin', 'super admin', 'super_admin', 'admin']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/erp-theme.css">
    <title>Super Admin Portal | NEO Solution</title>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/sidebar-admin.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/admin-portal.css?v=<?php echo filemtime(__DIR__ . '/../UxUi-Back/assets/css/portals/admin-portal.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<body>


<script type="text/javascript">
        window.pth = <?php echo json_encode(isset($pth) && $pth !== '' ? $pth : '../'); ?>;
        window.homePage = <?php echo json_encode(isset($home_page) ? rtrim($home_page, '/') . '/' : '../'); ?>;
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Super_Admin_user_dashboard_close_all === 'function') {
                Super_Admin_user_dashboard_close_all();
            }
            if (typeof Super_Admin_user_dashboard_01_OPEN === 'function') {
                Super_Admin_user_dashboard_01_OPEN();
            } else if (typeof Admin_user_dashboard_01_OPEN === 'function') {
                Admin_user_dashboard_01_OPEN();
            }
        });
</script>

<?php
    include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_JS.php';
?>
    
        
<?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/sidebar.php';
?>
        
<?php

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_01_dashboard/Super_Admin_user_dashboard_01_dashboard.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_01_dashboard/JS/Super_Admin_user_dashboard_01_dashboard_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_02_employees/Super_Admin_user_dashboard_02_employees.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_02_employees/JS/Super_Admin_user_dashboard_02_employees_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_03_documents/Super_Admin_user_dashboard_03_documents.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_03_documents/JS/Super_Admin_user_dashboard_03_documents_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_04_bank_details/Super_Admin_user_dashboard_04_bank_details.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_04_bank_details/JS/Super_Admin_user_dashboard_04_bank_details_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_05_departments/Super_Admin_user_dashboard_05_departments.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_05_departments/JS/Super_Admin_user_dashboard_05_departments_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_06_job_roles/Super_Admin_user_dashboard_06_job_roles.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_06_job_roles/JS/Super_Admin_user_dashboard_06_job_roles_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_07_task_management/Super_Admin_user_dashboard_07_task_management.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_07_task_management/JS/Super_Admin_user_dashboard_07_task_management_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_08_leave_requests/Super_Admin_user_dashboard_08_leave_requests.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_08_leave_requests/JS/Super_Admin_user_dashboard_08_leave_requests_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_09_notifications/Super_Admin_user_dashboard_09_notifications.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_09_notifications/JS/Super_Admin_user_dashboard_09_notifications_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_10_settings/Super_Admin_user_dashboard_10_settings.php';
            include_once __DIR__ . '/../UxUi-Back/Super_Admin_user_dashboard/Super_Admin_user_dashboard_10_settings/JS/Super_Admin_user_dashboard_10_settings_JS.php';
      ?>
 
        <?php 
        
        include_once __DIR__ . '/../UxUi-Back/Includes/footer.php'; 
         
        
        ?>
</body>

</html>
