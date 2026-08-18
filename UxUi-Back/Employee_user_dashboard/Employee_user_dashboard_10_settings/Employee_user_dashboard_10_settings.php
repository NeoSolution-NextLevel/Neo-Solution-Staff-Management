<style>
  /* =========================================================
     SETTINGS (MATCHING FIGMA SCREENSHOT & FULL RESPONSIVE)
  ========================================================= */
  .settings-wrapper {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  .settings-page-head {
    margin-bottom: 24px;
  }

  .settings-page-head h1 {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy, #14204d);
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
  }

  .settings-page-head p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
  }

  /* Settings Box Card */
  .settings-box-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 26px 30px;
    margin-bottom: 24px;
    box-sizing: border-box;
    width: 100%;
  }

  .settings-box-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: #1e293b;
    margin: 0 0 20px 0;
  }

  /* Toggle Row Item */
  .setting-toggle-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 16px;
  }

  .setting-toggle-item:last-child {
    border-bottom: none;
    padding-bottom: 4px;
  }

  .setting-toggle-item:first-child {
    padding-top: 0;
  }

  .setting-toggle-info strong {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 3px;
  }

  .setting-toggle-info span {
    font-size: 12.5px;
    color: #64748b;
  }

  /* Custom Switch Pill */
  .switch-pill {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 26px;
    flex-shrink: 0;
  }

  .switch-pill input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 34px;
  }

  .switch-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.15);
  }

  .switch-pill input:checked + .switch-slider {
    background-color: #2563eb;
  }

  .switch-pill input:checked + .switch-slider:before {
    transform: translateX(20px);
  }

  /* Account Info 4-Box Grid */
  .account-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px 20px;
    margin-bottom: 22px;
    width: 100%;
  }

  .account-info-box {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .account-info-box .label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
  }

  .account-info-box .value {
    font-size: 14.5px;
    font-weight: 700;
    color: #1e293b;
  }

  .settings-save-btn {
    width: 100%;
    background: #1e3a8a;
    color: #ffffff;
    font-weight: 700;
    font-size: 14.5px;
    border: none;
    border-radius: 10px;
    padding: 13px 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(30, 58, 138, 0.18);
  }

  .settings-save-btn:hover {
    background: #172554;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
  }

  .settings-save-btn:active {
    transform: translateY(0);
  }

  @media (max-width: 900px) {
    .settings-box-card {
      padding: 20px 18px;
      margin-bottom: 16px;
    }

    .account-info-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }
  }
</style>

<div id="Employee_user_dashboard_10_settings" class="w3-animate-opacity" style="display:none;">
  <main class="main">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_10" aria-label="Open menu" onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Settings</h2>
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
          <div class="avatar">AP</div>
          <span>Amal</span>
        </div>
      </div>
    </div>

    <div class="settings-wrapper w3-container" style="padding: 0;">

      <!-- Page Head -->
      <div class="settings-page-head">
        <p>Manage your account preferences</p>
      </div>

      <!-- Box 1: Notification Preferences -->
      <div class="settings-box-card w3-card w3-round-xlarge">
        <h3>Notification Preferences</h3>

        <!-- Toggle 1: Email Notifications -->
        <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Email Notifications</strong>
            <span>Receive notifications via email</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingEmailNotif" checked>
            <span class="switch-slider"></span>
          </label>
        </div>

        <!-- Toggle 2: Task Updates -->
        <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Task Updates</strong>
            <span>Get notified when tasks are assigned or updated</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingTaskUpdates" checked>
            <span class="switch-slider"></span>
          </label>
        </div>

        <!-- Toggle 3: Leave Status -->
        <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Leave Status</strong>
            <span>Notifications for leave request status changes</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingLeaveStatus" checked>
            <span class="switch-slider"></span>
          </label>
        </div>

        <!-- Toggle 4: System Alerts -->
        <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>System Alerts</strong>
            <span>Important system maintenance and updates</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingSystemAlerts">
            <span class="switch-slider"></span>
          </label>
        </div>
      </div>

      <!-- Box 2: Privacy Settings -->
      <div class="settings-box-card w3-card w3-round-xlarge">
        <h3>Privacy Settings</h3>

        <!-- Toggle 1: Profile Visibility -->
        <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Profile Visibility</strong>
            <span>Allow other employees to view your profile</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingProfileVisibility" checked>
            <span class="switch-slider"></span>
          </label>
        </div>

        <!-- Toggle 2: Activity Status -->
        <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Activity Status</strong>
            <span>Show your online/active status to others</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingActivityStatus">
            <span class="switch-slider"></span>
          </label>
        </div>
      </div>

      <!-- Box 3: Account Information -->
      <div class="settings-box-card w3-card w3-round-xlarge">
        <h3>Account Information</h3>

        <div class="account-info-grid">
          <div class="account-info-box">
            <span class="label">Account Type</span>
            <span class="value">Employee</span>
          </div>

          <div class="account-info-box">
            <span class="label">Account Status</span>
            <span class="value" style="color: #16a34a;">Active</span>
          </div>

          <div class="account-info-box">
            <span class="label">Last Login</span>
            <span class="value">2026-08-07</span>
          </div>

          <div class="account-info-box">
            <span class="label">Member Since</span>
            <span class="value">2022-03-20</span>
          </div>
        </div>

        <button type="button" class="settings-save-btn w3-button w3-round-large" id="saveSettingsBtn" onclick="saveEmployeeSettings()">
          <span>Save Settings</span>
        </button>
      </div>

    </div>

  </main>
</div>

<script>
  function saveEmployeeSettings() {
    var btn = document.getElementById('saveSettingsBtn');
    if (btn) {
      var originalText = btn.innerHTML;
      btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Settings Saved Successfully';
      btn.style.background = '#16a34a';
      setTimeout(function() {
        btn.innerHTML = originalText;
        btn.style.background = '#1e3a8a';
      }, 2200);
    }
  }
</script>
