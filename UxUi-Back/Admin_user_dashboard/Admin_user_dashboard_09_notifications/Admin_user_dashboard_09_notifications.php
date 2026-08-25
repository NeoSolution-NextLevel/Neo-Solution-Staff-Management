<style>
    :root {
      --primary: #235ae8;
      --primary-hover: #1b49c4;
      --bg-app: #f4f7fc;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --accent-blue: #2563eb;
      --logout-color: #ef4444;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    html, body {
      height: 100%;
      background-color: var(--bg-app);
      color: var(--text-main);
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
      background: #1e3a8a;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
    }

    /* Content Layout */
    .content {
      padding: 24px 28px 48px;
      display: flex;
      flex-direction: column;
      gap: 18px;
      max-width: 100%;
      width: 100%;
      margin: 0;
      box-sizing: border-box;
    }

    .content-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      padding: 0 4px 6px 4px;
      margin-bottom: 4px;
    }

    .header-title h1 {
      font-size: 22px;
      font-weight: 800;
      color: #1e293b;
    }

    .header-title p {
      font-size: 13.5px;
      color: var(--text-muted);
      margin-top: 3px;
      font-weight: 500;
    }

    .mark-read-btn {
      background: #eff6ff;
      border: 1px solid #dbeafe;
      color: var(--accent-blue);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      padding: 8px 16px;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .mark-read-btn:hover {
      background: #dbeafe;
      color: #1d4ed8;
    }

    /* Notifications List & Cards */
    .notifications-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      width: 100%;
      max-width: 100%;
      box-sizing: border-box;
    }

    .notif-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      align-items: flex-start;
      gap: 14px;
      position: relative;
      width: 100%;
      max-width: 100%;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
      transition: transform 0.2s, box-shadow 0.2s;
      box-sizing: border-box;
    }

    .notif-card.unread {
      background: #f8fafc;
    }

    .notif-card:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .notif-icon-wrap {
      flex-shrink: 0;
    }

    .notif-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .icon-blue, .icon-rocket {
      background: #eff6ff;
      color: #2563eb;
      border: 1px solid #dbeafe;
    }

    .icon-green, .icon-check {
      background: #ecfdf5;
      color: #059669;
      border: 1px solid #a7f3d0;
    }

    .icon-amber, .icon-calendar {
      background: #fffbeb;
      color: #d97706;
      border: 1px solid #fde68a;
    }

    .icon-red {
      background: #fef2f2;
      color: #dc2626;
      border: 1px solid #fecaca;
    }

    .icon-purple {
      background: #faf5ff;
      color: #7e22ce;
      border: 1px solid #f3e8ff;
    }

    .notif-body {
      flex: 1;
      min-width: 0;
      padding-right: 14px;
    }

    .notif-title-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      margin-bottom: 4px;
      flex-wrap: wrap;
    }

    .notif-title {
      font-size: 14px;
      font-weight: 700;
      color: #1e293b;
      margin: 0;
      line-height: 1.3;
    }

    .notif-time {
      font-size: 11.5px;
      color: #94a3b8;
      font-weight: 500;
      white-space: nowrap;
      flex-shrink: 0;
    }

    .notif-msg {
      font-size: 13px;
      color: #475569;
      line-height: 1.45;
      margin: 0 0 6px 0;
      word-break: break-word;
    }

    .notif-link {
      font-size: 12px;
      color: #2563eb;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .unread-indicator {
      width: 8px;
      height: 8px;
      background: var(--accent-blue);
      border-radius: 50%;
      position: absolute;
      top: 16px;
      right: 16px;
      flex-shrink: 0;
    }

    /* Mobile Responsive Breakpoints */
    @media (max-width: 900px) {
      .main-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
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

      .content-header {
        align-items: center;
        margin-bottom: 10px;
      }

      .header-title h1 {
        font-size: 19px;
      }

      .notif-card {
        padding: 12px 14px;
        gap: 10px;
        border-radius: 12px;
        margin-bottom: 10px;
      }

      .notif-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
      }

      .notif-icon svg {
        width: 17px;
        height: 17px;
      }

      .notif-body {
        padding-right: 8px;
      }

      .unread-indicator {
        top: 12px;
        right: 12px;
        width: 7px;
        height: 7px;
      }
    }
  </style>
<div id="Admin_user_dashboard_09_notifications" style="display:none;">

  <div class="app-layout">
    <!-- Backdrop Overlay for Mobile Drawer -->
    <div class="drawer-overlay" id="drawerOverlay"></div>


    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
      
      <!-- Top Header Navigation -->
      <header class="topbar">
        <div class="topbar-left">
          <button class="menu-btn" id="menuBtn" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
          <h2 class="page-breadcrumb">Notifications</h2>
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

      <!-- Main Notifications Content -->
      <main class="content">
        <div class="content-header">
          <div class="header-title">
            <p id="notifCount">3 unread notifications</p>
          </div>
          <button class="mark-read-btn" id="markAllReadBtn" type="button">Mark all as read</button>
        </div>

        <div class="notifications-list" id="notificationsContainer">
        </div>
      </main>
    </div>
  </div>

</div>