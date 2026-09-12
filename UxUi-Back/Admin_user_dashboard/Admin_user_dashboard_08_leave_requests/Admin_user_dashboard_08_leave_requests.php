<style>
  /* Admin Leave Requests - Simple, Clean W3.CSS Based Styles */
  #Admin_user_dashboard_08_leave_requests {
    width: 100%;
    min-height: 100vh;
  }

  .main-wrapper {
    margin-left: 250px;
    width: calc(100% - 250px);
    max-width: calc(100% - 250px);
    min-height: 100vh;
    padding: 16px 24px 36px;
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
  .topbar-left {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: #14204d;
    margin: 0;
  }

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
  }
  .menu-btn svg { width: 20px; height: 20px; }

  /* Header & Filter Buttons */
  .header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 12px;
    width: 100%;
  }

  .header-title {
    text-align: left;
  }

  .header-title p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 600;
    text-align: left;
  }

  .filter-tabs {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #ffffff;
    padding: 4px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
  }

  .filter-btn {
    border: none;
    background: transparent;
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .filter-btn:hover { color: #1e293b; background: #f1f5f9; }
  .filter-btn.active {
    background: #14204d;
    color: #ffffff;
    font-weight: 700;
  }

  /* Table Card */
  .table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    width: 100%;
    margin-bottom: 24px;
  }

  table.leave-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
  }

  table.leave-table th {
    background: #f8fafc;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
  }

  table.leave-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13.5px;
    vertical-align: middle;
    color: #334155;
  }

  table.leave-table tr:hover {
    background: #fafbfd;
  }

  /* Column Widths */
  .col-emp { width: 18%; }
  .col-type { width: 14%; }
  .col-period { width: 21%; }
  .col-reason { width: 17%; }
  .col-status { width: 11%; }
  .col-actions { width: 19%; min-width: 175px; text-align: center; }

  table.leave-table th:last-child,
  table.leave-table td:last-child {
    text-align: center !important;
    padding-left: 14px !important;
    padding-right: 14px !important;
  }

  /* Simple Status Tags */
  .status-tag {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: capitalize;
  }
  .status-tag.pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
  .status-tag.approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
  .status-tag.rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

  /* Modern Action Buttons */
  .btn-actions-group {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    gap: 6px;
    white-space: nowrap;
  }

  .btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.15s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    line-height: 1.25;
    text-decoration: none;
  }

  .btn-action.approve {
    background: #16a34a;
    color: #ffffff;
  }
  .btn-action.approve:hover {
    background: #15803d;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(22, 163, 74, 0.3);
  }

  .btn-action.reject {
    background: #dc2626;
    color: #ffffff;
  }
  .btn-action.reject:hover {
    background: #b91c1c;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(220, 38, 38, 0.3);
  }

  .btn-action.view {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #cbd5e1;
    padding: 5px 14px;
  }
  .btn-action.view:hover {
    background: #e2e8f0;
    color: #0f172a;
    border-color: #94a3b8;
    transform: translateY(-1px);
  }

  /* Leave Modal Styles */
  .leave-modal-card {
    max-width: 520px;
    width: 90%;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    border: 1px solid #e2e8f0;
  }

  .leave-modal-header {
    background: linear-gradient(135deg, #14204d 0%, #1c2b63 100%);
    color: #ffffff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .leave-modal-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.2px;
  }

  .leave-modal-close {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: #ffffff;
    font-size: 20px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, transform 0.15s;
    line-height: 1;
  }

  .leave-modal-close:hover {
    background: #ef4444;
    transform: scale(1.05);
  }

  /* Clickable Text */
  .clickable-link {
    color: #14204d;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
  }
  .clickable-link:hover {
    color: #3b5bdb;
    text-decoration: underline;
  }

  .reason-cell {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    color: #475569;
  }
  .reason-cell:hover {
    color: #3b5bdb;
  }

  .mobile-leave-cards {
    display: none;
  }

  /* Mobile */
  @media (max-width: 768px) {
    .main-wrapper {
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 0 0 70px 0 !important;
    }
    .header-row {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
      margin-bottom: 14px !important;
    }
    .header-title {
      width: 100% !important;
      text-align: left !important;
    }
    .filter-tabs {
      width: 100% !important;
      display: flex !important;
      justify-content: space-between !important;
      box-sizing: border-box !important;
    }
    .filter-btn {
      flex: 1 !important;
      text-align: center !important;
      padding: 8px 4px !important;
      font-size: 12px !important;
    }
    .menu-btn { display: inline-flex !important; }
    .topbar h2 { font-size: 18px !important; }
    .table-card {
      display: none !important;
    }
    .mobile-leave-cards {
      display: flex !important;
      flex-direction: column;
      gap: 12px;
      width: 100%;
    }
    .mobile-leave-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
      padding: 14px;
      box-sizing: border-box;
      overflow: hidden;
    }
    .mobile-leave-card-header,
    .mobile-leave-card-row,
    .mobile-leave-card-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }
    .mobile-leave-card-header {
      align-items: flex-start;
      padding-bottom: 12px;
      border-bottom: 1px solid #f1f5f9;
    }
    .mobile-leave-card-name {
      color: #14204d;
      font-size: 14px;
      font-weight: 800;
      overflow-wrap: anywhere;
    }
    .mobile-leave-card-type,
    .mobile-leave-card-label {
      color: #64748b;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.03em;
    }
    .mobile-leave-card-body {
      display: grid;
      gap: 9px;
      padding: 12px 0;
    }
    .mobile-leave-card-value {
      color: #334155;
      font-size: 13px;
      text-align: right;
      overflow-wrap: anywhere;
    }
    .mobile-leave-card-reason {
      color: #475569;
      font-size: 13px;
      line-height: 1.45;
      margin-top: 2px;
      overflow-wrap: anywhere;
    }
    .mobile-leave-card-actions {
      justify-content: flex-end;
      padding-top: 12px;
      border-top: 1px solid #f1f5f9;
    }
    .mobile-leave-card-actions .btn-actions-group {
      flex-wrap: wrap;
      justify-content: flex-end;
    }
    .leave-modal-card {
      width: calc(100% - 24px) !important;
      margin: 20px auto !important;
    }
  }

  @media (max-width: 600px) {
    #Admin_user_dashboard_08_leave_requests {
      overflow-x: hidden !important;
    }

    #Admin_user_dashboard_08_leave_requests .main-wrapper {
      padding: 8px 10px 64px !important;
    }

    #Admin_user_dashboard_08_leave_requests .topbar {
      gap: 8px !important;
      margin-bottom: 12px !important;
    }

    #Admin_user_dashboard_08_leave_requests .topbar-left {
      min-width: 0 !important;
      gap: 6px !important;
    }

    #Admin_user_dashboard_08_leave_requests .topbar h2 {
      min-width: 0 !important;
      font-size: 16px !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
    }

    #Admin_user_dashboard_08_leave_requests .topbar-right {
      gap: 7px !important;
      flex-shrink: 0 !important;
    }

    #Admin_user_dashboard_08_leave_requests .profile-pill {
      padding: 4px !important;
    }

    #Admin_user_dashboard_08_leave_requests .profile-pill > span {
      display: none !important;
    }

    #Admin_user_dashboard_08_leave_requests .avatar-sm {
      width: 28px !important;
      height: 28px !important;
    }

    #Admin_user_dashboard_08_leave_requests .header-row {
      gap: 8px !important;
      margin-bottom: 12px !important;
    }

    #Admin_user_dashboard_08_leave_requests .header-title p {
      font-size: 12.5px !important;
      line-height: 1.35 !important;
    }

    #Admin_user_dashboard_08_leave_requests .filter-tabs {
      padding: 3px !important;
      gap: 3px !important;
    }

    #Admin_user_dashboard_08_leave_requests .filter-btn {
      min-width: 0 !important;
      padding: 8px 3px !important;
      font-size: 11px !important;
      white-space: normal !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card {
      padding: 12px !important;
      border-radius: 11px !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-header,
    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-row {
      align-items: flex-start !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-row {
      flex-wrap: wrap !important;
      gap: 4px 10px !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-label {
      flex: 0 0 auto !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-value {
      min-width: 0 !important;
      flex: 1 1 120px !important;
      text-align: right !important;
      overflow-wrap: anywhere !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-actions {
      align-items: stretch !important;
      flex-direction: column !important;
      gap: 8px !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-actions .btn-actions-group {
      width: 100% !important;
      justify-content: stretch !important;
      gap: 6px !important;
    }

    #Admin_user_dashboard_08_leave_requests .mobile-leave-card-actions .btn-action {
      flex: 1 1 0 !important;
      min-width: 0 !important;
      padding: 7px 6px !important;
      white-space: normal !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card {
      width: calc(100% - 16px) !important;
      max-width: none !important;
      max-height: calc(100dvh - 24px) !important;
      margin: 12px auto !important;
      overflow-y: auto !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-header {
      padding: 13px 15px !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-header h4 {
      font-size: 14px !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card > div:nth-child(2) {
      padding: 14px 15px !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card table {
      table-layout: fixed !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card table td {
      padding: 8px 0 !important;
      font-size: 12.5px !important;
      overflow-wrap: anywhere !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card table td:first-child {
      width: 38% !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card > div:last-child {
      padding: 10px 15px !important;
      flex-wrap: wrap !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card > div:last-child .btn-actions-group {
      flex: 1 1 100% !important;
      justify-content: stretch !important;
      flex-wrap: wrap !important;
    }

    #Admin_user_dashboard_08_leave_requests .leave-modal-card > div:last-child .btn-action {
      flex: 1 1 110px !important;
    }
  }
</style>

<div id="Admin_user_dashboard_08_leave_requests" style="display:none;">
  <div class="main-wrapper">
    
    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_08" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Leave Requests</h2>
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
          <p id="leaveCount">Loading leave requests...</p>
        </div>
        <div class="filter-tabs" id="leaveFilterTabs">
          <button class="filter-btn active" data-filter="All">All</button>
          <button class="filter-btn" data-filter="Pending">Pending</button>
          <button class="filter-btn" data-filter="Approved">Approved</button>
          <button class="filter-btn" data-filter="Rejected">Rejected</button>
        </div>
      </div>

      <!-- Table View -->
      <div class="table-card">
        <table class="leave-table">
          <thead>
            <tr>
              <th class="col-emp">Employee</th>
              <th class="col-type">Leave Type</th>
              <th class="col-period">Period & Days</th>
              <th class="col-reason">Reason</th>
              <th class="col-status">Status</th>
              <th class="col-actions" style="text-align:center;">Actions</th>
            </tr>
          </thead>
          <tbody id="leaveTableBody">
            <tr>
              <td colspan="6" style="text-align:center; padding: 36px 20px; color: #64748b;">Loading leave requests...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Mobile Card View -->
      <div class="mobile-leave-cards" id="mobileLeaveCards">
        <div class="mobile-leave-card" style="text-align:center; color:#64748b;">Loading leave requests...</div>
      </div>

    </main>

    <!-- Modern Modal for Leave Details -->
    <div id="leaveDetailsModal" class="w3-modal" style="padding-top: 50px; background-color: rgba(15, 23, 42, 0.5); backdrop-filter: blur(2px);">
      <div class="leave-modal-card">
        <div class="leave-modal-header">
          <h4>Leave Request Details</h4>
          <button type="button" class="leave-modal-close" onclick="closeLeaveModal()" aria-label="Close">&times;</button>
        </div>
        
        <div style="padding: 20px 24px; background: #ffffff;">
          <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
            <tr style="border-bottom: 1px solid #f1f5f9;">
              <td style="font-weight:700; color:#475569; width:35%; padding: 10px 0;">Employee:</td>
              <td id="modalEmpName" style="font-weight:700; color:#1e293b; padding: 10px 0;">—</td>
            </tr>
            <tr style="border-bottom: 1px solid #f1f5f9;">
              <td style="font-weight:700; color:#475569; padding: 10px 0;">Leave Type:</td>
              <td id="modalLeaveType" style="color:#1e293b; padding: 10px 0;">—</td>
            </tr>
            <tr style="border-bottom: 1px solid #f1f5f9;">
              <td style="font-weight:700; color:#475569; padding: 10px 0;">Leave Period:</td>
              <td id="modalLeaveDuration" style="color:#1e293b; padding: 10px 0;">—</td>
            </tr>
            <tr style="border-bottom: 1px solid #f1f5f9;">
              <td style="font-weight:700; color:#475569; padding: 10px 0;">Duration:</td>
              <td id="modalLeaveDays" style="font-weight:700; color:#2563eb; padding: 10px 0;">—</td>
            </tr>
            <tr style="border-bottom: 1px solid #f1f5f9;">
              <td style="font-weight:700; color:#475569; padding: 10px 0;">Submitted Date:</td>
              <td id="modalLeaveSubmitted" style="color:#64748b; padding: 10px 0;">—</td>
            </tr>
            <tr>
              <td style="font-weight:700; color:#475569; padding: 10px 0;">Status:</td>
              <td id="modalLeaveStatus" style="padding: 10px 0;">—</td>
            </tr>
          </table>

          <div style="margin-top: 14px;">
            <div style="font-weight:700; color:#14204d; font-size:13.5px; margin-bottom:6px;">Reason for Leave:</div>
            <div id="modalLeaveReason" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 14px; border-radius: 8px; font-size: 13.5px; color: #334155; min-height: 64px; line-height: 1.5; word-break: break-word;">
              —
            </div>
          </div>
        </div>

        <div style="background:#f8fafc; padding: 14px 24px; border-top: 1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; gap: 10px;">
          <div id="modalActionButtons" class="btn-actions-group"></div>
          <button type="button" class="btn-action view" style="margin-left:auto; padding: 7px 18px;" onclick="closeLeaveModal()">Close</button>
        </div>
      </div>
    </div>

  </div>
</div>
