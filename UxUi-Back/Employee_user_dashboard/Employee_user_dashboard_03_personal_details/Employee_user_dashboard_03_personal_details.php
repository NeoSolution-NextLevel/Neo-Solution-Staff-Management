<style>
  /* =========================================================
     EMPLOYEE PERSONAL DETAILS (CREATIVE, BENTO GRID DESIGN)
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
    margin-bottom: 16px;
  }

  .emp-pd-topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .emp-pd-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .emp-pd-menu-btn {
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
  .emp-pd-menu-btn svg { width: 20px; height: 20px; }

  /* Page Header Title */
  .pd-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .pd-page-header p {
    font-size: 14px;
    color: var(--muted);
    margin: 4px 0 0;
    font-weight: 500;
  }

  .btn-pd-edit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    color: var(--navy);
    border: 1px solid var(--border);
    padding: 9px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(20,25,60,0.05);
  }
  .btn-pd-edit:hover {
    background: var(--blue-lighter);
    color: var(--blue);
    border-color: var(--blue-light);
    transform: translateY(-1px);
  }

  /* Creative Bento Grid Cards */
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
    box-shadow: 0 1px 3px rgba(20,25,60,0.04);
    padding: 22px 24px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .pd-bento-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(20,25,60,0.08);
  }

  .pd-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 14px;
  }

  .pd-card-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .pd-card-icon.blue { background: #eff6ff; color: #2563eb; }
  .pd-card-icon.emerald { background: #ecfdf5; color: #059669; }
  .pd-card-icon.purple { background: #f5f3ff; color: #7c3aed; }
  .pd-card-icon.amber { background: #fef3c7; color: #d97706; }

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

  .pd-item-box {
    background: #f8fafc;
    border: 1px solid #eef2f6;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    flex-direction: column;
    gap: 3px;
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
  }

  .pd-val {
    font-size: 13.5px;
    font-weight: 700;
    color: #1e293b;
    word-break: break-word;
  }

  @media (max-width: 768px) {
    .emp-pd-menu-btn { display: inline-flex !important; }
    .emp-pd-topbar h2 { font-size: 18px !important; }
    .pd-bento-grid { grid-template-columns: 1fr !important; gap: 14px; }
    .pd-item-list { grid-template-columns: 1fr !important; }
    .btn-pd-edit { width: 100%; justify-content: center; }
  }
</style>

<div id="Employee_user_dashboard_03_personal_details" class="emp-main" style="padding:0;">
  <div class="emp-pd-container">
    
    <!-- Topbar Navigation -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_emp_03" aria-label="Open menu" onclick="typeof openEmployeeSidebar === 'function' ? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Personal Details</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="topAvatarPdPreview">AP</div>
          <span id="topEmpPdName">Amal Perera</span>
        </div>
      </div>
    </div>

    <!-- Page Header Title & Edit Trigger -->
    <div class="pd-page-header">
      <div>
        <p>Official employee personal, contact, and employment information</p>
      </div>
      <button type="button" class="btn-pd-edit" onclick="if(typeof openEditProfileModal === 'function') openEditProfileModal(); else Employee_user_dashboard_02_OPEN();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <span>Edit Details</span>
      </button>
    </div>

    <!-- Creative Bento Grid Cards -->
    <div class="pd-bento-grid">
      
      <!-- Card 1: Identity & Demographics -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon blue">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Identity & Demographics</h3>
            <p class="pd-card-subtitle">Official identification data</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box full-width">
            <span class="pd-label">Full Legal Name</span>
            <span class="pd-val" id="pdFullName">Amal Perera</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">NIC / Passport No</span>
            <span class="pd-val" id="pdNic">199512345678</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Date of Birth</span>
            <span class="pd-val" id="pdDob">1995-05-14</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Gender</span>
            <span class="pd-val" id="pdGender">Male</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Nationality</span>
            <span class="pd-val">Sri Lankan</span>
          </div>
        </div>
      </div>

      <!-- Card 2: Contact & Address -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon emerald">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Contact & Residence</h3>
            <p class="pd-card-subtitle">Communication channels & address</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box full-width">
            <span class="pd-label">Official Work Email</span>
            <span class="pd-val" id="pdEmail">amal.perera@neosolution.com</span>
          </div>
          <div class="pd-item-box full-width">
            <span class="pd-label">Primary Mobile Phone</span>
            <span class="pd-val" id="pdPhone">+94 77 123 4567</span>
          </div>
          <div class="pd-item-box full-width">
            <span class="pd-label">Residential Address</span>
            <span class="pd-val" id="pdAddress">No. 45, Galle Road, Colombo 03, Sri Lanka</span>
          </div>
        </div>
      </div>

      <!-- Card 3: Emergency Contacts -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon amber">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Emergency Contact</h3>
            <p class="pd-card-subtitle">Next of kin emergency details</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box full-width">
            <span class="pd-label">Emergency Contact Person</span>
            <span class="pd-val" id="pdEmName">Nimal Perera (Father)</span>
          </div>
          <div class="pd-item-box full-width">
            <span class="pd-label">Emergency Contact Phone</span>
            <span class="pd-val" id="pdEmPhone">+94 71 987 6543</span>
          </div>
        </div>
      </div>

      <!-- Card 4: Employment Snapshot -->
      <div class="pd-bento-card">
        <div class="pd-card-header">
          <div class="pd-card-icon purple">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
          </div>
          <div>
            <h3 class="pd-card-title">Company Position</h3>
            <p class="pd-card-subtitle">Organizational placement</p>
          </div>
        </div>

        <div class="pd-item-list">
          <div class="pd-item-box">
            <span class="pd-label">Employee Code</span>
            <span class="pd-val" id="pdEmpCode">EMP-002</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Department</span>
            <span class="pd-val" id="pdDept">Engineering</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Job Title</span>
            <span class="pd-val" id="pdJobTitle">Senior Software Engineer</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Work Location</span>
            <span class="pd-val" id="pdLocation">Colombo HQ</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Joining Date</span>
            <span class="pd-val" id="pdJoinDate">2024-01-15</span>
          </div>
          <div class="pd-item-box">
            <span class="pd-label">Employment Type</span>
            <span class="pd-val" id="pdEmpType">Full-Time (Permanent)</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
(function () {
  window.fetchPersonalDetails = function () {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          const p = res.data;
          const name = p.full_name || 'Amal Perera';
          const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();

          const el = id => document.getElementById(id);
          if (el('pdFullName')) el('pdFullName').textContent = name;
          if (el('topEmpPdName')) el('topEmpPdName').textContent = name;
          if (el('pdNic')) el('pdNic').textContent = p.nic || '—';
          if (el('pdDob')) el('pdDob').textContent = p.dob || '—';
          if (el('pdGender')) el('pdGender').textContent = p.gender || '—';
          if (el('pdEmail')) el('pdEmail').textContent = p.email || '—';
          if (el('pdPhone')) el('pdPhone').textContent = p.phone || '—';
          if (el('pdAddress')) el('pdAddress').textContent = p.address || '—';
          if (el('pdEmName')) el('pdEmName').textContent = p.emergency_contact_name || '—';
          if (el('pdEmPhone')) el('pdEmPhone').textContent = p.emergency_contact_phone || '—';
          if (el('pdEmpCode')) el('pdEmpCode').textContent = p.employee_id_code || 'EMP-002';
          if (el('pdDept')) el('pdDept').textContent = p.department || 'Engineering';
          if (el('pdJobTitle')) el('pdJobTitle').textContent = p.job_title || 'Senior Software Engineer';
          if (el('pdLocation')) el('pdLocation').textContent = p.work_location || 'Colombo HQ';
          if (el('pdJoinDate')) el('pdJoinDate').textContent = p.join_date || '2024-01-15';
          if (el('pdEmpType')) el('pdEmpType').textContent = p.employment_type || 'Full-Time (Permanent)';

          const topAvatar = el('topAvatarPdPreview');
          if (topAvatar) {
            if (p.profile_pic && p.profile_pic.trim() !== '') {
              const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + p.profile_pic;
              topAvatar.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
            } else {
              topAvatar.textContent = initials;
            }
          }
        }
      })
      .catch(() => {});
  };

  window.fetchPersonalDetails();
})();
</script>
