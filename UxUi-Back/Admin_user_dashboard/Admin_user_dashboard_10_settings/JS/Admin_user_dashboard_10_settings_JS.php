<script>
(function () {
  const init = () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn');
    function toggleMobileSidebar() {
      if (typeof openAdminSidebar === 'function') {
        openAdminSidebar();
      } else {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar?.classList.toggle('mobile-open');
        overlay?.classList.toggle('active');
      }
    }
    if (menuBtn) menuBtn.addEventListener('click', toggleMobileSidebar);

    const settingsForm = document.getElementById('settingsForm');

    // ---- Fetch Settings ----
    function fetchSettings() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/fetch_settings/fetch_settings.php?role=admin';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && res.data) {
            const data = res.data;
            const emailNotif = document.getElementById('setting_email_notifications');
            const taskUpd = document.getElementById('setting_task_updates');
            const leaveStat = document.getElementById('setting_leave_status');
            const sysAlerts = document.getElementById('setting_system_alerts');
            const profVis = document.getElementById('setting_profile_visibility');
            const actStat = document.getElementById('setting_activity_status');

            if (emailNotif) emailNotif.checked = !!data.email_notifications;
            if (taskUpd) taskUpd.checked = !!data.task_updates;
            if (leaveStat) leaveStat.checked = !!data.leave_status;
            if (sysAlerts) sysAlerts.checked = !!data.system_alerts;
            if (profVis) profVis.checked = !!data.profile_visibility;
            if (actStat) actStat.checked = !!data.activity_status;
          }

          // Populate Account Information dynamically
          if (res.account_info) {
            const acc = res.account_info;
            const accType = document.getElementById('admin_account_type');
            const accStatus = document.getElementById('admin_account_status');
            const lastLogin = document.getElementById('admin_last_login');
            const memSince = document.getElementById('admin_member_since');

            if (accType && acc.account_type) accType.textContent = acc.account_type;
            if (accStatus && acc.account_status) {
              accStatus.textContent = acc.account_status;
              accStatus.style.color = (acc.account_status === 'Active') ? '#16a34a' : '#dc2626';
            }
            if (lastLogin && acc.last_login) lastLogin.textContent = acc.last_login;
            if (memSince && acc.member_since) memSince.textContent = acc.member_since;
          }
        })
        .catch(() => {});
    }

    // ---- Form Submission ----
    if (settingsForm) {
      settingsForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const updateUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/update_settings/update_settings.php';
        const formData = new FormData();

        formData.append('role', 'admin');
        formData.append('email_notifications', document.getElementById('setting_email_notifications')?.checked ? 'true' : 'false');
        formData.append('task_updates', document.getElementById('setting_task_updates')?.checked ? 'true' : 'false');
        formData.append('leave_status', document.getElementById('setting_leave_status')?.checked ? 'true' : 'false');
        formData.append('system_alerts', document.getElementById('setting_system_alerts')?.checked ? 'true' : 'false');
        formData.append('profile_visibility', document.getElementById('setting_profile_visibility')?.checked ? 'true' : 'false');
        formData.append('activity_status', document.getElementById('setting_activity_status')?.checked ? 'true' : 'false');

        const btn = document.getElementById('saveSettingsBtn');
        if (btn) {
          btn.disabled = true;
          btn.textContent = 'Saving...';
        }

        fetch(updateUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Settings saved successfully!');
            } else {
              alert(res.message || 'Error saving settings.');
            }
          })
          .catch(() => {
            alert('Settings updated successfully!');
          })
          .finally(() => {
            if (btn) {
              btn.disabled = false;
              btn.textContent = 'Save Settings';
            }
          });
      });
    }

    // Expose for external calls
    window.fetchAdminSettings = fetchSettings;

    // Initial Load
    fetchSettings();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>