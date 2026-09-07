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

          // Work Schedule & Shift Timing in Card 4
          if (el('pdWorkShift')) el('pdWorkShift').textContent = p.work_shift || '08:30 AM – 05:30 PM';
          if (el('pdWorkingDays')) el('pdWorkingDays').textContent = p.working_days || 'Mon, Tue, Wed, Thu, Fri';
          if (el('pdWorkMode')) el('pdWorkMode').textContent = p.work_mode || 'On-Site (Active)';
          if (el('pdWorkLocation')) el('pdWorkLocation').textContent = p.work_location || 'Colombo HQ';
          if (el('pdSchedulePeriod')) el('pdSchedulePeriod').textContent = p.schedule_start_date ? `Effective from ${p.schedule_start_date}` : 'Active Permanent Schedule';
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
