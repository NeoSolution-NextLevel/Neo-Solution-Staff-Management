<script>
(function () {
  const init = () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn_06') || document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (typeof openAdminSidebar === 'function') openAdminSidebar();
      });
    }

    // ---- Job Roles State (Loaded Purely from Database) ----
    let jobRoles = [];

    const tableBody = document.getElementById('jobRolesTableBody');
    const mobileCards = document.getElementById('mobileJobRolesCardsContainer');
    const jobRolesCount = document.getElementById('jobRolesCount');
    const roleSearchInput = document.getElementById('roleSearchInput');
    const teamFilter = document.getElementById('jobRolesTeamFilter');

    const iconBriefcase = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>`;
    const iconEdit = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>`;
    const iconDelete = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>`;

    // ---- Render Table Rows & Mobile Cards ----
    function renderTable() {
      const query = roleSearchInput ? roleSearchInput.value.trim().toLowerCase() : '';
      const selectedTeam = teamFilter ? teamFilter.value : 'all';

      const filtered = jobRoles.filter(r => {
        const matchesTeam = (selectedTeam === 'all') || (r.dept && r.dept.toLowerCase() === selectedTeam.toLowerCase());
        const matchesQuery = !query ||
          (r.title && r.title.toLowerCase().includes(query)) ||
          (r.dept && r.dept.toLowerCase().includes(query));
        return matchesTeam && matchesQuery;
      });

      // 1. Desktop Table
      if (tableBody) {
        if (filtered.length > 0) {
          tableBody.innerHTML = filtered.map(r => `
            <tr data-id="${r.id}">
              <td>
                <div class="job-cell">
                  <div class="role-icon">${iconBriefcase}</div>
                  <span class="job-title">${r.title}</span>
                </div>
              </td>
              <td class="dept-cell">${r.dept}</td>
              <td><span class="employee-badge">${r.employees}</span></td>
              <td>
                <div class="action-group">
                  <button class="action-btn btn-edit" title="Edit Role" onclick="editJobRole(${r.id})">${iconEdit}</button>
                  <button class="action-btn btn-delete" title="Delete Role" onclick="deleteJobRole(${r.id})">${iconDelete}</button>
                </div>
              </td>
            </tr>
          `).join('');
        } else {
          tableBody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding: 30px 20px; color: #64748b;">No job roles found in database.</td></tr>';
        }
      }

      // 2. Mobile Responsive Cards
      if (mobileCards) {
        if (filtered.length > 0) {
          mobileCards.innerHTML = filtered.map(r => `
            <div class="mobile-role-card">
              <div class="mobile-role-card-head">
                <div class="job-cell">
                  <div class="role-icon">${iconBriefcase}</div>
                  <div>
                    <div class="job-title">${r.title}</div>
                    <div style="font-size:12px; color:#64748b; margin-top:2px;">${r.dept}</div>
                  </div>
                </div>
                <span class="employee-badge" title="Assigned Employees">${r.employees} staff</span>
              </div>
              <div class="mobile-role-details">
                <div class="mobile-role-row">
                  <span style="color:#64748b; font-weight:600;">Department:</span>
                  <span style="color:#1e293b; font-weight:700;">${r.dept}</span>
                </div>
                <div class="mobile-role-row">
                  <span style="color:#64748b; font-weight:600;">Employees:</span>
                  <span style="color:var(--primary); font-weight:700;">${r.employees} active</span>
                </div>
              </div>
              <div class="mobile-role-actions">
                <button type="button" class="btn-mobile-role-edit" onclick="editJobRole(${r.id})">
                  <i class="fa-solid fa-pen"></i> Edit
                </button>
                <button type="button" class="btn-mobile-role-del" onclick="deleteJobRole(${r.id})">
                  <i class="fa-solid fa-trash"></i> Delete
                </button>
              </div>
            </div>
          `).join('');
        } else {
          mobileCards.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #64748b; background:#fff; border-radius:12px;">No job roles found.</div>';
        }
      }

      if (jobRolesCount) {
        jobRolesCount.textContent = `${jobRoles.length} role${jobRoles.length === 1 ? '' : 's'} defined`;
      }
    }

    // ---- Populate Department Dropdowns dynamically from Database ----
    window.populateJobRoleDepartmentDropdowns = function(deptList) {
      const addSelect = document.getElementById('addJobRoleDept');
      const editSelect = document.getElementById('editJobRoleDept');
      const filterSelect = document.getElementById('jobRolesTeamFilter');

      const deptNames = Array.isArray(deptList) 
        ? Array.from(new Set(deptList.map(d => typeof d === 'string' ? d : d.name))).filter(Boolean)
        : [];

      if (addSelect) {
        const curVal = addSelect.value;
        if (deptNames.length > 0) {
          addSelect.innerHTML = `<option value="">Select Department...</option>` +
            deptNames.map(name => `<option value="${name}">${name}</option>`).join('');
          if (curVal && deptNames.includes(curVal)) addSelect.value = curVal;
        } else {
          addSelect.innerHTML = `<option value="">No departments created yet (Add from Departments page)</option>`;
        }
      }

      if (editSelect) {
        const curVal = editSelect.value;
        if (deptNames.length > 0) {
          editSelect.innerHTML = `<option value="">Select Department...</option>` +
            deptNames.map(name => `<option value="${name}">${name}</option>`).join('');
          if (curVal && deptNames.includes(curVal)) editSelect.value = curVal;
        } else {
          editSelect.innerHTML = `<option value="">No departments created yet</option>`;
        }
      }

      if (filterSelect) {
        const curFilter = filterSelect.value;
        filterSelect.innerHTML = `<option value="all">All Departments / Teams</option>` +
          deptNames.map(name => `<option value="${name}">${name}</option>`).join('');
        if (curFilter) filterSelect.value = curFilter;
      }
    };

    // Filter event listeners
    if (roleSearchInput) roleSearchInput.addEventListener('input', renderTable);
    if (teamFilter) teamFilter.addEventListener('change', renderTable);

    // ---- Fetch Job Roles from Database ----
    window.fetchAdminJobRoles = function() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Job_Roles/fetch_job_roles/fetch_job_roles.php';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            jobRoles = res.data;
          } else {
            jobRoles = [];
          }
          renderTable();
        })
        .catch(() => {
          renderTable();
        });
    };

    // Fetch live departments from database
    window.loadLiveDepartmentsIntoJobRoles = function() {
      const deptUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Departments/fetch_department/fetch_department.php';
      fetch(deptUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            window.populateJobRoleDepartmentDropdowns(res.data);
          } else {
            window.populateJobRoleDepartmentDropdowns([]);
          }
        })
        .catch(() => {
          window.populateJobRoleDepartmentDropdowns([]);
        });
    };

    // ---- Add Job Role Modal Handler ----
    const openAddJobRoleBtn = document.getElementById('openAddJobRoleBtn');
    const addJobRoleModal = document.getElementById('addJobRoleModal');
    const closeAddJobRoleModal = document.getElementById('closeAddJobRoleModal');
    const cancelAddJobRoleModal = document.getElementById('cancelAddJobRoleModal');
    const addJobRoleForm = document.getElementById('addJobRoleForm');

    function openAddModal() { 
      window.loadLiveDepartmentsIntoJobRoles();
      addJobRoleModal?.classList.add('active'); 
    }
    function closeAddModal() { 
      addJobRoleModal?.classList.remove('active'); 
      addJobRoleForm?.reset(); 
    }

    if (openAddJobRoleBtn) openAddJobRoleBtn.addEventListener('click', openAddModal);
    if (closeAddJobRoleModal) closeAddJobRoleModal.addEventListener('click', closeAddModal);
    if (cancelAddJobRoleModal) cancelAddJobRoleModal.addEventListener('click', closeAddModal);
    addJobRoleModal?.addEventListener('click', (e) => { if (e.target === addJobRoleModal) closeAddModal(); });

    if (addJobRoleForm) {
      addJobRoleForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addJobRoleForm);
        const addUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Job_Roles/add_job_roles/add_job_roles.php';

        fetch(addUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              closeAddModal();
              window.fetchAdminJobRoles();
              alert('Job Role created and saved to database successfully!');
            } else {
              alert(res.message || 'Error creating job role.');
            }
          })
          .catch(() => {
            alert('Failed to connect to server.');
          });
      });
    }

    // ---- Edit Job Role Modal Handler ----
    const editJobRoleModal = document.getElementById('editJobRoleModal');
    const closeEditJobRoleModal = document.getElementById('closeEditJobRoleModal');
    const cancelEditJobRoleModal = document.getElementById('cancelEditJobRoleModal');
    const editJobRoleForm = document.getElementById('editJobRoleForm');

    function closeEditModal() { editJobRoleModal?.classList.remove('active'); editJobRoleForm?.reset(); }

    if (closeEditJobRoleModal) closeEditJobRoleModal.addEventListener('click', closeEditModal);
    if (cancelEditJobRoleModal) cancelEditJobRoleModal.addEventListener('click', closeEditModal);
    editJobRoleModal?.addEventListener('click', (e) => { if (e.target === editJobRoleModal) closeEditModal(); });

    window.editJobRole = function (id) {
      window.loadLiveDepartmentsIntoJobRoles();
      const role = jobRoles.find(r => Number(r.id) === Number(id));
      if (!role) return;

      document.getElementById('editJobRoleId').value = role.id;
      document.getElementById('editJobRoleTitle').value = role.title;
      document.getElementById('editJobRoleDept').value = role.dept;
      document.getElementById('editJobRoleEmployees').value = role.employees;

      editJobRoleModal?.classList.add('active');
    };

    if (editJobRoleForm) {
      editJobRoleForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(editJobRoleForm);
        const editUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Job_Roles/edit_job_roles/edit_job_roles.php';

        fetch(editUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              closeEditModal();
              window.fetchAdminJobRoles();
              alert('Job Role updated in database successfully!');
            } else {
              alert(res.message || 'Error updating job role.');
            }
          })
          .catch(() => {
            alert('Failed to connect to server.');
          });
      });
    }

    // ---- Delete Job Role Handler ----
    window.deleteJobRole = function (id) {
      if (!confirm('Are you sure you want to delete this job role from database?')) return;

      const deleteUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Job_Roles/delete_job_roles/delete_job_roles.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(deleteUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            window.fetchAdminJobRoles();
          } else {
            alert(res.message || 'Could not delete job role.');
          }
        })
        .catch(() => {
          window.fetchAdminJobRoles();
        });
    };

    // Initial Load from Database
    window.loadLiveDepartmentsIntoJobRoles();
    window.fetchAdminJobRoles();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>