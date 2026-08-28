<script>
(function () {
  document.addEventListener('DOMContentLoaded', () => {

    // ---- Mobile sidebar toggle ----
    const menuBtn = document.getElementById('menuBtn');

    function toggleMobileSidebar() {
      if (typeof openAdminSidebar === 'function') {
        openAdminSidebar();
      } else {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar?.classList.toggle('mobile-open');
        overlay?.classList.toggle('active');
      }
    }

    if (menuBtn) {
      menuBtn.addEventListener('click', toggleMobileSidebar);
    }

    // ---- Donut / Pie chart dynamic rendering purely from database ----
    function renderTaskStatusPieChart(taskStatusList, kpiData) {
      const donut = document.getElementById('donutChart');
      const totalEl = document.getElementById('donutTotalTasks');

      let completed = 0;
      let inProgress = 0;
      let pending = 0;

      if (Array.isArray(taskStatusList)) {
        taskStatusList.forEach(ts => {
          const lbl = (ts.label || '').toLowerCase();
          const cnt = Number(ts.count) || 0;
          if (lbl === 'completed' || lbl === 'done') completed = cnt;
          else if (lbl.includes('progress')) inProgress = cnt;
          else if (lbl === 'pending') pending = cnt;
        });
      } else if (kpiData) {
        completed = Number(kpiData.completed_tasks) || 0;
        inProgress = Number(kpiData.in_progress_tasks) || 0;
        pending = Number(kpiData.pending_tasks) || 0;
      }

      const total = completed + inProgress + pending;
      if (totalEl) totalEl.textContent = total;

      // Update Legend Counts and Percentages
      const setLegend = (idVal, idPct, count) => {
        const elVal = document.getElementById(idVal);
        const elPct = document.getElementById(idPct);
        if (elVal) elVal.textContent = count;
        if (elPct) {
          const pct = total > 0 ? Math.round((count / total) * 100) : 0;
          elPct.textContent = `(${pct}%)`;
        }
      };

      setLegend('legendCompleted', 'legendCompletedPct', completed);
      setLegend('legendInProgress', 'legendInProgressPct', inProgress);
      setLegend('legendPending', 'legendPendingPct', pending);

      // Render Dynamic Conic Gradient Slices
      if (donut) {
        if (total === 0) {
          donut.style.background = 'conic-gradient(#e2e8f0 0deg 360deg)';
        } else {
          const cDeg = (completed / total) * 360;
          const ipDeg = cDeg + (inProgress / total) * 360;

          donut.style.background = `conic-gradient(
            var(--green) 0deg ${cDeg}deg,
            var(--blue) ${cDeg}deg ${ipDeg}deg,
            var(--amber) ${ipDeg}deg 360deg
          )`;
        }

        donut.classList.remove('animate');
        void donut.offsetWidth; // trigger DOM reflow
        donut.classList.add('animate');
      }
    }

    // ---- Department distribution (Strictly from Database) ----
    const deptList = document.getElementById('deptList');
    function renderDepartments(depts) {
      if (!deptList) return;
      if (!Array.isArray(depts) || depts.length === 0) {
        deptList.innerHTML = '<div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px; font-weight: 500;">No departments found in database.</div>';
        return;
      }

      const maxDept = Math.max(...depts.map(d => d.count), 1);

      deptList.innerHTML = '';
      depts.forEach(({ name, count }) => {
        const row = document.createElement('div');
        row.className = 'dept-row';
        row.innerHTML = `
          <div class="dept-head">
            <span>${escapeHtml(name)}</span>
            <span class="dept-count-pill">${count} staff</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill" style="width:${(count / maxDept * 100)}%"></div>
          </div>
        `;
        deptList.appendChild(row);
      });
    }

    // ---- Recent Activities (Clickable Navigation to Relevant Tabs) ----
    const activitiesList = document.getElementById('dashboardActivitiesList');
    function renderActivities(customActs) {
      if (!activitiesList) return;
      if (!customActs || customActs.length === 0) {
        activitiesList.innerHTML = '<div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px; font-weight: 500;">No recent system activities found in database.</div>';
        return;
      }
      activitiesList.innerHTML = '';
      customActs.forEach(act => {
        const item = document.createElement('div');
        item.className = 'activity-item';

        const titleText = act.title || 'System Activity';
        const titleLower = titleText.toLowerCase();
        const typeLower = (act.type || '').toLowerCase();

        // 1. Determine destination page
        let navAction = "if(typeof Admin_user_dashboard_09_OPEN==='function') Admin_user_dashboard_09_OPEN();";
        let iconClass = 'blue';
        let iconHtml = '<i class="fa-solid fa-bell"></i>';

        if (titleLower.includes('leave') || typeLower.includes('leave')) {
          navAction = "if(typeof Admin_user_dashboard_08_OPEN==='function') Admin_user_dashboard_08_OPEN();";
          iconClass = 'amber';
          iconHtml = '<i class="fa-solid fa-calendar-check"></i>';
        } else if (titleLower.includes('task') || typeLower.includes('task')) {
          navAction = "if(typeof Admin_user_dashboard_07_OPEN==='function') Admin_user_dashboard_07_OPEN();";
          iconClass = 'navy';
          iconHtml = '<i class="fa-solid fa-list-check"></i>';
        } else if (titleLower.includes('employee') || titleLower.includes('profile') || typeLower.includes('employee') || typeLower.includes('profile')) {
          navAction = "if(typeof Admin_user_dashboard_02_OPEN==='function') Admin_user_dashboard_02_OPEN();";
          iconClass = 'green';
          iconHtml = '<i class="fa-solid fa-user-check"></i>';
        } else if (titleLower.includes('department') || typeLower.includes('department')) {
          navAction = "if(typeof Admin_user_dashboard_05_OPEN==='function') Admin_user_dashboard_05_OPEN();";
          iconClass = 'blue';
          iconHtml = '<i class="fa-solid fa-building"></i>';
        }

        item.setAttribute('onclick', navAction);
        item.setAttribute('title', `Click to open ${titleText}`);

        item.innerHTML = `
          <div class="activity-icon ${iconClass}">
            ${iconHtml}
          </div>
          <div class="activity-text">
            <p style="font-weight:700; color:#1e293b; margin:0 0 2px; font-size:13px;">${escapeHtml(titleText)}</p>
            <span style="font-size:11.5px; color:#64748b;">${escapeHtml(act.date)}</span>
          </div>
        `;
        activitiesList.appendChild(item);
      });
    }

    function escapeHtml(text) {
      if (!text) return '';
      return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    // ---- Fetch Live Data from Dashboard Controller Endpoint ----
    function fetchLiveDashboardData() {
      const endpoint = '../View-List/Dashboard/dashboard_details_LIST.php';
      fetch(endpoint)
        .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.json();
        })
        .then(res => {
          if (res && res.data) {
            const d = res.data;
            // Update KPI cards strictly from database
            if (d.kpi) {
              const kpi = d.kpi;
              if (document.getElementById('kpiTotalEmployees')) document.getElementById('kpiTotalEmployees').textContent = kpi.total_employees;
              if (document.getElementById('kpiActiveEmployees')) document.getElementById('kpiActiveEmployees').textContent = kpi.active_employees;
              if (document.getElementById('kpiPendingTasks')) document.getElementById('kpiPendingTasks').textContent = kpi.pending_tasks;
              if (document.getElementById('kpiCompletedTasks')) document.getElementById('kpiCompletedTasks').textContent = kpi.completed_tasks;
              if (document.getElementById('kpiPendingLeaves')) document.getElementById('kpiPendingLeaves').textContent = kpi.pending_leaves;
            }

            // Update Task Status Pie / Donut Chart purely from database
            renderTaskStatusPieChart(d.task_status, d.kpi);

            // Update Department Distribution purely from database
            if (d.departments) {
              renderDepartments(d.departments);
            }

            // Update Activities purely from database
            if (d.activities) {
              renderActivities(d.activities);
            }
          }
        })
        .catch(err => {
          console.error('Error fetching dashboard live data:', err);
        });
    }

    fetchLiveDashboardData();

    // Global playback function for tab switching
    window.playDashboardChartAnimations = function() {
      fetchLiveDashboardData();
    };

  });
})();
</script>