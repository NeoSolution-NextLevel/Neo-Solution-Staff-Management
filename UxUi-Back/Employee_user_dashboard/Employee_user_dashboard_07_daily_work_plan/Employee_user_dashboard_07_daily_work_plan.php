<style>
  /* =========================================================
     DAILY WORK PLAN (CLEAN ALIGNMENT & RESPONSIVE)
  ========================================================= */
  #Employee_user_dashboard_07_daily_work_plan {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
    min-width: 0;
  }

  @media (min-width: 901px) {
    #Employee_user_dashboard_07_daily_work_plan {
      margin-left: 260px !important;
      width: calc(100% - 260px) !important;
      max-width: calc(100% - 260px) !important;
      padding: 0 24px 80px !important;
      box-sizing: border-box !important;
    }
  }

  @media (max-width: 900px) {
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
    min-width: 0;
  }

  #Employee_user_dashboard_07_daily_work_plan .topbar,
  #Employee_user_dashboard_07_daily_work_plan .topbar-left,
  #Employee_user_dashboard_07_daily_work_plan .topbar-right,
  #Employee_user_dashboard_07_daily_work_plan .workplan-header-row,
  #Employee_user_dashboard_07_daily_work_plan .workplan-head-left,
  #Employee_user_dashboard_07_daily_work_plan .workplan-step-card,
  #Employee_user_dashboard_07_daily_work_plan .task-card,
  #Employee_user_dashboard_07_daily_work_plan .task-card-head,
  #Employee_user_dashboard_07_daily_work_plan .task-card-title,
  #Employee_user_dashboard_07_daily_work_plan .task-card-desc {
    min-width: 0;
    box-sizing: border-box;
  }

  #Employee_user_dashboard_07_daily_work_plan .task-card-title,
  #Employee_user_dashboard_07_daily_work_plan .task-card-desc,
  #Employee_user_dashboard_07_daily_work_plan .task-meta-box .meta-value,
  #Employee_user_dashboard_07_daily_work_plan .step-header-wrap h3,
  #Employee_user_dashboard_07_daily_work_plan .step-subtext,
  #Employee_user_dashboard_07_daily_work_plan .plan-ref-content {
    overflow-wrap: anywhere;
    word-break: break-word;
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
    white-space: nowrap !important;
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
  @media (max-width: 900px) {
    #Employee_user_dashboard_07_daily_work_plan .topbar {
      gap: 10px;
      padding: 12px 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .topbar-left {
      flex: 1 1 auto;
      min-width: 0;
    }

    #Employee_user_dashboard_07_daily_work_plan .topbar-left h2 {
      min-width: 0;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      font-size: 16px !important;
    }

    #Employee_user_dashboard_07_daily_work_plan .topbar-right {
      flex: 0 0 auto;
      gap: 8px;
    }

    #Employee_user_dashboard_07_daily_work_plan .admin-pill span {
      display: none;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-step-card {
      padding: 18px 16px;
      border-radius: 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .step-header-wrap {
      align-items: flex-start;
    }

    #Employee_user_dashboard_07_daily_work_plan .step-title-group {
      flex: 1 1 220px;
      min-width: 0;
      align-items: flex-start;
    }

    #Employee_user_dashboard_07_daily_work_plan .step-title-group h3 {
      font-size: 15px;
      line-height: 1.35;
    }

    #Employee_user_dashboard_07_daily_work_plan .shift-wrapup-badge {
      max-width: 100%;
      white-space: normal !important;
      text-align: center;
    }

    #Employee_user_dashboard_07_daily_work_plan .daily-plan-actions {
      align-items: stretch;
    }

    #Employee_user_dashboard_07_daily_work_plan .daily-plan-actions > button {
      flex: 1 1 100%;
      justify-content: center;
    }

    #Employee_user_dashboard_07_daily_work_plan .daily-plan-status {
      width: 100%;
    }

    #Employee_user_dashboard_07_daily_work_plan .shift-ctrls-row {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }

    #Employee_user_dashboard_07_daily_work_plan .shift-ctrls-row > div,
    #Employee_user_dashboard_07_daily_work_plan .shift-ctrls-row > button {
      width: 100%;
      box-sizing: border-box;
    }

    #Employee_user_dashboard_07_daily_work_plan .shift-ctrls-row > div {
      align-items: stretch !important;
      flex-direction: column;
      gap: 6px !important;
    }

    #Employee_user_dashboard_07_daily_work_plan .shift-ctrls-row select {
      width: 100%;
      min-width: 0 !important;
      box-sizing: border-box;
    }

    #Employee_user_dashboard_07_daily_work_plan .shift-end-submit-btn,
    #Employee_user_dashboard_07_daily_work_plan .shift-view-task-btn {
      width: 100%;
      justify-content: center;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-header-row {
      align-items: flex-start;
      margin-bottom: 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-head-left h1 {
      font-size: 18px;
      line-height: 1.3;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-head-left p {
      font-size: 13px;
      line-height: 1.4;
    }

    #Employee_user_dashboard_07_daily_work_plan .view-switcher {
      flex: 0 0 auto;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-filters {
      align-items: stretch;
      gap: 8px;
      margin-bottom: 16px;
    }

    #Employee_user_dashboard_07_daily_work_plan .search-pill-wrap,
    #Employee_user_dashboard_07_daily_work_plan .filter-pill-select {
      width: 100%;
      max-width: none;
      min-width: 0;
      box-sizing: border-box;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-tasks-grid {
      grid-template-columns: 1fr !important;
      gap: 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-card {
      padding: 18px 16px;
      border-radius: 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-card-head {
      align-items: flex-start;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-card-title {
      flex: 1 1 auto;
      font-size: 15px;
    }

    #Employee_user_dashboard_07_daily_work_plan .status-pill {
      flex: 0 0 auto;
      white-space: normal;
      text-align: center;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-tags-row {
      flex-wrap: wrap;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-meta-grid {
      grid-template-columns: 1fr;
      gap: 8px;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-card > div:last-child {
      flex-direction: column;
    }

    #Employee_user_dashboard_07_daily_work_plan .task-card > div:last-child > *,
    #Employee_user_dashboard_07_daily_work_plan .task-card > div:last-child > div {
      width: 100%;
      flex: 1 1 auto !important;
      box-sizing: border-box;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-overlay {
      padding: 8px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-card {
      width: 100%;
      max-height: calc(100vh - 16px);
      border-radius: 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-header {
      padding: 14px 16px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-header h3 {
      min-width: 0;
      font-size: 15px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-body {
      padding: 16px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-body [style*="grid-template-columns"] {
      grid-template-columns: 1fr !important;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-footer {
      padding: 12px 16px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-footer button {
      width: 100%;
      justify-content: center;
    }
  }

  @media (max-width: 480px) {
    #Employee_user_dashboard_07_daily_work_plan {
      padding-left: 10px !important;
      padding-right: 10px !important;
    }

    #Employee_user_dashboard_07_daily_work_plan .topbar {
      padding-left: 0;
      padding-right: 0;
    }

    #Employee_user_dashboard_07_daily_work_plan .workplan-step-card,
    #Employee_user_dashboard_07_daily_work_plan .task-card {
      padding: 14px;
    }

    #Employee_user_dashboard_07_daily_work_plan .step-title-group {
      gap: 7px;
    }

    #Employee_user_dashboard_07_daily_work_plan .step-badge {
      padding-left: 9px;
      padding-right: 9px;
    }

    #Employee_user_dashboard_07_daily_work_plan .daily-plan-input {
      min-height: 84px;
      padding: 11px 12px;
    }

    #Employee_user_dashboard_07_daily_work_plan .emp-modal-overlay {
      padding: 5px;
    }
  }

  /* Work Plan Upload & Attachments System */
  .workplan-upload-section {
    margin-top: 14px;
    margin-bottom: 14px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px;
  }

  .workplan-upload-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
  }

  .upload-title {
    font-size: 12.5px;
    font-weight: 800;
    color: #1e293b;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .upload-hint {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
  }

  .workplan-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    background: #ffffff;
    padding: 14px 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .workplan-dropzone:hover,
  .workplan-dropzone.dragover {
    border-color: #3b82f6;
    background: #eff6ff;
  }

  .dropzone-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .dropzone-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .dropzone-text {
    font-size: 13px;
    color: #475569;
  }

  .dropzone-text strong {
    color: #2563eb;
  }

  /* Pending Files Tray */
  .workplan-pending-tray {
    margin-top: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .pending-file-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 5px 10px 5px 6px;
    font-size: 12px;
    color: #1e293b;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
  }

  .pending-thumb {
    width: 26px;
    height: 26px;
    border-radius: 4px;
    object-fit: cover;
  }

  .pending-icon {
    width: 26px;
    height: 26px;
    border-radius: 4px;
    background: #e2e8f0;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
  }

  .pending-file-info {
    display: flex;
    flex-direction: column;
    max-width: 140px;
  }

  .pending-name {
    font-weight: 700;
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .pending-size {
    font-size: 10.5px;
    color: #64748b;
  }

  .pending-remove-btn {
    background: none;
    border: none;
    color: #ef4444;
    cursor: pointer;
    font-size: 16px;
    line-height: 1;
    padding: 0 4px;
  }

  /* Saved Attachments Gallery */
  .workplan-saved-gallery {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .gallery-group-title {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 4px;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 8px;
  }

  .wp-photo-card {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    aspect-ratio: 1;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }

  .wp-photo-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  .wp-photo-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .wp-photo-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  .wp-photo-card:hover .wp-photo-overlay {
    opacity: 1;
  }

  .wp-card-action-btn {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    background: #ffffff;
    border: none;
    color: #1e293b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
    font-size: 11px;
    transition: background 0.15s;
  }

  .wp-card-action-btn:hover {
    background: #f1f5f9;
  }

  .wp-card-action-btn.delete-btn {
    color: #ef4444;
  }
  .wp-card-action-btn.delete-btn:hover {
    background: #fee2e2;
  }

  .wp-docs-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .wp-doc-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 7px 10px;
    gap: 8px;
  }

  .wp-doc-left {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
  }

  .wp-doc-icon-badge {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
  }

  .wp-doc-name {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .wp-doc-meta {
    font-size: 10.5px;
    color: #64748b;
  }

  .wp-doc-actions {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-shrink: 0;
  }

  .wp-doc-btn {
    padding: 3px 7px;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    border: 1px solid transparent;
  }

  .wp-doc-btn.view-btn-doc {
    background: #eff6ff;
    color: #2563eb;
    border-color: #bfdbfe;
  }

  .wp-doc-btn.dl-btn-doc {
    background: #ecfdf5;
    color: #059669;
    border-color: #a7f3d0;
  }

  .wp-doc-btn.del-btn-doc {
    background: #fef2f2;
    color: #ef4444;
    border-color: #fecaca;
    cursor: pointer;
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
          <div class="avatar" id="topAvatarPlanPreview"><?php echo htmlspecialchars(!empty($logged_user_initials) ? $logged_user_initials : 'EM'); ?></div>
          <span id="topEmpPlanName"><?php echo htmlspecialchars(!empty($logged_user_first_name) && $logged_user_first_name !== 'Guest' ? $logged_user_first_name : 'Employee'); ?></span>
        </div>
      </div>
    </div>

    <div class="workplan-step-container">
      
      <section class="workplan-step-card step-1-card">
        <div class="step-header-wrap">
          <div class="step-title-group">
            <span class="step-badge step-1">Step 1</span>
            <h3>Plan Today's Work</h3>
          </div>
          <span id="morningPlanStatusBadge" class="shift-wrapup-badge pending">Shift Not Started</span>
        </div>
        <p class="step-subtext">Write down the tasks you plan to accomplish today. Click <b>Start Work</b> to activate your shift for the day.</p>
        
        <textarea id="dailyWorkPlanText" class="daily-plan-input" placeholder="Enter today's planned tasks:"></textarea>

        <!-- Step 1 File Upload Section -->
        <div class="workplan-upload-section" id="step1UploadSection">
          <div class="workplan-upload-header">
            <span class="upload-title">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
              Plan Documents & Photos (Optional)
            </span>
            <span class="upload-hint">Upload task specs, reference docs, or photos (JPG, PNG, PDF, DOCX up to 15MB)</span>
          </div>

          <div class="workplan-dropzone" id="step1Dropzone" onclick="document.getElementById('step1FileInput').click()">
            <input type="file" id="step1FileInput" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,image/*" style="display:none;" onchange="handleStepFileSelect('step1', this.files)">
            <div class="dropzone-content">
              <div class="dropzone-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              </div>
              <div class="dropzone-text">
                <strong>Click to browse</strong> or drag &amp; drop plan documents &amp; photos here
              </div>
            </div>
          </div>

          <!-- Pending Files Tray -->
          <div class="workplan-pending-tray" id="step1PendingTray" style="display:none;"></div>

          <!-- Saved Attachments Gallery -->
          <div class="workplan-saved-gallery" id="step1SavedGallery"></div>
        </div>
        
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

      <section class="workplan-step-card step-2-card">
        <div class="step-header-wrap">
          <div class="step-title-group">
            <span class="step-badge step-2">Step 2</span>
            <h3>Update on Planned Work</h3>
          </div>
          <span class="shift-wrapup-badge" id="shiftStatusBadge"> Shift In Progress</span>
        </div>
        <p class="step-subtext">When ending your shift, review your plan below and provide an update on what was accomplished:</p>

        <div class="plan-ref-box">
          <div class="plan-ref-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Today's Plan:
          </div>
          <div id="morningPlanPreviewText" class="plan-ref-content">No plan entered yet. Write your plan in Step 1 above.</div>
        </div>

        <label style="font-size:13px; font-weight:700; color:#334155; display:block; margin-bottom:6px;">
          What did you complete from this plan?:
        </label>
        <textarea id="shiftEndNotes" class="daily-plan-input" placeholder="Write what you finished from the morning plan, what remains pending, or any end-of-shift notes..."></textarea>

        <!-- Step 2 File Upload Section -->
        <div class="workplan-upload-section" id="step2UploadSection">
          <div class="workplan-upload-header">
            <span class="upload-title">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
              Work Proof, Photos &amp; Documents (Optional)
            </span>
            <span class="upload-hint">Upload completed work proof photos, receipts, or summary PDFs</span>
          </div>

          <div class="workplan-dropzone" id="step2Dropzone" onclick="document.getElementById('step2FileInput').click()">
            <input type="file" id="step2FileInput" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,image/*" style="display:none;" onchange="handleStepFileSelect('step2', this.files)">
            <div class="dropzone-content">
              <div class="dropzone-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              </div>
              <div class="dropzone-text">
                <strong>Click to browse</strong> or drag &amp; drop proof photos &amp; completion documents here
              </div>
            </div>
          </div>

          <!-- Pending Files Tray -->
          <div class="workplan-pending-tray" id="step2PendingTray" style="display:none;"></div>

          <!-- Saved Attachments Gallery -->
          <div class="workplan-saved-gallery" id="step2SavedGallery"></div>
        </div>

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
            <span>Submit Update</span>
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

    <div class="workplan-header-row">
      <div class="workplan-head-left">
        <h1>My Assigned & Daily Tasks</h1>
        <p id="empActiveTasksCount">Loading tasks from database...</p>
      </div>

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

    <div class="workplan-tasks-grid" id="workplanTasksGrid">
      <div style="text-align:center; padding: 40px 16px; color:#64748b; background:#fff; border-radius:16px; grid-column: 1 / -1; border:1px solid #e8eaf0;">
        Loading your tasks...
      </div>
    </div>

  </div>

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

        <div id="modalTaskAttachmentsWrap" style="display:none; margin-top: 10px;">
          <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Work Proof &amp; Attachments</div>
          <div id="modalTaskAttachmentsList" style="display:flex; flex-wrap:wrap; gap:8px;"></div>
        </div>
      </div>
      <div class="emp-modal-footer">
        <button type="button" class="save-plan-btn" onclick="closeWorkplanTaskModal()">Close</button>
      </div>
    </div>
  </div>

  <!-- Photo Preview / Lightbox Modal -->
  <div class="emp-modal-overlay" id="workplanPhotoPreviewModal" style="display:none;" onclick="if(event.target===this) closeWorkplanPhotoModal();">
    <div class="emp-modal-card" style="max-width: 680px; width: 95%; padding: 0; overflow: hidden; background: #0f172a; border-radius: 14px;">
      <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: #1e293b; color: #ffffff;">
        <div style="display: flex; align-items: center; gap: 8px; min-width: 0;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span id="photoPreviewModalTitle" style="font-weight: 700; font-size: 13.5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #f8fafc;">Photo Preview</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
          <a id="photoPreviewDownloadBtn" href="#" download class="save-plan-btn" style="padding: 5px 12px; font-size: 12px; background: #334155; color: #ffffff; border: none; text-decoration: none;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Download
          </a>
          <button type="button" class="emp-modal-close" style="color: #94a3b8; font-size: 22px; cursor: pointer; background: none; border: none;" onclick="closeWorkplanPhotoModal()">&times;</button>
        </div>
      </div>
      <div style="padding: 16px; display: flex; align-items: center; justify-content: center; min-height: 260px; max-height: 70vh; overflow: auto; background: #0b1120;">
        <img id="photoPreviewModalImg" src="" alt="Work plan photo" style="max-width: 100%; max-height: 65vh; object-fit: contain; border-radius: 6px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);" />
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

  const shiftEndNotes = document.getElementById('shiftEndNotes');
  const shiftEndTaskStatus = document.getElementById('shiftEndTaskStatus');
  const submitShiftEndBtn = document.getElementById('submitShiftEndBtn');
  const shiftEndStatusMsg = document.getElementById('shiftEndStatusMsg');
  const shiftStatusBadge = document.getElementById('shiftStatusBadge');

  function escapeHtml(str) {
    return (str || '').toString().replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[m]);
  }

  let step1SelectedFiles = [];
  let step2SelectedFiles = [];
  let currentPlanAttachments = [];
  let currentShiftAttachments = [];

  const photoExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'bmp'];

  window.handleStepFileSelect = function (step, files) {
    if (!files || !files.length) return;
    const targetArr = step === 'step1' ? step1SelectedFiles : step2SelectedFiles;
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      if (file.size > 20 * 1024 * 1024) {
        alert('File "' + file.name + '" exceeds the 20MB limit.');
        continue;
      }
      if (!targetArr.some(f => f.name === file.name && f.size === file.size)) {
        targetArr.push(file);
      }
    }
    renderPendingTray(step);
  };

  function renderPendingTray(step) {
    const tray = document.getElementById(step + 'PendingTray');
    if (!tray) return;
    const targetArr = step === 'step1' ? step1SelectedFiles : step2SelectedFiles;
    if (targetArr.length === 0) {
      tray.style.display = 'none';
      tray.innerHTML = '';
      return;
    }
    tray.style.display = 'flex';
    tray.innerHTML = targetArr.map((f, idx) => {
      const ext = (f.name.split('.').pop() || '').toLowerCase();
      const isPhoto = photoExtensions.includes(ext);
      const sizeStr = f.size >= 1048576 ? (f.size / 1048576).toFixed(1) + ' MB' : (f.size / 1024).toFixed(0) + ' KB';

      let previewThumb = '';
      if (isPhoto) {
        const tempUrl = URL.createObjectURL(f);
        previewThumb = `<img src="${tempUrl}" class="pending-thumb" alt="${escapeHtml(f.name)}" />`;
      } else {
        previewThumb = `<div class="pending-icon">${escapeHtml(ext.toUpperCase().substring(0, 3))}</div>`;
      }

      return `
        <div class="pending-file-chip">
          ${previewThumb}
          <div class="pending-file-info">
            <span class="pending-name" title="${escapeHtml(f.name)}">${escapeHtml(f.name)}</span>
            <span class="pending-size">${sizeStr} (ready to upload)</span>
          </div>
          <button type="button" class="pending-remove-btn" title="Remove" onclick="removePendingStepFile('${step}', ${idx})">&times;</button>
        </div>
      `;
    }).join('');
  }

  window.removePendingStepFile = function (step, idx) {
    const targetArr = step === 'step1' ? step1SelectedFiles : step2SelectedFiles;
    targetArr.splice(idx, 1);
    renderPendingTray(step);
  };

  function renderSavedGallery(step, attachments) {
    const gallery = document.getElementById(step + 'SavedGallery');
    if (!gallery) return;
    if (!attachments || attachments.length === 0) {
      gallery.innerHTML = '';
      return;
    }

    const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
    const photos = attachments.filter(a => a.file_type === 'photo');
    const docs = attachments.filter(a => a.file_type !== 'photo');

    let html = '';

    if (photos.length > 0) {
      html += `
        <div style="margin-bottom:8px;">
          <div class="gallery-group-title">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Photos (${photos.length})
          </div>
          <div class="gallery-grid">
            ${photos.map(ph => {
              const fullSrc = pth + ph.file_path;
              return `
                <div class="wp-photo-card" onclick="openWorkplanPhotoModal('${escapeHtml(ph.name)}', '${fullSrc}', '${escapeHtml(ph.file_size)}')">
                  <img src="${fullSrc}" alt="${escapeHtml(ph.name)}" />
                  <div class="wp-photo-overlay" onclick="event.stopPropagation()">
                    <button type="button" class="wp-card-action-btn" title="View Photo" onclick="openWorkplanPhotoModal('${escapeHtml(ph.name)}', '${fullSrc}', '${escapeHtml(ph.file_size)}')">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                    </button>
                    <a href="${fullSrc}" download="${escapeHtml(ph.name)}" class="wp-card-action-btn" title="Download">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </a>
                    <button type="button" class="wp-card-action-btn delete-btn" title="Delete attachment" onclick="deleteWorkplanAttachment('${ph.id}', '${step}')">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                  </div>
                </div>
              `;
            }).join('')}
          </div>
        </div>
      `;
    }

    if (docs.length > 0) {
      html += `
        <div>
          <div class="gallery-group-title">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Documents (${docs.length})
          </div>
          <div class="wp-docs-list">
            ${docs.map(doc => {
              const fullSrc = pth + doc.file_path;
              return `
                <div class="wp-doc-row">
                  <div class="wp-doc-left">
                    <div class="wp-doc-icon-badge">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div>
                      <div class="wp-doc-name" title="${escapeHtml(doc.name)}">${escapeHtml(doc.name)}</div>
                      <div class="wp-doc-meta">${escapeHtml(doc.file_size)} • ${escapeHtml(doc.uploaded_at || '')}</div>
                    </div>
                  </div>
                  <div class="wp-doc-actions">
                    <a href="${fullSrc}" target="_blank" class="wp-doc-btn view-btn-doc" title="View file in new tab">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      View
                    </a>
                    <a href="${fullSrc}" download="${escapeHtml(doc.name)}" class="wp-doc-btn dl-btn-doc" title="Download">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                      Download
                    </a>
                    <button type="button" class="wp-doc-btn del-btn-doc" title="Delete attachment" onclick="deleteWorkplanAttachment('${doc.id}', '${step}')">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                  </div>
                </div>
              `;
            }).join('')}
          </div>
        </div>
      `;
    }

    gallery.innerHTML = html;
  }

  window.openWorkplanPhotoModal = function (title, src, size) {
    const modal = document.getElementById('workplanPhotoPreviewModal');
    const img = document.getElementById('photoPreviewModalImg');
    const titleEl = document.getElementById('photoPreviewModalTitle');
    const dlBtn = document.getElementById('photoPreviewDownloadBtn');
    if (!modal || !img) return;
    img.src = src;
    if (titleEl) titleEl.textContent = title + (size ? ' (' + size + ')' : '');
    if (dlBtn) {
      dlBtn.href = src;
      dlBtn.setAttribute('download', title || 'photo');
    }
    modal.style.display = 'flex';
  };

  window.closeWorkplanPhotoModal = function () {
    const modal = document.getElementById('workplanPhotoPreviewModal');
    if (modal) modal.style.display = 'none';
  };

  window.deleteWorkplanAttachment = function (attId, step) {
    if (!confirm('Are you sure you want to remove this attachment?')) return;
    const body = new FormData();
    body.append('action', 'delete_attachment');
    body.append('attachment_id', attId);

    fetch(dailyPlanUrl(), { method: 'POST', body, credentials: 'same-origin' })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          if (step === 'step1') {
            currentPlanAttachments = res.plan_attachments || [];
            renderSavedGallery('step1', currentPlanAttachments);
          } else {
            currentShiftAttachments = res.shift_attachments || [];
            renderSavedGallery('step2', currentShiftAttachments);
          }
        } else {
          alert(res.message || 'Unable to delete attachment');
        }
      })
      .catch(() => alert('Network error while deleting attachment.'));
  };

  function setupDropzoneEvents(zoneId, step) {
    const zone = document.getElementById(zoneId);
    if (!zone) return;
    ['dragenter', 'dragover'].forEach(eventName => {
      zone.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
        zone.classList.add('dragover');
      }, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
      zone.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
        zone.classList.remove('dragover');
      }, false);
    });
    zone.addEventListener('drop', e => {
      const dt = e.dataTransfer;
      if (dt && dt.files && dt.files.length) {
        handleStepFileSelect(step, dt.files);
      }
    }, false);
  }

  setTimeout(() => {
    setupDropzoneEvents('step1Dropzone', 'step1');
    setupDropzoneEvents('step2Dropzone', 'step2');
  }, 100);

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
          currentPlanAttachments = [];
          currentShiftAttachments = [];
          renderSavedGallery('step1', []);
          renderSavedGallery('step2', []);
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

        currentPlanAttachments = res.data.plan_attachments || [];
        currentShiftAttachments = res.data.shift_attachments || [];
        renderSavedGallery('step1', currentPlanAttachments);
        renderSavedGallery('step2', currentShiftAttachments);

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
    step1SelectedFiles.forEach(f => {
      body.append('plan_files[]', f);
    });

    fetch(dailyPlanUrl(), { method: 'POST', body, credentials: 'same-origin' })
      .then(res => res.json())
      .then(res => {
        if (res.status !== 'success') throw new Error(res.message || 'Unable to save plan');

        step1SelectedFiles = [];
        renderPendingTray('step1');
        const fileInp = document.getElementById('step1FileInput');
        if (fileInp) fileInp.value = '';
        if (res.data && res.data.plan_attachments) {
          currentPlanAttachments = res.data.plan_attachments;
          renderSavedGallery('step1', currentPlanAttachments);
        }
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
    step2SelectedFiles.forEach(f => {
      body.append('shift_files[]', f);
    });

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

        step2SelectedFiles = [];
        renderPendingTray('step2');
        const fileInp2 = document.getElementById('step2FileInput');
        if (fileInp2) fileInp2.value = '';
        if (res.data && res.data.shift_attachments) {
          currentShiftAttachments = res.data.shift_attachments;
          renderSavedGallery('step2', currentShiftAttachments);
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

    const modePill = el('modalTaskModePill');
    if (modePill) {
      modePill.textContent = task.mode || 'Online';
      modePill.className = 'tag-pill ' + ((task.mode || '').toLowerCase() === 'online' ? 'online' : 'onsite');
    }

    const descEl = el('modalTaskDesc');
    if (descEl) {
      descEl.textContent = task.description || 'No additional work plan details.';
    }

    const attWrap = el('modalTaskAttachmentsWrap');
    const attList = el('modalTaskAttachmentsList');
    if (attWrap && attList) {
      const allAtts = [...currentPlanAttachments, ...currentShiftAttachments];
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      if (allAtts.length > 0) {
        attWrap.style.display = 'block';
        attList.innerHTML = allAtts.map(a => {
          const src = pth + a.file_path;
          if (a.file_type === 'photo') {
            return `
              <div class="wp-photo-card" style="width:58px; height:58px;" onclick="openWorkplanPhotoModal('${escapeHtml(a.name)}', '${src}', '${escapeHtml(a.file_size)}')">
                <img src="${src}" alt="${escapeHtml(a.name)}" />
                <div class="wp-photo-overlay">
                  <span style="color:#ffffff; font-size:10px;"><i class="fa-solid fa-eye"></i></span>
                </div>
              </div>
            `;
          } else {
            return `
              <a href="${src}" target="_blank" style="display:inline-flex; align-items:center; gap:5px; background:#f1f5f9; border:1px solid #cbd5e1; border-radius:6px; padding:4px 8px; font-size:12px; color:#1e293b; text-decoration:none;" title="${escapeHtml(a.name)}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span style="max-width:120px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:600;">${escapeHtml(a.name)}</span>
              </a>
            `;
          }
        }).join('');
      } else {
        attWrap.style.display = 'none';
      }
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
    const empName = window.currentEmployeeName 
      || (document.getElementById('empSidebarName') && document.getElementById('empSidebarName').textContent.trim()) 
      || (document.getElementById('dashTopEmpName') && document.getElementById('dashTopEmpName').textContent.trim()) 
      || '';
    if (empName && empName !== 'Loading...' && empName !== 'Employee') {
      fetchUrl += '?employee=' + encodeURIComponent(empName);
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
