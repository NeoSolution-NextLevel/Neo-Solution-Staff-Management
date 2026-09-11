<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="<?php echo isset($home_page) ? $home_page : '../'; ?>UxUi-Back/assets/css/portals/sidebar-admin.css">


<aside class="admin-sidebar" id="adminSidebar">

    <!-- Brand Logo & Mobile Close Button -->
    <div class="sidebar-brand">
        <div class="brand-logo-wrap">
            <img src="<?php echo isset($home_page) ? $home_page : '../'; ?>UxUi-Back/assets/neo_solution_logo.png" alt="NEO Solution" class="brand-logo-img" style="max-height: 40px; width: auto; object-fit: contain;" onerror="this.src='../UxUi-Back/assets/neo_solution_logo.png'; this.onerror=function(){this.src='../../imports/img/logo.png';}">
            <button type="button" class="sidebar-close-btn" id="adminSidebarCloseBtn" onclick="closeAdminSidebar()" aria-label="Close Sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- User Info (Integrated Compact) -->
    <div class="sidebar-user">
        <div class="sidebar-user-avatar-wrap">
            <div class="sidebar-user-avatar">AU</div>
            <span class="user-status-dot"></span>
        </div>
        <div class="sidebar-user-info">
            <strong>Admin User</strong>
            <span>System Administrator</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-menu">
        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_01_OPEN==='function'){ Admin_user_dashboard_01_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="dashboard"
           class="sidebar-link active">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_02_OPEN==='function'){ Admin_user_dashboard_02_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="employees"
           class="sidebar-link">
            <i class="fa-solid fa-users"></i>
            <span>Employees</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_03_OPEN==='function'){ Admin_user_dashboard_03_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="documents"
           class="sidebar-link">
            <i class="fa-solid fa-folder-open"></i>
            <span>Documents</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_04_OPEN==='function'){ Admin_user_dashboard_04_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="bank_details"
           class="sidebar-link">
            <i class="fa-solid fa-building-columns"></i>
            <span>Bank Details</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_05_OPEN==='function'){ Admin_user_dashboard_05_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="departments"
           class="sidebar-link">
            <i class="fa-solid fa-sitemap"></i>
            <span>Departments</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_06_OPEN==='function'){ Admin_user_dashboard_06_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="job_roles"
           class="sidebar-link">
            <i class="fa-solid fa-briefcase"></i>
            <span>Job Roles</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_07_OPEN==='function'){ Admin_user_dashboard_07_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="task_management"
           class="sidebar-link">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Task Management</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_08_OPEN==='function'){ Admin_user_dashboard_08_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="leave_requests"
           class="sidebar-link">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Leave Requests</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_09_OPEN==='function'){ Admin_user_dashboard_09_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="notifications"
           class="sidebar-link">
            <i class="fa-solid fa-bell"></i>
            <span>Notifications</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Admin_user_dashboard_10_OPEN==='function'){ Admin_user_dashboard_10_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="settings"
           class="sidebar-link">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>

    </nav>

    <!-- Logout -->
    <div class="sidebar-bottom">
        <a href="<?php echo isset($home_page) ? $home_page . (isset($User_login_url) ? $User_login_url : 'UxUi/Main/') . 'User-Login' . (isset($online_offline_extention) ? $online_offline_extention : '.php') : './Main/User-Login.php'; ?>" class="sidebar-link logout-link" onclick="logoutUser(); return false;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Logout</span>
        </a>
        
    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeAdminSidebar()"></div>

<script>
    function closeAdminSidebar() {
        var sb = document.getElementById('adminSidebar');
        var ov = document.getElementById('sidebarOverlay');
        if (sb) sb.classList.remove('mobile-open');
        if (ov) ov.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openAdminSidebar() {
        var sb = document.getElementById('adminSidebar');
        var ov = document.getElementById('sidebarOverlay');
        if (sb) sb.classList.add('mobile-open');
        if (ov) ov.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    if (typeof window.logoutUser !== 'function') {
        window.logoutUser = function() {
            var loginUrl = "<?php echo isset($home_page) ? $home_page . (isset($User_login_url) ? $User_login_url : 'UxUi/Main/') . 'User-Login' . (isset($online_offline_extention) ? $online_offline_extention : '.php') : './Main/User-Login.php'; ?>";
            try {
                document.cookie.split(";").forEach(function(cookie) {
                    document.cookie = cookie
                        .replace(/^ +/, "")
                        .replace(/=.*/, "=;expires=" + new Date(0).toUTCString() + ";path=/");
                });
                sessionStorage.clear();
                localStorage.clear();
            } catch(e) {}

            var pth = "<?php echo isset($pth) ? $pth : ''; ?>";
            if (typeof $ !== 'undefined' && $.ajax) {
                $.ajax({
                    url: pth + "View-List/Main/Main_User_Logout.php",
                    type: "POST",
                    dataType: "json",
                    complete: function() {
                        window.location.href = loginUrl;
                    }
                });
            } else {
                window.location.href = loginUrl;
            }
        };
    }
</script>