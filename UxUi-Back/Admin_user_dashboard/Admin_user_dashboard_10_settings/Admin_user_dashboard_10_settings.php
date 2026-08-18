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
      width: 100vw;
      min-height: 100vh;
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
      padding: 16px 20px 40px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      max-width: 100%;
      width: 100%;
      margin: 0 0 30px 0;
    }

    .content-header {
      margin-bottom: 4px;
    }

    .content-header h1 {
      font-size: 22px;
      font-weight: 800;
      color: #1e293b;
    }

    .content-header p {
      font-size: 13px;
      color: var(--text-muted);
      margin-top: 3px;
    }

    /* Settings Cards */
    .settings-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px 18px;
      width: 100%;
      max-width: 100%;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
      margin-bottom: 8px;
    }

    .settings-card:last-child {
      margin-bottom: 24px;
    }

    .settings-card h3 {
      font-size: 15px;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 14px;
    }

    /* Settings Item Rows */
    .setting-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 0;
      gap: 16px;
    }

    .setting-item:not(:last-child) {
      border-bottom: 1px solid #f1f5f9;
    }

    .setting-info h4 {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 2px;
    }

    .setting-info p {
      font-size: 12px;
      color: var(--text-muted);
    }

    /* Custom Toggle Switch */
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
      gap: 12px;
      margin-bottom: 20px;
    }

    .info-box {
      background: #f8fafc;
      border: 1px solid #f1f5f9;
      border-radius: 12px;
      padding: 12px 16px;
    }

    .info-box span {
      display: block;
      font-size: 11px;
      color: var(--text-muted);
      margin-bottom: 4px;
      font-weight: 500;
    }

    .info-box strong {
      font-size: 13.5px;
      color: var(--text-main);
      font-weight: 700;
    }

    /* Action Buttons */
    .btn-submit {
      width: 100%;
      background: var(--primary-dark);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, transform 0.1s;
    }

    .btn-submit:hover {
      background: #172e6d;
    }

    .btn-submit:active {
      transform: scale(0.99);
    }

    /* Mobile Responsive Breakpoints */
    @media (max-width: 900px) {
      .main-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 12px 12px 80px !important;
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
        padding: 12px 16px;
      }

      .profile-pill span {
        display: none;
      }

      .profile-pill {
        padding: 2px;
        background: transparent;
      }

      .content {
        padding: 20px 16px;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
<div id="Admin_user_dashboard_10_settings">

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

          <!-- Section 2: Privacy Settings -->
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
          <section class="settings-card">
            <h3>Account Information</h3>

            <div class="info-grid">
              <div class="info-box">
                <span>Account Type</span>
                <strong>Administrator</strong>
              </div>
              <div class="info-box">
                <span>Account Status</span>
                <strong>Active</strong>
              </div>
              <div class="info-box">
                <span>Last Login</span>
                <strong>2026-08-07</strong>
              </div>
              <div class="info-box">
                <span>Member Since</span>
                <strong>2022-01-15</strong>
              </div>
            </div>

            <button type="submit" class="btn-submit" id="saveSettingsBtn">Save Settings</button>
          </section>
        </form>
      </main>
    </div>
  </div>

</div>