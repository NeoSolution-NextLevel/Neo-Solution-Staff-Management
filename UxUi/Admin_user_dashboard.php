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

        /* Desktop Layout */
        [id^="Admin_user_dashboard_"] {
            margin-left: 250px !important;
            width: calc(100% - 250px) !important;
            max-width: calc(100% - 250px) !important;
            min-height: 100vh !important;
            height: auto !important;
            overflow: visible !important;
            padding: 0 24px 80px !important;
            box-sizing: border-box !important;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* Prevent nested inner containers from duplicating margin or shrinking width */
        [id^="Admin_user_dashboard_"] .main,
        [id^="Admin_user_dashboard_"] .main-wrapper,
        [id^="Admin_user_dashboard_"] .content-wrapper,
        [id^="Admin_user_dashboard_"] .content,
        [id^="Admin_user_dashboard_"] .table-wrap,
        [id^="Admin_user_dashboard_"] .table-card,
        [id^="Admin_user_dashboard_"] .docs-container {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        .content {
            padding: 0 0 20px 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            height: auto !important;
            overflow: visible !important;
        }

        /* Topbar Header Bar - Full Width Clean SaaS Navbar */
        .topbar, 
        header.topbar,
        [id^="Admin_user_dashboard_"] .topbar {
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
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 3px rgba(20,25,60,.03) !important;
            margin: 0 -24px 22px -24px !important;
            width: calc(100% + 48px) !important;
            box-sizing: border-box !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 99 !important;
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

        /* Mobile & Tablet View (<= 768px) */
        @media (max-width: 768px) {
            [id^="Admin_user_dashboard_"],
            [id^="Admin_user_dashboard_"].w3-container,
            .main,
            .main-wrapper,
            .content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 14px 80px !important;
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
                padding: 0 14px !important;
                margin: 0 -14px 16px -14px !important;
                width: calc(100% + 28px) !important;
                height: 58px !important;
                min-height: 58px !important;
                max-height: 58px !important;
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