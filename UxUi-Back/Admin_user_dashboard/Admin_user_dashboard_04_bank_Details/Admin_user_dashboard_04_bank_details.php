<style>
  :root{
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #3b5bdb;
    --blue-light: #dbe4ff;
    --blue-lighter: #eef2ff;
    --green: #12b76a;
    --green-bg: #e3f9ee;
    --amber: #f5a623;
    --amber-bg: #fdf1dc;
    --red: #f0576a;
    --red-bg: #fde8ec;
    --ink: #1a1f36;
    --muted: #6b7280;
    --border: #e8eaf0;
    --bg: #f5f6fa;
    --card: #ffffff;
    --radius: 16px;
    --shadow: 0 1px 2px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
    font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
  }

  *{ box-sizing:border-box; margin:0; padding:0; }

  #Admin_user_dashboard_04_bank_details {
    width: 100%;
    min-height: 100vh;
  }

  /* Main Container */
  .main{
    margin-left: 250px;
    width: calc(100% - 250px);
    max-width: calc(100% - 250px);
    min-height: 100vh;
    padding: 16px 20px 24px;
    box-sizing: border-box;
    transition: margin-left 0.3s ease, width 0.3s ease;
  }

  .topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom: 16px;
  }
  .topbar h2{ font-size: 22px; font-weight:800; color: var(--navy); letter-spacing:-.3px; }

  .topbar-right{ display:flex; align-items:center; gap:14px; }
  .icon-btn{
    width:40px; height:40px;
    border-radius:50%;
    background: var(--blue-lighter);
    display:flex; align-items:center; justify-content:center;
    position:relative;
    cursor:pointer;
  }
  .icon-btn svg{ width:18px; height:18px; color: var(--navy); }
  .dot{
    position:absolute; top:8px; right:9px;
    width:7px; height:7px; border-radius:50%;
    background: var(--red);
    border: 2px solid var(--card);
  }
  .admin-pill{
    display:flex; align-items:center; gap:8px;
    background: var(--blue-lighter);
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    cursor:pointer;
  }
  .admin-pill .avatar{ width:30px; height:30px; font-size:11.5px; background:var(--navy); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; }
  .admin-pill span{ font-size:13.5px; font-weight:700; color:var(--navy); }

  .menu-btn{
    display:none;
    align-items:center; justify-content:center;
    width:38px; height:38px;
    border-radius:8px;
    background: var(--blue-lighter);
    border:none;
    cursor:pointer;
    color: var(--navy);
    margin-right:6px;
  }
  .menu-btn svg{ width:20px; height:20px; }

  .page-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    margin-bottom: 20px;
  }
  .page-head p{ font-size:14px; color: var(--muted); margin-top: 4px; }

  .notice-banner{
    display:flex;
    align-items:flex-start;
    gap:12px;
    background: var(--amber-bg);
    border: 1px solid #f5dfa8;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    color: #8a6314;
    font-size: 13.5px;
    line-height:1.5;
  }
  .notice-banner svg{ width:18px; height:18px; flex-shrink:0; margin-top:2px; color: var(--amber); }

  .acc-chip{
    display:inline-block;
    background: var(--blue-lighter);
    color: var(--navy);
    font-family: 'Courier New', monospace;
    font-weight:700;
    font-size: 13px;
    letter-spacing: .04em;
    padding: 6px 12px;
    border-radius: 8px;
  }

  /* Desktop Table Layout */
  .table-card{
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow:hidden;
    margin-bottom: 24px;
  }
  .table-wrap{ width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch; }
  table.emp-table{
    width:100%;
    border-collapse: collapse;
    min-width: 680px;
  }
  table.emp-table thead th{
    text-align:left;
    font-size: 12px;
    text-transform:uppercase;
    letter-spacing: .04em;
    color: var(--muted);
    font-weight:700;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    background: #fafbfd;
  }
  table.emp-table tbody td{
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    vertical-align:middle;
    font-size:13.5px;
    color: #3a3f55;
    white-space: nowrap;
  }
  table.emp-table tbody tr:last-child td{ border-bottom:none; }
  table.emp-table tbody tr:hover{ background: #fafbfd; }

  .emp-cell{ display:flex; align-items:center; gap:12px; }
  .emp-avatar{
    width:38px; height:38px;
    border-radius:50%;
    background: var(--blue);
    color:#fff;
    font-size:12.5px;
    font-weight:700;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
  }
  .emp-name{ font-size:14px; font-weight:700; color: var(--ink); }
  .emp-email{ font-size:12px; color: var(--muted); margin-top:1px; }

  /* Mobile Bank Cards View */
  .mobile-bank-cards {
    display: none;
    flex-direction: column;
    gap: 12px;
    width: 100%;
    margin-bottom: 24px;
  }

  .mobile-bank-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 16px;
    box-shadow: 0 1px 3px rgba(20,25,60,.04);
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .mobile-bank-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
    background: #f8fafc;
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #eef2f6;
  }

  .mobile-bank-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
  }

  .mobile-bank-label {
    color: #64748b;
    font-weight: 600;
  }

  .mobile-bank-val {
    color: #1e293b;
    font-weight: 700;
  }

  /* Mobile Responsive Breakpoints */
  @media (max-width: 768px){
    .main{
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 12px 12px 80px !important;
    }

    .menu-btn{ display: inline-flex !important; }
    .topbar h2{ font-size: 18px !important; }
    .page-head h1{ font-size: 19px !important; }

    .table-card { display: none !important; }
    .mobile-bank-cards { display: flex !important; }
  }
</style>

<div id="Admin_user_dashboard_04_bank_details">
  <!-- ================= MAIN ================= -->
  <main class="main">

    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_04" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Bank Details</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="Admin_user_dashboard_09_OPEN();" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill">
          <div class="avatar">AU</div>
          <span>Admin</span>
        </div>
      </div>
    </div>

    <div class="page-head">
      <div>
        <p>Employee salary payment bank information</p>
      </div>
    </div>

    <div class="notice-banner">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
      <span>Bank account numbers are partially masked for security. Full details are available in encrypted storage only.</span>
    </div>

    <!-- 1. Desktop & Tablet Table -->
    <div class="table-card">
      <div class="table-wrap">
        <table class="emp-table">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Account Holder</th>
              <th>Bank Name</th>
              <th>Branch</th>
              <th>Account No.</th>
            </tr>
          </thead>
          <tbody id="bankTableBody">
            <tr>
              <td colspan="5" style="text-align:center; padding: 30px 20px; color: #6b7280;">Loading bank details...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 2. Mobile Phone Cards List -->
    <div class="mobile-bank-cards" id="mobileBankCardsContainer">
      <div style="text-align:center; padding: 30px 16px; color: #6b7280; background:#fff; border-radius:12px;">
        Loading bank details...
      </div>
    </div>

  </main>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    loadAdminBankDetails();
  });

  function loadAdminBankDetails() {
    var pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
    $.ajax({
      url: pth + "View-List/Bank_details/List_All_Bank_Details.php",
      type: "GET",
      dataType: "json",
      success: function(response) {
        var tbody = document.getElementById('bankTableBody');
        var mobileContainer = document.getElementById('mobileBankCardsContainer');

        if (response && response.status === 'success' && response.data && response.data.length > 0) {
          if (tbody) tbody.innerHTML = '';
          if (mobileContainer) mobileContainer.innerHTML = '';

          response.data.forEach(function(row) {
            var empName = row.account_holder_name || 'N/A';
            var empId = row.employee_id || row.user_id || 'EMP-002';
            var bank = row.bank_name || '-';
            var branch = row.branch || '-';
            var accRaw = row.bank_account_number || row.account_number || '-';
            var accMasked = (accRaw && accRaw !== '-') ? (accRaw.length > 4 ? accRaw.slice(-4).padStart(accRaw.length, '•') : accRaw) : '-';
            var initials = empName !== 'N/A' ? empName.split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase() : 'AP';

            var rowId = 'acc_row_' + Math.random().toString(36).substr(2, 9);

            // Desktop Table Row
            if (tbody) {
              var tr = document.createElement('tr');
              tr.innerHTML = '<td>' +
                '<div class="emp-cell">' +
                  '<div class="emp-avatar">' + initials + '</div>' +
                  '<div>' +
                    '<div class="emp-name">' + empName + '</div>' +
                    '<div class="emp-email">' + empId + '</div>' +
                  '</div>' +
                '</div>' +
              '</td>' +
              '<td><strong style="color:#1e293b;">' + empName + '</strong></td>' +
              '<td><span style="font-weight:700; color:var(--blue);">' + bank + '</span></td>' +
              '<td>' + branch + '</td>' +
              '<td>' +
                '<div style="display:inline-flex; align-items:center; gap:8px;">' +
                  '<span class="acc-chip" id="' + rowId + '_desk" data-raw="' + accRaw + '" data-masked="' + accMasked + '">' + accMasked + '</span>' +
                  (accRaw !== '-' ? '<button type="button" onclick="toggleAdminAccView(\'' + rowId + '_desk\', this)" style="background:none; border:none; cursor:pointer; color:#64748b; font-size:14px; padding:2px 4px;" title="Show/Hide"><i class="fa-solid fa-eye-slash"></i></button>' : '') +
                '</div>' +
              '</td>';
              tbody.appendChild(tr);
            }

            // Mobile Card Item
            if (mobileContainer) {
              var card = document.createElement('div');
              card.className = 'mobile-bank-card';
              card.innerHTML = '<div style="display:flex; align-items:center; justify-content:space-between;">' +
                '<div class="emp-cell">' +
                  '<div class="emp-avatar">' + initials + '</div>' +
                  '<div>' +
                    '<div class="emp-name">' + empName + '</div>' +
                    '<div class="emp-email">' + empId + '</div>' +
                  '</div>' +
                '</div>' +
                '<div style="display:inline-flex; align-items:center; gap:6px;">' +
                  '<span class="acc-chip" id="' + rowId + '_mob" data-raw="' + accRaw + '" data-masked="' + accMasked + '">' + accMasked + '</span>' +
                  (accRaw !== '-' ? '<button type="button" onclick="toggleAdminAccView(\'' + rowId + '_mob\', this)" style="background:none; border:none; cursor:pointer; color:#64748b; font-size:14px; padding:2px 4px;" title="Show/Hide"><i class="fa-solid fa-eye-slash"></i></button>' : '') +
                '</div>' +
              '</div>' +
              '<div class="mobile-bank-details">' +
                '<div class="mobile-bank-row">' +
                  '<span class="mobile-bank-label">Bank Name:</span>' +
                  '<span class="mobile-bank-val" style="color:var(--blue);">' + bank + '</span>' +
                '</div>' +
                '<div class="mobile-bank-row">' +
                  '<span class="mobile-bank-label">Branch:</span>' +
                  '<span class="mobile-bank-val">' + branch + '</span>' +
                '</div>' +
                '<div class="mobile-bank-row">' +
                  '<span class="mobile-bank-label">Account Holder:</span>' +
                  '<span class="mobile-bank-val">' + empName + '</span>' +
                '</div>' +
              '</div>';
              mobileContainer.appendChild(card);
            }

          });
        } else {
          if (tbody) tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 30px 20px; color: #6b7280;">No bank records found.</td></tr>';
          if (mobileContainer) mobileContainer.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #6b7280; background:#fff; border-radius:12px;">No bank records found.</div>';
        }
      },
      error: function() {
        var tbody = document.getElementById('bankTableBody');
        var mobileContainer = document.getElementById('mobileBankCardsContainer');
        if (tbody) tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 30px 20px; color: #6b7280;">No bank records found in database.</td></tr>';
        if (mobileContainer) mobileContainer.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #6b7280; background:#fff; border-radius:12px;">No bank records found in database.</div>';
      }
    });
  }

  window.toggleAdminAccView = function(chipId, btn) {
    var chip = document.getElementById(chipId);
    if (!chip) return;
    var raw = chip.getAttribute('data-raw');
    var masked = chip.getAttribute('data-masked');
    var icon = btn.querySelector('i');

    if (chip.textContent === masked) {
      chip.textContent = raw;
      chip.style.letterSpacing = '0.5px';
      chip.style.background = '#eef2ff';
      chip.style.color = '#1e3a8a';
      if (icon) icon.className = 'fa-solid fa-eye';
    } else {
      chip.textContent = masked;
      chip.style.letterSpacing = 'normal';
      chip.style.background = '#f1f5f9';
      chip.style.color = '#334155';
      if (icon) icon.className = 'fa-solid fa-eye-slash';
    }
  };
</script>