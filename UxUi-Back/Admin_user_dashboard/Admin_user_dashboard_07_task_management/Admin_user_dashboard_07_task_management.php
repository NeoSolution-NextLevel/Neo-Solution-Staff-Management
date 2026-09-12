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
      max-width: 100vw;
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

    .task-pill {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 11.5px;
      font-weight: 700;
      line-height: 1;
      white-space: nowrap !important;
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
      margin: 0 auto;
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

    .task-btn-view {
      background: #f0fdf4;
      color: #16a34a;
      border: 1px solid #bbf7d0;
      padding: 6px 12px;
      font-size: 12px;
      font-weight: 700;
      width: auto;
      height: 32px;
      border-radius: 8px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.15s ease;
    }
    .task-btn-view:hover { background: #dcfce7; color: #15803d; transform: translateY(-1px); }
    .task-btn-edit {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1px solid #bfdbfe;
      background: #eff6ff;
      color: #2563eb;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .task-btn-edit:hover { background: #dbeafe; color: #1d4ed8; transform: translateY(-1px); }
    .task-btn-delete { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
    .task-btn-delete:hover { background: #fee2e2; color: #dc2626; transform: translateY(-1px); }

    .w3-modal-overlay {
      position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 999999;
      display: none; align-items: center; justify-content: center; padding: 12px; box-sizing: border-box; overflow-y: auto;
    }
    .w3-modal-overlay.active { display: flex; }
    .w3-modal-card {
      background-color: #ffffff; border-radius: 16px; width: 100%; max-width: 540px; max-height: 90vh; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden;
      display: flex; flex-direction: column; margin: auto;
    }
    .w3-modal-header { 
      display: flex; 
      align-items: center; 
      justify-content: space-between; 
      padding: 16px 22px; 
      background-color: #f8fafc; 
      border-bottom: 1px solid #e2e8f0; 
      flex-shrink: 0; 
    }
    .w3-modal-header h3 { 
      font-size: 17px; 
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
    .w3-modal-body { 
      padding: 18px 22px; 
      display: flex; 
      flex-direction: column; 
      gap: 14px; 
      overflow-y: auto; 
      -webkit-overflow-scrolling: touch; 
      flex: 1; 
    }
    .w3-form-group { 
      display: flex; 
      flex-direction: column; 
      gap: 5px; 
    }
    .w3-form-group label { 
      font-size: 12px; 
      font-weight: 700; 
      color: #475569; 
    }
    .w3-form-group input, .w3-form-group select, .w3-form-group textarea { 
      padding: 10px 12px; 
      border: 1px solid #cbd5e1; 
      border-radius: 8px; 
      font-size: 13.5px; 
      color: #1e293b; 
      outline: none; 
      background-color: #ffffff; 
      width: 100%; 
      box-sizing: border-box; 
      font-family: inherit; 
    }
    .w3-form-group input:focus, .w3-form-group select:focus, .w3-form-group textarea:focus { 
      border-color: #3b5bdb; 
      box-shadow: 0 0 0 3px rgba(59,91,219,0.12); 
    }
    .w3-form-row { 
      display: grid; 
      grid-template-columns: 1fr 1fr; 
      gap: 12px; 
    }
    .w3-modal-footer { 
      display: flex; 
      align-items: center; 
      justify-content: flex-end; 
      gap: 10px; 
      padding: 14px 22px; 
      border-top: 1px solid #f1f5f9; 
      background: #ffffff; flex-shrink: 0; 
    }
    .w3-btn-cancel { 
      padding: 10px 18px; 
      border-radius: 8px; 
      border: 1px solid #cbd5e1; 
      background-color: #ffffff; 
      color: #64748b; font-size: 13px; 
      font-weight: 600; cursor: pointer; 
    }
    .w3-btn-save { 
      padding: 10px 20px; 
      border-radius: 8px; 
      border: none; 
      background-color: #14204d; 
      color: #ffffff; 
      font-size: 13px; 
      font-weight: 700; 
      cursor: pointer; 
      box-shadow: 0 2px 6px rgba(20, 32, 77, 0.2); 
    }

    @media (max-width: 1024px) {
      .task-controls-row {
        flex-direction: column;
        align-items: flex-start;
      }
      .task-search-box {
        width: 100%;
        max-width: 100%;
      }
      .task-filter-group {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 5px;
      }
    }

    @media (max-width: 900px) {
      #Admin_user_dashboard_07_task_management {
        padding: 12px 14px 80px !important;
      }

      .topbar {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 8px !important;
        margin-bottom: 14px !important;
      }

      .topbar-left {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        min-width: 0 !important;
        flex: 1 !important;
      }

      .menu-btn {
        display: inline-flex !important;
        flex-shrink: 0 !important;
      }

      .topbar h2 {
        font-size: 16px !important;
        line-height: 1.25 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
      }

      .topbar-right {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-shrink: 0 !important;
      }

      .admin-pill {
        padding: 4px 8px 4px 4px !important;
      }

      .admin-pill span {
        display: none !important;
      }

      .task-header-row {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 10px !important;
        margin-bottom: 12px !important;
      }

      .task-count-text {
        min-width: 0 !important;
        font-size: 13.5px !important;
        font-weight: 700 !important;
        color: #64748b !important;
        margin: 0 !important;
        overflow-wrap: anywhere !important;
      }

      .btn-create-task {
        width: auto !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 8px 16px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        border-radius: 8px !important;
        background: #14204d !important;
        color: #ffffff !important;
        white-space: nowrap !important;
        box-shadow: 0 2px 6px rgba(20,32,77,0.2) !important;
      }

      .task-controls-row {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 10px !important;
        margin-bottom: 14px !important;
      }

      .task-search-box {
        max-width: 100% !important;
        width: 100% !important;
        padding: 10px 14px !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
      }

      .task-search-box input {
        font-size: 13.5px !important;
        width: 100% !important;
      }

      .task-filter-group {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
        overflow: visible !important;
        white-space: normal !important;
        padding: 2px 2px 4px 2px !important;
        width: 100% !important;
      }

      .filter-pill {
        padding: 7px 15px !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        white-space: normal !important;
        border-radius: 999px !important;
      }

      #taskEmployeeFilter {
        margin-left: 0 !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        padding: 7px 14px !important;
        border-radius: 999px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
        color: #334155 !important;
      }

      .task-table-container {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        overflow: visible !important;
      }

      .task-table,
      .task-table tbody {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
        width: 100% !important;
        min-width: 100% !important;
      }

      .task-table thead {
        display: none !important;
      }

      /* Premium 2-Column Mobile Grid Card */
      .task-table tr {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        grid-template-areas:
          "task task"
          "employee deadline"
          "mode status"
          "actions actions" !important;
        background: #ffffff !important;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 16px !important;
        margin-bottom: 0 !important;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04) !important;
        gap: 12px 14px !important;
        box-sizing: border-box !important;
        width: 100% !important;
      }

      .task-table td.col-task {
        grid-area: task !important;
        display: block !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 0 0 12px 0 !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }

      .task-table td.col-task .task-title-text {
        font-size: 15.5px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        line-height: 1.35 !important;
      }

      .task-table td.col-task .task-dept-text {
        display: inline-block !important;
        background: #f1f5f9 !important;
        color: #475569 !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        padding: 2.5px 8px !important;
        border-radius: 6px !important;
        margin-top: 5px !important;
      }

      .task-table td.col-employee {
        grid-area: employee !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        min-width: 0 !important;
      }

      .task-table td.col-employee::before {
        content: "Assigned To" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
      }

      .task-table td.col-employee {
        color: #1e293b !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        line-height: 1.35 !important;
        word-break: break-word !important;
      }

      .task-table td.col-deadline {
        grid-area: deadline !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        min-width: 0 !important;
      }

      .task-table td.col-deadline::before {
        content: "Deadline" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
      }

      .task-table td.col-deadline {
        color: #334155 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        white-space: nowrap !important;
      }

      .task-table td.col-mode {
        grid-area: mode !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        white-space: nowrap !important;
      }

      .task-table td.col-mode::before {
        content: "Work Mode" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        white-space: nowrap !important;
      }

      .task-table td.col-status {
        grid-area: status !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        white-space: nowrap !important;
      }

      .task-table td.col-status::before {
        content: "Status" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        white-space: nowrap !important;
      }

      .task-table td.col-actions {
        grid-area: actions !important;
        display: flex !important;
        border-top: 1px solid #f1f5f9 !important;
        padding: 12px 0 0 0 !important;
        margin-top: 4px !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }

      .task-table td.col-actions .task-action-group {
        display: flex !important;
        width: 100% !important;
        gap: 8px !important;
        margin: 0 !important;
      }

      .task-table td.col-actions .task-btn-view {
        flex: 1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        height: 38px !important;
        padding: 0 14px !important;
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
      }

      .task-table td.col-actions .task-btn-edit {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 38px !important;
        width: 44px !important;
        background: #f8fafc !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        cursor: pointer !important;
      }

      .w3-form-row { grid-template-columns: 1fr !important; }

      .w3-modal-overlay {
        padding: 10px !important;
        align-items: flex-start !important;
        padding-top: 30px !important;
      }
      .w3-modal-card {
        width: 100% !important;
        max-width: 100% !important;
        border-radius: 14px !important;
      }
      .w3-modal-header {
        padding: 14px 18px !important;
      }
      .w3-modal-body {
        padding: 14px 18px !important;
      }
      .w3-modal-footer {
        padding: 12px 18px !important;
      }
    }

    @media (max-width: 600px) {
      #Admin_user_dashboard_07_task_management {
        padding: 8px 10px 64px !important;
        overflow-x: hidden !important;
      }

      #Admin_user_dashboard_07_task_management .main-task-wrapper {
        gap: 12px !important;
      }

      #Admin_user_dashboard_07_task_management .task-header-row {
        gap: 8px !important;
      }

      #Admin_user_dashboard_07_task_management .task-count-text {
        font-size: 12px !important;
        line-height: 1.3 !important;
      }

      #Admin_user_dashboard_07_task_management .btn-create-task {
        padding: 8px 11px !important;
        font-size: 12px !important;
      }

      #Admin_user_dashboard_07_task_management .task-filter-group {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        width: 100% !important;
        overflow: visible !important;
        padding: 0 !important;
        gap: 7px !important;
      }

      #Admin_user_dashboard_07_task_management .filter-pill,
      #Admin_user_dashboard_07_task_management #taskEmployeeFilter {
        width: 100% !important;
        min-width: 0 !important;
        padding: 8px 6px !important;
        font-size: 11.5px !important;
        white-space: normal !important;
        text-align: center !important;
        box-sizing: border-box !important;
      }

      #Admin_user_dashboard_07_task_management .task-table tr {
        grid-template-columns: 1fr 1fr !important;
        padding: 14px !important;
        gap: 12px 14px !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td {
        min-width: 0 !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-employee {
        overflow-wrap: anywhere !important;
        word-break: break-word !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-status,
      #Admin_user_dashboard_07_task_management .task-table td.col-mode,
      #Admin_user_dashboard_07_task_management .task-table td.col-deadline {
        overflow-wrap: normal !important;
        word-break: normal !important;
        white-space: nowrap !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-status .task-pill,
      #Admin_user_dashboard_07_task_management .task-table td.col-mode .task-pill {
        white-space: nowrap !important;
        display: inline-flex !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-task .task-title-text,
      #Admin_user_dashboard_07_task_management .task-table td.col-task .task-dept-text {
        overflow-wrap: anywhere !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-actions .task-action-group {
        flex-wrap: wrap !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-actions .task-btn-view {
        min-width: 0 !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-overlay {
        padding: 8px !important;
        padding-top: 18px !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-card {
        max-height: calc(100dvh - 26px) !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-header h3 {
        font-size: 15px !important;
        max-width: calc(100% - 36px) !important;
        overflow-wrap: anywhere !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-footer {
        flex-wrap: wrap !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-footer button {
        flex: 1 1 120px !important;
      }
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
        <div class="task-header-row">
          <p class="task-count-text" id="taskCount"></p>
          <button class="btn-create-task" id="openCreateTaskBtn" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Create Task
          </button>
        </div>

        <!-- Toolbar  -->
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
            <select id="taskEmployeeFilter" class="filter-pill" style="padding: 7px 14px; outline: none; margin-left: auto; cursor: pointer; background-color: #fff; border: 1px solid #e2e8f0; border-radius: 999px;">
              <option value="All">All Employees</option>
            </select>
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
        <form id="createTaskForm" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
          <div class="w3-modal-body">
            <div class="w3-form-group">
              <label>Task Title</label>
              <input type="text" name="title" required placeholder="e.g. Redesign Employee Portal UI">
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Department</label>
                <select name="dept" id="createTaskDept" required>
                  <option value="">Select Department</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Assigned Employee</label>
                <select name="employee" id="createTaskEmployee" required>
                  <option value="">-- First Select a Department --</option>
                </select>
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
        <form id="editTaskForm" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
          <div class="w3-modal-body">
            <input type="hidden" name="id" id="editTaskId">
            <div class="w3-form-group">
              <label>Task Title</label>
              <input type="text" name="title" id="editTaskTitle" required placeholder="e.g. Redesign Employee Portal UI">
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Department</label>
                <select name="dept" id="editTaskDept" required>
                  <option value="">Select Department</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Assigned Employee</label>
                <select name="employee" id="editTaskEmployee" required>
                  <option value="">-- First Select a Department --</option>
                </select>
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

    <div class="w3-modal-overlay" id="viewTaskModal">
      <div class="w3-modal-card" style="max-width: 580px;">
        <div class="w3-modal-header">
          <h3>Task Details</h3>
          <button type="button" class="w3-modal-close" id="closeViewTaskModal">&times;</button>
        </div>
        <div class="w3-modal-body" style="gap: 16px;">
          <div>
            <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 4px;">Task Title</div>
            <h4 id="viewTaskTitle" style="margin: 0; font-size: 17px; font-weight: 800; color: #14204d; line-height: 1.35;"></h4>
          </div>

          <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <span id="viewTaskStatusPill" class="task-pill pill-pending">Pending</span>
            <span id="viewTaskPriorityPill" class="task-pill pill-medium">In Progress</span>
            <span id="viewTaskModePill" class="task-pill pill-online">Completed</span>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #f1f5f9;">
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Assigned Employee</span>
              <span id="viewTaskEmployee" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Department</span>
              <span id="viewTaskDept" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Deadline</span>
              <span id="viewTaskDeadline" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Task ID</span>
              <span id="viewTaskId" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
          </div>

          <div id="viewTaskDescSection">
            <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Description & Work Plan</div>
            <div id="viewTaskDesc" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; color: #334155; line-height: 1.5; white-space: pre-wrap;"></div>
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="closeViewTaskModalBtn">Close</button>
          <button type="button" class="w3-btn-save" id="editFromViewModalBtn" style="background-color: #2563eb;">Edit Task</button>
        </div>
      </div>
    </div>

</div>