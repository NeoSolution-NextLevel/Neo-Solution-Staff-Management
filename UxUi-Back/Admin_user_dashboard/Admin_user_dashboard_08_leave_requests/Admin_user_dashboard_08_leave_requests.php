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
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .header-title p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
  }

  .filter-tabs {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    padding: 4px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
  }

  .filter-btn {
    border: none;
    background: transparent;
    padding: 6px 14px;
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
  .col-emp { width: 22%; }
  .col-type { width: 16%; }
  .col-period { width: 22%; }
  .col-reason { width: 16%; }
  .col-status { width: 11%; }
  .col-actions { width: 13%; text-align: right; }

  /* Simple Status Tags */
  .status-tag {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
  }
  .status-tag.pending { background: #fef3c7; color: #b45309; }
  .status-tag.approved { background: #dcfce7; color: #15803d; }
  .status-tag.rejected { background: #fee2e2; color: #b91c1c; }

  /* Action Buttons */
  .btn-approve {
    background: #15803d;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    margin-right: 4px;
  }
  .btn-approve:hover { background: #166534; }

  .btn-reject {
    background: #dc2626;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
  }
  .btn-reject:hover { background: #991b1b; }

  .btn-view {
    background: #e2e8f0;
    color: #334155;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
  }
  .btn-view:hover { background: #cbd5e1; }

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

  /* Mobile */
  @media (max-width: 768px) {
    .main-wrapper {
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 12px 12px 60px !important;
    }
    .menu-btn { display: inline-flex !important; }
    .topbar h2 { font-size: 18px !important; }
    .table-card { overflow-x: auto !important; }
    table.leave-table { min-width: 650px !important; }
  }
</style>

<div id="Admin_user_dashboard_08_leave_requests">
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
              <th class="col-actions" style="text-align:right;">Actions</th>
            </tr>
          </thead>
          <tbody id="leaveTableBody">
            <tr>
              <td colspan="6" style="text-align:center; padding: 36px 20px; color: #64748b;">Loading leave requests...</td>
            </tr>
          </tbody>
        </table>
      </div>

    </main>

    <!-- Simple W3 Modal for Leave Details -->
    <div id="leaveDetailsModal" class="w3-modal" style="padding-top: 50px;">
      <div class="w3-modal-content w3-card-4 w3-round" style="max-width: 500px; overflow: hidden; background: #ffffff;">
        <header class="w3-container w3-padding" style="background: #14204d; color: #ffffff; display:flex; align-items:center; justify-content:space-between;">
          <h4 style="margin:0; font-size:16px; font-weight:700;">Leave Request Details</h4>
          <span onclick="closeLeaveModal()" class="w3-button w3-display-topright w3-hover-red" style="font-size:20px; cursor:pointer;">&times;</span>
        </header>
        
        <div class="w3-container w3-padding-16">
          <table class="w3-table w3-bordered" style="margin-bottom: 16px;">
            <tr>
              <td style="font-weight:700; width:35%;">Employee:</td>
              <td id="modalEmpName">—</td>
            </tr>
            <tr>
              <td style="font-weight:700;">Leave Type:</td>
              <td id="modalLeaveType">—</td>
            </tr>
            <tr>
              <td style="font-weight:700;">Leave Period:</td>
              <td id="modalLeaveDuration">—</td>
            </tr>
            <tr>
              <td style="font-weight:700;">Duration:</td>
              <td id="modalLeaveDays">—</td>
            </tr>
            <tr>
              <td style="font-weight:700;">Submitted Date:</td>
              <td id="modalLeaveSubmitted">—</td>
            </tr>
            <tr>
              <td style="font-weight:700;">Status:</td>
              <td id="modalLeaveStatus">—</td>
            </tr>
          </table>

          <div style="margin-top: 12px;">
            <div style="font-weight:700; color:#14204d; margin-bottom:6px;">Reason:</div>
            <div id="modalLeaveReason" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 6px; font-size: 13.5px; color: #334155; min-height: 60px; line-height: 1.4; word-break: break-word;">
              —
            </div>
          </div>
        </div>

        <footer class="w3-container w3-padding" style="background:#f1f5f9; display:flex; align-items:center; justify-content:space-between;">
          <div id="modalActionButtons"></div>
          <button type="button" class="w3-button w3-white w3-border w3-round" style="font-weight:600; font-size:13px; margin-left:auto;" onclick="closeLeaveModal()">Close</button>
        </footer>
      </div>
    </div>

  </div>
</div>
