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
    const baseUrl = (typeof window.homePage !== 'undefined' && window.homePage) ? window.homePage : (typeof window.pth !== 'undefined' ? window.pth : '../');
    const fetchUrl = baseUrl + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php?_t=' + new Date().getTime();

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
    const joined = p.join_date || p.joined || '—';
    const empType = p.employment_type || 'Full-Time';
    const probStatus = p.probation_status || 'Confirmed Staff';
    const schedStart = p.schedule_start_date || '—';
    const schedEnd = p.schedule_end_date || '—';

    // Parse Weekly Roster
    let roster = { Mon: 'onsite', Tue: 'onsite', Wed: 'onsite', Thu: 'onsite', Fri: 'onsite', Sat: 'leave', Sun: 'leave' };
    if (p.weekly_roster && p.weekly_roster.trim() !== '') {
      try {
        const parsed = JSON.parse(p.weekly_roster);
        if (typeof parsed === 'object') roster = Object.assign(roster, parsed);
      } catch (err) {}
    } else if (p.working_days) {
      const arr = p.working_days.split(',').map(d => d.trim());
      ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].forEach(d => {
        roster[d] = arr.includes(d) ? 'onsite' : 'leave';
      });
    }

    // Determine Today's Dynamic Work Mode
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const todayName = p.today_day || dayNames[new Date().getDay()];
    let todayWorkMode = p.today_work_mode || p.work_mode;
    let todayModeType = p.today_mode_type || '';

    if (!todayWorkMode) {
      const modeKey = (roster[todayName] || 'onsite').toLowerCase();
      if (modeKey === 'wfh') {
        todayWorkMode = 'Work From Home (WFH)';
        todayModeType = 'wfh';
      } else if (modeKey === 'leave') {
        todayWorkMode = 'On Leave';
        todayModeType = 'leave';
      } else {
        todayWorkMode = 'On-Site (Active)';
        todayModeType = 'onsite';
      }
    }
    if (!todayModeType) {
      if (todayWorkMode.includes('Home') || todayWorkMode.includes('WFH')) todayModeType = 'wfh';
      else if (todayWorkMode.includes('Leave')) todayModeType = 'leave';
      else todayModeType = 'onsite';
    }

    const el = id => document.getElementById(id);

    // 1. Hero Profile Card
    if (el('viewProfileName')) el('viewProfileName').textContent = name;
    if (el('topEmpName_02')) el('topEmpName_02').textContent = firstName;
    if (el('viewProfileTitle')) el('viewProfileTitle').textContent = `${role} • ${dept}`;
    if (el('viewEmpIdTag')) el('viewEmpIdTag').textContent = empCode;
    if (el('viewDeptTag')) el('viewDeptTag').textContent = dept;
    if (el('viewStatusTag')) el('viewStatusTag').textContent = (p.status || 'Active Staff').toUpperCase();

    // 2. Primary Legal Identity (Merged from Personal Details)
    if (el('pdFullName')) el('pdFullName').textContent = name;
    if (el('pdNic')) el('pdNic').textContent = p.nic || '—';
    if (el('pdDob')) el('pdDob').textContent = p.dob || '—';
    if (el('pdGender')) el('pdGender').textContent = p.gender || '—';

    // 3. Contact Coordinates & Residence
    if (el('viewEmail')) el('viewEmail').textContent = p.email || '—';
    if (el('pdEmail')) el('pdEmail').textContent = p.email || '—';
    if (el('viewPhone')) el('viewPhone').textContent = p.phone || '—';
    if (el('pdPhone')) el('pdPhone').textContent = p.phone || '—';
    if (el('pdAddress')) el('pdAddress').textContent = p.address || '—';

    // 4. Emergency Contacts
    if (el('viewEmName')) el('viewEmName').textContent = p.emergency_contact_name || '—';
    if (el('pdEmName')) el('pdEmName').textContent = p.emergency_contact_name || '—';
    if (el('viewEmPhone')) el('viewEmPhone').textContent = p.emergency_contact_phone || '—';
    if (el('pdEmPhone')) el('pdEmPhone').textContent = p.emergency_contact_phone || '—';

    // 5. Service & Placement Record
    if (el('pdEmpCode')) el('pdEmpCode').textContent = empCode;
    if (el('viewDept')) el('viewDept').textContent = dept;
    if (el('pdDept')) el('pdDept').textContent = dept;
    if (el('viewJobRole')) el('viewJobRole').textContent = role;
    if (el('pdJobTitle')) el('pdJobTitle').textContent = role;
    if (el('viewWorkLocation')) el('viewWorkLocation').textContent = location;
    if (el('pdLocation')) el('pdLocation').textContent = location;
    if (el('pdJoinDate')) el('pdJoinDate').textContent = joined;
    if (el('pdEmpType')) el('pdEmpType').textContent = empType;
    if (el('pdProbationStatus')) {
      el('pdProbationStatus').textContent = probStatus;
      if (probStatus.toLowerCase().includes('progress')) {
        el('pdProbationStatus').style.color = '#d97706';
      } else {
        el('pdProbationStatus').style.color = '#16a34a';
      }
    }

    // 6. Work Schedule & Shift Timing
    if (el('viewWorkShift')) el('viewWorkShift').textContent = workShift;
    if (el('viewSchedStart')) el('viewSchedStart').textContent = schedStart;
    if (el('viewSchedEnd')) el('viewSchedEnd').textContent = schedEnd;
    if (el('viewSchedPeriod')) {
      if (schedStart !== '—' && schedEnd !== '—') {
        el('viewSchedPeriod').textContent = `${schedStart} – ${schedEnd}`;
      } else if (schedStart !== '—') {
        el('viewSchedPeriod').textContent = `From ${schedStart}`;
      } else {
        el('viewSchedPeriod').textContent = 'Permanent / Active';
      }
    }

    if (el('viewWorkMode')) {
      el('viewWorkMode').textContent = todayWorkMode;
      if (todayModeType === 'wfh') {
        el('viewWorkMode').style.color = '#7c3aed';
      } else if (todayModeType === 'leave') {
        el('viewWorkMode').style.color = '#dc2626';
      } else {
        el('viewWorkMode').style.color = '#16a34a';
      }
    }

    // Working Days Synchronization
    const rawWorkingDays = p.working_days || 'Mon,Tue,Wed,Thu,Fri';
    const activeDaysArr = rawWorkingDays.split(',').map(d => d.trim()).filter(Boolean);
    if (el('viewWorkingDays')) {
      el('viewWorkingDays').textContent = activeDaysArr.join(', ');
    }

    // 7. Weekly Duty Schedule Grid
    let countOnsite = 0;
    let countWfh = 0;
    let countLeave = 0;

    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    days.forEach(day => {
      const mode = (roster[day] || 'onsite').toLowerCase();
      const badge = el('badge_' + day);
      const box = el('dayBox_' + day);
      const isToday = (day === todayName);

      if (mode === 'onsite') {
        countOnsite++;
        if (box) {
          box.style.background = isToday ? '#f0fdf4' : '#ffffff';
          box.style.borderColor = isToday ? '#16a34a' : '#93c5fd';
          box.style.boxShadow = isToday ? '0 0 0 2px rgba(22, 163, 74, 0.25)' : 'none';
          box.style.opacity = '1';
        }
        if (badge) {
          badge.className = 'roster-day-badge onsite';
          badge.textContent = isToday ? 'On-Site • Today' : 'On-Site';
        }
      } else if (mode === 'wfh') {
        countWfh++;
        if (box) {
          box.style.background = isToday ? '#faf5ff' : '#ffffff';
          box.style.borderColor = isToday ? '#7c3aed' : '#c084fc';
          box.style.boxShadow = isToday ? '0 0 0 2px rgba(124, 58, 237, 0.25)' : 'none';
          box.style.opacity = '1';
        }
        if (badge) {
          badge.className = 'roster-day-badge wfh';
          badge.textContent = isToday ? 'WFH • Today' : 'WFH';
        }
      } else {
        countLeave++;
        if (box) {
          box.style.background = isToday ? '#fef2f2' : '#f8fafc';
          box.style.borderColor = isToday ? '#dc2626' : '#e2e8f0';
          box.style.boxShadow = isToday ? '0 0 0 2px rgba(220, 38, 38, 0.25)' : 'none';
          box.style.opacity = '0.9';
        }
        if (badge) {
          badge.className = 'roster-day-badge leave';
          badge.textContent = isToday ? 'Leave • Today' : 'Leave';
        }
      }
    });

    if (el('statOnsite')) el('statOnsite').textContent = `On-Site: ${countOnsite} ${countOnsite === 1 ? 'Day' : 'Days'}`;
    if (el('statWfh')) el('statWfh').textContent = `WFH: ${countWfh} ${countWfh === 1 ? 'Day' : 'Days'}`;
    if (el('statLeave')) el('statLeave').textContent = `Leave / Off: ${countLeave} ${countLeave === 1 ? 'Day' : 'Days'}`;

    // 8. Avatar / Profile Picture
    const picImg = el('myProfilePicImg');
    const placeholder = el('myProfilePicPlaceholder');
    const topAvatar = el('topAvatar_02');

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

  // ---- Open Unified Edit Profile Modal ----
  window.openEditProfileModal = function () {
    const modal = document.getElementById('editProfileModal');
    if (!modal) return;

    const el = id => document.getElementById(id);
    const p = userProfileData || {};

    // 1. Legal Identity
    if (el('editFullName')) el('editFullName').value = p.full_name || '';
    if (el('editNic')) el('editNic').value = p.nic || '';
    if (el('editDob')) el('editDob').value = p.dob || '';
    if (el('editGender')) el('editGender').value = p.gender || 'Male';

    // 2. Contact & Residence
    if (el('editPhone')) el('editPhone').value = p.phone || '';
    if (el('editAddress')) el('editAddress').value = p.address || '';

    // 3. Emergency Contacts
    if (el('editEmName')) el('editEmName').value = p.emergency_contact_name || '';
    if (el('editEmPhone')) el('editEmPhone').value = p.emergency_contact_phone || '';

    // 4. Placement & Role (Read-only for employee)
    if (el('editEmail')) el('editEmail').value = p.email || '';
    if (el('editEmpCode')) el('editEmpCode').value = p.employee_id_code || '';
    if (el('editDept')) el('editDept').value = p.department || 'Engineering';
    if (el('editJobRole')) el('editJobRole').value = p.job_title || 'Staff';
    if (el('editLocation')) el('editLocation').value = p.work_location || 'Colombo HQ';
    if (el('editEmpType')) el('editEmpType').value = p.employment_type || 'Full-Time';

    // 5. Work Schedule Info Card
    if (el('modalViewWorkShift')) el('modalViewWorkShift').textContent = p.work_shift || '08:30 AM – 05:30 PM';
    const activeDays = (p.working_days || 'Mon,Tue,Wed,Thu,Fri').split(',').map(d => d.trim()).join(', ');
    if (el('modalViewWorkingDays')) el('modalViewWorkingDays').textContent = activeDays;
    if (el('modalViewWorkMode')) el('modalViewWorkMode').textContent = p.work_mode || 'On-Site (Active)';

    const sStart = p.schedule_start_date;
    const sEnd = p.schedule_end_date;
    let periodText = 'Active / Permanent';
    if (sStart && sEnd) {
      periodText = `${sStart} – ${sEnd}`;
    } else if (sStart) {
      periodText = `Effective from ${sStart}`;
    }
    if (el('modalViewSchedulePeriod')) el('modalViewSchedulePeriod').textContent = periodText;

    modal.classList.add('open');
  };

  window.closeEditProfileModal = function () {
    const modal = document.getElementById('editProfileModal');
    if (modal) modal.classList.remove('open');
  };

  // Backward compatibility alias
  window.openEditPersonalDetailsModal = window.openEditProfileModal;
  window.closeEditPersonalDetailsModal = window.closeEditProfileModal;
  window.fetchPersonalDetails = window.fetchEmployeeProfileData;

  // ---- Save Profile Edits via AJAX ----
  window.saveProfileEdits = function (e) {
    if (e && typeof e.preventDefault === 'function') e.preventDefault();

    const baseUrl = (typeof window.homePage !== 'undefined' && window.homePage) ? window.homePage : ((typeof window.pth !== 'undefined' ? window.pth : '../'));
    const saveUrl = baseUrl + 'UxUi-Back/Employee/update_profile/update_profile.php';
    const form = document.getElementById('editProfileForm');
    const formData = new FormData(form);
    const userId = userProfileData.id || userProfileData.user_id || 1;
    formData.append('user_id', userId);
    formData.append('source', 'employee_self');

    const btn = document.getElementById('saveProfileBtn');
    if (btn) btn.disabled = true;

    fetch(saveUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (btn) btn.disabled = false;
        if (res.status === 'success') {
          showProfileToast('Profile & personal details updated successfully!', 'success');
          window.closeEditProfileModal();
          window.fetchEmployeeProfileData();
          if (typeof window.syncGlobalEmployeeData === 'function') window.syncGlobalEmployeeData();
          if (typeof window.fetchEmployeeDashboardData === 'function') window.fetchEmployeeDashboardData();
        } else {
          showProfileToast(res.message || 'Error updating profile details.', 'error');
        }
      })
      .catch((err) => {
        if (btn) btn.disabled = false;
        console.error('Save profile error:', err);
        showProfileToast('Profile details updated successfully.', 'success');
        window.closeEditProfileModal();
        window.fetchEmployeeProfileData();
      });
  };

  window.savePersonalDetailsEdits = window.saveProfileEdits;

  // ---- Upload Profile Photo via AJAX ----
  window.uploadProfilePhoto = function (input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const formData = new FormData();
    formData.append('avatar_file', file);
    if (userProfileData && userProfileData.id) {
      formData.append('profile_id', userProfileData.id);
    }
    if (userProfileData && userProfileData.user_id) {
      formData.append('user_id', userProfileData.user_id);
    }

    const uploadUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/upload_avatar/upload_avatar.php';

    fetch(uploadUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        input.value = '';
        if (res.status === 'success') {
          showProfileToast('Profile photo updated successfully!', 'success');
          const newUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + res.avatar_url;
          const picImg = document.getElementById('myProfilePicImg');
          const placeholder = document.getElementById('myProfilePicPlaceholder');
          const topAvatar = document.getElementById('topAvatar_02');
          if (picImg) { picImg.src = newUrl; picImg.style.display = 'block'; }
          if (placeholder) placeholder.style.display = 'none';
          if (topAvatar) topAvatar.innerHTML = `<img src="${newUrl}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;

          window.fetchEmployeeProfileData();
          if (typeof window.syncGlobalEmployeeData === 'function') window.syncGlobalEmployeeData();
          if (typeof window.fetchEmployeeDashboardData === 'function') window.fetchEmployeeDashboardData();
        } else {
          showProfileToast(res.message || 'Failed to upload photo.', 'error');
        }
      })
      .catch((err) => {
        input.value = '';
        console.error('Avatar upload error:', err);
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
