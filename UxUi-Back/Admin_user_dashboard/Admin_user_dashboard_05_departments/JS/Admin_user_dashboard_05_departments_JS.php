<script>
(function () {
  const init = () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn_05') || document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (typeof openAdminSidebar === 'function') openAdminSidebar();
      });
    }

    // ---- Department Theme & Colors Palette Engine ----
    function getDepartmentColorTheme(deptName) {
      const name = (deptName || '').toLowerCase().trim();

      // Keyword based vibrant color themes
      if (name.includes('account') || name.includes('finan') || name.includes('audit') || name.includes('tax') || name.includes('bank') || name.includes('pay')) {
        return {
          color: '#10b981',
          badgeBg: '#ecfdf5',
          badgeColor: '#059669'
        };
      }
      if (name.includes('engine') || name.includes('tech') || name.includes('dev') || name.includes('soft') || name.includes('it') || name.includes('qa') || name.includes('system')) {
        return {
          color: '#2563eb',
          badgeBg: '#eff6ff',
          badgeColor: '#1d4ed8'
        };
      }
      if (name.includes('market') || name.includes('sale') || name.includes('media') || name.includes('growth') || name.includes('ad')) {
        return {
          color: '#4f46e5',
          badgeBg: '#eef2ff',
          badgeColor: '#4338ca'
        };
      }
      if (name.includes('hr') || name.includes('human') || name.includes('people') || name.includes('talent') || name.includes('staff')) {
        return {
          color: '#f59e0b',
          badgeBg: '#fffbeb',
          badgeColor: '#b45309'
        };
      }
      if (name.includes('manage') || name.includes('admin') || name.includes('exec') || name.includes('direct') || name.includes('lead')) {
        return {
          color: '#1e293b',
          badgeBg: '#f1f5f9',
          badgeColor: '#0f172a'
        };
      }
      if (name.includes('design') || name.includes('ui') || name.includes('ux') || name.includes('art') || name.includes('creat')) {
        return {
          color: '#ec4899',
          badgeBg: '#fdf2f8',
          badgeColor: '#be185d'
        };
      }
      if (name.includes('support') || name.includes('help') || name.includes('custom') || name.includes('operat') || name.includes('serv')) {
        return {
          color: '#06b6d4',
          badgeBg: '#ecfeff',
          badgeColor: '#0e7490'
        };
      }

      // Hash-based consistent palette for any other custom department name
      const palette = [
        { color: '#3b82f6', badgeBg: '#eff6ff', badgeColor: '#1d4ed8' },
        { color: '#8b5cf6', badgeBg: '#f5f3ff', badgeColor: '#6d28d9' },
        { color: '#0d9488', badgeBg: '#f0fdfa', badgeColor: '#0f766e' },
        { color: '#ea580c', badgeBg: '#fff7ed', badgeColor: '#c2410c' },
        { color: '#6366f1', badgeBg: '#eef2ff', badgeColor: '#4338ca' },
        { color: '#e11d48', badgeBg: '#fff1f2', badgeColor: '#be123c' }
      ];

      let hash = 0;
      for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
      }
      const index = Math.abs(hash) % palette.length;
      return palette[index];
    }

    // ---- State & Data (Loaded Purely from Database) ----
    let departments = [];

    const deptGrid = document.getElementById('deptGrid');
    const deptCount = document.getElementById('deptCount');

    const iconEdit = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>`;
    const iconDelete = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>`;

    // Sync all department dropdowns across the application (Job Roles, Employees, etc.)
    function syncGlobalDepartmentDropdowns() {
      const deptNames = Array.from(new Set(departments.map(d => d.name))).filter(Boolean);

      // 1. Update Job Roles dropdowns and team filter
      if (typeof window.populateJobRoleDepartmentDropdowns === 'function') {
        window.populateJobRoleDepartmentDropdowns(departments);
      }

      // 2. Update Employee dropdowns
      const empSelects = [
        document.getElementById('addEmpDept'),
        document.getElementById('editEmpDept'),
        document.querySelector('#addEmpForm select[name="dept"]'),
        document.querySelector('#editEmpForm select[name="dept"]')
      ];

      empSelects.forEach(sel => {
        if (sel) {
          const curVal = sel.value;
          if (deptNames.length > 0) {
            sel.innerHTML = `<option value="">Select Department...</option>` +
              deptNames.map(name => `<option value="${name}">${name}</option>`).join('');
            if (curVal && deptNames.includes(curVal)) sel.value = curVal;
          } else {
            sel.innerHTML = `<option value="">No departments available</option>`;
          }
        }
      });
    }

    // ---- Render Department Cards with Starting Letter Icons ----
    function renderDeptGrid() {
      if (!deptGrid) return;

      if (departments.length === 0) {
        deptGrid.innerHTML = `
          <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; background: #ffffff; border-radius: 14px; border: 1px dashed #cbd5e1; color: #64748b;">
            <p style="font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">No departments found in database</p>
            <p style="font-size: 13px;">Click <strong>"Add Department"</strong> above to create your first department.</p>
          </div>
        `;
      } else {
        deptGrid.innerHTML = departments.map(d => {
          const theme = getDepartmentColorTheme(d.name);
          const initialLetter = (d.name.trim().charAt(0) || 'D').toUpperCase();

          return `
            <div class="dept-card" style="color: ${theme.color};">
              <div class="dept-card-ambient" style="background: ${theme.color};"></div>
              <div class="card-icon" style="background-color: ${theme.color};">
                ${initialLetter}
              </div>
              <div class="card-info">
                <h3>${d.name}</h3>
                <p>Head: ${d.head}</p>
              </div>
              <div class="card-footer">
                <span class="emp-count-badge" style="background-color: ${theme.badgeBg}; color: ${theme.badgeColor};">
                  ${d.employees} Employee${d.employees === 1 ? '' : 's'}
                </span>
                <div class="card-actions">
                  <button class="action-btn action-edit" title="Edit Department" onclick="editDepartment(${d.id})">${iconEdit}</button>
                  <button class="action-btn action-delete" title="Delete Department" onclick="deleteDepartment(${d.id})">${iconDelete}</button>
                </div>
              </div>
            </div>
          `;
        }).join('');
      }

      if (deptCount) {
        deptCount.textContent = `${departments.length} department${departments.length === 1 ? '' : 's'} defined`;
      }

      // Synchronize across other modules
      syncGlobalDepartmentDropdowns();
    }

    // ---- Fetch Departments directly from Database ----
    window.fetchAdminDepartments = function() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Departments/fetch_department/fetch_department.php';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            departments = res.data;
          } else {
            departments = [];
          }
          renderDeptGrid();
        })
        .catch(() => {
          renderDeptGrid();
        });
    };

    // ---- Add Department Modal Logic ----
    const openAddDeptBtn = document.getElementById('openAddDeptBtn');
    const addDeptModal = document.getElementById('addDeptModal');
    const closeAddDeptModal = document.getElementById('closeAddDeptModal');
    const cancelAddDeptModal = document.getElementById('cancelAddDeptModal');
    const addDeptForm = document.getElementById('addDeptForm');

    function openAddModal() { addDeptModal?.classList.add('active'); }
    function closeAddModal() { addDeptModal?.classList.remove('active'); addDeptForm?.reset(); }

    if (openAddDeptBtn) openAddDeptBtn.addEventListener('click', openAddModal);
    if (closeAddDeptModal) closeAddDeptModal.addEventListener('click', closeAddModal);
    if (cancelAddDeptModal) cancelAddDeptModal.addEventListener('click', closeAddModal);
    addDeptModal?.addEventListener('click', (e) => { if (e.target === addDeptModal) closeAddModal(); });

    if (addDeptForm) {
      addDeptForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addDeptForm);
        const addUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Departments/add_department/add_department.php';

        fetch(addUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              closeAddModal();
              window.fetchAdminDepartments();
              alert('Department created successfully!');
            } else {
              alert(res.message || 'Error creating department.');
            }
          })
          .catch(() => {
            alert('Failed to connect to server.');
          });
      });
    }

    // ---- Edit Department Modal Logic ----
    const editDeptModal = document.getElementById('editDeptModal');
    const closeEditDeptModal = document.getElementById('closeEditDeptModal');
    const cancelEditDeptModal = document.getElementById('cancelEditDeptModal');
    const editDeptForm = document.getElementById('editDeptForm');

    function closeEditModal() { editDeptModal?.classList.remove('active'); editDeptForm?.reset(); }

    if (closeEditDeptModal) closeEditDeptModal.addEventListener('click', closeEditModal);
    if (cancelEditDeptModal) cancelEditDeptModal.addEventListener('click', closeEditModal);
    editDeptModal?.addEventListener('click', (e) => { if (e.target === editDeptModal) closeEditModal(); });

    window.editDepartment = function (id) {
      const dept = departments.find(d => Number(d.id) === Number(id));
      if (!dept) return;

      document.getElementById('editDeptId').value = dept.id;
      document.getElementById('editDeptName').value = dept.name;
      document.getElementById('editDeptHead').value = dept.head;
      document.getElementById('editDeptEmployees').value = dept.employees;

      editDeptModal?.classList.add('active');
    };

    if (editDeptForm) {
      editDeptForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(editDeptForm);
        const editUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Departments/edit_department/edit_department.php';

        fetch(editUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              closeEditModal();
              window.fetchAdminDepartments();
              alert('Department updated successfully!');
            } else {
              alert(res.message || 'Error updating department.');
            }
          })
          .catch(() => {
            alert('Failed to connect to server.');
          });
      });
    }

    // ---- Delete Department Handler ----
    window.deleteDepartment = function (id) {
      if (!confirm('Are you sure you want to delete this department from the database?')) return;

      const deleteUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Departments/delete_department/delete_department.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(deleteUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            window.fetchAdminDepartments();
          } else {
            alert(res.message || 'Could not delete department.');
          }
        })
        .catch(() => {
          window.fetchAdminDepartments();
        });
    };

    // Initial Load from Database
    window.fetchAdminDepartments();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>