<style>
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
  .profile-tag.blue { background: #14204d; color: #ffffff; border: 1px solid #14204d; }
  .profile-tag.green { background: #e3f9ee; color: #12b76a; border: 1px solid #c2f0d9; }
  .profile-tag.gray { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }

  /* 2. Grid Layout */
  .profile-grid-layout {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
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
    box-sizing: border-box;
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
    gap: 10px;
  }

  .prof-card-head h3 svg {
    color: var(--blue);
    flex-shrink: 0;
  }

  .prof-card-subtitle {
    font-size: 12px;
    color: var(--muted);
    margin: 2px 0 0 0;
    font-weight: 500;
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
    min-width: 0;
  }
  .info-field:hover {
    background: #f1f5f9;
  }
  .info-field.full-span {
    grid-column: 1 / -1;
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

  /* Weekly Roster */
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
    padding: 10px 3px;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    transition: all 0.2s ease;
    min-width: 0;
  }
  
  .roster-day-name {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
    white-space: nowrap;
  }

  .roster-day-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    word-break: keep-all;
    font-size: 9.5px;
    font-weight: 800;
    padding: 4px 6px;
    border-radius: 6px;
    text-transform: uppercase;
    line-height: 1;
    max-width: 100%;
    box-sizing: border-box;
  }
  .roster-day-badge.onsite { background: #2563eb; color: #ffffff; border: 1px solid #2563eb; }
  .roster-day-badge.wfh { background: #7c3aed; color: #ffffff; border: 1px solid #7c3aed; }
  .roster-day-badge.leave { background: #f1f5f9; color: #64748b; border: 1px dashed #cbd5e1; }

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

  /* Career Timeline Card (Full Width) */
  .timeline-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.03);
    padding: 24px 28px;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 24px;
    transition: all 0.2s ease;
  }
  .timeline-card:hover {
    box-shadow: 0 6px 20px rgba(20, 25, 60, 0.06);
    border-color: #cbd5e1;
  }

  .timeline-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
  }

  .timeline-card-head h3 {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .timeline-list {
    position: relative;
    padding-left: 28px;
  }

  .timeline-list::before {
    content: "";
    position: absolute;
    top: 6px;
    bottom: 24px;
    left: 7px;
    width: 2px;
    background: #e2e8f0;
  }

  .timeline-item {
    position: relative;
    padding-bottom: 22px;
  }

  .timeline-item:last-child {
    padding-bottom: 0;
  }

  .timeline-dot {
    position: absolute;
    left: -28px;
    top: 3px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #ffffff;
    border: 3px solid #2563eb;
    box-sizing: border-box;
    z-index: 2;
  }

  .timeline-dot.filled {
    background: #2563eb;
    border-color: #2563eb;
  }

  .timeline-date {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 3px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .timeline-title {
    font-size: 14.5px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 3px;
  }

  .timeline-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.45;
  }

  /* Modal Styles */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.65);
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
    gap: 16px;
    box-sizing: border-box;
  }

  .modal-section-title {
    font-size: 12px;
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 6px;
    margin-top: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
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

  /* Responsive Rules */
  @media (max-width: 900px) {
    .profile-grid-layout { grid-template-columns: 1fr !important; }
    .roster-days-grid { grid-template-columns: repeat(4, 1fr) !important; }
    .btn-edit-profile { width: 100%; justify-content: center; }
  }

  @media (max-width: 600px) {
    #Employee_user_dashboard_02_my_profile {
      width: 100% !important;
      max-width: 100% !important;
      overflow-x: hidden !important;
    }

    #Employee_user_dashboard_02_my_profile .emp-prof-container {
      padding: 0 10px 64px !important;
    }

    #Employee_user_dashboard_02_my_profile .topbar {
      min-width: 0 !important;
      height: 56px !important;
      padding: 8px 0 !important;
      gap: 8px !important;
    }

    #Employee_user_dashboard_02_my_profile .topbar-left {
      min-width: 0 !important;
      gap: 6px !important;
      flex: 1 !important;
    }

    #Employee_user_dashboard_02_my_profile .topbar-left h2 {
      font-size: 16px !important;
    }

    #Employee_user_dashboard_02_my_profile .profile-banner {
      height: 86px !important;
    }

    #Employee_user_dashboard_02_my_profile .profile-hero-content {
      padding: 0 13px 15px !important;
    }

    #Employee_user_dashboard_02_my_profile .profile-avatar-wrapper,
    #Employee_user_dashboard_02_my_profile .profile-avatar-img,
    #Employee_user_dashboard_02_my_profile .profile-avatar-placeholder {
      width: 72px !important;
      height: 72px !important;
    }

    #Employee_user_dashboard_02_my_profile .profile-avatar-wrapper {
      margin-top: -36px !important;
    }

    #Employee_user_dashboard_02_my_profile .profile-name {
      font-size: 20px !important;
      line-height: 1.25 !important;
    }

    #Employee_user_dashboard_02_my_profile .info-field-grid {
      grid-template-columns: 1fr !important;
      gap: 8px !important;
    }

    #Employee_user_dashboard_02_my_profile .roster-days-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      gap: 7px !important;
    }

    #Employee_user_dashboard_02_my_profile .timeline-card {
      padding: 16px 14px !important;
      border-radius: 13px !important;
    }

    #Employee_user_dashboard_02_my_profile .timeline-list {
      padding-left: 24px !important;
    }

    #Employee_user_dashboard_02_my_profile .timeline-dot {
      left: -24px !important;
    }

    #Employee_user_dashboard_02_my_profile .modal-overlay {
      padding: 8px !important;
      align-items: flex-start !important;
    }

    #Employee_user_dashboard_02_my_profile .modal-box {
      width: 100% !important;
      max-width: 100% !important;
      max-height: calc(100dvh - 16px) !important;
      border-radius: 13px !important;
    }

    #Employee_user_dashboard_02_my_profile .modal-body {
      padding: 14px !important;
      gap: 12px !important;
    }

    #Employee_user_dashboard_02_my_profile .modal-body > div[style*="grid-template-columns"] {
      grid-template-columns: 1fr !important;
      gap: 10px !important;
    }

    #Employee_user_dashboard_02_my_profile .modal-footer {
      flex-direction: column !important;
    }

    #Employee_user_dashboard_02_my_profile .modal-footer button {
      width: 100% !important;
    }
  }
</style>

<div id="Employee_user_dashboard_02_my_profile" class="w3-container tab-content" style="display: none; padding: 0;">
  <div class="emp-prof-container">

    <!-- Standard Topbar -->
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
          <div class="avatar" id="topAvatar_02"><?php echo htmlspecialchars(!empty($logged_user_initials) ? $logged_user_initials : 'EM'); ?></div>
          <span id="topEmpName_02"><?php echo htmlspecialchars(!empty($logged_user_first_name) && $logged_user_first_name !== 'Guest' ? $logged_user_first_name : 'Employee'); ?></span>
        </div>
      </div>
    </div>

    <!-- Page Action Subbar -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
      <div>
        <p style="font-size: 13.5px; color: #64748b; margin: 0; font-weight: 500;">Comprehensive personal identity, job information, service record & duty schedule</p>
      </div>

      <button type="button" class="btn-edit-profile" onclick="openEditProfileModal()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <span>Edit Profile Details</span>
      </button>
    </div>

    <!-- 1. Hero Profile Header Card -->
    <div class="profile-hero-card">
      <div class="profile-banner"></div>

      <div class="profile-hero-content">
        <div class="profile-avatar-row">
          <div class="profile-avatar-wrapper">
            <img id="myProfilePicImg" class="profile-avatar-img" style="display:none;" alt="Profile Picture" />
            <div id="myProfilePicPlaceholder" class="profile-avatar-placeholder"></div>
            
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

        <h1 class="profile-name" id="viewProfileName"><?php echo htmlspecialchars($logged_user_name ?? 'Loading Profile...'); ?></h1>
        <p class="profile-title" id="viewProfileTitle"></p>
      </div>
    </div>

    <!-- SECTION: Personal Dossier, Job Information & Workplace Placement -->
    <div class="profile-grid-layout">
      
      <!-- Card 1: Primary Legal Identity -->
      <div class="prof-card">
        <div class="prof-card-head">
          <div>
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              <span>Primary Legal Identity</span>
            </h3>
            <p class="prof-card-subtitle">Personal verification & government credentials</p>
          </div>
        </div>
        <div class="info-field-grid">
          <div class="info-field full-span">
            <span class="info-field-label">Full Legal Name</span>
            <span class="info-field-val" id="pdFullName">—</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">National Identity Card (NIC)</span>
            <span class="info-field-val" id="pdNic">—</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Date of Birth</span>
            <span class="info-field-val" id="pdDob">—</span>
          </div>
          <div class="info-field full-span">
            <span class="info-field-label">Gender</span>
            <span class="info-field-val" id="pdGender">—</span>
          </div>
        </div>
      </div>

      <!-- Card 2: Contact Coordinates & Residence -->
      <div class="prof-card">
        <div class="prof-card-head">
          <div>
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <span>Contact Coordinates & Residence</span>
            </h3>
            <p class="prof-card-subtitle">Official communication channels & home location</p>
          </div>
        </div>
        <div class="info-field-grid">
          <div class="info-field full-span">
            <span class="info-field-label">Official Work Email</span>
            <span class="info-field-val" id="viewEmail">—</span>
          </div>
          <div class="info-field full-span">
            <span class="info-field-label">Primary Mobile Phone</span>
            <span class="info-field-val" id="viewPhone">—</span>
          </div>
          <div class="info-field full-span">
            <span class="info-field-label">Residential Address</span>
            <span class="info-field-val" id="pdAddress">—</span>
          </div>
        </div>
      </div>

      <!-- Card 3: Emergency Notification Contact -->
      <div class="prof-card">
        <div class="prof-card-head">
          <div>
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              <span>Primary Emergency Contact</span>
            </h3>
            <p class="prof-card-subtitle">Designated next of kin for urgent notification</p>
          </div>
        </div>
        <div class="info-field-grid">
          <div class="info-field">
            <span class="info-field-label">Contact Person Name</span>
            <span class="info-field-val" id="viewEmName" style="color: #0f172a; font-weight: 700;">—</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Emergency Phone Number</span>
            <span class="info-field-val" id="viewEmPhone" style="color: #0f172a; font-weight: 700;">—</span>
          </div>
        </div>
      </div>

      <!-- Card 4: Job Information & Placement Record -->
      <div class="prof-card">
        <div class="prof-card-head">
          <div>
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
              <span>Job Information & Service Record</span>
            </h3>
            <p class="prof-card-subtitle">Official organizational appointment & job position details</p>
          </div>
        </div>
        <div class="info-field-grid">
          <div class="info-field">
            <span class="info-field-label">Employee ID Code</span>
            <span class="info-field-val" id="pdEmpCode">—</span>
            <span id="jobEmpId" style="display:none;"></span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Department</span>
            <span class="info-field-val" id="viewDept">—</span>
            <span id="jobDept" style="display:none;"></span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Designation / Role</span>
            <span class="info-field-val" id="viewJobRole">—</span>
            <span id="jobRole" style="display:none;"></span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Employment Type</span>
            <span class="info-field-val" id="pdEmpType">—</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Assigned Work Location</span>
            <span class="info-field-val" id="viewWorkLocation">Colombo HQ</span>
            <span id="jobLocation" style="display:none;"></span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Official Joining Date</span>
            <span class="info-field-val" id="pdJoinDate">—</span>
            <span id="jobJoined" style="display:none;"></span>
          </div>
          <div class="info-field full-span">
            <span class="info-field-label">Probation & Service Confirmation</span>
            <span class="info-field-val" id="pdProbationStatus" style="color:#16a34a;">Confirmed Staff</span>
          </div>
        </div>
      </div>

      <!-- Card 5: Work Schedule & Shift Timing -->
      <div class="prof-card">
        <div class="prof-card-head">
          <div>
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span>Work Schedule & Shift Timing</span>
            </h3>
            <p class="prof-card-subtitle">Working hours & daily work arrangement</p>
          </div>
        </div>
        <div class="info-field-grid">
          <div class="info-field">
            <span class="info-field-label">Work Shift Hours</span>
            <span class="info-field-val" id="viewWorkShift" style="font-weight: 700; color: #1e293b;">08:30 AM – 05:30 PM</span>
            <span id="jobWorkShift" style="display:none;"></span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Working Days</span>
            <span class="info-field-val" id="viewWorkingDays" style="font-weight: 700; color: #2563eb;">Mon, Tue, Wed, Thu, Fri</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">General Work Mode</span>
            <span class="info-field-val" id="viewWorkMode" style="color: #16a34a; font-weight: 700;">On-Site (Active)</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Schedule Period</span>
            <span class="info-field-val" id="viewSchedPeriod">Permanent / Active</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Schedule Start Date</span>
            <span class="info-field-val" id="viewSchedStart">—</span>
          </div>
          <div class="info-field">
            <span class="info-field-label">Schedule End Date</span>
            <span class="info-field-val" id="viewSchedEnd">—</span>
          </div>
        </div>
      </div>

      <!-- Card 6: Weekly Duty Schedule / Roster Grid -->
      <div class="prof-card">
        <div class="prof-card-head">
          <div>
            <h3>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <span>Weekly Duty Schedule</span>
            </h3>
            <p class="prof-card-subtitle">Day-by-day weekly arrangement according to assigned working days</p>
          </div>
        </div>
        <div>
          <div class="roster-days-grid" id="viewRosterGrid">
            <div class="roster-day-box" id="dayBox_Mon">
              <span class="roster-day-name">Mon</span>
              <span class="roster-day-badge onsite" id="badge_Mon">Working</span>
            </div>
            <div class="roster-day-box" id="dayBox_Tue">
              <span class="roster-day-name">Tue</span>
              <span class="roster-day-badge onsite" id="badge_Tue">Working</span>
            </div>
            <div class="roster-day-box" id="dayBox_Wed">
              <span class="roster-day-name">Wed</span>
              <span class="roster-day-badge onsite" id="badge_Wed">Working</span>
            </div>
            <div class="roster-day-box" id="dayBox_Thu">
              <span class="roster-day-name">Thu</span>
              <span class="roster-day-badge onsite" id="badge_Thu">Working</span>
            </div>
            <div class="roster-day-box" id="dayBox_Fri">
              <span class="roster-day-name">Fri</span>
              <span class="roster-day-badge onsite" id="badge_Fri">Working</span>
            </div>
            <div class="roster-day-box" id="dayBox_Sat">
              <span class="roster-day-name">Sat</span>
              <span class="roster-day-badge leave" id="badge_Sat">Off Day</span>
            </div>
            <div class="roster-day-box" id="dayBox_Sun">
              <span class="roster-day-name">Sun</span>
              <span class="roster-day-badge leave" id="badge_Sun">Off Day</span>
            </div>
          </div>

          <div class="roster-summary-row">
            <span class="roster-stat-pill onsite" id="statOnsite">On-Site: 5 Days</span>
            <span class="roster-stat-pill wfh" id="statWfh" style="background:#f5f3ff; color:#7c3aed; border:1px solid #ddd6fe;">WFH: 0 Days</span>
            <span class="roster-stat-pill leave" id="statLeave">Leave / Off: 2 Days</span>
          </div>
        </div>
      </div>

    </div>

    <!-- SECTION: Career Timeline & Service Milestones (From Job Information) -->
    <div class="timeline-card">
      <div class="timeline-card-head">
        <h3>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <span>Career Timeline & Service Milestones</span>
        </h3>
        <span style="font-size: 12px; color: #64748b; font-weight: 600;">Position & Employment History</span>
      </div>

      <div class="timeline-list">
        
        <!-- Milestone 1: Joining -->
        <div class="timeline-item">
          <div class="timeline-dot filled"></div>
          <div class="timeline-date" id="timelineJoinDate">—</div>
          <div class="timeline-title">Official Appointment & Joining</div>
          <div class="timeline-desc" id="timelineJoinDesc">Joined as organization staff member.</div>
        </div>

        <!-- Milestone 2: Probation & Confirmation -->
        <div class="timeline-item">
          <div class="timeline-dot" style="border-color:#16a34a; background:#e3f9ee;"></div>
          <div class="timeline-date" id="timelineProbDate">Probation & Service Review</div>
          <div class="timeline-title" id="timelineProbTitle">Probation Status</div>
          <div class="timeline-desc" id="timelineProbDesc">Staff service confirmation and evaluation.</div>
        </div>

        <!-- Milestone 3: Active Position -->
        <div class="timeline-item">
          <div class="timeline-dot filled" style="background:#2563eb; border-color:#2563eb;"></div>
          <div class="timeline-date">Current Position</div>
          <div class="timeline-title" id="timelineActiveTitle">Active Contributing Staff</div>
          <div class="timeline-desc" id="timelineActiveDesc">Active team member in designated department.</div>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- ========================================================
     UNIFIED EDIT PROFILE & PERSONAL DETAILS MODAL
     ======================================================== -->
<div class="modal-overlay" id="editProfileModal">
  <div class="modal-box" style="max-width: 680px; width: 100%; max-height: 90vh; display: flex; flex-direction: column;">
    <div class="modal-header">
      <div style="display:flex; align-items:center; gap:8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <h3 style="margin:0; font-size:18px; font-weight:800; color:var(--navy);">Edit Profile & Personal Details</h3>
      </div>
      <button type="button" class="modal-close-btn" onclick="closeEditProfileModal()">&times;</button>
    </div>

    <form id="editProfileForm" onsubmit="saveProfileEdits(event)" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
      <div class="modal-body" style="overflow-y: auto; max-height: calc(90vh - 130px); padding: 20px 24px; display: flex; flex-direction: column; gap: 16px;">
        
        <!-- SECTION 1: Legal Identity -->
        <div class="modal-section-title">
          <span>1. Primary Legal Identity</span>
          <span style="font-size: 10px; color: #16a34a; font-weight: 700; text-transform: none;">Editable by Employee</span>
        </div>
        
        <div class="modal-form-group">
          <label for="editFullName">Full Legal Name *</label>
          <input type="text" id="editFullName" name="full_name" class="modal-form-control" required placeholder="e.g. Kasun Kalhara Perera" />
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editNic">National Identity Card (NIC) / Passport</label>
            <input type="text" id="editNic" name="nic" class="modal-form-control" placeholder="e.g. 199412345678" />
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

        <!-- SECTION 2: Contact & Residence -->
        <div class="modal-section-title">
          <span>2. Contact Coordinates & Residence</span>
          <span style="font-size: 10px; color: #16a34a; font-weight: 700; text-transform: none;">Editable by Employee</span>
        </div>

        <div class="modal-form-group">
          <label for="editPhone">Primary Contact Phone</label>
          <input type="text" id="editPhone" name="phone" class="modal-form-control" placeholder="e.g. 077 1234567" />
        </div>

        <div class="modal-form-group">
          <label for="editAddress">Residential Address</label>
          <input type="text" id="editAddress" name="address" class="modal-form-control" placeholder="e.g. No. 45/2, Galle Road, Colombo 03" />
        </div>

        <!-- SECTION 3: Emergency Notification Contact -->
        <div class="modal-section-title">
          <span>3. Emergency Contacts</span>
          <span style="font-size: 10px; color: #16a34a; font-weight: 700; text-transform: none;">Editable by Employee</span>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editEmName">Emergency Contact Person</label>
            <input type="text" id="editEmName" name="emergency_contact_name" class="modal-form-control" placeholder="e.g. Nimal Perera (Father)" style="border: 1.5px solid #86efac; background: #ffffff;" />
          </div>
          <div class="modal-form-group">
            <label for="editEmPhone">Emergency Contact Phone</label>
            <input type="text" id="editEmPhone" name="emergency_contact_phone" class="modal-form-control" placeholder="e.g. +94 77 123 4567" style="border: 1.5px solid #86efac; background: #ffffff;" />
          </div>
        </div>

        <!-- SECTION 4: Workplace Placement & Record (Read-Only for Employee) -->
        <div class="modal-section-title">
          <span>4. Official Placement & Service Record</span>
          <span style="font-size: 10px; color: #64748b; font-weight: 700; text-transform: none;"><i class="fa-solid fa-lock"></i> Managed by Admin</span>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editEmail">Official Work Email</label>
            <input type="email" id="editEmail" name="email" class="modal-form-control" readonly tabindex="-1" style="background: #f8fafc; color: #64748b; cursor: not-allowed; border: 1px dashed #cbd5e1;" />
          </div>
          <div class="modal-form-group">
            <label for="editEmpCode">Employee ID Code</label>
            <input type="text" id="editEmpCode" name="employee_id_code" class="modal-form-control" readonly tabindex="-1" style="background: #f8fafc; color: #64748b; cursor: not-allowed; border: 1px dashed #cbd5e1;" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editDept">Department</label>
            <input type="text" id="editDept" name="dept" class="modal-form-control" readonly tabindex="-1" style="background: #f8fafc; color: #64748b; cursor: not-allowed; border: 1px dashed #cbd5e1;" />
          </div>
          <div class="modal-form-group">
            <label for="editJobRole">Job Role / Designation</label>
            <input type="text" id="editJobRole" name="role" class="modal-form-control" readonly tabindex="-1" style="background: #f8fafc; color: #64748b; cursor: not-allowed; border: 1px dashed #cbd5e1;" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
          <div class="modal-form-group">
            <label for="editLocation">Work Location</label>
            <input type="text" id="editLocation" name="work_location" class="modal-form-control" readonly tabindex="-1" style="background: #f8fafc; color: #64748b; cursor: not-allowed; border: 1px dashed #cbd5e1;" />
          </div>
          <div class="modal-form-group">
            <label for="editEmpType">Employment Type</label>
            <input type="text" id="editEmpType" name="employment_type" class="modal-form-control" readonly tabindex="-1" style="background: #f8fafc; color: #64748b; cursor: not-allowed; border: 1px dashed #cbd5e1;" />
          </div>
        </div>

        <!-- Read-Only Assigned Work Schedule Info Card -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; display: flex; flex-direction: column; gap: 10px;">
          <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
            <div>
              <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 3px;">Work Shift & Hours</div>
              <div id="modalViewWorkShift" style="padding: 7px 10px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700; color: #1e293b;">
                08:30 AM – 05:30 PM
              </div>
            </div>
            <div>
              <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 3px;">Working Days</div>
              <div id="modalViewWorkingDays" style="padding: 7px 10px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700; color: #2563eb;">
                Mon, Tue, Wed, Thu, Fri
              </div>
            </div>
          </div>

          <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
            <div>
              <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 3px;">Work Mode</div>
              <div id="modalViewWorkMode" style="padding: 7px 10px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12.5px; font-weight: 600; color: #16a34a;">
                On-Site (Active)
              </div>
            </div>
            <div>
              <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 3px;">Schedule Period</div>
              <div id="modalViewSchedulePeriod" style="padding: 7px 10px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12.5px; font-weight: 600; color: #475569;">
                Active / Permanent
              </div>
            </div>
          </div>

          <div style="font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 6px; padding-top: 6px; border-top: 1px dashed #cbd5e1;">
            <i class="fa-solid fa-circle-info" style="color: #0284c7;"></i>
            <span>Department, designation, working days, and shift hours are managed by Company Administration.</span>
          </div>
        </div>

      </div>

      <div class="modal-footer" style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px; background:#fafbfd; flex-shrink:0;">
        <button type="button" class="btn-edit-profile" style="background:#f1f5f9; color:#475569; box-shadow:none;" onclick="closeEditProfileModal()">Cancel</button>
        <button type="submit" class="btn-edit-profile" id="saveProfileBtn" style="background:var(--navy); color:#ffffff;">Save All Changes</button>
      </div>
    </form>
  </div>
</div>
