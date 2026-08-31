<style>
  #Employee_user_dashboard_09_notifications {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  .emp-notif-container {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* Top Navigation Bar */
  .emp-notif-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .emp-notif-topbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .emp-notif-topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy, #14204d);
    letter-spacing: -0.3px;
    margin: 0;
  }

  .emp-notif-menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: #eef2ff;
    border: none;
    cursor: pointer;
    color: #14204d;
    margin-right: 6px;
  }
  .emp-notif-menu-btn svg { width: 20px; height: 20px; }

  .emp-notif-topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .emp-notif-icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #eef2ff;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
    border: none;
  }
  .emp-notif-icon-btn svg { width: 18px; height: 18px; color: #14204d; }

  .emp-notif-dot {
    position: absolute;
    top: 8px;
    right: 9px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #ef4444;
    border: 2px solid #ffffff;
  }

  .emp-notif-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #eef2ff;
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    cursor: pointer;
  }
  .emp-notif-pill .avatar {
    width: 30px;
    height: 30px;
    font-size: 11.5px;
    background: #3b5bdb;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
  }
  .emp-notif-pill span {
    font-size: 13.5px;
    font-weight: 700;
    color: #14204d;
  }

  /* Card */
  .emp-notif-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 1px 3px rgba(20,25,60,.04);
    padding: 24px;
    box-sizing: border-box;
    width: 100%;
    margin-bottom: 24px;
  }

  .emp-notif-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
  }

  .emp-notif-head h3 {
    font-size: 18px;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
  }

  .emp-mark-read-btn {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-size: 12.5px;
    font-weight: 700;
    padding: 7px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .emp-mark-read-btn:hover { 
    background: #e2e8f0; 
    color: #1e293b; }

  .emp-notif-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1px solid #eef2f6;
    margin-bottom: 10px;
    background: #ffffff;
    transition: all 0.15s ease;
    cursor: pointer;
  }
  .emp-notif-item.unread { 
    background: #f8fafc; 
    border-color: #cbd5e1; 
  }
  .emp-notif-item:hover { 
    transform: translateY(-1px); 
    box-shadow: 0 2px 6px rgba(0,0,0,0.04); 
  }

  .emp-notif-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
  }

  @media (max-width: 768px) {
    .emp-notif-menu-btn { display: inline-flex !important; }
    .emp-notif-topbar h2 { font-size: 18px !important; }
    .emp-notif-card { padding: 16px; }
  }
</style>

<div id="Employee_user_dashboard_09_notifications" class="emp-main" style="display:none; padding:0;">
  <div class="emp-notif-container">
    
    <!-- Topbar Navigation -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_emp_09" aria-label="Open menu" onclick="typeof openEmployeeSidebar === 'function' ? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Notifications</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot" id="empTopNotifDot"></span>
        </div>
        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="topAvatarNotifPreview">--</div>
          <span id="topEmpNotifName">Loading...</span>
        </div>
      </div>
    </div>

    <!-- Notification List Card -->
    <div class="emp-notif-card">
      <div class="emp-notif-head">
        <div>
          <h3>System Notifications</h3>
          <span id="empNotifCount" style="font-size: 13px; color: #64748b; font-weight: 500;">Loading notifications...</span>
        </div>
        <button type="button" class="emp-mark-read-btn" id="empMarkAllReadBtn">Mark all as read</button>
      </div>

      <div id="empNotificationsList">
        <div style="text-align:center; padding: 30px; color:#64748b;">Loading notifications from database...</div>
      </div>
    </div>

  </div>
</div>

<script>
(function () {
  let empNotifs = [];
  const listContainer = document.getElementById('empNotificationsList');
  const countSpan = document.getElementById('empNotifCount');
  const markReadBtn = document.getElementById('empMarkAllReadBtn');

  function formatTimeAgo(timeStr) {
    if (!timeStr) return '';
    const date = new Date(timeStr.replace(/-/g, '/'));
    if (isNaN(date.getTime())) return timeStr;

    const seconds = Math.floor((new Date() - date) / 1000);
    if (seconds < 60) return 'Just now';
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes} min${minutes === 1 ? '' : 's'} ago`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours} hr${hours === 1 ? '' : 's'} ago`;
    const days = Math.floor(hours / 24);
    if (days < 7) return `${days} day${days === 1 ? '' : 's'} ago`;
    return timeStr.substring(0, 10);
  }

  function renderEmpNotifs() {
    if (!listContainer) return;

    if (empNotifs.length === 0) {
      listContainer.innerHTML = `
        <div style="text-align:center; padding: 40px 16px; color: #64748b; background:#f8fafc; border-radius:12px; border:1px dashed #cbd5e1;">
          <div style="margin-bottom:8px; color:#94a3b8;"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
          <div style="font-weight:700; color:#1e293b; font-size:14.5px;">No notifications found</div>
          <p style="font-size:12.5px; color:#64748b; margin-top:4px;">Updates on your leave requests, documents, and tasks will appear here.</p>
        </div>
      `;
      if (countSpan) countSpan.textContent = '0 unread notifications';
      updateEmpDots(0);
      return;
    }

    listContainer.innerHTML = empNotifs.map(n => {
      const type = (n.type || '').toLowerCase();
      let iconHtml = '<div class="emp-notif-icon" style="background:#eff6ff; color:#2563eb;"><i class="fa-solid fa-bell"></i></div>';

      if (type.includes('payment') || type.includes('receipt') || type.includes('salary')) {
        iconHtml = '<div class="emp-notif-icon" style="background:#ecfdf5; color:#059669;"><i class="fa-solid fa-file-invoice-dollar"></i></div>';
      } else if (type.includes('approved') || type.includes('complete') || type.includes('success')) {
        iconHtml = '<div class="emp-notif-icon" style="background:#ecfdf5; color:#059669;"><i class="fa-solid fa-check"></i></div>';
      } else if (type.includes('reject') || type.includes('error')) {
        iconHtml = '<div class="emp-notif-icon" style="background:#fef2f2; color:#dc2626;"><i class="fa-solid fa-xmark"></i></div>';
      } else if (type.includes('task')) {
        iconHtml = '<div class="emp-notif-icon" style="background:#fef3c7; color:#d97706;"><i class="fa-regular fa-clipboard"></i></div>';
      }

      const unreadClass = n.unread ? 'unread' : '';
      const dotHtml = n.unread ? '<span style="width:7px; height:7px; border-radius:50%; background:#2563eb; display:inline-block; margin-left:6px;"></span>' : '';

      return `
        <div class="emp-notif-item ${unreadClass}" onclick="handleEmpNotifClick(${n.id}, '${n.type}')" title="Click to view details">
          ${iconHtml}
          <div style="flex:1;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
              <h4 style="margin:0 0 3px; font-size:14px; font-weight:700; color:#1e293b;">${n.title} ${dotHtml}</h4>
              <span style="font-size:11.5px; color:#94a3b8; font-weight:500;">${formatTimeAgo(n.time)}</span>
            </div>
            <p style="margin:0; font-size:12.5px; color:#475569; line-height:1.4;">${n.message}</p>
            <span style="font-size:11.5px; color:#2563eb; font-weight:600; margin-top:4px; display:inline-block;">View Details →</span>
          </div>
        </div>
      `;
    }).join('');

    const unreadCount = empNotifs.filter(n => n.unread).length;
    if (countSpan) {
      countSpan.textContent = `${unreadCount} unread notification${unreadCount === 1 ? '' : 's'}`;
    }
    updateEmpDots(unreadCount);
  }

  function updateEmpDots(count) {
    document.querySelectorAll('.emp-dot, #empTopNotifDot').forEach(dot => {
      dot.style.display = count > 0 ? 'block' : 'none';
    });
  }

  window.fetchEmpNotifications = function () {
    const currentName = document.getElementById('empSidebarName') ? document.getElementById('empSidebarName').textContent.trim() : '';
    const nameParam = currentName ? ('&user=' + encodeURIComponent(currentName)) : '';
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/fetch_notification/fetch_notification.php?role=employee' + nameParam;
    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && Array.isArray(res.data)) {
          empNotifs = res.data;
        } else {
          empNotifs = [];
        }
        renderEmpNotifs();
      })
      .catch(() => {
        renderEmpNotifs();
      });
  };

  // ---- Click on notification and route to relevant page ----
  window.handleEmpNotifClick = function (id, type) {
    const markUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/mark_notification_read/mark_notification_read.php';
    const formData = new FormData();
    if (id) formData.append('id', id);
    formData.append('role', 'employee');

    fetch(markUrl, { method: 'POST', body: formData }).catch(() => {});

    const item = empNotifs.find(n => Number(n.id) === Number(id));
    if (item) item.unread = false;
    renderEmpNotifs();

    const t = (type || '').toLowerCase();
    if (t.includes('pay') || t.includes('receipt') || t.includes('salary')) {
      if (typeof Employee_user_dashboard_05_OPEN === 'function') Employee_user_dashboard_05_OPEN();
    } else if (t.includes('leave')) {
      if (typeof Employee_user_dashboard_08_OPEN === 'function') Employee_user_dashboard_08_OPEN();
    } else if (t.includes('doc')) {
      if (typeof Employee_user_dashboard_04_OPEN === 'function') Employee_user_dashboard_04_OPEN();
    } else if (t.includes('task')) {
      if (typeof Employee_user_dashboard_07_OPEN === 'function') Employee_user_dashboard_07_OPEN();
    } else if (t.includes('job') || t.includes('role')) {
      if (typeof Employee_user_dashboard_06_OPEN === 'function') Employee_user_dashboard_06_OPEN();
    } else if (t.includes('bank')) {
      if (typeof Employee_user_dashboard_05_OPEN === 'function') Employee_user_dashboard_05_OPEN();
    } else if (t.includes('profile')) {
      if (typeof Employee_user_dashboard_02_OPEN === 'function') Employee_user_dashboard_02_OPEN();
    } else {
      if (typeof Employee_user_dashboard_01_OPEN === 'function') Employee_user_dashboard_01_OPEN();
    }
  };

  window.markEmpNotifRead = function (id) {
    const markUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/mark_notification_read/mark_notification_read.php';
    const formData = new FormData();
    if (id) formData.append('id', id);
    formData.append('role', 'employee');

    fetch(markUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          if (id) {
            const item = empNotifs.find(n => Number(n.id) === Number(id));
            if (item) item.unread = false;
          } else {
            empNotifs.forEach(n => n.unread = false);
          }
          renderEmpNotifs();
        }
      })
      .catch(() => {
        if (id) {
          const item = empNotifs.find(n => Number(n.id) === Number(id));
          if (item) item.unread = false;
        } else {
          empNotifs.forEach(n => n.unread = false);
        }
        renderEmpNotifs();
      });
  };

  if (markReadBtn) {
    markReadBtn.addEventListener('click', () => markEmpNotifRead(null));
  }

  window.fetchEmpNotifications();
})();
</script>
