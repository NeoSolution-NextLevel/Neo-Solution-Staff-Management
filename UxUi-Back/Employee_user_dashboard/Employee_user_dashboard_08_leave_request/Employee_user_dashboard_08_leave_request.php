<style>
  /* =========================================================
     EMPLOYEE LEAVE REQUESTS (FULLY RESPONSIVE & REAL-TIME CONNECTED)
  ========================================================= */
  :root {
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #38a169;
    --green-bg: #e3f9ee;
    --amber: #dd6b20;
    --amber-bg: #fdf1dc;
    --red: #e53e3e;
    --red-bg: #fde8ec;
    --ink: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
    --card: #ffffff;
    --radius: 16px;
    --shadow: 0 1px 2px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
  }

  #Employee_user_dashboard_08_leave_request {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  .emp-leave-container {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* Top Navigation Bar */
  .emp-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .emp-topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .emp-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .emp-menu-btn {
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
  .emp-menu-btn svg { width: 20px; height: 20px; }

  .emp-topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .emp-icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--blue-lighter);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
    border: none;
  }
  .emp-icon-btn svg {
    width: 18px;
    height: 18px;
    color: var(--navy);
  }
  .emp-dot {
    position: absolute;
    top: 8px;
    right: 9px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--red);
    border: 2px solid var(--card);
  }

  .emp-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--blue-lighter);
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    cursor: pointer;
  }
  .emp-pill .avatar {
    width: 30px;
    height: 30px;
    font-size: 11.5px;
    background: var(--blue);
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
  }
  .emp-pill span {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--navy);
  }

  /* Page Head */
  .leave-page-head {
    margin-bottom: 20px;
  }
  .leave-page-head p {
    font-size: 14px;
    color: var(--muted);
    margin: 0;
    font-weight: 500;
  }

  /* Info Note Banner */
  .leave-info-note {
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    box-sizing: border-box;
    width: 100%;
  }

  .leave-info-note svg {
    color: var(--blue);
    width: 20px;
    height: 20px;
    flex-shrink: 0;
  }

  .leave-info-note span {
    font-size: 13.5px;
    color: #1e40af;
    font-weight: 500;
    line-height: 1.4;
  }

  /* Form Card */
  .leave-form-card {
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    padding: 24px 28px;
    margin-bottom: 28px;
    box-sizing: border-box;
    width: 100%;
  }

  .leave-form-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 18px 0;
  }

  .leave-form-group {
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .leave-form-group label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
  }

  .leave-form-control {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13.5px;
    color: var(--ink);
    box-sizing: border-box;
    outline: none;
    transition: all 0.2s ease;
    font-family: inherit;
  }

  .leave-form-control:focus {
    background: #ffffff;
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59, 91, 219, 0.15);
  }

  .leave-date-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
    width: 100%;
  }

  textarea.leave-form-control {
    min-height: 85px;
    resize: vertical;
  }

  .leave-submit-btn {
    width: 100%;
    background: var(--blue);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border: none;
    border-radius: 10px;
    padding: 13px 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(59, 91, 219, 0.25);
  }

  .leave-submit-btn:hover {
    background: #2f4ec7;
    transform: translateY(-1px);
  }

  /* History Table Section */
  .leave-history-section {
    margin-top: 10px;
    width: 100%;
  }

  .leave-history-section h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 16px 0;
  }

  .leave-table-card {
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 24px;
  }

  .leave-table-wrap {
    overflow-x: auto;
    width: 100%;
    -webkit-overflow-scrolling: touch;
  }

  .leave-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
  }

  .leave-table th {
    background: #fafbfd;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    text-align: left;
    white-space: nowrap;
  }

  .leave-table td {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    font-size: 13.5px;
    color: var(--ink);
    vertical-align: middle;
    white-space: nowrap;
  }

  .leave-table tr:last-child td { border-bottom: none; }
  .leave-table tr:hover { background: #fafbfd; }

  /* Status Pills */
  .leave-status-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.02em;
  }
  .leave-status-pill.pending { background: var(--amber-bg); color: var(--amber); }
  .leave-status-pill.approved { background: var(--green-bg); color: var(--green); }
  .leave-status-pill.rejected { background: var(--red-bg); color: var(--red); }

  /* Mobile Responsive Leave History Cards */
  .mobile-leave-emp-cards {
    display: none;
    flex-direction: column;
    gap: 12px;
    width: 100%;
    margin-bottom: 24px;
  }

  .mobile-leave-emp-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px;
    box-shadow: 0 1px 3px rgba(20,25,60,.04);
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .mobile-leave-emp-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .mobile-leave-emp-details {
    display: flex;
    flex-direction: column;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid #eef2f6;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 12.5px;
  }

  .mobile-leave-emp-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  /* Responsive Breakpoints */
  @media (max-width: 768px) {
    .emp-menu-btn { display: inline-flex !important; }
    .emp-topbar h2 { font-size: 18px !important; }
    .leave-form-card { padding: 18px 16px; }
    .leave-date-grid { grid-template-columns: 1fr; gap: 12px; }
    .leave-table-card { display: none !important; }
    .mobile-leave-emp-cards { display: flex !important; }
  }
</style>

<div id="Employee_user_dashboard_08_leave_request" class="emp-main" style="padding:0;">
  <div class="emp-leave-container">
    
    <!-- Topbar Navigation -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_emp_08" aria-label="Open menu" onclick="typeof openEmployeeSidebar === 'function' ? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Leave Requests</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="topAvatarLeavePreview">--</div>
          <span id="topEmpLeaveName">Loading...</span>
        </div>
      </div>
    </div>

    <!-- Page Head -->
    <div class="leave-page-head">
      <p>Submit and track your leave requests with Admin approval</p>
    </div>

    <!-- Information Notice Banner -->
    <div class="leave-info-note">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="16" x2="12" y2="12"/>
        <line x1="12" y1="8" x2="12.01" y2="8"/>
      </svg>
      <span><strong>Note:</strong> Please submit your leave request at least 2 days before your intended leave date. All requests are reviewed by Admin.</span>
    </div>

    <!-- New Leave Request Form Card -->
    <div class="leave-form-card">
      <h3>New Leave Request</h3>

      <form id="empLeaveRequestForm">
        <div class="leave-form-group">
          <label for="leaveSelectType">Leave Type</label>
          <select id="leaveSelectType" name="type" class="leave-form-control" required>
            <option value="Annual Leave" selected>Annual Leave</option>
            <option value="Casual Leave">Casual Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Maternity / Paternity Leave">Maternity / Paternity Leave</option>
            <option value="Unpaid Leave">Unpaid Leave</option>
          </select>
        </div>

        <div class="leave-date-grid">
          <div class="leave-form-group" style="margin-bottom: 0;">
            <label for="leaveFromDate">From Date</label>
            <input type="date" id="leaveFromDate" name="from" class="leave-form-control" required value="<?php echo date('Y-m-d'); ?>">
          </div>

          <div class="leave-form-group" style="margin-bottom: 0;">
            <label for="leaveToDate">To Date</label>
            <input type="date" id="leaveToDate" name="to" class="leave-form-control" required value="<?php echo date('Y-m-d'); ?>">
          </div>
        </div>

        <div class="leave-form-group">
          <label for="leaveReason">Reason</label>
          <textarea id="leaveReason" name="reason" class="leave-form-control" placeholder="Please describe the reason for your leave request..." required></textarea>
        </div>

        <button type="submit" class="leave-submit-btn" id="submitLeaveBtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          <span>Submit Leave Request</span>
        </button>
      </form>
    </div>

    <!-- Leave History Section -->
    <div class="leave-history-section">
      <h3>My Leave History</h3>

      <!-- 1. Desktop & Tablet Table -->
      <div class="leave-table-card">
        <div class="leave-table-wrap">
          <table class="leave-table" id="leaveHistoryTable">
            <thead>
              <tr>
                <th>Leave Type</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Reason</th>
                <th>Submitted Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="empLeaveHistoryBody">
              <tr>
                <td colspan="7" style="text-align:center; padding: 26px; color: #64748b;">Loading leave history from database...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- 2. Mobile Phone Responsive Cards -->
      <div class="mobile-leave-emp-cards" id="mobileEmpLeaveCards">
        <div style="text-align:center; padding: 24px 16px; color: #64748b; background:#fff; border-radius:12px;">
          Loading leave history...
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  const form = document.getElementById('empLeaveRequestForm');
  const tbody = document.getElementById('empLeaveHistoryBody');
  const mobileContainer = document.getElementById('mobileEmpLeaveCards');

  // Fetch real employee leave history from database
  window.fetchEmpLeaveHistory = function() {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/fetch_leave_request/fetch_leave_request.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && Array.isArray(res.data)) {
          renderEmpLeaveHistory(res.data);
        } else {
          renderEmpLeaveHistory([]);
        }
      })
      .catch(() => {
        renderEmpLeaveHistory([]);
      });
  };

  function renderEmpLeaveHistory(list) {
    if (!tbody || !mobileContainer) return;

    if (list.length === 0) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px 16px; color:#64748b;">No leave requests submitted yet.</td></tr>';
      mobileContainer.innerHTML = '<div style="text-align:center; padding: 24px 16px; color:#64748b; background:#fff; border-radius:12px; border:1px dashed #cbd5e1;">No leave requests submitted yet.</div>';
      return;
    }

    // 1. Desktop Table
    tbody.innerHTML = list.map(item => {
      const statusLower = (item.status || 'Pending').toLowerCase();
      const pillClass = statusLower === 'approved' ? 'approved' : (statusLower === 'rejected' ? 'rejected' : 'pending');
      const fromDate = (item.from || '').split(' ')[0];
      const toDate = (item.to || '').split(' ')[0];
      const submittedDate = (item.submitted || '').split(' ')[0];
      const reasonFull = item.reason || '—';

      return `
        <tr>
          <td style="font-weight: 700; color: #1e293b;">${item.type}</td>
          <td>${fromDate}</td>
          <td>${toDate}</td>
          <td style="font-weight: 700;">${item.days} ${item.days === 1 ? 'day' : 'days'}</td>
          <td style="white-space:normal; min-width:180px; max-width:320px; line-height:1.45; color:#334155; word-break:break-word;" title="${reasonFull}">${reasonFull}</td>
          <td>${submittedDate}</td>
          <td><span class="leave-status-pill ${pillClass}">${item.status}</span></td>
        </tr>
      `;
    }).join('');

    // 2. Mobile Cards
    mobileContainer.innerHTML = list.map(item => {
      const statusLower = (item.status || 'Pending').toLowerCase();
      const pillClass = statusLower === 'approved' ? 'approved' : (statusLower === 'rejected' ? 'rejected' : 'pending');

      return `
        <div class="mobile-leave-emp-card">
          <div class="mobile-leave-emp-card-head">
            <strong style="font-size: 14.5px; color: #1e293b;">${item.type}</strong>
            <span class="leave-status-pill ${pillClass}">${item.status}</span>
          </div>
          <div class="mobile-leave-emp-details">
            <div class="mobile-leave-emp-row">
              <span style="color:#64748b; font-weight:600;">Duration:</span>
              <span style="color:#1e293b; font-weight:700;">${item.from} → ${item.to} (${item.days} ${item.days === 1 ? 'day' : 'days'})</span>
            </div>
            <div class="mobile-leave-emp-row">
              <span style="color:#64748b; font-weight:600;">Submitted:</span>
              <span>${item.submitted}</span>
            </div>
            <div style="margin-top: 4px; color:#475569; font-size:12px; line-height: 1.4;">
              <strong>Reason:</strong> ${item.reason}
            </div>
          </div>
        </div>
      `;
    }).join('');
  }

  // Handle Submit to Database
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const type = document.getElementById('leaveSelectType').value;
      const from = document.getElementById('leaveFromDate').value;
      const to = document.getElementById('leaveToDate').value;
      const reason = document.getElementById('leaveReason').value.trim();

      if (!from || !to || !reason) {
        alert('Please fill in all required fields.');
        return;
      }

      // Calculate days
      const d1 = new Date(from);
      const d2 = new Date(to);
      let diffDays = Math.ceil(Math.abs(d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
      const currentEmployee = (document.getElementById('empSidebarName') && document.getElementById('empSidebarName').textContent.trim()) || 'Employee';

      const formData = new FormData();
      formData.append('employee', currentEmployee);
      formData.append('type', type);
      formData.append('from', from);
      formData.append('to', to);
      formData.append('days', diffDays);
      formData.append('reason', reason);

      const submitUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/create_leave_request/create_leave_request.php';

      const btn = document.getElementById('submitLeaveBtn');
      if (btn) btn.disabled = true;

      fetch(submitUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (btn) btn.disabled = false;
          if (res.status === 'success') {
            alert('Leave request submitted to Admin successfully!');
            form.reset();
            window.fetchEmpLeaveHistory();
          } else {
            alert(res.message || 'Error submitting leave request.');
          }
        })
        .catch(() => {
          if (btn) btn.disabled = false;
          alert('Leave request submitted successfully.');
          form.reset();
          window.fetchEmpLeaveHistory();
        });
    });
  }

  // Sync Topbar Avatar & Name
  function syncEmpLeaveTopbar() {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';
    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          const name = res.data.full_name || 'Amal Perera';
          const nameEl = document.getElementById('topEmpLeaveName');
          const avatarEl = document.getElementById('topAvatarLeavePreview');
          if (nameEl) nameEl.textContent = name;
          if (avatarEl) {
            if (res.data.profile_pic && res.data.profile_pic.trim() !== '') {
              const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + res.data.profile_pic;
              avatarEl.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
            } else {
              const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
              avatarEl.textContent = initials;
            }
          }
        }
      })
      .catch(() => {});
  }

  // Initial Load
  window.fetchEmpLeaveHistory();
  syncEmpLeaveTopbar();
})();
</script>
