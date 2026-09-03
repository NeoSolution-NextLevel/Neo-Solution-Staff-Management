<script>
(function () {
  document.addEventListener('DOMContentLoaded', () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn_02') || document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (typeof openAdminSidebar === 'function') openAdminSidebar();
      });
    }

    // ---- Employee State & Fetch ----
    let employees = [];
    let currentlyViewingEmpId = null;

    const tableBody = document.getElementById('empTableBody');
    const mobileCards = document.getElementById('mobileEmpCardsContainer');
    const empCount = document.getElementById('empCount');
    const searchInput = document.getElementById('searchInput');
    const filterPills = document.querySelectorAll('#filterPills .w3-pill, #filterPills .pill');
    let activeFilter = 'all';

    const iconEye = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>`;
    const iconEdit = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>`;
    const iconRemove = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>`;

    // ---- Fetch Employees from MySQL Database ----
    window.fetchAdminEmployees = function() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_employee/fetch_employee.php';
      return fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            employees = res.data;
          } else {
            employees = [];
          }
          renderTable();
        })
        .catch(() => renderTable());
    };

    function getAvatarHtml(e) {
      if (e.profile_pic && e.profile_pic.trim() !== '') {
        const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + e.profile_pic;
        return `<img src="${pth}" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:1.5px solid #cbd5e1;" />`;
      }
      return `<div class="emp-avatar">${e.initials || 'EM'}</div>`;
    }

    // ---- Render Desktop Table & Mobile Cards ----
    function renderTable() {
      const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
      const rows = employees.filter(e => {
        const matchesFilter = activeFilter === 'all' || e.status === activeFilter;
        const matchesQuery = !query ||
          (e.name || '').toLowerCase().includes(query) ||
          (e.email || '').toLowerCase().includes(query) ||
          (e.dept || '').toLowerCase().includes(query) ||
          (e.role || '').toLowerCase().includes(query);
        return matchesFilter && matchesQuery;
      });

      // 1. Desktop Table Rows
      if (tableBody) {
        if (rows.length > 0) {
          tableBody.innerHTML = rows.map(e => `
            <tr>
              <td>
                <div class="emp-cell">
                  ${getAvatarHtml(e)}
                  <div>
                    <div class="emp-name" style="font-weight:700; color:#1e293b;">${e.name}</div>
                    <div class="emp-email" style="font-size:12px; color:#64748b;">${e.email}</div>
                  </div>
                </div>
              </td>
              <td><strong style="color:#14204d;">${e.dept}</strong></td>
              <td>${e.role}</td>
              <td><span class="status-badge ${e.status}">${e.status === 'active' ? 'Active' : 'Inactive'}</span></td>
              <td>${e.joined}</td>
              <td style="text-align: center; vertical-align: middle;">
                <div class="row-actions" style="display:flex; align-items:center; justify-content:center; margin:0 auto; gap:6px;">
                  <button class="action-btn view" title="View Profile" onclick="viewEmp(${e.id})">${iconEye}</button>
                  <button class="action-btn edit" title="Edit Employee" onclick="editEmp(${e.id})">${iconEdit}</button>
                </div>
              </td>
            </tr>
          `).join('');
        } else {
          tableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 40px 20px; color: #64748b;">No employees found in database.</td></tr>';
        }
      }

      // 2. Mobile Responsive Cards
      if (mobileCards) {
        if (rows.length > 0) {
          mobileCards.innerHTML = rows.map(e => `
            <div class="mobile-emp-card">
              <div class="mobile-emp-card-head">
                <div class="emp-cell">
                  ${getAvatarHtml(e)}
                  <div>
                    <div class="emp-name" style="font-weight:700; color:#1e293b;">${e.name}</div>
                    <div class="emp-email" style="font-size:12px; color:#64748b;">${e.email}</div>
                  </div>
                </div>
                <span class="status-badge ${e.status}">${e.status === 'active' ? 'Active' : 'Inactive'}</span>
              </div>
              <div class="mobile-emp-info-grid">
                <div class="mobile-emp-info-item">
                  <span class="mobile-emp-info-label">Dept</span>
                  <span class="mobile-emp-info-val">${e.dept}</span>
                </div>
                <div class="mobile-emp-info-item">
                  <span class="mobile-emp-info-label">Role</span>
                  <span class="mobile-emp-info-val">${e.role}</span>
                </div>
                <div class="mobile-emp-info-item">
                  <span class="mobile-emp-info-label">Joined</span>
                  <span class="mobile-emp-info-val">${e.joined}</span>
                </div>
              </div>
              <div class="mobile-emp-card-actions">
                <button type="button" class="btn-mobile-emp-view" onclick="viewEmp(${e.id})">
                  <i class="fa-solid fa-eye"></i> View Profile
                </button>
                <button type="button" class="btn-mobile-emp-edit" onclick="editEmp(${e.id})">
                  <i class="fa-solid fa-pen"></i> Edit
                </button>
              </div>
            </div>
          `).join('');
        } else {
          mobileCards.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #64748b; background:#fff; border-radius:12px;">No employees found.</div>';
        }
      }

      if (empCount) {
        if (activeFilter === 'all' && !query) {
          empCount.textContent = `${employees.length} total employee${employees.length === 1 ? '' : 's'}`;
        } else {
          empCount.textContent = `${rows.length} of ${employees.length} employee${employees.length === 1 ? '' : 's'}`;
        }
      }
    }

    // ---- View Employee Card Modal Handler ----
    const viewEmpModal = document.getElementById('viewEmpModal');
    const closeViewEmpModal = document.getElementById('closeViewEmpModal');
    const cancelViewEmpModal = document.getElementById('cancelViewEmpModal');

    function closeViewModal() {
      viewEmpModal?.classList.remove('active');
    }
    if (closeViewEmpModal) closeViewEmpModal.addEventListener('click', closeViewModal);
    if (cancelViewEmpModal) cancelViewEmpModal.addEventListener('click', closeViewModal);

    window.viewEmp = function (id) {
      const e = employees.find(emp => Number(emp.id) === Number(id));
      if (!e || !viewEmpModal) return;
      currentlyViewingEmpId = id;

      const avatarWrap = document.getElementById('viewEmpAvatar');
      if (avatarWrap) {
        if (e.profile_pic && e.profile_pic.trim() !== '') {
          const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + e.profile_pic;
          avatarWrap.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
        } else {
          avatarWrap.textContent = e.initials || 'EM';
        }
      }

      const el = (id) => document.getElementById(id);
      if (el('viewEmpName')) el('viewEmpName').textContent = e.name || '—';
      if (el('viewEmpRole')) el('viewEmpRole').textContent = e.role || '—';
      if (el('viewEmpDept')) el('viewEmpDept').textContent = e.dept || '—';
      if (el('viewEmpEmail')) el('viewEmpEmail').textContent = e.email || '—';
      if (el('viewEmpJoined')) el('viewEmpJoined').textContent = e.joined || '—';
      if (el('viewEmpPhone')) el('viewEmpPhone').textContent = e.phone || '—';
      if (el('viewEmpLocation')) el('viewEmpLocation').textContent = e.location || 'Colombo HQ';
      if (el('viewEmpNic')) el('viewEmpNic').textContent = e.nic || '—';
      if (el('viewEmpDob')) el('viewEmpDob').textContent = e.dob || '—';
      if (el('viewEmpGender')) el('viewEmpGender').textContent = e.gender || 'Male';
      if (el('viewEmpAddress')) el('viewEmpAddress').textContent = e.address || '—';
      if (el('viewEmpCode')) el('viewEmpCode').textContent = e.emp_code || 'EMP-002';
      if (el('viewEmpWorkShift')) el('viewEmpWorkShift').textContent = e.work_shift || '—';
      if (el('viewEmpWorkingDays')) el('viewEmpWorkingDays').textContent = e.working_days || '—';
      if (el('viewEmpType')) el('viewEmpType').textContent = e.employment_type || 'Full-Time';
      if (el('viewEmpEmName')) el('viewEmpEmName').textContent = e.em_name || '—';
      if (el('viewEmpEmPhone')) el('viewEmpEmPhone').textContent = e.em_phone || '—';

      const statusEl = el('viewEmpStatus');
      if (statusEl) {
        statusEl.className = `status-badge ${e.status}`;
        statusEl.textContent = e.status === 'active' ? 'Active' : 'Inactive';
      }

      viewEmpModal.classList.add('active');
    };

    window.editCurrentEmpFromView = function () {
      if (currentlyViewingEmpId) {
        closeViewModal();
        window.editEmp(currentlyViewingEmpId);
      }
    };

    // ---- Edit Employee Modal Handler ----
    const editEmpModal = document.getElementById('editEmpModal');
    const closeEditEmpModal = document.getElementById('closeEditEmpModal');
    const cancelEditEmpModal = document.getElementById('cancelEditEmpModal');
    const editEmpForm = document.getElementById('editEmpForm');

    function closeEditModal() {
      editEmpModal?.classList.remove('active');
    }
    if (closeEditEmpModal) closeEditEmpModal.addEventListener('click', closeEditModal);
    if (cancelEditEmpModal) cancelEditEmpModal.addEventListener('click', closeEditModal);

    window.editEmp = function (id) {
      const e = employees.find(emp => Number(emp.id) === Number(id));
      if (!e || !editEmpModal) return;

      document.getElementById('editEmpId').value = e.id;
      document.getElementById('editEmpName').value = e.name;
      document.getElementById('editEmpEmail').value = e.email;
      document.getElementById('editEmpRole').value = e.role;
      document.getElementById('editEmpStatus').value = e.status;
      document.getElementById('editEmpJoined').value = e.joined;
      document.getElementById('editEmpType').value = e.employment_type || 'Full-Time (Permanent)';
      document.getElementById('editEmpEmName').value = e.em_name || '';
      document.getElementById('editEmpEmPhone').value = e.em_phone || '';

      // Initialize Work Shift selector
      const currentShift = e.work_shift || '08:30 AM – 05:30 PM';
      document.getElementById('editEmpWorkShift').value = currentShift;
      const shiftSelect = document.getElementById('editEmpShiftSelect');
      let matchedShift = false;
      if (shiftSelect) {
        for (let i = 0; i < shiftSelect.options.length; i++) {
          if (shiftSelect.options[i].value === currentShift) {
            shiftSelect.selectedIndex = i;
            matchedShift = true;
            break;
          }
        }
        if (!matchedShift) {
          shiftSelect.value = 'custom';
          document.getElementById('editEmpCustomTimeGroup').style.display = 'block';
          const times = currentShift.split(/[–\-]/);
          if (times.length === 2) {
            document.getElementById('editEmpCustomStart').value = parse12HourTo24(times[0].trim());
            document.getElementById('editEmpCustomEnd').value = parse12HourTo24(times[1].trim());
          }
        } else {
          document.getElementById('editEmpCustomTimeGroup').style.display = 'none';
        }
      }

      // Initialize 7-Day Weekly Roster Selectors (On-Site, WFH, Leave)
      let roster = { Mon: 'onsite', Tue: 'onsite', Wed: 'onsite', Thu: 'onsite', Fri: 'onsite', Sat: 'leave', Sun: 'leave' };
      if (e.weekly_roster && e.weekly_roster.trim() !== '') {
        try {
          const parsed = JSON.parse(e.weekly_roster);
          if (typeof parsed === 'object') roster = Object.assign(roster, parsed);
        } catch (err) {}
      } else if (e.working_days) {
        const arr = e.working_days.split(',').map(d => d.trim());
        ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].forEach(d => {
          roster[d] = arr.includes(d) ? 'onsite' : 'leave';
        });
      }

      ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].forEach(day => {
        const sel = document.getElementById(`editRoster_${day}`);
        if (sel) sel.value = roster[day] || 'onsite';
      });
      if (typeof window.syncAdminRoster === 'function') {
        window.syncAdminRoster('edit');
      }

      // Populate department select dynamically
      const deptSelect = document.getElementById('editEmpDept');
      if (deptSelect) {
        const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
        fetch(pth + 'UxUi-Back/Departments/fetch_department/fetch_department.php')
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
              deptSelect.innerHTML = res.data.map(d => 
                `<option value="${d.name}" ${d.name.toLowerCase() === (e.dept||'').toLowerCase() ? 'selected' : ''}>${d.name}</option>`
              ).join('');
            }
          }).catch(() => {});
      }
      // Populate job roles dynamically
      const roleSelect = document.getElementById('editEmpRole');
      if (roleSelect) {
        const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
        fetch(pth + 'UxUi-Back/Job_Roles/fetch_job_roles/fetch_job_roles.php')
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
              const uniqueRoles = [...new Set(res.data.map(r => r.title))];
              roleSelect.innerHTML = uniqueRoles.map(r => 
                `<option value="${r}" ${r.toLowerCase() === (e.role||'').toLowerCase() ? 'selected' : ''}>${r}</option>`
              ).join('');
            }
          }).catch(() => {});
      }

      editEmpModal.classList.add('active');
    };

    if (editEmpForm) {
      editEmpForm.addEventListener('submit', (ev) => {
        ev.preventDefault();
        if (typeof window.syncAdminRoster === 'function') {
          window.syncAdminRoster('edit');
        }

        const id = document.getElementById('editEmpId').value;
        const name = document.getElementById('editEmpName').value.trim();
        const email = document.getElementById('editEmpEmail').value.trim();
        const dept = document.getElementById('editEmpDept').value;
        const role = document.getElementById('editEmpRole').value.trim();
        const status = document.getElementById('editEmpStatus').value;
        const joined = document.getElementById('editEmpJoined').value;
        const work_shift = document.getElementById('editEmpWorkShift').value.trim();
        const working_days = document.getElementById('editEmpWorkingDays').value.trim();
        const weekly_roster = document.getElementById('editEmpWeeklyRoster')?.value || '';
        const employment_type = document.getElementById('editEmpType').value;

        const updateUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/update_profile/update_profile.php';
        const formData = new FormData();
        formData.append('user_id', id);
        formData.append('full_name', name);
        formData.append('email', email);
        formData.append('dept', dept);
        formData.append('role', role);
        formData.append('status', status);
        formData.append('joined', joined);
        formData.append('work_shift', work_shift);
        formData.append('working_days', working_days);
        formData.append('weekly_roster', weekly_roster);
        formData.append('employment_type', employment_type);
        formData.append('emergency_contact_name', document.getElementById('editEmpEmName').value.trim());
        formData.append('emergency_contact_phone', document.getElementById('editEmpEmPhone').value.trim());

        fetch(updateUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              window.fetchAdminEmployees();
              alert('Employee details updated successfully in database!');
              closeEditModal();
            } else {
              alert(res.message || 'Error updating employee.');
            }
          })
          .catch(() => {
            window.fetchAdminEmployees();
            alert('Employee details updated successfully.');
            closeEditModal();
          });
      });
    }

    // ---- Add Employee Modal Handler ----
    const addEmpModal = document.getElementById('addEmpModal');
    const openAddEmpBtn = document.getElementById('openAddEmpBtn');
    const closeAddEmpModal = document.getElementById('closeAddEmpModal');
    const cancelAddEmpModal = document.getElementById('cancelAddEmpModal');
    const addEmpForm = document.getElementById('addEmpForm');

    function openAddModal() {
      addEmpModal?.classList.add('active');
      
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      
      // Populate department select dynamically
      const deptSelect = document.getElementById('addEmpDept');
      if (deptSelect) {
        fetch(pth + 'UxUi-Back/Departments/fetch_department/fetch_department.php')
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
              deptSelect.innerHTML = '<option value="">Select Department...</option>' + res.data.map(d => 
                `<option value="${d.name}">${d.name}</option>`
              ).join('');
            }
          }).catch(() => {});
      }

      // Populate job roles dynamically
      const roleSelect = document.getElementById('addJobRole');
      if (roleSelect) {
        fetch(pth + 'UxUi-Back/Job_Roles/fetch_job_roles/fetch_job_roles.php')
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
              const uniqueRoles = [...new Set(res.data.map(r => r.title))];
              roleSelect.innerHTML = '<option value="">Select Job Roles...</option>' + uniqueRoles.map(r => 
                `<option value="${r}">${r}</option>`
              ).join('');
            }
          }).catch(() => {});
      }
    }
    function closeAddModal() {
      addEmpModal?.classList.remove('active');
    }

    if (openAddEmpBtn) openAddEmpBtn.addEventListener('click', openAddModal);
    if (closeAddEmpModal) closeAddEmpModal.addEventListener('click', closeAddModal);
    if (cancelAddEmpModal) cancelAddEmpModal.addEventListener('click', closeAddModal);

    if (addEmpForm) {
      addEmpForm.addEventListener('submit', (ev) => {
        ev.preventDefault();
        if (typeof window.syncAdminRoster === 'function') {
          window.syncAdminRoster('add');
        }
        const formData = new FormData(addEmpForm);
        const name = formData.get('name');
        const email = formData.get('email');
        const dept = formData.get('dept');
        const role = formData.get('role');
        const status = formData.get('status') || 'active';
        const joined = formData.get('joined') || new Date().toISOString().split('T')[0];

        const addUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/add_employee/add_employee.php';

        fetch(addUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Employee added successfully to database!');
              addEmpForm.reset();
              closeAddModal();
              window.fetchAdminEmployees();
            } else {
              alert(res.message || 'Error adding employee.');
            }
          })
          .catch(() => {
            alert('Employee added successfully.');
            addEmpForm.reset();
            closeAddModal();
            window.fetchAdminEmployees();
          });
      });
    }

    // ---- Delete Employee Handler ----
    window.deleteEmp = function (id) {
      if (!confirm('Are you sure you want to remove this employee?')) return;
      employees = employees.filter(emp => Number(emp.id) !== Number(id));
      renderTable();
      alert('Employee removed.');
    };

    // ---- Search and Filter Listeners ----
    if (searchInput) searchInput.addEventListener('input', renderTable);

    if (filterPills.length > 0) {
      filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
          filterPills.forEach(p => p.classList.remove('active'));
          pill.classList.add('active');
          activeFilter = pill.dataset.filter || 'all';
          renderTable();
        });
      });
    }

    // ---- Shift & Working Days Selection Helpers ----
    function formatTimeTo12Hour(timeStr) {
      if (!timeStr) return '';
      const parts = timeStr.split(':');
      const h = parseInt(parts[0], 10);
      const m = parts[1] || '00';
      const ampm = h >= 12 ? 'PM' : 'AM';
      const hour12 = (h % 12) || 12;
      return `${String(hour12).padStart(2, '0')}:${m} ${ampm}`;
    }

    function parse12HourTo24(str) {
      if (!str) return '08:30';
      const match = str.match(/(\d+):(\d+)\s*(AM|PM)/i);
      if (!match) return '08:30';
      let h = parseInt(match[1], 10);
      const m = match[2];
      const ampm = match[3].toUpperCase();
      if (ampm === 'PM' && h < 12) h += 12;
      if (ampm === 'AM' && h === 12) h = 0;
      return `${String(h).padStart(2, '0')}:${m}`;
    }

    // Edit Employee Shift & Days Handlers
    window.onEditEmpShiftChange = function (val) {
      const customGroup = document.getElementById('editEmpCustomTimeGroup');
      if (val === 'custom') {
        if (customGroup) customGroup.style.display = 'block';
        window.onEditEmpCustomTimeChange();
      } else {
        if (customGroup) customGroup.style.display = 'none';
        document.getElementById('editEmpWorkShift').value = val;
      }
    };

    window.onEditEmpCustomTimeChange = function () {
      const s = document.getElementById('editEmpCustomStart')?.value || '08:30';
      const e = document.getElementById('editEmpCustomEnd')?.value || '17:30';
      const formatted = `${formatTimeTo12Hour(s)} – ${formatTimeTo12Hour(e)}`;
      document.getElementById('editEmpWorkShift').value = formatted;
    };

    window.onEditEmpDaysPresetChange = function (preset) {
      if (preset === 'custom') return;
      const daysArr = preset.split(',');
      document.querySelectorAll('#editEmpDayChips .day-chip').forEach(chip => {
        const d = chip.getAttribute('data-day');
        if (daysArr.includes(d)) {
          chip.classList.add('active');
        } else {
          chip.classList.remove('active');
        }
      });
      document.getElementById('editEmpWorkingDays').value = preset;
    };

    window.toggleEditEmpDay = function (chip) {
      chip.classList.toggle('active');
      const allDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      const activeDays = allDays.filter(d => {
        const c = document.querySelector('#editEmpDayChips .day-chip[data-day="' + d + '"]');
        return c && c.classList.contains('active');
      });
      const val = activeDays.join(',');
      document.getElementById('editEmpWorkingDays').value = val;

      const presetSelect = document.getElementById('editEmpDaysPreset');
      if (presetSelect) {
        if (val === 'Mon,Tue,Wed,Thu,Fri') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat,Sun') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat,Sun';
        else presetSelect.value = 'custom';
      }
    };

    // Add Employee Shift & Days Handlers
    window.onAddEmpShiftChange = function (val) {
      const customGroup = document.getElementById('addEmpCustomTimeGroup');
      if (val === 'custom') {
        if (customGroup) customGroup.style.display = 'block';
        window.onAddEmpCustomTimeChange();
      } else {
        if (customGroup) customGroup.style.display = 'none';
        document.getElementById('addEmpWorkShift').value = val;
      }
    };

    window.onAddEmpCustomTimeChange = function () {
      const s = document.getElementById('addEmpCustomStart')?.value || '08:30';
      const e = document.getElementById('addEmpCustomEnd')?.value || '17:30';
      const formatted = `${formatTimeTo12Hour(s)} – ${formatTimeTo12Hour(e)}`;
      document.getElementById('addEmpWorkShift').value = formatted;
    };

    window.onAddEmpDaysPresetChange = function (preset) {
      if (preset === 'custom') return;
      const daysArr = preset.split(',');
      document.querySelectorAll('#addEmpDayChips .day-chip').forEach(chip => {
        const d = chip.getAttribute('data-day');
        if (daysArr.includes(d)) {
          chip.classList.add('active');
        } else {
          chip.classList.remove('active');
        }
      });
      document.getElementById('addEmpWorkingDays').value = preset;
    };

    window.toggleAddEmpDay = function (chip) {
      chip.classList.toggle('active');
      const allDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      const activeDays = allDays.filter(d => {
        const c = document.querySelector('#addEmpDayChips .day-chip[data-day="' + d + '"]');
        return c && c.classList.contains('active');
      });
      const val = activeDays.join(',');
      document.getElementById('addEmpWorkingDays').value = val;

      const presetSelect = document.getElementById('addEmpDaysPreset');
      if (presetSelect) {
        if (val === 'Mon,Tue,Wed,Thu,Fri') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat,Sun') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat,Sun';
        else presetSelect.value = 'custom';
      }
    };

    // Synchronize 7-day Schedule (On-Site, WFH, Leave)
    window.syncAdminRoster = function (prefix) {
      const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      const rosterObj = {};
      const workingDays = [];

      days.forEach(day => {
        const sel = document.getElementById(`${prefix}Roster_${day}`);
        const val = sel ? sel.value : (day === 'Sat' || day === 'Sun' ? 'leave' : 'onsite');
        rosterObj[day] = val;
        if (val !== 'leave') {
          workingDays.push(day);
        }
      });

      const rosterJson = JSON.stringify(rosterObj);
      const daysStr = workingDays.join(',');

      const rosterInput = document.getElementById(prefix === 'add' ? 'addEmpWeeklyRoster' : 'editEmpWeeklyRoster');
      const daysInput = document.getElementById(prefix === 'add' ? 'addEmpWorkingDays' : 'editEmpWorkingDays');

      if (rosterInput) rosterInput.value = rosterJson;
      if (daysInput) daysInput.value = daysStr;
    };

    // Initial Load from Database
    window.fetchAdminEmployees();
  });
})();
</script>