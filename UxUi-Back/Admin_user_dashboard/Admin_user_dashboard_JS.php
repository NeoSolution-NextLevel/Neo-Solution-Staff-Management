<script type="text/javascript">
 function setSidebarActive(pageName) {
   document.querySelectorAll('.wwjm-sidebar-nav-item, .sidebar-link').forEach(function(item){
     var isMatch = item.getAttribute('data-page') === pageName;
     item.classList.toggle('active', isMatch);
     item.classList.toggle('wwjm-sidebar-active', isMatch);
   });
 }

 function setAdminDashboardSectionDisplay(id, displayValue) {
   var section = document.getElementById(id);
   if (section) {
     section.style.display = displayValue;
   }
 }

function Admin_user_dashboard_close_all() {
 setAdminDashboardSectionDisplay("Admin_user_dashboard_01", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_02_employees", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_03_documents", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_04_bank_details", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_05_departments", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_06_job_roles", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_07_task_management", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_08_leave_requests", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_09_notifications", "none");
 setAdminDashboardSectionDisplay("Admin_user_dashboard_10_settings", "none");

 }

 function Admin_user_dashboard_01_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_01");
  if (el) el.style.display = "block";
  setSidebarActive('dashboard');
  if (typeof window.playDashboardChartAnimations === 'function') {
    window.playDashboardChartAnimations();
  }
 }

function Admin_user_dashboard_02_OPEN() {
 Admin_user_dashboard_close_all();
 setAdminDashboardSectionDisplay("Admin_user_dashboard_02_employees", "block");
 setSidebarActive('employees');
 if (typeof window.fetchAdminEmployees === 'function') {
   window.fetchAdminEmployees();
 }
}

  function Admin_user_dashboard_03_OPEN() {
    Admin_user_dashboard_close_all();
    var el = document.getElementById("Admin_user_dashboard_03_documents");
    if (el) el.style.display = "block";
    setSidebarActive('documents');
    if (typeof window.switchAdminDocTab === 'function') {
      window.switchAdminDocTab('documents');
    } else if (typeof window.loadAdminDocuments === 'function') {
      window.loadAdminDocuments();
    }
  }

  function Admin_user_dashboard_03_REQUESTS_OPEN() {
    Admin_user_dashboard_close_all();
    var el = document.getElementById("Admin_user_dashboard_03_documents");
    if (el) el.style.display = "block";
    setSidebarActive('documents');
    if (typeof window.switchAdminDocTab === 'function') {
      window.switchAdminDocTab('requests');
    } else if (typeof window.loadDocumentRequests === 'function') {
      window.loadDocumentRequests();
    }
  }

function Admin_user_dashboard_04_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_04_bank_details");
  if (el) el.style.display = "block";
  setSidebarActive('bank_details');
  if (typeof window.loadAdminBankDetails === 'function') {
    window.loadAdminBankDetails();
  }
}

function Admin_user_dashboard_05_OPEN() {
 Admin_user_dashboard_close_all();
 setAdminDashboardSectionDisplay("Admin_user_dashboard_05_departments", "block");
 setSidebarActive('departments');
 if (typeof window.fetchAdminDepartments === 'function') {
   window.fetchAdminDepartments();
 }
}

 function Admin_user_dashboard_06_OPEN() {
 Admin_user_dashboard_close_all();
 setAdminDashboardSectionDisplay("Admin_user_dashboard_06_job_roles", "block");
 setSidebarActive('job_roles');
 if (typeof window.loadLiveDepartmentsIntoJobRoles === 'function') {
   window.loadLiveDepartmentsIntoJobRoles();
 }
 if (typeof window.fetchAdminJobRoles === 'function') {
   window.fetchAdminJobRoles();
 }
 }

 function Admin_user_dashboard_07_OPEN() {
  Admin_user_dashboard_close_all();
  setAdminDashboardSectionDisplay("Admin_user_dashboard_07_task_management", "block");
  setSidebarActive('task_management');
  if (typeof window.fetchAdminTasks === 'function') {
    window.fetchAdminTasks();
  }
}

 function Admin_user_dashboard_08_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_08_leave_requests");
  if (el) el.style.display = "block";
  setSidebarActive('leave_requests');
  if (typeof window.fetchAdminLeaveRequests === 'function') {
    window.fetchAdminLeaveRequests();
  }
 }
 function Admin_user_dashboard_09_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_09_notifications");
  if (el) el.style.display = "block";
  setSidebarActive('notifications');
  if (typeof window.fetchAdminNotifications === 'function') {
    window.fetchAdminNotifications();
  }
 }

function Admin_user_dashboard_10_OPEN() {
 Admin_user_dashboard_close_all();
 setAdminDashboardSectionDisplay("Admin_user_dashboard_10_settings", "block");
 setSidebarActive('settings');
 if (typeof window.fetchAdminSettings === 'function') {
  window.fetchAdminSettings();
 }
}

 </script>
