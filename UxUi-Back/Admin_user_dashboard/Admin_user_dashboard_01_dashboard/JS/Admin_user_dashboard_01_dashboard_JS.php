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

    // ---- Bar chart data & animation ----
    const barGroups = document.getElementById('barGroups');

    function renderBarChart(customMonths) {
      if (!barGroups) return;
      barGroups.innerHTML = '';

      const months = customMonths || [
        { m: 'Mar', light: 9,  dark: 8  },
        { m: 'Apr', light: 15, dark: 12 },
        { m: 'May', light: 11, dark: 7  },
        { m: 'Jun', light: 16, dark: 16 },
        { m: 'Jul', light: 12, dark: 10 },
        { m: 'Aug', light: 4,  dark: 2  }
      ];
      const maxVal = Math.max(...months.map(m => Math.max(m.light || 0, m.dark || 0)), 16);
      const chartHeight = 234;

      months.forEach(({ m, light, dark }, groupIndex) => {
        const group = document.createElement('div');
        group.className = 'bar-group';

        const bars = document.createElement('div');
        bars.className = 'bars';

        const lightBar = document.createElement('div');
        lightBar.className = 'bar light animate';
        lightBar.style.height = (light / maxVal * chartHeight) + 'px';
        lightBar.style.animationDelay = (groupIndex * 0.1) + 's';

        const darkBar = document.createElement('div');
        darkBar.className = 'bar dark animate';
        darkBar.style.height = (dark / maxVal * chartHeight) + 'px';
        darkBar.style.animationDelay = (groupIndex * 0.1 + 0.05) + 's';

        bars.appendChild(lightBar);
        bars.appendChild(darkBar);

        const label = document.createElement('div');
        label.className = 'month';
        label.textContent = m;

        group.appendChild(bars);
        group.appendChild(label);
        barGroups.appendChild(group);
      });
    }

    // ---- Donut rotation animation trigger ----
    function playDonutAnimation() {
      const donut = document.getElementById('donutChart');
      if (donut) {
        donut.classList.remove('animate');
        void donut.offsetWidth; // trigger DOM reflow
        donut.classList.add('animate');
      }
    }

    // ---- Department distribution ----
    const deptList = document.getElementById('deptList');
    function renderDepartments(customDepts) {
      if (!deptList) return;
      const depts = customDepts || [
        { name: 'Engineering', count: 2 },
        { name: 'Marketing', count: 1 },
        { name: 'Finance', count: 1 },
        { name: 'HR', count: 1 },
        { name: 'Management', count: 1 }
      ];
      const maxDept = Math.max(...depts.map(d => d.count), 1);

      deptList.innerHTML = '';
      depts.forEach(({ name, count }) => {
        const row = document.createElement('div');
        row.className = 'dept-row';
        row.innerHTML = `
          <div class="dept-head">
            <span class="name">${name}</span>
            <span class="count">${count}</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill" style="width:${(count / maxDept * 100)}%"></div>
          </div>
        `;
        deptList.appendChild(row);
      });
    }

    // ---- Recent Activities ----
    const activitiesList = document.getElementById('dashboardActivitiesList');
    function renderActivities(customActs) {
      if (!activitiesList) return;
      if (!customActs || customActs.length === 0) {
        activitiesList.innerHTML = '<div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px; font-weight: 500;">No recent system activities found.</div>';
        return;
      }
      activitiesList.innerHTML = '';
      customActs.forEach(act => {
        const item = document.createElement('div');
        item.className = 'activity-item';
        item.innerHTML = `
          <div class="activity-icon ${act.icon || 'blue'}"></div>
          <div class="activity-text">
            <p>${act.title}</p>
            <span>${act.date}</span>
          </div>
        `;
        activitiesList.appendChild(item);
      });
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
            // Update KPI cards
            if (d.kpi) {
              const kpi = d.kpi;
              if (document.getElementById('kpiTotalEmployees')) document.getElementById('kpiTotalEmployees').textContent = kpi.total_employees;
              if (document.getElementById('kpiActiveEmployees')) document.getElementById('kpiActiveEmployees').textContent = kpi.active_employees;
              if (document.getElementById('kpiPendingTasks')) document.getElementById('kpiPendingTasks').textContent = kpi.pending_tasks;
              if (document.getElementById('kpiCompletedTasks')) document.getElementById('kpiCompletedTasks').textContent = kpi.completed_tasks;
              if (document.getElementById('kpiPendingLeaves')) document.getElementById('kpiPendingLeaves').textContent = kpi.pending_leaves;
            }

            // Update Task Status Legend
            if (d.task_status) {
              d.task_status.forEach(ts => {
                if (ts.label === 'Completed' && document.getElementById('legendCompleted')) {
                  document.getElementById('legendCompleted').textContent = ts.count;
                } else if (ts.label === 'In Progress' && document.getElementById('legendInProgress')) {
                  document.getElementById('legendInProgress').textContent = ts.count;
                } else if (ts.label === 'Pending' && document.getElementById('legendPending')) {
                  document.getElementById('legendPending').textContent = ts.count;
                }
              });
            }

            // Update Bar Chart
            if (d.monthly_tasks) {
              renderBarChart(d.monthly_tasks);
            }

            // Update Department Distribution
            if (d.departments) {
              renderDepartments(d.departments);
            }

            // Update Activities
            if (d.activities) {
              renderActivities(d.activities);
            }
          }
        })
        .catch(err => {
          console.warn('Dashboard data fetch note (using defaults):', err);
        });
    }

    // Initial render & animation play
    renderBarChart();
    playDonutAnimation();
    renderDepartments();
    fetchLiveDashboardData();

    // Global playback function for tab switching
    window.playDashboardChartAnimations = function() {
      renderBarChart();
      playDonutAnimation();
      fetchLiveDashboardData();
    };

  });
})();
</script>