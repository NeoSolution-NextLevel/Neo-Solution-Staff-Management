<style>
    :root {
      --primary: #1e3a8a;
      --primary-hover: #172554;
      --bg-app: #f4f7fc;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;

      /* Badge colors */
      --badge-online-bg: #eef2ff;
      --badge-online-text: #4f46e5;
      --badge-onsite-bg: #ecfdf5;
      --badge-onsite-text: #059669;
      --badge-high-bg: #fef2f2;
      --badge-high-text: #ef4444;
      --badge-medium-bg: #fffbe3;
      --badge-medium-text: #d97706;
      --badge-progress-bg: #eff6ff;
      --badge-progress-text: #2563eb;
      --badge-pending-bg: #fffbe3;
      --badge-pending-text: #d97706;
      --badge-completed-bg: #ecfdf5;
      --badge-completed-text: #059669;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
      background-color: var(--bg-app);
      color: var(--text-main);
      min-height: 100vh;
      display: flex;
    }

    .app-layout {
      display: flex;
      width: 100%;
      min-height: 100vh;
    }


    /* Main Area */
    .main-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    /* Top Bar */
    .topbar {
      background: var(--sidebar-bg);
      padding: 14px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
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
    }

    .page-title {
      font-size: 14px;
      font-weight: 700;
      color: var(--text-main);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .icon-btn-notif {
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
    }

    .notif-badge {
      position: absolute;
      top: 8px;
      right: 8px;
      width: 6px;
      height: 6px;
      background: #ef4444;
      border-radius: 50%;
    }

    .profile-pill {
      background: #f1f5f9;
      padding: 4px 12px 4px 4px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 12.5px;
      font-weight: 600;
    }

    .avatar-sm {
      width: 28px;
      height: 28px;
      background: var(--primary);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
    }

    /* Main Content */
    .content {
      padding: 16px 20px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      width: 100%;
      max-width: 100%;
    }

    .header-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .header-title h1 {
      font-size: 22px;
      font-weight: 800;
      color: var(--text-main);
    }

    .header-title p {
      font-size: 13px;
      color: var(--text-muted);
      margin-top: 2px;
    }

    .btn-create {
      background: var(--primary);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-create:hover {
      background: var(--primary-hover);
    }

    /* Toolbar Controls */
    .controls-row {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .search-box {
      position: relative;
      min-width: 240px;
    }

    .search-box input {
      width: 100%;
      padding: 8px 14px 8px 34px;
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 20px;
      font-size: 13px;
      outline: none;
    }

    .search-box svg {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
    }

    .filter-group {
      display: flex;
      gap: 8px;
    }

    .filter-pill {
      padding: 6px 14px;
      border-radius: 20px;
      border: 1px solid transparent;
      background: var(--card-bg);
      color: var(--text-muted);
      font-size: 12.5px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-pill.active {
      background: var(--primary);
      color: white;
    }

    /* Table Component */
    .table-container {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      overflow: hidden;
      width: 100%;
      max-width: 100%;
    }

    .task-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    .task-table th {
      background: #fafafa;
      padding: 10px 14px;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-muted);
      border-bottom: 1px solid var(--border);
    }

    .task-table td {
      padding: 10px 14px;
      border-bottom: 1px solid var(--border);
      font-size: 13px;
      vertical-align: middle;
    }

    .task-table tr:last-child td {
      border-bottom: none;
    }

    .task-title {
      font-weight: 600;
      color: var(--text-main);
    }

    .task-dept {
      font-size: 11.5px;
      color: var(--text-muted);
      margin-top: 2px;
    }

    /* Badges */
    .pill {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 12px;
      font-size: 11.5px;
      font-weight: 600;
    }

    .pill-online { background: var(--badge-online-bg); color: var(--badge-online-text); }
    .pill-onsite { background: var(--badge-onsite-bg); color: var(--badge-onsite-text); }
    .pill-high { background: var(--badge-high-bg); color: var(--badge-high-text); }
    .pill-medium { background: var(--badge-medium-bg); color: var(--badge-medium-text); }
    .pill-progress { background: var(--badge-progress-bg); color: var(--badge-progress-text); }
    .pill-pending { background: var(--badge-pending-bg); color: var(--badge-pending-text); }
    .pill-completed { background: var(--badge-completed-bg); color: var(--badge-completed-text); }

    .time-detail {
      font-size: 11.5px;
      color: var(--text-muted);
      line-height: 1.3;
    }

    .action-group {
      display: flex;
      gap: 6px;
    }

    .action-btn {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .btn-edit { background: #eff6ff; color: #2563eb; }
    .btn-delete { background: #fef2f2; color: #ef4444; }

    /* Mobile Drawer Overlay */
    .drawer-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.4);
      z-index: 90;
    }

    /* Dynamic Mobile Responsiveness */
    @media (max-width: 768px) {
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

      .drawer-overlay.active {
        display: block;
      }

      .toggle-menu {
        display: none;
      }

      #Admin_user_dashboard_07_task_management {
        padding: 0 12px 80px !important;
      }

      #Admin_user_dashboard_07_task_management .main-wrapper,
      #Admin_user_dashboard_07_task_management .content {
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
      }

      .header-row {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }

      .header-title {
        display: flex;
        align-items: center;
        justify-content: flex-start;
      }

      .btn-create {
        width: 100%;
        justify-content: center;
        padding: 10px 16px;
      }

      .controls-row {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }

      .search-box {
        width: 100% !important;
      }

      .search-box input {
        width: 100% !important;
        box-sizing: border-box !important;
      }

      .filter-group {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
        width: 100%;
      }

      .filter-pill {
        white-space: nowrap;
        flex-shrink: 0;
      }

      .table-container {
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 12px;
      }

      .task-table {
        min-width: 650px;
        width: 100%;
      }

      .task-table th, .task-table td {
        padding: 10px 12px;
      }
    }

    /* W3 Modal Formatting */
    .w3-modal-overlay {
      position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 999999;
      display: none; align-items: center; justify-content: center; padding: 12px; box-sizing: border-box; overflow-y: auto;
    }
    .w3-modal-overlay.active { display: flex; }
    .w3-modal-card {
      background-color: #ffffff; border-radius: 16px; width: 100%; max-width: 520px; max-height: 90vh; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden;
      display: flex; flex-direction: column; margin: auto;
    }
    .w3-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; flex-shrink: 0; }
    .w3-modal-header h3 { font-size: 17px; font-weight: 800; color: #14204d; margin: 0; }
    .w3-modal-close { background: none; border: none; font-size: 24px; color: #64748b; cursor: pointer; line-height: 1; padding: 0 4px; }
    .w3-modal-body { padding: 18px 20px; display: flex; flex-direction: column; gap: 12px; overflow-y: auto; -webkit-overflow-scrolling: touch; flex: 1; }
    .w3-form-group { display: flex; flex-direction: column; gap: 5px; }
    .w3-form-group label { font-size: 12px; font-weight: 700; color: #475569; }
    .w3-form-group input, .w3-form-group select, .w3-form-group textarea { padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; color: #1e293b; outline: none; background-color: #ffffff; width: 100%; box-sizing: border-box; font-family: inherit; }
    .w3-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (max-width: 600px) { .w3-form-row { grid-template-columns: 1fr; } }
    .w3-modal-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 12px 20px; border-top: 1px solid #f1f5f9; background: #ffffff; flex-shrink: 0; }
    .w3-btn-cancel { padding: 9px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background-color: #ffffff; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; }
    .w3-btn-save { padding: 9px 18px; border-radius: 8px; border: none; background-color: #1e3a8a; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25); }
  </style>

<div id="Admin_user_dashboard_07_task_management">

  <div class="app-layout">
    <!-- Backdrop Overlay for Mobile -->
    <div class="drawer-overlay" id="drawerOverlay"></div>

    <!-- Main Section -->
    <div class="main-wrapper">
      
      <!-- Top Header Bar -->
      <header class="topbar">
        <div class="topbar-left">
          <button class="menu-btn" id="menuBtn_07" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
          <h2 class="page-title">Task Management</h2>
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
      </header>

      <!-- Main Body -->
      <main class="content">
        
        <div class="header-row">
          <div class="header-title">
            <p id="taskCount">0 total tasks</p>
          </div>
          <button class="btn-create" id="openCreateTaskBtn" type="button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create Task
          </button>
        </div>

        <div class="controls-row">
          <div class="search-box">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="taskSearchInput" placeholder="Search tasks...">
          </div>

          <div class="filter-group" id="taskFilterGroup">
            <button class="filter-pill active" data-filter="All">All</button>
            <button class="filter-pill" data-filter="Pending">Pending</button>
            <button class="filter-pill" data-filter="In Progress">In Progress</button>
            <button class="filter-pill" data-filter="Completed">Completed</button>
          </div>
        </div>

        <!-- Dynamic Responsive Table -->
        <div class="table-container">
          <table class="task-table">
            <thead>
              <tr>
                <th class="col-task">Task</th>
                <th class="col-employee">Employee</th>
                <th class="col-mode">Mode</th>
                <th class="col-deadline">Deadline</th>
                <th class="col-priority">Priority</th>
                <th class="col-status">Status</th>
                <th class="col-times">Times</th>
                <th class="col-actions">Actions</th>
              </tr>
            </thead>
            <tbody id="taskTableBody">
            </tbody>
          </table>
        </div>

      </main>
    </div>
  </div>

  <!-- Create Task Modal -->
  <div class="w3-modal-overlay" id="createTaskModal">
    <div class="w3-modal-card">
      <div class="w3-modal-header">
        <h3>Create New Task</h3>
        <button type="button" class="w3-modal-close" id="closeCreateTaskModal">&times;</button>
      </div>
      <form id="createTaskForm" class="w3-modal-body">
        <div class="w3-form-group">
          <label>Task Title</label>
          <input type="text" name="title" required placeholder="e.g. Redesign Employee Portal UI">
        </div>
        <div class="w3-form-row">
          <div class="w3-form-group">
            <label>Department</label>
            <select name="dept">
              <option value="Engineering">Engineering</option>
              <option value="Marketing">Marketing</option>
              <option value="Finance">Finance</option>
              <option value="HR">HR</option>
              <option value="Management">Management</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Assigned Employee</label>
            <input type="text" name="employee" required placeholder="e.g. Amal Perera">
          </div>
        </div>
        <div class="w3-form-row">
          <div class="w3-form-group">
            <label>Work Mode</label>
            <select name="mode">
              <option value="Online">Online</option>
              <option value="Onsite">Onsite</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Deadline</label>
            <input type="date" name="deadline" value="<?php echo date('Y-m-d'); ?>">
          </div>
        </div>
        <div class="w3-form-row">
          <div class="w3-form-group">
            <label>Priority</label>
            <select name="priority">
              <option value="High">High</option>
              <option value="Medium" selected>Medium</option>
              <option value="Low">Low</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Status</label>
            <select name="status">
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelCreateTaskModal">Cancel</button>
          <button type="submit" class="w3-btn-save">Create Task</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Task Modal -->
  <div class="w3-modal-overlay" id="editTaskModal">
    <div class="w3-modal-card">
      <div class="w3-modal-header">
        <h3>Edit Task</h3>
        <button type="button" class="w3-modal-close" id="closeEditTaskModal">&times;</button>
      </div>
      <form id="editTaskForm" class="w3-modal-body">
        <input type="hidden" name="id" id="editTaskId">
        <div class="w3-form-group">
          <label>Task Title</label>
          <input type="text" name="title" id="editTaskTitle" required placeholder="e.g. Redesign Employee Portal UI">
        </div>
        <div class="w3-form-row">
          <div class="w3-form-group">
            <label>Department</label>
            <select name="dept" id="editTaskDept">
              <option value="Engineering">Engineering</option>
              <option value="Marketing">Marketing</option>
              <option value="Finance">Finance</option>
              <option value="HR">HR</option>
              <option value="Management">Management</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Assigned Employee</label>
            <input type="text" name="employee" id="editTaskEmployee" required placeholder="e.g. Amal Perera">
          </div>
        </div>
        <div class="w3-form-row">
          <div class="w3-form-group">
            <label>Work Mode</label>
            <select name="mode" id="editTaskMode">
              <option value="Online">Online</option>
              <option value="Onsite">Onsite</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Deadline</label>
            <input type="date" name="deadline" id="editTaskDeadline">
          </div>
        </div>
        <div class="w3-form-row">
          <div class="w3-form-group">
            <label>Priority</label>
            <select name="priority" id="editTaskPriority">
              <option value="High">High</option>
              <option value="Medium">Medium</option>
              <option value="Low">Low</option>
            </select>
          </div>
          <div class="w3-form-group">
            <label>Status</label>
            <select name="status" id="editTaskStatus">
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="cancelEditTaskModal">Cancel</button>
          <button type="submit" class="w3-btn-save">Update Task</button>
        </div>
      </form>
    </div>
  </div>
</div>
          </table>
        </div>

      </main>
    </div>
  </div>
</div>