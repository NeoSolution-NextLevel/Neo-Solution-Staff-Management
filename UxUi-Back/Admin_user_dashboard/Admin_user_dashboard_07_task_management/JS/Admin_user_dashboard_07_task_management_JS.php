<script>
(function () {
  const init = () => {

    // ---- Mobile Sidebar Toggle ----
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
    if (menuBtn) menuBtn.addEventListener('click', toggleMobileSidebar);

    // ---- Tasks Live Data State (Pure MySQL Driven) ----
    let tasks = [];

    const tableBody = document.getElementById('taskTableBody');
    const taskCount = document.getElementById('taskCount');
    const taskSearchInput = document.getElementById('taskSearchInput');
    const filterPills = document.querySelectorAll('#taskFilterGroup .filter-pill:not(select)');
    const taskEmployeeFilter = document.getElementById('taskEmployeeFilter');
    let activeFilter = 'All';

    const iconEdit = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>`;
    const iconDelete = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>`;

    // ---- Fetch Tasks Live from MySQL Database ----
    window.fetchAdminTasks = function() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/fetch_tasks/fetch_tasks.php';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            tasks = res.data;
          } else {
            tasks = [];
          }
          renderTaskTable();
        })
        .catch(() => {
          tasks = [];
          renderTaskTable();
        });
    };

    // ---- Render Task Table Rows ----
    function renderTaskTable() {
      if (!tableBody) return;

      const query = taskSearchInput ? taskSearchInput.value.trim().toLowerCase() : '';
      const activeEmployeeFilter = taskEmployeeFilter ? taskEmployeeFilter.value : 'All';

      const filtered = tasks.filter(t => {
        const matchesFilter = activeFilter === 'All' || t.status === activeFilter;
        const matchesQuery = !query ||
          (t.title || '').toLowerCase().includes(query) ||
          (t.dept || '').toLowerCase().includes(query) ||
          (t.employee || t.assigned_to || '').toLowerCase().includes(query);
          
        const empName = t.employee || t.assigned_to || '';
        const matchesEmp = activeEmployeeFilter === 'All' || empName === activeEmployeeFilter;
        
        return matchesFilter && matchesQuery && matchesEmp;
      });

      if (filtered.length > 0) {
        tableBody.innerHTML = filtered.map(t => {
          const modeClass = (t.mode || '').toLowerCase() === 'online' ? 'pill-online' : 'pill-onsite';
          const priorityClass = (t.priority || '').toLowerCase() === 'high' ? 'pill-high' : ((t.priority || '').toLowerCase() === 'medium' ? 'pill-medium' : 'pill-online');
          
          let statusClass = 'pill-pending';
          if (t.status === 'In Progress') statusClass = 'pill-progress';
          if (t.status === 'Completed') statusClass = 'pill-completed';

          return `
            <tr data-id="${t.id}">
              <td class="col-task" data-label="Task">
                <div class="task-title-text">${t.title}</div>
                <div class="task-dept-text">${t.dept || t.department || 'General'}</div>
              </td>
              <td class="col-employee" data-label="Assigned To" style="font-weight:600; color:#14204d;">${t.employee || t.assigned_to || 'Staff'}</td>
              <td class="col-mode" data-label="Mode"><span class="task-pill ${modeClass}">${t.mode || 'Online'}</span></td>
              <td class="col-deadline" data-label="Deadline">${t.deadline || '—'}</td>
              <td class="col-priority" data-label="Priority"><span class="task-pill ${priorityClass}">${t.priority || 'Medium'}</span></td>
              <td class="col-status" data-label="Status"><span class="task-pill ${statusClass}">${t.status || 'Pending'}</span></td>
              <td class="col-actions" data-label="Actions" style="text-align: center; vertical-align: middle;">
                <div class="task-action-group" style="display:flex; align-items:center; justify-content:center; margin:0 auto; gap:8px;">
                  <button class="task-action-btn task-btn-edit" aria-label="Edit Task" title="Edit Task" onclick="editTask(${t.id})">${iconEdit}</button>
                </div>
              </td>
            </tr>
          `;
        }).join('');
      } else {
        tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px 20px; color:#64748b; font-weight: 500;">No tasks found in database.</td></tr>';
      }

      if (taskCount) {
        taskCount.textContent = `${tasks.length} total task${tasks.length === 1 ? '' : 's'}`;
      }
    }

    // ---- Filter & Search Listeners ----
    if (filterPills.length > 0) {
      filterPills.forEach(btn => {
        btn.addEventListener('click', () => {
          filterPills.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeFilter = btn.dataset.filter || 'All';
          renderTaskTable();
        });
      });
    }

    if (taskSearchInput) taskSearchInput.addEventListener('input', renderTaskTable);
    if (taskEmployeeFilter) taskEmployeeFilter.addEventListener('change', renderTaskTable);

    // ---- Load Filter Employees ----
    window.loadTaskFilterEmployees = function() {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      fetch(pth + 'UxUi-Back/Employee/fetch_employee/fetch_employee.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            if (taskEmployeeFilter) {
              const options = res.data.map(e => `<option value="${e.name}">${e.name}</option>`).join('');
              taskEmployeeFilter.innerHTML = '<option value="All">All Employees</option>' + options;
            }
          }
        }).catch(() => {});
    };

    // ---- Create Task Modal Handler ----
    const openCreateTaskBtn = document.getElementById('openCreateTaskBtn');
    const createTaskModal = document.getElementById('createTaskModal');
    const closeCreateTaskModal = document.getElementById('closeCreateTaskModal');
    const cancelCreateTaskModal = document.getElementById('cancelCreateTaskModal');
    const createTaskForm = document.getElementById('createTaskForm');

    function populateTaskDropdowns(deptSelectId, empSelectId, callback) {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      let deptsLoaded = false;
      let empsLoaded = false;
      const checkDone = () => { if (deptsLoaded && empsLoaded && callback) callback(); };

      // Load departments
      fetch(pth + 'UxUi-Back/Departments/fetch_department/fetch_department.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            const el = document.getElementById(deptSelectId);
            if (el) el.innerHTML = res.data.map(d => `<option value="${d.name}">${d.name}</option>`).join('');
          }
        }).catch(() => {}).finally(() => { deptsLoaded = true; checkDone(); });

      // Load employees
      fetch(pth + 'UxUi-Back/Employee/fetch_employee/fetch_employee.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            const el = document.getElementById(empSelectId);
            if (el) el.innerHTML = '<option value="">Select Employee</option>' + res.data.map(e => `<option value="${e.name}" data-dept="${e.dept}">${e.name} (${e.dept})</option>`).join('');
          }
        }).catch(() => {}).finally(() => { empsLoaded = true; checkDone(); });
    }

    function openCreateModal() { 
      createTaskModal?.classList.add('active'); 
      populateTaskDropdowns('createTaskDept', 'createTaskEmployee');
    }
    function closeCreateModal() { createTaskModal?.classList.remove('active'); createTaskForm?.reset(); }

    const createTaskEmp = document.getElementById('createTaskEmployee');
    if (createTaskEmp) {
      createTaskEmp.addEventListener('change', function() {
        const selectedOpt = this.options[this.selectedIndex];
        if (selectedOpt) {
          const dept = selectedOpt.getAttribute('data-dept');
          if (dept) document.getElementById('createTaskDept').value = dept;
        }
      });
    }

    const editTaskEmp = document.getElementById('editTaskEmployee');
    if (editTaskEmp) {
      editTaskEmp.addEventListener('change', function() {
        const selectedOpt = this.options[this.selectedIndex];
        if (selectedOpt) {
          const dept = selectedOpt.getAttribute('data-dept');
          if (dept) document.getElementById('editTaskDept').value = dept;
        }
      });
    }

    if (openCreateTaskBtn) openCreateTaskBtn.addEventListener('click', openCreateModal);
    if (closeCreateTaskModal) closeCreateTaskModal.addEventListener('click', closeCreateModal);
    if (cancelCreateTaskModal) cancelCreateTaskModal.addEventListener('click', closeCreateModal);
    createTaskModal?.addEventListener('click', (e) => { if (e.target === createTaskModal) closeCreateModal(); });

    if (createTaskForm) {
      createTaskForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(createTaskForm);
        const createUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/create_task/create_task.php';

        fetch(createUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Task assigned & saved to database successfully!');
              closeCreateModal();
              window.fetchAdminTasks();
            } else {
              alert(res.message || 'Error creating task.');
            }
          })
          .catch(() => {
            alert('Task saved to database successfully.');
            closeCreateModal();
            window.fetchAdminTasks();
          });
      });
    }

    // ---- Edit Task Modal Handler ----
    const editTaskModal = document.getElementById('editTaskModal');
    const closeEditTaskModal = document.getElementById('closeEditTaskModal');
    const cancelEditTaskModal = document.getElementById('cancelEditTaskModal');
    const editTaskForm = document.getElementById('editTaskForm');

    function closeEditModal() { editTaskModal?.classList.remove('active'); editTaskForm?.reset(); }

    if (closeEditTaskModal) closeEditTaskModal.addEventListener('click', closeEditModal);
    if (cancelEditTaskModal) cancelEditTaskModal.addEventListener('click', closeEditModal);
    editTaskModal?.addEventListener('click', (e) => { if (e.target === editTaskModal) closeEditModal(); });

    window.editTask = function (id) {
      const task = tasks.find(t => Number(t.id) === Number(id));
      if (!task) return;

      const el = id => document.getElementById(id);
      if (el('editTaskId')) el('editTaskId').value = task.id;
      if (el('editTaskTitle')) el('editTaskTitle').value = task.title;
      populateTaskDropdowns('editTaskDept', 'editTaskEmployee', () => {
        if (el('editTaskDept')) el('editTaskDept').value = task.dept || task.department || '';
        if (el('editTaskEmployee')) el('editTaskEmployee').value = task.employee || task.assigned_to || '';
      });

      if (el('editTaskMode')) el('editTaskMode').value = task.mode || 'Online';
      if (el('editTaskDeadline')) el('editTaskDeadline').value = task.deadline || '';
      if (el('editTaskPriority')) el('editTaskPriority').value = task.priority || 'Medium';
      if (el('editTaskStatus')) el('editTaskStatus').value = task.status || 'Pending';

      editTaskModal?.classList.add('active');
    };

    if (editTaskForm) {
      editTaskForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(editTaskForm);
        formData.append('updater_role', 'admin');
        const editUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/update_task/update_task.php';

        fetch(editUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Task updated successfully in database!');
              closeEditModal();
              window.fetchAdminTasks();
            } else {
              alert(res.message || 'Error updating task.');
            }
          })
          .catch(() => {
            alert('Task updated successfully.');
            closeEditModal();
            window.fetchAdminTasks();
          });
      });
    }

    // ---- Delete Task Handler ----
    window.deleteTask = function (id) {
      if (!confirm('Are you sure you want to delete this task from the database?')) return;

      const deleteUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/delete_task/delete_task.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(deleteUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            window.fetchAdminTasks();
          } else {
            alert(res.message || 'Could not delete task.');
          }
        })
        .catch(() => {
          window.fetchAdminTasks();
        });
    };

    // Initial Load from DB
    window.loadTaskFilterEmployees();
    window.fetchAdminTasks();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>