<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    /* =========================================================
       EMPLOYEE SIDEBAR (SCROLL-FREE 100% VIEWPORT FIT)
    ========================================================= */
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
        --border: #e2e8f0;
        --bg: #f5f6fa;
        --card: #ffffff;
        --radius: 16px;
        --shadow: 0 1px 2px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
    }

    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        max-height: 100vh;
        background: #ffffff;
        border-right: 1px solid var(--border);
        z-index: 100;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease;
        box-sizing: border-box;
    }

    /* Brand Header (Matches topbar height exactly) */
    .sidebar-brand {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        height: 64px;
        min-height: 64px;
        max-height: 64px;
        padding: 0 16px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        flex-shrink: 0;
        box-sizing: border-box;
    }

    .brand-logo-wrap {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .brand-logo-img {
        max-width: 140px;
        height: auto;
        display: block;
    }

    /* Compact Integrated User Profile Block */
    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 7px 10px;
        background: #f0f7ff;
        margin: 6px 10px 4px 10px;
        border-radius: 10px;
        flex-shrink: 0;
        border: 1px solid #e0edff;
    }

    .sidebar-user-avatar {
        width: 32px;
        height: 32px;
        background: var(--navy);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 11.5px;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .sidebar-user-info strong {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    .sidebar-user-info span {
        font-size: 11px;
        color: #64748b;
        display: block;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    /* Navigation Links (Evenly Distributed & Clean Spacing) */
    .sidebar-menu {
        padding: 6px 10px;
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.15s ease;
        cursor: pointer;
        line-height: 1.2;
    }

    .sidebar-link:hover {
        background: #f1f5f9;
        color: var(--navy);
    }

    .sidebar-link.active {
        background: #eef4ff;
        color: #2563eb;
        font-weight: 700;
        box-shadow: 0 1px 2px rgba(37, 99, 235, 0.08);
    }

    /* Bottom Logout */
    .sidebar-bottom {
        padding: 6px 10px 8px 10px;
        border-top: 1px solid var(--border);
        flex-shrink: 0;
    }

    .sidebar-link.logout-link {
        color: var(--red);
        padding: 6px 12px;
    }

    .sidebar-link.logout-link:hover {
        background: var(--red-bg);
        color: #c53030;
    }

    /* Overlay for mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        z-index: 90;
    }

    @media (max-width: 900px) {
        .admin-sidebar {
            transform: translateX(-100%);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            z-index: 999999;
        }

        .admin-sidebar.mobile-open {
            transform: translateX(0);
        }

        .sidebar-menu {
            justify-content: flex-start !important;
            gap: 2px !important;
        }

        .sidebar-bottom {
            margin-top: auto !important;
        }

        .sidebar-overlay {
            z-index: 999998;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .main,
        .main-wrapper,
        .emp-main,
        .dashboard-main {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }
</style>

<aside class="admin-sidebar" id="employeeSidebar">

    <!-- Brand Logo -->
    <div class="sidebar-brand">
        <div class="brand-logo-wrap">
            <svg class="brand-logo-img" viewBox="0 0 280 100" width="140" height="50" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <radialGradient id="empBlueSphere" cx="32%" cy="30%" r="68%">
                        <stop offset="0%" stop-color="#7399f7"/>
                        <stop offset="25%" stop-color="#2b4db3"/>
                        <stop offset="60%" stop-color="#142668"/>
                        <stop offset="90%" stop-color="#091338"/>
                        <stop offset="100%" stop-color="#04091c"/>
                    </radialGradient>
                    <radialGradient id="empGreenSphere" cx="32%" cy="30%" r="68%">
                        <stop offset="0%" stop-color="#5ec95e"/>
                        <stop offset="25%" stop-color="#238029"/>
                        <stop offset="60%" stop-color="#125219"/>
                        <stop offset="90%" stop-color="#0a3310"/>
                        <stop offset="100%" stop-color="#041a08"/>
                    </radialGradient>
                    <linearGradient id="empNeoGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#3b62c4"/>
                        <stop offset="18%" stop-color="#24459c"/>
                        <stop offset="50%" stop-color="#142b6e"/>
                        <stop offset="80%" stop-color="#0a1945"/>
                        <stop offset="100%" stop-color="#050e29"/>
                    </linearGradient>
                    <linearGradient id="empSpecularGlow" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.6"/>
                        <stop offset="40%" stop-color="#ffffff" stop-opacity="0.1"/>
                        <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
                    </linearGradient>
                    <filter id="empSphereShadow" x="-20%" y="-20%" width="140%" height="140%">
                        <feDropShadow dx="1.5" dy="2.5" stdDeviation="2" flood-color="#0a1535" flood-opacity="0.28"/>
                    </filter>
                </defs>
                <g transform="translate(6, 4)" filter="url(#empSphereShadow)">
                    <circle cx="28" cy="28" r="17" fill="url(#empBlueSphere)"/>
                    <ellipse cx="23" cy="23" rx="7" ry="4" fill="url(#empSpecularGlow)" transform="rotate(-30 23 23)"/>
                    <circle cx="62" cy="38" r="16" fill="url(#empGreenSphere)"/>
                    <ellipse cx="57" cy="33" rx="6" ry="3.5" fill="url(#empSpecularGlow)" transform="rotate(-30 57 33)"/>
                    <circle cx="30" cy="62" r="16" fill="url(#empGreenSphere)"/>
                    <ellipse cx="25" cy="57" rx="6" ry="3.5" fill="url(#empSpecularGlow)" transform="rotate(-30 25 57)"/>
                    <circle cx="62" cy="72" r="17" fill="url(#empBlueSphere)"/>
                    <ellipse cx="57" cy="67" rx="7" ry="4" fill="url(#empSpecularGlow)" transform="rotate(-30 57 67)"/>
                </g>
                <text x="96" y="58" font-family="'Impact', 'Arial Black', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="58" font-weight="900" letter-spacing="2.5" fill="url(#empNeoGrad)">NEO</text>
                <text x="130" y="84" font-family="'Playfair Display', 'Georgia', 'Times New Roman', serif" font-size="28" font-style="italic" font-weight="600" letter-spacing="0.5" fill="#0f2252">Solution</text>
            </svg>
        </div>
    </div>

    <!-- User Profile Block (Integrated Compact) -->
    <div class="sidebar-user" id="empSidebarUserBlock">
        <div class="sidebar-user-avatar" id="empSidebarAvatar">--</div>
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
            <span>Dashboard</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_02_OPEN==='function'){ Employee_user_dashboard_02_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="my_profile"
           class="sidebar-link">
            <span>My Profile</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_03_OPEN==='function'){ Employee_user_dashboard_03_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="personal_details"
           class="sidebar-link">
            <span>Personal Details</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_04_OPEN==='function'){ Employee_user_dashboard_04_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="documents"
           class="sidebar-link">
            <span>Documents</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_05_OPEN==='function'){ Employee_user_dashboard_05_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="bank_details"
           class="sidebar-link">
            <span>Bank Details</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_06_OPEN==='function'){ Employee_user_dashboard_06_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="job_information"
           class="sidebar-link">
            <span>Job Information</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_07_OPEN==='function'){ Employee_user_dashboard_07_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="daily_work_plan"
           class="sidebar-link">
            <span>Daily Work Plan</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_08_OPEN==='function'){ Employee_user_dashboard_08_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="leave_requests"
           class="sidebar-link">
            <span>Leave Requests</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function'){ Employee_user_dashboard_09_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="notifications"
           class="sidebar-link">
            <span>Notifications</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Employee_user_dashboard_10_OPEN==='function'){ Employee_user_dashboard_10_OPEN(); } if(typeof closeEmployeeSidebar==='function'){ closeEmployeeSidebar(); }"
           data-page="settings"
           class="sidebar-link">
            <span>Settings</span>
        </a>

    </nav>

    <!-- Logout -->
    <div class="sidebar-bottom">
        <a role="button" tabindex="0" class="sidebar-link logout-link" onclick="logoutUser(); return false;">
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
    }

    function openEmployeeSidebar() {
        var sb = document.getElementById('employeeSidebar');
        var ov = document.getElementById('employeeSidebarOverlay');
        if (sb) sb.classList.add('mobile-open');
        if (ov) ov.classList.add('active');
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