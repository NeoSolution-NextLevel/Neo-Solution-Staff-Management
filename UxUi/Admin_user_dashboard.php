<?php 
// include_once '../imports/need/session_setup.php';
// include_once '../imports/need/DB.php';
// include_once '../Controller/Main/Cook_Managment/Cook_Managing.php';

?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Dashboard System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
    <style>
        :root {
            --navy: #14204d;
            --navy-2: #1c2b63;
            --blue: #3b5bdb;
            --blue-light: #dbe4ff;
            --blue-lighter: #eef2ff;
            --green: #12b76a;
            --green-bg: #e3f9ee;
            --amber: #f5a623;
            --amber-bg: #fdf1dc;
            --red: #f0576a;
            --red-bg: #fde8ec;
            --ink: #1a1f36;
            --muted: #6b7280;
            --border: #e8eaf0;
            --bg: #f5f6fa;
            --card: #ffffff;
            --radius: 16px;
            --shadow: 0 1px 2px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh !important;
            height: auto !important;
            display: block !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            background-color: var(--bg);
            color: var(--ink);
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
        }

        /* Container Sections */
        [id^="Admin_user_dashboard_"] {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            display: block;
        }

        .app-layout {
            display: block !important;
            width: 100% !important;
            min-height: 100vh;
        }

        /* Desktop Layout */
        .main,
        .main-wrapper,
        .content-wrapper {
            margin-left: 250px !important;
            width: calc(100% - 250px) !important;
            max-width: calc(100% - 250px) !important;
            min-height: calc(100vh - 60px) !important;
            height: auto !important;
            overflow: visible !important;
            padding: 16px 20px 80px !important;
            box-sizing: border-box !important;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .content {
            padding: 0 0 20px 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            height: auto !important;
            overflow: visible !important;
        }

        /* Topbar Header Bar (Flat rectangular bar without rounded corners) */
        .topbar, header.topbar {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
            height: 64px !important;
            min-height: 64px !important;
            max-height: 64px !important;
            padding: 0 24px !important;
            border-radius: 0 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 1px solid var(--border) !important;
            box-shadow: 0 1px 2px rgba(20,25,60,.03) !important;
            margin: -16px -20px 20px -20px !important;
            width: calc(100% + 40px) !important;
            box-sizing: border-box !important;
        }

        /* Nav bar header */
        .topbar h2,
        .topbar .page-breadcrumb,
        .topbar .page-title,
        .topbar-left h2,
        .topbar-left .page-breadcrumb,
        .topbar-left .page-title,
        .page-breadcrumb {
            font-size: 22px !important;
            font-weight: 800 !important;
            color: #14204d !important;
            letter-spacing: -0.3px !important;
            margin: 0 !important;
            line-height: 1.2 !important;
            display: inline-block !important;
        }

        .page-title h1,
        .header-title h1,
        .content-header h1,
        .page-head h1,
        .header-row h1,
        [id^="Admin_user_dashboard_"] h1 {
            font-size: 22px !important;
            font-weight: 800 !important;
            color: #14204d !important;
            letter-spacing: -0.3px !important;
            margin: 0 0 4px 0 !important;
            line-height: 1.2 !important;
        }

        .page-title p,
        .header-title p,
        .content-header p,
        .page-head p,
        .header-row p,
        [id^="Admin_user_dashboard_"] .page-head p,
        [id^="Admin_user_dashboard_"] .header-title p,
        [id^="Admin_user_dashboard_"] .content-header p {
            font-size: 13px !important;
            color: #64748b !important;
            margin: 0 !important;
            font-weight: 500 !important;
        }

        .menu-btn, .toggle-menu {
            display: none !important;
        }

        /* full screen */
        [id^="Admin_user_dashboard_"] .table-card,
        [id^="Admin_user_dashboard_"] .table-responsive,
        [id^="Admin_user_dashboard_"] .table-wrap,
        [id^="Admin_user_dashboard_"] .table-container,
        [id^="Admin_user_dashboard_"] .notifications-list,
        [id^="Admin_user_dashboard_"] .settings-card,
        [id^="Admin_user_dashboard_"] .card,
        [id^="Admin_user_dashboard_"] .stat-card {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            border-radius: 14px !important;
            border: 1px solid #e8eaf0 !important;
            box-shadow: 0 2px 8px rgba(20,25,60,.04) !important;
        }

        [id^="Admin_user_dashboard_"] .banner {
            padding: 18px 22px !important;
            margin-bottom: 16px !important;
            border-radius: 14px !important;
        }

        [id^="Admin_user_dashboard_"] .stat-card {
            padding: 14px 16px !important;
        }

        [id^="Admin_user_dashboard_"] .card,
        [id^="Admin_user_dashboard_"] .settings-card {
            padding: 16px 18px !important;
        }

        [id^="Admin_user_dashboard_"] .table-card,
        [id^="Admin_user_dashboard_"] .table-responsive,
        [id^="Admin_user_dashboard_"] .table-wrap,
        [id^="Admin_user_dashboard_"] .table-container {
            padding: 0 !important;
            overflow: hidden !important;
        }

        [id^="Admin_user_dashboard_"] .dept-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
            gap: 16px !important;
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Compact Table Width & Cell Padding for all pages */
        [id^="Admin_user_dashboard_"] table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        [id^="Admin_user_dashboard_"] table th {
            background: #fafbfd !important;
            color: #6b7280 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: .04em !important;
            font-weight: 700 !important;
            padding: 10px 14px !important;
            border-bottom: 1px solid #e8eaf0 !important;
            text-align: left !important;
        }

        [id^="Admin_user_dashboard_"] table td {
            padding: 10px 14px !important;
            border-bottom: 1px solid #e8eaf0 !important;
            vertical-align: middle !important;
            color: #3a3f55 !important;
            font-size: 13.5px !important;
        }

        /* Mobile & Tablet View  */
        @media (max-width: 768px) {
            .main,
            .main-wrapper,
            .content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 12px 12px 60px !important;
            }

            .menu-btn, .toggle-menu {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 38px !important;
                height: 38px !important;
                border-radius: 8px !important;
                background: var(--blue-lighter) !important;
                border: none !important;
                cursor: pointer !important;
                color: var(--navy) !important;
                margin-right: 8px !important;
            }

            .topbar {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 12px 16px !important;
                margin: -12px -12px 16px -12px !important;
                width: calc(100% + 24px) !important;
                border-radius: 0 !important;
                background: #ffffff !important;
                border-bottom: 1px solid var(--border) !important;
            }

            .topbar h2, .page-title h1 {
                font-size: 18px !important;
            }

            .stats, .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }

            .charts-row, .bottom-row, .dept-grid, .grid-roles {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .table-wrap, .table-card, .table-responsive, .table-container {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }

            [id^="Admin_user_dashboard_"] table {
                min-width: 600px !important;
            }
        }
    </style>
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