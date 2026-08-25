<script>
(function () {
  /**
   * Fetch and populate Employee Personal Details
   */
  window.fetchPersonalDetails = function () {
    const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';

    fetch(fetchUrl)
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success' && res.data) {
          const p = res.data;
          const name = p.full_name || p.fullname || p.name || 'Employee';
          const initials = name.split(' ').filter(n => n.length > 0).map(n => n[0]).join('').substring(0, 2).toUpperCase() || 'EM';
          const joined = p.join_date || p.joined || '—';

          const el = id => document.getElementById(id);
          if (el('pdFullName')) el('pdFullName').textContent = name;
          if (el('topEmpPdName')) el('topEmpPdName').textContent = name;
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

          // Dynamic Probation Status (6 Months Review)
          if (joined && joined !== '—') {
            const joinD = new Date(joined);
            if (!isNaN(joinD.getTime())) {
              const probD = new Date(joinD);
              probD.setMonth(probD.getMonth() + 6);
              const probStr = probD.toISOString().split('T')[0];
              const now = new Date();
              if (now < probD) {
                if (el('pdProbationStatus')) {
                  el('pdProbationStatus').textContent = '6 Months (In Progress - Review: ' + probStr + ')';
                  el('pdProbationStatus').style.color = '#d97706';
                }
              } else {
                if (el('pdProbationStatus')) {
                  el('pdProbationStatus').textContent = '6 Months (Completed & Confirmed on ' + probStr + ')';
                  el('pdProbationStatus').style.color = '#16a34a';
                }
              }
            }
          }

          const topAvatar = el('topAvatarPdPreview');
          if (topAvatar) {
            if (p.profile_pic && p.profile_pic.trim() !== '') {
              const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + p.profile_pic;
              topAvatar.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
            } else {
              topAvatar.textContent = initials;
            }
          }
        }
      })
      .catch(() => {});
  };

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.fetchPersonalDetails === 'function') {
      window.fetchPersonalDetails();
    }
  });
})();
</script>
