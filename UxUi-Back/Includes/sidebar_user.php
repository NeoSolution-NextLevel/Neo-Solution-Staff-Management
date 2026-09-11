<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="<?php echo isset($home_page) ? $home_page : '../'; ?>UxUi-Back/assets/css/portals/sidebar-user.css">


<aside class="admin-sidebar" id="employeeSidebar">

    <!-- Brand Logo & Mobile Close Button -->
    <div class="sidebar-brand">
        <div class="brand-logo-wrap">
            <img src="<?php echo isset($home_page) ? $home_page : '../'; ?>UxUi-Back/assets/neo_solution_logo.png" alt="NEO Solution" class="brand-logo-img" style="max-height: 40px; width: auto; object-fit: contain;" onerror="this.src='../UxUi-Back/assets/neo_solution_logo.png'; this.onerror=function(){this.src='../../imports/img/logo.png';}">
            <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" onclick="closeEmployeeSidebar()" aria-label="Close Sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- User Profile Block (Integrated Compact) -->
    <div class="sidebar-user" id="empSidebarUserBlock">
        <div class="sidebar-user-avatar-wrap">
            <div class="sidebar-user-avatar" id="empSidebarAvatar">--</div>
            <span class="user-status-dot"></span>
        </div>
        <div class="sidebar-user-info">
            <strong id="empSidebarName">Loading...</strong>
            <span id="empSidebarRole">Staff</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-menu">

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_01_OPEN==='function'){ Employee_user_dashboard_01_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="dashboard"
           class="sidebar-link active">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_02_OPEN==='function'){ Employee_user_dashboard_02_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="my_profile"
           class="sidebar-link">
            <i class="fa-solid fa-circle-user"></i>
            <span>My Profile</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_03_OPEN==='function'){ Employee_user_dashboard_03_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="personal_details"
           class="sidebar-link">
            <i class="fa-solid fa-id-card"></i>
            <span>Personal Details</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_04_OPEN==='function'){ Employee_user_dashboard_04_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="documents"
           class="sidebar-link">
            <i class="fa-solid fa-folder-open"></i>
            <span>Documents</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_05_OPEN==='function'){ Employee_user_dashboard_05_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="bank_details"
           class="sidebar-link">
            <i class="fa-solid fa-building-columns"></i>
            <span>Bank Details</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_06_OPEN==='function'){ Employee_user_dashboard_06_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="job_information"
           class="sidebar-link">
            <i class="fa-solid fa-briefcase"></i>
            <span>Job Information</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_07_OPEN==='function'){ Employee_user_dashboard_07_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="daily_work_plan"
           class="sidebar-link">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Daily Work Plan</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_08_OPEN==='function'){ Employee_user_dashboard_08_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="leave_requests"
           class="sidebar-link">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Leave Requests</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function'){ Employee_user_dashboard_09_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="notifications"
           class="sidebar-link">
            <i class="fa-solid fa-bell"></i>
            <span>Notifications</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_10_OPEN==='function'){ Employee_user_dashboard_10_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="settings"
           class="sidebar-link">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>

    </nav>

    <!-- Logout -->
    <div class="sidebar-bottom">
        <a role="button" tabindex="0" class="sidebar-link logout-link" onclick="logoutUser(); return false;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Logout</span>
        </a>
        
    </div>

</aside>

<div class="sidebar-overlay" id="employeeSidebarOverlay" onclick="closeEmployeeSidebar()"></div>

<script>
    function closeEmployeeSidebar() {
        var sb = document.getElementById('employeeSidebar');
        var ov = document.getElementById('employeeSidebarOverlay');
        if (sb) sb.classList.remove('mobile-open');
        if (ov) ov.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openEmployeeSidebar() {
        var sb = document.getElementById('employeeSidebar');
        var ov = document.getElementById('employeeSidebarOverlay');
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

    // Auto load employee profile into sidebar
    (function () {
        function syncSidebarProfile() {
            var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
            fetch(pth + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php')
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    if (res && res.status === 'success' && res.data) {
                        var d = res.data;
                        var nameEl = document.getElementById('empSidebarName');
                        var roleEl = document.getElementById('empSidebarRole');
                        var avatarEl = document.getElementById('empSidebarAvatar');
                        if (nameEl && d.full_name) nameEl.textContent = d.full_name;
                        if (roleEl && (d.job_title || d.department)) roleEl.textContent = d.job_title || d.department;
                        if (avatarEl) {
                            if (d.profile_pic && d.profile_pic.trim() !== '') {
                                avatarEl.innerHTML = '<img src="' + pth + d.profile_pic + '" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />';
                            } else {
                                var initials = (d.full_name || 'AP').split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase();
                                avatarEl.textContent = initials;
                            }
                        }
                    }
                }).catch(function() {});
        }
        syncSidebarProfile();
    })();
</script>