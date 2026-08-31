<style>
  :root{
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #10b981;
    --green-bg: #ecfdf5;
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

  *{ 
    box-sizing:border-box; 
    margin:0; padding:0; 
  }

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
    color: var(--navy); 
  }
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
  .menu-btn svg{ 
    width:20px; 
    height:20px; 
  }

  /* Sub-Navigation Tabs */
  .bank-tabs-nav {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 8px;
  }
  .bank-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 700;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 6px 6px 0 0;
  }
  .bank-tab-btn:hover {
    color: var(--navy);
    background: #f1f5f9;
  }
  .bank-tab-btn.active {
    color: var(--blue);
    border-bottom-color: var(--blue);
    background: var(--blue-lighter);
  }
  .bank-tab-badge {
    background: #e2e8f0;
    color: #475569;
    font-size: 11px;
    padding: 2px 7px;
    border-radius: 999px;
    font-weight: 800;
  }
  .bank-tab-btn.active .bank-tab-badge {
    background: var(--blue);
    color: #ffffff;
  }

  .page-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }
  .page-head p{ 
    font-size:14px; 
    color: var(--muted); 
    margin-top: 4px; 
  }

  .head-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
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

  .pay-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
  }
  .pay-btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-1px);
  }

  .notice-banner{
    display:flex;
    align-items:center;
    gap:12px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    color: #065f46;
    font-size: 13.5px;
  }
  .notice-banner svg{ 
    width:18px; 
    height:18px; 
    flex-shrink:0; 
    color: #10b981; 
  }

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

  .salary-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
    font-weight: 800;
    font-size: 13px;
    padding: 5px 11px;
    border-radius: 8px;
  }

  .view-acc-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    border: 1px solid var(--border);
    color: var(--navy);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .view-acc-btn:hover {
    background: var(--blue-lighter);
    border-color: var(--blue);
    color: var(--blue);
  }

  .table-pay-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .table-pay-btn:hover {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    transform: translateY(-1px);
  }

  .table-receipt-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .table-receipt-btn:hover {
    background: #10b981;
    color: #ffffff;
    border-color: #10b981;
    transform: translateY(-1px);
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
    min-width: 820px;
  }
  table.emp-table thead th{
    text-align:left;
    font-size: 12px;
    text-transform:uppercase;
    letter-spacing: .04em;
    color: var(--muted);
    font-weight:700;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    background: #fafbfd;
  }
  table.emp-table tbody td{
    padding: 14px 18px;
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

  /* Modals Overlay */
  .bank-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(4px);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
    overflow-y: auto;
  }

  .bank-modal-card {
    background: #ffffff;
    width: 100%;
    max-width: 580px;
    border-radius: 18px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    overflow: hidden;
    animation: bankModalPop 0.25s ease-out;
    margin: auto;
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
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .bank-modal-close {
    background: none;
    border: none;
    font-size: 22px;
    color: #64748b;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    line-height: 1;
  }

  .bank-modal-body {
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    max-height: 78vh;
    overflow-y: auto;
  }

  .bank-form-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
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

  /* Dedicated PNG Upload Dropzone */
  .receipt-image-dropzone {
    border: 2px dashed #94a3b8;
    border-radius: 12px;
    padding: 22px 16px;
    background: #f8fafc;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .receipt-image-dropzone:hover {
    border-color: #2563eb;
    background: #eff6ff;
  }
  .receipt-image-preview-box {
    display: none;
    position: relative;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
  }
  .receipt-image-preview-img {
    width: 100%;
    max-height: 240px;
    object-fit: contain;
    background: #ffffff;
    display: block;
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

  /* Mobile Responsive Receipts Card Layout */
  .emp-mobile-receipt-cards {
    display: none;
    flex-direction: column;
    gap: 12px;
    padding: 16px;
  }
  .emp-mobile-receipt-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
  }

  /* Mobile Responsive */
  @media (max-width: 768px){
    #Admin_user_dashboard_04_bank_details { padding: 0 12px 80px !important; }
    .main{ margin-left: 0 !important; width: 100% !important; max-width: 100% !important; padding: 0 !important; }
    .menu-btn{ display: inline-flex !important; }
    .topbar h2{ font-size: 18px !important; }
    .head-actions { width: 100%; flex-direction: column; gap: 8px; }
    .search-input { width: 100% !important; }
    .add-btn, .pay-btn-primary { width: 100%; justify-content: center; }
    .bank-form-grid-2 { grid-template-columns: 1fr; }
    .table-wrap { display: none !important; }
    .emp-mobile-receipt-cards { display: flex !important; }
    .bank-modal-overlay { padding: 8px !important; }
    .bank-modal-card { border-radius: 14px !important; }
    .bank-modal-body { padding: 16px !important; }
    .bank-modal-footer { padding: 12px 16px !important; }
  }
</style>

<div id="Admin_user_dashboard_04_bank_details" style="display:none;">
  <main class="main">

    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_04" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Bank Details & Payment Receipts</h2>
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

    <!-- Tab Sub-Navigation -->
    <div class="bank-tabs-nav">
      <button type="button" class="bank-tab-btn active" id="tabBtnAccounts" onclick="switchAdminBankTab('accounts')">
        <i class="fa-solid fa-building-columns"></i>
        <span>Bank Accounts & Fixed Salaries</span>
        <span class="bank-tab-badge" id="bankAccountsCountBadge">0</span>
      </button>
      <button type="button" class="bank-tab-btn" id="tabBtnPayments" onclick="switchAdminBankTab('payments')">
        <i class="fa-solid fa-receipt"></i>
        <span>Uploaded PNG Receipts</span>
        <span class="bank-tab-badge" id="paymentReceiptsCountBadge">0</span>
      </button>
    </div>

    <!-- ================= TAB 1: BANK ACCOUNTS ================= -->
    <div id="adminTabBankAccountsView">
      <div class="page-head">
        <div>
          <p>Employee salary bank accounts,monthly salary configuration, and PNG receipt delivery</p>
        </div>
        <div class="head-actions">
          <div class="search-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="adminBankSearchInput" class="search-input" placeholder="Search employee or bank..." oninput="filterAdminBankRows(this.value)">
          </div>
        </div>
      </div>

      <!-- Desktop Table -->
      <div class="table-card">
        <div class="table-wrap">
          <table class="emp-table">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Account Holder</th>
                <th>Bank & Branch</th>
                <th>Account Number</th>
                <th>Monthly Salary</th>
                <th style="text-align:right;">Actions</th>
              </tr>
            </thead>
            <tbody id="bankTableBody">
              <tr>
                <td colspan="6" style="text-align:center; padding: 30px 20px; color: #6b7280;">Loading bank details...</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Mobile Bank Cards -->
        <div class="emp-mobile-receipt-cards" id="adminMobileBankCardsContainer">
          <div style="text-align:center; padding: 30px 16px; color: #6b7280;">Loading bank details...</div>
        </div>
      </div>
    </div>

    <!-- ================= TAB 2: UPLOADED PNG RECEIPTS ================= -->
    <div id="adminTabPaymentsView" style="display:none;">
      <div class="page-head">
        <div>
          <p>List of all uploaded payment receipts and PNG bank slips sent to employees</p>
        </div>
        <div class="head-actions">
          <div class="search-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="adminPaymentSearchInput" class="search-input" placeholder="Search receipt or employee..." oninput="filterAdminPaymentRows(this.value)">
          </div>
          <button type="button" class="pay-btn-primary" onclick="openAdminUploadReceiptModal()">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span>Upload Receipt (PNG)</span>
          </button>
        </div>
      </div>

      <div class="table-card">
        <div class="table-wrap">
          <table class="emp-table">
            <thead>
              <tr>
                <th>Receipt #</th>
                <th>Employee</th>
                <th>Disbursement Date</th>
                <th>Payment Period</th>
                <th>Paid Amount</th>
                <th style="text-align:right;">Action</th>
              </tr>
            </thead>
            <tbody id="adminPaymentsTableBody">
              <tr>
                <td colspan="7" style="text-align:center; padding: 30px 20px; color: #6b7280;">Loading payment receipts...</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Mobile Payments Cards -->
        <div class="emp-mobile-receipt-cards" id="adminMobilePaymentsContainer">
          <div style="text-align:center; padding: 30px 16px; color: #6b7280;">Loading payment receipts...</div>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- ================= MODAL: Simple Upload Payment Receipt (PNG) Modal ================= -->
<div class="bank-modal-overlay" id="adminUploadReceiptModalOverlay" onclick="if(event.target===this) closeAdminUploadReceiptModal();">
  <div class="bank-modal-card">
    <div class="bank-modal-head">
      <h3><i class="fa-solid fa-file-image" style="color:var(--blue);"></i> Upload Payment Receipt (PNG)</h3>
      <button type="button" class="bank-modal-close" onclick="closeAdminUploadReceiptModal()">&times;</button>
    </div>
    
    <form id="adminUploadReceiptForm" onsubmit="event.preventDefault(); submitAdminUploadReceiptForm();">
      <div class="bank-modal-body">

        <!-- 1. Select Employee -->
        <div class="bank-form-group">
          <label for="uploadSelectEmployee">Select Employee</label>
          <select id="uploadSelectEmployee" class="bank-form-select" onchange="onUploadEmployeeChange(this.value)" required>
            <option value="" disabled selected>-- Choose employee --</option>
          </select>
        </div>

        <input type="hidden" id="uploadEmpId" value="">
        <input type="hidden" id="uploadUserId" value="1">
        <input type="hidden" id="uploadEmpName" value="">
        <input type="hidden" id="uploadBankName" value="">
        <input type="hidden" id="uploadBranch" value="">
        <input type="hidden" id="uploadAccNo" value="">

        <!-- 2. Date & Payment Period (Selectable Month & Year) -->
        <div class="bank-form-grid-2">
          <div class="bank-form-group">
            <label for="uploadReceiptDate"><i class="fa-solid fa-calendar-day" style="color:var(--blue);"></i> Payment / Receipt Date</label>
            <input type="date" id="uploadReceiptDate" class="bank-form-input" value="<?php echo date('Y-m-d'); ?>" required>
          </div>

          <!-- Selectable Month & Year -->
          <div class="bank-form-group">
            <label><i class="fa-solid fa-calendar-alt" style="color:var(--blue);"></i> Payment Period</label>
            <div style="display:flex; gap:8px;">
              <select id="uploadPeriodMonth" class="bank-form-select" style="flex:1;" required>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August" selected>August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
              <select id="uploadPeriodYear" class="bank-form-select" style="width:105px;" required>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
              </select>
            </div>
          </div>
        </div>

        <!-- 3. Paid Salary Amount (Editable per employee) -->
        <div class="bank-form-group">
          <label for="uploadReceiptAmount"><i class="fa-solid fa-money-bill-wave" style="color:#10b981;"></i> Monthly Salary / Paid Amount (LKR)</label>
          <input type="number" step="0.01" id="uploadReceiptAmount" class="bank-form-input" placeholder="e.g. 1000.00" value="" required>
          <small style="color:#64748b; font-size:11.5px;">This salary amount will be displayed to the employee in their dashboard.</small>
        </div>

        <!-- 4. PNG Image Upload Area -->
        <div class="bank-form-group">
          <label><i class="fa-solid fa-image" style="color:#10b981;"></i> Upload Receipt PNG / Image / Slip</label>
          <input type="file" id="uploadReceiptFileInput" accept="image/png,image/jpeg,image/jpg,image/webp,application/pdf" style="display:none;" onchange="handleReceiptFileSelect(this)" required>
          
          <div class="receipt-image-dropzone" id="uploadReceiptDropzone" onclick="document.getElementById('uploadReceiptFileInput').click()">
            <i class="fa-solid fa-cloud-arrow-up" style="font-size:30px; color:var(--blue);"></i>
            <span style="font-weight:700; color:#1e293b; font-size:14px;">Click to select Receipt PNG Image</span>
            <span style="font-size:12px; color:#64748b;">Upload bank transfer slip screenshot or payment receipt PNG</span>
          </div>

          <div class="receipt-image-preview-box" id="uploadReceiptPreviewBox">
            <img id="uploadReceiptPreviewImg" class="receipt-image-preview-img" src="" alt="Receipt Preview">
            <div style="padding:8px 12px; background:#fff; display:flex; justify-content:space-between; align-items:center; font-size:12px; border-top:1px solid #e2e8f0;">
              <span id="uploadReceiptPreviewName" style="font-weight:700; color:#1e293b;">receipt.png</span>
              <button type="button" class="view-acc-btn" style="padding:4px 10px; color:#dc2626; border-color:#fecaca;" onclick="clearUploadedReceiptFile(event)"><i class="fa-solid fa-trash"></i> Change</button>
            </div>
          </div>
        </div>

      </div>
      
      <div class="bank-modal-footer">
        <button type="button" class="view-acc-btn" style="padding:10px 16px;" onclick="closeAdminUploadReceiptModal()">Cancel</button>
        <button type="submit" class="pay-btn-primary" id="adminUploadSubmitBtn" style="padding:10px 24px;">
          <i class="fa-solid fa-paper-plane"></i>
          <span>Send Receipt to Employee</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ================= MODAL: View PNG Receipt Modal ================= -->
<div class="bank-modal-overlay" id="adminViewReceiptModalOverlay" onclick="if(event.target===this) closeAdminViewReceiptModal();">
  <div class="bank-modal-card" style="max-width:680px;">
    <div class="bank-modal-head">
      <h3><i class="fa-solid fa-receipt" style="color:var(--blue);"></i> Payment Receipt Details & PNG</h3>
      <button type="button" class="bank-modal-close" onclick="closeAdminViewReceiptModal()">&times;</button>
    </div>
    
    <div class="bank-modal-body">
      <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; display:grid; grid-template-columns:repeat(2,1fr); gap:10px; font-size:13.5px;">
        <div><span style="color:#64748b;">Receipt #:</span> <strong id="viewModalReceiptNo" style="color:var(--blue); font-family:monospace;">REC-202608-0001</strong></div>
        <div><span style="color:#64748b;">Disbursement Date:</span> <strong id="viewModalReceiptDate">2026-08-30</strong></div>
        <div><span style="color:#64748b;">Employee:</span> <strong id="viewModalReceiptEmp">John Doe</strong></div>
        <div><span style="color:#64748b;">Payment Period:</span> <strong id="viewModalReceiptMonth" style="color:var(--navy);">August 2026</strong></div>
        <div id="viewModalAmountWrap" style="grid-column:1/-1;"><span style="color:#64748b;">Paid Salary Amount:</span> <strong id="viewModalReceiptAmount" style="color:#059669; font-size:15.5px;">LKR 150,000.00</strong></div>
      </div>

      <div style="border:1px solid #cbd5e1; border-radius:12px; overflow:hidden; background:#ffffff; text-align:center; padding:10px;">
        <img id="viewModalReceiptImg" src="" alt="Payment Receipt PNG" style="max-width:100%; max-height:420px; object-fit:contain; cursor:pointer;" onclick="window.open(this.src, '_blank')" title="Click to view full image">
      </div>
    </div>

    <div class="bank-modal-footer">
      <a id="viewModalDownloadBtn" href="#" download class="view-acc-btn" style="padding:10px 18px; text-decoration:none;"><i class="fa-solid fa-download"></i> Download PNG</a>
      <button type="button" class="pay-btn-primary" style="padding:10px 20px;" onclick="closeAdminViewReceiptModal()">Done</button>
    </div>
  </div>
</div>

<!-- ================= MODAL: Add / Edit Bank & Fixed Salary Modal ================= -->
<div class="bank-modal-overlay" id="adminBankModalOverlay" onclick="if(event.target===this) closeAdminBankModal();">
  <div class="bank-modal-card">
    <div class="bank-modal-head">
      <h3 id="adminBankModalTitle"><i class="fa-solid fa-building-columns" style="color:var(--blue);"></i> Add Bank Account & Salary</h3>
      <button type="button" class="bank-modal-close" onclick="closeAdminBankModal()">&times;</button>
    </div>
    <form id="adminBankForm" onsubmit="event.preventDefault(); submitAdminBankForm();">
      <div class="bank-modal-body">
        <input type="hidden" id="adminBankEditId" value="0">
        
        <div class="bank-form-grid-2">
          <div class="bank-form-group">
            <label for="adminBankEmpId">Employee ID</label>
            <input type="text" id="adminBankEmpId" class="bank-form-input" placeholder="e.g., EMP-001" required>
          </div>
          <div class="bank-form-group">
            <label for="adminBankHolderName">Account Holder Name</label>
            <input type="text" id="adminBankHolderName" class="bank-form-input" placeholder="Name on bank account" required>
          </div>
        </div>

        <div class="bank-form-grid-2">
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
            </select>
          </div>
          <div class="bank-form-group">
            <label for="adminBankBranch">Branch</label>
            <input type="text" id="adminBankBranch" class="bank-form-input" placeholder="e.g., Colombo Main" required>
          </div>
        </div>

        <div class="bank-form-group">
          <label for="adminBankAccNo">Bank Account Number</label>
          <input type="text" id="adminBankAccNo" class="bank-form-input" placeholder="e.g., 0012345678901" required autocomplete="off">
        </div>

        <!-- Monthly Salary Field -->
        <div class="bank-form-group">
          <label for="adminFixedSalary"><i class="fa-solid fa-coins" style="color:#f59e0b;"></i> Monthly Salary (LKR)</label>
          <input type="number" step="0.01" id="adminFixedSalary" class="bank-form-input" placeholder="e.g. 1000.00" value="" required>
          <small style="color:#64748b; font-size:11.5px;">This salary will be saved for this employee and displayed in their dashboard.</small>
        </div>
      </div>

      <div class="bank-modal-footer">
        <button type="button" class="view-acc-btn" style="padding:10px 16px;" onclick="closeAdminBankModal()">Cancel</button>
        <button type="submit" class="add-btn" id="adminBankSubmitBtn" style="padding:10px 20px;">
          <span>Save Bank & Salary</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  window.adminBankDataCache = [];
  window.adminPaymentsCache = [];
  window.selectedReceiptFile = null;

  document.addEventListener("DOMContentLoaded", function() {
    // Auto-select current month & year in Period selectors
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var currentMonth = monthNames[new Date().getMonth()];
    var currentYear = String(new Date().getFullYear());
    
    var mSel = document.getElementById('uploadPeriodMonth');
    if (mSel) mSel.value = currentMonth;
    var ySel = document.getElementById('uploadPeriodYear');
    if (ySel) ySel.value = currentYear;

    window.loadAdminBankDetails();
    window.loadAdminPaymentReceipts();
  });

  window.switchAdminBankTab = function(tabName) {
    var btnAcc = document.getElementById('tabBtnAccounts');
    var btnPay = document.getElementById('tabBtnPayments');
    var viewAcc = document.getElementById('adminTabBankAccountsView');
    var viewPay = document.getElementById('adminTabPaymentsView');

    if (tabName === 'accounts') {
      if (btnAcc) btnAcc.classList.add('active');
      if (btnPay) btnPay.classList.remove('active');
      if (viewAcc) viewAcc.style.display = 'block';
      if (viewPay) viewPay.style.display = 'none';
      window.loadAdminBankDetails();
    } else {
      if (btnAcc) btnAcc.classList.remove('active');
      if (btnPay) btnPay.classList.add('active');
      if (viewAcc) viewAcc.style.display = 'none';
      if (viewPay) viewPay.style.display = 'block';
      window.loadAdminPaymentReceipts();
    }
  };

  // 1. Load Bank Accounts & Salaries
  window.loadAdminBankDetails = function() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    $.ajax({
      url: pth + "View-List/Bank_details/List_All_Bank_Details.php",
      type: "GET",
      dataType: "json",
      success: function(response) {
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var list = Array.isArray(resObj.data) ? resObj.data : [];

        window.adminBankDataCache = list;
        var badge = document.getElementById('bankAccountsCountBadge');
        if (badge) badge.innerText = list.length;
        renderAdminBankRows(list);
        populateUploadEmployeeDropdown(list);
      },
      error: function() {
        renderAdminBankRows([]);
      }
    });
  };

  function renderAdminBankRows(list) {
    var tbody = document.getElementById('bankTableBody');
    var mobContainer = document.getElementById('adminMobileBankCardsContainer');
    if (!tbody) return;

    if (!list || list.length === 0) {
      tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 30px 20px; color: #6b7280;">No bank records found.</td></tr>';
      if (mobContainer) mobContainer.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #6b7280;">No bank records found.</div>';
      return;
    }

    tbody.innerHTML = '';
    if (mobContainer) mobContainer.innerHTML = '';

    list.forEach(function(row) {
      var empName = row.employee_name || row.account_holder_name || row.holder_name || 'Employee';
      var holderName = row.account_holder_name || row.holder_name || empName;
      var empId = row.employee_id || ('EMP-' + String(row.user_id || 1).padStart(3, '0'));
      var bank = row.bank_name || '-';
      var branch = row.branch || '-';
      var accRaw = row.bank_account_number || row.account_number || '-';
      var accMasked = (accRaw && accRaw !== '-') ? (accRaw.length > 4 ? accRaw.slice(-4).padStart(accRaw.length, '•') : accRaw) : '-';
      var fixedSal = parseFloat(row.net_salary || row.basic_salary || '-').toLocaleString('en-US', { minimumFractionDigits: 2 });
      var initials = empName !== 'Employee' ? empName.split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase() : 'EM';
      var jsonPayload = encodeURIComponent(JSON.stringify(row));

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
      '<td><span style="font-weight:700; color:var(--blue);">' + bank + '</span><br><small style="color:#64748b;">' + branch + '</small></td>' +
      '<td><span class="acc-chip">' + accMasked + '</span></td>' +
      '<td><span class="salary-chip"><i class="fa-solid fa-coins"></i> LKR ' + fixedSal + '</span></td>' +
      '<td style="text-align:right;">' +
        '<div style="display:inline-flex; align-items:center; gap:6px;">' +
          '<button type="button" class="table-pay-btn" onclick="openAdminUploadReceiptForEmp(\'' + jsonPayload + '\')"><i class="fa-solid fa-cloud-arrow-up"></i> Upload Receipt</button>' +
        '</div>' +
      '</td>';
      tbody.appendChild(tr);

      if (mobContainer) {
        var card = document.createElement('div');
        card.className = 'emp-mobile-receipt-card';
        card.innerHTML = '<div style="display:flex; justify-content:space-between; align-items:center;">' +
          '<div class="emp-cell">' +
            '<div class="emp-avatar">' + initials + '</div>' +
            '<div>' +
              '<div class="emp-name">' + empName + '</div>' +
              '<div class="emp-email">' + empId + '</div>' +
            '</div>' +
          '</div>' +
          '<span class="salary-chip"><i class="fa-solid fa-coins"></i> LKR ' + fixedSal + '</span>' +
        '</div>' +
        '<div style="font-size:13px; color:#475569; display:flex; flex-direction:column; gap:4px; margin-top:4px;">' +
          '<div><span style="color:#64748b;">Bank:</span> <strong>' + bank + ' (' + branch + ')</strong></div>' +
          '<div><span style="color:#64748b;">Account:</span> <span class="acc-chip" style="font-size:11.5px; padding:3px 8px;">' + accMasked + '</span></div>' +
        '</div>' +
        '<div style="display:flex; gap:8px; margin-top:6px;">' +
          '<button type="button" class="table-pay-btn" style="flex:1; justify-content:center; padding:9px;" onclick="openAdminUploadReceiptForEmp(\'' + jsonPayload + '\')"><i class="fa-solid fa-cloud-arrow-up"></i> Upload Receipt</button>' +
          '<button type="button" class="view-acc-btn" style="padding:9px 14px;" onclick="openAdminBankModal(' + JSON.stringify(row).replace(/"/g, '&quot;') + ')"><i class="fa-solid fa-pen"></i></button>' +
        '</div>';
        mobContainer.appendChild(card);
      }
    });
  }

  // 2. Load Payment Receipts
  window.loadAdminPaymentReceipts = function() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    $.ajax({
      url: pth + "View-List/Salary_Payments/List_Salary_Payments.php",
      type: "GET",
      dataType: "json",
      success: function(response) {
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var list = Array.isArray(resObj.data) ? resObj.data : [];

        window.adminPaymentsCache = list;
        var badge = document.getElementById('paymentReceiptsCountBadge');
        if (badge) badge.innerText = list.length;
        renderAdminPaymentRows(list);
      },
      error: function() {
        renderAdminPaymentRows([]);
      }
    });
  };

  function renderAdminPaymentRows(list) {
    var tbody = document.getElementById('adminPaymentsTableBody');
    var mobContainer = document.getElementById('adminMobilePaymentsContainer');
    if (!tbody) return;

    if (!list || list.length === 0) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px 20px; color: #6b7280;">No receipts uploaded yet.</td></tr>';
      if (mobContainer) mobContainer.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #6b7280;">No receipts uploaded yet.</div>';
      return;
    }

    tbody.innerHTML = '';
    if (mobContainer) mobContainer.innerHTML = '';

    list.forEach(function(row) {
      var recNo = row.receipt_no || ('REC-' + row.id);
      var empName = row.employee_name || 'Employee';
      var empId = row.employee_id || 'EMP-001';
      var month = row.payment_month || '-';
      var date = row.payment_date || '-';
      var amount = parseFloat(row.net_salary || 0).toLocaleString('en-US', { minimumFractionDigits: 2 });
      var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
      var hasImg = row.receipt_image && row.receipt_image.trim() !== '';
      var imgUrl = hasImg ? ((row.receipt_image.startsWith('http') || row.receipt_image.startsWith('data:')) ? row.receipt_image : (pth + row.receipt_image)) : '';
      var jsonPayload = encodeURIComponent(JSON.stringify(row));

      var tr = document.createElement('tr');
      tr.innerHTML = '<td><strong style="color:var(--blue); font-family:monospace;">' + recNo + '</strong></td>' +
        '<td>' +
          '<div class="emp-name">' + empName + '</div>' +
          '<div class="emp-email">' + empId + '</div>' +
        '</td>' +
        '<td><span style="font-weight:700; color:#1e293b;"><i class="fa-solid fa-calendar-day" style="color:var(--blue); margin-right:4px;"></i>' + date + '</span></td>' +
        '<td><strong>' + month + '</strong></td>' +
        '<td><strong style="color:#059669;">LKR ' + amount + '</strong></td>' +
        '<td>' +
          (hasImg ? '<img src="' + imgUrl + '" style="height:36px; max-width:60px; object-fit:cover; border-radius:6px; border:1px solid #cbd5e1; cursor:pointer;" onclick="openAdminViewReceiptModal(\'' + jsonPayload + '\')">' : '<span style="color:#94a3b8; font-size:12px;">No PNG</span>') +
        '</td>'; 
        
      tbody.appendChild(tr);

      if (mobContainer) {
        var card = document.createElement('div');
        card.className = 'emp-mobile-receipt-card';
        card.innerHTML = '<div style="display:flex; justify-content:space-between; align-items:center;">' +
          '<strong style="color:var(--blue); font-family:monospace;">' + recNo + '</strong>' +
          '<span style="font-size:12px; color:#64748b;"><i class="fa-solid fa-calendar-day" style="color:var(--blue);"></i> ' + date + '</span>' +
        '</div>' +
        '<div style="font-size:13px; color:#475569; display:flex; flex-direction:column; gap:4px;">' +
          '<div><span style="color:#64748b;">Employee:</span> <strong>' + empName + ' (' + empId + ')</strong></div>' +
          '<div><span style="color:#64748b;">Period:</span> <strong>' + month + '</strong></div>' +
          '<div><span style="color:#64748b;">Paid Amount:</span> <strong style="color:#059669;">LKR ' + amount + '</strong></div>' +
        '</div>' ;
        mobContainer.appendChild(card);
      }
    });
  }

  // 3. Upload Modal Logic
  function populateUploadEmployeeDropdown(bankList) {
    var sel = document.getElementById('uploadSelectEmployee');
    if (!sel) return;
    sel.innerHTML = '<option value="" disabled selected>-- Choose employee --</option>';

    if (bankList && bankList.length > 0) {
      bankList.forEach(function(row, idx) {
        var empName = row.employee_name || row.account_holder_name || row.holder_name || 'Employee';
        var empId = row.employee_id || ('EMP-' + String(row.user_id || 1).padStart(3, '0'));
        var opt = document.createElement('option');
        opt.value = idx;
        opt.textContent = empName + ' (' + empId + ')';
        sel.appendChild(opt);
      });
    }
  }

  window.onUploadEmployeeChange = function(idx) {
    if (idx === '' || typeof window.adminBankDataCache[idx] === 'undefined') return;
    var data = window.adminBankDataCache[idx];
    setUploadModalFields(data);
  };

  function setUploadModalFields(data) {
    var empName = data.employee_name || data.account_holder_name || data.holder_name || 'Employee';
    var empId = data.employee_id || ('EMP-' + String(data.user_id || 1).padStart(3, '0'));
    var bank = data.bank_name || '-';
    var branch = data.branch || '-';
    var acc = data.bank_account_number || data.account_number || '-';
    var fixedSal = parseFloat(data.net_salary || data.basic_salary || '-');

    document.getElementById('uploadEmpId').value = empId;
    document.getElementById('uploadUserId').value = data.user_id || 1;
    document.getElementById('uploadEmpName').value = empName;
    document.getElementById('uploadBankName').value = bank;
    document.getElementById('uploadBranch').value = branch;
    document.getElementById('uploadAccNo').value = acc;
    
    // Auto-fill individual employee's salary
    var amtInput = document.getElementById('uploadReceiptAmount');
    if (amtInput) amtInput.value = fixedSal.toFixed(2);
  }

  window.openAdminUploadReceiptModal = function() {
    var overlay = document.getElementById('adminUploadReceiptModalOverlay');
    clearUploadedReceiptFile();
    populateUploadEmployeeDropdown(window.adminBankDataCache);
    if (window.adminBankDataCache.length > 0) {
      var sel = document.getElementById('uploadSelectEmployee');
      if (sel) sel.selectedIndex = 1;
      setUploadModalFields(window.adminBankDataCache[0]);
    }
    if (overlay) overlay.style.display = 'flex';
  };

  window.openAdminUploadReceiptForEmp = function(encodedJson) {
    try {
      var data = JSON.parse(decodeURIComponent(encodedJson));
      var overlay = document.getElementById('adminUploadReceiptModalOverlay');
      clearUploadedReceiptFile();
      populateUploadEmployeeDropdown(window.adminBankDataCache);

      var sel = document.getElementById('uploadSelectEmployee');
      if (sel) {
        for (var i = 0; i < sel.options.length; i++) {
          if (sel.options[i].text.includes(data.employee_id || data.employee_name)) {
            sel.selectedIndex = i;
            break;
          }
        }
      }
      setUploadModalFields(data);
      if (overlay) overlay.style.display = 'flex';
    } catch(e) {}
  };

  window.closeAdminUploadReceiptModal = function() {
    var overlay = document.getElementById('adminUploadReceiptModalOverlay');
    if (overlay) overlay.style.display = 'none';
  };

  window.handleReceiptFileSelect = function(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    window.selectedReceiptFile = file;

    var dropzone = document.getElementById('uploadReceiptDropzone');
    var previewBox = document.getElementById('uploadReceiptPreviewBox');
    var previewImg = document.getElementById('uploadReceiptPreviewImg');
    var previewName = document.getElementById('uploadReceiptPreviewName');

    if (previewName) previewName.innerText = file.name;

    if (file.type && file.type.startsWith('image/')) {
      var reader = new FileReader();
      reader.onload = function(e) {
        if (previewImg) previewImg.src = e.target.result;
        if (dropzone) dropzone.style.display = 'none';
        if (previewBox) previewBox.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      if (dropzone) dropzone.style.display = 'none';
      if (previewBox) previewBox.style.display = 'block';
    }
  };

  window.clearUploadedReceiptFile = function(e) {
    if (e) e.stopPropagation();
    window.selectedReceiptFile = null;
    var inp = document.getElementById('uploadReceiptFileInput');
    if (inp) inp.value = '';
    var dropzone = document.getElementById('uploadReceiptDropzone');
    var previewBox = document.getElementById('uploadReceiptPreviewBox');
    var previewImg = document.getElementById('uploadReceiptPreviewImg');
    if (previewImg) previewImg.src = '';
    if (dropzone) dropzone.style.display = 'flex';
    if (previewBox) previewBox.style.display = 'none';
  };

  window.submitAdminUploadReceiptForm = function() {
    var empId = document.getElementById('uploadEmpId').value.trim();
    var empName = document.getElementById('uploadEmpName').value.trim();
    var date = document.getElementById('uploadReceiptDate').value.trim();
    var mVal = document.getElementById('uploadPeriodMonth').value;
    var yVal = document.getElementById('uploadPeriodYear').value;
    var period = mVal + ' ' + yVal;
    var amount = parseFloat(document.getElementById('uploadReceiptAmount').value) || 0;
    var bank = document.getElementById('uploadBankName').value.trim();
    var branch = document.getElementById('uploadBranch').value.trim();
    var accNo = document.getElementById('uploadAccNo').value.trim();
    var userId = document.getElementById('uploadUserId').value || 1;

    if (!empName) {
      alert('Please select an employee.');
      return;
    }
    if (!window.selectedReceiptFile) {
      alert('Please select a PNG / receipt image to upload.');
      return;
    }

    var btn = document.getElementById('adminUploadSubmitBtn');
    var origHtml = btn ? btn.innerHTML : 'Send Receipt to Employee';
    if (btn) {
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading & Saving...';
      btn.disabled = true;
    }

    var formData = new FormData();
    formData.append('employee_id', empId);
    formData.append('user_id', userId);
    formData.append('employee_name', empName);
    formData.append('bank_name', bank);
    formData.append('branch', branch);
    formData.append('account_number', accNo);
    formData.append('payment_date', date);
    formData.append('payment_month', period);
    formData.append('net_salary', amount);
    formData.append('basic_salary', amount);
    formData.append('receipt_image', window.selectedReceiptFile);

    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    $.ajax({
      url: pth + "View-List/Salary_Payments/Process_Payment.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = origHtml;
        }
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var isSuccess = (resObj.error === "0" || resObj.status === "success");

        if (isSuccess) {
          closeAdminUploadReceiptModal();
          window.loadAdminPaymentReceipts();
          window.loadAdminBankDetails();
          alert('Payment receipt (' + period + ') sent to ' + empName + ' successfully!');
          switchAdminBankTab('payments');
        } else {
          alert('Error: ' + (resObj.message || 'Could not upload receipt.'));
        }
      },
      error: function() {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = origHtml;
        }
        closeAdminUploadReceiptModal();
        window.loadAdminPaymentReceipts();
        window.loadAdminBankDetails();
        switchAdminBankTab('payments');
      }
    });
  };

  // 4. View PNG Receipt Modal Logic
  window.openAdminViewReceiptModal = function(encodedJson) {
    try {
      var d = JSON.parse(decodeURIComponent(encodedJson));
      var overlay = document.getElementById('adminViewReceiptModalOverlay');
      var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');

      document.getElementById('viewModalReceiptNo').innerText = d.receipt_no || 'REC-001';
      document.getElementById('viewModalReceiptDate').innerText = d.payment_date || '<?php echo date("Y-m-d"); ?>';
      document.getElementById('viewModalReceiptEmp').innerText = (d.employee_name || 'Employee') + ' (' + (d.employee_id || 'EMP-001') + ')';
      document.getElementById('viewModalReceiptMonth').innerText = d.payment_month || '-';

      var amtSpan = document.getElementById('viewModalReceiptAmount');
      if (d.net_salary && parseFloat(d.net_salary) > 0) {
        if (amtSpan) amtSpan.innerText = 'LKR ' + parseFloat(d.net_salary).toLocaleString('en-US', { minimumFractionDigits: 2 });
      } else {
        if (amtSpan) amtSpan.innerText = 'LKR 0.00';
      }

      var img = document.getElementById('viewModalReceiptImg');
      var downloadBtn = document.getElementById('viewModalDownloadBtn');
      if (d.receipt_image && d.receipt_image.trim() !== '') {
        var fullImgUrl = (d.receipt_image.startsWith('http') || d.receipt_image.startsWith('data:')) ? d.receipt_image : (pth + d.receipt_image);
        if (img) img.src = fullImgUrl;
        if (downloadBtn) {
          downloadBtn.href = fullImgUrl;
          downloadBtn.download = (d.receipt_no || 'receipt') + '.png';
        }
      }

      if (overlay) overlay.style.display = 'flex';
    } catch(e) {}
  };

  window.closeAdminViewReceiptModal = function() {
    var overlay = document.getElementById('adminViewReceiptModalOverlay');
    if (overlay) overlay.style.display = 'none';
  };

  // 5. Add / Edit Bank & Fixed Salary Modal
  window.openAdminBankModal = function(editData) {
    var overlay = document.getElementById('adminBankModalOverlay');
    var title = document.getElementById('adminBankModalTitle');
    var editId = document.getElementById('adminBankEditId');
    var empId = document.getElementById('adminBankEmpId');
    var holder = document.getElementById('adminBankHolderName');
    var bank = document.getElementById('adminBankSelectName');
    var branch = document.getElementById('adminBankBranch');
    var accNo = document.getElementById('adminBankAccNo');
    var fixedSal = document.getElementById('adminFixedSalary');

    if (editData) {
      if (title) title.innerHTML = '<i class="fa-solid fa-pen-to-square" style="color:var(--blue);"></i> Edit Bank & Salary';
      if (editId) editId.value = editData.id || 0;
      if (empId) empId.value = editData.employee_id || 'EMP-001';
      if (holder) holder.value = editData.account_holder_name || editData.holder_name || editData.employee_name || '';
      if (bank) bank.value = editData.bank_name || '';
      if (branch) branch.value = editData.branch || '';
      if (accNo) accNo.value = editData.bank_account_number || editData.account_number || '';
      if (fixedSal) fixedSal.value = parseFloat(editData.net_salary || editData.basic_salary || '-').toFixed(2);
    } else {
      if (title) title.innerHTML = '<i class="fa-solid fa-building-columns" style="color:var(--blue);"></i> Add Bank Account & Salary';
      if (editId) editId.value = 0;
      if (empId) empId.value = '';
      if (holder) holder.value = '';
      if (bank) bank.value = '';
      if (branch) branch.value = '';
      if (accNo) accNo.value = '';
      if (fixedSal) fixedSal.value = '';
    }

    if (overlay) overlay.style.display = 'flex';
  };

  window.closeAdminBankModal = function() {
    var overlay = document.getElementById('adminBankModalOverlay');
    if (overlay) overlay.style.display = 'none';
  };

  window.submitAdminBankForm = function() {
    var editId = document.getElementById('adminBankEditId').value;
    var empId = document.getElementById('adminBankEmpId').value.trim();
    var holder = document.getElementById('adminBankHolderName').value.trim();
    var bank = document.getElementById('adminBankSelectName').value;
    var branch = document.getElementById('adminBankBranch').value.trim();
    var accNum = document.getElementById('adminBankAccNo').value.trim();
    var fixedSal = parseFloat(document.getElementById('adminFixedSalary').value) || 0;

    if (!empId || !holder || !bank || !branch || !accNum) {
      alert('Please fill in all bank details.');
      return;
    }

    var payload = {
      id: editId,
      employee_id: empId,
      account_holder_name: holder,
      holder_name: holder,
      bank_name: bank,
      branch: branch,
      account_number: accNum,
      bank_account_number: accNum,
      net_salary: fixedSal,
      basic_salary: fixedSal,
      user_id: 1
    };

    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    $.ajax({
      url: pth + "UxUi-Back/Bank_Details/account_number.php",
      type: "POST",
      data: payload,
      dataType: "json",
      success: function() {
        closeAdminBankModal();
        window.loadAdminBankDetails();
      },
      error: function() {
        closeAdminBankModal();
        window.loadAdminBankDetails();
      }
    });
  };

  window.filterAdminBankRows = function(query) {
    var q = (query || '').toLowerCase().trim();
    if (!q) { renderAdminBankRows(window.adminBankDataCache); return; }
    var filtered = window.adminBankDataCache.filter(function(row) {
      return (row.employee_name || '').toLowerCase().includes(q) || (row.employee_id || '').toLowerCase().includes(q) || (row.bank_name || '').toLowerCase().includes(q);
    });
    renderAdminBankRows(filtered);
  };

  window.filterAdminPaymentRows = function(query) {
    var q = (query || '').toLowerCase().trim();
    if (!q) { renderAdminPaymentRows(window.adminPaymentsCache); return; }
    var filtered = window.adminPaymentsCache.filter(function(row) {
      return (row.receipt_no || '').toLowerCase().includes(q) || (row.employee_name || '').toLowerCase().includes(q) || (row.payment_month || '').toLowerCase().includes(q) || (row.payment_date || '').toLowerCase().includes(q);
    });
    renderAdminPaymentRows(filtered);
  };
</script>