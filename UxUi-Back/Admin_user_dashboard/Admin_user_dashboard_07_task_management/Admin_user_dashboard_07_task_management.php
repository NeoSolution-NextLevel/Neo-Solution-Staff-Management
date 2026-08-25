<style>
    /* =========================================================
       ADMIN TASK MANAGEMENT - MODERN SAAS LAYOUT
    ========================================================= */
    :root {
      --primary: #1e3a8a;
      --primary-hover: #172554;
      --bg-app: #f4f7fc;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --navy: #14204d;
      --blue-lighter: #eef2ff;

      /* Badge colors */
      --badge-online-bg: #eef2ff;
      --badge-online-text: #4f46e5;
      --badge-onsite-bg: #ecfdf5;
      --badge-onsite-text: #059669;
      --badge-high-bg: #fef2f2;
      --badge-high-text: #ef4444;
      --badge-medium-bg: #fffbe3;
      --badge-medium-text: #d97706;
      --badge-low-bg: #f1f5f9;
      --badge-low-text: #64748b;
      --badge-progress-bg: #eff6ff;
      --badge-progress-text: #2563eb;
      --badge-pending-bg: #fffbe3;
      --badge-pending-text: #d97706;
      --badge-completed-bg: #ecfdf5;
      --badge-completed-text: #059669;
    }

    #Admin_user_dashboard_07_task_management {
      width: 100%;
      box-sizing: border-box;
    }

    #Admin_user_dashboard_07_task_management .main-task-wrapper {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    /* Header Row */
    .task-header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      margin-bottom: 4px;
    }

    .task-count-text {
      font-size: 14px;
      color: #64748b;
      font-weight: 600;
      margin: 0;
    }

    .btn-create-task {
      background: #14204d;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 13.5px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(20, 32, 77, 0.2);
    }

    .btn-create-task:hover {
      background: #1c2b63;
      transform: translateY(-1px);
    }

    .btn-create-task svg {
      width: 16px;
      height: 16px;
    }

    /* Toolbar Controls (Search + Filter Pills) */
    .task-controls-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      width: 100%;
      flex-wrap: wrap;
    }

    .task-search-box {
      flex: 1;
      max-width: 460px;
      min-width: 240px;
      display: flex;
      align-items: center;
      gap: 10px;
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 10px 14px;
      box-shadow: 0 1px 2px rgba(20,25,60,.03);
    }

    .task-search-box svg {
      width: 16px;
      height: 16px;
      color: #94a3b8;
      flex-shrink: 0;
    }

    .task-search-box input {
      border: none;
      outline: none;
      flex: 1;
      font-size: 13.5px;
      color: #1e293b;
      background: transparent;
      font-family: inherit;
    }

    .task-search-box input::placeholder {
      color: #94a3b8;
    }

    .task-filter-group {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .filter-pill {
      padding: 8px 18px;
      border-radius: 999px;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      font-size: 13px;
      font-weight: 600;
      color: #64748b;
      cursor: pointer;
      transition: all 0.2s ease;
      outline: none;
      box-shadow: 0 1px 2px rgba(20,25,60,0.02);
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .filter-pill:hover {
      background: #f8fafc;
      color: #14204d;
      border-color: #cbd5e1;
    }

    .filter-pill.active {
      background: #14204d !important;
      color: #ffffff !important;
      border-color: #14204d !important;
      box-shadow: 0 2px 8px rgba(20,32,77,0.2) !important;
    }

    /* Table Component */
    .task-table-container {
      background: #ffffff;
      border-radius: 14px;
      border: 1px solid #e8eaf0;
      box-shadow: 0 2px 8px rgba(20,25,60,.04);
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      width: 100%;
      max-width: 100%;
    }

    .task-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    .task-table th {
      background: #fafbfd;
      padding: 12px 16px;
      font-size: 12px;
      font-weight: 700;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: .04em;
      border-bottom: 1px solid #e8eaf0;
      white-space: nowrap;
    }

    .task-table td {
      padding: 12px 16px;
      border-bottom: 1px solid #f1f5f9;
      font-size: 13.5px;
      vertical-align: middle;
      color: #3a3f55;
    }

    .task-table tr:last-child td {
      border-bottom: none;
    }

    .task-table tr:hover td {
      background: #fafbfd;
    }

    .task-title-text {
      font-weight: 700;
      color: #1e293b;
      font-size: 14px;
      line-height: 1.3;
    }

    .task-dept-text {
      font-size: 12px;
      color: #64748b;
      font-weight: 500;
      margin-top: 2px;
    }

    /* Badges */
    .task-pill {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 11.5px;
      font-weight: 700;
      line-height: 1;
    }

    .pill-online { background: var(--badge-online-bg); color: var(--badge-online-text); }
    .pill-onsite { background: var(--badge-onsite-bg); color: var(--badge-onsite-text); }
    .pill-high { background: var(--badge-high-bg); color: var(--badge-high-text); }
    .pill-medium { background: var(--badge-medium-bg); color: var(--badge-medium-text); }
    .pill-low { background: var(--badge-low-bg); color: var(--badge-low-text); }
    .pill-progress { background: var(--badge-progress-bg); color: var(--badge-progress-text); }
    .pill-pending { background: var(--badge-pending-bg); color: var(--badge-pending-text); }
    .pill-completed { background: var(--badge-completed-bg); color: var(--badge-completed-text); }

    .task-action-group {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .task-action-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s ease;
    }

    .task-btn-edit { background: #eff6ff; color: #2563eb; }
    .task-btn-edit:hover { background: #dbeafe; color: #1d4ed8; transform: translateY(-1px); }
    .task-btn-delete { background: #fef2f2; color: #ef4444; }
    .task-btn-delete:hover { background: #fee2e2; color: #dc2626; transform: translateY(-1px); }

    /* W3 Modal Formatting */
    .w3-modal-overlay {
      position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 999999;
      display: none; align-items: center; justify-content: center; padding: 12px; box-sizing: border-box; overflow-y: auto;
    }
    .w3-modal-overlay.active { display: flex; }
    .w3-modal-card {
      background-color: #ffffff; border-radius: 16px; width: 100%; max-width: 540px; max-height: 90vh; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden;
      display: flex; flex-direction: column; margin: auto;
    }
    .w3-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 22px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; flex-shrink: 0; }
    .w3-modal-header h3 { font-size: 17px; font-weight: 800; color: #14204d; margin: 0; }
    .w3-modal-close { background: none; border: none; font-size: 24px; color: #64748b; cursor: pointer; line-height: 1; padding: 0 4px; }
    .w3-modal-body { padding: 18px 22px; display: flex; flex-direction: column; gap: 14px; overflow-y: auto; -webkit-overflow-scrolling: touch; flex: 1; }
    .w3-form-group { display: flex; flex-direction: column; gap: 5px; }
    .w3-form-group label { font-size: 12px; font-weight: 700; color: #475569; }
    .w3-form-group input, .w3-form-group select, .w3-form-group textarea { padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; color: #1e293b; outline: none; background-color: #ffffff; width: 100%; box-sizing: border-box; font-family: inherit; }
    .w3-form-group input:focus, .w3-form-group select:focus, .w3-form-group textarea:focus { border-color: #3b5bdb; box-shadow: 0 0 0 3px rgba(59,91,219,0.12); }
    .w3-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .w3-modal-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 14px 22px; border-top: 1px solid #f1f5f9; background: #ffffff; flex-shrink: 0; }
    .w3-btn-cancel { padding: 10px 18px; border-radius: 8px; border: 1px solid #cbd5e1; background-color: #ffffff; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; }
    .w3-btn-save { padding: 10px 20px; border-radius: 8px; border: none; background-color: #14204d; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 6px rgba(20, 32, 77, 0.2); }

    /* Dynamic Mobile Responsiveness */
    @media (max-width: 768px) {
      #Admin_user_dashboard_07_task_management {
        padding: 0 4px 80px !important;
      }

      .task-header-row {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }

      .btn-create-task {
        width: 100%;
        justify-content: center;
        padding: 12px;
      }

      .task-controls-row {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }

      .task-search-box {
        max-width: 100% !important;
        width: 100% !important;
      }

      .task-filter-group {
        display: flex;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
        width: 100%;
      }

      .filter-pill {
        white-space: nowrap;
        flex-shrink: 0;
      }

      .task-table-container {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        overflow: visible !important;
      }

      .task-table,
      .task-table tbody {
        display: block !important;
        width: 100% !important;
        min-width: 100% !important;
      }

      .task-table thead {
        display: none !important;
      }

      .task-table tr {
        display: flex !important;
        flex-direction: column !important;
        background: #ffffff !important;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 14px 16px !important;
        margin-bottom: 14px !important;
        box-shadow: 0 2px 6px rgba(20,25,60,0.04) !important;
        gap: 8px !important;
      }

      .task-table td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 6px 0 !important;
        border: none !important;
        font-size: 13px !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }

      .task-table td.col-task {
        display: block !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding-bottom: 10px !important;
        margin-bottom: 4px !important;
      }

      .task-table td.col-actions {
        border-top: 1px solid #f1f5f9 !important;
        padding-top: 10px !important;
        margin-top: 4px !important;
        justify-content: flex-end !important;
      }

      .task-table td:not(.col-task):not(.col-actions)::before {
        content: attr(data-label);
        font-weight: 700;
        font-size: 11.5px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-right: 12px;
        flex-shrink: 0;
      }

      .task-table td:not(.col-task):not(.col-actions) > * {
        margin-left: auto;
      }

      .w3-form-row { grid-template-columns: 1fr; }
    }
</style>

<div id="Admin_user_dashboard_07_task_management" class="w3-container" style="display: none; padding: 0;"> 

    <!-- Topbar Header -->
    <div class="topbar">
        <div class="topbar-left">
          <button class="menu-btn" id="menuBtn_07" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
          </button>
          <h2>Task Management</h2>
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
        
    <div class="main-task-wrapper">
        <!-- Header Row (Count + Create Task Button) -->
        <div class="task-header-row">
          <p class="task-count-text" id="taskCount">0 total tasks</p>
          <button class="btn-create-task" id="openCreateTaskBtn" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Create Task
          </button>
        </div>

        <!-- Toolbar (Search Box + Filter Pills) -->
        <div class="task-controls-row">
          <div class="task-search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="taskSearchInput" placeholder="Search tasks by title, department, or employee...">
          </div>

          <div class="task-filter-group" id="taskFilterGroup">
            <button class="filter-pill active" data-filter="All">All</button>
            <button class="filter-pill" data-filter="Pending">Pending</button>
            <button class="filter-pill" data-filter="In Progress">In Progress</button>
            <button class="filter-pill" data-filter="Completed">Completed</button>
          </div>
        </div>

        <!-- Dynamic Responsive Table -->
        <div class="task-table-container">
          <table class="task-table">
            <thead>
              <tr>
                <th style="min-width: 200px;">Task</th>
                <th style="min-width: 140px;">Employee</th>
                <th style="min-width: 90px;">Mode</th>
                <th style="min-width: 110px;">Deadline</th>
                <th style="min-width: 90px;">Priority</th>
                <th style="min-width: 100px;">Status</th>
                <th style="min-width: 90px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody id="taskTableBody">
              <tr>
                <td colspan="7" style="text-align: center; padding: 40px 20px; color: #64748b;">
                  Loading tasks from database...
                </td>
              </tr>
            </tbody>
          </table>
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
              <select name="dept" id="createTaskDept" required>
                <option value="Engineering">Engineering</option>
                <option value="Marketing">Marketing</option>
                <option value="Finance">Finance</option>
                <option value="HR">HR</option>
                <option value="Management">Management</option>
              </select>
            </div>
            <div class="w3-form-group">
              <label>Assigned Employee</label>
              <input type="text" name="employee" id="createTaskEmployee" required placeholder="e.g. Amal Perera">
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