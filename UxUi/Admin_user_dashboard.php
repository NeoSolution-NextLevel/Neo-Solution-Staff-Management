<?php 
include_once __DIR__ . '/../imports/need/session_setup.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/erp-theme.css">
    <title>Admin Portal | NEO Solution</title>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/sidebar-admin.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/admin-portal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<body>


<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            Admin_user_dashboard_close_all();
           
            
            Admin_user_dashboard_01_OPEN();
            
        });
</script>

    
        
<?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/sidebar.php';
?>
        
<?php

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_01_dashboard/Admin_user_dashboard_01_dashboard.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_01_dashboard/JS/Admin_user_dashboard_01_dashboard_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_02_employees/Admin_user_dashboard_02_employees.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_02_employees/JS/Admin_user_dashboard_02_employees_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_03_documents/Admin_user_dashboard_03_documents.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_03_documents/JS/Admin_user_dashboard_03_documents_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_04_bank_details/Admin_user_dashboard_04_bank_details.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_04_bank_details/JS/Admin_user_dashboard_04_bank_details_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_05_departments/Admin_user_dashboard_05_departments.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_05_departments/JS/Admin_user_dashboard_05_departments_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_06_job_roles/Admin_user_dashboard_06_job_roles.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_06_job_roles/JS/Admin_user_dashboard_06_job_roles_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_07_task_management/Admin_user_dashboard_07_task_management.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_07_task_management/JS/Admin_user_dashboard_07_task_management_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_08_leave_requests/Admin_user_dashboard_08_leave_requests.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_08_leave_requests/JS/Admin_user_dashboard_08_leave_requests_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_09_notifications/Admin_user_dashboard_09_notifications.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_09_notifications/JS/Admin_user_dashboard_09_notifications_JS.php';

            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_10_settings/Admin_user_dashboard_10_settings.php';
            include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_10_settings/JS/Admin_user_dashboard_10_settings_JS.php';
      ?>
 
        <?php 
        
        include_once __DIR__ . '/../UxUi-Back/Includes/footer.php'; 
         
        
        ?>
</body>

</html>