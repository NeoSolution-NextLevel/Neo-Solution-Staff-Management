<style>
  /* =========================================================
     DAILY WORK PLAN (CLEAN ALIGNMENT & RESPONSIVE)
  ========================================================= */
  #Employee_user_dashboard_07_daily_work_plan {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  @media (min-width: 769px) {
    #Employee_user_dashboard_07_daily_work_plan {
      margin-left: 250px !important;
      width: calc(100% - 250px) !important;
      max-width: calc(100% - 250px) !important;
      padding: 0 24px 80px !important;
      box-sizing: border-box !important;
    }
  }

  @media (max-width: 768px) {
    #Employee_user_dashboard_07_daily_work_plan {
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100vw !important;
      padding: 0 12px 80px !important;
      box-sizing: border-box !important;
    }
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

  /* Step-by-Step Cards */
  .workplan-step-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 26px;
  }

  .workplan-step-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 22px 24px;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
    position: relative;
  }

  .workplan-step-card:hover {
    box-shadow: 0 4px 14px rgba(20, 25, 60, 0.06);
  }

  .workplan-step-card.step-1-card {
    border-left: 5px solid #f59e0b;
  }

  .workplan-step-card.step-2-card {
    border-left: 5px solid #2563eb;
  }

  .step-header-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
    flex-wrap: wrap;
    gap: 10px;
  }

  .step-title-group {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .step-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .step-badge.step-1 {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
  }

  .step-badge.step-2 {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
  }

  .step-header-wrap h3 {
    margin: 0;
    color: var(--navy, #14204d);
    font-size: 17px;
    font-weight: 800;
  }

  .step-subtext {
    margin: 0 0 14px 0;
    color: #64748b;
    font-size: 13.5px;
    line-height: 1.45;
  }

  .daily-plan-input {
    width: 100%;
    min-height: 90px;
    resize: vertical;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 13px 15px;
    font: inherit;
    font-size: 13.5px;
    line-height: 1.5;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    background: #ffffff;
    color: #1e293b;
  }

  .daily-plan-input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
  }

  .daily-plan-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 14px;
    flex-wrap: wrap;
  }

  .start-work-btn {
    border: 0;
    border-radius: 10px;
    background: #16a34a;
    color: #ffffff;
    padding: 11px 20px;
    font-weight: 700;
    cursor: pointer;
    font-size: 13.5px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 7px;
  }

  .start-work-btn:hover {
    background: #15803d;
    transform: translateY(-1px);
  }

  .start-work-btn.active {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
    cursor: default;
    transform: none;
  }

  .save-plan-btn {
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    background: #f8fafc;
    color: #334155;
    padding: 11px 18px;
    font-weight: 700;
    cursor: pointer;
    font-size: 13.5px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 7px;
  }

  .save-plan-btn:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
  }

  .daily-plan-status {
    color: #64748b;
    font-size: 12.5px;
    font-weight: 600;
  }

  /* Morning Plan Reference Box in Step 2 */
  .plan-ref-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #3b82f6;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 16px;
  }

  .plan-ref-title {
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #475569;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 7px;
  }

  .plan-ref-content {
    font-size: 13.5px;
    color: #1e293b;
    font-weight: 600;
    white-space: pre-wrap;
    line-height: 1.5;
  }

  /* Evening Status Badges */
  .shift-wrapup-badge {
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .shift-wrapup-badge.completed {
    background: #dcfce7;
    color: #15803d;
    border-color: rgba(21, 128, 61, 0.25);
  }

  .shift-wrapup-badge.pending {
    background: #fef3c7;
    color: #b45309;
    border-color: rgba(180, 83, 9, 0.25);
  }

  .shift-ctrls-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 16px;
    flex-wrap: wrap;
  }

  .shift-end-submit-btn {
    padding: 11px 24px;
    border-radius: 10px;
    border: 0;
    background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
    color: #ffffff;
    font-weight: 700;
    font-size: 13.5px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.25);
  }

  .shift-end-submit-btn:hover {
    background: linear-gradient(135deg, #166534 0%, #15803d 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
  }

  .shift-status-alert {
    margin-top: 14px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .shift-status-alert.success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
  }
  .shift-view-task-btn {
    padding: 11px 20px;
    border-radius: 10px;
    border: 1px solid #bfdbfe;
    background: #eff6ff;
    color: #1d4ed8;
    font-weight: 700;
    font-size: 13.5px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 7px;
  }
  .shift-view-task-btn:hover {
    background: #dbeafe;
    border-color: #93c5fd;
    transform: translateY(-1px);
  }

  /* Employee Task Details Modal */
  .emp-modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 14px;
    box-sizing: border-box;
    overflow-y: auto;
  }
  .emp-modal-overlay.active {
    display: flex !important;
  }
  .emp-modal-card {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    margin: auto;
  }
  .emp-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 22px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    flex-shrink: 0;
  }
  .emp-modal-header h3 {
    font-size: 17px;
    font-weight: 800;
    color: #14204d;
    margin: 0;
  }
  .emp-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    color: #64748b;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
  }
  .emp-modal-body {
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    overflow-y: auto;
    flex: 1;
  }
  .emp-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 14px 22px;
    border-top: 1px solid #f1f5f9;
    background: #ffffff;
    flex-shrink: 0;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .workplan-menu-btn { display: inline-flex !important; }
    .workplan-topbar h2 { font-size: 18px !important; }
    .workplan-tasks-grid { grid-template-columns: 1fr !important; gap: 14px; }
    .task-card { padding: 18px 16px; }
    .search-pill-wrap { max-width: 100%; }
    .shift-ctrls-row { flex-direction: column; align-items: stretch; }
    .shift-end-submit-btn { width: 100%; justify-content: center; }
  }
</style>

<div id="Employee_user_dashboard_07_daily_work_plan" style="display:none;">
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

    <!-- Step-by-Step Daily Workflow -->
    <div class="workplan-step-container">
      
      <!-- STEP 1: Morning Plan -->
      <section class="workplan-step-card step-1-card">
        <div class="step-header-wrap">
          <div class="step-title-group">
            <span class="step-badge step-1">Step 1</span>
            <h3>Plan Today's Work</h3>
          </div>
          <span id="morningPlanStatusBadge" class="shift-wrapup-badge pending">Shift Not Started</span>
        </div>
        <p class="step-subtext">Write down the tasks you plan to accomplish today. Click <b>Start Work</b> to activate your shift for the day.</p>
        
        <textarea id="dailyWorkPlanText" class="daily-plan-input" placeholder="Enter today's planned tasks:&#10;1. Review pending customer requests&#10;2. Finish documentation updates&#10;3. Conduct weekly inventory verification..."></textarea>
        
        <div class="daily-plan-actions">
          <button type="button" id="saveDailyPlanBtn" class="save-plan-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            <span>Save Plan</span>
          </button>
          <button type="button" id="startWorkBtn" class="start-work-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Start Work — Active Today</span>
          </button>
          <span id="dailyPlanStatus" class="daily-plan-status"></span>
        </div>
      </section>

      <!-- STEP 2: Evening Shift Update -->
      <section class="workplan-step-card step-2-card">
        <div class="step-header-wrap">
          <div class="step-title-group">
            <span class="step-badge step-2">Step 2</span>
            <h3>Update on Planned Work</h3>
          </div>
          <span class="shift-wrapup-badge" id="shiftStatusBadge"> Shift In Progress</span>
        </div>
        <p class="step-subtext">When ending your shift, review your morning plan below and provide an update on what was accomplished:</p>

        <!-- Morning Plan Reference Box -->
        <div class="plan-ref-box">
          <div class="plan-ref-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Today's Morning Plan:
          </div>
          <div id="morningPlanPreviewText" class="plan-ref-content">No plan entered yet. Write your plan in Step 1 above.</div>
        </div>

        <label style="font-size:13px; font-weight:700; color:#334155; display:block; margin-bottom:6px;">
          What did you complete from this plan? (Evening Progress Update):
        </label>
        <textarea id="shiftEndNotes" class="daily-plan-input" placeholder="Write what you finished from the morning plan, what remains pending, or any end-of-shift notes..."></textarea>

        <div class="shift-ctrls-row">
          <div style="display: flex; align-items: center; gap: 8px;">
            <label style="font-size: 13px; font-weight: 700; color: #334155;">Work Status:</label>
            <select id="shiftEndTaskStatus" class="filter-pill-select" style="min-width: 150px; font-weight: 700;">
              <option value="Completed" selected>Completed</option>
              <option value="Pending">Pending</option>
            </select>
          </div>

          <button type="button" id="submitShiftEndBtn" class="shift-end-submit-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
              <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>Submit Shift Update & Sync to Tasks</span>
          </button>

          <button type="button" id="viewShiftTaskBtn" class="shift-view-task-btn" style="display: none;" onclick="openShiftWorkTaskModal()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
            <span>View Task</span>
          </button>
        </div>

        <div id="shiftEndStatusMsg" class="shift-status-alert success" style="display: none;"></div>
      </section>

    </div>

    <!-- Page Head with View Switcher -->
    <div class="workplan-header-row">
      <div class="workplan-head-left">
        <h1>My Assigned & Daily Tasks</h1>
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

  <!-- Task Details Modal (for Employee) -->
  <div class="emp-modal-overlay" id="workplanTaskDetailsModal" style="display:none;">
    <div class="emp-modal-card">
      <div class="emp-modal-header">
        <h3>Task Details</h3>
        <button type="button" class="emp-modal-close" onclick="closeWorkplanTaskModal()">&times;</button>
      </div>
      <div class="emp-modal-body">
        <div>
          <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 4px;">Task Title</div>
          <h4 id="modalTaskTitle" style="margin: 0; font-size: 17px; font-weight: 800; color: #14204d; line-height: 1.35;"></h4>
        </div>

        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
          <span id="modalTaskStatusPill" class="status-pill done">Completed</span>
          <span id="modalTaskPriorityPill" class="tag-pill medium">Medium</span>
          <span id="modalTaskModePill" class="tag-pill online">Online</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #f1f5f9;">
          <div>
            <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Department</span>
            <span id="modalTaskDept" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
          </div>
          <div>
            <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Deadline</span>
            <span id="modalTaskDeadline" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
          </div>
        </div>

        <div>
          <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Description / Work Plan Details</div>
          <div id="modalTaskDesc" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; color: #334155; line-height: 1.5; white-space: pre-wrap; max-height: 220px; overflow-y: auto;"></div>
        </div>
      </div>
      <div class="emp-modal-footer">
        <button type="button" class="save-plan-btn" onclick="closeWorkplanTaskModal()">Close</button>
      </div>
    </div>
  </div>

</div>

<script>
(function () {
  let employeeTasks = [];

  const dailyPlanUrl = () => (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/daily_work_plan/daily_work_plan.php';
  const planText = document.getElementById('dailyWorkPlanText');
  const planStatus = document.getElementById('dailyPlanStatus');
  const startWorkBtn = document.getElementById('startWorkBtn');
  const savePlanBtn = document.getElementById('saveDailyPlanBtn');
  const morningPlanPreview = document.getElementById('morningPlanPreviewText');
  const morningStatusBadge = document.getElementById('morningPlanStatusBadge');

  // Evening Shift Update elements
  const shiftEndNotes = document.getElementById('shiftEndNotes');
  const shiftEndTaskStatus = document.getElementById('shiftEndTaskStatus');
  const submitShiftEndBtn = document.getElementById('submitShiftEndBtn');
  const shiftEndStatusMsg = document.getElementById('shiftEndStatusMsg');
  const shiftStatusBadge = document.getElementById('shiftStatusBadge');

  function formatTimeStr(dtStr) {
    if (!dtStr) return '';
    try {
      const parts = dtStr.split(' ');
      if (parts.length >= 2) {
        const timeParts = parts[1].split(':');
        let hours = parseInt(timeParts[0], 10);
        const mins = timeParts[1];
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        return `${hours}:${mins} ${ampm}`;
      }
      return dtStr;
    } catch (e) {
      return dtStr;
    }
  }

  // Sync morning plan text into Step 2 reference box on input
  planText?.addEventListener('input', function () {
    updatePlanPreviewText(this.value);
  });

  function updatePlanPreviewText(text) {
    if (!morningPlanPreview) return;
    const clean = (text || '').trim();
    if (clean) {
      morningPlanPreview.textContent = clean;
      morningPlanPreview.style.color = '#1e293b';
      morningPlanPreview.style.fontStyle = 'normal';
    } else {
      morningPlanPreview.textContent = 'No plan entered yet. Write your plan in Step 1 above.';
      morningPlanPreview.style.color = '#94a3b8';
      morningPlanPreview.style.fontStyle = 'italic';
    }
  }

  function loadDailyPlan() {
    fetch(dailyPlanUrl(), { credentials: 'same-origin' })
      .then(res => res.json())
      .then(res => {
        if (!res.data) {
          updatePlanPreviewText('');
          if (morningStatusBadge) {
            morningStatusBadge.className = 'shift-wrapup-badge pending';
            morningStatusBadge.textContent = '⚪ Shift Not Started';
          }
          if (shiftStatusBadge) {
            shiftStatusBadge.className = 'shift-wrapup-badge';
            shiftStatusBadge.textContent = '⏳ Shift Not Started';
          }
          return;
        }

        const currentPlan = res.data.plan_text || '';
        if (planText) planText.value = currentPlan;
        updatePlanPreviewText(currentPlan);

        if (res.data.started_at && startWorkBtn) {
          startWorkBtn.textContent = 'Active Today';
          startWorkBtn.classList.add('active');
          startWorkBtn.disabled = true;
          if (morningStatusBadge) {
            morningStatusBadge.className = 'shift-wrapup-badge completed';
            morningStatusBadge.innerHTML = '🟢 Active Shift (' + formatTimeStr(res.data.started_at) + ')';
          }
        } else if (morningStatusBadge) {
          morningStatusBadge.className = 'shift-wrapup-badge pending';
          morningStatusBadge.textContent = '⚪ Shift Not Started';
        }

        if (planStatus) {
          planStatus.textContent = res.data.updated_at ? `Updated ${formatTimeStr(res.data.updated_at)}` : '';
        }

        // Evening update population
        const viewShiftTaskBtn = document.getElementById('viewShiftTaskBtn');
        if (shiftEndNotes && res.data.evening_update) {
          shiftEndNotes.value = res.data.evening_update;
        }
        if (shiftEndTaskStatus && res.data.task_status) {
          shiftEndTaskStatus.value = res.data.task_status;
        }

        if (res.data.task_id && viewShiftTaskBtn) {
          viewShiftTaskBtn.style.display = 'inline-flex';
          viewShiftTaskBtn.setAttribute('data-task-id', res.data.task_id);
        } else if (viewShiftTaskBtn && !res.data.shift_ended_at) {
          viewShiftTaskBtn.style.display = 'none';
        }

        if (res.data.shift_ended_at) {
          const endedTime = formatTimeStr(res.data.shift_ended_at);
          const stVal = res.data.task_status || 'Completed';
          if (viewShiftTaskBtn) {
            viewShiftTaskBtn.style.display = 'inline-flex';
            if (res.data.task_id) viewShiftTaskBtn.setAttribute('data-task-id', res.data.task_id);
          }
          if (shiftStatusBadge) {
            shiftStatusBadge.textContent = `Shift Ended (${endedTime})`;
            shiftStatusBadge.className = 'shift-wrapup-badge ' + (stVal === 'Completed' ? 'completed' : 'pending');
          }
          if (shiftEndStatusMsg) {
            shiftEndStatusMsg.style.display = 'flex';
            shiftEndStatusMsg.className = 'shift-status-alert success';
            shiftEndStatusMsg.innerHTML = `
              <div style="flex:1;">Shift ended at <b>${endedTime}</b> (Status: <b>${stVal}</b> — Synced to Tasks)</div>
              <button type="button" class="shift-view-task-btn" style="padding: 6px 14px; font-size: 12px; margin-left: auto;" onclick="openShiftWorkTaskModal()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <span>View Task</span>
              </button>
            `;
          }
        } else if (res.data.started_at) {
          if (shiftStatusBadge) {
            shiftStatusBadge.className = 'shift-wrapup-badge';
            shiftStatusBadge.textContent = '⏳ Shift In Progress';
          }
        }
      }).catch(() => {});
  }

  function saveDailyPlan(startWork) {
    const text = (planText?.value || '').trim();
    if (!text) {
      if (planStatus) {
        planStatus.style.color = '#dc2626';
        planStatus.textContent = 'Please enter your daily plan first.';
      }
      return;
    }

    const body = new FormData();
    body.append('plan_text', text);
    body.append('start_work', startWork ? '1' : '0');

    fetch(dailyPlanUrl(), { method: 'POST', body, credentials: 'same-origin' })
      .then(res => res.json())
      .then(res => {
        if (res.status !== 'success') throw new Error(res.message || 'Unable to save plan');
        if (planStatus) {
          planStatus.style.color = '#15803d';
          planStatus.textContent = startWork ? 'Work started! You are active today.' : 'Daily plan saved.';
        }
        if (startWorkBtn && startWork) {
          startWorkBtn.textContent = 'Active Today';
          startWorkBtn.classList.add('active');
          startWorkBtn.disabled = true;
          if (morningStatusBadge) {
            morningStatusBadge.className = 'shift-wrapup-badge completed';
            morningStatusBadge.innerHTML = '🟢 Active Shift Today';
          }
          if (shiftStatusBadge) {
            shiftStatusBadge.className = 'shift-wrapup-badge';
            shiftStatusBadge.textContent = '⏳ Shift In Progress';
          }
        }
        updatePlanPreviewText(text);
      }).catch(err => {
        if (planStatus) {
          planStatus.style.color = '#dc2626';
          planStatus.textContent = err.message;
        }
      });
  }

  function submitShiftEndUpdate() {
    const notes = (shiftEndNotes?.value || '').trim();
    const statusVal = shiftEndTaskStatus?.value || 'Completed';

    if (!notes && !(planText?.value || '').trim()) {
      if (shiftEndStatusMsg) {
        shiftEndStatusMsg.style.display = 'flex';
        shiftEndStatusMsg.className = 'shift-status-alert error';
        shiftEndStatusMsg.textContent = 'Please enter your shift update notes first.';
      }
      return;
    }

    if (submitShiftEndBtn) {
      submitShiftEndBtn.disabled = true;
      submitShiftEndBtn.style.opacity = '0.7';
    }

    const body = new FormData();
    body.append('action', 'shift_end_update');
    body.append('evening_update', notes);
    body.append('task_status', statusVal);

    fetch(dailyPlanUrl(), { method: 'POST', body, credentials: 'same-origin' })
      .then(res => res.json())
      .then(res => {
        if (submitShiftEndBtn) {
          submitShiftEndBtn.disabled = false;
          submitShiftEndBtn.style.opacity = '1';
        }
        if (res.status !== 'success') {
          throw new Error(res.message || 'Unable to submit shift update');
        }

        const viewShiftTaskBtn = document.getElementById('viewShiftTaskBtn');
        if (viewShiftTaskBtn) {
          viewShiftTaskBtn.style.display = 'inline-flex';
          if (res.task_id) viewShiftTaskBtn.setAttribute('data-task-id', res.task_id);
        }

        if (shiftEndStatusMsg) {
          shiftEndStatusMsg.style.display = 'flex';
          shiftEndStatusMsg.className = 'shift-status-alert success';
          shiftEndStatusMsg.innerHTML = `
            <div style="flex:1;">🎉 <b>${res.message}</b> Added to your tasks as <b>${statusVal}</b>!</div>
            <button type="button" class="shift-view-task-btn" style="padding: 6px 14px; font-size: 12px; margin-left: auto;" onclick="openShiftWorkTaskModal()">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              <span>View Task</span>
            </button>
          `;
        }

        if (shiftStatusBadge) {
          shiftStatusBadge.textContent = 'Shift Ended (' + statusVal + ')';
          shiftStatusBadge.className = 'shift-wrapup-badge ' + (statusVal === 'Completed' ? 'completed' : 'pending');
        }

        // Immediately reload task list below
        if (typeof window.fetchEmployeeWorkplanTasks === 'function') {
          window.fetchEmployeeWorkplanTasks();
        }
      })
      .catch(err => {
        if (submitShiftEndBtn) {
          submitShiftEndBtn.disabled = false;
          submitShiftEndBtn.style.opacity = '1';
        }
        if (shiftEndStatusMsg) {
          shiftEndStatusMsg.style.display = 'flex';
          shiftEndStatusMsg.className = 'shift-status-alert error';
          shiftEndStatusMsg.textContent = err.message || 'Error submitting shift update.';
        }
      });
  }

  window.closeWorkplanTaskModal = function() {
    const modal = document.getElementById('workplanTaskDetailsModal');
    if (modal) {
      modal.classList.remove('active');
      modal.style.display = 'none';
    }
  };

  window.openWorkplanTaskDetails = function(taskId) {
    const task = employeeTasks.find(t => Number(t.id) === Number(taskId));
    if (!task) return;

    const el = id => document.getElementById(id);
    if (el('modalTaskTitle')) el('modalTaskTitle').textContent = task.title || 'Task Details';
    if (el('modalTaskDept')) el('modalTaskDept').textContent = task.department || task.dept || 'Engineering';
    if (el('modalTaskDeadline')) el('modalTaskDeadline').textContent = task.deadline || '—';

    const statusPill = el('modalTaskStatusPill');
    if (statusPill) {
      statusPill.textContent = task.status || 'Pending';
      statusPill.className = 'status-pill ' + (task.status === 'Completed' ? 'done' : (task.status === 'In Progress' ? 'in-progress' : 'pending'));
    }

    const priorityPill = el('modalTaskPriorityPill');
    if (priorityPill) {
      priorityPill.textContent = (task.priority || 'Medium') + ' Priority';
      const p = (task.priority || '').toLowerCase();
      priorityPill.className = 'tag-pill ' + (p === 'high' ? 'high' : (p === 'low' ? 'low' : 'medium'));
    }

    const modePill = el('modalTaskModePill');
    if (modePill) {
      modePill.textContent = task.mode || 'Online';
      modePill.className = 'tag-pill ' + ((task.mode || '').toLowerCase() === 'online' ? 'online' : 'onsite');
    }

    const descEl = el('modalTaskDesc');
    if (descEl) {
      descEl.textContent = task.description || 'No additional work plan details.';
    }

    const modal = document.getElementById('workplanTaskDetailsModal');
    if (modal) {
      modal.style.display = 'flex';
      modal.classList.add('active');
    }
  };

  window.openShiftWorkTaskModal = function() {
    const btn = document.getElementById('viewShiftTaskBtn');
    let targetTaskId = btn ? btn.getAttribute('data-task-id') : null;

    let targetTask = null;
    if (targetTaskId) {
      targetTask = employeeTasks.find(t => Number(t.id) === Number(targetTaskId));
    }
    if (!targetTask && employeeTasks.length > 0) {
      targetTask = employeeTasks[0];
    }

    if (targetTask) {
      window.openWorkplanTaskDetails(targetTask.id);
      const grid = document.getElementById('workplanTasksGrid');
      if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      window.fetchEmployeeWorkplanTasks();
      setTimeout(() => {
        if (employeeTasks.length > 0) {
          window.openWorkplanTaskDetails(employeeTasks[0].id);
        }
      }, 500);
    }
  };

  savePlanBtn?.addEventListener('click', () => saveDailyPlan(false));
  startWorkBtn?.addEventListener('click', () => saveDailyPlan(true));
  submitShiftEndBtn?.addEventListener('click', submitShiftEndUpdate);
  
  window.loadDailyPlan = loadDailyPlan;
  loadDailyPlan();




  window.fetchEmployeeWorkplanTasks = function () {
    const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
    let fetchUrl = pth + 'UxUi-Back/Tasks/fetch_tasks/fetch_tasks.php';
    if (window.currentEmployeeName) {
      fetchUrl += '?employee=' + encodeURIComponent(window.currentEmployeeName);
    }

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

          <div style="display: flex; gap: 8px; margin-top: 14px;">
            <button type="button" class="task-action-btn" style="flex: 1; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155;" onclick="openWorkplanTaskDetails(${t.id})">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              <span>View Task</span>
            </button>
            <div style="flex: 1.2;">
              ${actionBtnHtml}
            </div>
          </div>
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
    formData.append('updater_role', 'employee');

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
