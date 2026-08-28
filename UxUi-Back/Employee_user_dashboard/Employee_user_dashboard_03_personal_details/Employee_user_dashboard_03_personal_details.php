<style>
  /* =========================================================
     EMPLOYEE PERSONAL DETAILS & LEGAL DOSSIER
  ========================================================= */
  :root {
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #16a34a;
    --green-bg: #dcfce7;
    --amber: #d97706;
    --amber-bg: #fef3c7;
    --red: #dc2626;
    --red-bg: #fee2e2;
    --ink: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
    --card: #ffffff;
    --radius: 16px;
    --shadow: 0 1px 3px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
  }

  #Employee_user_dashboard_03_personal_details {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  .emp-pd-container {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* Topbar */
  .emp-pd-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .emp-pd-topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .emp-pd-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .emp-pd-topbar p {
    font-size: 13px;
    color: var(--muted);
    margin: 2px 0 0 0;
    font-weight: 500;
  }

  .emp-pd-menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--blue-lighter);
    border: none;
    cursor: pointer;
    color: var(--navy);
  }
  .emp-pd-menu-btn svg { width: 20px; height: 20px; }

  .btn-pd-edit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--blue);
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .btn-pd-edit:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
  }

  /* Bento Grid Cards */
  .pd-bento-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    width: 100%;
    margin-bottom: 24px;
  }

  .pd-bento-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(20,25,60,0.03);
    padding: 22px 24px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }
  .pd-bento-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(20,25,60,0.06);
    border-color: #cbd5e1;
  }

  .pd-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 14px;
  }

  .pd-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .pd-card-icon.blue { background: #eff6ff; color: #2563eb; }
  .pd-card-icon.emerald { background: #e3f9ee; color: #12b76a; }
  .pd-card-icon.purple { background: #eef2ff; color: #3b5bdb; }
  .pd-card-icon.amber { background: #f8fafc; color: #14204d; border: 1px solid #e2e8f0; }

  .pd-card-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
  }
  .pd-card-subtitle {
    font-size: 12px;
    color: var(--muted);
    margin: 2px 0 0;
    font-weight: 500;
  }

  .pd-item-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
  }

  .pd-probation-4col-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    width: 100%;
    align-items: stretch;
  }

  .pd-probation-4col-grid .pd-item-box {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 70px;
    height: 100%;
    box-sizing: border-box;
  }

  .pd-item-box {
    background: #f8fafc;
    border: 1px solid #eef2f6;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: background 0.15s ease;
  }
  .pd-item-box:hover { background: #f1f5f9; }
  .pd-item-box.full-width { grid-column: 1 / -1; }

  .pd-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .pd-val {
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
    word-break: break-word;
  }

  /* Modal Form Controls */
  .pd-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    padding: 20px;
    box-sizing: border-box;
  }
  .pd-modal-overlay.open { display: flex; }

  .pd-modal-box {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    border: 1px solid #cbd5e1;
    overflow: hidden;
    animation: modalPopIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .pd-modal-header {
    padding: 18px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    flex-shrink: 0;
  }

  .pd-modal-header h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
  }

  .pd-modal-close-btn {
    background: #f1f5f9;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #64748b;
    font-size: 18px;
    font-weight: bold;
    transition: all 0.15s;
  }
  .pd-modal-close-btn:hover { background: #fee2e2; color: #dc2626; }

  .pd-modal-body {
    padding: 20px 24px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    flex: 1;
    min-height: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
    box-sizing: border-box;
  }

  .pd-modal-form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .pd-modal-form-group label {
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
  }

  .pd-modal-form-control {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    outline: none;
    transition: all 0.2s;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
  }
  .pd-modal-form-control:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
  }

  @media (max-width: 900px) {
    .pd-probation-4col-grid { grid-template-columns: repeat(2, 1fr) !important; }
  }
  @media (max-width: 868px) {
    .emp-pd-menu-btn { display: inline-flex !important; }
    .pd-bento-grid { grid-template-columns: 1fr !important; }
    .pd-item-list { grid-template-columns: 1fr !important; }
    .btn-pd-edit { width: 100%; justify-content: center; }
  }
  @media (max-width: 500px) {
    .pd-probation-4col-grid { grid-template-columns: 1fr !important; }
  }
</style>

<div id="Employee_user_dashboard_03_personal_details" class="w3-container tab-content" style="display: none; padding: 0;">
  <div class="emp-pd-container">

    <!-- Standard Dashboard Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_03" aria-label="Open menu" onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Personal Details</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function'){ Employee_user_dashboard_09_OPEN(); }" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>

        <div class="admin-pill" onclick="if(typeof Employee_user_dashboard_02_OPEN==='function'){ Employee_user_dashboard_02_OPEN(); }">
          <div class="avatar" id="topAvatar_03">--</div>
          <span id="topEmpName_03">Loading...</span>
        </div>
      </div>
    </div>

    <!-- Page Action Subbar -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
      <div>
        <p style="font-size: 13.5px; color: #64748b; margin: 0; font-weight: 500;">Official employee identification, legal credentials & service record dossier</p>
      </div>

      <button type="button" class="btn-pd-edit" onclick="openEditPersonalDetailsModal()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <span>Edit Legal Details</span>
      </button>
    </div>

    <!-- Bento Grid Section -->
    <div class="pd-bento-grid">

      <!-- Card 1: Legal Identity & Identification -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon blue">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Primary Legal Identity</h3>
            <p class="pd-card-subtitle">Personal verification & state credentials</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box full-width">
            <span class="pd-label">Full Legal Name</span>
            <span class="pd-val" id="pdFullName">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">National Identity Card (NIC)</span>
            <span class="pd-val" id="pdNic">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Date of Birth</span>
            <span class="pd-val" id="pdDob">—</span>
          </div>
          <div class="pd-item-box full-width">
            <span class="pd-label">Gender</span>
            <span class="pd-val" id="pdGender">—</span>
          </div>
        </div>
      </div>

      <!-- Card 2: Contact Coordinates & Residence -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon emerald">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Contact Coordinates & Residence</h3>
            <p class="pd-card-subtitle">Official communication channels & location</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box full-width">
            <span class="pd-label">Official Work Email</span>
            <span class="pd-val" id="pdEmail">—</span>
          </div>
          <div class="pd-item-box full-width">
            <span class="pd-label">Primary Mobile Phone</span>
            <span class="pd-val" id="pdPhone">—</span>
          </div>
          <div class="pd-item-box full-width">
            <span class="pd-label">Residential Address</span>
            <span class="pd-val" id="pdAddress">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Emergency Contact Person</span>
            <span class="pd-val" id="pdEmName">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Emergency Phone</span>
            <span class="pd-val" id="pdEmPhone">—</span>
          </div>
        </div>
      </div>

      <!-- Card 3: Service & Placement Record -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon purple">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Service & Placement Record</h3>
            <p class="pd-card-subtitle">Official appointment & organizational role</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box">
            <span class="pd-label">Employee ID Code</span>
            <span class="pd-val" id="pdEmpCode">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Department</span>
            <span class="pd-val" id="pdDept">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Designation / Role</span>
            <span class="pd-val" id="pdJobTitle">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Work Location</span>
            <span class="pd-val" id="pdLocation">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Official Joining Date</span>
            <span class="pd-val" id="pdJoinDate">—</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Employment Type</span>
            <span class="pd-val" id="pdEmpType">—</span>
          </div>
        </div>
      </div>

      <!-- Card 4: Probation Process & Career Lifecycle (Bottom-Right Card in 2x2 Bento Grid) -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon blue">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Probation Process & Career Milestones</h3>
            <p class="pd-card-subtitle">Probation review timeline & confirmation</p>
          </div>
        </div>

        <!-- 2x2 Internal Grid for 4 Probation Items -->
        <div class="pd-item-list">
          <!-- 1. Probation Status -->
          <div class="pd-item-box">
            <span class="pd-label">Probation Status</span>
            <span class="pd-val" id="pdProbationStatus" style="color: #2563eb; font-weight: 700; margin-top:2px;">In Progress</span>
          </div>

          <!-- 2. Official Confirmed Start Date -->
          <div class="pd-item-box">
            <span class="pd-label">Confirmed Start Date</span>
            <span class="pd-val" id="pdOfficialStartDate" style="color: #16a34a; font-weight: 700;">—</span>
          </div>

          <!-- 3. Probation Start Date -->
          <div class="pd-item-box">
            <span class="pd-label">Probation Start Date</span>
            <span class="pd-val" id="pdProbationStartDate">—</span>
          </div>

          <!-- 4. Probation End Date -->
          <div class="pd-item-box">
            <span class="pd-label">Probation End Date</span>
            <span class="pd-val" id="pdProbationEndDate">—</span>
          </div>

          <!-- 5. 15-Day Attendance Progress Tracker -->
          <div class="pd-item-box full-width" style="margin-top: 2px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 4px;">
              <span class="pd-label" style="font-weight:700;">15-Day Probation Attendance Tracking</span>
              <span id="pdAttendanceDaysBadge" style="font-size:11.5px; font-weight:700; background:#eff6ff; color:#2563eb; padding:3px 10px; border-radius:6px;">0 / 15 Days Marked</span>
            </div>
            <div style="width:100%; height:8px; background:#e2e8f0; border-radius:999px; overflow:hidden; margin-top:6px;">
              <div id="pdAttendanceProgressBar" style="width:0%; height:100%; background:linear-gradient(90deg, #2563eb, #16a34a); border-radius:999px; transition: width 0.4s ease;"></div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- Edit Legal Details Modal Dialog -->
<div class="pd-modal-overlay" id="editPersonalDetailsModal">
  <div class="pd-modal-box" style="max-width: 640px; width: 100%; max-height: 90vh; display: flex; flex-direction: column;">
    <div class="pd-modal-header">
      <div style="display:flex; align-items:center; gap:8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <h3 style="margin:0; font-size:18px; font-weight:800; color:var(--navy);">Edit Legal & Personal Dossier</h3>
      </div>
      <button type="button" class="pd-modal-close-btn" onclick="closeEditPersonalDetailsModal()">&times;</button>
    </div>

    <form id="editPersonalDetailsForm" onsubmit="savePersonalDetailsEdits(event)" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
      <div class="pd-modal-body" style="overflow-y: auto; max-height: calc(90vh - 130px); padding: 20px 24px; display: flex; flex-direction: column; gap: 16px;">
        
        <!-- Section 1: Legal Identity -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">1. Primary Legal Identity</div>
        
        <div class="pd-modal-form-group">
          <label for="pdEditFullName">Full Legal Name *</label>
          <input type="text" id="pdEditFullName" name="full_name" class="pd-modal-form-control" required placeholder="e.g. Kasun Kalhara Perera" />
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditNic">NIC / Passport Number</label>
            <input type="text" id="pdEditNic" name="nic" class="pd-modal-form-control" placeholder="e.g. 199412345678" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditDob">Date of Birth</label>
            <input type="date" id="pdEditDob" name="dob" class="pd-modal-form-control" />
          </div>
        </div>

        <div class="pd-modal-form-group">
          <label for="pdEditGender">Gender</label>
          <select id="pdEditGender" name="gender" class="pd-modal-form-control">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <!-- Section 2: Contact & Residence -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px; margin-top: 6px;">2. Contact Coordinates & Residence</div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditEmail">Official Work Email</label>
            <input type="email" id="pdEditEmail" name="email" class="pd-modal-form-control" placeholder="e.g. kasun@company.com" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditPhone">Primary Contact Phone</label>
            <input type="text" id="pdEditPhone" name="phone" class="pd-modal-form-control" placeholder="e.g. 077 1234567" />
          </div>
        </div>

        <div class="pd-modal-form-group">
          <label for="pdEditAddress">Residential Address</label>
          <input type="text" id="pdEditAddress" name="address" class="pd-modal-form-control" placeholder="e.g. No. 45/2, Galle Road, Colombo 03" />
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditEmName">Emergency Contact Person</label>
            <input type="text" id="pdEditEmName" name="emergency_contact_name" class="pd-modal-form-control" placeholder="e.g. S. Perera (Father)" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditEmPhone">Emergency Contact Phone</label>
            <input type="text" id="pdEditEmPhone" name="emergency_contact_phone" class="pd-modal-form-control" placeholder="e.g. 077 7654321" />
          </div>
        </div>

        <!-- Section 3: Placement & Contract -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px; margin-top: 6px;">3. Service & Placement Record</div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditDept">Department</label>
            <input type="text" id="pdEditDept" name="dept" class="pd-modal-form-control" placeholder="e.g. Engineering" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditJobRole">Designation / Role</label>
            <input type="text" id="pdEditJobRole" name="role" class="pd-modal-form-control" placeholder="e.g. Senior Software Engineer" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditEmpCode">Employee ID Code</label>
            <input type="text" id="pdEditEmpCode" name="employee_id_code" class="pd-modal-form-control" placeholder="e.g. EMP-001" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditJoinDate">Official Joining Date</label>
            <input type="date" id="pdEditJoinDate" name="joined" class="pd-modal-form-control" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditLocation">Work Location</label>
            <input type="text" id="pdEditLocation" name="work_location" class="pd-modal-form-control" placeholder="e.g. Colombo HQ" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditEmpType">Employment Type</label>
            <input type="text" id="pdEditEmpType" name="employment_type" class="pd-modal-form-control" placeholder="e.g. Full-Time" />
          </div>
        </div>

        <!-- Section 4: Probation Lifecycle -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px; margin-top: 6px;">4. Probation Process & Lifecycle</div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditProbationStatus">Probation Status</label>
            <select id="pdEditProbationStatus" name="probation_status" class="pd-modal-form-control">
              <option value="In Progress">In Progress (Active Probation)</option>
              <option value="Completed">Completed (Confirmed Staff)</option>
              <option value="Extended">Extended</option>
              <option value="Under Review">Under Review</option>
            </select>
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditOfficialStartDate">Official Confirmed Start Date</label>
            <input type="date" id="pdEditOfficialStartDate" name="official_start_date" class="pd-modal-form-control" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="pd-modal-form-group">
            <label for="pdEditProbationStartDate">Probation Start Date</label>
            <input type="date" id="pdEditProbationStartDate" name="probation_start_date" class="pd-modal-form-control" />
          </div>
          <div class="pd-modal-form-group">
            <label for="pdEditProbationEndDate">Probation End Date</label>
            <input type="date" id="pdEditProbationEndDate" name="probation_end_date" class="pd-modal-form-control" />
          </div>
        </div>

        <div class="pd-modal-form-group">
          <label for="pdEditAttendanceDays">Attended / Marked Days (out of 15)</label>
          <input type="number" id="pdEditAttendanceDays" name="attendance_days" min="0" max="15" class="pd-modal-form-control" placeholder="0 - 15" />
        </div>
      
      </div>

      <div class="modal-footer" style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px; background:#fafbfd; flex-shrink:0;">
        <button type="button" class="btn-pd-edit" style="background:#f1f5f9; color:#475569; box-shadow:none;" onclick="closeEditPersonalDetailsModal()">Cancel</button>
        <button type="submit" class="btn-pd-edit" id="savePdBtn" style="background:var(--navy); color:#ffffff;">Save All Changes</button>
      </div>
    </form>
  </div>
</div>
