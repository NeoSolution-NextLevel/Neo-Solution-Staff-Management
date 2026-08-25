<style>
  :root {
    --primary: #235ae8;
    --primary-hover: #1b49c4;
    --bg-app: #f0f4fb;
    --card-bg: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --border: #e2e8f0;

    --icon-job-bg: #8b4e1d;
    --badge-bg: #e8f0fe;
    --badge-text: #235ae8;
    --btn-edit-bg: #ebf3fe;
    --btn-edit-text: #235ae8;
    --btn-delete-bg: #fdebeb;
    --btn-delete-text: #f87171;
  }

  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  }

  #Admin_user_dashboard_06_job_roles {
    width: 100%;
    min-height: 100vh;
  }

  .main-wrapper {
    margin-left: 250px;
    width: calc(100% - 250px);
    max-width: calc(100% - 250px);
    min-height: 100vh;
    padding: 16px 20px 24px;
    box-sizing: border-box;
    transition: margin-left 0.3s ease, width 0.3s ease;
  }

  /* Header Bar */
  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: #14204d;
    letter-spacing: -0.3px;
  }

  .menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: #eef2ff;
    border: none;
    cursor: pointer;
    color: #14204d;
    margin-right: 6px;
  }
  .menu-btn svg { width: 20px; height: 20px; }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .icon-btn {
    background: #eef2ff;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
  }
  .icon-btn svg { width: 18px; height: 18px; color: #14204d; }

  .notif-dot {
    position: absolute;
    top: 8px;
    right: 9px;
    width: 7px;
    height: 7px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid white;
  }

  .profile-pill {
    background: #eef2ff;
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 700;
    color: #14204d;
    cursor: pointer;
  }

  .avatar-sm {
    width: 30px;
    height: 30px;
    background: #14204d;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11.5px;
    font-weight: 700;
  }

  /* Content Header */
  .header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    gap: 12px;
  }

  .header-title p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
    font-weight: 500;
  }

  .btn-add {
    background: var(--primary);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(35, 90, 232, 0.25);
    white-space: nowrap;
  }
  .btn-add:hover { background: var(--primary-hover); }

  /* Toolbar: Search & Dynamic Team/Department Filter */
  .roles-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .roles-search-box {
    flex: 1;
    min-width: 220px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px;
    box-shadow: 0 1px 2px rgba(20,25,60,.03);
  }
  .roles-search-box svg { width: 16px; height: 16px; color: var(--text-muted); flex-shrink: 0; }
  .roles-search-box input {
    border: none;
    outline: none;
    flex: 1;
    font-size: 13.5px;
    color: var(--text-main);
    background: transparent;
    font-family: inherit;
  }
  .roles-search-box input::placeholder { color: #94a3b8; }

  .team-filter-select {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    outline: none;
    cursor: pointer;
    min-width: 180px;
    box-shadow: 0 1px 2px rgba(20,25,60,.03);
  }

  /* Desktop Table Card */
  .table-card {
    background: var(--card-bg);
    border-radius: 14px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    overflow: hidden;
    width: 100%;
    margin-bottom: 24px;
  }

  .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .role-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
  }

  .role-table th {
    background: #fafbfd;
    padding: 14px 20px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 700;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    text-align: left;
  }

  .role-table td {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    font-size: 13.5px;
    vertical-align: middle;
    white-space: nowrap;
  }

  .role-table tr:last-child td { border-bottom: none; }
  .role-table tr:hover { background: #fafbfd; }

  .job-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .role-icon {
    width: 36px;
    height: 36px;
    background: var(--icon-job-bg);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .job-title {
    font-weight: 700;
    color: var(--text-main);
  }

  .dept-cell {
    color: #475569;
    font-weight: 600;
  }

  .employee-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 26px;
    height: 26px;
    padding: 0 8px;
    border-radius: 999px;
    background: var(--badge-bg);
    color: var(--badge-text);
    font-size: 12px;
    font-weight: 700;
  }

  .action-group {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: filter 0.15s, transform 0.15s;
  }
  .action-btn:hover { filter: brightness(0.92); transform: translateY(-1px); }
  .action-btn.btn-edit { background: var(--btn-edit-bg); color: var(--btn-edit-text); }
  .action-btn.btn-delete { background: var(--btn-delete-bg); color: var(--btn-delete-text); }

  /* Mobile Job Role Cards */
  .mobile-role-cards {
    display: none;
    flex-direction: column;
    gap: 12px;
    width: 100%;
    margin-bottom: 24px;
  }

  .mobile-role-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 16px;
    box-shadow: 0 1px 3px rgba(20,25,60,.04);
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .mobile-role-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .mobile-role-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
    background: #f8fafc;
    border-radius: 10px;
    padding: 10px 12px;
    border: 1px solid #eef2f6;
  }

  .mobile-role-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
  }

  .mobile-role-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .btn-mobile-role-edit {
    flex: 1;
    background: var(--btn-edit-bg);
    color: var(--btn-edit-text);
    font-size: 13px;
    font-weight: 700;
    border: 1px solid #dbe4ff;
    border-radius: 8px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
  }

  .btn-mobile-role-del {
    background: var(--btn-delete-bg);
    color: var(--btn-delete-text);
    font-size: 13px;
    font-weight: 700;
    border: 1px solid #fecdd3;
    border-radius: 8px;
    padding: 8px 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  /* Modals (Fixed Header, Scrollable Body, Always-Visible Footer) */
  .w3-modal-overlay {
    position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); z-index: 999999;
    display: none; align-items: center; justify-content: center; padding: 12px; box-sizing: border-box; overflow-y: auto;
  }
  .w3-modal-overlay.active { display: flex; }
  .w3-modal-card {
    background-color: #ffffff; border-radius: 16px; width: 100%; max-width: 480px; max-height: 88vh;
    display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden; margin: auto;
  }
  .w3-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background-color: #ffffff; border-bottom: 1px solid #e2e8f0; flex-shrink: 0; }
  .w3-modal-header h3 { font-size: 16px; font-weight: 800; color: #14204d; margin: 0; }
  .w3-modal-close { background: none; border: none; font-size: 24px; color: #64748b; cursor: pointer; line-height: 1; padding: 0 4px; }
  .w3-modal-form-wrapper { display: flex; flex-direction: column; flex: 1; min-height: 0; overflow: hidden; }
  .w3-modal-body-scroll { padding: 16px 18px; display: flex; flex-direction: column; gap: 12px; flex: 1; overflow-y: auto; -webkit-overflow-scrolling: touch; }
  .w3-form-group { display: flex; flex-direction: column; gap: 4px; }
  .w3-form-group label { font-size: 12px; font-weight: 700; color: #475569; }
  .w3-form-group input, .w3-form-group select { padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; color: #1e293b; outline: none; background-color: #ffffff; }
  .w3-modal-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 12px 18px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
  .w3-btn-cancel { padding: 9px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background-color: #ffffff; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; }
  .w3-btn-save { padding: 9px 18px; border-radius: 8px; border: none; background-color: #3b5bdb; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; }

  /* Mobile Breakpoints */
  @media (max-width: 768px) {
    .main-wrapper {
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 12px 12px 80px !important;
    }

    .menu-btn { display: inline-flex !important; }
    .topbar h2 { font-size: 18px !important; }
    .header-row {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }
    .btn-add {
      width: 100%;
      justify-content: center;
    }

    .roles-toolbar {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .roles-search-box, .team-filter-select {
      width: 100%;
    }

    .table-card { display: none !important; }
    .mobile-role-cards { display: flex !important; }
  }
</style>

<div id="Admin_user_dashboard_06_job_roles" style="display:none;">
  <div class="main-wrapper">
    
    <!-- Top Navigation Header -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_06" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2 class="page-breadcrumb">Job Roles</h2>
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

    <!-- Main Content -->
    <main style="width: 100%;">
      
      <div class="header-row">
        <div class="header-title">
          <p id="jobRolesCount">6 roles defined</p>
        </div>
        <button class="btn-add" id="openAddJobRoleBtn" type="button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Job Role
        </button>
      </div>

      <!-- Search & Team/Department Filter -->
      <div class="roles-toolbar">
        <div class="roles-search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          <input type="text" id="roleSearchInput" placeholder="Search job roles...">
        </div>
        <select class="team-filter-select" id="jobRolesTeamFilter" title="Filter by Department / Team">
          <option value="all">All Departments / Teams</option>
        </select>
      </div>

      <!-- 1. Desktop & Tablet Table -->
      <div class="table-card">
        <div class="table-responsive">
          <table class="role-table">
            <thead>
              <tr>
                <th>Job Title</th>
                <th>Department</th>
                <th>Employees</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="jobRolesTableBody"></tbody>
          </table>
        </div>
      </div>

      <!-- 2. Mobile Phone Responsive Cards List -->
      <div class="mobile-role-cards" id="mobileJobRolesCardsContainer">
        <div style="text-align:center; padding: 30px 16px; color: #64748b; background:#fff; border-radius:12px;">
          Loading job roles...
        </div>
      </div>

    </main>
  </div>

  <!-- Add Job Role Modal -->
  <div class="w3-modal-overlay" id="addJobRoleModal">
    <div class="w3-modal-card">
      <div class="w3-modal-header">
        <h3>Add New Job Role</h3>
        <button type="button" class="w3-modal-close" id="closeAddJobRoleModal">&times;</button>
      </div>
      <form id="addJobRoleForm" class="w3-modal-form-wrapper">
        <div class="w3-modal-body-scroll">
          <div class="w3-form-group">
            <label>Job Title</label>
            <input type="text" name="title" required placeholder="e.g. Lead QA Engineer">
          </div>
          <div class="w3-form-group">
            <label>Department / Team</label>
            <select name="dept" id="addJobRoleDept" required>
              <option value="">Select Department...</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Number of Employees</label>
            <input type="number" name="employees" min="0" value="1">
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelAddJobRoleModal">Cancel</button>
          <button type="submit" class="w3-btn-save">Create Job Role</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Job Role Modal -->
  <div class="w3-modal-overlay" id="editJobRoleModal">
    <div class="w3-modal-card">
      <div class="w3-modal-header">
        <h3>Edit Job Role</h3>
        <button type="button" class="w3-modal-close" id="closeEditJobRoleModal">&times;</button>
      </div>
      <form id="editJobRoleForm" class="w3-modal-form-wrapper">
        <input type="hidden" name="id" id="editJobRoleId">
        <div class="w3-modal-body-scroll">
          <div class="w3-form-group">
            <label>Job Title</label>
            <input type="text" name="title" id="editJobRoleTitle" required placeholder="e.g. Senior Developer">
          </div>
          <div class="w3-form-group">
            <label>Department / Team</label>
            <select name="dept" id="editJobRoleDept" required>
              <option value="">Select Department...</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Number of Employees</label>
            <input type="number" name="employees" id="editJobRoleEmployees" min="0">
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelEditJobRoleModal">Cancel</button>
          <button type="submit" class="w3-btn-save">Update Job Role</button>
        </div>
      </form>
    </div>
  </div>
</div>