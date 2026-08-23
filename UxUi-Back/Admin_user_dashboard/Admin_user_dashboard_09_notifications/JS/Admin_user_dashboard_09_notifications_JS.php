<script>
(function () {
  const init = () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn') || document.getElementById('menuBtn_09');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (typeof openAdminSidebar === 'function') openAdminSidebar();
      });
    }

    // ---- State (Purely from MySQL Database) ----
    let notifications = [];

    const container = document.getElementById('notificationsContainer');
    const notifCount = document.getElementById('notifCount');
    const markAllReadBtn = document.getElementById('markAllReadBtn');

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

    // ---- Render Notifications List ----
    function renderNotifications() {
      if (!container) return;

      if (notifications.length === 0) {
        container.innerHTML = `
          <div style="text-align:center; padding: 50px 20px; color: #64748b; background:#ffffff; border-radius:14px; border:1px dashed #cbd5e1;">
            <div style="font-size:32px; margin-bottom:8px;">🔔</div>
            <div style="font-weight:700; font-size:15px; color:#1e293b;">No notifications right now</div>
            <p style="font-size:13px; color:#64748b; margin-top:4px;">When actions like leave requests, document uploads, or new roles happen, you will be notified here.</p>
          </div>
        `;
        if (notifCount) notifCount.textContent = '0 unread notifications';
        updateTopbarDots(0);
        return;
      }

      container.innerHTML = notifications.map(n => {
        let iconHtml = `
          <div class="notif-icon icon-blue" style="width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#eff6ff; color:#2563eb;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
        `;

        const type = (n.type || '').toLowerCase();
        if (type.includes('leave_request') || type.includes('leave')) {
          iconHtml = `
            <div class="notif-icon icon-amber" style="width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#fef3c7; color:#d97706;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
          `;
        } else if (type.includes('approved') || type.includes('complete') || type.includes('success')) {
          iconHtml = `
            <div class="notif-icon icon-green" style="width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#ecfdf5; color:#059669;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          `;
        } else if (type.includes('doc') || type.includes('upload')) {
          iconHtml = `
            <div class="notif-icon icon-blue" style="width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#eff6ff; color:#2563eb;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
          `;
        } else if (type.includes('department') || type.includes('role') || type.includes('employee')) {
          iconHtml = `
            <div class="notif-icon" style="width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#f5f3ff; color:#7c3aed;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
          `;
        } else if (type.includes('reject') || type.includes('error') || type.includes('alert')) {
          iconHtml = `
            <div class="notif-icon icon-red" style="width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#fef2f2; color:#dc2626;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
          `;
        }

        const unreadDot = n.unread ? '<div class="unread-indicator" style="width:10px; height:10px; border-radius:50%; background:#2563eb; flex-shrink:0; margin-top:4px;"></div>' : '';
        const cardBg = n.unread ? '#f8fafc' : '#ffffff';

        return `
          <div class="notif-card ${n.unread ? 'unread' : ''}" data-id="${n.id}" onclick="handleAdminNotifClick(${n.id}, '${n.type}')" title="Click to view details">
            <div class="notif-icon-wrap">
              ${iconHtml}
            </div>
            <div class="notif-body">
              <div class="notif-title-row">
                <h4 class="notif-title">${n.title}</h4>
                <span class="notif-time">${formatTimeAgo(n.time)}</span>
              </div>
              <p class="notif-msg">${n.message}</p>
              <span class="notif-link">View Page →</span>
            </div>
            ${unreadDot}
          </div>
        `;
      }).join('');

      const unreadTotal = notifications.filter(n => n.unread).length;
      if (notifCount) {
        notifCount.textContent = `${unreadTotal} unread notification${unreadTotal === 1 ? '' : 's'}`;
      }
      updateTopbarDots(unreadTotal);
    }

    function updateTopbarDots(unreadCount) {
      document.querySelectorAll('.notif-dot').forEach(dot => {
        dot.style.display = unreadCount > 0 ? 'block' : 'none';
      });
    }

    // ---- Fetch Notifications from MySQL Database ----
    window.fetchAdminNotifications = function () {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/fetch_notification/fetch_notification.php?role=admin';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            notifications = res.data;
          } else {
            notifications = [];
          }
          renderNotifications();
        })
        .catch(() => {
          renderNotifications();
        });
    };

    // ---- Notification Click & Navigation Handler ----
    window.handleAdminNotifClick = function (id, type) {
      // 1. Mark notification as read
      const markUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/mark_notification_read/mark_notification_read.php';
      const formData = new FormData();
      if (id) formData.append('id', id);
      formData.append('role', 'admin');

      fetch(markUrl, { method: 'POST', body: formData }).catch(() => {});

      const item = notifications.find(n => Number(n.id) === Number(id));
      if (item) item.unread = false;
      renderNotifications();

      // 2. Navigate to relevant dashboard page
      const t = (type || '').toLowerCase();
      if (t.includes('leave')) {
        if (typeof Admin_user_dashboard_08_OPEN === 'function') Admin_user_dashboard_08_OPEN();
      } else if (t.includes('doc') || t.includes('upload')) {
        if (typeof Admin_user_dashboard_03_OPEN === 'function') Admin_user_dashboard_03_OPEN();
      } else if (t.includes('department')) {
        if (typeof Admin_user_dashboard_05_OPEN === 'function') Admin_user_dashboard_05_OPEN();
      } else if (t.includes('role')) {
        if (typeof Admin_user_dashboard_06_OPEN === 'function') Admin_user_dashboard_06_OPEN();
      } else if (t.includes('employee')) {
        if (typeof Admin_user_dashboard_02_OPEN === 'function') Admin_user_dashboard_02_OPEN();
      } else if (t.includes('task')) {
        if (typeof Admin_user_dashboard_07_OPEN === 'function') Admin_user_dashboard_07_OPEN();
      } else if (t.includes('bank')) {
        if (typeof Admin_user_dashboard_04_OPEN === 'function') Admin_user_dashboard_04_OPEN();
      } else {
        if (typeof Admin_user_dashboard_01_OPEN === 'function') Admin_user_dashboard_01_OPEN();
      }
    };

    window.markNotifRead = function (id) {
      const markUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/mark_notification_read/mark_notification_read.php';
      const formData = new FormData();
      if (id) formData.append('id', id);
      formData.append('role', 'admin');

      fetch(markUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            if (id) {
              const item = notifications.find(n => Number(n.id) === Number(id));
              if (item) item.unread = false;
            } else {
              notifications.forEach(n => n.unread = false);
            }
            renderNotifications();
          }
        })
        .catch(() => {
          if (id) {
            const item = notifications.find(n => Number(n.id) === Number(id));
            if (item) item.unread = false;
          } else {
            notifications.forEach(n => n.unread = false);
          }
          renderNotifications();
        });
    };

    if (markAllReadBtn) {
      markAllReadBtn.addEventListener('click', () => markNotifRead(null));
    }

    // Initial Load from Database
    window.fetchAdminNotifications();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>