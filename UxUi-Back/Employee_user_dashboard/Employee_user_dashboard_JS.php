<script type="text/javascript">
  // Expose session user_id for document request filtering
  window.empSessionUserId = <?php echo isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0; ?>;

  function setEmployeeSidebarActive(pageName) {

    document.querySelectorAll('.sidebar-link').forEach(function(item){
      var isMatch = item.getAttribute('data-page') === pageName;
      item.classList.toggle('active', isMatch);
    });
  }

  function Employee_user_dashboard_close_all() {
    var ids = [
      "Employee_user_dashboard_01",
      "Employee_user_dashboard_02_my_profile",
      "Employee_user_dashboard_03_personal_details",
      "Employee_user_dashboard_04_documents",
      "Employee_user_dashboard_05_bank_details",
      "Employee_user_dashboard_06_job_information",
      "Employee_user_dashboard_07_daily_work_plan",
      "Employee_user_dashboard_08_leave_request",
      "Employee_user_dashboard_09_notifications",
      "Employee_user_dashboard_10_settings"
    ];

    ids.forEach(function(id) {
      var el = document.getElementById(id);
      if (el) el.style.display = "none";
    });
  }

  window.syncGlobalEmployeeData = function() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';
    fetch(pth)
      .then(function(res) { return res.json(); })
      .then(function(res) {
        if (res && res.status === 'success' && res.data) {
          var d = res.data;
          var name = d.full_name || 'Employee';
          var role = d.job_title || 'Staff';
          var dept = d.department || 'General';
          var empId = d.employee_id_code || 'EMP-002';
          var initials = name.split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase();
          var pic = (d.profile_pic && d.profile_pic.trim() !== '') ? ((typeof window.pth !== 'undefined' ? window.pth : '../') + d.profile_pic) : null;
          
          window.currentEmployeeName = name;

          // 1. Sync Sidebar User Block
          var sbName = document.getElementById('empSidebarName');
          var sbRole = document.getElementById('empSidebarRole');
          var sbAvatar = document.getElementById('empSidebarAvatar');
          if (sbName) sbName.textContent = name;
          if (sbRole) sbRole.textContent = role;
          if (sbAvatar) {
            if (pic) {
              sbAvatar.innerHTML = '<img src="' + pic + '" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />';
            } else {
              sbAvatar.textContent = initials;
            }
          }

          // 2. Sync ALL Topbars across entire dashboard
          document.querySelectorAll('.admin-pill, .emp-pill, .profile-pill').forEach(function(pill) {
            var nameSpan = pill.querySelector('span');
            var avatarEl = pill.querySelector('.avatar, .avatar-sm');
            if (nameSpan) nameSpan.textContent = name;
            if (avatarEl) {
              if (pic) {
                avatarEl.innerHTML = '<img src="' + pic + '" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />';
              } else {
                avatarEl.textContent = initials;
              }
            }
          });

          // 3. Sync Specific Topbar IDs if present
          var topNameIds = ['topEmpName', 'topEmpLeaveName', 'topEmpDocName', 'topEmpNotifName'];
          topNameIds.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.textContent = name;
          });

          // 4. Sync Welcome Banner on Dashboard
          var bannerName = document.getElementById('empWelcomeBannerName');
          var bannerDept = document.getElementById('empWelcomeBannerDept');
          var bannerTag = document.getElementById('empBannerDeptTag');
          if (bannerName) bannerName.textContent = name;
          if (bannerDept) bannerDept.textContent = dept;
          if (bannerTag) bannerTag.textContent = dept;
        }
      })
      .catch(function(err) {});
  };

  document.addEventListener("DOMContentLoaded", function() {
    window.syncGlobalEmployeeData();
  });

  function Employee_user_dashboard_01_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_01");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('dashboard');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmployeeDashboardData === 'function') {
      window.fetchEmployeeDashboardData();
    }
  }

  function Employee_user_dashboard_02_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_02_my_profile");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('my_profile');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmployeeProfileData === 'function') {
      window.fetchEmployeeProfileData();
    }
  }

  function Employee_user_dashboard_03_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_03_personal_details");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('personal_details');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchPersonalDetails === 'function') {
      window.fetchPersonalDetails();
    }
  }

  function Employee_user_dashboard_04_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_04_documents");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('documents');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmployeeDocumentsList === 'function') {
      window.fetchEmployeeDocumentsList();
    }
  }

  function Employee_user_dashboard_05_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_05_bank_details");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('bank_details');
    window.syncGlobalEmployeeData();
    if (typeof window.loadEmployeeBankDetails === 'function') {
      window.loadEmployeeBankDetails();
    }
  }

  function Employee_user_dashboard_06_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_06_job_information");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('job_information');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchJobInformation === 'function') {
      window.fetchJobInformation();
    }
  }

  function Employee_user_dashboard_07_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_07_daily_work_plan");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('daily_work_plan');
    window.syncGlobalEmployeeData();
    if (typeof window.loadDailyPlan === 'function') {
      window.loadDailyPlan();
    }
    if (typeof window.fetchEmployeeWorkplanTasks === 'function') {
      window.fetchEmployeeWorkplanTasks();
    }
  }

  function Employee_user_dashboard_08_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_08_leave_request");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('leave_requests');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmpLeaveHistory === 'function') {
      window.fetchEmpLeaveHistory();
    }
  }

  function Employee_user_dashboard_09_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_09_notifications");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('notifications');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmpNotifications === 'function') {
      window.fetchEmpNotifications();
    }
  }

  function Employee_user_dashboard_10_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_10_settings");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('settings');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmployeeSettings === 'function') {
      window.fetchEmployeeSettings();
    }
  }

  window.Employee_user_dashboard_close_all = Employee_user_dashboard_close_all;
  window.Employee_user_dashboard_01_OPEN = Employee_user_dashboard_01_OPEN;
  window.Employee_user_dashboard_02_OPEN = Employee_user_dashboard_02_OPEN;
  window.Employee_user_dashboard_03_OPEN = Employee_user_dashboard_03_OPEN;
  window.Employee_user_dashboard_04_OPEN = Employee_user_dashboard_04_OPEN;
  window.Employee_user_dashboard_05_OPEN = Employee_user_dashboard_05_OPEN;
  window.Employee_user_dashboard_06_OPEN = Employee_user_dashboard_06_OPEN;
  window.Employee_user_dashboard_07_OPEN = Employee_user_dashboard_07_OPEN;
  window.Employee_user_dashboard_08_OPEN = Employee_user_dashboard_08_OPEN;
  window.Employee_user_dashboard_09_OPEN = Employee_user_dashboard_09_OPEN;
  window.Employee_user_dashboard_10_OPEN = Employee_user_dashboard_10_OPEN;
</script>
