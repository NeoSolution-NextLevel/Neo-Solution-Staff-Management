<style>
  /* =========================================================
     EMPLOYEE MY PROFILE (WORKPLACE IDENTITY & SCHEDULE ROSTER)
  ========================================================= */
  :root {
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #16a34a;
    --green-bg: #dcfce7;
    --purple: #7c3aed;
    --purple-bg: #f5f3ff;
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

  #Employee_user_dashboard_02_my_profile {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  .emp-prof-container {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* Topbar */
  .emp-prof-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .emp-prof-topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .emp-prof-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .emp-prof-topbar p {
    font-size: 13px;
    color: var(--muted);
    margin: 2px 0 0 0;
    font-weight: 500;
  }

  .emp-prof-menu-btn {
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
  .emp-prof-menu-btn svg { width: 20px; height: 20px; }

  /* 1. Hero Profile Header Card */
  .profile-hero-card {
    background: #ffffff;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 20px;
    width: 100%;
    position: relative;
  }

  .profile-banner {
    position: relative;
    height: 130px;
    background: linear-gradient(120deg, var(--navy) 0%, var(--navy-2) 55%, #3648a0 100%);
    overflow: hidden;
  }

  .profile-banner::before {
    content: "";
    position: absolute;
    top: -90px;
    right: -60px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.14), transparent 65%);
  }

  .profile-banner::after {
    content: "";
    position: absolute;
    bottom: -120px;
    right: 120px;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.08), transparent 65%);
  }

  .profile-hero-content {
    padding: 0 28px 22px;
    position: relative;
  }

  .profile-avatar-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 14px;
  }

  .profile-avatar-wrapper {
    position: relative;
    width: 92px;
    height: 92px;
    margin-top: -46px;
    z-index: 5;
    flex-shrink: 0;
  }

  .profile-avatar-img {
    width: 92px;
    height: 92px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ffffff;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.16);
    background: var(--blue);
    display: block;
  }

  .profile-avatar-placeholder {
    width: 92px;
    height: 92px;
    border-radius: 50%;
    border: 4px solid #ffffff;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.16);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff;
    font-size: 32px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    letter-spacing: 0.5px;
  }

  .avatar-upload-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    background: #ffffff;
    color: #1e293b;
    border: 1px solid #cbd5e1;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .avatar-upload-badge:hover {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    transform: scale(1.1);
  }
  .avatar-upload-badge svg { width: 14px; height: 14px; }

  .profile-actions-bar {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
  }

  .btn-edit-profile {
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
  .btn-edit-profile:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
  }

  .profile-name {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 4px 0;
    letter-spacing: -0.4px;
  }

  .profile-title {
    font-size: 14px;
    color: var(--muted);
    margin: 0 0 12px 0;
    font-weight: 600;
  }

  .profile-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
  }

  .profile-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
  }
  .profile-tag.code, .profile-tag.blue { background: #14204d; color: #ffffff; border: 1px solid #14204d; }
  .profile-tag.status, .profile-tag.green { background: #e3f9ee; color: #12b76a; border: 1px solid #c2f0d9; }
  .profile-tag.dept, .profile-tag.gray { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }

  /* 2. Grid Layout */
  .profile-grid-layout {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 20px;
    width: 100%;
  }

  .prof-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid var(--border);
    padding: 22px;
    box-shadow: 0 1px 3px rgba(20,25,60,.03);
    margin-bottom: 20px;
    transition: all 0.2s ease;
  }
  .prof-card:hover {
    box-shadow: 0 6px 20px rgba(20,25,60,.06);
    border-color: #cbd5e1;
  }

  .prof-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
  }

  .prof-card-head h3 {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .prof-card-head h3 svg {
    color: var(--blue);
  }

  .info-field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .info-field {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: background 0.15s ease;
  }
  .info-field:hover {
    background: #f1f5f9;
  }

  .info-field-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .info-field-val {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
    word-break: break-word;
  }

  /* Weekly Roster Pills & Grid */
  .roster-days-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
    margin-top: 12px;
  }

  .roster-day-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 4px;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    transition: all 0.2s ease;
  }
  
  .roster-day-name {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
  }

  .roster-day-badge {
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }
  .roster-day-badge.onsite { background: #0f172a; color: #ffffff; border: 1px solid #0f172a; }
  .roster-day-badge.wfh { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
  .roster-day-badge.leave { background: #ffffff; color: #64748b; border: 1px dashed #cbd5e1; }

  .roster-summary-row {
    display: flex;
    gap: 10px;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
    flex-wrap: wrap;
  }

  .roster-stat-pill {
    display: inline-flex;
    align-items: center;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #1e293b;
  }

  .quick-action-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    margin-bottom: 8px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
    transition: all 0.15s ease;
  }
  .quick-action-link:hover {
    background: var(--blue-lighter);
    color: var(--blue);
    border-color: #bfdbfe;
    transform: translateX(3px);
  }

  /* Modal Styles */
  .modal-overlay {
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
  .modal-overlay.open {
    display: flex;
  }

  .modal-box {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    border: 1px solid #cbd5e1;
    overflow: hidden;
    animation: modalPopIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  @keyframes modalPopIn {
    from { opacity: 0; transform: scale(0.96) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  .modal-header {
    padding: 18px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    flex-shrink: 0;
  }

  .modal-header h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
  }

  .modal-close-btn {
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
  .modal-close-btn:hover { background: #fee2e2; color: #dc2626; }

  .modal-body {
    padding: 20px 24px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    flex: 1;
    min-height: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-sizing: border-box;
  }

  .modal-form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .modal-form-group label {
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
  }

  .modal-form-control {
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
  .modal-form-control:focus {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
  }

  /* Day Roster Form Rows in Modal */
  .modal-roster-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 10px;
    margin-top: 6px;
  }

  .modal-day-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .modal-day-card-title {
    font-size: 12.5px;
    font-weight: 800;
    color: var(--navy);
  }

  .modal-day-select {
    width: 100%;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 8px;
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    outline: none;
  }

  @media (max-width: 868px) {
    .emp-prof-menu-btn { display: inline-flex !important; }
    .profile-grid-layout { grid-template-columns: 1fr !important; }
    .info-field-grid { grid-template-columns: 1fr !important; }
    .roster-days-grid { grid-template-columns: repeat(4, 1fr); }
    .modal-roster-grid { grid-template-columns: 1fr 1fr; }
    .profile-avatar-row { flex-direction: column; align-items: flex-start; }
    .profile-actions-bar { width: 100%; }
    .btn-edit-profile { width: 100%; justify-content: center; }
  }
</style>

<div id="Employee_user_dashboard_02_my_profile" class="w3-container tab-content" style="display: none; padding: 0;">
  <div class="emp-prof-container">

    <!-- Standard Dashboard Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_02" aria-label="Open menu" onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>My Profile</h2>
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
          <div class="avatar" id="topAvatar_02">--</div>
          <span id="topEmpName_02">Loading...</span>
        </div>
      </div>
    </div>

    <!-- Page Action Subbar -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
      <div>
        <p style="font-size: 13.5px; color: #64748b; margin: 0; font-weight: 500;">Workplace role identity, duty roster & working schedule</p>
      </div>

      <button type="button" class="btn-edit-profile" onclick="openEditProfileModal()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <span>Edit Profile</span>
      </button>
    </div>

    <!-- 1.Header Card -->
    <div class="profile-hero-card">
      <div class="profile-banner"></div>

      <div class="profile-hero-content">
        <div class="profile-avatar-row">
          <!-- Interactive Avatar with Photo Upload -->
          <div class="profile-avatar-wrapper">
            <img id="myProfilePicImg" class="profile-avatar-img" style="display:none;" alt="Profile Picture" />
            <div id="myProfilePicPlaceholder" class="profile-avatar-placeholder">--</div>
            
            <label for="avatarFileInput" class="avatar-upload-badge" title="Change Profile Picture">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            </label>
            <input type="file" id="avatarFileInput" accept="image/*" style="display: none;" onchange="uploadProfilePhoto(this)" />
          </div>

          <div class="profile-actions-bar">
            <span class="profile-tag blue" id="viewEmpIdTag">EMP-001</span>
            <span class="profile-tag green" id="viewStatusTag">Active Staff</span>
            <span class="profile-tag gray" id="viewDeptTag">Engineering</span>
          </div>
        </div>

        <h1 class="profile-name" id="viewProfileName">Loading Profile...</h1>
        <p class="profile-title" id="viewProfileTitle">—</p>
      </div>
    </div>

    <!-- 2. Bento Details Grid Layout -->
    <div class="profile-grid-layout">
      
      <!-- Left Column: Work Schedule & Duty Roster Planner -->
      <div>
        <!-- Work Schedule & Shift Timing Card -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span>Work Schedule & Shift Timing</span>
            </h3>
          </div>
          <div class="info-field-grid">
            <div class="info-field">
              <span class="info-field-label">Work Shift Hours</span>
              <span class="info-field-val" id="viewWorkShift">08:30 AM – 05:30 PM</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">General Work Mode</span>
              <span class="info-field-val" id="viewWorkMode" style="color: #16a34a;">On-Site (Active)</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Schedule Start Date</span>
              <span class="info-field-val" id="viewSchedStart">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Schedule End Date</span>
              <span class="info-field-val" id="viewSchedEnd">—</span>
            </div>
            <div class="info-field" style="grid-column: 1 / -1;">
              <span class="info-field-label">Assigned Work Location</span>
              <span class="info-field-val" id="viewWorkLocation">Colombo HQ</span>
            </div>
          </div>
        </div>

        <!-- Weekly Duty Roster (On-Site, WFH, Leave) Card -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <span>Weekly Duty Roster (On-Site, WFH, Leave)</span>
            </h3>
          </div>
          <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Day-by-day work arrangement according to active duty calendar:</div>
            
            <!-- 7-Day Visual Roster Grid -->
            <div class="roster-days-grid" id="viewRosterGrid">
              <div class="roster-day-box" id="dayBox_Mon">
                <span class="roster-day-name">Mon</span>
                <span class="roster-day-badge onsite" id="badge_Mon">On-Site</span>
              </div>
              <div class="roster-day-box" id="dayBox_Tue">
                <span class="roster-day-name">Tue</span>
                <span class="roster-day-badge onsite" id="badge_Tue">On-Site</span>
              </div>
              <div class="roster-day-box" id="dayBox_Wed">
                <span class="roster-day-name">Wed</span>
                <span class="roster-day-badge onsite" id="badge_Wed">On-Site</span>
              </div>
              <div class="roster-day-box" id="dayBox_Thu">
                <span class="roster-day-name">Thu</span>
                <span class="roster-day-badge onsite" id="badge_Thu">On-Site</span>
              </div>
              <div class="roster-day-box" id="dayBox_Fri">
                <span class="roster-day-name">Fri</span>
                <span class="roster-day-badge wfh" id="badge_Fri">WFH</span>
              </div>
              <div class="roster-day-box" id="dayBox_Sat">
                <span class="roster-day-name">Sat</span>
                <span class="roster-day-badge leave" id="badge_Sat">Leave</span>
              </div>
              <div class="roster-day-box" id="dayBox_Sun">
                <span class="roster-day-name">Sun</span>
                <span class="roster-day-badge leave" id="badge_Sun">Leave</span>
              </div>
            </div>

            <!-- Dynamic Roster Summary Counters (Calculated from 7 days above) -->
            <div class="roster-summary-row">
              <span class="roster-stat-pill onsite" id="statOnsite">On-Site: 0 Days</span>
              <span class="roster-stat-pill wfh" id="statWfh">WFH: 0 Days</span>
              <span class="roster-stat-pill leave" id="statLeave">Leave: 0 Days</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Workplace Coordinates & Navigation -->
      <div>
        <!-- Workplace Contact & Role Info -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <span>Workplace Contact & Role</span>
            </h3>
          </div>
          <div class="info-field-grid">
            <div class="info-field" style="grid-column: 1 / -1;">
              <span class="info-field-label">Official Work Email</span>
              <span class="info-field-val" id="viewEmail">—</span>
            </div>
            <div class="info-field" style="grid-column: 1 / -1;">
              <span class="info-field-label">Primary Mobile Phone</span>
              <span class="info-field-val" id="viewPhone">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Department</span>
              <span class="info-field-val" id="viewDept">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Designation / Role</span>
              <span class="info-field-val" id="viewJobRole">—</span>
            </div>
          </div>
        </div>

        <!-- Quick Navigation Hub -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
              <span>Staff Hub Quick Links</span>
            </h3>
          </div>
          <div>
            <div class="quick-action-link" onclick="Employee_user_dashboard_03_OPEN()">
              <span>Personal Details</span>
              <span>&rarr;</span>
            </div>
            <div class="quick-action-link" onclick="Employee_user_dashboard_06_OPEN()">
              <span>Job Information & Timeline</span>
              <span>&rarr;</span>
            </div>
            <div class="quick-action-link" onclick="Employee_user_dashboard_07_OPEN()">
              <span>Daily Work Plan</span>
              <span>&rarr;</span>
            </div>
            <div class="quick-action-link" onclick="Employee_user_dashboard_04_OPEN()">
              <span>My Documents</span>
              <span>&rarr;</span>
            </div>
            <div class="quick-action-link" onclick="Employee_user_dashboard_08_OPEN()">
              <span>Request Leave</span>
              <span>&rarr;</span>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- Edit Profile & Schedule Modal Dialog -->
<div class="modal-overlay" id="editProfileModal">
  <div class="modal-box" style="max-width: 640px; width: 100%; max-height: 90vh; display: flex; flex-direction: column;">
    <div class="modal-header">
      <div style="display:flex; align-items:center; gap:8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <h3 style="margin:0; font-size:18px; font-weight:800; color:var(--navy);">Edit Profile & Duty Schedule</h3>
      </div>
      <button type="button" class="modal-close-btn" onclick="closeEditProfileModal()">&times;</button>
    </div>

    <form id="editProfileForm" onsubmit="saveProfileEdits(event)" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
      <div class="modal-body" style="overflow-y: auto; max-height: calc(90vh - 130px); padding: 20px 24px; display: flex; flex-direction: column; gap: 16px;">
        
        <!-- Section 1: Professional Identity & Role -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">1. Professional Identity & Role</div>
        
        <div class="modal-form-group">
          <label for="editFullName">Display Name *</label>
          <input type="text" id="editFullName" name="full_name" class="modal-form-control" required placeholder="e.g. Kasun Kalhara Perera" />
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editDept">Department</label>
            <input type="text" id="editDept" name="dept" class="modal-form-control" placeholder="e.g. Engineering" />
          </div>
          <div class="modal-form-group">
            <label for="editJobRole">Job Role / Designation</label>
            <input type="text" id="editJobRole" name="role" class="modal-form-control" placeholder="e.g. Senior Software Engineer" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editEmail">Official Work Email</label>
            <input type="email" id="editEmail" name="email" class="modal-form-control" placeholder="e.g. kasun@company.com" />
          </div>
          <div class="modal-form-group">
            <label for="editPhone">Primary Contact Phone</label>
            <input type="text" id="editPhone" name="phone" class="modal-form-control" placeholder="e.g. 077 1234567" />
          </div>
        </div>

        <!-- Section 2: Work Schedule & Shift Timing -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px; margin-top: 6px;">2. Schedule Dates & Shift Timings</div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editSchedStart">Schedule Effective Start Date</label>
            <input type="date" id="editSchedStart" name="schedule_start_date" class="modal-form-control" />
          </div>
          <div class="modal-form-group">
            <label for="editSchedEnd">Schedule Effective End Date</label>
            <input type="date" id="editSchedEnd" name="schedule_end_date" class="modal-form-control" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editWorkShift">Work Shift Hours</label>
            <input type="text" id="editWorkShift" name="work_shift" class="modal-form-control" placeholder="e.g. 08:30 AM – 05:30 PM" />
          </div>
          <div class="modal-form-group">
            <label for="editWorkMode">Work Mode</label>
            <select id="editWorkMode" name="work_mode" class="modal-form-control">
              <option value="On-Site (Active)">On-Site (Active)</option>
              <option value="Hybrid">Hybrid</option>
              <option value="Remote">Remote</option>
            </select>
          </div>
        </div>

        <div class="modal-form-group">
          <label for="editLocation">Work Location</label>
          <input type="text" id="editLocation" name="work_location" class="modal-form-control" placeholder="e.g. Colombo HQ" />
        </div>

        <!-- Section 3: Daily Work Arrangement (On-Site / WFH / Leave) -->
        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px; margin-top: 6px;">3. Weekly Duty Arrangement (On-Site, WFH, Leave)</div>

        <input type="hidden" id="editWeeklyRosterHidden" name="weekly_roster" value="" />
        
        <div class="modal-roster-grid">
          <!-- Mon -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Monday</span>
            <select class="modal-day-select" id="rosterSel_Mon">
              <option value="onsite">On-Site</option>
              <option value="wfh">WFH</option>
              <option value="leave">Leave</option>
            </select>
          </div>
          <!-- Tue -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Tuesday</span>
            <select class="modal-day-select" id="rosterSel_Tue">
              <option value="onsite">On-Site</option>
              <option value="wfh">WFH</option>
              <option value="leave">Leave</option>
            </select>
          </div>
          <!-- Wed -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Wednesday</span>
            <select class="modal-day-select" id="rosterSel_Wed">
              <option value="onsite">On-Site</option>
              <option value="wfh">WFH</option>
              <option value="leave">Leave</option>
            </select>
          </div>
          <!-- Thu -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Thursday</span>
            <select class="modal-day-select" id="rosterSel_Thu">
              <option value="onsite">On-Site</option>
              <option value="wfh">WFH</option>
              <option value="leave">Leave</option>
            </select>
          </div>
          <!-- Fri -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Friday</span>
            <select class="modal-day-select" id="rosterSel_Fri">
              <option value="onsite">On-Site</option>
              <option value="wfh" selected>WFH</option>
              <option value="leave">Leave</option>
            </select>
          </div>
          <!-- Sat -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Saturday</span>
            <select class="modal-day-select" id="rosterSel_Sat">
              <option value="onsite">On-Site</option>
              <option value="wfh">WFH</option>
              <option value="leave" selected>Leave</option>
            </select>
          </div>
          <!-- Sun -->
          <div class="modal-day-card">
            <span class="modal-day-card-title">Sunday</span>
            <select class="modal-day-select" id="rosterSel_Sun">
              <option value="onsite">On-Site</option>
              <option value="wfh">WFH</option>
              <option value="leave" selected>Leave</option>
            </select>
          </div>
        </div>
      
      </div>

      <div class="modal-footer" style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px; background:#fafbfd; flex-shrink:0;">
        <button type="button" class="btn-edit-profile" style="background:#f1f5f9; color:#475569; box-shadow:none;" onclick="closeEditProfileModal()">Cancel</button>
        <button type="submit" class="btn-edit-profile" id="saveProfileBtn" style="background:var(--navy); color:#ffffff;">Save Changes</button>
      </div>
    </form>
  </div>
</div>
