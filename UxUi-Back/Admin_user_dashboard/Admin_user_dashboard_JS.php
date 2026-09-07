<script type="text/javascript">
 function setSidebarActive(pageName) {
   document.querySelectorAll('.wwjm-sidebar-nav-item, .sidebar-link').forEach(function(item){
     var isMatch = item.getAttribute('data-page') === pageName;
     item.classList.toggle('active', isMatch);
     item.classList.toggle('wwjm-sidebar-active', isMatch);
   });
 }

function Admin_user_dashboard_close_all() {
 document.getElementById("Admin_user_dashboard_01").style.display = "none";
 document.getElementById("Admin_user_dashboard_02_employees").style.display = "none";
 document.getElementById("Admin_user_dashboard_03_documents").style.display = "none";
 document.getElementById("Admin_user_dashboard_04_bank_details").style.display = "none";
 document.getElementById("Admin_user_dashboard_05_departments").style.display = "none";
 document.getElementById("Admin_user_dashboard_06_job_roles").style.display = "none";
 document.getElementById("Admin_user_dashboard_07_task_management").style.display = "none";
 document.getElementById("Admin_user_dashboard_08_leave_requests").style.display = "none";
 document.getElementById("Admin_user_dashboard_09_notifications").style.display = "none";
 document.getElementById("Admin_user_dashboard_10_settings").style.display = "none";

 }

 function Admin_user_dashboard_01_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_01");
  if (el) el.style.display = "";
  setSidebarActive('dashboard');
  if (typeof window.playDashboardChartAnimations === 'function') {
    window.playDashboardChartAnimations();
  }
 }

function Admin_user_dashboard_02_OPEN() {
 Admin_user_dashboard_close_all();
 document.getElementById("Admin_user_dashboard_02_employees").style.display = "";
 setSidebarActive('employees');
 if (typeof window.fetchAdminEmployees === 'function') {
   window.fetchAdminEmployees();
 }
}

  function Admin_user_dashboard_03_OPEN() {
    Admin_user_dashboard_close_all();
    var el = document.getElementById("Admin_user_dashboard_03_documents");
    if (el) el.style.display = "";
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
    if (el) el.style.display = "";
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
  if (el) el.style.display = "";
  setSidebarActive('bank_details');
  if (typeof window.loadAdminBankDetails === 'function') {
    window.loadAdminBankDetails();
  }
}

function Admin_user_dashboard_05_OPEN() {
Admin_user_dashboard_close_all();
document.getElementById("Admin_user_dashboard_05_departments").style.display = "";
 setSidebarActive('departments');
if (typeof Member_body_01_01_A_01_Memeber_Details_Display === 'function') {
 Member_body_01_01_A_01_Memeber_Details_Display();
 }
}

 function Admin_user_dashboard_06_OPEN() {
 Admin_user_dashboard_close_all();
document.getElementById("Admin_user_dashboard_06_job_roles").style.display = "";
setSidebarActive('job_roles');
if (typeof Member_body_01_01_A_01_Memeber_Details_Display === 'function') {
 Member_body_01_01_A_01_Memeber_Details_Display();
 }
 }

 function Admin_user_dashboard_07_OPEN() {
  Admin_user_dashboard_close_all();
  document.getElementById("Admin_user_dashboard_07_task_management").style.display = "";
  setSidebarActive('task_management');
  if (typeof window.fetchAdminTasks === 'function') {
    window.fetchAdminTasks();
  }
}

 function Admin_user_dashboard_08_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_08_leave_requests");
  if (el) el.style.display = "";
  setSidebarActive('leave_requests');
  if (typeof window.fetchAdminLeaveRequests === 'function') {
    window.fetchAdminLeaveRequests();
  }
 }
 function Admin_user_dashboard_09_OPEN() {
  Admin_user_dashboard_close_all();
  var el = document.getElementById("Admin_user_dashboard_09_notifications");
  if (el) el.style.display = "";
  setSidebarActive('notifications');
  if (typeof window.fetchAdminNotifications === 'function') {
    window.fetchAdminNotifications();
  }
 }

function Admin_user_dashboard_10_OPEN() {
 Admin_user_dashboard_close_all();
 document.getElementById("Admin_user_dashboard_10_settings").style.display = "";
setSidebarActive('settings');
if (typeof window.fetchAdminSettings === 'function') {
 window.fetchAdminSettings();
}
if (typeof Member_body_01_01_A_01_Memeber_Details_Display === 'function') {
 Member_body_01_01_A_01_Memeber_Details_Display();
 }
}

 </script>