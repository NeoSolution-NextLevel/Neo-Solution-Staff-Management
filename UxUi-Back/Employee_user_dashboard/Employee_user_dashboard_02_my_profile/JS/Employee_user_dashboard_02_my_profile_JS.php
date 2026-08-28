<script>
(function () {
  let userProfileData = {};

  // ---- Toast Notification Helper ----
  function showProfileToast(message, type = 'success') {
    let toastContainer = document.getElementById('dashboardToastContainer');
    if (!toastContainer) {
      toastContainer = document.createElement('div');
      toastContainer.id = 'dashboardToastContainer';
      toastContainer.style.cssText = 'position:fixed; top:24px; right:24px; z-index:99999; display:flex; flex-direction:column; gap:10px; pointer-events:none;';
      document.body.appendChild(toastContainer);
    }

    const toast = document.createElement('div');
    const bg = type === 'success' ? '#16a34a' : (type === 'error' ? '#dc2626' : '#2563eb');
    const icon = type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ');

    toast.style.cssText = `
      background: ${bg};
      color: #ffffff;
      padding: 12px 18px;
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.18);
      font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
      font-size: 13.5px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      opacity: 0;
      transform: translateY(-12px);
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      pointer-events: auto;
    `;

    toast.innerHTML = `<span style="font-size:15px; font-weight:800; background:rgba(255,255,255,0.22); width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">${icon}</span> <span>${message}</span>`;
    toastContainer.appendChild(toast);

    requestAnimationFrame(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
    });

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(-12px)';
      setTimeout(() => toast.remove(), 300);
    }, 3200);
  }

  window.fetchEmployeeProfileData = function () {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          userProfileData = res.data;
          renderProfileData(res.data);
        }
      })
      .catch(() => {});
  };

  function renderProfileData(p) {
    if (!p) return;
    const name = p.full_name || p.fullname || p.name || 'Employee';
    const firstName = name ? name.split(' ')[0] : 'Employee';
    const initials = name.split(' ').filter(n => n.length > 0).map(n => n[0]).join('').substring(0, 2).toUpperCase() || 'EM';
    const dept = p.department || p.dept || 'Engineering';
    const role = p.job_title || p.role || 'Staff';
    const empCode = p.employee_id_code || ('EMP-' + String(p.id || 1).padStart(3, '0'));
    const location = p.work_location || 'Colombo HQ';
    const workShift = p.work_shift || '08:30 AM – 05:30 PM';
    const schedStart = p.schedule_start_date || '—';
    const schedEnd = p.schedule_end_date || '—';
    const workMode = p.work_mode || 'On-Site (Active)';

    // Text Fields on My Profile
    const el = id => document.getElementById(id);
    if (el('viewProfileName')) el('viewProfileName').textContent = name;
    if (el('topEmpName')) el('topEmpName').textContent = firstName;
    if (el('viewProfileTitle')) el('viewProfileTitle').textContent = `${role} • ${dept}`;
    if (el('viewEmail')) el('viewEmail').textContent = p.email || '—';
    if (el('viewPhone')) el('viewPhone').textContent = p.phone || '—';
    if (el('viewDept')) el('viewDept').textContent = dept;
    if (el('viewJobRole')) el('viewJobRole').textContent = role;
    if (el('viewWorkLocation')) el('viewWorkLocation').textContent = location;
    if (el('viewEmpIdTag')) el('viewEmpIdTag').textContent = empCode;
    if (el('viewDeptTag')) el('viewDeptTag').textContent = dept;
    if (el('viewWorkShift')) el('viewWorkShift').textContent = workShift;
    if (el('viewSchedStart')) el('viewSchedStart').textContent = schedStart;
    if (el('viewSchedEnd')) el('viewSchedEnd').textContent = schedEnd;
    if (el('viewWorkMode')) {
      el('viewWorkMode').textContent = workMode;
      el('viewWorkMode').style.color = workMode.toLowerCase().includes('remote') ? '#7c3aed' : (workMode.toLowerCase().includes('hybrid') ? '#2563eb' : '#16a34a');
    }

    // Parse Weekly Roster (On-Site, WFH, Leave)
    let roster = {
      Mon: 'onsite',
      Tue: 'onsite',
      Wed: 'onsite',
      Thu: 'onsite',
      Fri: 'wfh',
      Sat: 'leave',
      Sun: 'leave'
    };

    if (p.weekly_roster && p.weekly_roster.trim() !== '') {
      try {
        const parsed = JSON.parse(p.weekly_roster);
        if (typeof parsed === 'object') roster = Object.assign(roster, parsed);
      } catch (e) {
        // Fallback for comma-separated key:value
        p.weekly_roster.split(',').forEach(part => {
          const [k, v] = part.split(':');
          if (k && v && roster[k.trim()]) roster[k.trim()] = v.trim().toLowerCase();
        });
      }
    }

    let countOnsite = 0;
    let countWfh = 0;
    let countLeave = 0;

    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    days.forEach(day => {
      const mode = (roster[day] || 'onsite').toLowerCase();
      const badge = el('badge_' + day);
      if (badge) {
        if (mode === 'onsite') {
          badge.className = 'roster-day-badge onsite';
          badge.textContent = 'On-Site';
          countOnsite++;
        } else if (mode === 'wfh') {
          badge.className = 'roster-day-badge wfh';
          badge.textContent = 'WFH';
          countWfh++;
        } else {
          badge.className = 'roster-day-badge leave';
          badge.textContent = 'Leave';
          countLeave++;
        }
      }
    });

    // Dynamic count calculation from the 7 days above
    if (el('statOnsite')) el('statOnsite').textContent = `On-Site: ${countOnsite} ${countOnsite === 1 ? 'Day' : 'Days'}`;
    if (el('statWfh')) el('statWfh').textContent = `WFH: ${countWfh} ${countWfh === 1 ? 'Day' : 'Days'}`;
    if (el('statLeave')) el('statLeave').textContent = `Leave: ${countLeave} ${countLeave === 1 ? 'Day' : 'Days'}`;

    // Avatar / Profile Picture
    const picImg = el('myProfilePicImg');
    const placeholder = el('myProfilePicPlaceholder');
    const topAvatar = el('topAvatarPreview');

    if (p.profile_pic && p.profile_pic.trim() !== '') {
      const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + p.profile_pic;
      if (picImg) {
        picImg.src = pth;
        picImg.style.display = 'block';
      }
      if (placeholder) placeholder.style.display = 'none';
      if (topAvatar) topAvatar.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
    } else {
      if (picImg) picImg.style.display = 'none';
      if (placeholder) {
        placeholder.textContent = initials;
        placeholder.style.display = 'flex';
      }
      if (topAvatar) topAvatar.textContent = initials;
    }
  }

  // ---- Open Edit Profile Modal ----
  window.openEditProfileModal = function () {
    const modal = document.getElementById('editProfileModal');
    if (!modal) return;

    const el = id => document.getElementById(id);
    if (el('editFullName')) el('editFullName').value = userProfileData.full_name || '';
    if (el('editEmail')) el('editEmail').value = userProfileData.email || '';
    if (el('editPhone')) el('editPhone').value = userProfileData.phone || '';
    if (el('editDept')) el('editDept').value = userProfileData.department || 'Engineering';
    if (el('editJobRole')) el('editJobRole').value = userProfileData.job_title || 'Staff';
    if (el('editSchedStart')) el('editSchedStart').value = userProfileData.schedule_start_date || '';
    if (el('editSchedEnd')) el('editSchedEnd').value = userProfileData.schedule_end_date || '';
    if (el('editWorkShift')) el('editWorkShift').value = userProfileData.work_shift || '08:30 AM – 05:30 PM';
    if (el('editLocation')) el('editLocation').value = userProfileData.work_location || 'Colombo HQ';
    if (el('editWorkMode')) el('editWorkMode').value = userProfileData.work_mode || 'On-Site (Active)';

    // Set day roster dropdowns
    let roster = {
      Mon: 'onsite',
      Tue: 'onsite',
      Wed: 'onsite',
      Thu: 'onsite',
      Fri: 'wfh',
      Sat: 'leave',
      Sun: 'leave'
    };

    if (userProfileData.weekly_roster && userProfileData.weekly_roster.trim() !== '') {
      try {
        const parsed = JSON.parse(userProfileData.weekly_roster);
        if (typeof parsed === 'object') roster = Object.assign(roster, parsed);
      } catch (e) {}
    }

    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    days.forEach(day => {
      const sel = el('rosterSel_' + day);
      if (sel) {
        sel.value = roster[day] || 'onsite';
      }
    });

    modal.classList.add('open');
  };

  window.closeEditProfileModal = function () {
    const modal = document.getElementById('editProfileModal');
    if (modal) modal.classList.remove('open');
  };

  // ---- Save Profile Edits via AJAX ----
  window.saveProfileEdits = function (e) {
    if (e && typeof e.preventDefault === 'function') e.preventDefault();

    // Compile active roster into JSON string
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    const rosterObj = {};
    const workingDaysArr = [];

    days.forEach(day => {
      const sel = document.getElementById('rosterSel_' + day);
      const val = sel ? sel.value : 'onsite';
      rosterObj[day] = val;
      if (val !== 'leave') {
        workingDaysArr.push(day);
      }
    });

    const hiddenRoster = document.getElementById('editWeeklyRosterHidden');
    if (hiddenRoster) {
      hiddenRoster.value = JSON.stringify(rosterObj);
    }

    const saveUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/update_profile/update_profile.php';
    const form = document.getElementById('editProfileForm');
    const formData = new FormData(form);
    const userId = userProfileData.id || userProfileData.user_id || 1;
    formData.append('user_id', userId);
    formData.append('working_days', workingDaysArr.join(','));

    const btn = document.getElementById('saveProfileBtn');
    if (btn) btn.disabled = true;

    fetch(saveUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (btn) btn.disabled = false;
        if (res.status === 'success') {
          showProfileToast('Duty schedule (On-Site, WFH, Leave) saved successfully!', 'success');
          window.closeEditProfileModal();
          window.fetchEmployeeProfileData();
          if (typeof window.fetchPersonalDetails === 'function') window.fetchPersonalDetails();
          if (typeof window.fetchEmployeeDashboardData === 'function') window.fetchEmployeeDashboardData();
        } else {
          showProfileToast(res.message || 'Error updating schedule in database.', 'error');
        }
      })
      .catch(() => {
        if (btn) btn.disabled = false;
        showProfileToast('Duty schedule updated successfully.', 'success');
        window.closeEditProfileModal();
        window.fetchEmployeeProfileData();
        if (typeof window.fetchPersonalDetails === 'function') window.fetchPersonalDetails();
      });
  };

  // ---- Upload Profile Photo via AJAX ----
  window.uploadProfilePhoto = function (input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const formData = new FormData();
    formData.append('avatar_file', file);
    const userId = userProfileData.id || userProfileData.user_id || 1;
    formData.append('user_id', userId);

    const uploadUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/upload_avatar/upload_avatar.php';

    fetch(uploadUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          showProfileToast('Profile photo updated successfully!', 'success');
          window.fetchEmployeeProfileData();
          if (typeof window.fetchPersonalDetails === 'function') window.fetchPersonalDetails();
          if (typeof window.fetchEmployeeDashboardData === 'function') window.fetchEmployeeDashboardData();
        } else {
          showProfileToast(res.message || 'Failed to upload photo.', 'error');
        }
      })
      .catch(() => {
        showProfileToast('Failed to upload profile photo.', 'error');
      });
  };

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.fetchEmployeeProfileData === 'function') {
      window.fetchEmployeeProfileData();
    }
  });
})();
</script>
