<style>
  :root{
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #38a169;
    --green-bg: #e3f9ee;
    --amber: #dd6b20;
    --amber-bg: #fdf1dc;
    --red: #e53e3e;
    --red-bg: #fde8ec;
    --ink: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
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
  .topbar h2{ 
    font-size: 22px; 
    font-weight:800; 
    color: var(--navy); 
    letter-spacing:-.3px; 
  }

  .topbar-right{ 
    display:flex; 
    align-items:center; 
    gap:14px; 
  }

  .icon-btn{
    width:40px; height:40px;
    border-radius:50%;
    background: var(--blue-lighter);
    display:flex; 
    align-items:center; 
    justify-content:center;
    position:relative;
    cursor:pointer;
  }
  .icon-btn svg{ 
    width:18px; 
    height:18px; 
    color: var(--navy); }
  .dot{
    position:absolute; 
    top:8px; 
    right:9px;
    width:7px; 
    height:7px; 
    border-radius:50%;
    background: var(--red);
    border: 2px solid var(--card);
  }
  .admin-pill{
    display:flex; 
    align-items:center; 
    gap:8px;
    background: var(--blue-lighter);
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    cursor:pointer;
  }
  .admin-pill .avatar{ 
    width:30px; 
    height:30px; 
    font-size:11.5px; 
    background:var(--navy); 
    color:#fff; 
    border-radius:50%; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    font-weight:700;
   }
  .admin-pill span{ 
    font-size:13.5px;
    font-weight:700; 
    color:var(--navy); 
    }

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
    align-items:center;
    justify-content:space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }
  .page-head p{ font-size:14px; color: var(--muted); margin-top: 4px; }

  .head-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }
  .search-input-wrap i {
    position: absolute;
    left: 12px;
    color: var(--muted);
    font-size: 13px;
  }
  .search-input {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 9px 12px 9px 34px;
    font-size: 13.5px;
    color: var(--ink);
    outline: none;
    transition: all 0.2s ease;
    width: 220px;
  }
  .search-input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59,91,219,0.12);
  }

  .add-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--navy);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(20,32,77,0.15);
  }
  .add-btn:hover {
    background: var(--navy-2);
    transform: translateY(-1px);
  }

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
    min-width: 720px;
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

  .action-btn-sm {
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--navy);
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.15s ease;
  }
  .action-btn-sm:hover {
    background: var(--blue-lighter);
    border-color: var(--blue);
  }

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

  /* Admin Add/Edit Bank Modal */
  .bank-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(3px);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
  }

  .bank-modal-card {
    background: #ffffff;
    width: 100%;
    max-width: 520px;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    overflow: hidden;
    animation: bankModalPop 0.25s ease-out;
  }

  @keyframes bankModalPop {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  .bank-modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid #e2e8f0;
    background: #fafbfd;
  }
  .bank-modal-head h3 {
    margin: 0;
    font-size: 17px;
    font-weight: 800;
    color: var(--navy);
  }
  .bank-modal-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #64748b;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
  }
  .bank-modal-close:hover {
    background: #f1f5f9;
    color: #0f172a;
  }

  .bank-modal-body {
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .bank-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .bank-form-group label {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
  }
  .bank-form-input, .bank-form-select {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 14px;
    color: #1e293b;
    outline: none;
    font-family: inherit;
    box-sizing: border-box;
  }
  .bank-form-input:focus, .bank-form-select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59,91,219,0.12);
  }

  .bank-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
  }

  /* Mobile Responsive Breakpoints */
  @media (max-width: 768px){
    #Admin_user_dashboard_04_bank_details {
      padding: 0 12px 80px !important;
    }
    .main{
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 0 !important;
    }

    .menu-btn{ display: inline-flex !important; }
    .topbar h2{ font-size: 18px !important; }
    .page-head h1{ font-size: 19px !important; }
    .head-actions { width: 100%; flex-direction: column; gap: 8px; }
    .search-input-wrap { width: 100%; }
    .search-input { width: 100% !important; }
    .add-btn { width: 100%; justify-content: center; }

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
      <div class="head-actions">
        <div class="search-input-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" id="adminBankSearchInput" class="search-input" placeholder="Search bank records..." oninput="filterAdminBankRows(this.value)">
        </div>
        <button type="button" class="add-btn" onclick="openAdminBankModal()">
          <i class="fa-solid fa-plus"></i>
          <span>Add Bank Account</span>
        </button>
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

<!-- ================= Admin Add Bank Modal ================= -->
<div class="bank-modal-overlay" id="adminBankModalOverlay" onclick="if(event.target===this) closeAdminBankModal();">
  <div class="bank-modal-card">
    <div class="bank-modal-head">
      <h3 id="adminBankModalTitle">Add Bank Account</h3>
      <button type="button" class="bank-modal-close" onclick="closeAdminBankModal()">&times;</button>
    </div>
    <form id="adminBankForm" onsubmit="event.preventDefault(); submitAdminBankForm();">
      <div class="bank-modal-body">
        <div class="bank-form-group">
          <label for="adminBankEmpId">Employee ID / Code</label>
          <input type="text" id="adminBankEmpId" class="bank-form-input" placeholder="e.g., EMP-001" required>
        </div>
        <div class="bank-form-group">
          <label for="adminBankHolderName">Account Holder Name</label>
          <input type="text" id="adminBankHolderName" class="bank-form-input" placeholder="Full name as on bank account" required>
        </div>
        <div class="bank-form-group">
          <label for="adminBankSelectName">Bank Name</label>
          <select id="adminBankSelectName" class="bank-form-select" required>
            <option value="" disabled selected>Select bank</option>
            <option value="Commercial Bank of Ceylon">Commercial Bank of Ceylon</option>
            <option value="Bank of Ceylon (BOC)">Bank of Ceylon (BOC)</option>
            <option value="People's Bank">People's Bank</option>
            <option value="Hatton National Bank (HNB)">Hatton National Bank (HNB)</option>
            <option value="Sampath Bank">Sampath Bank</option>
            <option value="Seylan Bank">Seylan Bank</option>
            <option value="National Development Bank (NDB)">National Development Bank (NDB)</option>
            <option value="Nations Trust Bank (NTB)">Nations Trust Bank (NTB)</option>
            <option value="DFCC Bank">DFCC Bank</option>
            <option value="Pan Asia Bank">Pan Asia Bank</option>
            <option value="Union Bank of Colombo">Union Bank of Colombo</option>
            <option value="Standard Chartered Bank">Standard Chartered Bank</option>
            <option value="HSBC Sri Lanka">HSBC Sri Lanka</option>
          </select>
        </div>
        <div class="bank-form-group">
          <label for="adminBankBranch">Branch</label>
          <input type="text" id="adminBankBranch" class="bank-form-input" placeholder="e.g., Colombo Main Branch" required>
        </div>
        <div class="bank-form-group">
          <label for="adminBankAccNo">Bank Account Number</label>
          <input type="text" id="adminBankAccNo" class="bank-form-input" placeholder="e.g., 0012345678901" required autocomplete="off">
        </div>
      </div>
      <div class="bank-modal-footer">
        <button type="button" class="action-btn-sm" style="padding:10px 16px;" onclick="closeAdminBankModal()">Cancel</button>
        <button type="submit" class="add-btn" id="adminBankSubmitBtn" style="padding:10px 20px;">
          <span>Save Bank Account</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  window.adminBankDataCache = [];

  document.addEventListener("DOMContentLoaded", function() {
    // 1. Instant recovery from local cache on page load
    try {
      var cached = localStorage.getItem('neo_admin_bank_list');
      if (cached) {
        var parsed = JSON.parse(cached);
        if (Array.isArray(parsed) && parsed.length > 0) {
          window.adminBankDataCache = parsed;
          renderAdminBankRows(parsed);
        }
      }
    } catch(e) {}

    // 2. Fetch authoritative database list
    window.loadAdminBankDetails();
  });

  window.loadAdminBankDetails = function() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    $.ajax({
      url: pth + "View-List/Bank_details/List_All_Bank_Details.php",
      type: "GET",
      dataType: "json",
      success: function(response) {
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var isSuccess = (resObj.error === "0" || resObj.status === "success");
        var list = Array.isArray(resObj.data) ? resObj.data : [];

        if (isSuccess && list.length > 0) {
          window.adminBankDataCache = list;
          renderAdminBankRows(window.adminBankDataCache);
        } else {
          window.adminBankDataCache = [];
          renderAdminBankRows([]);
        }
      },
      error: function() {
        window.adminBankDataCache = [];
        var tbody = document.getElementById('bankTableBody');
        var mobileContainer = document.getElementById('mobileBankCardsContainer');
        if (tbody) tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 30px 20px; color: #6b7280;">No bank records found.</td></tr>';
        if (mobileContainer) mobileContainer.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #6b7280; background:#fff; border-radius:12px;">No bank records found.</div>';
      }
    });
  };

  function renderAdminBankRows(list) {
    var tbody = document.getElementById('bankTableBody');
    var mobileContainer = document.getElementById('mobileBankCardsContainer');

    if (!list || list.length === 0) {
      if (tbody) tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 30px 20px; color: #6b7280;">No bank records found.</td></tr>';
      if (mobileContainer) mobileContainer.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #6b7280; background:#fff; border-radius:12px;">No bank records found.</div>';
      return;
    }

    if (tbody) tbody.innerHTML = '';
    if (mobileContainer) mobileContainer.innerHTML = '';

    list.forEach(function(row) {
      var empName = row.employee_name || row.account_holder_name || row.holder_name || 'N/A';
      var holderName = row.account_holder_name || row.holder_name || empName;
      var empId = row.employee_id || ('EMP-' + String(row.user_id || 1).padStart(3, '0'));
      var bank = row.bank_name || '-';
      var branch = row.branch || '-';
      var accRaw = row.bank_account_number || row.account_number || '-';
      var accMasked = (accRaw && accRaw !== '-') ? (accRaw.length > 4 ? accRaw.slice(-4).padStart(accRaw.length, '•') : accRaw) : '-';
      var initials = empName !== 'N/A' ? empName.split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase() : 'EM';

      var rowId = 'acc_row_' + Math.random().toString(36).substr(2, 9);

      // Desktop Table Row (Secure Read-Only View)
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
        '<td><strong style="color:#1e293b;">' + holderName + '</strong></td>' +
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

      // Mobile Card Item (Secure Read-Only View)
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
            '<span class="mobile-bank-val">' + holderName + '</span>' +
          '</div>' +
        '</div>';
        mobileContainer.appendChild(card);
      }
    });
  }

  window.filterAdminBankRows = function(query) {
    var q = (query || '').toLowerCase().trim();
    if (!q) {
      renderAdminBankRows(window.adminBankDataCache);
      return;
    }
    var filtered = window.adminBankDataCache.filter(function(row) {
      var emp = (row.employee_name || '').toLowerCase();
      var id = (row.employee_id || '').toLowerCase();
      var holder = (row.account_holder_name || row.holder_name || '').toLowerCase();
      var bank = (row.bank_name || '').toLowerCase();
      var branch = (row.branch || '').toLowerCase();
      var acc = (row.bank_account_number || row.account_number || '').toLowerCase();
      return emp.includes(q) || id.includes(q) || holder.includes(q) || bank.includes(q) || branch.includes(q) || acc.includes(q);
    });
    renderAdminBankRows(filtered);
  };

  window.openAdminBankModal = function(editData) {
    var overlay = document.getElementById('adminBankModalOverlay');
    var title = document.getElementById('adminBankModalTitle');
    var empId = document.getElementById('adminBankEmpId');
    var holder = document.getElementById('adminBankHolderName');
    var bank = document.getElementById('adminBankSelectName');
    var branch = document.getElementById('adminBankBranch');
    var accNo = document.getElementById('adminBankAccNo');

    if (editData) {
      if (title) title.innerText = 'Edit Bank Account';
      if (empId) empId.value = editData.employee_id || 'EMP-001';
      if (holder) holder.value = editData.account_holder_name || editData.holder_name || editData.employee_name || '';
      if (bank) bank.value = editData.bank_name || '';
      if (branch) branch.value = editData.branch || '';
      if (accNo) accNo.value = editData.bank_account_number || editData.account_number || '';
    } else {
      if (title) title.innerText = 'Add Bank Account';
      if (empId) empId.value = 'EMP-001';
      if (holder) holder.value = '';
      if (bank) bank.value = '';
      if (branch) branch.value = '';
      if (accNo) accNo.value = '';
    }

    if (overlay) overlay.style.display = 'flex';
  };

  window.closeAdminBankModal = function() {
    var overlay = document.getElementById('adminBankModalOverlay');
    if (overlay) overlay.style.display = 'none';
  };

  window.submitAdminBankForm = function() {
    var empId = document.getElementById('adminBankEmpId').value.trim();
    var holder = document.getElementById('adminBankHolderName').value.trim();
    var bank = document.getElementById('adminBankSelectName').value;
    var branch = document.getElementById('adminBankBranch').value.trim();
    var accNum = document.getElementById('adminBankAccNo').value.trim();

    if (!empId || !holder || !bank || !branch || !accNum) {
      alert('Please fill in all bank details.');
      return;
    }

    var btn = document.getElementById('adminBankSubmitBtn');
    var origHtml = btn ? btn.innerHTML : 'Save Bank Account';
    if (btn) {
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
      btn.disabled = true;
    }

    var pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
    var payload = {
      employee_id: empId,
      account_holder_name: holder,
      holder_name: holder,
      bank_name: bank,
      branch: branch,
      account_number: accNum,
      bank_account_number: accNum,
      user_id: 1
    };

    $.ajax({
      url: pth + "UxUi-Back/Bank_Details/account_number.php",
      type: "POST",
      data: payload,
      dataType: "json",
      success: function(res) {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = origHtml;
        }
        var resObj = Array.isArray(res) ? (res[0] || {}) : (res || {});
        var isSuccess = (resObj.error === "0" || resObj.status === "success");

        if (isSuccess) {
          closeAdminBankModal();
          window.loadAdminBankDetails();
        } else {
          alert('Error: ' + (resObj.message || resObj.error || 'Could not save bank details.'));
        }
      },
      error: function() {
        $.ajax({
          url: pth + "View-List/Bank_details/Save_Bank_Details.php",
          type: "POST",
          data: payload,
          dataType: "json",
          success: function(res2) {
            if (btn) {
              btn.disabled = false;
              btn.innerHTML = origHtml;
            }
            var resObj2 = Array.isArray(res2) ? (res2[0] || {}) : (res2 || {});
            var isSuccess2 = (resObj2.error === "0" || resObj2.status === "success");
            if (isSuccess2) {
              closeAdminBankModal();
              window.loadAdminBankDetails();
            } else {
              alert('Error: ' + (resObj2.message || resObj2.error || 'Could not save bank details.'));
            }
          },
          error: function() {
            if (btn) {
              btn.disabled = false;
              btn.innerHTML = origHtml;
            }
            alert('Failed to connect to the database.');
          }
        });
      }
    });
  };

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