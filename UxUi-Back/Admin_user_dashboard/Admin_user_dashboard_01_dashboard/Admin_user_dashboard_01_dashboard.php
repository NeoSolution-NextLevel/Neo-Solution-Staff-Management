<style>
  :root{
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #3b5bdb;
    --blue-light: #dbe4ff;
    --blue-lighter: #eef2ff;
    --green: #12b76a;
    --green-bg: #e3f9ee;
    --amber: #f5a623;
    --amber-bg: #fdf1dc;
    --red: #f0576a;
    --red-bg: #fde8ec;
    --ink: #1a1f36;
    --muted: #6b7280;
    --border: #e8eaf0;
    --bg: #f5f6fa;
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

  body{
    background: var(--bg);
    color: var(--ink);
    display:flex;
    min-height:100vh;
    display: flex;
    min-height: 100vh;
  }

  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }



  .brand{
    display:flex;
    align-items:center;
    gap:12px;
    padding: 4px 6px 14px 6px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 12px;
  }
  .brand-icon{
    width:38px; height:38px;
    border-radius:11px;
    background: var(--navy);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
  }
  .brand-icon svg{ width:20px; height:20px; }
  .brand-text h1{ font-size:16px; font-weight:800; color:var(--navy); letter-spacing:-.2px; }
  .brand-text p{ font-size:12px; color:var(--muted); margin-top:1px; }

  .profile-card{
    display:flex;
    align-items:center;
    gap:12px;
    background: var(--blue-lighter);
    border-radius: 12px;
    padding: 10px 12px;
    margin-bottom: 12px;
    flex-shrink:0;
  }
  .avatar{
    width:34px; height:34px;
    border-radius:50%;
    background: var(--navy);
    color:#fff;
    font-size:12px;
    font-weight:700;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
  }
  .profile-card .name{ font-size:13.5px; font-weight:700; color:var(--ink); }
  .profile-card .role{ font-size:11.5px; color:var(--muted); }

  nav.nav-list{ display:flex; flex-direction:column; gap:1px; flex:1; min-height:0; justify-content:space-between; }

  .nav-item{
    display:flex;
    align-items:center;
    gap:11px;
    padding: 9px 12px;
    border-radius: 9px;
    font-size: 13.5px;
    font-weight: 600;
    color: #4b5169;
    transition: background .15s ease, color .15s ease;
  }
  .nav-item svg{ width:17px; height:17px; flex-shrink:0; }
  .nav-item:hover{ background: var(--blue-lighter); color: var(--navy); }
  .nav-item.active{
    background: var(--navy);
    color: #fff;
    box-shadow: 0 6px 16px rgba(20,32,77,.25);
  }

  /* ---------- Main ---------- */
  .main{
    flex:1;
    min-width:0;
    width: 100%;
    max-width: 100%;
    padding: 16px 20px 24px;
  }

  .topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom: 16px;
  }
  .topbar h2{ font-size: 22px; font-weight:800; color: var(--navy); letter-spacing:-.3px; }

  .topbar-right{ display:flex; align-items:center; gap:12px; }
  .icon-btn{
    width:38px; height:38px;
    border-radius:50%;
    background: var(--blue-lighter);
    display:flex; align-items:center; justify-content:center;
    position:relative;
    cursor:pointer;
  }
  .icon-btn svg{ width:18px; height:18px; color: var(--navy); }
  .dot{
    position:absolute; top:8px; right:9px;
    width:7px; height:7px; border-radius:50%;
    background: var(--red);
    border: 2px solid var(--card);
  }
  .admin-pill{
    display:flex; align-items:center; gap:8px;
    background: var(--blue-lighter);
    padding: 4px 14px 4px 4px;
    border-radius: 999px;
    cursor:pointer;
  }
  .admin-pill .avatar{ width:30px; height:30px; font-size:11.5px; background:var(--navy); }
  .admin-pill span{ font-size:13px; font-weight:700; color:var(--navy); }

  /* ---------- Welcome banner ---------- */
  .banner{
    position:relative;
    overflow:hidden;
    background: linear-gradient(120deg, var(--navy) 0%, var(--navy-2) 55%, #3648a0 100%);
    border-radius: var(--radius);
    padding: 18px 24px;
    color:#ffffff;
    margin-bottom: 16px;
    width: 100%;
    max-width: 100%;
    box-shadow: var(--shadow);
  }

  .banner::before{
    content:"";
    position:absolute;
    top:-90px;
    right:-60px;
    width:320px;
    height:320px;
    border-radius:50%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,.14), transparent 65%);
  }
  .banner::after{
    content:"";
    position:absolute;
    bottom:-120px;
    right:120px;
    width:260px; 
    height:260px;
    border-radius:50%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,.08), transparent 65%);
  }
  .banner .date{
    font-size:13px; 
    color: #c7d0f5; 
    margin-bottom:4px; 
    position:relative;
    font-weight: 500; 
  }
  .banner h3{ 
    font-size:22px; 
    font-weight:800; 
    margin-bottom:6px; 
    position:relative; 
    letter-spacing: -0.2px;
  }
  .banner p{ 
    font-size:13.5px; 
    color:#cfd6f7;
    position:relative; 
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

  

  /* ---------- Stat cards ---------- */
  .stats{
    display:grid;
    grid-template-columns: repeat(5, 1fr);
    gap:12px;
    margin-bottom: 16px;
    width: 100%;
    max-width: 100%;
  }
  .stat-card{
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 14px 16px;
    display:flex;
    flex-direction:column;
    gap:10px;
    width: 100%;
    max-width: 100%;
  }
  .stat-icon{
    width:38px; 
    height:38px;
    border-radius:10px;
    display:flex; 
    align-items:center; 
    justify-content:center;
  }
  .stat-icon svg{ 
    width:19px; 
    height:19px; 
  }
  .stat-icon.blue{ 
    background: var(--blue-light); 
    color: var(--blue); 
  }
  .stat-icon.green{ 
    background: var(--green-bg); 
    color: var(--green); 
  }
  .stat-icon.amber{ 
    background: var(--amber-bg); 
    color: var(--amber); 
  }
  .stat-icon.navy{ 
    background: var(--blue-light); 
    color: var(--navy); 
  }
  .stat-icon.red{ 
    background: var(--red-bg); 
    color: var(--red); 
  }
  .stat-value{ 
    font-size: 22px; 
    font-weight:800; 
    color: var(--ink); 
  }
  .stat-label{ 
    font-size:12.5px; 
    color: var(--muted); 
    font-weight:600; 
    line-height:1.3; 
  }

  /* ---------- Charts row ---------- */
  .charts-row{
    display:grid;
    grid-template-columns: 1.65fr 1fr;
    gap:14px;
    margin-bottom: 16px;
    width: 100%;
    max-width: 100%;
  }
  .card{
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
  .card-header-row h4 { margin-bottom: 0 !important; font-size:16px; font-weight:800; color: var(--navy); }
  .chart-play-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--blue-lighter);
    color: var(--blue);
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .chart-play-btn:hover {
    background: var(--blue);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 91, 219, 0.25);
  }

  /* bar chart */
  .bar-chart{
    display:flex;
    align-items:flex-end;
    gap:26px;
    height: 260px;
    padding-left: 30px;
    position:relative;
  }
  .y-axis{
    position:absolute;
    left:0; top:0; bottom:26px;
    display:flex;
    flex-direction:column-reverse;
    justify-content:space-between;
    font-size:12px;
    color: var(--muted);
    width:24px;
    text-align:right;
  }
  .bar-groups{
    display:flex;
    align-items:flex-end;
    gap:26px;
    height:100%;
    flex:1;
    padding-left: 34px;
    border-left: 1px solid var(--border);
  }
  .bar-group{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:flex-end;
    flex:1;
    height:100%;
  }
  .bars{
    display:flex;
    align-items:flex-end;
    gap:6px;
    height: 234px;
  }
  .bar{
    width:20px;
    border-radius: 4px 4px 0 0;
    transform-origin: bottom;
    transition: transform 0.3s ease;
  }
  .bar.light{ background: var(--blue-light); }
  .bar.dark{ background: var(--blue); }

  @keyframes growBar {
    0% {
      transform: scaleY(0);
      opacity: 0.3;
    }
    100% {
      transform: scaleY(1);
      opacity: 1;
    }
  }

  .bar.animate {
    animation: growBar 0.45s ease-out both;
  }

  .bar-group .month{ margin-top:10px; font-size:13px; color: var(--navy); font-weight:600; }

  /* donut */
  .donut-wrap{ display:flex; flex-direction:column; align-items:center; }
  .donut{
    width: 210px; height:210px;
    border-radius:50%;
    background: conic-gradient(
      var(--blue) 0deg 90deg,
      var(--green) 90deg 210deg,
      var(--amber) 210deg 360deg
    );
    display:flex; align-items:center; justify-content:center;
    margin-bottom: 22px;
    box-shadow: 0 4px 16px rgba(20,25,60,0.06);
  }
  
  @keyframes spinDonut {
    0% {
      transform: scale(0.92) rotate(-10deg);
      opacity: 0.3;
    }
    100% {
      transform: scale(1) rotate(0deg);
      opacity: 1;
    }
  }

  .donut.animate {
    animation: spinDonut 0.5s ease-out forwards;
  }

  .donut::after{
    content:"";
    width: 118px; height:118px;
    border-radius:50%;
    background: var(--card);
  }
  .legend{ width:100%; display:flex; flex-direction:column; gap:12px; }
  .legend-row{ display:flex; align-items:center; justify-content:space-between; font-size:14px; }
  .legend-row .left{ display:flex; align-items:center; gap:10px; color:#3a3f55; font-weight:600; }
  .swatch{ width:10px; height:10px; border-radius:50%; }
  .swatch.blue{ background: var(--blue); }
  .swatch.green{ background: var(--green); }
  .swatch.amber{ background: var(--amber); }
  .legend-row .val{ font-weight:700; color: var(--ink); }

  /* ---------- Bottom row ---------- */
  .bottom-row{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:20px;
  }

  .dept-row{ margin-bottom: 18px; }
  .dept-row:last-child{ margin-bottom:0; }
  .dept-head{ display:flex; justify-content:space-between; font-size:14px; margin-bottom:8px; }
  .dept-head .name{ color:#3a3f55; font-weight:600; }
  .dept-head .count{ color: var(--ink); font-weight:700; }
  .progress-track{
    height:8px;
    border-radius: 999px;
    background: var(--blue-lighter);
    overflow:hidden;
  }
  .progress-fill{
    height:100%;
    border-radius:999px;
    background: var(--blue);
  }

  .activity-item{
    display:flex;
    gap:14px;
    padding: 13px 0;
    border-bottom: 1px solid var(--border);
  }
  .activity-item:last-child{ border-bottom:none; padding-bottom:0; }
  .activity-icon{
    width:38px; height:38px;
    border-radius:10px;
    flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:17px;
  }
  .activity-icon.green{ background: var(--green-bg); }
  .activity-icon.blue{ background: var(--blue-light); }
  .activity-icon.amber{ background: var(--amber-bg); }
  .activity-icon.grey{ background: var(--blue-lighter); }
  .activity-text p{ font-size:14px; color:#2b2f45; font-weight:600; line-height:1.4; }
  .activity-text span{ font-size:12.5px; color: var(--muted); }

  @media (max-width: 1300px){
    .stats{ grid-template-columns: repeat(3,1fr); }
    .charts-row, .bottom-row{ grid-template-columns: 1fr; }
  }

  /* ---------- Mobile ---------- */
  .menu-btn{ display:none; }
  .overlay{ display:none; }

  @media (max-width: 900px){
    body{ position:relative; overflow-x:hidden; }

    .menu-btn{
      display:flex;
      align-items:center; justify-content:center;
      width:38px; height:38px;
      border-radius:8px;
      background:transparent;
      border:none;
      cursor:pointer;
      color: var(--navy);
      margin-right:4px;
    }
    .menu-btn svg{ width:22px; height:22px; }

    
    .overlay{
      display:block;
      position:fixed; inset:0;
      background: rgba(15,20,45,.4);
      opacity:0;
      pointer-events:none;
      transition: opacity .25s ease;
      z-index: 30;
    }
    .overlay.show{ opacity:1; pointer-events:auto; }

    .main{ padding: 16px 16px 32px; width:100%; }

    .topbar h2{ font-size:20px; }
    .topbar-left{ display:flex; align-items:center; gap:2px; }
    .admin-pill span{ display:none; }
    .admin-pill{ padding:6px; }

    .banner{ padding:22px 20px; }
    .banner h3{ font-size:22px; }

    .stats{ grid-template-columns: repeat(2,1fr); gap:12px; }
    .stat-card{ padding:16px; gap:8px; }
    .stat-value{ font-size:22px; }
    .stat-label{ font-size:12.5px; }

    .charts-row{ grid-template-columns: 1fr; gap:16px; }
    .bottom-row{ grid-template-columns: 1fr; gap:16px; }

    .card{ padding:18px; }

    .bar-chart{ padding-left:0; }
    .bar-groups{ gap:14px; padding-left:26px; }
    .bar{ width:14px; }
  }
</style>

<div id="Admin_user_dashboard_01">

  <div class="overlay" id="overlay"></div>


  <!-- ================= MAIN ================= -->
  <main class="main">

    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Dashboard</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="Admin_user_dashboard_09_OPEN();" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
           stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
           <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
           <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill" onclick="Admin_user_dashboard_10_OPEN();" title="Settings">
          <div class="avatar">AU</div>
          <span>Admin</span>
        </div>
      </div>
    </div>

    <section class="banner">
      <div class="date"><?php echo date('l, F j, Y'); ?></div>
      <h3>Welcome back, Admin</h3>
      <p>Manage your employees and monitor daily operations.</p>
    </section>

    <section class="stats">
      <div class="stat-card">
        <div class="stat-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-value" id="kpiTotalEmployees">5</div>
        <div class="stat-label">Total Employees</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-10 10-3-3"/></svg>
        </div>
        <div class="stat-value" id="kpiActiveEmployees">4</div>
        <div class="stat-label">Active Employees</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-value" id="kpiPendingTasks">3</div>
        <div class="stat-label">Pending Tasks</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon navy">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="m9 12 2 2 4-4"/></svg>
        </div>
        <div class="stat-value" id="kpiCompletedTasks">2</div>
        <div class="stat-label">Completed Tasks</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon red">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
        </div>
        <div class="stat-value" id="kpiPendingLeaves">2</div>
        <div class="stat-label">Pending Leave</div>
      </div>
    </section>

    <section class="charts-row">
      <div class="card">
        <div class="card-header-row">
          <h4>Task Completion Statistics</h4>
        </div>
        <div class="bar-chart">
          <div class="y-axis">
            <span>0</span><span>4</span><span>8</span><span>12</span><span>16</span>
          </div>
          <div class="bar-groups" id="barGroups"></div>
        </div>
      </div>

      <div class="card">
        <div class="card-header-row">
          <h4>Task Status</h4>
        </div>
        <div class="donut-wrap">
          <div class="donut animate" id="donutChart"></div>
          <div class="legend" id="donutLegend">
            <div class="legend-row"><div class="left"><span class="swatch green"></span>Completed</div><span class="val" id="legendCompleted">2</span></div>
            <div class="legend-row"><div class="left"><span class="swatch blue"></span>In Progress</div><span class="val" id="legendInProgress">1</span></div>
            <div class="legend-row"><div class="left"><span class="swatch amber"></span>Pending</div><span class="val" id="legendPending">3</span></div>
          </div>
        </div>
      </div>
    </section>

    <section class="bottom-row">
      <div class="card">
        <h4>Employee Distribution by Department</h4>
        <div id="deptList"></div>
      </div>

      <div class="card">
        <h4>Recent Activities</h4>
        <div id="dashboardActivitiesList">
          <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px; font-weight: 500;">Loading recent system activities...</div>
        </div>
      </div>
    </section>
  </main>
</div>
