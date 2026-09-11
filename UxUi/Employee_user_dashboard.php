<?php 
include_once '../imports/need/session_setup.php';

// --- Admin Impersonation Banner ---
$is_impersonating  = !empty($_SESSION['admin_impersonating']) && $_SESSION['admin_impersonating'] === true;
$admin_name        = $is_impersonating && !empty($_SESSION['admin_impersonating_name'])
                     ? htmlspecialchars($_SESSION['admin_impersonating_name'])
                     : 'Admin';
$restore_url       = rtrim($home_page, '/') . '/View-List/Main/admin_restore_session.php';
$admin_dash_url    = rtrim($home_page, '/') . '/UxUi/Admin_user_dashboard.php';
if (!empty($_SESSION['admin_original_session']['url_home'])) {
    $orig_url = trim($_SESSION['admin_original_session']['url_home']);
    if (stripos($orig_url, 'http') === 0) {
        $admin_dash_url = $orig_url;
    } else {
        $admin_dash_url = rtrim($home_page, '/') . '/' . ltrim($orig_url, '/');
    }
}
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
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/sidebar-user.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/employee-portal.css">
</head>


<body>

<?php if ($is_impersonating): ?>
    <!-- ===== Admin Impersonation Banner ===== -->
    <div id="adminImpersonationBanner" style="
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 99999;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        gap: 12px;
        box-shadow: 0 3px 16px rgba(79,70,229,.45);
        font-family: 'Segoe UI', sans-serif;
        flex-wrap: wrap;
    ">
        <div style="display:flex; align-items:center; gap:10px; min-width:0; flex:1;">
            <span style="background:rgba(255,255,255,.2); border-radius:50%; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:16px;">👁</span>
            <div style="min-width:0;">
                <div style="font-size:13px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    Admin Preview Mode — Viewing as Employee
                </div>
                <div style="font-size:11.5px; opacity:.85; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    You are currently impersonating this account. Logged in as: <strong><?php echo $admin_name; ?></strong>
                </div>
            </div>
        </div>
        <button id="btnReturnToAdmin" onclick="adminReturnToPanel()"
            style="flex-shrink:0; display:inline-flex; align-items:center; gap:7px; padding:8px 18px; border:2px solid rgba(255,255,255,.7); border-radius:8px; background:rgba(255,255,255,.15); color:#fff; font-size:13px; font-weight:700; cursor:pointer; transition:all .2s; white-space:nowrap;"
            onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:15px;height:15px;"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
            Return to Admin Panel
        </button>
    </div>
    <!-- Push page content down so banner doesn't overlap -->
    <div style="height: 56px;"></div>
    <script>
    function adminReturnToPanel() {
        const btn = document.getElementById('btnReturnToAdmin');
        if (btn) { btn.disabled = true; btn.textContent = 'Returning…'; }

        const formData = new FormData();
        fetch('<?php echo htmlspecialchars($restore_url); ?>', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(res => {
            if (Array.isArray(res) && res[0] && res[0].error === '0') {
                window.location.href = res[0].redirect_url || '<?php echo htmlspecialchars($admin_dash_url); ?>';
            } else {
                alert('⚠️ Could not restore admin session. Redirecting to Admin Dashboard…');
                window.location.href = '<?php echo htmlspecialchars($admin_dash_url); ?>';
            }
        })
        .catch(() => {
            alert('⚠️ Network error. Redirecting to Admin Dashboard…');
            window.location.href = '<?php echo htmlspecialchars($admin_dash_url); ?>';
        });
    }
    </script>
<?php endif; ?>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            Employee_user_dashboard_close_all();
            Employee_user_dashboard_01_OPEN();

            // Keep the employee's daily presence fresh while the portal is open.
            const presenceHeartbeat = () => fetch('../UxUi-Back/Employee/heartbeat/heartbeat.php', {
                credentials: 'same-origin',
                cache: 'no-store'
            }).catch(() => {});
            presenceHeartbeat();
            window.setInterval(presenceHeartbeat, 120000);
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