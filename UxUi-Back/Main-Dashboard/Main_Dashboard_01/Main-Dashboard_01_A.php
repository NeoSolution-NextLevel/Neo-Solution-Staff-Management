<?php 
    $pth = "../"; 
    $active_page = "User-dashboard"; // Tells the sidebar to highlight this tab
    $page_title = "User-dashboard | staff management";
    include '../UxUI-Back/Includes/header.php'; 

?>




<style>
        /* =========================================================
           GLOBAL
        ========================================================= */
        :root {
            --erp-primary: #2563eb;
            --erp-primary-dark: #1d4ed8;
            --erp-primary-light: #eff6ff;
            --erp-background: #f4f6fa;
            --erp-surface: #ffffff;
            --erp-border: #e2e8f0;
            --erp-text-main: #1e293b;
            --erp-text-muted: #64748b;
            --erp-sidebar-width: 240px;
            --erp-header-height: 64px;
            --erp-radius-md: 12px;
            --erp-radius-lg: 16px;
            --erp-shadow-subtle: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--erp-background);
            color: var(--erp-text-main);
            min-height: 100vh;
        }
    </style>

<div data-page="member-list" id="Main_dashboard_01_A">

<div class="member-list-app">
 <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>

  
  

  <?php include_once __DIR__ . '/sidebar.php'; ?>
<main class="dashboard-main">

<?php $page_title = 'Dashboard'; include_once __DIR__ . '/header.php'; ?>

    <section class="dashboard-content">


        <!-- WELCOME -->

        <div class="welcome-card">

            <div class="welcome-date">
                Sunday, August 9, 2026
            </div>

            <div class="welcome-title">
                Welcome back, Administrator
            </div>

            <div class="welcome-description">
                Here's what's happening in your office today.
            </div>

        </div>


        <!-- STATISTICS -->

        <div class="stats-grid">


            <div class="stat-card">

                <div class="stat-icon blue">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div class="stat-content">

                    <div
                        id="Dashboard_A_01_val_04"
                        class="stat-value">
                        0
                    </div>

                    <div class="stat-label">
                        Total Staff
                    </div>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon green">
                    <i class="fa-solid fa-user-check"></i>
                </div>

                <div class="stat-content">

                    <div
                        id="Dashboard_A_01_val_05"
                        class="stat-value">
                        0
                    </div>

                    <div class="stat-label">
                        Active Users
                    </div>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon orange">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div class="stat-content">

                    <div
                        id="Dashboard_A_01_val_06"
                        class="stat-value">
                        0
                    </div>

                    <div class="stat-label">
                        Pending Tasks
                    </div>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon purple">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="stat-content">

                    <div
                        id="Dashboard_A_01_val_07"
                        class="stat-value">
                        0
                    </div>

                    <div class="stat-label">
                        Completed Tasks
                    </div>

                </div>

            </div>

        </div>


        <!-- CHARTS -->

        <div class="dashboard-grid">


            <div class="dashboard-card">


                <div class="card-header">

                    <div>

                        <div class="card-title">
                            Task Completion
                        </div>

                        <div class="card-subtitle">
                            Monthly completed tasks
                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <canvas
                        id="taskCompletionChart">
                    </canvas>

                </div>

            </div>


            <div class="dashboard-card">


                <div class="card-header">

                    <div>

                        <div class="card-title">
                            Task Status
                        </div>

                        <div class="card-subtitle">
                            Current task distribution
                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <canvas
                        id="taskStatusChart">
                    </canvas>

                </div>

            </div>


        </div>


        <!-- PENDING LEAVE -->

        <div class="dashboard-card table-card">


            <div class="card-header">

                <div>

                    <div class="card-title">
                        Pending Leave Requests
                    </div>

                    <div class="card-subtitle">
                        Leave requests waiting for approval
                    </div>

                </div>

            </div>


            <div class="responsive-table">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Employee
                            </th>

                            <th>
                                Leave Type
                            </th>

                            <th>
                                Start Date
                            </th>

                            <th>
                                End Date
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <tr>

                            <td>
                                No pending requests
                            </td>

                            <td>
                                -
                            </td>

                            <td>
                                -
                            </td>

                            <td>
                                -
                            </td>

                            <td>
                                -
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


    </section>

</main>


<!-- =========================================================
     DASHBOARD JS
========================================================= -->

<?php
include_once '../../../UxUi-Back/Main-Dashboard/Main_Dashboard_01/JS/Main-Dashboard_01_A_JS.php';
?>


<script>

function openSidebar() {
    openAdminSidebar();
}

function closeSidebar() {
    closeAdminSidebar();
}


/* Close mobile sidebar when
   clicking a navigation link */

document
    .querySelectorAll('.sidebar-link')
    .forEach(function(link) {

        link.addEventListener(
            'click',
            function() {

                if (
                    window.innerWidth <= 768
                ) {

                    closeSidebar();

                }

            }
        );

    });


/* Reset mobile menu on desktop */

window.addEventListener(
    'resize',
    function() {

        if (
            window.innerWidth > 768
        ) {

            closeSidebar();

        }

    }
);

</script>

