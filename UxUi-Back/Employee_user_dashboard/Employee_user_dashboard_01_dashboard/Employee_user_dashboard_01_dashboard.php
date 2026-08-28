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

  *{ box-sizing:border-box; margin:0; padding:0; }


  /* ---------- Welcome banner ---------- */
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
    margin-bottom: 6px;
    position: relative;
    letter-spacing: -0.2px;
  }

  .banner p {
    font-size: 13.5px;
    color: #cfd6f7;
    position: relative;
  }

  .banner-progress-wrap {
    position: relative;
    margin-top: 14px;
    padding-top: 10px;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
  }

  .banner-progress-head {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    font-weight: 600;
    color: #dbe4ff;
    margin-bottom: 6px;
  }

  .banner-progress-track {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.22);
    border-radius: 999px;
    overflow: hidden;
  }

  .banner-progress-fill {
    height: 100%;
    width: 0%;
    background: #ffffff;
    border-radius: 999px;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
    transition: width 0.5s ease;
  }

  /* ---------- Stat cards (4 Equal Columns Spanning Full Width) ---------- */
  .stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
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
    transition: transform 0.2s ease;
  }

  .stat-card:hover {
    transform: translateY(-2px);
  }

  .stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .stat-icon svg {
    width: 19px;
    height: 19px;
  }

  .stat-icon.blue {
    background: var(--blue-light);
    color: var(--blue);
  }

  .stat-icon.green {
    background: var(--green-bg);
    color: var(--green);
  }

  .stat-icon.amber {
    background: var(--amber-bg);
    color: var(--amber);
  }

  .stat-icon.navy {
    background: var(--blue-light);
    color: var(--navy);
  }

  .stat-icon.red {
    background: var(--red-bg);
    color: var(--red);
  }

  .stat-value {
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
  }

  .stat-label {
    font-size: 12.5px;
    color: var(--muted);
    font-weight: 600;
    line-height: 1.3;
  }

  /* ---------- Content row ---------- */
  .charts-row {
    display: grid;
    grid-template-columns: 1.65fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
    width: 100%;
    max-width: 100%;
  }

  .card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    padding: 16px 18px;
    width: 100%;
    max-width: 100%;
  }

  .card-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
  }

  .card-header-row h4, .card h4 {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
  }

  .activity-item {
    display: flex;
    gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
    align-items: center;
  }

  .activity-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .activity-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
  }

  .activity-icon.green {
    background: var(--green-bg);
    color: var(--green);
  }

  .activity-icon.blue {
    background: var(--blue-light);
    color: var(--blue);
  }

  .activity-icon.amber {
    background: var(--amber-bg);
    color: var(--amber);
  }

  .activity-icon.red {
    background: var(--red-bg);
    color: var(--red);
  }

  .activity-text p {
    font-size: 13.5px;
    color: var(--ink);
    font-weight: 600;
    line-height: 1.3;
  }

  .activity-text span {
    font-size: 12px;
    color: var(--muted);
  }

  @media (max-width: 1300px) {
    .charts-row {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 1024px) {
    .stats {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
  }

  @media (max-width: 600px) {
    .stats {
      grid-template-columns: 1fr;
      gap: 10px;
    }
    .charts-row {
      grid-template-columns: 1fr;
      gap: 14px;
    }
  }
</style>

<div id="Employee_user_dashboard_01">

  <div class="overlay" id="overlay"></div>

  <!-- ================= MAIN ================= -->
  <main class="main">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_01" aria-label="Open menu" onclick="typeof openEmployeeSidebar==='function'? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Dashboard</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="Employee_user_dashboard_09_OPEN();" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>

        <div class="admin-pill" onclick="if(typeof Employee_user_dashboard_02_OPEN==='function'){ Employee_user_dashboard_02_OPEN(); }">
          <div class="avatar" id="dashTopAvatar">AP</div>
          <span id="dashTopEmpName">Amal</span>
        </div>
      </div>
    </div>

    <!-- Welcome Banner -->
    <section class="banner">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; position: relative; flex-wrap: wrap; gap: 8px;">
        <div class="date"><?php echo date('l, F j, Y'); ?></div>
        <div style="display: flex; gap: 8px; align-items: center;">
          <span id="dashEmpCode" style="background: rgba(255, 255, 255, 0.16); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 3px 12px; border-radius: 999px;">EMP-002</span>
          <span id="dashEmpDept" style="background: rgba(255, 255, 255, 0.16); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 3px 12px; border-radius: 999px;">Engineering</span>
        </div>
      </div>

      <h3 id="dashWelcomeTitle" style="margin:0 0 4px 0;">Welcome back, Amal</h3>
      <p id="dashWelcomeSubtitle" style="margin:0;">Here's your work overview for today.</p>
    </section>

    <!-- 4 Stat Cards (Clickable Navigation) -->
    <section class="stats">
      <!-- Today's Tasks -> Daily Work Plan -->
      <div class="stat-card" onclick="if(typeof Employee_user_dashboard_07_OPEN==='function') Employee_user_dashboard_07_OPEN();" title="View Today's Tasks" style="cursor: pointer;">
        <div class="stat-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 11 12 14 22 4"></polyline>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
          </svg>
        </div>
        <div class="stat-value" id="kpiTodayTasks">0</div>
        <div class="stat-label">Today's Tasks</div>
      </div>

      <!-- Pending Tasks -> Daily Work Plan -->
      <div class="stat-card" onclick="if(typeof Employee_user_dashboard_07_OPEN==='function') Employee_user_dashboard_07_OPEN();" title="View Pending Tasks" style="cursor: pointer;">
        <div class="stat-icon amber">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
        </div>
        <div class="stat-value" id="kpiPendingTasks">0</div>
        <div class="stat-label">Pending Tasks</div>
      </div>

      <!-- Completed Tasks -> Daily Work Plan -->
      <div class="stat-card" onclick="if(typeof Employee_user_dashboard_07_OPEN==='function') Employee_user_dashboard_07_OPEN();" title="View Completed Tasks" style="cursor: pointer;">
        <div class="stat-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14 9 11"></polyline>
          </svg>
        </div>
        <div class="stat-value" id="kpiCompletedTasks">0</div>
        <div class="stat-label">Completed</div>
      </div>

      <!-- Leave Requests -> Leave Request Tab -->
      <div class="stat-card" onclick="if(typeof Employee_user_dashboard_08_OPEN==='function') Employee_user_dashboard_08_OPEN();" title="View Leave Requests" style="cursor: pointer;">
        <div class="stat-icon navy">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
          </svg>
        </div>
        <div class="stat-value" id="kpiLeaveRequests">0</div>
        <div class="stat-label">Leave Requests</div>
      </div>
    </section>

    <!-- Content Row: 2 Columns on Desktop, 1 Column on Mobile -->
    <section class="charts-row">

      <!-- Left Column: Today's Work Plan -->
      <div class="card">
        <div class="card-header-row">
          <h4>Today's Work Plan</h4>
          <span style="font-size:12px; color:var(--blue); font-weight:700; cursor:pointer;" onclick="if(typeof Employee_user_dashboard_07_OPEN==='function') Employee_user_dashboard_07_OPEN();">View All &rarr;</span>
        </div>

        <div id="dashTodayWorkPlanContainer" style="display: flex; flex-direction: column; gap: 12px;">
          <div style="text-align:center; padding: 20px; color: #64748b;">Loading tasks...</div>
        </div>
      </div>

      <!-- Right Column: Deadlines & Notifications -->
      <div style="display: flex; flex-direction: column; gap: 14px;">

        <!-- Upcoming Deadlines -->
        <div class="card">
          <div class="card-header-row">
            <h4>Upcoming Deadlines</h4>
          </div>

          <div id="dashDeadlinesContainer" style="display: flex; flex-direction: column; gap: 12px;">
            <div style="text-align:center; padding: 10px; color: #64748b;">Loading deadlines...</div>
          </div>
        </div>

        <!-- Recent Notifications -->
        <div class="card">
          <div class="card-header-row">
            <h4>Recent Notifications</h4>
            <span style="font-size:12px; color:var(--blue); font-weight:700; cursor:pointer;" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function') Employee_user_dashboard_09_OPEN();">View All &rarr;</span>
          </div>

          <div id="dashRecentNotificationsContainer" style="display: flex; flex-direction: column; gap: 4px;">
            <div style="text-align:center; padding: 10px; color: #64748b;">Loading notifications...</div>
          </div>
        </div>

      </div>

    </section>

  </main>
</div>
