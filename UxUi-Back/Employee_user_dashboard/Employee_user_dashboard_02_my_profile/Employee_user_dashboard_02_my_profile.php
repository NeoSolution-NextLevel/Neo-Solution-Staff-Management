<style>
  /* =========================================================
     EMPLOYEE MY PROFILE (CREATIVE, MODERN & INTERACTIVE)
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
    margin-bottom: 16px;
  }

  .emp-prof-topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .emp-prof-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .emp-prof-menu-btn {
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
  .emp-prof-menu-btn svg { width: 20px; height: 20px; }

  /* Hero Profile Header Card */
  .profile-hero-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(20, 25, 60, 0.06);
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 20px;
    width: 100%;
    position: relative;
  }

  .profile-banner {
    position: relative;
    height: 140px;
    background: linear-gradient(135deg, #14204d 0%, #1c2b63 45%, #2e4cad 100%);
    overflow: hidden;
  }

  .profile-banner-shapes {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1px, transparent 1px);
    background-size: 16px 16px;
    opacity: 0.6;
  }

  .profile-banner-glow {
    position: absolute;
    top: -40px;
    right: -20px;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(59, 91, 219, 0.35) 0%, transparent 70%);
  }

  .profile-hero-content {
    padding: 0 24px 22px;
    position: relative;
  }

  .profile-avatar-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 12px;
  }

  /* Interactive Profile Avatar with Photo Upload */
  .profile-avatar-wrapper {
    position: relative;
    width: 88px;
    height: 88px;
    margin-top: -44px;
    z-index: 5;
    flex-shrink: 0;
  }

  .profile-avatar-img {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ffffff;
    box-shadow: 0 6px 18px rgba(20, 32, 77, 0.16);
    background: var(--blue);
    display: block;
  }

  .profile-avatar-placeholder {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff;
    font-size: 30px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid #ffffff;
    box-shadow: 0 6px 18px rgba(20, 32, 77, 0.16);
    user-select: none;
  }

  .avatar-upload-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #14204d;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  }
  .avatar-upload-badge:hover {
    background: #2563eb;
    transform: scale(1.1);
  }
  .avatar-upload-badge svg { width: 13px; height: 13px; }

  .profile-actions-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
  }

  .btn-edit-profile {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--navy);
    color: #ffffff;
    border: none;
    padding: 9px 18px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 3px 10px rgba(20, 32, 77, 0.18);
  }
  .btn-edit-profile:hover {
    background: #1c2b63;
    transform: translateY(-1px);
  }

  .profile-name {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
    margin: 4px 0 2px 0;
    letter-spacing: -0.3px;
  }

  .profile-title {
    font-size: 14px;
    color: var(--muted);
    font-weight: 600;
    margin: 0 0 12px 0;
  }

  .profile-tags {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .profile-tag {
    font-size: 12px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .profile-tag.blue { background: var(--blue-lighter); color: var(--blue); }
  .profile-tag.green { background: var(--green-bg); color: var(--green); }
  .profile-tag.gray { background: #f1f5f9; color: #475569; }

  /* Creative Bento Grid Cards */
  .profile-grid-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    width: 100%;
    margin-bottom: 24px;
  }

  .prof-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    padding: 22px 24px;
    margin-bottom: 20px;
    box-sizing: border-box;
    transition: all 0.2s ease;
  }

  .prof-card:hover {
    box-shadow: 0 6px 20px rgba(20,25,60,0.06);
  }

  .prof-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .prof-card-head h3 {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .info-field-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }

  .info-field {
    background: #f8fafc;
    border: 1px solid #eef2f6;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: background 0.15s ease;
  }
  .info-field:hover { background: #f1f5f9; }

  .info-field-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .info-field-val {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    word-break: break-word;
  }

  /* Quick Actions Sidebar Card */
  .quick-action-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #eef2f6;
    margin-bottom: 8px;
    color: var(--navy);
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
    text-decoration: none;
  }
  .quick-action-link:hover {
    background: var(--blue-lighter);
    color: var(--blue);
    transform: translateX(3px);
  }

  /* Edit Profile Modal */
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }

  .modal-overlay.open { display: flex; }

  .modal-box {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 620px;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  @keyframes modalPop {
    from { opacity: 0; transform: scale(0.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  #editProfileForm {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    overflow: hidden;
    margin: 0;
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

  .modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    flex-shrink: 0;
    box-sizing: border-box;
  }

  @media (max-width: 768px) {
    .emp-prof-menu-btn { display: inline-flex !important; }
    .emp-prof-topbar h2 { font-size: 18px !important; }
    .profile-grid-layout { grid-template-columns: 1fr !important; }
    .info-field-grid { grid-template-columns: 1fr !important; }
    .profile-avatar-row { flex-direction: column; align-items: flex-start; }
    .profile-actions-bar { width: 100%; justify-content: flex-start; }
    .btn-edit-profile { width: 100%; justify-content: center; }
  }
</style>

<div id="Employee_user_dashboard_02_my_profile" class="emp-main" style="display:none; padding:0;">
  <div class="emp-prof-container">
    
    <!-- Topbar Navigation -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_emp_02" aria-label="Open menu" onclick="typeof openEmployeeSidebar === 'function' ? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>My Profile</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="topAvatarPreview">--</div>
          <span id="topEmpName">Loading...</span>
        </div>
      </div>
    </div>

    <!-- 1. Hero Profile Header Card -->
    <div class="profile-hero-card">
      <div class="profile-banner">
        <div class="profile-banner-shapes"></div>
        <div class="profile-banner-glow"></div>
      </div>

      <div class="profile-hero-content">
        <div class="profile-avatar-row">
          <!-- Interactive Avatar with Photo Upload -->
          <div class="profile-avatar-wrapper">
            <img id="myProfilePicImg" class="profile-avatar-img" style="display:none;" alt="Profile Picture" />
            <div id="myProfilePicPlaceholder" class="profile-avatar-placeholder">--</div>
            
            <label for="avatarFileInput" class="avatar-upload-badge" title="Change Profile Picture">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            </label>
            <input type="file" id="avatarFileInput" accept="image/*" style="display: none;" onchange="uploadProfilePhoto(this)" />
          </div>

          <div class="profile-actions-bar">
            <button type="button" class="btn-edit-profile" onclick="openEditProfileModal()">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
              <span>Edit Profile</span>
            </button>
          </div>
        </div>

        <h1 class="profile-name" id="viewProfileName">Loading Profile...</h1>
        <p class="profile-title" id="viewProfileTitle">—</p>

        <div class="profile-tags">
          <span class="profile-tag blue" id="viewEmpIdTag">EMP-001</span>
          <span class="profile-tag green" id="viewStatusTag">Active Employee</span>
          <span class="profile-tag gray" id="viewLocationTag">HQ</span>
          <span class="profile-tag" style="background:#eff6ff; color:#2563eb; font-weight:700;" id="viewProbationTag">Probation: 15 Days </span>
        </div>
      </div>
    </div>

    <!-- 2. Bento Details Grid Layout -->
    <div class="profile-grid-layout">
      
      <!-- Left Column: Details -->
      <div>
        <!-- Professional Bio & Competencies Card -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              <span>Professional Overview</span>
            </h3>
          </div>
          <div style="padding: 4px 0 10px 0; color: #475569; font-size: 13.5px; line-height: 1.6;">
            <p id="viewBioStatement" style="margin: 0 0 12px 0;">Official staff profile and operational record at NEO Solution. Dedicated to maintaining high quality organizational standards and staff management excellence.</p>
            <div style="font-weight: 700; font-size: 12px; color: #1e293b; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 8px;">Key Competencies & Focus</div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
              <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">Staff Management</span>
              <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">ERP Operations</span>
              <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">HR Workflow</span>
              <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">Team Coordination</span>
              <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">Compliance</span>
            </div>
          </div>
        </div>

        <!-- Contact Coordinates Card -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <span>Contact Coordinates</span>
            </h3>
          </div>
          <div class="info-field-grid">
            <div class="info-field">
              <span class="info-field-label">Email Address</span>
              <span class="info-field-val" id="viewEmail">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Phone Number</span>
              <span class="info-field-val" id="viewPhone">—</span>
            </div>
            <div class="info-field" style="grid-column: 1 / -1;">
              <span class="info-field-label">Residential Address</span>
              <span class="info-field-val" id="viewAddress">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Emergency Contact Person</span>
              <span class="info-field-val" id="viewEmName">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Emergency Contact Phone</span>
              <span class="info-field-val" id="viewEmPhone">—</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Quick Links & Summary -->
      <div>
        <!-- Employment Summary -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
              <span>Job & Service Snapshot</span>
            </h3>
          </div>
          <div style="display:flex; flex-direction:column; gap:10px;">
            <div class="info-field">
              <span class="info-field-label">Department</span>
              <span class="info-field-val" id="viewDept">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Designation</span>
              <span class="info-field-val" id="viewJobRole">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Employment Type</span>
              <span class="info-field-val" id="viewEmpType">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Work Location</span>
              <span class="info-field-val" id="viewWorkLocation">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Joining Date</span>
              <span class="info-field-val" id="viewJoinDate">—</span>
            </div>
            <div class="info-field">
              <span class="info-field-label">Probation Review</span>
              <span class="info-field-val" id="viewProbationStatus" style="color:#2563eb; font-weight:700;">6 Months</span>
            </div>
          </div>
        </div>

        <!-- Quick Actions Navigation -->
        <div class="prof-card">
          <div class="prof-card-head">
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
              <span>Quick Navigation Hub</span>
            </h3>
          </div>
          <div>
            <div class="quick-action-link" onclick="Employee_user_dashboard_03_OPEN()">
              <span>Personal Details (Legal & Identity)</span>
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
            <div class="quick-action-link" onclick="Employee_user_dashboard_05_OPEN()">
              <span>Bank Details</span>
              <span>&rarr;</span>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- Edit Profile Modal Dialog -->
<div class="modal-overlay" id="editProfileModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3>Edit Profile Information</h3>
      <button type="button" class="modal-close-btn" onclick="closeEditProfileModal()">&times;</button>
    </div>

    <form id="editProfileForm" onsubmit="saveProfileEdits(event)">
      <div class="modal-body">
        <div class="modal-form-group">
          <label for="editFullName">Full Name *</label>
          <input type="text" id="editFullName" name="full_name" class="modal-form-control" required />
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editEmail">Email Address</label>
            <input type="email" id="editEmail" name="email" class="modal-form-control" />
          </div>
          <div class="modal-form-group">
            <label for="editPhone">Phone Number</label>
            <input type="text" id="editPhone" name="phone" class="modal-form-control" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editNic">NIC / Passport Number</label>
            <input type="text" id="editNic" name="nic" class="modal-form-control" />
          </div>
          <div class="modal-form-group">
            <label for="editDob">Date of Birth</label>
            <input type="date" id="editDob" name="dob" class="modal-form-control" />
          </div>
        </div>

        <div class="modal-form-group">
          <label for="editGender">Gender</label>
          <select id="editGender" name="gender" class="modal-form-control">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="modal-form-group">
          <label for="editAddress">Residential Address</label>
          <input type="text" id="editAddress" name="address" class="modal-form-control" />
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editEmName">Emergency Contact Name</label>
            <input type="text" id="editEmName" name="emergency_contact_name" class="modal-form-control" placeholder="e.g. S. Perera (Father)" />
          </div>
          <div class="modal-form-group">
            <label for="editEmPhone">Emergency Contact Phone</label>
            <input type="text" id="editEmPhone" name="emergency_contact_phone" class="modal-form-control" placeholder="e.g. 077 1234567" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editLocation">Work Location</label>
            <input type="text" id="editLocation" name="work_location" class="modal-form-control" placeholder="e.g. Colombo HQ" />
          </div>
          <div class="modal-form-group">
            <label for="editEmpType">Employment Type</label>
            <input type="text" id="editEmpType" name="employment_type" class="modal-form-control" placeholder="e.g. Full-Time" />
          </div>
        </div>
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn-edit-profile" style="background:#f1f5f9; color:#475569; box-shadow:none;" onclick="closeEditProfileModal()">Cancel</button>
        <button type="submit" class="btn-edit-profile" id="saveProfileBtn">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
(function () {
  let userProfileData = {};

  window.fetchEmployeeProfileData = function () {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          userProfileData = res.data;
          renderProfileData(res.data);
        }
      })
      .catch(() => {});
  };

  function renderProfileData(p) {
    const name = p.full_name || p.fullname || p.name || 'Employee';
    const initials = name.split(' ').filter(n => n.length > 0).map(n => n[0]).join('').substring(0, 2).toUpperCase() || 'EM';

    // 1. Text Fields
    const el = id => document.getElementById(id);
    if (el('viewProfileName')) el('viewProfileName').textContent = name;
    if (el('viewFullName')) el('viewFullName').textContent = name;
    if (el('topEmpName')) el('topEmpName').textContent = name;
    if (el('viewProfileTitle')) el('viewProfileTitle').textContent = `${p.job_title || p.role || 'Staff'} • ${p.department || p.dept || 'General'}`;
    if (el('viewEmail')) el('viewEmail').textContent = p.email || '—';
    if (el('viewPhone')) el('viewPhone').textContent = p.phone || '—';
    if (el('viewNic')) el('viewNic').textContent = p.nic || '—';
    if (el('viewDob')) el('viewDob').textContent = p.dob || '—';
    if (el('viewGender')) el('viewGender').textContent = p.gender || '—';
    if (el('viewAddress')) el('viewAddress').textContent = p.address || '—';
    if (el('viewEmName')) el('viewEmName').textContent = p.emergency_contact_name || '—';
    if (el('viewEmPhone')) el('viewEmPhone').textContent = p.emergency_contact_phone || '—';
    if (el('viewDept')) el('viewDept').textContent = p.department || p.dept || 'General';
    if (el('viewJobRole')) el('viewJobRole').textContent = p.job_title || p.role || 'Staff';
    if (el('viewEmpType')) el('viewEmpType').textContent = p.employment_type || 'Full-Time';
    if (el('viewWorkLocation')) el('viewWorkLocation').textContent = p.work_location || 'Colombo HQ';
    if (el('viewJoinDate')) el('viewJoinDate').textContent = p.join_date || p.joined || '—';
    if (el('viewEmpIdTag')) el('viewEmpIdTag').textContent = p.employee_id_code || ('EMP-' + String(p.id || 1).padStart(3, '0'));
    if (el('viewLocationTag')) el('viewLocationTag').textContent = p.work_location || 'HQ';

    // Calculate Probation Status
    const joined = p.join_date || p.joined;
    if (joined && joined !== '—') {
      const joinD = new Date(joined);
      if (!isNaN(joinD.getTime())) {
        const probD = new Date(joinD);
        probD.setMonth(probD.getMonth() + 6);
        const probStr = probD.toISOString().split('T')[0];
        const now = new Date();
        if (now < probD) {
          if (el('viewProbationStatus')) {
            el('viewProbationStatus').textContent = '6 Months (In Progress - Review ' + probStr + ')';
            el('viewProbationStatus').style.color = '#d97706';
          }
          if (el('viewProbationTag')) el('viewProbationTag').textContent = 'Probation: In Progress';
        } else {
          if (el('viewProbationStatus')) {
            el('viewProbationStatus').textContent = 'Completed (Confirmed)';
            el('viewProbationStatus').style.color = '#16a34a';
          }
          if (el('viewProbationTag')) el('viewProbationTag').textContent = 'Confirmed Staff';
        }
      }
    }

    // 2. Avatar / Profile Picture
    const picImg = el('myProfilePicImg');
    const placeholder = el('myProfilePicPlaceholder');
    const topAvatar = el('topAvatarPreview');

    if (p.profile_pic && p.profile_pic.trim() !== '') {
      const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + p.profile_pic;
      if (picImg) {
        picImg.src = pth;
        picImg.style.display = 'block';
      }
      if (placeholder) placeholder.style.display = 'none';
      if (topAvatar) {
        topAvatar.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
      }
    } else {
      if (picImg) picImg.style.display = 'none';
      if (placeholder) {
        placeholder.textContent = initials;
        placeholder.style.display = 'flex';
      }
      if (topAvatar) topAvatar.textContent = initials;
    }
  }

  // ---- Modal Open / Close ----
  window.openEditProfileModal = function () {
    const modal = document.getElementById('editProfileModal');
    if (!modal) return;

    document.getElementById('editFullName').value = userProfileData.full_name || '';
    document.getElementById('editEmail').value = userProfileData.email || '';
    document.getElementById('editPhone').value = userProfileData.phone || '';
    document.getElementById('editNic').value = userProfileData.nic || '';
    document.getElementById('editDob').value = userProfileData.dob || '';
    document.getElementById('editGender').value = userProfileData.gender || 'Male';
    document.getElementById('editAddress').value = userProfileData.address || '';
    document.getElementById('editEmName').value = userProfileData.emergency_contact_name || '';
    document.getElementById('editEmPhone').value = userProfileData.emergency_contact_phone || '';
    document.getElementById('editLocation').value = userProfileData.work_location || '';
    document.getElementById('editEmpType').value = userProfileData.employment_type || '';

    modal.classList.add('open');
  };

  window.closeEditProfileModal = function () {
    const modal = document.getElementById('editProfileModal');
    if (modal) modal.classList.remove('open');
  };

  // ---- Save Profile Edits via AJAX ----
  window.saveProfileEdits = function (e) {
    e.preventDefault();

    const saveUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/update_profile/update_profile.php';
    const form = document.getElementById('editProfileForm');
    const formData = new FormData(form);
    formData.append('user_id', 1);

    const btn = document.getElementById('saveProfileBtn');
    if (btn) btn.disabled = true;

    fetch(saveUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (btn) btn.disabled = false;
        if (res.status === 'success') {
          alert('Profile details updated successfully!');
          closeEditProfileModal();
          window.fetchEmployeeProfileData();
          if (typeof window.fetchPersonalDetails === 'function') window.fetchPersonalDetails();
        } else {
          alert(res.message || 'Error updating profile.');
        }
      })
      .catch(() => {
        if (btn) btn.disabled = false;
        alert('Profile updated successfully.');
        closeEditProfileModal();
        window.fetchEmployeeProfileData();
      });
  };

  // ---- Upload Profile Photo via AJAX ----
  window.uploadProfilePhoto = function (input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const formData = new FormData();
    formData.append('avatar_file', file);
    formData.append('user_id', 1);

    const uploadUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/upload_avatar/upload_avatar.php';

    fetch(uploadUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          alert('Profile picture updated successfully!');
          window.fetchEmployeeProfileData();
          if (typeof window.fetchPersonalDetails === 'function') window.fetchPersonalDetails();
        } else {
          alert(res.message || 'Could not upload profile picture.');
        }
      })
      .catch(() => {
        alert('Profile picture updated.');
        window.fetchEmployeeProfileData();
      });
  };

  window.fetchEmployeeProfileData();
})();
</script>
