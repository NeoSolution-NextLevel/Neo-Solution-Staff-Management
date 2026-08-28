<?php 
include_once '../imports/need/session_setup.php';
?>

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

        /* Base container reset */
        [id^="Employee_user_dashboard_"] {
            min-height: 100vh !important;
            height: auto !important;
            box-sizing: border-box !important;
        }

        /* Prevent nested inner containers from duplicating margin or shrinking width */
        [id^="Employee_user_dashboard_"] .main,
        [id^="Employee_user_dashboard_"] .emp-main,
        [id^="Employee_user_dashboard_"] .main-wrapper,
        [id^="Employee_user_dashboard_"] .content-wrapper,
        [id^="Employee_user_dashboard_"] .content,
        [id^="Employee_user_dashboard_"] .app-layout,
        [id^="Employee_user_dashboard_"] .docs-container,
        [id^="Employee_user_dashboard_"] .docs-wrapper,
        [id^="Employee_user_dashboard_"] .settings-container,
        [id^="Employee_user_dashboard_"] .profile-wrapper,
        [id^="Employee_user_dashboard_"] .personal-details-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        /* Topbar Header Bar Base */
        .topbar, 
        header.topbar,
        [id^="Employee_user_dashboard_"] .topbar {
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
            [id^="Employee_user_dashboard_"] {
                margin-left: 250px !important;
                width: calc(100% - 250px) !important;
                max-width: calc(100% - 250px) !important;
                padding: 0 24px 80px !important;
                transition: margin-left 0.3s ease, width 0.3s ease;
            }

            .topbar, 
            header.topbar,
            [id^="Employee_user_dashboard_"] .topbar {
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
        [id^="Employee_user_dashboard_"] .topbar h2 {
            font-size: 20px !important;
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
        [id^="Employee_user_dashboard_"] h1 {
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
        [id^="Employee_user_dashboard_"] .page-head p,
        [id^="Employee_user_dashboard_"] .header-title p,
        [id^="Employee_user_dashboard_"] .content-header p {
            font-size: 13px !important;
            color: #64748b !important;
            margin: 0 !important;
            font-weight: 500 !important;
        }

        .topbar-left {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--blue-lighter);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .icon-btn:hover {
            transform: translateY(-1px);
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
            color: var(--navy);
        }

        .dot {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--red);
            border: 2px solid var(--card);
        }

        .admin-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--blue-lighter);
            padding: 4px 14px 4px 4px;
            border-radius: 999px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .admin-pill:hover {
            background: var(--blue-light);
        }

        .admin-pill .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--navy);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-pill span {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--navy);
        }

        .menu-btn, .toggle-menu {
            display: none !important;
        }

        /* full screen */
        [id^="Employee_user_dashboard_"] .table-card,
        [id^="Employee_user_dashboard_"] .table-responsive,
        [id^="Employee_user_dashboard_"] .table-wrap,
        [id^="Employee_user_dashboard_"] .table-container,
        [id^="Employee_user_dashboard_"] .notifications-list,
        [id^="Employee_user_dashboard_"] .settings-card,
        [id^="Employee_user_dashboard_"] .card,
        [id^="Employee_user_dashboard_"] .stat-card,
        [id^="Employee_user_dashboard_"] .details-card,
        [id^="Employee_user_dashboard_"] .profile-hero-card {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            border-radius: 14px !important;
            border: 1px solid #e8eaf0 !important;
            box-shadow: 0 2px 8px rgba(20,25,60,.04) !important;
        }

        [id^="Employee_user_dashboard_"] .banner {
            padding: 18px 22px !important;
            margin-bottom: 16px !important;
            border-radius: 14px !important;
        }

        [id^="Employee_user_dashboard_"] .stat-card {
            padding: 14px 16px !important;
        }

        [id^="Employee_user_dashboard_"] .card,
        [id^="Employee_user_dashboard_"] .settings-card {
            padding: 16px 18px !important;
        }

        [id^="Employee_user_dashboard_"] .table-card,
        [id^="Employee_user_dashboard_"] .table-responsive,
        [id^="Employee_user_dashboard_"] .table-wrap,
        [id^="Employee_user_dashboard_"] .table-container {
            padding: 0 !important;
            overflow: hidden !important;
        }

        [id^="Employee_user_dashboard_"] .dept-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
            gap: 16px !important;
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        @media (min-width: 769px) {
            /* Compact Table Width & Cell Padding for all pages */
            [id^="Employee_user_dashboard_"] table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            [id^="Employee_user_dashboard_"] table th {
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

            [id^="Employee_user_dashboard_"] table td {
                padding: 10px 14px !important;
                border-bottom: 1px solid #e8eaf0 !important;
                vertical-align: middle !important;
                color: #3a3f55 !important;
                font-size: 13.5px !important;
            }
        }

        /* Mobile & Tablet View (<= 768px) */
        @media (max-width: 768px) {
            [id^="Employee_user_dashboard_"],
            [id^="Employee_user_dashboard_"].emp-main,
            .emp-main,
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
            [id^="Employee_user_dashboard_"] .topbar {
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

            .topbar h2, .topbar-left h2, .page-title h1 {
                font-size: 18px !important;
            }

            .admin-pill span, .user-pill span {
                display: none !important;
            }

            .admin-pill, .user-pill {
                padding: 4px !important;
            }

            .stats, .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }

            .charts-row, .bottom-row, .dept-grid, .grid-roles, .docs-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .table-wrap, .table-card, .table-responsive, .table-container {
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }

            [id^="Employee_user_dashboard_"] table {
                min-width: 550px !important;
            }
        }
    </style>
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
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/Employee_user_dashboard_01_dashboard.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/Employee_user_dashboard_01_dashboard.php';
    }
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/JS/Employee_user_dashboard_01_dashboard_JS.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/JS/Employee_user_dashboard_01_dashboard_JS.php';
    }

    // 02 My Profile
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/Employee_user_dashboard_02_my_profile.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/Employee_user_dashboard_02_my_profile.php';
    }
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/JS/Employee_user_dashboard_02_my_profile_JS.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/JS/Employee_user_dashboard_02_my_profile_JS.php';
    }

    // 03 Personal Details
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/Employee_user_dashboard_03_personal_details.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/Employee_user_dashboard_03_personal_details.php';
    }
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/JS/Employee_user_dashboard_03_personal_details_JS.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/JS/Employee_user_dashboard_03_personal_details_JS.php';
    }

    // 04 Documents
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_04_documents/Employee_user_dashboard_04_documents.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_04_documents/Employee_user_dashboard_04_documents.php';
    }

    // 05 Bank Details
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_05_bank_details/Employee_user_dashboard_05_bank_details.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_05_bank_details/Employee_user_dashboard_05_bank_details.php';
    }

    // 06 Job Information
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_06_job_information/Employee_user_dashboard_06_job_information.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_06_job_information/Employee_user_dashboard_06_job_information.php';
    }

    // 07 Daily Work Plan
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_07_daily_work_plan/Employee_user_dashboard_07_daily_work_plan.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_07_daily_work_plan/Employee_user_dashboard_07_daily_work_plan.php';
    }

    // 08 Leave Requests
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_08_leave_request/Employee_user_dashboard_08_leave_request.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_08_leave_request/Employee_user_dashboard_08_leave_request.php';
    }

    // 09 Notifications
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_09_notifications/Employee_user_dashboard_09_notifications.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_09_notifications/Employee_user_dashboard_09_notifications.php';
    }

    // 10 Settings
    if (file_exists(__DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_10_settings/Employee_user_dashboard_10_settings.php')) {
        include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_10_settings/Employee_user_dashboard_10_settings.php';
    }
    ?>

    <?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/footer.php'; 
    ?>
</body>

</html>