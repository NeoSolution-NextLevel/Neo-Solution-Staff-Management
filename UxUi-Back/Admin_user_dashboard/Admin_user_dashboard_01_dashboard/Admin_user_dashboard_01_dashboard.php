<style>
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
    font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
  }

  *{ 
    box-sizing:border-box; 
    margin:0; 
    padding:0; 
  }

  body {
    background: var(--bg);
    color: var(--ink);
  }

  a { text-decoration:none; color:inherit; }

  /* ---------- Main Dashboard Wrapper ---------- */
  .main {
    flex: 1;
    min-width: 0;
    width: 100%;
    max-width: 100%;
    padding: 16px 20px 24px;
    display: flex;
    flex-direction: column;
  }

  /* ---------- Topbar Navigation Bar ---------- */
  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
  }

  .topbar-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .topbar-left h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    background: var(--blue-lighter);
    border: none;
    width: 38px;
    height: 38px;
    border-radius: 9px;
    cursor: pointer;
    color: var(--navy);
  }
  .menu-btn svg { width: 20px; height: 20px; }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .icon-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--blue-lighter);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
    transition: transform 0.2s, background 0.2s;
  }
  .icon-btn:hover {
    background: var(--blue-light);
    transform: translateY(-1px);
  }
  .icon-btn svg {
    width: 19px;
    height: 19px;
    color: var(--navy);
  }

  .dot {
    position: absolute;
    top: 7px;
    right: 8px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--red);
    border: 2px solid #ffffff;
  }

  .admin-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--blue-lighter);
    padding: 4px 14px 4px 5px;
    border-radius: 999px;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .admin-pill:hover {
    background: var(--blue-light);
    transform: translateY(-1px);
  }
  .admin-pill .avatar {
    width: 28px;
    height: 28px;
    font-size: 11.5px;
    background: var(--navy);
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
  }
  .admin-pill span {
    font-size: 13px;
    font-weight: 700;
    color: var(--navy);
  }

  @media (max-width: 768px) {
    .menu-btn { display: inline-flex !important; }
  }

  /* ---------- Welcome Banner (Same as Employees Dashboard) ---------- */
  .banner {
    position: relative;
    overflow: hidden;
    background: linear-gradient(120deg, var(--navy) 0%, var(--navy-2) 55%, #3648a0 100%);
    border-radius: var(--radius);
    padding: 18px 24px;
    color: #ffffff;
    margin-bottom: 16px;
    width: 100%;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .banner::before {
    content: "";
    position: absolute;
    top: -90px;
    right: -60px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.14), transparent 65%);
  }

  .banner::after {
    content: "";
    position: absolute;
    bottom: -120px;
    right: 120px;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.08), transparent 65%);
  }

  .banner .date {
    font-size: 13px;
    color: #c7d0f5;
    margin-bottom: 4px;
    position: relative;
    font-weight: 500;
  }

  .banner h3 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 4px;
    position: relative;
    letter-spacing: -0.2px;
  }

  .banner p {
    font-size: 13.5px;
    color: #cfd6f7;
    position: relative;
  }

  .banner-badge {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    font-size: 12.5px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 999px;
    backdrop-filter: blur(4px);
  }

  /* ---------- 5 Stat Cards (Same as Employees Dashboard) ---------- */
  .stats {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 16px;
    width: 100%;
    max-width: 100%;
  }

  .stat-card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 100%;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(20,25,60,0.08);
  }

  .stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .stat-icon svg {
    width: 19px;
    height: 19px;
  }

  .stat-icon.blue   { background: var(--blue-light); color: var(--blue); }
  .stat-icon.green  { background: var(--green-bg); color: var(--green); }
  .stat-icon.amber  { background: var(--amber-bg); color: var(--amber); }
  .stat-icon.navy   { background: var(--blue-light); color: var(--navy); }
  .stat-icon.red    { background: var(--red-bg); color: var(--red); }

  .stat-value {
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.1;
  }

  .stat-label {
    font-size: 12.5px;
    color: var(--muted);
    font-weight: 600;
    line-height: 1.3;
  }

  /* ---------- Content 3-Cards Row ---------- */
  .charts-row {
    display: grid;
    grid-template-columns: 1.15fr 1.15fr 1.55fr;
    gap: 16px;
    margin-bottom: 20px;
    width: 100%;
    max-width: 100%;
    align-items: stretch;
  }

  .card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    padding: 18px 18px;
    width: 100%;
    max-width: 100%;
    display: flex;
    flex-direction: column;
  }

  .card-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border);
    gap: 6px;
  }

  .card-header-row h4, .card h4 {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
    white-space: nowrap;
    letter-spacing: -0.01em;
  }

  .card-header-link {
    font-size: 11.5px;
    color: var(--blue);
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    flex-shrink: 0;
    transition: all 0.15s ease;
  }
  .card-header-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
  }

  /* Donut / Pie Chart */
  .donut-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    width: 100%;
  }

  .donut-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 8px 0 16px;
  }

  .donut {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: conic-gradient(
      var(--green) 0deg 120deg,
      var(--blue) 120deg 240deg,
      var(--amber) 240deg 360deg
    );
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(20,25,60,0.08);
    position: relative;
    transition: background 0.4s ease;
  }

  @keyframes spinDonut {
    0%   { transform: scale(0.92) rotate(-10deg); opacity: 0.3; }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
  }

  .donut.animate {
    animation: spinDonut 0.5s ease-out forwards;
  }

  .donut::after {
    content: "";
    position: absolute;
    width: 106px;
    height: 106px;
    border-radius: 50%;
    background: var(--card);
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.06);
  }

  .donut-center-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }

  .donut-total {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1;
  }

  .donut-sub {
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 3px;
  }

  .legend {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .legend-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13.5px;
    padding: 5px 8px;
    border-radius: 8px;
    transition: background 0.15s;
  }

  .legend-row:hover {
    background: var(--blue-lighter);
  }

  .legend-row .left {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #334155;
    font-weight: 600;
  }

  .legend-row .right {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .legend-row .val {
    font-weight: 800;
    color: var(--navy);
  }

  .legend-row .pct {
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
  }

  .swatch {
    width: 11px;
    height: 11px;
    border-radius: 3px;
    flex-shrink: 0;
  }

  .swatch.green { background: var(--green); }
  .swatch.blue  { background: var(--blue); }
  .swatch.amber { background: var(--amber); }

  /* Department Distribution */
  .dept-list-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
    overflow-y: auto;
    max-height: 320px;
    padding-right: 4px;
  }

  .dept-row {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .dept-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
  }

  .dept-count-pill {
    background: var(--blue-light);
    color: var(--blue);
    font-size: 11.5px;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 999px;
  }

  .progress-track {
    height: 7px;
    background: #edf2f7;
    border-radius: 999px;
    overflow: hidden;
  }

  .progress-fill {
    height: 100%;
    border-radius: 999px;
    background: var(--blue);
    transition: width 0.4s ease;
  }

  /* Recent Activities */
  .activities-list-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
    overflow-y: auto;
    max-height: 320px;
    padding-right: 4px;
  }

  .activity-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
    cursor: pointer;
  }

  .activity-item:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    transform: translateX(3px);
  }

  .activity-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 13.5px;
  }

  .activity-icon.blue   { background: #dbeafe !important; color: #2563eb !important; }
  .activity-icon.green  { background: #dcfce7 !important; color: #16a34a !important; }
  .activity-icon.amber  { background: #fef3c7 !important; color: #d97706 !important; }
  .activity-icon.navy   { background: #e0e7ff !important; color: #1e3a8a !important; }
  .activity-icon.red    { background: #fee2e2 !important; color: #dc2626 !important; }

  .activity-text {
    flex: 1;
    min-width: 0;
  }

  .activity-text p {
    font-size: 13px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .activity-text span {
    font-size: 11px;
    color: var(--muted);
  }

  /* Custom Slim Scrollbars */
  .dept-list-container::-webkit-scrollbar,
  .activities-list-container::-webkit-scrollbar {
    width: 5px;
  }
  .dept-list-container::-webkit-scrollbar-thumb,
  .activities-list-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 5px;
  }

  .active-members-card { margin-bottom: 20px; }
  .active-members-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 10px; }
  .active-member-row { display:flex; align-items:center; gap:10px; padding:10px; border:1px solid var(--border); border-radius:10px; background:#f8fafc; }
  .active-member-avatar { width:36px; height:36px; border-radius:50%; background:var(--green-bg); color:var(--green); display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0; overflow:hidden; }
  .active-member-avatar img { width:100%; height:100%; object-fit:cover; }
  .active-member-info { flex:1; min-width:0; }
  .active-member-info strong, .active-member-info span { display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .active-member-info strong { font-size:13px; color:var(--ink); }
  .active-member-info span { font-size:11px; color:var(--muted); }
  .active-member-view { border:0; background:var(--blue-light); color:var(--blue); border-radius:7px; padding:6px 8px; cursor:pointer; font-size:11px; font-weight:700; }
  .daily-plans-card { margin-bottom:20px; }
  .daily-plans-table-wrap { overflow-x:auto; }
  .daily-plans-table { width:100%; border-collapse:collapse; font-size:12.5px; }
  .daily-plans-table th { text-align:left; color:var(--muted); font-size:11px; text-transform:uppercase; padding:9px 8px; border-bottom:1px solid var(--border); }
  .daily-plans-table td { padding:10px 8px; border-bottom:1px solid #f1f5f9; vertical-align:top; }
  .daily-plans-table .plan-name { font-weight:800; color:var(--ink); }
  .daily-plans-table .plan-dept { color:var(--muted); font-size:11px; margin-top:2px; }
  .plan-status { display:inline-block; border-radius:999px; padding:4px 9px; font-size:11px; font-weight:700; background:#eff6ff; color:#2563eb; white-space:nowrap; }
  .plan-status.active { background:#dcfce7; color:#15803d; }
  .plan-profile-btn { border:0; background:transparent; color:var(--blue); font-weight:700; cursor:pointer; }

  /* ---------- Responsive ---------- */
  @media (max-width: 1200px) {
    .stats {
      grid-template-columns: repeat(3, 1fr);
    }
    .charts-row {
      grid-template-columns: 1fr 1fr;
    }
    .card:last-child {
      grid-column: span 2;
    }
  }

  @media (max-width: 768px) {
    .stats {
      grid-template-columns: repeat(2, 1fr);
    }
    .charts-row {
      grid-template-columns: 1fr;
    }
    .card:last-child {
      grid-column: span 1;
    }
  }
</style>

<div id="Admin_user_dashboard_01">

  <main class="main">

    <!-- 0. Top Navigation Bar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_01" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Dashboard</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="Admin_user_dashboard_09_OPEN();" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill" onclick="Admin_user_dashboard_10_OPEN();" title="Profile & Settings">
          <div class="avatar">AU</div>
          <span>Admin</span>
        </div>
      </div>
    </div>

    <!-- 1. Welcome Banner -->
    <section class="banner">
      <div>
        <div class="date"><?php echo date('l, F j, Y'); ?></div>
        <h3>Welcome back, Admin</h3>
        <p>Manage your staff, monitor daily workloads & department operations.</p>
      </div>
      <div class="banner-badge">
        <i class="fa-solid fa-circle-check" style="color: #4ade80; margin-right: 6px;"></i>System Active
      </div>
    </section>

    <!-- 2. 5 KPI Stat Cards (Same scale as Employees Dashboard) -->
    <section class="stats">
      <!-- Total Staff -> Employees -->
      <div class="stat-card" onclick="if(typeof Admin_user_dashboard_02_OPEN === 'function') Admin_user_dashboard_02_OPEN();" title="View Employees" style="cursor: pointer;">
        <div class="stat-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-value" id="kpiTotalEmployees">0</div>
        <div class="stat-label">Total Staff</div>
      </div>

      <!-- Active Staff -> Employees -->
      <div class="stat-card" onclick="if(typeof Admin_user_dashboard_02_OPEN === 'function') Admin_user_dashboard_02_OPEN();" title="View Active Staff" style="cursor: pointer;">
        <div class="stat-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-10 10-3-3"/>
          </svg>
        </div>
        <div class="stat-value" id="kpiActiveEmployees">0</div>
        <div class="stat-label">Active Today</div>
      </div>

      <!-- Pending Tasks -> Task Management -->
      <div class="stat-card" onclick="if(typeof Admin_user_dashboard_07_OPEN === 'function') Admin_user_dashboard_07_OPEN();" title="View Tasks" style="cursor: pointer;">
        <div class="stat-icon amber">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <div class="stat-value" id="kpiPendingTasks">0</div>
        <div class="stat-label">Pending Tasks</div>
      </div>

      <!-- Completed Tasks -> Task Management -->
      <div class="stat-card" onclick="if(typeof Admin_user_dashboard_07_OPEN === 'function') Admin_user_dashboard_07_OPEN();" title="View Completed Tasks" style="cursor: pointer;">
        <div class="stat-icon navy">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="m9 12 2 2 4-4"/>
          </svg>
        </div>
        <div class="stat-value" id="kpiCompletedTasks">0</div>
        <div class="stat-label">Completed Tasks</div>
      </div>

      <!-- Pending Leaves -> Leave Requests -->
      <div class="stat-card" onclick="if(typeof Admin_user_dashboard_08_OPEN === 'function') Admin_user_dashboard_08_OPEN();" title="View Leave Requests" style="cursor: pointer;">
        <div class="stat-icon red">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/>
          </svg>
        </div>
        <div class="stat-value" id="kpiPendingLeaves">0</div>
        <div class="stat-label">Pending Leaves</div>
      </div>
    </section>

    <!-- 3. Core Visual Cards Row (Pie Chart, Departments, Activities) -->
    <section class="charts-row">

      <!-- Column 1: Task Status Pie / Donut Chart -->
      <div class="card">
        <div class="card-header-row">
          <h4>Task Status Overview</h4>
          <span class="card-header-link" onclick="if(typeof Admin_user_dashboard_07_OPEN==='function') Admin_user_dashboard_07_OPEN();">View All &rarr;</span>
        </div>
        <div class="donut-wrap">
          <div class="donut-container">
            <div class="donut animate" id="donutChart">
              <div class="donut-center-content">
                <span class="donut-total" id="donutTotalTasks">0</span>
                <span class="donut-sub">Total Tasks</span>
              </div>
            </div>
          </div>
          <div class="legend" id="donutLegend">
            <div class="legend-row">
              <div class="left"><span class="swatch green"></span>Completed</div>
              <div class="right"><span class="val" id="legendCompleted">0</span> <span class="pct" id="legendCompletedPct">(0%)</span></div>
            </div>
            <div class="legend-row">
              <div class="left"><span class="swatch blue"></span>In Progress</div>
              <div class="right"><span class="val" id="legendInProgress">0</span> <span class="pct" id="legendInProgressPct">(0%)</span></div>
            </div>
            <div class="legend-row">
              <div class="left"><span class="swatch amber"></span>Pending</div>
              <div class="right"><span class="val" id="legendPending">0</span> <span class="pct" id="legendPendingPct">(0%)</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Column 2: Department Distribution -->
      <div class="card">
        <div class="card-header-row">
          <h4>Department Distribution</h4>
          <span class="card-header-link" onclick="if(typeof Admin_user_dashboard_05_OPEN==='function') Admin_user_dashboard_05_OPEN();">View All &rarr;</span>
        </div>
        <div class="dept-list-container" id="deptList">
          <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px;">Loading departments...</div>
        </div>
      </div>

      <!-- Column 3: Recent Activities -->
      <div class="card">
        <div class="card-header-row">
          <h4>Recent System Activities</h4>
          <span class="card-header-link" onclick="if(typeof Admin_user_dashboard_09_OPEN==='function') Admin_user_dashboard_09_OPEN();">View All &rarr;</span>
        </div>
        <div class="activities-list-container" id="dashboardActivitiesList">
          <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px;">Loading recent activities...</div>
        </div>
      </div>

    </section>

    <section class="card active-members-card">
      <div class="card-header-row">
        <h4>Active Members Today</h4>
        <span class="card-header-link" id="activeMembersDate">Loading...</span>
      </div>
      <div class="active-members-list" id="activeMembersList">
        <div style="padding: 12px; color:#94a3b8; font-size:13px;">Loading active members...</div>
      </div>
    </section>

    <section class="card daily-plans-card">
      <div class="card-header-row">
        <h4>Today’s Daily Work Plans</h4>
        <span class="card-header-link">Employee submissions</span>
      </div>
      <div class="daily-plans-table-wrap" id="dailyWorkPlansList">
        <div style="padding:12px; color:#94a3b8; font-size:13px;">Loading daily work plans...</div>
      </div>
    </section>

  </main>

</div>
