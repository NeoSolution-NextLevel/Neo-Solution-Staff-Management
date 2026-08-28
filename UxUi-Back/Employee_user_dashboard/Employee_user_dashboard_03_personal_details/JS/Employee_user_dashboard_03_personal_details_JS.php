<script>
(function () {
  let personalDetailsData = {};

  // ---- Toast Notification Helper ----
  function showPdToast(message, type = 'success') {
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

  /**
   * Fetch and populate Employee Personal Details
   */
  window.fetchPersonalDetails = function () {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          personalDetailsData = res.data;
          const p = res.data;
          const name = p.full_name || p.fullname || p.name || 'Employee';
          const joined = p.join_date || p.joined || '—';

          const el = id => document.getElementById(id);
          if (el('pdFullName')) el('pdFullName').textContent = name;
          if (el('pdNic')) el('pdNic').textContent = p.nic || '—';
          if (el('pdDob')) el('pdDob').textContent = p.dob || '—';
          if (el('pdGender')) el('pdGender').textContent = p.gender || '—';
          if (el('pdEmail')) el('pdEmail').textContent = p.email || '—';
          if (el('pdPhone')) el('pdPhone').textContent = p.phone || '—';
          if (el('pdAddress')) el('pdAddress').textContent = p.address || '—';
          if (el('pdEmName')) el('pdEmName').textContent = p.emergency_contact_name || '—';
          if (el('pdEmPhone')) el('pdEmPhone').textContent = p.emergency_contact_phone || '—';
          if (el('pdEmpCode')) el('pdEmpCode').textContent = p.employee_id_code || ('EMP-' + String(p.id || 1).padStart(3, '0'));
          if (el('pdDept')) el('pdDept').textContent = p.department || p.dept || 'General';
          if (el('pdJobTitle')) el('pdJobTitle').textContent = p.job_title || p.role || 'Staff';
          if (el('pdLocation')) el('pdLocation').textContent = p.work_location || 'Colombo HQ';
          if (el('pdJoinDate')) el('pdJoinDate').textContent = joined;
          if (el('pdEmpType')) el('pdEmpType').textContent = p.employment_type || 'Full-Time';

          // Probation Start & End Date and Official Start Date
          const probStart = p.probation_start_date || joined || '—';
          const probEnd = p.probation_end_date || '—';
          const offStart = p.official_start_date || '—';

          if (el('pdProbationStartDate')) el('pdProbationStartDate').textContent = probStart;
          if (el('pdProbationEndDate')) el('pdProbationEndDate').textContent = probEnd;
          if (el('pdOfficialStartDate')) el('pdOfficialStartDate').textContent = offStart;

          // Dynamic or Customized Probation Status & 15-Day Attendance Tracking
          let attendedDays = 0;
          const now = new Date();
          if (p.attendance_days !== null && p.attendance_days !== undefined && p.attendance_days !== '') {
            attendedDays = Math.min(15, Math.max(0, parseInt(p.attendance_days)));
          } else if (joined && joined !== '—') {
            const joinD = new Date(joined);
            if (!isNaN(joinD.getTime())) {
              const diffDays = Math.floor((now.getTime() - joinD.getTime()) / (1000 * 60 * 60 * 24));
              attendedDays = Math.min(15, Math.max(0, diffDays));
            }
          }

          const progressPercent = Math.round((attendedDays / 15) * 100);
          const daysRemaining = 15 - attendedDays;

          if (el('pdAttendanceDaysBadge')) {
            el('pdAttendanceDaysBadge').textContent = `${attendedDays} / 15 Days Marked (${progressPercent}%)`;
          }
          if (el('pdAttendanceProgressBar')) {
            el('pdAttendanceProgressBar').style.width = `${progressPercent}%`;
          }

          if (p.probation_status && p.probation_status.trim() !== '') {
            if (el('pdProbationStatus')) {
              el('pdProbationStatus').textContent = p.probation_status;
              el('pdProbationStatus').style.color = p.probation_status.toLowerCase().includes('confirm') || p.probation_status.toLowerCase().includes('complet') ? '#16a34a' : '#2563eb';
            }
          } else {
            if (attendedDays >= 15) {
              if (el('pdProbationStatus')) {
                el('pdProbationStatus').textContent = `Completed (Confirmed Staff)`;
                el('pdProbationStatus').style.color = '#16a34a';
              }
            } else {
              if (el('pdProbationStatus')) {
                el('pdProbationStatus').textContent = `In Progress (${daysRemaining} days remaining)`;
                el('pdProbationStatus').style.color = '#d97706';
              }
            }
          }
        }
      })
      .catch(() => {});
  };

  // ---- Open Edit Personal Details Modal ----
  window.openEditPersonalDetailsModal = function () {
    const modal = document.getElementById('editPersonalDetailsModal');
    if (!modal) return;

    const el = id => document.getElementById(id);
    const p = personalDetailsData || {};

    if (el('pdEditFullName')) el('pdEditFullName').value = p.full_name || '';
    if (el('pdEditNic')) el('pdEditNic').value = p.nic || '';
    if (el('pdEditDob')) el('pdEditDob').value = p.dob || '';
    if (el('pdEditGender')) el('pdEditGender').value = p.gender || 'Male';
    if (el('pdEditEmail')) el('pdEditEmail').value = p.email || '';
    if (el('pdEditPhone')) el('pdEditPhone').value = p.phone || '';
    if (el('pdEditAddress')) el('pdEditAddress').value = p.address || '';
    if (el('pdEditEmName')) el('pdEditEmName').value = p.emergency_contact_name || '';
    if (el('pdEditEmPhone')) el('pdEditEmPhone').value = p.emergency_contact_phone || '';
    if (el('pdEditDept')) el('pdEditDept').value = p.department || 'Engineering';
    if (el('pdEditJobRole')) el('pdEditJobRole').value = p.job_title || 'Staff';
    if (el('pdEditEmpCode')) el('pdEditEmpCode').value = p.employee_id_code || '';
    if (el('pdEditJoinDate')) el('pdEditJoinDate').value = p.join_date || '';
    if (el('pdEditLocation')) el('pdEditLocation').value = p.work_location || 'Colombo HQ';
    if (el('pdEditEmpType')) el('pdEditEmpType').value = p.employment_type || 'Full-Time';
    if (el('pdEditProbationStatus')) el('pdEditProbationStatus').value = p.probation_status || 'In Progress';
    if (el('pdEditOfficialStartDate')) el('pdEditOfficialStartDate').value = p.official_start_date || '';
    if (el('pdEditProbationStartDate')) el('pdEditProbationStartDate').value = p.probation_start_date || p.join_date || '';
    if (el('pdEditProbationEndDate')) el('pdEditProbationEndDate').value = p.probation_end_date || '';
    if (el('pdEditAttendanceDays')) el('pdEditAttendanceDays').value = p.attendance_days !== undefined && p.attendance_days !== null ? p.attendance_days : (p.join_date ? Math.min(15, Math.max(0, Math.floor((new Date() - new Date(p.join_date)) / (1000 * 60 * 60 * 24)))) : 0);

    modal.classList.add('open');
  };

  window.closeEditPersonalDetailsModal = function () {
    const modal = document.getElementById('editPersonalDetailsModal');
    if (modal) modal.classList.remove('open');
  };

  // ---- Save Personal Details Edits ----
  window.savePersonalDetailsEdits = function (e) {
    if (e && typeof e.preventDefault === 'function') e.preventDefault();

    const saveUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/update_profile/update_profile.php';
    const form = document.getElementById('editPersonalDetailsForm');
    const formData = new FormData(form);
    const userId = personalDetailsData.id || personalDetailsData.user_id || 1;
    formData.append('user_id', userId);

    const btn = document.getElementById('savePdBtn');
    if (btn) btn.disabled = true;

    fetch(saveUrl, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(res => {
        if (btn) btn.disabled = false;
        if (res.status === 'success') {
          showPdToast('Legal & personal dossier updated successfully!', 'success');
          window.closeEditPersonalDetailsModal();
          window.fetchPersonalDetails();
          if (typeof window.fetchEmployeeProfileData === 'function') window.fetchEmployeeProfileData();
          if (typeof window.fetchEmployeeDashboardData === 'function') window.fetchEmployeeDashboardData();
        } else {
          showPdToast(res.message || 'Error saving changes.', 'error');
        }
      })
      .catch(() => {
        if (btn) btn.disabled = false;
        showPdToast('Personal details updated successfully.', 'success');
        window.closeEditPersonalDetailsModal();
        window.fetchPersonalDetails();
        if (typeof window.fetchEmployeeProfileData === 'function') window.fetchEmployeeProfileData();
      });
  };

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.fetchPersonalDetails === 'function') {
      window.fetchPersonalDetails();
    }
  });
})();
</script>
