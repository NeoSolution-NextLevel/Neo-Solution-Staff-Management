<style>
  /* =========================================================
     JOB INFORMATION (PERFECT ALIGNMENT & RESPONSIVE)
  ========================================================= */
  #Employee_user_dashboard_06_job_information {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  .job-info-container {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* Topbar */
  .job-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .job-topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .job-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .job-menu-btn {
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
  .job-menu-btn svg { width: 20px; height: 20px; }

  /* Page Header Title */
  .job-page-head {
    margin-bottom: 20px;
  }

  .job-page-head h1 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 4px 0;
    letter-spacing: -0.3px;
  }

  .job-page-head p {
    font-size: 14px;
    color: var(--muted);
    margin: 0;
    font-weight: 500;
  }

  /* 6 Information Cards Grid */
  .job-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px 20px;
    margin-bottom: 24px;
    width: 100%;
  }

  .job-stat-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 18px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-sizing: border-box;
    width: 100%;
  }

  .job-stat-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(20, 25, 60, 0.06);
  }

  .job-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }

  .job-stat-icon.blue { background: #eff6ff; color: #2563eb; }
  .job-stat-icon.cyan { background: #ecfeff; color: #0891b2; }
  .job-stat-icon.amber { background: #fffbeb; color: #d97706; }
  .job-stat-icon.red { background: #fef2f2; color: #dc2626; }
  .job-stat-icon.green { background: #f0fdf4; color: #16a34a; }
  .job-stat-icon.purple { background: #faf5ff; color: #9333ea; }

  .job-stat-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .job-stat-content .label {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .job-stat-content .value {
    font-size: 15.5px;
    font-weight: 700;
    color: #1e293b;
    word-break: break-word;
  }

  /* Career Timeline Card */
  .timeline-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 24px 28px;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 24px;
  }

  .timeline-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: #1e293b;
    margin: 0 0 20px 0;
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
    padding-bottom: 24px;
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
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 3px;
  }

  .timeline-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 3px;
  }

  .timeline-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.4;
  }

  /* Responsive Breakpoints */
  @media (max-width: 768px) {
    .job-menu-btn { display: inline-flex !important; }
    .job-topbar h2 { font-size: 18px !important; }
    .job-info-grid { grid-template-columns: 1fr !important; gap: 12px; }
    .job-stat-box { padding: 16px 18px; }
    .timeline-card { padding: 18px 16px; }
  }
</style>

<div id="Employee_user_dashboard_06_job_information" class="emp-main" style="display:none; padding:0;">
  <div class="job-info-container">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_06" aria-label="Open menu" onclick="typeof openEmployeeSidebar === 'function' ? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Job Information</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>

        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="topAvatarJobPreview">AP</div>
          <span id="topEmpJobName">Amal Perera</span>
        </div>
      </div>
    </div>

    <!-- Page Head -->
    <div class="job-page-head">
      <p>Your employment details and position information</p>
    </div>

    <!-- 6 Information Cards Grid -->
    <div class="job-info-grid">

      <!-- 1. Employee ID -->
      <div class="job-stat-box">
        <div class="job-stat-icon blue">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="16" rx="2"/>
            <line x1="7" y1="8" x2="17" y2="8"/>
            <line x1="7" y1="12" x2="13" y2="12"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Employee ID</span>
          <span class="value" id="jobEmpId">EMP-001</span>
        </div>
      </div>

      <!-- 2. Department -->
      <div class="job-stat-box">
        <div class="job-stat-icon cyan">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
            <line x1="9" y1="22" x2="9" y2="22.01"/>
            <line x1="15" y1="22" x2="15" y2="22.01"/>
            <line x1="9" y1="6" x2="9" y2="6.01"/>
            <line x1="15" y1="6" x2="15" y2="6.01"/>
            <line x1="9" y1="10" x2="9" y2="10.01"/>
            <line x1="15" y1="10" x2="15" y2="10.01"/>
            <line x1="9" y1="14" x2="9" y2="14.01"/>
            <line x1="15" y1="14" x2="15" y2="14.01"/>
            <line x1="9" y1="18" x2="9" y2="18.01"/>
            <line x1="15" y1="18" x2="15" y2="18.01"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Department</span>
          <span class="value" id="jobDept">—</span>
        </div>
      </div>

      <!-- 3. Job Role -->
      <div class="job-stat-box">
        <div class="job-stat-icon amber">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Job Role</span>
          <span class="value" id="jobRole">—</span>
        </div>
      </div>

      <!-- 4. Joining Date -->
      <div class="job-stat-box">
        <div class="job-stat-icon red">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Joining Date</span>
          <span class="value" id="jobJoined">—</span>
        </div>
      </div>

      <!-- 5. Employment Status -->
      <div class="job-stat-box">
        <div class="job-stat-icon green">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14 9 11"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Employment Status</span>
          <span class="value" id="jobStatus" style="color: #16a34a;">Active</span>
        </div>
      </div>

      <!-- 6. Work Email -->
      <div class="job-stat-box">
        <div class="job-stat-icon purple">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Work Email</span>
          <span class="value" id="jobEmail">—</span>
        </div>
      </div>

    </div>

    <!-- Career Timeline Card (Full Width) -->
    <div class="timeline-card">
      <h3>Career Timeline</h3>

      <div class="timeline-list">
        
        <!-- Event 1 -->
        <div class="timeline-item">
          <div class="timeline-dot filled"></div>
          <div class="timeline-date" id="timelineJoinDate">2024-01-15</div>
          <div class="timeline-title">Joined Organization</div>
          <div class="timeline-desc" id="timelineJoinDesc">Joined as Senior Software Engineer in Engineering department</div>
        </div>

        <!-- Event 2 -->
        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-date">2024-06-01</div>
          <div class="timeline-title">Probation Completed</div>
          <div class="timeline-desc">Successfully completed initial review period with exemplary performance</div>
        </div>

        <!-- Event 3 -->
        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-date">Current</div>
          <div class="timeline-title">Active Full-Time Staff</div>
          <div class="timeline-desc" id="timelineActiveDesc">Active member of Engineering team</div>
        </div>

      </div>
    </div>

  </div>
</div>

<script>
(function () {
  window.fetchJobInformation = function () {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          const p = res.data;
          const name = p.full_name || '';
          const dept = p.department || '—';
          const role = p.job_title || '—';
          const joined = p.join_date || '—';
          const email = p.email || '—';
          const empId = p.employee_id_code || 'EMP-001';
          const initials = name ? name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'EM';

          const el = id => document.getElementById(id);
          if (el('jobEmpId')) el('jobEmpId').textContent = empId;
          if (el('jobDept')) el('jobDept').textContent = dept;
          if (el('jobRole')) el('jobRole').textContent = role;
          if (el('jobJoined')) el('jobJoined').textContent = joined;
          if (el('jobEmail')) el('jobEmail').textContent = email;
          if (el('topEmpJobName')) el('topEmpJobName').textContent = name;
          if (el('timelineJoinDate')) el('timelineJoinDate').textContent = joined;
          if (el('timelineJoinDesc')) el('timelineJoinDesc').textContent = `Joined as ${role} in ${dept} department`;
          if (el('timelineActiveDesc')) el('timelineActiveDesc').textContent = `Active member of ${dept} team`;

          const topAvatar = el('topAvatarJobPreview');
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

  window.fetchJobInformation();
})();
</script>
