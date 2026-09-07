<style>
    :root {
      --primary: #235ae8;
      --primary-dark: #1d3b8a;
      --primary-hover: #1b49c4;
      --bg-app: #f4f7fc;
      --sidebar-bg: #ffffff;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --accent-blue: #2563eb;
      --logout-color: #ef4444;
      --toggle-bg-off: #e2e8f0;
      --toggle-bg-on: #2563eb;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    html, body {
      min-height: 100vh;
      background-color: var(--bg-app);
      color: var(--text-main);
      overflow-x: hidden;
      overflow-y: auto;
    }

    .app-layout {
      display: flex;
      width: 100%;
      max-width: 100%;
      min-height: 100vh;
      box-sizing: border-box;
    }

    /* Mobile Drawer Overlay */
    .drawer-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.4);
      backdrop-filter: blur(2px);
      z-index: 90;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .drawer-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    /* Sidebar Navigation */
    .sidebar {
      width: 250px;
      background: var(--sidebar-bg);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      padding: 20px 16px;
      flex-shrink: 0;
      z-index: 100;
      height: 100vh;
      position: sticky;
      top: 0;
      overflow-y: auto;
      transition: transform 0.3s ease;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0 4px;
      margin-bottom: 20px;
    }

    .brand-icon {
      width: 38px;
      height: 38px;
      background: var(--primary);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      box-shadow: 0 4px 12px rgba(35, 90, 232, 0.25);
    }

    .brand-title h3 {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-main);
      line-height: 1.2;
    }

    .brand-title p {
      font-size: 11px;
      color: var(--text-muted);
    }

    .user-card {
      background: #eff6ff;
      border-radius: 14px;
      padding: 12px;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 20px;
    }

    .avatar-lg {
      width: 38px;
      height: 38px;
      background: var(--primary-dark);
      color: white;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 700;
      flex-shrink: 0;
    }

    .user-info h4 {
      font-size: 13px;
      font-weight: 700;
      color: var(--text-main);
    }

    .user-info p {
      font-size: 11px;
      color: var(--accent-blue);
      font-weight: 500;
    }

    .nav-menu {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 4px;
      flex: 1;
    }

    .nav-item a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      border-radius: 12px;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 13.5px;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .nav-item a:hover {
      background: #f1f5f9;
      color: var(--text-main);
    }

    .nav-item.active a {
      background: var(--primary-dark);
      color: white;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(29, 59, 138, 0.25);
    }

    .nav-item svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
    }

    .logout-item {
      margin-top: auto;
      padding-top: 16px;
    }

    .logout-item a {
      color: var(--logout-color);
    }

    .logout-item a:hover {
      background: #fef2f2;
      color: var(--logout-color);
    }

    /* Main Content Area */
    .main-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    /* Top Navigation Header */
    .topbar {
      background: var(--sidebar-bg);
      padding: 14px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
      height: 64px;
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .toggle-menu {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-main);
      padding: 6px;
      border-radius: 8px;
    }

    .toggle-menu:hover {
      background: #f1f5f9;
    }

    .page-breadcrumb {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-main);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .icon-btn {
      background: #f1f5f9;
      border: none;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      position: relative;
      transition: background 0.2s;
    }

    .icon-btn:hover {
      background: #e2e8f0;
    }

    .notif-dot {
      position: absolute;
      top: 9px;
      right: 9px;
      width: 7px;
      height: 7px;
      background: #ef4444;
      border-radius: 50%;
      border: 1.5px solid white;
    }

    .profile-pill {
      background: #eff6ff;
      padding: 4px 14px 4px 4px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-main);
    }

    .avatar-sm {
      width: 28px;
      height: 28px;
      background: var(--primary-dark);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
    }

    /* Settings Content Layout */
    .content {
      padding: 24px 28px 60px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 100%;
      width: 100%;
      margin: 0 0 30px 0;
      box-sizing: border-box;
    }

    .content-header {
      margin-bottom: 8px;
      padding: 0 4px;
    }

    .content-header h1 {
      font-size: 22px;
      font-weight: 800;
      color: #1e293b;
    }

    .content-header p {
      font-size: 13.5px;
      color: var(--text-muted);
      margin-top: 3px;
      font-weight: 500;
    }

    /* Settings Cards */
    .settings-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px 28px;
      width: 100%;
      max-width: 100%;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    .settings-card:last-child {
      margin-bottom: 30px;
    }

    .settings-card h3 {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 18px;
      padding-bottom: 10px;
      border-bottom: 1px solid #f1f5f9;
    }

    /* Settings Item Rows */
    .setting-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 0;
      gap: 18px;
    }

    .setting-item:not(:last-child) {
      border-bottom: 1px solid #f8fafc;
    }

    .setting-info h4 {
      font-size: 14.5px;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 3px;
    }

    .setting-info p {
      font-size: 12.5px;
      color: var(--text-muted);
    }

    /* Toggle Switch Component */
    .switch {
      position: relative;
      display: inline-block;
      width: 44px;
      height: 24px;
      flex-shrink: 0;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      inset: 0;
      background-color: var(--toggle-bg-off);
      transition: 0.3s;
      border-radius: 24px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: 0.3s;
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    input:checked + .slider {
      background-color: var(--toggle-bg-on);
    }

    input:checked + .slider:before {
      transform: translateX(20px);
    }

    /* Account Information Grid */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .info-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 16px 20px;
    }

    .info-box span {
      display: block;
      font-size: 11.5px;
      color: var(--text-muted);
      margin-bottom: 6px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .info-box strong {
      font-size: 14.5px;
      color: var(--text-main);
      font-weight: 700;
    }

    /* Action Buttons */
    .btn-submit {
      width: 100%;
      background: #14204d;
      color: white;
      border: none;
      padding: 14px 24px;
      border-radius: 12px;
      font-size: 14.5px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(20, 32, 77, 0.2);
    }

    .btn-submit:hover {
      background: #1c2b63;
      box-shadow: 0 4px 12px rgba(20, 32, 77, 0.25);
      transform: translateY(-1px);
    }

    .btn-submit:active {
      transform: scale(0.99);
    }

    /* SMTP Configuration Styles */
    .smtp-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      margin-top: 14px;
    }
    @media (max-width: 640px) {
      .smtp-grid { grid-template-columns: 1fr; }
    }
    .smtp-field {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .smtp-field label {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-main);
    }
    .smtp-field label span {
      font-weight: normal;
      color: var(--text-muted);
      font-size: 11.5px;
    }
    .smtp-input, .smtp-select {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 13.5px;
      color: var(--text-main);
      background-color: #ffffff;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .smtp-input:focus, .smtp-select:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .smtp-actions {
      display: flex;
      gap: 12px;
      margin-top: 18px;
      flex-wrap: wrap;
    }
    .btn-smtp-save {
      background: #2563eb;
      color: white;
      border: none;
      padding: 10px 22px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s;
    }
    .btn-smtp-save:hover { background: #1d4ed8; }
    .btn-smtp-test {
      background: #f1f5f9;
      color: #334155;
      border: 1px solid #cbd5e1;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }
    .btn-smtp-test:hover { background: #e2e8f0; color: #0f172a; }
    .btn-smtp-logs {
      background: #f8fafc;
      color: #475569;
      border: 1px solid #e2e8f0;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }
    .btn-smtp-logs:hover { background: #f1f5f9; color: #1e293b; }

    /* Email Outbox Modal */
    .email-logs-modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.55);
      backdrop-filter: blur(3px);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.25s, visibility 0.25s;
    }
    .email-logs-modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    .email-logs-modal {
      background: #ffffff;
      border-radius: 14px;
      width: 100%;
      max-width: 850px;
      max-height: 85vh;
      display: flex;
      flex-direction: column;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }
    .email-logs-header {
      padding: 18px 24px;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #f8fafc;
    }
    .email-logs-header h3 { font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; }
    .email-logs-close {
      background: none;
      border: none;
      font-size: 22px;
      color: #94a3b8;
      cursor: pointer;
      line-height: 1;
      padding: 4px;
    }
    .email-logs-close:hover { color: #0f172a; }
    .email-logs-body {
      padding: 20px 24px;
      overflow-y: auto;
      flex: 1;
    }
    .email-logs-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
    .email-logs-table th {
      background: #f1f5f9;
      color: #475569;
      font-weight: 600;
      text-align: left;
      padding: 10px 14px;
      border-bottom: 2px solid #e2e8f0;
    }
    .email-logs-table td {
      padding: 11px 14px;
      border-bottom: 1px solid #f1f5f9;
      color: #334155;
      vertical-align: middle;
    }
    .email-logs-table tr:hover td {
      background: #f8fafc;
    }

    /* Mobile Responsive Breakpoints */
    @media (max-width: 900px) {
      .main-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
      }

      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        transform: translateX(-100%);
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .toggle-menu,
      .menu-btn {
        display: inline-flex !important;
      }

      .topbar {
        padding: 10px 14px;
      }

      .profile-pill span {
        display: none;
      }

      .profile-pill {
        padding: 2px;
        background: transparent;
      }

      .content {
        padding: 12px 10px 70px !important;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
<div id="Admin_user_dashboard_10_settings" style="display:none;">

  <div class="app-layout">
    <!-- Mobile Drawer Backdrop Overlay -->
    <div class="drawer-overlay" id="drawerOverlay"></div>

    <!-- Main Content Area -->
    <div class="main-wrapper">
      
      <!-- Top Header Navigation -->
      <header class="topbar">
        <div class="topbar-left">
          <button class="menu-btn" id="menuBtn" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
          <h2 class="page-breadcrumb">Settings</h2>
        </div>
        <div class="topbar-right">
          <button class="icon-btn" aria-label="Notifications" onclick="Admin_user_dashboard_09_OPEN();">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="notif-dot"></span>
          </button>
          <div class="profile-pill">
            <div class="avatar-sm">AU</div>
            <span>Admin</span>
          </div>
        </div>
      </header>

      <!-- Main Settings Content -->
      <main class="content">
        <div class="content-header">
          <p>Manage your account preferences</p>
        </div>

        <form id="settingsForm">
          <!-- Section 1: Notification Preferences -->
          <section class="settings-card">
            <h3>Notification Preferences</h3>
            
            <div class="setting-item">
              <div class="setting-info">
                <h4>Email Notifications</h4>
                <p>Receive notifications via email</p>
              </div>
              <label class="switch">
                <input type="checkbox" id="setting_email_notifications" name="email_notifications" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="setting-item">
              <div class="setting-info">
                <h4>Task Updates</h4>
                <p>Get notified when tasks are assigned or updated</p>
              </div>
              <label class="switch">
                <input type="checkbox" id="setting_task_updates" name="task_updates" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="setting-item">
              <div class="setting-info">
                <h4>Leave Status</h4>
                <p>Notifications for leave request status changes</p>
              </div>
              <label class="switch">
                <input type="checkbox" id="setting_leave_status" name="leave_status" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="setting-item">
              <div class="setting-info">
                <h4>System Alerts</h4>
                <p>Important system maintenance and updates</p>
              </div>
              <label class="switch">
                <input type="checkbox" id="setting_system_alerts" name="system_alerts">
                <span class="slider"></span>
              </label>
            </div>
          </section>

          <!-- Section 2: Leave Email & SMTP Setup -->
          <section class="settings-card" id="smtpSettingsSection">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 16px;">
              <div>
                <h3 style="margin: 0; border-bottom: none; padding-bottom: 0;">Leave Email & SMTP Configuration</h3>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 3px;">Configure automated email alerts for employee leave requests, approvals, and rejections.</p>
              </div>
              <label class="switch" title="Enable / Disable SMTP Live Delivery">
                <input type="checkbox" id="smtp_is_enabled" name="smtp_is_enabled">
                <span class="slider"></span>
              </label>
            </div>

            <div class="setting-item" style="padding-top: 0; margin-bottom: 8px;">
              <div class="setting-info">
                <h4>Admin Notification Email</h4>
                <p>Employee leave requests will be sent to this email address</p>
              </div>
              <div style="min-width: 260px;">
                <input type="email" id="smtp_admin_email" class="smtp-input" placeholder="admin@neosolution.com">
              </div>
            </div>

            <div class="smtp-grid">
              <div class="smtp-field">
                <label>SMTP Host <span>(e.g., smtp.gmail.com)</span></label>
                <input type="text" id="smtp_host" class="smtp-input" placeholder="smtp.gmail.com">
              </div>

              <div class="smtp-field">
                <label>SMTP Port <span>(587 for TLS / 465 for SSL)</span></label>
                <input type="number" id="smtp_port" class="smtp-input" placeholder="587">
              </div>

              <div class="smtp-field">
                <label>Encryption Protocol</label>
                <select id="smtp_secure" class="smtp-select">
                  <option value="tls">TLS (STARTTLS - Recommended)</option>
                  <option value="ssl">SSL</option>
                  <option value="none">None (Plain)</option>
                </select>
              </div>

              <div class="smtp-field">
                <label>Sender Display Name</label>
                <input type="text" id="smtp_from_name" class="smtp-input" placeholder="NEO Solution HR">
              </div>

              <div class="smtp-field">
                <label>SMTP Username / Email</label>
                <input type="text" id="smtp_user" class="smtp-input" placeholder="hr@neosolution.com">
              </div>

              <div class="smtp-field">
                <label>SMTP Password / App Password</label>
                <input type="password" id="smtp_pass" class="smtp-input" placeholder="••••••••">
              </div>

              <div class="smtp-field" style="grid-column: span 2;">
                <label>From Email Address <span>(Sender address shown in emails)</span></label>
                <input type="email" id="smtp_from_email" class="smtp-input" placeholder="noreply@neosolution.com">
              </div>
            </div>

            <div class="smtp-actions">
              <button type="button" class="btn-smtp-save" id="btnSaveSmtp">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Save Email Settings
              </button>

              <button type="button" class="btn-smtp-test" id="btnTestEmail">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                Send Test Email
              </button>

              <button type="button" class="btn-smtp-logs" id="btnOpenEmailLogs">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                Sent Email Outbox Logs
              </button>
            </div>
          </section>

          <!-- Section 3: Privacy Settings -->
          <section class="settings-card">
            <h3>Privacy Settings</h3>

            <div class="setting-item">
              <div class="setting-info">
                <h4>Profile Visibility</h4>
                <p>Allow other employees to view your profile</p>
              </div>
              <label class="switch">
                <input type="checkbox" id="setting_profile_visibility" name="profile_visibility" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="setting-item">
              <div class="setting-info">
                <h4>Activity Status</h4>
                <p>Show your online/active status to others</p>
              </div>
              <label class="switch">
                <input type="checkbox" id="setting_activity_status" name="activity_status">
                <span class="slider"></span>
              </label>
            </div>
          </section>

          <!-- Section 3: Account Information -->
          <?php
          $admin_init_type = $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? 'Administrator';
          $admin_init_status = 'Active';
          $admin_init_last_login = date('Y-m-d');
          $admin_init_member_since = date('Y-m-d');

          try {
              if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
                  include_once __DIR__ . '/../../../imports/need/DB.php';
              }
              if (class_exists('DataBase')) {
                  $db_adm = new DataBase();
                  $conn_adm = $db_adm->get_data_base_connction();
                  $uid_adm = $_SESSION['user_id'] ?? $_SESSION['main_user_login_id'] ?? $_SESSION['user_name'] ?? '';
                  $adm_found = false;
                  if (!empty($uid_adm)) {
                      $uid_adm_esc = $conn_adm->real_escape_string((string)$uid_adm);
                      $q_adm = $conn_adm->query("SELECT * FROM `main_user_login` WHERE `id` = '$uid_adm_esc' OR `user_name` = '$uid_adm_esc' LIMIT 1");
                      if ($q_adm && $r_adm = $q_adm->fetch_assoc()) {
                          $admin_init_type = !empty($r_adm['ac_type']) ? $r_adm['ac_type'] : $admin_init_type;
                          $admin_init_status = ($r_adm['account_active_state'] == 1 || $r_adm['account_active_state'] === null) ? 'Active' : 'Inactive';
                          if (!empty($r_adm['last_login'])) $admin_init_last_login = date('Y-m-d', strtotime($r_adm['last_login']));
                          if (!empty($r_adm['sdt'])) $admin_init_member_since = date('Y-m-d', strtotime($r_adm['sdt']));
                          $adm_found = true;
                      }
                  }
                  if (!$adm_found) {
                      $q_def_adm = $conn_adm->query("SELECT * FROM `main_user_login` WHERE `main_user_account_access_level_list_id` = '1' OR `ac_type` LIKE '%Admin%' ORDER BY `id` ASC LIMIT 1");
                      if ($q_def_adm && $r_def_adm = $q_def_adm->fetch_assoc()) {
                          $admin_init_type = !empty($r_def_adm['ac_type']) ? $r_def_adm['ac_type'] : 'Administrator';
                          $admin_init_status = ($r_def_adm['account_active_state'] == 1 || $r_def_adm['account_active_state'] === null) ? 'Active' : 'Inactive';
                          if (!empty($r_def_adm['last_login'])) $admin_init_last_login = date('Y-m-d', strtotime($r_def_adm['last_login']));
                          if (!empty($r_def_adm['sdt'])) $admin_init_member_since = date('Y-m-d', strtotime($r_def_adm['sdt']));
                      }
                  }
              }
          } catch (Exception $ex) {}
          ?>
          <section class="settings-card">
            <h3>Account Information</h3>

            <div class="info-grid">
              <div class="info-box">
                <span>Account Type</span>
                <strong id="admin_account_type"><?php echo htmlspecialchars($admin_init_type); ?></strong>
              </div>
              <div class="info-box">
                <span>Account Status</span>
                <strong id="admin_account_status" style="color:<?php echo ($admin_init_status === 'Active') ? '#16a34a' : '#dc2626'; ?>;"><?php echo htmlspecialchars($admin_init_status); ?></strong>
              </div>
              <div class="info-box">
                <span>Last Login</span>
                <strong id="admin_last_login"><?php echo htmlspecialchars($admin_init_last_login); ?></strong>
              </div>
              <div class="info-box">
                <span>Member Since</span>
                <strong id="admin_member_since"><?php echo htmlspecialchars($admin_init_member_since); ?></strong>
              </div>
            </div>

            <button type="submit" class="btn-submit" id="saveSettingsBtn">Save Settings</button>
          </section>
        </form>
      </main>
    </div>
  </div>

  <!-- Email Logs Modal -->
  <div class="email-logs-modal-overlay" id="emailLogsModal">
    <div class="email-logs-modal">
      <div class="email-logs-header">
        <div style="display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <h3>Sent Email Outbox Logs</h3>
        </div>
        <button type="button" class="email-logs-close" id="btnCloseEmailLogs">&times;</button>
      </div>
      <div class="email-logs-body">
        <p style="font-size: 13px; color: #64748b; margin-bottom: 14px;">Recent email dispatch records and status for leave requests and notifications.</p>
        <div style="overflow-x: auto;">
          <table class="email-logs-table">
            <thead>
              <tr>
                <th>Date & Time</th>
                <th>Recipient</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="emailLogsTableBody">
              <tr>
                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">Loading email logs...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>