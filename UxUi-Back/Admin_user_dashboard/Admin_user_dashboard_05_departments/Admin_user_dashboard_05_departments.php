<style>
    :root {
      --primary: #235ae8;
      --primary-dark: #1d3b8a;
      --primary-hover: #172e6d;
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

    /* Main Content Area */
    .main-wrapper {
      margin-left: 250px;
      width: calc(100% - 250px);
      max-width: calc(100% - 250px);
      min-height: 100vh;
      padding: 16px 20px 24px;
      box-sizing: border-box;
      transition: margin-left 0.3s ease, width 0.3s ease;
    }

    /* Topbar Header */
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

    /* Page Header */
    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      gap: 16px;
    }

    .page-title p {
      font-size: 14px;
      color: var(--text-muted);
      margin: 0;
      font-weight: 500;
    }

    .btn-add-dept {
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
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .btn-add-dept:hover {
      background: #1b49c4;
      transform: translateY(-1px);
    }

    /* Department Cards Grid */
    .dept-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
      gap: 16px;
      width: 100%;
      margin-bottom: 24px;
    }

    .dept-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px 20px;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      gap: 14px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .dept-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
    }

    /* Top Right Ambient Circle */
    .dept-card-ambient {
      position: absolute;
      top: -30px;
      right: -30px;
      width: 115px;
      height: 115px;
      border-radius: 50%;
      opacity: 0.12;
      pointer-events: none;
    }

    .card-icon {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 800;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }
    .card-icon svg {
      width: 22px;
      height: 22px;
      stroke-width: 2;
    }

    .card-info h3 {
      font-size: 17px;
      font-weight: 800;
      color: var(--text-main);
      margin-bottom: 4px;
      text-transform: capitalize;
    }

    .card-info p {
      font-size: 13.5px;
      color: var(--text-muted);
      font-weight: 500;
    }

    .card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 4px;
    }

    .emp-count-badge {
      font-size: 12px;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: 14px;
    }

    .card-actions {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .action-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s;
    }

    .action-edit {
      background: #eff6ff;
      color: #2563eb;
    }
    .action-edit:hover { background: #dbeafe; }

    .action-delete {
      background: #fef2f2;
      color: #ef4444;
    }
    .action-delete:hover { background: #fee2e2; }

    /* Modals (Fixed Header, Scrollable Body, Sticky Footer) */
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
    .w3-modal-overlay.active { 
      display: flex; 
    }
    .w3-modal-card {
      background-color: #ffffff; 
      border-radius: 16px; 
      width: 100%; 
      max-width: 480px; 
      max-height: 88vh;
      display: flex; 
      flex-direction: column; 
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); 
      overflow: hidden; margin: auto;
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
    .w3-modal-header h3 { 
      font-size: 16px; 
      font-weight: 800; 
      color: #14204d; 
      margin: 0; 
    }
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
      padding: 16px 18px; 
      display: flex; 
      flex-direction: column; 
      gap: 12px; 
      flex: 1; 
      overflow-y: auto; 
      -webkit-overflow-scrolling: touch; 
    }
    .w3-form-group { 
      display: flex; 
      flex-direction: column; 
      gap: 4px; 
    }
    .w3-form-group label { 
      font-size: 12px; 
      font-weight: 700; 
      color: #475569; 
    }
    .w3-form-group input, .w3-form-group select { padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; color: #1e293b; outline: none; background-color: #ffffff; }
    .w3-modal-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 12px 18px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
    .w3-btn-cancel { padding: 9px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background-color: #ffffff; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; }
    .w3-btn-save { padding: 9px 18px; border-radius: 8px; border: none; background-color: #3b5bdb; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; }

    /* Responsive */
    @media (max-width: 768px) {
      .main-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 12px 12px 80px !important;
      }
      .menu-btn { display: inline-flex !important; }
      .topbar h2 { font-size: 18px !important; }
      .page-header {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
      }
      .btn-add-dept { width: 100%; justify-content: center; }
      .dept-grid { grid-template-columns: 1fr; }
    }
</style>

<div id="Admin_user_dashboard_05_departments" style="display:none;">
  <div class="main-wrapper">
    
    <!-- Topbar Header -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_05" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2 class="page-breadcrumb">Departments</h2>
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
      
      <div class="page-header">
        <div class="page-title">
          <p id="deptCount">Loading departments...</p>
        </div>
        <button class="btn-add-dept" id="openAddDeptBtn" type="button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Department
        </button>
      </div>

      <!-- Department Cards Grid (Loaded Dynamically from Database) -->
      <div class="dept-grid" id="deptGrid">
        <div style="text-align:center; padding: 40px 16px; color: #64748b; grid-column: 1/-1;">
          Loading departments from database...
        </div>
      </div>

    </main>
  </div>

  <!-- Add Department Modal -->
  <div class="w3-modal-overlay" id="addDeptModal">
    <div class="w3-modal-card">
      <div class="w3-modal-header">
        <h3>Add New Department</h3>
        <button type="button" class="w3-modal-close" id="closeAddDeptModal">&times;</button>
      </div>
      <form id="addDeptForm" class="w3-modal-form-wrapper">
        <div class="w3-modal-body-scroll">
          <div class="w3-form-group">
            <label>Department Name</label>
            <input type="text" name="name" required placeholder="e.g. Accountant / Marketing / Engineering">
          </div>
          <div class="w3-form-group">
            <label>Department Head</label>
            <input type="text" name="head" required placeholder="e.g. Supun Perera">
          </div>
          <div class="w3-form-group">
            <label>Number of Employees</label>
            <input type="number" name="employees" min="0" value="1">
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelAddDeptModal">Cancel</button>
          <button type="submit" class="w3-btn-save">Create Department</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Department Modal -->
  <div class="w3-modal-overlay" id="editDeptModal">
    <div class="w3-modal-card">
      <div class="w3-modal-header">
        <h3>Edit Department</h3>
        <button type="button" class="w3-modal-close" id="closeEditDeptModal">&times;</button>
      </div>
      <form id="editDeptForm" class="w3-modal-form-wrapper">
        <input type="hidden" name="id" id="editDeptId">
        <div class="w3-modal-body-scroll">
          <div class="w3-form-group">
            <label>Department Name</label>
            <input type="text" name="name" id="editDeptName" required placeholder="e.g. Engineering">
          </div>
          <div class="w3-form-group">
            <label>Department Head</label>
            <input type="text" name="head" id="editDeptHead" required placeholder="e.g. Amal Perera">
          </div>
          <div class="w3-form-group">
            <label>Number of Employees</label>
            <input type="number" name="employees" id="editDeptEmployees" min="0">
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelEditDeptModal">Cancel</button>
          <button type="submit" class="w3-btn-save">Update Department</button>
        </div>
      </form>
    </div>
  </div>
</div>
