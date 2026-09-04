<style>
  /* =========================================================
     ADMIN EMPLOYEES PAGE
  ========================================================= */
  :root {
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #38a169;
    --green-bg: #e3f9ee;
    --amber: #dd6b20;
    --amber-bg: #fdf1dc;
    --red: #e53e3e;
    --red-bg: #fde8ec;
    --ink: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
    --card: #ffffff;
    --radius: 16px;
    --shadow: 0 1px 2px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
  }

  * { box-sizing: 
        border-box; 
        margin: 0; 
        padding: 0; 
    }

  #Admin_user_dashboard_02_employees {
    width: 100%;
    min-height: 100vh;
  }

  .main, .w3-main-content {
    margin-left: 250px;
    width: calc(100% - 250px);
    max-width: calc(100% - 250px);
    min-height: 100vh;
    padding: 16px 20px 24px;
    box-sizing: border-box;
    transition: margin-left 0.3s ease, width 0.3s ease;
  }

  /* Topbar */
  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }
  .topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
  }

  .topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--blue-lighter);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
  }
  .icon-btn svg {
    width: 18px;
    height: 18px;
    color: var(--navy);
  }
  .dot {
    position: absolute;
    top: 8px;
    right: 9px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--red);
    border: 2px solid var(--card);
  }

  .admin-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--blue-lighter);
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    cursor: pointer;
  }
  .admin-pill .avatar {
    width: 30px;
    height: 30px;
    font-size: 11.5px;
    background: var(--navy);
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
  }
  .admin-pill span {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--navy);
  }

  .menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: var(--blue-lighter);
    border: none;
    cursor: pointer;
    color: var(--navy);
    margin-right: 6px;
  }
  .menu-btn svg { width: 20px; height: 20px; }

  /* Page Head */
  .w3-page-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 12px;
  }
  .w3-page-head p {
    font-size: 14px;
    color: var(--muted);
    margin: 0;
    font-weight: 500;
  }

  .w3-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: var(--blue);
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    border: none;
    padding: 11px 20px;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(59,91,219,.25);
    transition: background-color 0.15s ease, transform 0.1s ease;
    white-space: nowrap;
  }
  .w3-btn-primary:hover { background-color: #2f4ec7; transform: translateY(-1px); }
  .w3-btn-primary svg { width: 16px; height: 16px; }

  /* Toolbar: Search & Filter Pills */
  .w3-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .w3-search-box {
    flex: 1;
    min-width: 220px;
    display: flex;
    align-items: center;
    gap: 10px;
    background-color: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px;
    box-shadow: 0 1px 2px rgba(20,25,60,.03);
  }
  .w3-search-box svg {
    width: 16px;
    height: 16px;
    color: var(--muted);
    flex-shrink: 0;
  }
  .w3-search-box input {
    border: none;
    outline: none;
    flex: 1;
    font-size: 13.5px;
    color: var(--ink);
    background: transparent;
    font-family: inherit;
  }
  .w3-search-box input::placeholder { color: #94a3b8; }

  .w3-filter-pills {
    display: flex;
    gap: 8px;
  }
  .w3-pill {
    padding: 9px 18px;
    border-radius: 999px;
    background-color: var(--card);
    border: 1px solid var(--border);
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s ease;
  }
  .w3-pill.active {
    background-color: var(--navy);
    color: #ffffff;
    border-color: var(--navy);
  }
  .w3-pill:not(.active):hover { 
    background-color: var(--blue-lighter); 
    color: var(--blue); 
  }

  /* Desktop Table Layout */
  .w3-table-card {
    background-color: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    width: 100%;
    margin-bottom: 24px;
  }

  .w3-table-wrap {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  table.emp-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
  }
  table.emp-table thead th {
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--muted);
    font-weight: 700;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    background-color: #fafbfd;
  }
  table.emp-table tbody td {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    font-size: 13.5px;
    color: #334155;
    white-space: nowrap;
  }
  table.emp-table tbody tr:last-child td { border-bottom: none; }
  table.emp-table tbody tr:hover { background-color: #fafbfd; }
  table.emp-table thead th:last-child,
  table.emp-table tbody td:last-child {
    text-align: center !important;
  }

  .emp-cell { display: flex; align-items: center; gap: 12px; }
  .emp-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: var(--blue);
    color: #ffffff;
    font-size: 12.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .emp-name { font-size: 14px; font-weight: 700; color: var(--ink); }
  .emp-email { font-size: 12px; color: var(--muted); margin-top: 1px; }

  .status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
  }
  .status-badge.active { background-color: var(--green-bg); color: var(--green); }
  .status-badge.inactive { background-color: var(--red-bg); color: var(--red); }

  .row-actions { display: flex; align-items: center; justify-content: center; margin: 0 auto; gap: 6px; }
  .action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
    transition: filter 0.15s ease, transform 0.15s ease;
  }
  .action-btn svg { width: 16px; height: 16px; }
  .action-btn.view { background-color: var(--blue-lighter); color: var(--blue); }
  .action-btn:hover { filter: brightness(0.92); transform: translateY(-1px); }

  /* Selectable Working Day Chips */
  .day-chips-container {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 6px;
  }
  .day-chip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #cbd5e1;
    user-select: none;
    transition: all 0.15s ease;
  }
  .day-chip:hover {
    background: #e2e8f0;
    color: #1e293b;
  }
  .day-chip.active {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25);
  }

  /* Mobile Phone Cards View */
  .mobile-emp-cards {
    display: none;
    flex-direction: column;
    gap: 12px;
    width: 100%;
    margin-bottom: 24px;
  }

  .mobile-emp-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 16px;
    box-shadow: 0 1px 3px rgba(20,25,60,.04);
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .mobile-emp-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .mobile-emp-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 12px;
    background: #f8fafc;
    border-radius: 10px;
    padding: 10px 12px;
    border: 1px solid #eef2f6;
  }

  .mobile-emp-info-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }
  .mobile-emp-info-label {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
  }
  .mobile-emp-info-val {
    font-size: 12.5px;
    color: #1e293b;
    font-weight: 700;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .mobile-emp-card-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .btn-mobile-emp-view {
    flex: 1;
    background: #eef2ff;
    color: #3b5bdb;
    font-size: 12.5px;
    font-weight: 700;
    border: 1px solid #dbe4ff;
    border-radius: 8px;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
  }

  .btn-mobile-emp-edit {
    flex: 1;
    background: #e6f4ea;
    color: #12b76a;
    font-size: 12.5px;
    font-weight: 700;
    border: 1px solid #cbf0d8;
    border-radius: 8px;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
  }

  .btn-mobile-emp-del {
    background: #fde8ec;
    color: #f0576a;
    font-size: 12.5px;
    font-weight: 700;
    border: 1px solid #fecdd3;
    border-radius: 8px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  .w3-modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 12px;
    box-sizing: border-box;
    overflow-y: auto;
  }
  .w3-modal-overlay.active { display: flex; }

  .w3-modal-card {
    background-color: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 480px;
    max-height: 88vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    overflow: hidden;
    margin: auto;
    position: relative;
  }

  .emp-tab-btn {
    padding: 10px 14px;
    border: none;
    background: transparent;
    font-size: 12.5px;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    border-bottom: 2.5px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    transition: all 0.2s ease;
  }
  .emp-tab-btn:hover {
    color: #1e293b;
  }
  .emp-tab-btn.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
    background: rgba(37, 99, 235, 0.05);
  }

  .w3-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    background-color: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    flex-shrink: 0;
  }
  .w3-modal-header h3 { font-size: 16px; font-weight: 800; color: var(--navy); margin: 0; }
  .w3-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    color: #64748b;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
  }

  .w3-modal-form-wrapper {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    overflow: hidden;
  }

  .w3-modal-body-scroll {
    flex: 1;
    overflow-y: auto;
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    -webkit-overflow-scrolling: touch;
  }

  .w3-form-group { display: flex; flex-direction: column; gap: 4px; }
  .w3-form-group label { font-size: 12px; font-weight: 700; color: #475569; }
  .w3-form-group input, .w3-form-group select {
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13.5px;
    color: #1e293b;
    outline: none;
    background-color: #ffffff;
  }
  .w3-form-group input:focus, .w3-form-group select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59, 91, 219, 0.15);
  }

  .w3-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

  .w3-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 12px 18px;
    background: #ffffff;
    border-top: 1px solid #f1f5f9;
    flex-shrink: 0;
  }
  .w3-btn-cancel {
    padding: 9px 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background-color: #ffffff;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
  }
  .w3-btn-save {
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    background-color: var(--blue);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(59, 91, 219, 0.25);
  }

  .w3-emp-profile-modal { max-width: 460px; padding: 0; }
  .w3-emp-profile-header {
    position: relative;
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-2) 100%);
    height: 85px;
    padding: 12px 16px;
    flex-shrink: 0;
  }
  .w3-emp-profile-header .w3-modal-close { position: absolute; top: 10px; right: 14px; color: #ffffff; z-index: 10; font-size: 24px; }
  .w3-emp-profile-avatar-wrap {
    position: absolute; bottom: -24px; left: 18px; display: flex; align-items: flex-end; gap: 12px;
  }
  .w3-emp-profile-avatar {
    width: 60px; height: 60px; border-radius: 50%;
    background-color: var(--blue); color: #ffffff;
    font-size: 19px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    border: 3px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }
  .w3-emp-profile-body {
    padding: 32px 18px 16px;
    flex: 1;
    overflow-y: auto;
  }
  .w3-emp-profile-name { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 2px; }
  .w3-emp-profile-role { font-size: 13px; font-weight: 700; color: var(--blue); margin-bottom: 2px; }
  .w3-emp-profile-email { font-size: 12.5px; color: var(--muted); margin-bottom: 12px; }
  .w3-emp-profile-details-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; margin-bottom: 12px;
  }
  .w3-detail-box { display: flex; flex-direction: column; gap: 2px; }
  .w3-detail-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; }
  .w3-detail-val { font-size: 13px; font-weight: 700; color: #1e293b; }
  .w3-emp-profile-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; text-align: center; }
  .w3-p-stat { background-color: var(--blue-lighter); padding: 8px; border-radius: 8px; }
  .w3-p-stat .num { display: block; font-size: 14px; font-weight: 800; color: var(--navy); }
  .w3-p-stat .lbl { font-size: 11px; color: var(--muted); font-weight: 600; }

  @media (max-width: 768px) {
    #Admin_user_dashboard_02_employees {
      padding: 0 12px 80px !important;
    }
    .main, .w3-main-content {
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 0 !important;
    }

    .menu-btn { display: inline-flex !important; }
    .topbar h2 { font-size: 18px !important; }
    .w3-page-head {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }
    .w3-btn-primary {
      width: 100%;
      justify-content: center;
    }

    .w3-toolbar {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .w3-search-box { width: 100%; }
    .w3-filter-pills {
      overflow-x: auto;
      padding-bottom: 4px;
      -webkit-overflow-scrolling: touch;
    }

    .w3-table-card { display: none !important; }
    .mobile-emp-cards { display: flex !important; }

    .w3-form-row { grid-template-columns: 1fr; gap: 8px; }
    .w3-emp-profile-details-grid { grid-template-columns: 1fr; gap: 8px; }
    .w3-modal-card { width: 100%; max-height: 92vh; }
  }

  @media (max-height: 520px) {
    .w3-modal-card {
      max-height: 94vh !important;
    }
    .w3-modal-header {
      padding: 10px 14px !important;
    }
    .w3-modal-body-scroll {
      padding: 10px 14px !important;
      gap: 8px !important;
    }
    .w3-modal-footer {
      padding: 8px 14px !important;
    }
  }
</style>

<div id="Admin_user_dashboard_02_employees" class="w3-container" style="display:none; padding:0;">
  <div class="overlay" id="overlay"></div>

  <!-- MAIN -->
  <main class="main w3-main-content">

    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_02" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Employees</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="Admin_user_dashboard_09_OPEN();" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill">
          <div class="avatar">AU</div>
          <span>Admin</span>
        </div>
      </div>
    </div>

    <div class="w3-page-head">
      <div>
        <p id="empCount">0 total employees</p>
      </div>
      <button class="w3-btn-primary" id="openAddEmpBtn" type="button">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        Add Employee
      </button>
    </div>

    <div class="w3-toolbar" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
      <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; flex:1; min-width:280px;">
        <div class="w3-search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          <input type="text" id="searchInput" placeholder="Search employees...">
        </div>
        <div class="w3-filter-pills" id="filterPills">
          <div class="w3-pill active" data-filter="all">All</div>
          <div class="w3-pill" data-filter="active">Active</div>
          <div class="w3-pill" data-filter="inactive">Inactive</div>
        </div>
      </div>

      <!-- Quick Auto-Login as Employee Dropdown -->
      <div class="quick-login-wrap" style="display:inline-flex; align-items:center; gap:8px; background:#f5f3ff; border:1.5px solid #ddd6fe; padding:4px 12px; border-radius:12px;">
        <span style="font-size:12.5px; font-weight:800; color:#6366f1; display:inline-flex; align-items:center; gap:6px; white-space:nowrap;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M19 8l2 2-2 2"/><path d="M17 10h4"/></svg>
          Auto Login:
        </span>
        <select id="quickAutoLoginSelect" onchange="if(typeof handleQuickAutoLogin==='function'){handleQuickAutoLogin(this.value);}"
          style="padding:6px 10px; border-radius:8px; border:1px solid #c7d2fe; background:#ffffff; font-size:12.5px; font-weight:700; color:#312e81; cursor:pointer; outline:none; max-width:240px; box-shadow:0 1px 2px rgba(99,102,241,.1);">
          <option value="">⚡ Select Employee to Login...</option>
        </select>
      </div>
    </div>

    <!-- 1. Desktop & Tablet Table -->
    <div class="w3-table-card">
      <div class="w3-table-wrap">
        <table class="emp-table">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Department</th>
              <th>Job Role</th>
              <th>Status</th>
              <th>Joined</th>
              <th style="text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody id="empTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- 2. Mobile Phone Responsive Cards List -->
    <div class="mobile-emp-cards" id="mobileEmpCardsContainer">
      <div style="text-align:center; padding: 30px 16px; color: #64748b; background:#fff; border-radius:12px;">
        Loading employees...
      </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="w3-modal-overlay" id="addEmpModal">
      <div class="w3-modal-card">
        <div class="w3-modal-header">
          <h3>Add New Employee</h3>
          <button type="button" class="w3-modal-close" id="closeAddEmpModal">&times;</button>
        </div>
        <form id="addEmpForm" class="w3-modal-form-wrapper">
          <div class="w3-modal-body-scroll">
            <div class="w3-form-group">
              <label>Full Name</label>
              <input type="text" name="name" required placeholder="e.g. Kasun Kalhara">
            </div>
            <div class="w3-form-group">
              <label>Email Address</label>
              <input type="email" name="email" required placeholder="e.g. kasun@office.com">
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Department</label>
                <select name="dept" id="addEmpDept" required>
                  <option value="">Select Department...</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Job Role</label>
                <select name="role" id="addJobRole" required>
                  <option value="">Select Department first...</option>
                </select>
              </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Status</label>
                <select name="status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Joined Date</label>
                <input type="date" name="joined" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>

            <!-- Work Schedule Section -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:14px 0 8px; border-top:1px solid #e2e8f0; padding-top:12px;">Work Schedule & Shift Timing</div>
            
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Work Shift & Hours</label>
                <select id="addEmpShiftSelect" onchange="onAddEmpShiftChange(this.value)">
                  <option value="08:00 AM – 05:00 PM"selected>08:00 AM – 05:00 PM</option>
                  <option value="08:30 AM – 05:30 PM">08:30 AM – 05:30 PM</option>
                  <option value="09:00 AM – 06:00 PM">09:00 AM – 06:00 PM</option>
                  <option value="custom">Custom Time Selection...</option>
                </select>
                <input type="hidden" name="work_shift" id="addEmpWorkShift" value="08:30 AM – 05:30 PM">
              </div>
              <div class="w3-form-group" id="addEmpCustomTimeGroup" style="display:none;">
                <label>Custom Start & End Time</label>
                <div style="display:flex; align-items:center; gap:6px;">
                  <input type="time" id="addEmpCustomStart" value="08:30" onchange="onAddEmpCustomTimeChange()" style="flex:1;">
                  <span style="font-weight:700; color:#64748b;">to</span>
                  <input type="time" id="addEmpCustomEnd" value="17:30" onchange="onAddEmpCustomTimeChange()" style="flex:1;">
                </div>
              </div>
            </div>

            <div class="w3-form-group">
              <label>Weekly Work Schedule (On-Site, WFH, Leave)</label>
              <div style="font-size:11.5px; color:#64748b; margin-bottom:8px;">Choose On-Site, WFH, or Leave for each day:</div>
              <input type="hidden" name="weekly_roster" id="addEmpWeeklyRoster" value='{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}'>
              <input type="hidden" name="working_days" id="addEmpWorkingDays" value="Mon,Tue,Wed,Thu,Fri">
              
              <div class="roster-grid-admin" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(76px, 1fr)); gap:6px;">
                <!-- Mon -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Mon</span>
                  <select id="addRoster_Mon" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Tue -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Tue</span>
                  <select id="addRoster_Tue" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Wed -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Wed</span>
                  <select id="addRoster_Wed" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Thu -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Thu</span>
                  <select id="addRoster_Thu" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Fri -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Fri</span>
                  <select id="addRoster_Fri" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Sat -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Sat</span>
                  <select id="addRoster_Sat" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite">On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave" selected>Leave</option>
                  </select>
                </div>
                <!-- Sun -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Sun</span>
                  <select id="addRoster_Sun" onchange="syncAdminRoster('add')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite">On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave" selected>Leave</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="w3-modal-footer">
            <button type="button" class="w3-btn-cancel" id="cancelAddEmpModal">Cancel</button>
            <button type="submit" class="w3-btn-save">Save Employee</button>
          </div>
        </form>
      </div>
      </div>
</div>
    </div>

    <!-- View Employee Profile Details Card Modal -->
    <!-- View Employee Full Account Details Modal -->
    <div class="w3-modal-overlay" id="viewEmpModal">
      <div class="w3-modal-card w3-emp-profile-modal" style="max-width: 760px; width: 95%;">
        <div class="w3-emp-profile-header" style="height: 100px; background: linear-gradient(135deg, #14204d 0%, #1c2b63 50%, #2e4cad 100%);">
          <button type="button" class="w3-modal-close" id="closeViewEmpModal" style="top:12px; right:16px;">&times;</button>
          <div class="w3-emp-profile-avatar-wrap" style="bottom:-32px;">
            <div class="w3-emp-profile-avatar" id="viewEmpAvatar" style="width:72px; height:72px; font-size:24px; border:4px solid #ffffff; overflow:hidden;">--</div>
          </div>
        </div>

        <div style="padding: 38px 22px 0; background: #ffffff;">
          <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
            <div>
              <h2 class="w3-emp-profile-name" id="viewEmpName" style="font-size:22px; font-weight:800; color:#14204d; margin:0 0 2px;">Loading...</h2>
              <p class="w3-emp-profile-role" style="font-size:13.5px; font-weight:700; color:#2563eb; margin:0;"><span id="viewEmpRole">—</span> • <span id="viewEmpDept">—</span></p>
            </div>
            <div style="display:flex; gap:6px;">
              <span class="status-badge active" id="viewEmpStatus" style="font-size:12px; padding:4px 12px;">Active</span>
              <span class="status-badge" id="viewEmpCode" style="background:#eff6ff; color:#2563eb; font-size:12px; padding:4px 12px;">EMP-001</span>
            </div>
          </div>

          <!-- Tab Navigation -->
          <div class="emp-profile-tab-nav" style="display:flex; gap:6px; border-bottom:1px solid #e2e8f0; overflow-x:auto;">
            <button type="button" class="emp-tab-btn active" id="btnTabOverview" onclick="switchEmpTab('tabOverview', this)">
              <i class="fa-solid fa-user"></i> Overview
            </button>
            <button type="button" class="emp-tab-btn" id="btnTabWorkPlan" onclick="switchEmpTab('tabWorkPlan', this)">
              <i class="fa-solid fa-list-check"></i> Work Plan
            </button>
            <button type="button" class="emp-tab-btn" id="btnTabBank" onclick="switchEmpTab('tabBank', this)">
              <i class="fa-solid fa-building-columns"></i> Bank Account
            </button>
            <button type="button" class="emp-tab-btn" id="btnTabDocs" onclick="switchEmpTab('tabDocs', this)">
              <i class="fa-solid fa-folder-open"></i> Documents
            </button>
            <button type="button" class="emp-tab-btn" id="btnTabTasks" onclick="switchEmpTab('tabTasks', this)">
              <i class="fa-solid fa-clipboard-check"></i> Tasks & Leaves
            </button>
          </div>
        </div>

        <div class="w3-emp-profile-body" style="padding: 16px 22px 18px; max-height: 60vh; overflow-y: auto;">
          
          <!-- TAB 1: OVERVIEW -->
          <div class="emp-tab-pane active" id="tabOverview">
            <!-- Section 1: Contact & Communication -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:8px 0 8px;">Contact & Residence</div>
            <div class="w3-emp-profile-details-grid" style="margin-bottom: 14px;">
              <div class="w3-detail-box">
                <span class="w3-detail-label">Email Address</span>
                <strong class="w3-detail-val" id="viewEmpEmail" style="color:#2563eb;">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Phone Number</span>
                <strong class="w3-detail-val" id="viewEmpPhone">—</strong>
              </div>
              <div class="w3-detail-box" style="grid-column: 1 / -1;">
                <span class="w3-detail-label">Residential Address</span>
                <strong class="w3-detail-val" id="viewEmpAddress">—</strong>
              </div>
            </div>

            <!-- Section 2: Identity & Demographics -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:14px 0 8px;">Identity & Personal Information</div>
            <div class="w3-emp-profile-details-grid" style="margin-bottom: 14px;">
              <div class="w3-detail-box">
                <span class="w3-detail-label">NIC / Passport Number</span>
                <strong class="w3-detail-val" id="viewEmpNic">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Date of Birth</span>
                <strong class="w3-detail-val" id="viewEmpDob">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Gender</span>
                <strong class="w3-detail-val" id="viewEmpGender">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Work Location</span>
                <strong class="w3-detail-val" id="viewEmpLocation">—</strong>
              </div>
            </div>

            <!-- Section 3: Emergency Contacts -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:14px 0 8px;">Emergency Contacts</div>
            <div class="w3-emp-profile-details-grid" style="margin-bottom: 14px;">
              <div class="w3-detail-box">
                <span class="w3-detail-label">Emergency Contact Name</span>
                <strong class="w3-detail-val" id="viewEmpEmName">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Emergency Contact Phone</span>
                <strong class="w3-detail-val" id="viewEmpEmPhone">—</strong>
              </div>
            </div>

            <!-- Section 4: Work Schedule -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:14px 0 8px;">Work Schedule & Duty Arrangement</div>
            <div class="w3-emp-profile-details-grid" style="margin-bottom: 10px;">
              <div class="w3-detail-box">
                <span class="w3-detail-label">Work Shift</span>
                <strong class="w3-detail-val" id="viewEmpWorkShift">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Working Days</span>
                <strong class="w3-detail-val" id="viewEmpWorkingDays">—</strong>
              </div>
            </div>
            <div id="viewEmpRosterWrap" style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:14px;"></div>

            <!-- Section 5: Employment Information -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:14px 0 8px;">Employment Snapshot</div>
            <div class="w3-emp-profile-details-grid">
              <div class="w3-detail-box">
                <span class="w3-detail-label">Date Joined</span>
                <strong class="w3-detail-val" id="viewEmpJoined">—</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Employment Type</span>
                <strong class="w3-detail-val" id="viewEmpType">—</strong>
              </div>
            </div>
          </div>

          <!-- TAB 2: DAILY WORK PLAN -->
          <div class="emp-tab-pane" id="tabWorkPlan" style="display:none;">
            <div id="viewEmpWorkPlanContent">
              <div style="text-align:center; padding:30px; color:#94a3b8;">Loading work plans...</div>
            </div>
          </div>

          <!-- TAB 3: BANK ACCOUNT -->
          <div class="emp-tab-pane" id="tabBank" style="display:none;">
            <div id="viewEmpBankContent">
              <div style="text-align:center; padding:30px; color:#94a3b8;">Loading bank details...</div>
            </div>
          </div>

          <!-- TAB 4: DOCUMENTS -->
          <div class="emp-tab-pane" id="tabDocs" style="display:none;">
            <div id="viewEmpDocsContent">
              <div style="text-align:center; padding:30px; color:#94a3b8;">Loading documents...</div>
            </div>
          </div>

          <!-- TAB 5: TASKS & LEAVES -->
          <div class="emp-tab-pane" id="tabTasks" style="display:none;">
            <div id="viewEmpTasksContent">
              <div style="text-align:center; padding:30px; color:#94a3b8;">Loading tasks and leaves...</div>
            </div>
          </div>

        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelViewEmpModal">Close</button>
          <button type="button" id="btnLoginAsEmpFromView" onclick="loginAsCurrentEmp()"
            style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border:none; border-radius:10px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; font-size:13.5px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(99,102,241,.3); transition:all .2s;"
            onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M19 8l2 2-2 2"/><path d="M17 10h4"/></svg>
            Login as Employee
          </button>
          <button type="button" class="w3-btn-save" id="btnEditFromViewModal" onclick="editCurrentEmpFromView()">Edit Employee</button>
        </div>
      </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="w3-modal-overlay" id="editEmpModal">
      <div class="w3-modal-card">
        <div class="w3-modal-header">
          <h3>Edit Employee Profile</h3>
          <button type="button" class="w3-modal-close" id="closeEditEmpModal">&times;</button>
        </div>
        <form id="editEmpForm" class="w3-modal-form-wrapper">
          <input type="hidden" name="id" id="editEmpId">
          <div class="w3-modal-body-scroll">
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="editEmpName" readonly placeholder="e.g. Kasun Kalhara" style="background-color: #f1f5f9; cursor: not-allowed;">
              </div>
              <div class="w3-form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="editEmpEmail" readonly placeholder="e.g. kasun@office.com" style="background-color: #f1f5f9; cursor: not-allowed;">
              </div>
            </div>
            
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Department</label>
                <select name="dept" id="editEmpDept">
                  <option value=""></option>
                </select>
              </div>

              <div class="w3-form-group">
                <label>Job Role</label>
                <select name="role" id="editEmpRole">
                  <option value=""></option>
                </select>
              </div>
            </div>
            
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Status</label>
                <select name="status" id="editEmpStatus">
                  <option value="active">On-Site (Active)</option>
                  <option value="inactive">Remote</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Joined Date</label>
                <input type="date" name="joined" id="editEmpJoined">
              </div>
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Emergency Contact Name</label>
                <input type="text" name="emergency_contact_name" id="editEmpEmName" placeholder="e.g. Namal Perera">
              </div>
              <div class="w3-form-group">
                <label>Emergency Contact Phone</label>
                <input type="text" name="emergency_contact_phone" id="editEmpEmPhone" placeholder="e.g. 0771234567">
              </div>
            </div>
            <!-- Work Schedule Section -->
            <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin:16px 0 8px; border-top:1px solid #e2e8f0; padding-top:14px;">Work Schedule & Shift Timing</div>
            
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Work Shift & Hours</label>
                <select id="editEmpShiftSelect" onchange="onEditEmpShiftChange(this.value)">
                  <option value="08:00 AM – 05:00 PM" selected>08:00 AM – 05:00 PM</option>
                  <option value="08:30 AM – 05:30 PM">08:30 AM – 05:30 PM</option>
                  <option value="09:00 AM – 06:00 PM">09:00 AM – 06:00 PM</option>
                  <option value="custom">Custom Time Selection...</option>
                </select>
                <input type="hidden" name="work_shift" id="editEmpWorkShift" value="08:30 AM – 05:30 PM">
              </div>
              <div class="w3-form-group" id="editEmpCustomTimeGroup" style="display:none;">
                <label>Custom Start & End Time</label>
                <div style="display:flex; align-items:center; gap:6px;">
                  <input type="time" id="editEmpCustomStart" value="08:30" onchange="onEditEmpCustomTimeChange()" style="flex:1;">
                  <span style="font-weight:700; color:#64748b;">to</span>
                  <input type="time" id="editEmpCustomEnd" value="17:30" onchange="onEditEmpCustomTimeChange()" style="flex:1;">
                </div>
              </div>
            </div>

            <div class="w3-form-group">
              <label>Weekly Work Schedule (On-Site, WFH, Leave)</label>
              <div style="font-size:11.5px; color:#64748b; margin-bottom:8px;">Choose On-Site, WFH, or Leave for each day:</div>
              <input type="hidden" name="weekly_roster" id="editEmpWeeklyRoster" value='{"Mon":"onsite","Tue":"onsite","Wed":"onsite","Thu":"onsite","Fri":"onsite","Sat":"leave","Sun":"leave"}'>
              <input type="hidden" name="working_days" id="editEmpWorkingDays" value="Mon,Tue,Wed,Thu,Fri">
              
              <div class="roster-grid-admin" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(76px, 1fr)); gap:6px;">
                <!-- Mon -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Mon</span>
                  <select id="editRoster_Mon" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Tue -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Tue</span>
                  <select id="editRoster_Tue" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Wed -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Wed</span>
                  <select id="editRoster_Wed" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Thu -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Thu</span>
                  <select id="editRoster_Thu" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Fri -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Fri</span>
                  <select id="editRoster_Fri" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite" selected>On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave">Leave</option>
                  </select>
                </div>
                <!-- Sat -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Sat</span>
                  <select id="editRoster_Sat" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite">On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave" selected>Leave</option>
                  </select>
                </div>
                <!-- Sun -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:6px; text-align:center;">
                  <span style="font-weight:700; font-size:11.5px; color:#1e293b; display:block; margin-bottom:4px;">Sun</span>
                  <select id="editRoster_Sun" onchange="syncAdminRoster('edit')" style="width:100%; font-size:11px; padding:4px 2px; border-radius:6px; border:1px solid #cbd5e1; font-weight:600;">
                    <option value="onsite">On-Site</option>
                    <option value="wfh">WFH</option>
                    <option value="leave" selected>Leave</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="w3-form-group">
              <label>Employment Type</label>
              <select name="employment_type" id="editEmpType">
                <option value="Full-Time (Permanent)">Full-Time (Permanent)</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Contract">Contract</option>
                <option value="Internship">Internship</option>
              </select>
            </div>
          </div>
          <div class="w3-modal-footer">
            <button type="button" class="w3-btn-cancel" id="cancelEditEmpModal">Cancel</button>
            <button type="submit" class="w3-btn-save">Update Changes</button>
          </div>
        </form>
      </div>
    </div>
</div>
  </main>
</div>
