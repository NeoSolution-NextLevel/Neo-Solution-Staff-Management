<?php 
include_once __DIR__ . '/../imports/need/session_setup.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/erp-theme.css">
    <title>Admin Portal | NEO Solution</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" > </script>
</head>


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
            display: flex !important;
            flex-direction: column !important;
            overflow-x: hidden !important;
            background-color: var(--bg);
            color: var(--ink);
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
        }

        /* Base container reset */
        [id^="Admin_user_dashboard_"] {
            flex: 1 0 auto;
            min-height: calc(100vh - 60px);
            box-sizing: border-box !important;
        }

        /* Prevent nested inner containers from duplicating margin or shrinking width */
        [id^="Admin_user_dashboard_"] .main,
        [id^="Admin_user_dashboard_"] .main-wrapper,
        [id^="Admin_user_dashboard_"] .content-wrapper,
        [id^="Admin_user_dashboard_"] .content,
        [id^="Admin_user_dashboard_"] .app-layout,
        [id^="Admin_user_dashboard_"] .table-wrap,
        [id^="Admin_user_dashboard_"] .table-card,
        [id^="Admin_user_dashboard_"] .docs-container {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        /* Topbar Header Bar Base */
        .topbar, 
        header.topbar,
        [id^="Admin_user_dashboard_"] .topbar {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
            border-radius: 0 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 3px rgba(20,25,60,.03) !important;
            box-sizing: border-box !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 99 !important;
        }

        /* Desktop Layout (>= 769px) */
        @media (min-width: 769px) {
            [id^="Admin_user_dashboard_"] {
                margin-left: 250px !important;
                width: calc(100% - 250px) !important;
                max-width: calc(100% - 250px) !important;
                padding: 0 24px 30px !important;
                transition: margin-left 0.3s ease, width 0.3s ease;
            }

            .topbar, 
            header.topbar,
            [id^="Admin_user_dashboard_"] .topbar {
                height: 64px !important;
                min-height: 64px !important;
                max-height: 64px !important;
                padding: 0 24px !important;
                margin: 0 -24px 22px -24px !important;
                width: calc(100% + 48px) !important;
            }
        }

        /* Nav bar header elements */
        .topbar h2,
        .topbar .page-breadcrumb,
        .topbar .page-title,
        .topbar-left h2,
        .topbar-left .page-breadcrumb,
        .topbar-left .page-title,
        .page-breadcrumb,
        [id^="Admin_user_dashboard_"] .topbar h2 {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #14204d !important;
            letter-spacing: -0.3px !important;
            margin: 0 !important;
            line-height: 1.2 !important;
            display: inline-block !important;
        }

        .topbar-left {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .topbar-right {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .topbar .icon-btn,
        [id^="Admin_user_dashboard_"] .topbar .icon-btn {
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            background: #eef2ff !important;
            border: 1px solid #e0edff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            color: #14204d !important;
        }

        .topbar .icon-btn:hover,
        [id^="Admin_user_dashboard_"] .topbar .icon-btn:hover {
            background: #e0e7ff !important;
            transform: translateY(-1px) !important;
        }

        .topbar .dot,
        [id^="Admin_user_dashboard_"] .topbar .dot {
            position: absolute !important;
            top: 7px !important;
            right: 8px !important;
            width: 7px !important;
            height: 7px !important;
            border-radius: 50% !important;
            background: #ef4444 !important;
            border: 2px solid #ffffff !important;
        }

        .topbar .admin-pill,
        [id^="Admin_user_dashboard_"] .topbar .admin-pill {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            padding: 4px 14px 4px 5px !important;
            border-radius: 999px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .topbar .admin-pill:hover,
        [id^="Admin_user_dashboard_"] .topbar .admin-pill:hover {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }

        .topbar .admin-pill .avatar,
        [id^="Admin_user_dashboard_"] .topbar .admin-pill .avatar {
            width: 28px !important;
            height: 28px !important;
            font-size: 11px !important;
            background: #14204d !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 800 !important;
        }

        .topbar .admin-pill span,
        [id^="Admin_user_dashboard_"] .topbar .admin-pill span {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #14204d !important;
        }

        .menu-btn, .toggle-menu {
            display: none !important;
        }

        /* Full width cards and containers */
        [id^="Admin_user_dashboard_"] .table-card,
        [id^="Admin_user_dashboard_"] .table-responsive,
        [id^="Admin_user_dashboard_"] .table-wrap,
        [id^="Admin_user_dashboard_"] .table-container,
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

        /* Dedicated Padding for Notifications & Settings */
        #Admin_user_dashboard_09_notifications .content,
        #Admin_user_dashboard_10_settings .content {
            max-width: 960px !important;
            margin-left: 0 !important;
            margin-right: auto !important;
            padding: 10px 0 60px 0 !important;
            box-sizing: border-box !important;
        }

        #Admin_user_dashboard_09_notifications .content-header,
        #Admin_user_dashboard_10_settings .content-header {
            margin-bottom: 20px !important;
            padding: 0 4px !important;
        }

        [id^="Admin_user_dashboard_"] .notifications-list,
        #Admin_user_dashboard_09_notifications .notifications-list {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 14px !important;
            width: 100% !important;
            max-width: 960px !important;
            padding: 0 !important;
        }

        @media (min-width: 769px) {
            [id^="Admin_user_dashboard_"] .notif-card,
            #Admin_user_dashboard_09_notifications .notif-card {
                padding: 20px 24px !important;
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 14px !important;
                box-shadow: 0 2px 8px rgba(20,25,60,.03) !important;
                display: flex !important;
                align-items: flex-start !important;
                gap: 18px !important;
                box-sizing: border-box !important;
                margin-bottom: 14px !important;
            }

            [id^="Admin_user_dashboard_"] .settings-card,
            #Admin_user_dashboard_10_settings .settings-card {
                width: 100% !important;
                max-width: 960px !important;
                box-sizing: border-box !important;
                background: #ffffff !important;
                border-radius: 16px !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 2px 8px rgba(20,25,60,.04) !important;
                padding: 28px 32px !important;
                margin-bottom: 24px !important;
            }

            /* Compact Table Width & Cell Padding for all pages */
            [id^="Admin_user_dashboard_"] table:not(.task-table) {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            [id^="Admin_user_dashboard_"] table:not(.task-table) th {
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

            [id^="Admin_user_dashboard_"] table:not(.task-table) td {
                padding: 10px 14px !important;
                border-bottom: 1px solid #e8eaf0 !important;
                vertical-align: middle !important;
                color: #3a3f55 !important;
                font-size: 13.5px !important;
            }
        }

        [id^="Admin_user_dashboard_"] .setting-item,
        #Admin_user_dashboard_10_settings .setting-item {
            padding: 18px 0 !important;
        }

        [id^="Admin_user_dashboard_"] .info-box,
        #Admin_user_dashboard_10_settings .info-box {
            padding: 18px 24px !important;
            border-radius: 12px !important;
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

        /* Mobile & Tablet View (<= 768px) */
        @media (max-width: 768px) {
            [id^="Admin_user_dashboard_"],
            [id^="Admin_user_dashboard_"].w3-container,
            .main,
            .main-wrapper,
            .content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                padding: 0 12px 80px !important;
                box-sizing: border-box !important;
                overflow-x: hidden !important;
            }

            [id^="Admin_user_dashboard_"] .notif-card,
            #Admin_user_dashboard_09_notifications .notif-card {
                padding: 12px 14px !important;
                gap: 10px !important;
                border-radius: 12px !important;
                margin-bottom: 10px !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            [id^="Admin_user_dashboard_"] .settings-card,
            #Admin_user_dashboard_10_settings .settings-card {
                padding: 16px 18px !important;
                border-radius: 14px !important;
                margin-bottom: 16px !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            .menu-btn, .toggle-menu {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 38px !important;
                height: 38px !important;
                border-radius: 8px !important;
                background: #eef2ff !important;
                border: 1px solid #e0edff !important;
                cursor: pointer !important;
                color: #14204d !important;
                margin-right: 6px !important;
            }

            .menu-btn svg {
                width: 20px !important;
                height: 20px !important;
            }

            .topbar, 
            header.topbar,
            [id^="Admin_user_dashboard_"] .topbar {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 0 12px !important;
                margin: 0 -12px 16px -12px !important;
                width: calc(100% + 24px) !important;
                height: 58px !important;
                min-height: 58px !important;
                max-height: 58px !important;
                box-sizing: border-box !important;
            }

            .topbar-left {
                display: flex !important;
                align-items: center !important;
                gap: 6px !important;
            }

            .topbar h2, .page-title h1 {
                font-size: 18px !important;
            }

            .admin-pill span {
                display: none !important;
            }

            .admin-pill {
                padding: 4px !important;
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
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }

            [id^="Admin_user_dashboard_"] table:not(.task-table) {
                min-width: 550px !important;
            }

            [id^="Admin_user_dashboard_"] table.task-table {
                min-width: 100% !important;
                width: 100% !important;
            }
        }
    </style>


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