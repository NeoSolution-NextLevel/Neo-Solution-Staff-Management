<style>
  /* =========================================================
     BANK DETAILS (RESPONSIVE FULL PAGE LAYOUT & AJAX BACKEND)
  ========================================================= */
  .bank-details-wrapper {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  .bank-page-head {
    margin-bottom: 20px;
  }

  .bank-page-head h1 {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy, #14204d);
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
  }

  .bank-page-head p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
  }

  .bank-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 28px 32px;
    box-sizing: border-box;
    width: 100%;
  }

  .bank-info-badge {
    background: #eff6ff;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 26px;
    width: 100%;
    box-sizing: border-box;
  }

  .bank-info-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #2563eb;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }

  .bank-info-icon svg {
    width: 22px;
    height: 22px;
  }

  .bank-info-text strong {
    display: block;
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 3px;
  }

  .bank-info-text span {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
  }

  /* Form Fields Grid: 2 Columns on Desktop, 1 Column on Mobile */
  .bank-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 24px;
    margin-bottom: 24px;
    width: 100%;
  }

  .bank-form-group {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .bank-form-group.full-width {
    grid-column: 1 / -1;
  }

  .bank-form-group label {
    display: block;
    font-size: 13.5px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }

  .bank-form-control {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 13px 16px;
    font-size: 14px;
    color: #1e293b;
    box-sizing: border-box;
    outline: none;
    transition: all 0.2s ease;
    font-family: inherit;
  }

  .bank-form-control:focus {
    background: #ffffff;
    border-color: #3b5bdb;
    box-shadow: 0 0 0 3px rgba(59, 91, 219, 0.12);
  }

  .bank-form-control::placeholder {
    color: #94a3b8;
    font-size: 13.5px;
  }

  select.bank-form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 16px;
    padding-right: 40px;
    cursor: pointer;
  }

  .bank-submit-btn {
    width: 100%;
    background: #14204d;
    color: #ffffff;
    font-weight: 700;
    font-size: 14.5px;
    border: none;
    border-radius: 10px;
    padding: 14px 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(20, 32, 77, 0.15);
  }

  .bank-submit-btn:hover {
    background: #1c2b63;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(20, 32, 77, 0.2);
  }

  .bank-submit-btn:active {
    transform: translateY(0);
  }

  .bank-security-notice {
    background: #fffbeb;
    border: 1px solid #fef3c7;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 20px;
    box-sizing: border-box;
    width: 100%;
  }

  .bank-security-notice svg,
  .bank-security-notice i {
    color: #d97706;
    font-size: 20px;
    flex-shrink: 0;
  }

  .bank-security-notice span {
    font-size: 13.5px;
    color: #92400e;
    font-weight: 500;
    line-height: 1.4;
  }

  /* Responsive Adjustments for Mobile / Tablet */
  @media (max-width: 900px) {
    .bank-card {
      padding: 20px 18px;
    }

    .bank-form-grid {
      grid-template-columns: 1fr;
      gap: 16px;
      margin-bottom: 20px;
    }

    .bank-info-badge {
      padding: 12px 14px;
      gap: 12px;
    }

    .bank-security-notice {
      padding: 14px 16px;
      gap: 10px;
    }
  }
</style>

<div id="Employee_user_dashboard_05_bank_details" class="w3-animate-opacity" style="display:none;">
  <main class="main">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_05" aria-label="Open menu" onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Bank Details</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function'){ Employee_user_dashboard_09_OPEN(); }" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>

        <div class="admin-pill" onclick="if(typeof Employee_user_dashboard_02_OPEN==='function'){ Employee_user_dashboard_02_OPEN(); }">
          <div class="avatar">AP</div>
          <span>Amal</span>
        </div>
      </div>
    </div>

    <div class="bank-details-wrapper w3-container" style="padding: 0;">

      <!-- Page Head -->
      <div class="bank-page-head">
        <p>Manage your salary payment bank information</p>
      </div>

      <!-- Main Form Card (Full Width) -->
      <div class="bank-card w3-card w3-round-xlarge">

        <!-- Top Information Badge Banner -->
        <div class="bank-info-badge w3-round-large">
          <div class="bank-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
          </div>
          <div class="bank-info-text">
            <strong>Bank Account Information</strong>
            <span id="bankAccountStatusText">Loading bank details...</span>
          </div>
        </div>

        <!-- Form Fields Grid -->
        <form id="empBankDetailsForm" onsubmit="event.preventDefault(); saveEmployeeBankDetails();">
          
          <div class="bank-form-grid">
            <div class="bank-form-group">
              <label for="bankAccountHolderName">Account Holder Name</label>
              <input type="text" id="bankAccountHolderName" class="bank-form-control w3-input w3-round" placeholder="Full name as on bank account" required>
            </div>

            <div class="bank-form-group">
              <label for="bankSelectName">Bank Name</label>
              <select id="bankSelectName" class="bank-form-control w3-select w3-round" required>
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
              <label for="bankBranchName">Branch</label>
              <input type="text" id="bankBranchName" class="bank-form-control w3-input w3-round" placeholder="e.g., Colombo 03" required>
            </div>

            <div class="bank-form-group">
              <label for="bankAccountNumber">Bank Account Number</label>
              <div style="position: relative; width: 100%;">
                <input type="password" id="bankAccountNumber" class="bank-form-control w3-input w3-round" placeholder="e.g., 0012345678901" style="padding-right: 44px; letter-spacing: 1px;" required autocomplete="off">
                <button type="button" id="toggleAccVisibilityBtn" onclick="toggleBankAccountVisibility()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; font-size: 16px; padding: 6px; display: flex; align-items: center; justify-content: center;" title="Show/Hide Account Number">
                  <i class="fa-solid fa-eye-slash" id="accEyeIcon"></i>
                </button>
              </div>
            </div>
          </div>

          <button type="submit" class="bank-submit-btn w3-button w3-round-large" id="saveBankDetailsBtn">
            <span>Save Bank Details</span>
          </button>
        </form>

      </div>

      <!-- Confidentiality / Security Notice Box -->
      <div class="bank-security-notice w3-round-large">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="16" x2="12" y2="12"/>
          <line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>
        <span>Your bank details are kept strictly confidential, securely masked, and used only for salary disbursement purposes.</span>
      </div>

    </div>

  </main>
</div>

<script>
  function populateBankFormFields(d) {
    if (!d) return;
    var holderInput = document.getElementById('bankAccountHolderName');
    var selectBank = document.getElementById('bankSelectName');
    var branchInput = document.getElementById('bankBranchName');
    var accInput = document.getElementById('bankAccountNumber');
    var icon = document.getElementById('accEyeIcon');
    var statusText = document.getElementById('bankAccountStatusText');

    var accNum = d.account_number || d.bank_account_number || '';
    var bankName = d.bank_name || '';

    // Update ONLY the Linked Banner badge at the top
    if (statusText) {
      if (accNum || bankName) {
        var last4 = accNum.length > 4 ? accNum.slice(-4) : accNum;
        var masked = last4 ? ('••••' + last4) : '••••';
        statusText.innerHTML = '<span style="color: #12b76a; font-weight: 700;">Account linked:</span> ' + (bankName || 'Bank') + ' (' + masked + ')';
      } else {
        statusText.innerText = 'No bank account added yet';
      }
    }

    // Keep all form input fields completely empty / clear (No pre-filling)
    if (holderInput) holderInput.value = '';
    if (selectBank) selectBank.selectedIndex = 0;
    if (branchInput) branchInput.value = '';
    if (accInput) {
      accInput.value = '';
      accInput.type = 'password';
      if (icon) icon.className = 'fa-solid fa-eye-slash';
    }
  }

  // Load Bank Details strictly from Database on page load
  document.addEventListener("DOMContentLoaded", function() {
    loadEmployeeBankDetails();
  });

  window.toggleBankAccountVisibility = function() {
    var inp = document.getElementById('bankAccountNumber');
    var icon = document.getElementById('accEyeIcon');
    if (!inp || !icon) return;
    if (inp.type === 'password') {
      inp.type = 'text';
      inp.style.letterSpacing = 'normal';
      icon.className = 'fa-solid fa-eye';
    } else {
      inp.type = 'password';
      inp.style.letterSpacing = '1px';
      icon.className = 'fa-solid fa-eye-slash';
    }
  };

  function loadEmployeeBankDetails() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    var empId = window.currentEmployeeId || "EMP-001";
    var userId = window.currentUserId || 1;

    $.ajax({
      url: pth + "UxUi-Back/Bank_Details/account_number.php",
      type: "GET",
      data: { employee_id: empId, user_id: userId },
      dataType: "json",
      success: function(response) {
        var statusText = document.getElementById('bankAccountStatusText');
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});

        if (resObj.status === "success" && resObj.data) {
          populateBankFormFields(resObj.data);
        } else {
          // No record in DB: keep clean empty form
          if (statusText) {
            statusText.innerText = 'No bank account added yet';
          }
        }
      },
      error: function() {
        $.ajax({
          url: pth + "View-List/Bank_details/Fetch_Bank_Details.php",
          type: "GET",
          data: { employee_id: empId, user_id: userId },
          dataType: "json",
          success: function(response2) {
            var statusText = document.getElementById('bankAccountStatusText');
            var resObj2 = Array.isArray(response2) ? (response2[0] || {}) : (response2 || {});
            if (resObj2.status === "success" && resObj2.data) {
              populateBankFormFields(resObj2.data);
            } else {
              if (statusText) statusText.innerText = 'No bank account added yet';
            }
          },
          error: function() {
            var statusText = document.getElementById('bankAccountStatusText');
            if (statusText) statusText.innerText = 'No bank account added yet';
          }
        });
      }
    });
  }

  function saveEmployeeBankDetails() {
    var holder = document.getElementById('bankAccountHolderName').value.trim();
    var bank = document.getElementById('bankSelectName').value;
    var branch = document.getElementById('bankBranchName').value.trim();
    var accNum = document.getElementById('bankAccountNumber').value.trim();
    var empId = window.currentEmployeeId || "EMP-001";
    var userId = window.currentUserId || 1;

    if (!holder || !bank || !branch || !accNum) {
      alert('Please fill in all bank details.');
      return;
    }

    var btn = document.getElementById('saveBankDetailsBtn');
    var originalText = btn ? btn.innerHTML : 'Save Bank Details';
    if (btn) {
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
      btn.disabled = true;
    }

    var payload = {
      account_holder_name: holder,
      holder_name: holder,
      bank_name: bank,
      branch: branch,
      account_number: accNum,
      bank_account_number: accNum,
      employee_id: empId,
      employee_name: window.currentEmployeeName || holder,
      user_id: userId
    };

    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../');
    $.ajax({
      url: pth + "UxUi-Back/Bank_Details/account_number.php",
      type: "POST",
      data: payload,
      dataType: "json",
      success: function(response) {
        if (btn) {
          btn.disabled = false;
        }
        var resObj = Array.isArray(response) ? (response[0] || {}) : (response || {});
        var isSuccess = (resObj.error === "0" || resObj.status === "success");

        if (isSuccess) {
          populateBankFormFields(payload);

          if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Bank Details Saved';
            btn.style.background = '#12b76a';
            setTimeout(function() {
              btn.innerHTML = originalText;
              btn.style.background = '#14204d';
            }, 2500);
          }
        } else {
          alert('Error: ' + (resObj.message || resObj.error || 'Could not save bank details.'));
          if (btn) {
            btn.innerHTML = originalText;
          }
        }
      },
      error: function() {
        // Fallback to View-List endpoint
        $.ajax({
          url: pth + "View-List/Bank_details/Save_Bank_Details.php",
          type: "POST",
          data: payload,
          dataType: "json",
          success: function(response2) {
            if (btn) {
              btn.disabled = false;
            }
            var resObj2 = Array.isArray(response2) ? (response2[0] || {}) : (response2 || {});
            var isSuccess2 = (resObj2.error === "0" || resObj2.status === "success");
            if (isSuccess2) {
              populateBankFormFields(payload);
              if (btn) {
                btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Bank Details Saved';
                btn.style.background = '#12b76a';
                setTimeout(function() {
                  btn.innerHTML = originalText;
                  btn.style.background = '#14204d';
                }, 2500);
              }
            } else {
              alert('Error: ' + (resObj2.message || resObj2.error || 'Could not save bank details.'));
              if (btn) btn.innerHTML = originalText;
            }
          },
          error: function(xhr2) {
            if (btn) {
              btn.disabled = false;
              btn.innerHTML = originalText;
            }
            alert('Failed to connect to the server. Please check your database connection.');
          }
        });
      }
    });
  }
</script>
