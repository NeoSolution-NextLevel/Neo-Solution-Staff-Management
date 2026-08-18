<style>
  /* =========================================================
     DAILY WORK PLAN (CLEAN ALIGNMENT & RESPONSIVE)
  ========================================================= */
  #Employee_user_dashboard_07_daily_work_plan {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  .workplan-container {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* Topbar */
  .workplan-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .workplan-topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .workplan-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .workplan-menu-btn {
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
  .workplan-menu-btn svg { width: 20px; height: 20px; }

  /* Page Header Title & Actions */
  .workplan-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .workplan-head-left h1 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 4px 0;
    letter-spacing: -0.3px;
  }

  .workplan-head-left p {
    font-size: 14px;
    color: var(--muted);
    margin: 0;
    font-weight: 500;
  }

  .view-switcher {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .view-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #64748b;
    cursor: pointer;
    transition: all 0.15s ease;
  }

  .view-btn.active {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
  }

  .view-btn svg {
    width: 18px;
    height: 18px;
  }

  /* Filters bar */
  .workplan-filters {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }

  .search-pill-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
    max-width: 320px;
  }

  .search-pill-wrap svg {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    color: #94a3b8;
  }

  .search-pill-input {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    padding: 10px 16px 10px 38px;
    font-size: 13.5px;
    color: #1e293b;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s;
  }

  .search-pill-input:focus {
    border-color: #3b5bdb;
  }

  .filter-pill-select {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    padding: 10px 32px 10px 16px;
    font-size: 13.5px;
    color: #1e293b;
    font-weight: 500;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 14px;
  }

  /* Tasks Grid: 2 Columns on Desktop, 1 Column on Mobile */
  .workplan-tasks-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    width: 100%;
    margin-bottom: 24px;
  }

  .task-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-sizing: border-box;
    width: 100%;
  }

  .task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(20, 25, 60, 0.06);
  }

  .task-card-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 8px;
    gap: 10px;
  }

  .task-card-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy, #14204d);
    line-height: 1.3;
  }

  .status-pill {
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
    display: inline-block;
  }

  .status-pill.in-progress { background: #eff6ff; color: #2563eb; }
  .status-pill.pending { background: #fffbeb; color: #d97706; }
  .status-pill.done, .status-pill.completed { background: #f0fdf4; color: #16a34a; }

  .task-card-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.4;
    margin-bottom: 16px;
  }

  .task-tags-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
  }

  .tag-pill {
    padding: 3px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
  }

  .tag-pill.high { background: #fee2e2; color: #ef4444; }
  .tag-pill.medium { background: #fef3c7; color: #d97706; }
  .tag-pill.low { background: #f1f5f9; color: #64748b; }
  .tag-pill.online { background: #eff6ff; color: #3b82f6; }
  .tag-pill.onsite { background: #fdf2f8; color: #db2777; }

  .task-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 20px;
  }

  .task-meta-box {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    gap: 3px;
  }

  .task-meta-box .meta-label {
    font-size: 11px;
    color: #94a3b8;
    font-weight: 700;
    text-transform: uppercase;
  }

  .task-meta-box .meta-value {
    font-size: 13px;
    color: #1e293b;
    font-weight: 700;
  }

  .task-action-btn {
    width: 100%;
    padding: 11px 18px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .task-action-btn.done-btn { background: #15803d; color: #ffffff; }
  .task-action-btn.done-btn:hover { background: #166534; transform: translateY(-1px); }

  .task-action-btn.start-btn { background: #2563eb; color: #ffffff; }
  .task-action-btn.start-btn:hover { background: #1d4ed8; transform: translateY(-1px); }

  .task-action-btn.completed-btn {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
    cursor: default;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .workplan-menu-btn { display: inline-flex !important; }
    .workplan-topbar h2 { font-size: 18px !important; }
    .workplan-tasks-grid { grid-template-columns: 1fr !important; gap: 14px; }
    .task-card { padding: 18px 16px; }
    .search-pill-wrap { max-width: 100%; }
  }
</style>

<div id="Employee_user_dashboard_07_daily_work_plan" class="emp-main" style="display:none; padding:0;">
  <div class="workplan-container">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_07" aria-label="Open menu" onclick="typeof openEmployeeSidebar === 'function' ? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Daily Work Plan</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>

        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="topAvatarPlanPreview">--</div>
          <span id="topEmpPlanName">Loading...</span>
        </div>
      </div>
    </div>

    <!-- Page Head with View Switcher -->
    <div class="workplan-header-row">
      <div class="workplan-head-left">
        <h1>My Assigned Tasks</h1>
        <p id="empActiveTasksCount">Loading tasks from database...</p>
      </div>

      <!-- Grid & List Switcher -->
      <div class="view-switcher">
        <button class="view-btn active" title="Grid view" onclick="setWorkplanView('grid', this)">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"/>
            <rect x="14" y="3" width="7" height="7"/>
            <rect x="14" y="14" width="7" height="7"/>
            <rect x="3" y="14" width="7" height="7"/>
          </svg>
        </button>
        <button class="view-btn" title="List view" onclick="setWorkplanView('list', this)">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="8" y1="6" x2="21" y2="6"/>
            <line x1="8" y1="12" x2="21" y2="12"/>
            <line x1="8" y1="18" x2="21" y2="18"/>
            <line x1="3" y1="6" x2="3.01" y2="6"/>
            <line x1="3" y1="12" x2="3.01" y2="12"/>
            <line x1="3" y1="18" x2="3.01" y2="18"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Search & Filters Bar -->
    <div class="workplan-filters">
      <div class="search-pill-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" class="search-pill-input" id="workplanSearch" placeholder="Search tasks..." onkeyup="filterWorkplanTasks()">
      </div>

      <select class="filter-pill-select" id="workplanCategoryFilter" onchange="filterWorkplanTasks()">
        <option value="all">All Modes</option>
        <option value="Online">Online</option>
        <option value="Onsite">Onsite</option>
      </select>

      <select class="filter-pill-select" id="workplanStatusFilter" onchange="filterWorkplanTasks()">
        <option value="all">All Statuses</option>
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
      </select>
    </div>

    <!-- Tasks Grid (2 Column Desktop / 1 Column Mobile) -->
    <div class="workplan-tasks-grid" id="workplanTasksGrid">
      <div style="text-align:center; padding: 40px 16px; color:#64748b; background:#fff; border-radius:16px; grid-column: 1 / -1; border:1px solid #e8eaf0;">
        Loading your tasks from database...
      </div>
    </div>

  </div>
</div>

<script>
(function () {
  let employeeTasks = [];

  window.fetchEmployeeWorkplanTasks = function () {
    const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
    const fetchUrl = pth + 'UxUi-Back/Tasks/fetch_tasks/fetch_tasks.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && Array.isArray(res.data)) {
          employeeTasks = res.data;
        } else {
          employeeTasks = [];
        }
        renderEmployeeWorkplan();
      })
      .catch(() => {
        employeeTasks = [];
        renderEmployeeWorkplan();
      });
  };

  function renderEmployeeWorkplan() {
    const grid = document.getElementById('workplanTasksGrid');
    const countEl = document.getElementById('empActiveTasksCount');
    if (!grid) return;

    const search = (document.getElementById('workplanSearch')?.value || '').toLowerCase();
    const modeFilter = document.getElementById('workplanCategoryFilter')?.value || 'all';
    const statusFilter = document.getElementById('workplanStatusFilter')?.value || 'all';

    const filtered = employeeTasks.filter(t => {
      const matchSearch = !search || (t.title || '').toLowerCase().includes(search) || (t.description || '').toLowerCase().includes(search);
      const matchMode = modeFilter === 'all' || (t.mode || '').toLowerCase() === modeFilter.toLowerCase();
      const matchStatus = statusFilter === 'all' || (t.status || '').toLowerCase() === statusFilter.toLowerCase();
      return matchSearch && matchMode && matchStatus;
    });

    if (countEl) {
      countEl.textContent = `${filtered.length} active task${filtered.length === 1 ? '' : 's'}`;
    }

    if (filtered.length === 0) {
      grid.innerHTML = '<div style="text-align:center; padding:40px 16px; color:#64748b; background:#fff; border-radius:16px; grid-column:1/-1; border:1px solid #e8eaf0;">No assigned tasks found.</div>';
      return;
    }

    grid.innerHTML = filtered.map(t => {
      let statusPillClass = 'pending';
      if (t.status === 'In Progress') statusPillClass = 'in-progress';
      if (t.status === 'Completed') statusPillClass = 'done';

      let prioClass = (t.priority || '').toLowerCase() === 'high' ? 'high' : ((t.priority || '').toLowerCase() === 'medium' ? 'medium' : 'low');
      let modeClass = (t.mode || '').toLowerCase() === 'online' ? 'online' : 'onsite';

      let actionBtnHtml = '';
      if (t.status === 'Pending') {
        actionBtnHtml = `<button class="task-action-btn start-btn" onclick="updateTaskStatusInDb(${t.id}, 'In Progress')"><span>START TASK</span></button>`;
      } else if (t.status === 'In Progress') {
        actionBtnHtml = `<button class="task-action-btn done-btn" onclick="updateTaskStatusInDb(${t.id}, 'Completed')"><span>MARK AS DONE</span></button>`;
      } else {
        actionBtnHtml = `<button class="task-action-btn completed-btn" disabled><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> <span>Completed</span></button>`;
      }

      return `
        <div class="task-card" data-title="${t.title}" data-mode="${t.mode}" data-status="${t.status}">
          <div>
            <div class="task-card-head">
              <div class="task-card-title">${t.title}</div>
              <span class="status-pill ${statusPillClass}">${t.status}</span>
            </div>
            <p class="task-card-desc">${t.description || 'Assigned task for ' + (t.department || 'the department')}</p>
            
            <div class="task-tags-row">
              <span class="tag-pill ${prioClass}">${t.priority}</span>
              <span class="tag-pill ${modeClass}">${t.mode}</span>
            </div>

            <div class="task-meta-grid">
              <div class="task-meta-box">
                <span class="meta-label">Deadline</span>
                <span class="meta-value">${t.deadline}</span>
              </div>
              <div class="task-meta-box">
                <span class="meta-label">Department</span>
                <span class="meta-value">${t.department || t.dept || 'Engineering'}</span>
              </div>
            </div>
          </div>

          ${actionBtnHtml}
        </div>
      `;
    }).join('');
  }

  window.updateTaskStatusInDb = function (id, newStatus) {
    const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
    const updateUrl = pth + 'UxUi-Back/Tasks/update_task/update_task.php';
    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', newStatus);

    fetch(updateUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          window.fetchEmployeeWorkplanTasks();
        }
      })
      .catch(() => window.fetchEmployeeWorkplanTasks());
  };

  window.setWorkplanView = function (view, btn) {
    document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    const grid = document.getElementById('workplanTasksGrid');
    if (!grid) return;
    if (view === 'list') {
      grid.style.gridTemplateColumns = '1fr';
    } else {
      grid.style.gridTemplateColumns = window.innerWidth <= 768 ? '1fr' : 'repeat(2, 1fr)';
    }
  };

  window.filterWorkplanTasks = function () {
    renderEmployeeWorkplan();
  };

  window.fetchEmployeeWorkplanTasks();
})();
</script>
