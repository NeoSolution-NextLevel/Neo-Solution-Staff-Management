<script>
(function () {
  document.addEventListener('DOMContentLoaded', () => {
    
    // ---- Mobile sidebar toggle ----
    const menuBtn = document.getElementById('menuBtn_01');

    function toggleMobileSidebar() {
      if (typeof openEmployeeSidebar === 'function') {
        openEmployeeSidebar();
      } else {
        const sidebar = document.getElementById('employeeSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar?.classList.toggle('mobile-open');
        overlay?.classList.toggle('active');
      }
    }

    if (menuBtn) {
      menuBtn.addEventListener('click', toggleMobileSidebar);
    }

    // ---- Fetch Employee Live Profile, Department, Tasks, Notifications ----
    window.fetchEmployeeDashboardData = function () {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';

      // 1. Fetch Profile & Department
      fetch(pth + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && res.data) {
            const p = res.data;
            const fullName = p.full_name || '';
            const firstName = fullName ? fullName.split(' ')[0] : 'Employee';
            const dept = p.department || 'General';
            const empCode = p.employee_id_code || 'EMP-001';
            const initials = fullName ? fullName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'EM';

            const el = id => document.getElementById(id);
            if (el('dashEmpDept')) el('dashEmpDept').textContent = dept;
            if (el('dashEmpCode')) el('dashEmpCode').textContent = empCode;
            if (el('dashWelcomeTitle')) el('dashWelcomeTitle').textContent = `Welcome back, ${firstName}`;
            if (el('dashWelcomeSubtitle')) el('dashWelcomeSubtitle').textContent = `Here's your work overview for today in ${dept}.`;
            if (el('dashTopEmpName')) el('dashTopEmpName').textContent = firstName;

            const topAvatar = el('dashTopAvatar');
            if (topAvatar) {
              if (p.profile_pic && p.profile_pic.trim() !== '') {
                const img_pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + p.profile_pic;
                topAvatar.innerHTML = `<img src="${img_pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
              } else {
                topAvatar.textContent = initials;
              }
            }
            
            fetchTasksForEmployee(fullName, pth);
          } else {
            fetchTasksForEmployee('', pth);
          }
        })
        .catch(() => {
          fetchTasksForEmployee('', pth);
        });

      // 2. Fetch Tasks for KPIs and Today's Work Plan
      function fetchTasksForEmployee(employeeName, pth) {
        let taskUrl = pth + 'UxUi-Back/Tasks/fetch_tasks/fetch_tasks.php';
        if (employeeName) {
            taskUrl += '?employee=' + encodeURIComponent(employeeName);
        }
        
        fetch(taskUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            const tasks = res.data;
            const todayTasks = tasks.length;
            const pendingTasks = tasks.filter(t => t.status && t.status.trim().toLowerCase() === 'pending').length;
            const completedTasks = tasks.filter(t => t.status && (t.status.trim().toLowerCase() === 'completed' || t.status.trim().toLowerCase() === 'done')).length;

            const el = id => document.getElementById(id);
            if (el('kpiTodayTasks')) el('kpiTodayTasks').textContent = todayTasks;
            if (el('kpiPendingTasks')) el('kpiPendingTasks').textContent = pendingTasks;
            if (el('kpiCompletedTasks')) el('kpiCompletedTasks').textContent = completedTasks;

            // Render Today's Work Plan
            const planContainer = el('dashTodayWorkPlanContainer');
            if (planContainer) {
              if (tasks.length === 0) {
                planContainer.innerHTML = '<div style="text-align:center; padding: 20px; color: #64748b;">No tasks assigned yet.</div>';
              } else {
                planContainer.innerHTML = tasks.slice(0, 3).map(t => {
                  let pillClass = 'var(--amber-bg)';
                  let pillColor = 'var(--amber)';
                  let progressWidth = '20%';
                  if (t.status === 'In Progress') { pillClass = 'var(--blue-lighter)'; pillColor = 'var(--blue)'; progressWidth = '60%'; }
                  if (t.status === 'Completed') { pillClass = 'var(--green-bg)'; pillColor = 'var(--green)'; progressWidth = '100%'; }

                  return `
                    <div style="background: #fafbfd; border: 1px solid var(--border); border-radius: 12px; padding: 14px 16px;">
                      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 14px; font-weight: 700; color: var(--ink);">${t.title}</span>
                        <span style="background: ${pillClass}; color: ${pillColor}; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 999px;">${t.status}</span>
                      </div>
                      <div style="font-size: 12px; color: var(--muted); margin-bottom: 8px;">Deadline: ${t.deadline} · ${t.mode || 'Online'}</div>
                      <div style="width: 100%; height: 4px; background: #e8eaf0; border-radius: 999px; overflow: hidden;">
                        <div style="width: ${progressWidth}; height: 100%; background: ${pillColor}; border-radius: 999px;"></div>
                      </div>
                    </div>
                  `;
                }).join('');
              }
            }

            // Render Upcoming Deadlines
            const deadContainer = el('dashDeadlinesContainer');
            if (deadContainer) {
              if (tasks.length === 0) {
                deadContainer.innerHTML = '<div style="text-align:center; padding: 10px; color: #64748b;">No upcoming deadlines.</div>';
              } else {
                deadContainer.innerHTML = tasks.slice(0, 2).map(t => `
                  <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--blue); margin-top: 5px; flex-shrink: 0;"></span>
                    <div>
                      <div style="font-size: 13.5px; font-weight: 700; color: var(--ink);">${t.title}</div>
                      <div style="font-size: 12px; font-weight: 600; color: var(--muted); margin-top: 2px;">Due: ${t.deadline}</div>
                    </div>
                  </div>
                `).join('');
              }
            }
          }
        })
        .catch(() => {});
      }

      // 3. Fetch Notifications for Dashboard Widget
      let notifUrl = pth + 'UxUi-Back/Notifications/fetch_notification/fetch_notification.php?role=employee';
      if (window.currentEmployeeName) {
        notifUrl += '&user=' + encodeURIComponent(window.currentEmployeeName);
      }
      fetch(notifUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            const notifs = res.data;
            const notifContainer = document.getElementById('dashRecentNotificationsContainer');
            if (notifContainer) {
              if (notifs.length === 0) {
                notifContainer.innerHTML = '<div style="text-align:center; padding: 10px; color: #64748b;">No recent notifications.</div>';
              } else {
                notifContainer.innerHTML = notifs.slice(0, 3).map(n => {
                  let icon = '<i class="fa-solid fa-bell"></i>';
                  let iconColor = 'blue';
                  if (n.type === 'leave_approved') { icon = '<i class="fa-solid fa-check"></i>'; iconColor = 'green'; }
                  if (n.type === 'leave_rejected') { icon = '<i class="fa-solid fa-xmark"></i>'; iconColor = 'red'; }
                  if (n.type === 'task_assigned') { icon = '<i class="fa-solid fa-list-check"></i>'; iconColor = 'amber'; }

                  return `
                    <div class="activity-item" style="cursor:pointer;" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function') Employee_user_dashboard_09_OPEN();">
                      <div class="activity-icon ${iconColor}">${icon}</div>
                      <div class="activity-text">
                        <p>${n.title}</p>
                        <span>${n.created_at || ''}</span>
                      </div>
                    </div>
                  `;
                }).join('');
              }
            }
          }
        })
        .catch(() => {});

      // 4. Fetch Leave Requests for KPI
      fetch(pth + 'UxUi-Back/Leave_Requests/fetch_leave_request/fetch_leave_request.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            const count = res.data.length;
            const el = document.getElementById('kpiLeaveRequests');
            if (el) el.textContent = count;
          }
        })
        .catch(() => {});
    };

    function showDashToast(msg, type = 'success') {
      let c = document.getElementById('dashboardToastContainer');
      if (!c) {
        c = document.createElement('div');
        c.id = 'dashboardToastContainer';
        c.style.cssText = 'position:fixed; top:24px; right:24px; z-index:99999; display:flex; flex-direction:column; gap:10px; pointer-events:none;';
        document.body.appendChild(c);
      }
      const t = document.createElement('div');
      const bg = type === 'success' ? '#16a34a' : (type === 'error' ? '#dc2626' : '#2563eb');
      t.style.cssText = `background:${bg}; color:#ffffff; padding:12px 18px; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.18); font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:8px; opacity:0; transform:translateY(-10px); transition:all 0.25s ease; pointer-events:auto;`;
      t.innerHTML = `<span>${type==='success'?'✓':(type==='error'?'✕':'ℹ')}</span> <span>${msg}</span>`;
      c.appendChild(t);
      requestAnimationFrame(() => { t.style.opacity = '1'; t.style.transform = 'translateY(0)'; });
      setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(-10px)'; setTimeout(() => t.remove(), 300); }, 3200);
    }

    window.fetchEmployeeDashboardData();
  });
})();
</script>