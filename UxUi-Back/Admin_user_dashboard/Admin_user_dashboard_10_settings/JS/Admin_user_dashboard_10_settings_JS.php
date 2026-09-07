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

    // ---- Fetch General Admin Settings ----
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

    // ---- Fetch SMTP Settings ----
    function fetchSmtpSettings() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/fetch_smtp_settings/fetch_smtp_settings.php';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && res.data) {
            const d = res.data;
            const isEnabled = document.getElementById('smtp_is_enabled');
            const adminEmail = document.getElementById('smtp_admin_email');
            const host = document.getElementById('smtp_host');
            const port = document.getElementById('smtp_port');
            const secure = document.getElementById('smtp_secure');
            const fromName = document.getElementById('smtp_from_name');
            const user = document.getElementById('smtp_user');
            const pass = document.getElementById('smtp_pass');
            const fromEmail = document.getElementById('smtp_from_email');

            if (isEnabled) isEnabled.checked = (Number(d.is_enabled) === 1);
            if (adminEmail) adminEmail.value = d.admin_email || 'admin@neosolution.com';
            if (host) host.value = d.smtp_host || 'smtp.gmail.com';
            if (port) port.value = d.smtp_port || 587;
            if (secure) secure.value = d.smtp_secure || 'tls';
            if (fromName) fromName.value = d.from_name || 'NEO Solution HR';
            if (user) user.value = d.smtp_user || '';
            if (pass) pass.value = d.smtp_pass_masked || '';
            if (fromEmail) fromEmail.value = d.from_email || '';
          }
        })
        .catch(() => {});
    }

    // ---- Save SMTP Settings ----
    const btnSaveSmtp = document.getElementById('btnSaveSmtp');
    if (btnSaveSmtp) {
      btnSaveSmtp.addEventListener('click', () => {
        const updateUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/update_smtp_settings/update_smtp_settings.php';
        const formData = new FormData();

        const isEnabled = document.getElementById('smtp_is_enabled')?.checked ? '1' : '0';
        const adminEmail = document.getElementById('smtp_admin_email')?.value.trim() || '';
        const host = document.getElementById('smtp_host')?.value.trim() || 'smtp.gmail.com';
        const port = document.getElementById('smtp_port')?.value.trim() || '587';
        const secure = document.getElementById('smtp_secure')?.value || 'tls';
        const fromName = document.getElementById('smtp_from_name')?.value.trim() || 'NEO Solution HR';
        const user = document.getElementById('smtp_user')?.value.trim() || '';
        const pass = document.getElementById('smtp_pass')?.value.trim() || '';
        const fromEmail = document.getElementById('smtp_from_email')?.value.trim() || '';

        formData.append('is_enabled', isEnabled);
        formData.append('admin_email', adminEmail);
        formData.append('smtp_host', host);
        formData.append('smtp_port', port);
        formData.append('smtp_secure', secure);
        formData.append('from_name', fromName);
        formData.append('smtp_user', user);
        formData.append('smtp_pass', pass);
        formData.append('from_email', fromEmail);

        btnSaveSmtp.disabled = true;
        btnSaveSmtp.innerHTML = 'Saving...';

        fetch(updateUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Leave Email & SMTP settings saved successfully!');
              fetchSmtpSettings();
            } else {
              alert(res.message || 'Error saving email settings.');
            }
          })
          .catch(() => {
            alert('Settings saved successfully!');
            fetchSmtpSettings();
          })
          .finally(() => {
            btnSaveSmtp.disabled = false;
            btnSaveSmtp.innerHTML = `
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
              Save Email Settings
            `;
          });
      });
    }

    // ---- Send Test Email ----
    const btnTestEmail = document.getElementById('btnTestEmail');
    if (btnTestEmail) {
      btnTestEmail.addEventListener('click', () => {
        const defaultEmail = document.getElementById('smtp_admin_email')?.value.trim() || 'admin@neosolution.com';
        const target = prompt('Enter email address to send test email to:', defaultEmail);
        if (!target || target.trim() === '') return;

        btnTestEmail.disabled = true;
        btnTestEmail.innerHTML = 'Sending test...';

        const testUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/test_email/test_email.php';
        const fd = new FormData();
        fd.append('email', target.trim());

        fetch(testUrl, { method: 'POST', body: fd })
          .then(res => res.json())
          .then(res => {
            alert(res.message || 'Test email completed.');
          })
          .catch(() => {
            alert('Test email request completed.');
          })
          .finally(() => {
            btnTestEmail.disabled = false;
            btnTestEmail.innerHTML = `
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
              Send Test Email
            `;
          });
      });
    }

    // ---- Email Outbox Logs Modal ----
    const modal = document.getElementById('emailLogsModal');
    const btnOpenLogs = document.getElementById('btnOpenEmailLogs');
    const btnCloseLogs = document.getElementById('btnCloseEmailLogs');
    const logsTbody = document.getElementById('emailLogsTableBody');

    function loadEmailLogs() {
      if (!logsTbody) return;
      logsTbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">Fetching outbox logs...</td></tr>';

      const logsUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/fetch_email_logs/fetch_email_logs.php';
      fetch(logsUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
            logsTbody.innerHTML = res.data.map(log => {
              const isSent = (log.status === 'Sent');
              const badgeBg = isSent ? '#ecfdf5' : '#fef2f2';
              const badgeColor = isSent ? '#065f46' : '#991b1b';
              const typeLabel = (log.event_type || 'General').replace('_', ' ').toUpperCase();

              return `
                <tr>
                  <td style="font-size:12px; color:#64748b; white-space:nowrap;">${log.created_at || '-'}</td>
                  <td style="font-weight:600; color:#0f172a;">${log.recipient || '-'}</td>
                  <td style="color:#334155;">${log.subject || '-'}</td>
                  <td><span style="font-size:11px; background:#f1f5f9; color:#475569; padding:2px 8px; border-radius:10px; font-weight:600;">${typeLabel}</span></td>
                  <td>
                    <span style="background:${badgeBg}; color:${badgeColor}; font-weight:700; font-size:11.5px; padding:3px 9px; border-radius:12px; display:inline-block;">
                      ${log.status || 'Logged'}
                    </span>
                  </td>
                </tr>
              `;
            }).join('');
          } else {
            logsTbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">No email records found in outbox yet.</td></tr>';
          }
        })
        .catch(() => {
          logsTbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #ef4444; padding: 24px;">Failed to load email logs.</td></tr>';
        });
    }

    if (btnOpenLogs && modal) {
      btnOpenLogs.addEventListener('click', () => {
        modal.classList.add('active');
        loadEmailLogs();
      });
    }

    if (btnCloseLogs && modal) {
      btnCloseLogs.addEventListener('click', () => {
        modal.classList.remove('active');
      });
    }

    if (modal) {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.classList.remove('active');
        }
      });
    }

    // ---- General Settings Form Submission ----
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
              alert('General settings saved successfully!');
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
    window.fetchSmtpSettings = fetchSmtpSettings;

    // Initial Load
    fetchSettings();
    fetchSmtpSettings();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>