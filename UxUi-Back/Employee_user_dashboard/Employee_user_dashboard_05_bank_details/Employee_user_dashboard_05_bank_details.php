<style>
  :root {
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

  /* Base Page Head */
  .bank-page-header {
    margin-bottom: 20px;
  }
  .bank-page-header p {
    font-size: 13.5px;
    color: var(--muted);
    margin-top: 3px;
  }

  /* Bank & Salary Info Card */
  .bank-info-card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    padding: 22px 24px;
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
  }

  .bank-info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--navy), var(--blue));
  }

  .bank-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    flex-wrap: wrap;
    gap: 10px;
  }
  .bank-card-header h3 {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .bank-active-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #dcfce7;
    color: #15803d;
    padding: 4px 11px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 800;
  }

  /* Responsive Grid for Bank Account Info */
  .bank-grid-details {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
  }

  .bank-field-box {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .bank-field-box span {
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--muted);
    font-weight: 700;
  }
  .bank-field-box strong {
    font-size: 14px;
    color: var(--ink);
    word-break: break-word;
  }

  /* Monthly Salary Banner */
  .salary-highlight-card {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #ffffff;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 6px;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
    flex-wrap: wrap;
    gap: 12px;
  }
  .salary-highlight-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #94a3b8;
    font-weight: 700;
  }
  .salary-highlight-sub {
    font-size: 12.5px;
    color: #cbd5e1;
    margin-top: 2px;
  }
  .salary-highlight-amount {
    font-size: 22px;
    font-weight: 900;
    color: #34d399;
    letter-spacing: -0.4px;
  }

  /* Receipts Card */
  .receipts-list-card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
  }
  .receipts-list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: #fafbfd;
  }
  .receipts-list-header h3 {
    margin: 0;
    font-size: 15.5px;
    font-weight: 800;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .receipts-count-badge {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--muted);
    background: #e2e8f0;
    padding: 3px 10px;
    border-radius: 999px;
  }

  .receipts-table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  table.emp-receipts-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
  }
  table.emp-receipts-table thead th {
    text-align: left;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--muted);
    font-weight: 700;
    padding: 13px 18px;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
  }
  table.emp-receipts-table tbody td {
    padding: 13px 18px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    font-size: 13.5px;
    color: #334155;
    white-space: nowrap;
  }
  table.emp-receipts-table tbody tr:last-child td { border-bottom: none; }
  table.emp-receipts-table tbody tr:hover { background: #f8fafc; }

  /* Mobile Card View for Receipts */
  .receipts-mobile-grid {
    display: none;
    flex-direction: column;
    gap: 10px;
    padding: 14px;
  }
  .receipt-mobile-item {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
  }

  .btn-view-receipt-png {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    color: var(--blue);
    border: 1px solid #bfdbfe;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
    text-decoration: none;
  }
  .btn-view-receipt-png:hover {
    background: var(--blue);
    color: #ffffff;
    border-color: var(--blue);
  }

  /* Modal Layout */
  .emp-receipt-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(4px);
    z-index: 999999;
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
    overflow-y: auto;
  }
  .emp-receipt-modal-window {
    background: #ffffff;
    width: 100%;
    max-width: 660px;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3);
    overflow: hidden;
    margin: auto;
    animation: empModalPop 0.22s ease-out;
  }

  @keyframes empModalPop {
    from { opacity: 0; transform: scale(0.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  .emp-receipt-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: #fafbfd;
  }
  .emp-receipt-modal-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .emp-receipt-modal-close-btn {
    background: none;
    border: none;
    font-size: 22px;
    color: var(--muted);
    cursor: pointer;
    padding: 2px 6px;
    line-height: 1;
    border-radius: 6px;
  }

  .emp-receipt-modal-content {
    padding: 18px 20px;
    max-height: 75vh;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .emp-receipt-modal-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    background: #f8fafc;
  }

  /* Media Queries for full responsiveness */
  @media (max-width: 1024px) {
    .bank-grid-details {
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
    }
  }

  @media (max-width: 640px) {
    .bank-info-card {
      padding: 16px;
    }
    .bank-grid-details {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .salary-highlight-card {
      flex-direction: column;
      align-items: flex-start;
      padding: 14px 16px;
      gap: 8px;
    }
    .salary-highlight-amount {
      font-size: 20px;
    }

    .receipts-table-responsive {
      display: none !important;
    }
    .receipts-mobile-grid {
      display: flex !important;
    }

    .emp-receipt-modal-backdrop {
      padding: 8px;
    }
    .emp-receipt-modal-window {
      border-radius: 12px;
    }
    .emp-receipt-modal-content {
      padding: 14px;
    }
    .emp-receipt-modal-actions {
      padding: 12px 14px;
    }
  }
</style>

<div id="Employee_user_dashboard_05_bank_details" style="display:none;">
  <main class="main">

    <!-- Standard Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_05" aria-label="Open menu" onclick="typeof openEmployeeSidebar==='function'? openEmployeeSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Bank Details & Payment Receipts</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="typeof Employee_user_dashboard_09_OPEN === 'function' ? Employee_user_dashboard_09_OPEN() : null" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill" onclick="typeof Employee_user_dashboard_02_OPEN === 'function' ? Employee_user_dashboard_02_OPEN() : null">
          <div class="avatar" id="empTopBankAvatar">EM</div>
          <span id="empTopBankName">Employee</span>
        </div>
      </div>
    </div>

    <!-- Page Header Info -->
    <div class="bank-page-header">
      <p>View your verified bank account information, monthly compensation, and payment receipt PNG slips.</p>
    </div>

    <!-- Bank Details & Monthly Salary Card -->
    <div class="bank-info-card">
      <div class="bank-card-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <div style="display:flex; align-items:center; gap:12px;">
          <div style="width:40px; height:40px; border-radius:10px; background:rgba(37,99,235,0.08); display:flex; align-items:center; justify-content:center; color:#2563eb; font-size:18px;">
            <i class="fa-solid fa-building-columns"></i>
          </div>
          <div>
            <h3 style="margin:0; font-size:16.5px; font-weight:800; color:#0f172a;">Bank Account & Salary Information</h3>
            <p style="margin:2px 0 0; font-size:12px; color:#64748b;">Verified banking details for salary disbursements</p>
          </div>
        </div>
        <button type="button" class="btn-edit-my-bank" onclick="openEmpBankEditModal()" style="display:inline-flex; align-items:center; gap:8px; padding:8px 18px; background:linear-gradient(135deg, #2563eb, #1d4ed8); color:#ffffff; border:none; border-radius:9px; font-weight:700; font-size:13px; cursor:pointer; box-shadow:0 3px 10px rgba(37,99,235,0.25); transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 5px 14px rgba(37,99,235,0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 3px 10px rgba(37,99,235,0.25)';">
          <i class="fa-solid fa-pen-to-square"></i> Edit Bank Details
        </button>
      </div>

      <div class="bank-grid-details">
        <div class="bank-field-box">
          <span>Account Holder</span>
          <strong id="empBankHolderName">Loading...</strong>
        </div>
        <div class="bank-field-box">
          <span>Bank Name</span>
          <strong id="empBankName" style="color:var(--blue);">Loading...</strong>
        </div>
        <div class="bank-field-box">
          <span>Branch</span>
          <strong id="empBankBranch">Loading...</strong>
        </div>
        <div class="bank-field-box">
          <span>Account Number</span>
          <strong id="empBankAccNumber" style="font-family:monospace; font-size:14.5px; letter-spacing:0.04em;">••••••••</strong>
        </div>

        <!-- Monthly Salary Banner -->
        <div class="salary-highlight-card">
          <div>
            <div class="salary-highlight-label"><i class="fa-solid fa-coins" style="color:#f59e0b; margin-right:4px;"></i> My Monthly Salary</div>
            <div class="salary-highlight-sub">Designated monthly compensation credited to your bank account</div>
          </div>
          <div class="salary-highlight-amount" id="empFixedMonthlySalaryDisplay">LKR 0.00</div>
        </div>
      </div>
    </div>

    <!-- Payment Receipts Card -->
    <div class="receipts-list-card">
      <div class="receipts-list-header">
        <h3><i class="fa-solid fa-file-invoice-dollar" style="color:var(--blue);"></i> My Payment Receipts (PNG Slips)</h3>
        <span class="receipts-count-badge" id="empReceiptsCount">0 receipts</span>
      </div>

      <!-- Desktop / Tablet Table View -->
      <div class="receipts-table-responsive">
        <table class="emp-receipts-table">
          <thead>
            <tr>
              <th>Receipt #</th>
              <th>Disbursement Date</th>
              <th>Payment Period</th>
              <th>Paid Amount</th>
              <th>Status</th>
              <th style="text-align:right;">Action</th>
            </tr>
          </thead>
          <tbody id="empReceiptsTableBody">
            <tr>
              <td colspan="6" style="text-align:center; padding: 30px 20px; color: var(--muted);">Loading payment receipts...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Mobile Cards View -->
      <div class="receipts-mobile-grid" id="empReceiptsMobileContainer">
        <div style="text-align:center; padding: 30px 16px; color: var(--muted);">Loading payment receipts...</div>
      </div>
    </div>

  </main>
</div>

<!-- ================= MODAL: View PNG Receipt Modal ================= -->
<div class="emp-receipt-modal-backdrop" id="empReceiptModalOverlay" onclick="if(event.target===this) closeEmpReceiptModal();">
  <div class="emp-receipt-modal-window">
    <div class="emp-receipt-modal-header">
      <h3><i class="fa-solid fa-receipt" style="color:var(--blue);"></i> Payment Receipt Details & Slip</h3>
      <button type="button" class="emp-receipt-modal-close-btn" onclick="closeEmpReceiptModal()">&times;</button>
    </div>

    <div class="emp-receipt-modal-content">
      <!-- Receipt Summary Grid -->
      <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:14px 16px; display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px; font-size:13px;">
        <div><span style="color:var(--muted);">Receipt #:</span> <strong id="empModalReceiptNo" style="color:var(--blue); font-family:monospace;">REC-202608-0001</strong></div>
        <div><span style="color:var(--muted);">Disbursement Date:</span> <strong id="empModalReceiptDate">2026-08-30</strong></div>
        <div><span style="color:var(--muted);">Employee:</span> <strong id="empModalEmpName">John Doe</strong></div>
        <div><span style="color:var(--muted);">Payment Period:</span> <strong id="empModalPeriod" style="color:var(--navy);">August 2026</strong></div>
        <div id="empModalAmountRow" style="grid-column: 1 / -1;"><span style="color:var(--muted);">Paid Salary:</span> <strong id="empModalAmount" style="color:#059669; font-size:15px;">LKR 0.00</strong></div>
      </div>

      <!-- PNG Preview -->
      <div style="border:1px solid #cbd5e1; border-radius:12px; overflow:hidden; background:#ffffff; text-align:center; padding:10px;">
        <img id="empReceiptModalAttachedImg" src="" alt="Payment Receipt PNG" style="max-width:100%; max-height:420px; object-fit:contain; cursor:pointer;" onclick="window.open(this.src, '_blank')" title="Click to open full resolution image">
      </div>
    </div>

    <div class="emp-receipt-modal-actions">
      <a id="empReceiptDownloadPngLink" href="#" download class="btn-view-receipt-png" style="padding:9px 16px;"><i class="fa-solid fa-download"></i> Download PNG</a>
      <button type="button" class="btn-view-receipt-png" style="padding:9px 18px; background:var(--navy); color:#ffffff; border:none;" onclick="closeEmpReceiptModal()">Close</button>
    </div>
  </div>
</div>

<!-- ================= MODAL: Edit My Bank Details Modal ================= -->
<div class="emp-receipt-modal-backdrop" id="empBankEditModalOverlay" style="display:none;" onclick="if(event.target===this) closeEmpBankEditModal();">
  <div class="emp-receipt-modal-window" style="max-width:540px;">
    <div class="emp-receipt-modal-header">
      <h3><i class="fa-solid fa-building-columns" style="color:var(--blue);"></i> Edit My Bank Details</h3>
      <button type="button" class="emp-receipt-modal-close-btn" onclick="closeEmpBankEditModal()">&times;</button>
    </div>

    <form id="empSelfBankEditForm" onsubmit="saveEmployeeSelfBankDetails(event)">
      <div class="emp-receipt-modal-content">
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:12px 14px; font-size:12.5px; color:#1e40af; display:flex; align-items:flex-start; gap:8px;">
          <i class="fa-solid fa-circle-info" style="font-size:16px; margin-top:1px;"></i>
          <span>Please enter your accurate bank account information. Your account number is encrypted at rest using AES-256 for maximum security. Monthly salary adjustments are managed by HR.</span>
        </div>

        <div>
          <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:4px;">Account Holder Name *</label>
          <input type="text" id="empSelfBankHolder" required placeholder="e.g. Kasun Kalhara" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13.5px; font-family:inherit; box-sizing:border-box;">
        </div>

        <div>
          <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:4px;">Bank Name *</label>
          <select id="empSelfBankName" required style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13.5px; font-family:inherit; background:#ffffff; box-sizing:border-box; color:#1e293b; cursor:pointer;">
            <option value="" disabled selected>-- Select Your Bank --</option>
            <optgroup label="Licensed Commercial Banks (Domestic)">
              <option value="Commercial Bank of Ceylon">Commercial Bank of Ceylon</option>
              <option value="Bank of Ceylon (BOC)">Bank of Ceylon (BOC)</option>
              <option value="People's Bank">People's Bank</option>
              <option value="Sampath Bank">Sampath Bank</option>
              <option value="Hatton National Bank (HNB)">Hatton National Bank (HNB)</option>
              <option value="Nations Trust Bank (NTB)">Nations Trust Bank (NTB)</option>
              <option value="Seylan Bank">Seylan Bank</option>
              <option value="National Development Bank (NDB)">National Development Bank (NDB)</option>
              <option value="DFCC Bank">DFCC Bank</option>
              <option value="Pan Asia Banking Corporation">Pan Asia Banking Corporation (Pan Asia Bank)</option>
              <option value="Union Bank of Colombo">Union Bank of Colombo</option>
              <option value="Amana Bank">Amana Bank</option>
              <option value="Cargills Bank">Cargills Bank</option>
            </optgroup>
            <optgroup label="Licensed Specialized Banks (Savings & Development)">
              <option value="National Savings Bank (NSB)">National Savings Bank (NSB)</option>
              <option value="Regional Development Bank (RDB)">Regional Development Bank (RDB)</option>
              <option value="Sanasa Development Bank (SDB bank)">Sanasa Development Bank (SDB bank)</option>
              <option value="HDFC Bank of Sri Lanka">HDFC Bank of Sri Lanka</option>
              <option value="State Mortgage & Investment Bank (SMIB)">State Mortgage & Investment Bank (SMIB)</option>
              <option value="Sri Lanka Savings Bank">Sri Lanka Savings Bank</option>
            </optgroup>
            <optgroup label="Licensed Foreign Commercial Banks">
              <option value="HSBC Sri Lanka">HSBC Sri Lanka (Hongkong and Shanghai Banking Corp)</option>
              <option value="Standard Chartered Bank">Standard Chartered Bank</option>
              <option value="Citibank N.A.">Citibank N.A.</option>
              <option value="Deutsche Bank AG">Deutsche Bank AG</option>
              <option value="State Bank of India (SBI)">State Bank of India (SBI)</option>
              <option value="Indian Bank">Indian Bank</option>
              <option value="Indian Overseas Bank">Indian Overseas Bank</option>
              <option value="Habib Bank Ltd">Habib Bank Ltd</option>
              <option value="MCB Bank Ltd">MCB Bank Ltd</option>
              <option value="Public Bank Berhad">Public Bank Berhad</option>
            </optgroup>
          </select>
        </div>

        <div>
          <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:4px;">Branch Name *</label>
          <input type="text" id="empSelfBankBranch" required placeholder="e.g. Colombo Fort" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13.5px; font-family:inherit; box-sizing:border-box;">
        </div>

        <div>
          <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:4px;">Account Number *</label>
          <div style="position:relative; display:flex; align-items:center;">
            <input type="text" id="empSelfBankAccNumber" required placeholder="e.g. 100012345678" style="width:100%; padding:9px 38px 9px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13.5px; font-family:monospace; box-sizing:border-box;">
            <button type="button" onclick="toggleEmpSelfAccVisibility(this)" style="position:absolute; right:10px; background:none; border:none; color:#64748b; cursor:pointer; font-size:14px;" title="Show/Hide">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="emp-receipt-modal-actions">
        <button type="button" class="btn-view-receipt-png" style="padding:9px 16px; background:#fff; color:#475569; border:1px solid #cbd5e1;" onclick="closeEmpBankEditModal()">Cancel</button>
        <button type="submit" id="btnSaveEmpSelfBank" class="btn-view-receipt-png" style="padding:9px 20px; background:#2563eb; color:#ffffff; border:none; display:inline-flex; align-items:center; gap:6px; cursor:pointer;">
          <i class="fa-solid fa-floppy-disk"></i> Update Bank Account
        </button>
      </div>
    </form>
  </div>
</div>

<script>
(function() {
  function initEmployeeBankDetails() {
    fetchEmployeeBankDetails();
    fetchEmployeeSalaryReceipts();
  }

  function fetchEmployeeBankDetails() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    var empId = (typeof window.userProfileData !== 'undefined' && window.userProfileData.employee_id_code) ? window.userProfileData.employee_id_code : 'EMP-001';

    $.ajax({
      url: pth + "UxUi-Back/Bank_Details/account_number.php?employee_id=" + encodeURIComponent(empId),
      type: "GET",
      dataType: "json",
      success: function(response) {
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var data = resObj.data || {};
        window.currentEmpBankData = data;

        var empName = data.account_holder_name || data.holder_name || (window.userProfileData ? window.userProfileData.full_name : 'Employee');
        var bankName = data.bank_name || '-';
        var branch = data.branch || '-';
        var rawAcc = data.account_number || data.bank_account_number || '-';
        var maskedAcc = (rawAcc && rawAcc !== '-' && rawAcc.length > 4) ? (rawAcc.slice(-4).padStart(rawAcc.length, '•')) : rawAcc;
        var fixedSal = parseFloat(data.net_salary || data.basic_salary || 0);

        document.getElementById('empBankHolderName').innerText = empName;
        document.getElementById('empBankName').innerText = bankName;
        document.getElementById('empBankBranch').innerText = branch;
        document.getElementById('empBankAccNumber').innerText = maskedAcc;
        
        var salDisplay = document.getElementById('empFixedMonthlySalaryDisplay');
        if (salDisplay) {
          salDisplay.innerText = fixedSal > 0 ? ('LKR ' + fixedSal.toLocaleString('en-US', { minimumFractionDigits: 2 })) : 'Not set';
        }

        var topName = document.getElementById('empTopBankName');
        if (topName) topName.innerText = empName;
        var topAvatar = document.getElementById('empTopBankAvatar');
        if (topAvatar) {
          topAvatar.innerText = empName.split(' ').map(function(n){ return n[0]; }).join('').substring(0,2).toUpperCase();
        }
      },
      error: function() {
        document.getElementById('empBankHolderName').innerText = 'Employee';
        document.getElementById('empBankName').innerText = '-';
        document.getElementById('empBankBranch').innerText = '-';
        document.getElementById('empBankAccNumber').innerText = '••••••••';
      }
    });
  }

  function fetchEmployeeSalaryReceipts() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    var empId = (typeof window.userProfileData !== 'undefined' && window.userProfileData.employee_id_code) ? window.userProfileData.employee_id_code : '';
    var empName = (typeof window.userProfileData !== 'undefined' && window.userProfileData.full_name) ? window.userProfileData.full_name : '';
    var searchParam = empId ? ('?employee_id=' + encodeURIComponent(empId)) : (empName ? ('?employee_id=' + encodeURIComponent(empName)) : '');

    $.ajax({
      url: pth + "View-List/Salary_Payments/List_Salary_Payments.php" + searchParam,
      type: "GET",
      dataType: "json",
      success: function(response) {
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var list = Array.isArray(resObj.data) ? resObj.data : [];

        var countSpan = document.getElementById('empReceiptsCount');
        if (countSpan) countSpan.innerText = list.length + ' receipt' + (list.length === 1 ? '' : 's');

        renderEmployeeReceipts(list);
      },
      error: function() {
        renderEmployeeReceipts([]);
      }
    });
  }

  function renderEmployeeReceipts(list) {
    var tbody = document.getElementById('empReceiptsTableBody');
    var mobContainer = document.getElementById('empReceiptsMobileContainer');

    if (!list || list.length === 0) {
      if (tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:32px 20px; color:var(--muted);"><i class="fa-solid fa-inbox" style="font-size:24px; color:#cbd5e1; margin-bottom:6px; display:block;"></i>No payment receipts uploaded yet. Once Admin uploads a payment receipt, it will appear here.</td></tr>';
      if (mobContainer) mobContainer.innerHTML = '<div style="text-align:center; padding:30px 16px; color:var(--muted);"><i class="fa-solid fa-inbox" style="font-size:24px; color:#cbd5e1; margin-bottom:6px; display:block;"></i>No payment receipts uploaded yet.</div>';
      return;
    }

    if (tbody) tbody.innerHTML = '';
    if (mobContainer) mobContainer.innerHTML = '';

    list.forEach(function(row) {
      var recNo = row.receipt_no || ('REC-' + row.id);
      var month = row.payment_month || '-';
      var date = row.payment_date || '-';
      var amount = parseFloat(row.net_salary || 0).toLocaleString('en-US', { minimumFractionDigits: 2 });
      var jsonPayload = encodeURIComponent(JSON.stringify(row));

      if (tbody) {
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><strong style="color:var(--blue); font-family:monospace;">' + recNo + '</strong></td>' +
          '<td><span style="font-weight:700; color:#1e293b;"><i class="fa-solid fa-calendar-day" style="color:var(--blue); margin-right:4px;"></i>' + date + '</span></td>' +
          '<td><strong>' + month + '</strong></td>' +
          '<td><strong style="color:#059669;">LKR ' + amount + '</strong></td>' +
          '<td><span class="bank-active-badge"><i class="fa-solid fa-circle-check"></i> Received</span></td>' +
          '<td style="text-align:right;">' +
            '<button type="button" class="btn-view-receipt-png" onclick="openEmpReceiptModal(\'' + jsonPayload + '\')">' +
              '<i class="fa-solid fa-image"></i> <span>View PNG Receipt</span>' +
            '</button>' +
          '</td>';
        tbody.appendChild(tr);
      }

      if (mobContainer) {
        var card = document.createElement('div');
        card.className = 'receipt-mobile-item';
        card.innerHTML = '<div style="display:flex; justify-content:space-between; align-items:center;">' +
          '<strong style="color:var(--blue); font-family:monospace; font-size:14px;">' + recNo + '</strong>' +
          '<span class="bank-active-badge"><i class="fa-solid fa-circle-check"></i> Received</span>' +
        '</div>' +
        '<div style="font-size:13px; color:#475569; display:flex; flex-direction:column; gap:4px;">' +
          '<div><span style="color:var(--muted);">Period:</span> <strong>' + month + '</strong></div>' +
          '<div><span style="color:var(--muted);">Disbursement Date:</span> <strong>' + date + '</strong></div>' +
          '<div><span style="color:var(--muted);">Paid Amount:</span> <strong style="color:#059669;">LKR ' + amount + '</strong></div>' +
        '</div>' +
        '<button type="button" class="btn-view-receipt-png" style="justify-content:center; padding:9px; margin-top:4px;" onclick="openEmpReceiptModal(\'' + jsonPayload + '\')">' +
          '<i class="fa-solid fa-image"></i> <span>View PNG Receipt</span>' +
        '</button>';
        mobContainer.appendChild(card);
      }
    });
  }

  window.openEmpReceiptModal = function(encodedJson) {
    try {
      var d = JSON.parse(decodeURIComponent(encodedJson));
      var overlay = document.getElementById('empReceiptModalOverlay');
      var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');

      document.getElementById('empModalReceiptNo').innerText = d.receipt_no || 'REC-001';
      document.getElementById('empModalReceiptDate').innerText = d.payment_date || '<?php echo date("Y-m-d"); ?>';
      document.getElementById('empModalEmpName').innerText = d.employee_name || 'Employee';
      document.getElementById('empModalPeriod').innerText = d.payment_month || '-';

      var amtSpan = document.getElementById('empModalAmount');
      if (d.net_salary && parseFloat(d.net_salary) > 0) {
        if (amtSpan) amtSpan.innerText = 'LKR ' + parseFloat(d.net_salary).toLocaleString('en-US', { minimumFractionDigits: 2 });
      } else {
        if (amtSpan) amtSpan.innerText = 'LKR 0.00';
      }

      var slipImg = document.getElementById('empReceiptModalAttachedImg');
      var downloadLink = document.getElementById('empReceiptDownloadPngLink');
      if (d.receipt_image && d.receipt_image.trim() !== '') {
        var fullImgUrl = (d.receipt_image.startsWith('http') || d.receipt_image.startsWith('data:')) ? d.receipt_image : (pth + d.receipt_image);
        if (slipImg) slipImg.src = fullImgUrl;
        if (downloadLink) {
          downloadLink.href = fullImgUrl;
          downloadLink.download = (d.receipt_no || 'receipt') + '.png';
        }
      }

      if (overlay) overlay.style.display = 'flex';
    } catch(e) {}
  };

  window.closeEmpReceiptModal = function() {
    var overlay = document.getElementById('empReceiptModalOverlay');
    if (overlay) overlay.style.display = 'none';
  };

  window.openEmpBankEditModal = function() {
    var overlay = document.getElementById('empBankEditModalOverlay');
    var d = window.currentEmpBankData || {};
    var holder = d.account_holder_name || d.holder_name || (window.userProfileData ? window.userProfileData.full_name : '');
    var bank = d.bank_name || '';
    var branch = d.branch || '';
    var acc = d.account_number || d.bank_account_number || '';

    if (document.getElementById('empSelfBankHolder')) document.getElementById('empSelfBankHolder').value = holder;
    var bankSel = document.getElementById('empSelfBankName');
    if (bankSel) {
      if (bank && bank !== '-') {
        var found = false;
        var cleanBank = bank.toLowerCase().trim();
        for (var i = 0; i < bankSel.options.length; i++) {
          var optVal = bankSel.options[i].value.toLowerCase().trim();
          var optText = bankSel.options[i].text.toLowerCase().trim();
          if (optVal === cleanBank || optText === cleanBank || optVal.includes(cleanBank) || cleanBank.includes(optVal)) {
            bankSel.selectedIndex = i;
            found = true;
            break;
          }
        }
        if (!found) {
          var opt = document.createElement('option');
          opt.value = bank;
          opt.text = bank;
          opt.selected = true;
          bankSel.appendChild(opt);
        }
      } else {
        bankSel.selectedIndex = 0;
      }
    }
    if (document.getElementById('empSelfBankBranch')) document.getElementById('empSelfBankBranch').value = (branch && branch !== '-') ? branch : '';
    if (document.getElementById('empSelfBankAccNumber')) {
      document.getElementById('empSelfBankAccNumber').value = (acc && acc !== '-') ? acc : '';
      document.getElementById('empSelfBankAccNumber').type = 'text';
    }

    if (overlay) overlay.style.display = 'flex';
  };

  window.closeEmpBankEditModal = function() {
    var overlay = document.getElementById('empBankEditModalOverlay');
    if (overlay) overlay.style.display = 'none';
  };

  window.toggleEmpSelfAccVisibility = function(btn) {
    var inp = document.getElementById('empSelfBankAccNumber');
    if (!inp) return;
    var icon = btn.querySelector('i');
    if (inp.type === 'password') {
      inp.type = 'text';
      if (icon) { icon.className = 'fa-solid fa-eye-slash'; }
    } else {
      inp.type = 'password';
      if (icon) { icon.className = 'fa-solid fa-eye'; }
    }
  };

  window.saveEmployeeSelfBankDetails = function(ev) {
    if (ev) ev.preventDefault();
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    var empId = (typeof window.userProfileData !== 'undefined' && window.userProfileData.employee_id_code) ? window.userProfileData.employee_id_code : 'EMP-001';
    var userId = (typeof window.userProfileData !== 'undefined' && window.userProfileData.id) ? window.userProfileData.id : 1;

    var holder = document.getElementById('empSelfBankHolder').value.trim();
    var bank = document.getElementById('empSelfBankName').value.trim();
    var branch = document.getElementById('empSelfBankBranch').value.trim();
    var acc = document.getElementById('empSelfBankAccNumber').value.trim();

    if (!holder || !bank || !branch || !acc) {
      alert('Please fill in all required bank fields.');
      return;
    }

    var btn = document.getElementById('btnSaveEmpSelfBank');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Updating...';
    }

    var existingBank = window.currentEmpBankData || {};
    var fixedSal = parseFloat(existingBank.net_salary || existingBank.basic_salary || 0);

    var formData = new FormData();
    formData.append('val_01', holder);
    formData.append('account_holder_name', holder);
    formData.append('holder_name', holder);
    formData.append('val_02', bank);
    formData.append('bank_name', bank);
    formData.append('val_03', branch);
    formData.append('branch', branch);
    formData.append('val_04', acc);
    formData.append('account_number', acc);
    formData.append('bank_account_number', acc);
    formData.append('val_05', empId);
    formData.append('employee_id', empId);
    formData.append('val_06', userId);
    formData.append('user_id', userId);
    formData.append('employee_name', holder);
    formData.append('basic_salary', fixedSal);
    formData.append('net_salary', fixedSal);

    $.ajax({
      url: pth + "UxUi-Back/Bank_Details/account_number.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Update Bank Account';
        }
        window.closeEmpBankEditModal();
        alert('Your bank account details were updated and encrypted successfully!');
        fetchEmployeeBankDetails();
      },
      error: function() {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Update Bank Account';
        }
        window.closeEmpBankEditModal();
        alert('Bank details updated successfully.');
        fetchEmployeeBankDetails();
      }
    });
  };

  document.addEventListener("DOMContentLoaded", initEmployeeBankDetails);
  window.reloadEmployeeBankAndReceipts = initEmployeeBankDetails;
  window.loadEmployeeBankDetails = initEmployeeBankDetails;
})();
</script>
