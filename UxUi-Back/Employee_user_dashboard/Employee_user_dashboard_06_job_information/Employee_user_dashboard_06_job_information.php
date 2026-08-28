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
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #14204d;
    flex-shrink: 0;
    transition: all 0.2s ease;
  }

  .job-stat-box:hover .job-stat-icon {
    background: #eff6ff;
    color: #2563eb;
    border-color: #dbeafe;
  }

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
          <div class="avatar" id="topAvatarJobPreview">--</div>
          <span id="topEmpJobName">Loading...</span>
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
        <div class="job-stat-icon">
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
        <div class="job-stat-icon">
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
        <div class="job-stat-icon">
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
        <div class="job-stat-icon">
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

      <!-- 5. Probation Status -->
      <div class="job-stat-box">
        <div class="job-stat-icon">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Probation Period</span>
          <span class="value" id="jobProbationStatus">In Progress</span>
        </div>
      </div>

      <!-- 6. Work Location -->
      <div class="job-stat-box">
        <div class="job-stat-icon">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
        </div>
        <div class="job-stat-content">
          <span class="label">Work Location</span>
          <span class="value" id="jobLocation">Colombo HQ</span>
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
          <div class="timeline-date" id="timelineJoinDate">—</div>
          <div class="timeline-title">Joined Organization</div>
          <div class="timeline-desc" id="timelineJoinDesc">Joined as staff member</div>
        </div>

        <!-- Event 2 (Dynamic Probation) -->
        <div class="timeline-item">
          <div class="timeline-dot" id="timelineProbationDot"></div>
          <div class="timeline-date" id="timelineProbationDate">—</div>
          <div class="timeline-title" id="timelineProbationTitle">Probation Period Review</div>
          <div class="timeline-desc" id="timelineProbationDesc">15 days probation review and confirmation</div>
        </div>

        <!-- Event 3 -->
        <div class="timeline-item">
          <div class="timeline-dot filled" style="background:#2563eb; border-color:#2563eb;"></div>
          <div class="timeline-date">Current Position</div>
          <div class="timeline-title" id="timelineActiveTitle">Active Staff Member</div>
          <div class="timeline-desc" id="timelineActiveDesc">Active contributing member</div>
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
          const dept = p.department || 'General';
          const role = p.job_title || 'Staff';
          const joined = p.join_date || '—';
          const email = p.email || '—';
          const location = p.work_location || 'Colombo HQ';
          const empType = p.employment_type || 'Full-Time';
          const empId = p.employee_id_code || 'EMP-001';
          const initials = name ? name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'EM';

          const el = id => document.getElementById(id);
          if (el('jobEmpId')) el('jobEmpId').textContent = empId;
          if (el('jobDept')) el('jobDept').textContent = dept;
          if (el('jobRole')) el('jobRole').textContent = role;
          if (el('jobJoined')) el('jobJoined').textContent = joined;
          if (el('jobLocation')) el('jobLocation').textContent = location;
          if (el('topEmpJobName')) el('topEmpJobName').textContent = name;
          
          // 1. Official Appointment / Join Date
          const officialStart = p.official_start_date || joined || '—';
          if (el('timelineJoinDate')) el('timelineJoinDate').textContent = officialStart;
          if (el('timelineJoinDesc')) el('timelineJoinDesc').textContent = `Official appointment as ${role} in ${dept} department.`;

          // 2. Current Position
          if (el('timelineActiveTitle')) el('timelineActiveTitle').textContent = `Current Position (${empType})`;
          if (el('timelineActiveDesc')) el('timelineActiveDesc').textContent = `Active member of ${dept} team at ${location} (${role}).`;

          // 3. Dynamic Probation Review Milestones
          const probStatus = p.probation_status || 'In Progress';
          const probStart = p.probation_start_date || joined || '';
          const probEnd = p.probation_end_date || '';

          if (el('jobProbationStatus')) {
            el('jobProbationStatus').textContent = probStatus;
            el('jobProbationStatus').style.color = probStatus.toLowerCase().includes('completed') || probStatus.toLowerCase().includes('confirmed') ? '#16a34a' : '#2563eb';
          }

          if (probEnd) {
            if (el('timelineProbationDate')) el('timelineProbationDate').textContent = probEnd;
            if (el('timelineProbationTitle')) el('timelineProbationTitle').textContent = `Probation Review (${probStatus})`;
            if (el('timelineProbationDesc')) {
              el('timelineProbationDesc').textContent = probStart ? `Probation evaluation scheduled from ${probStart} to ${probEnd}.` : `Probation evaluation target date: ${probEnd}.`;
            }
            if (el('timelineProbationDot')) {
              el('timelineProbationDot').className = probStatus.toLowerCase().includes('completed') || probStatus.toLowerCase().includes('confirmed') ? 'timeline-dot filled' : 'timeline-dot';
            }
          } else if (joined && joined !== '—') {
            const joinD = new Date(joined);
            if (!isNaN(joinD.getTime())) {
              const probD = new Date(joinD);
              probD.setMonth(probD.getMonth() + 6);
              const probStr = probD.toISOString().split('T')[0];
              const now = new Date();

              if (now < probD) {
                if (el('timelineProbationDate')) el('timelineProbationDate').textContent = probStr;
                if (el('timelineProbationTitle')) el('timelineProbationTitle').textContent = 'Probation Review (Scheduled)';
                if (el('timelineProbationDesc')) el('timelineProbationDesc').textContent = `Performance evaluation scheduled on ${probStr}.`;
                if (el('timelineProbationDot')) el('timelineProbationDot').className = 'timeline-dot';
              } else {
                if (el('timelineProbationDate')) el('timelineProbationDate').textContent = probStr;
                if (el('timelineProbationTitle')) el('timelineProbationTitle').textContent = 'Probation Completed & Confirmed';
                if (el('timelineProbationDesc')) el('timelineProbationDesc').textContent = `Successfully completed review period on ${probStr} with confirmation.`;
                if (el('timelineProbationDot')) el('timelineProbationDot').className = 'timeline-dot filled';
              }
            }
          }

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

  window.fetchJobInformation = fetchJobInformation;
  fetchJobInformation();
})();
</script>
