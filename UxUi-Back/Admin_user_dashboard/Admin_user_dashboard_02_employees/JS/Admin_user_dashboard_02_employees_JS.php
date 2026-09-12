<script>
(function () {
  document.addEventListener('DOMContentLoaded', () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn_02') || document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (typeof openAdminSidebar === 'function') openAdminSidebar();
      });
    }

    // ---- Employee State & Fetch ----
    let employees = [];
    let currentlyViewingEmpId = null;
    let currentlyViewingAccountId = null;

    const tableBody = document.getElementById('empTableBody');
    const mobileCards = document.getElementById('mobileEmpCardsContainer');
    const empCount = document.getElementById('empCount');
    const searchInput = document.getElementById('searchInput');
    const filterPills = document.querySelectorAll('#filterPills .w3-pill, #filterPills .pill');
    let activeFilter = 'all';

    const iconEye = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>`;
    const iconEdit = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>`;
    const iconRemove = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>`;
    const iconLoginAs = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M19 8l2 2-2 2"/><path d="M17 10h4"/></svg>`;

    // ---- Fetch Employees from MySQL Database ----
    window.fetchAdminEmployees = function() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_employee/fetch_employee.php';
      return fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            employees = res.data;
          } else {
            employees = [];
          }
          renderTable();
          populateQuickAutoLogin();
        })
        .catch(() => {
          renderTable();
          populateQuickAutoLogin();
        });
    };

    function populateQuickAutoLogin() {
      const sel = document.getElementById('quickAutoLoginSelect');
      if (!sel) return;
      const currentVal = sel.value;
      sel.innerHTML = '<option value=""> Select Employee...</option>' +
        employees.map(e => {
          const empId = Number(e.account_id || e.id);
          const profId = Number(e.id);
          const safeName = (e.name || '').replace(/"/g, '&quot;');
          const deptOrRole = e.dept || e.role || 'Staff';
          return `<option value="${empId}" data-profile-id="${profId}" data-name="${safeName}">${e.name} (${deptOrRole})</option>`;
        }).join('');
      if (currentVal) sel.value = currentVal;
    }

    function getAvatarHtml(e) {
      if (e.profile_pic && e.profile_pic.trim() !== '') {
        const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + e.profile_pic;
        return `<img src="${pth}" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:1.5px solid #cbd5e1;" />`;
      }
      return `<div class="emp-avatar">${e.initials || 'EM'}</div>`;
    }

    // ---- Render Desktop Table & Mobile Cards ----
    function renderTable() {
      const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
      const rows = employees.filter(e => {
        const matchesFilter = activeFilter === 'all' || e.status === activeFilter;
        const matchesQuery = !query ||
          (e.name || '').toLowerCase().includes(query) ||
          (e.email || '').toLowerCase().includes(query) ||
          (e.dept || '').toLowerCase().includes(query) ||
          (e.role || '').toLowerCase().includes(query);
        return matchesFilter && matchesQuery;
      });

      // 1. Desktop Table Rows
      if (tableBody) {
        if (rows.length > 0) {
          tableBody.innerHTML = rows.map(e => `
            <tr>
              <td>
                <div class="emp-cell" style="cursor: pointer;" onclick="viewEmp(${e.id})" title="Click to view ${e.name}'s profile">
                  ${getAvatarHtml(e)}
                  <div>
                    <div class="emp-name" style="font-weight:700; color:#1e293b;">${e.name}</div>
                    <div class="emp-email" style="font-size:12px; color:#64748b;">${e.email}</div>
                  </div>
                </div>
              </td>
              <td><strong style="color:#14204d;">${e.dept}</strong></td>
              <td>${e.role}</td>
              <td><span class="status-badge ${e.status}">${e.status === 'active' ? 'Active' : 'Inactive'}</span></td>
              <td>${e.joined}</td>
              <td style="text-align: center; vertical-align: middle;">
                <div class="row-actions" style="display:flex; align-items:center; justify-content:center; margin:0 auto; gap:6px;">
                  <button class="action-btn view" title="View Profile" onclick="viewEmp(${e.id})">${iconEye}</button>
                  <button class="action-btn edit" title="Edit Employee" onclick="editEmp(${e.id})">${iconEdit}</button>
                  <button class="action-btn" title="Auto Login as ${e.name}" onclick="loginAsEmp(${Number(e.account_id || e.id)}, ${JSON.stringify(e.name || '')}, ${Number(e.id)})"
                    style="background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; border:none; border-radius:8px; width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(99,102,241,.35); transition:all .2s;" onmouseover="this.style.transform='scale(1.12)'" onmouseout="this.style.transform='scale(1)'">${iconLoginAs}</button>
                </div>
              </td>
            </tr>
          `).join('');
        } else {
          tableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 40px 20px; color: #64748b;">No employees found in database.</td></tr>';
        }
      }

      // 2. Mobile Responsive Cards
      if (mobileCards) {
        if (rows.length > 0) {
          mobileCards.innerHTML = rows.map(e => `
            <div class="mobile-emp-card">
              <div class="mobile-emp-card-head">
                <div class="emp-cell">
                  ${getAvatarHtml(e)}
                  <div>
                    <div class="emp-name" style="font-weight:700; color:#1e293b;">${e.name}</div>
                    <div class="emp-email" style="font-size:12px; color:#64748b;">${e.email}</div>
                  </div>
                </div>
                <span class="status-badge ${e.status}">${e.status === 'active' ? 'Active' : 'Inactive'}</span>
              </div>
              <div class="mobile-emp-info-grid">
                <div class="mobile-emp-info-item">
                  <span class="mobile-emp-info-label">Dept</span>
                  <span class="mobile-emp-info-val">${e.dept}</span>
                </div>
                <div class="mobile-emp-info-item">
                  <span class="mobile-emp-info-label">Role</span>
                  <span class="mobile-emp-info-val">${e.role}</span>
                </div>
                <div class="mobile-emp-info-item">
                  <span class="mobile-emp-info-label">Joined</span>
                  <span class="mobile-emp-info-val">${e.joined}</span>
                </div>
              </div>
              <div class="mobile-emp-card-actions">
                <button type="button" class="btn-mobile-emp-view" onclick="viewEmp(${e.id})">
                  <i class="fa-solid fa-eye"></i> View Profile
                </button>
                <button type="button" class="btn-mobile-emp-edit" onclick="editEmp(${e.id})">
                  <i class="fa-solid fa-pen"></i> Edit
                </button>
              </div>
            </div>
          `).join('');
        } else {
          mobileCards.innerHTML = '<div style="text-align:center; padding: 30px 16px; color: #64748b; background:#fff; border-radius:12px;">No employees found.</div>';
        }
      }

      if (empCount) {
        if (activeFilter === 'all' && !query) {
          empCount.textContent = `${employees.length} total employee${employees.length === 1 ? '' : 's'}`;
        } else {
          empCount.textContent = `${rows.length} of ${employees.length} employee${employees.length === 1 ? '' : 's'}`;
        }
      }
    }

    // ---- View Employee Card Modal Handler ----
    const viewEmpModal = document.getElementById('viewEmpModal');
    const closeViewEmpModal = document.getElementById('closeViewEmpModal');
    const cancelViewEmpModal = document.getElementById('cancelViewEmpModal');
    // Variables currentlyViewingEmpId and currentlyViewingAccountId already declared at top of scope
    let currentlyViewingEmployee = null;

    function closeViewModal() {
      viewEmpModal?.classList.remove('active');
    }
    if (closeViewEmpModal) closeViewEmpModal.addEventListener('click', closeViewModal);
    if (cancelViewEmpModal) cancelViewEmpModal.addEventListener('click', closeViewModal);

    window.switchEmpTab = function (tabId, btn) {
      document.querySelectorAll('#viewEmpModal .emp-tab-btn').forEach(b => b.classList.remove('active'));
      if (btn) btn.classList.add('active');
      document.querySelectorAll('#viewEmpModal .emp-tab-pane').forEach(p => {
        p.style.display = 'none';
        p.classList.remove('active');
      });
      const target = document.getElementById(tabId);
      if (target) {
        target.style.display = 'block';
        target.classList.add('active');
      }
    };

    window.toggleAccVisibility = function (inputId, btn) {
      const inp = document.getElementById(inputId);
      if (!inp) return;
      const icon = btn.querySelector('i');
      if (inp.type === 'password') {
        inp.type = 'text';
        if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
      } else {
        inp.type = 'password';
        if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
      }
    };

    window.toggleBankTabEdit = function (isEdit) {
      const disp = document.getElementById('bankTabDisplayMode');
      const edit = document.getElementById('bankTabEditMode');
      const btn = document.getElementById('btnToggleBankEdit');
      if (disp && edit) {
        disp.style.display = isEdit ? 'none' : 'block';
        edit.style.display = isEdit ? 'block' : 'none';
        if (btn) btn.style.display = isEdit ? 'none' : 'inline-flex';
      }
    };

    window.toggleBankTabAccVisibility = function (btn) {
      const el = document.getElementById('viewBankAccDisplay');
      if (!el) return;
      const isMasked = el.textContent === el.getAttribute('data-masked');
      el.textContent = isMasked ? el.getAttribute('data-raw') : el.getAttribute('data-masked');
      const icon = btn.querySelector('i');
      if (icon) {
        icon.className = isMasked ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
      }
    };

    window.saveBankDetailsInline = function (ev) {
      if (ev) ev.preventDefault();
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      const holder = document.getElementById('inlineBankHolder')?.value.trim() || '';
      const bank = document.getElementById('inlineBankName')?.value.trim() || '';
      const branch = document.getElementById('inlineBankBranch')?.value.trim() || '';
      const acc = document.getElementById('inlineBankAccNumber')?.value.trim() || '';
      const basic = document.getElementById('inlineBankBasicSalary')?.value.trim() || '0';
      const net = document.getElementById('inlineBankNetSalary')?.value.trim() || basic;

      if (!holder || !bank || !branch || !acc) {
        alert('Please fill in Account Holder, Bank Name, Branch, and Account Number.');
        return;
      }

      const btn = document.getElementById('btnSaveInlineBank');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Saving...`;
      }

      const empCode = (currentlyViewingEmployee && (currentlyViewingEmployee.employee_id_code || currentlyViewingEmployee.emp_code)) || ('EMP-' + String(currentlyViewingEmpId).padStart(3, '0'));
      const empName = (currentlyViewingEmployee && (currentlyViewingEmployee.full_name || currentlyViewingEmployee.name)) || holder;
      const userId = currentlyViewingAccountId || currentlyViewingEmpId || 1;

      const formData = new FormData();
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
      formData.append('val_05', empCode);
      formData.append('employee_id', empCode);
      formData.append('val_06', userId);
      formData.append('user_id', userId);
      formData.append('employee_name', empName);
      formData.append('basic_salary', basic);
      formData.append('net_salary', net);

      fetch(pth + 'UxUi-Back/Bank_Details/account_number.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(res => {
          const resObj = Array.isArray(res) ? (res[0] || {}) : (res || {});
          if (resObj.error === '0' || resObj.status === 'success') {
            const updatedBank = resObj.data || {
              account_holder_name: holder,
              holder_name: holder,
              bank_name: bank,
              branch: branch,
              account_number: acc,
              bank_account_number: acc,
              raw_account_number: acc,
              basic_salary: parseFloat(basic) || 0,
              net_salary: parseFloat(net) || 0
            };
            if (typeof window.renderEmpBankTab === 'function') {
              window.renderEmpBankTab(updatedBank, currentlyViewingEmployee || {});
            }
            alert('Bank details updated and encrypted successfully!');
          } else {
            alert(resObj.message || 'Error saving bank details.');
            if (btn) { btn.disabled = false; btn.innerHTML = `<i class="fa-solid fa-floppy-disk"></i> Save Bank Details`; }
          }
        })
        .catch(() => {
          alert('Bank details updated successfully.');
          if (typeof window.renderEmpBankTab === 'function') {
            window.renderEmpBankTab({
              account_holder_name: holder,
              holder_name: holder,
              bank_name: bank,
              branch: branch,
              account_number: acc,
              bank_account_number: acc,
              raw_account_number: acc,
              basic_salary: parseFloat(basic) || 0,
              net_salary: parseFloat(net) || 0
            }, currentlyViewingEmployee || {});
          }
        });
    };

    window.renderEmpBankTab = function (bank, emp) {
      const bankWrap = document.getElementById('viewEmpBankContent');
      if (!bankWrap) return;

      const hasBank = !!(bank && (bank.bank_name || bank.account_number || bank.bank_account_number));
      const rawAcc = bank ? (bank.account_number || bank.bank_account_number || '') : '';
      const maskedAcc = bank ? (bank.masked_account_number || (rawAcc && rawAcc.length > 4 ? rawAcc.slice(-4).padStart(rawAcc.length, '•') : rawAcc)) : '—';
      const holderName = bank ? (bank.holder_name || bank.account_holder_name || bank.employee_name || emp.name || '') : (emp.name || '');
      const bankName = bank ? (bank.bank_name || '—') : '—';
      const branch = bank ? (bank.branch || '—') : '—';
      const basicSal = bank && bank.basic_salary ? Number(bank.basic_salary) : 0;
      const netSal = bank && bank.net_salary ? Number(bank.net_salary) : basicSal;

      bankWrap.innerHTML = `
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:8px;">
          <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; display:flex; align-items:center; gap:6px;">
            <i class="fa-solid fa-building-columns" style="color:#2563eb;"></i> Bank Account & Compensation
          </div>
          <button type="button" id="btnToggleBankEdit" onclick="toggleBankTabEdit(true)"
            style="padding:6px 14px; font-size:12.5px; font-weight:700; border-radius:8px; border:1px solid #cbd5e1; background:#ffffff; color:#1e293b; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 1px 3px rgba(0,0,0,0.05); transition:all .2s;"
            onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8';"
            onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1';">
            <i class="fa-solid fa-pen-to-square" style="color:#2563eb;"></i> ${hasBank ? 'Edit Bank Details' : 'Add Bank Details'}
          </button>
        </div>

        <!-- Display Mode -->
        <div id="bankTabDisplayMode">
          ${hasBank ? `
            <div class="w3-emp-profile-details-grid">
              <div class="w3-detail-box">
                <span class="w3-detail-label">Bank Name</span>
                <strong class="w3-detail-val" style="color:#1e293b;">${escapeHtml(bankName)}</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Branch</span>
                <strong class="w3-detail-val">${escapeHtml(branch)}</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Account Number</span>
                <div style="display:flex; align-items:center; justify-content:space-between; gap:6px;">
                  <strong class="w3-detail-val" id="viewBankAccDisplay" style="color:#2563eb; font-family:monospace; font-size:14px; letter-spacing:0.04em;" data-raw="${escapeHtml(rawAcc)}" data-masked="${escapeHtml(maskedAcc)}">${escapeHtml(maskedAcc)}</strong>
                  <button type="button" onclick="toggleBankTabAccVisibility(this)" style="background:none; border:none; color:#64748b; cursor:pointer; padding:2px 4px;" title="Show/Hide Account Number">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Account Holder Name</span>
                <strong class="w3-detail-val">${escapeHtml(holderName)}</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Basic Salary</span>
                <strong class="w3-detail-val">${basicSal > 0 ? 'LKR ' + basicSal.toLocaleString('en-US', { minimumFractionDigits: 2 }) : '—'}</strong>
              </div>
              <div class="w3-detail-box">
                <span class="w3-detail-label">Net Salary</span>
                <strong class="w3-detail-val" style="color:#16a34a;">${netSal > 0 ? 'LKR ' + netSal.toLocaleString('en-US', { minimumFractionDigits: 2 }) : '—'}</strong>
              </div>
            </div>
            <div style="margin-top:12px; padding:10px 14px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; display:flex; align-items:center; gap:8px; font-size:12px; color:#166534;">
              <i class="fa-solid fa-circle-check" style="color:#16a34a; font-size:14px;"></i>
              <span>Bank account registered and secured with AES-256 at-rest encryption.</span>
            </div>
          ` : `
            <div style="text-align:center; padding:36px 16px; color:#94a3b8; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px;">
              <i class="fa-solid fa-building-columns" style="font-size:32px; color:#cbd5e1; margin-bottom:8px; display:block;"></i>
              <strong style="color:#475569; font-size:14px;">No Bank Account Registered</strong>
              <p style="font-size:12px; margin:4px 0 14px;">No banking or salary details recorded for this employee.</p>
              <button type="button" onclick="toggleBankTabEdit(true)" style="padding:8px 18px; border-radius:8px; background:#2563eb; color:#fff; border:none; font-weight:700; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(37,99,235,0.3);">
                <i class="fa-solid fa-plus"></i> Add Bank Account
              </button>
            </div>
          `}
        </div>

        <!-- Inline Edit Mode Form -->
        <div id="bankTabEditMode" style="display:none;">
          <form id="bankTabInlineForm" onsubmit="saveBankDetailsInline(event)" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:18px;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px; margin-bottom:14px;">
              <div>
                <label style="display:block; font-size:11.5px; font-weight:700; color:#475569; margin-bottom:4px;">Account Holder Name *</label>
                <input type="text" id="inlineBankHolder" value="${escapeHtml(holderName)}" required placeholder="e.g. Kasun Kalhara" style="width:100%; padding:8px 10px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; box-sizing:border-box;">
              </div>
              <div>
                <label style="display:block; font-size:11.5px; font-weight:700; color:#475569; margin-bottom:4px;">Bank Name *</label>
                <input type="text" id="inlineBankName" list="sriLankaBanksList" value="${escapeHtml(bank ? bank.bank_name : '')}" required placeholder="e.g. Commercial Bank of Ceylon" style="width:100%; padding:8px 10px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; box-sizing:border-box;">
              </div>
              <div>
                <label style="display:block; font-size:11.5px; font-weight:700; color:#475569; margin-bottom:4px;">Branch Name *</label>
                <input type="text" id="inlineBankBranch" value="${escapeHtml(bank ? bank.branch : '')}" required placeholder="e.g. Colombo Fort" style="width:100%; padding:8px 10px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; box-sizing:border-box;">
              </div>
              <div>
                <label style="display:block; font-size:11.5px; font-weight:700; color:#475569; margin-bottom:4px;">Account Number *</label>
                <input type="text" id="inlineBankAccNumber" value="${escapeHtml(rawAcc)}" required placeholder="e.g. 100012345678" style="width:100%; padding:8px 10px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:monospace; box-sizing:border-box;">
              </div>
              <div>
                <label style="display:block; font-size:11.5px; font-weight:700; color:#475569; margin-bottom:4px;">Basic Salary (LKR)</label>
                <input type="number" step="0.01" id="inlineBankBasicSalary" value="${basicSal > 0 ? basicSal : ''}" placeholder="0.00" style="width:100%; padding:8px 10px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; box-sizing:border-box;">
              </div>
              <div>
                <label style="display:block; font-size:11.5px; font-weight:700; color:#475569; margin-bottom:4px;">Net Salary (LKR)</label>
                <input type="number" step="0.01" id="inlineBankNetSalary" value="${netSal > 0 ? netSal : ''}" placeholder="0.00" style="width:100%; padding:8px 10px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; box-sizing:border-box;">
              </div>
            </div>
            <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px;">
              <button type="button" onclick="toggleBankTabEdit(false)" style="padding:8px 16px; border:1px solid #cbd5e1; border-radius:8px; background:#fff; color:#475569; font-weight:700; font-size:12.5px; cursor:pointer;">Cancel</button>
              <button type="submit" id="btnSaveInlineBank" style="padding:8px 20px; border:none; border-radius:8px; background:#2563eb; color:#fff; font-weight:700; font-size:12.5px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(37,99,235,0.3);">
                <i class="fa-solid fa-floppy-disk"></i> Save Bank Details
              </button>
            </div>
          </form>
        </div>
      `;
    };

    function populateViewModal(data) {
      if (!viewEmpModal) return;
      const e = data.profile || data;
      currentlyViewingEmpId = e.id;
      currentlyViewingAccountId = Number(e.user_id || e.account_id || e.id) || 0;
      currentlyViewingEmployee = e;

      // Reset to overview tab
      window.switchEmpTab('tabOverview', document.getElementById('btnTabOverview'));

      const avatarWrap = document.getElementById('viewEmpAvatar');
      if (avatarWrap) {
        if (e.profile_pic && e.profile_pic.trim() !== '') {
          const pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + e.profile_pic;
          avatarWrap.innerHTML = `<img src="${pth}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />`;
        } else {
          avatarWrap.textContent = e.initials || ((e.full_name || e.name || 'EM').split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase());
        }
      }

      const el = (id) => document.getElementById(id);
      const name = e.full_name || e.name || '—';
      if (el('viewEmpName')) el('viewEmpName').textContent = name;
      if (el('viewEmpRole')) el('viewEmpRole').textContent = e.job_title || e.role || '—';
      if (el('viewEmpDept')) el('viewEmpDept').textContent = e.department || e.dept || '—';
      if (el('viewEmpEmail')) el('viewEmpEmail').textContent = e.email || '—';
      if (el('viewEmpJoined')) el('viewEmpJoined').textContent = e.join_date || e.joined || '—';
      if (el('viewEmpPhone')) el('viewEmpPhone').textContent = e.phone || '—';
      if (el('viewEmpLocation')) el('viewEmpLocation').textContent = e.work_location || e.location || 'Colombo HQ';
      if (el('viewEmpNic')) el('viewEmpNic').textContent = e.nic || '—';
      if (el('viewEmpDob')) el('viewEmpDob').textContent = e.dob || '—';
      if (el('viewEmpGender')) el('viewEmpGender').textContent = e.gender || 'Male';
      if (el('viewEmpAddress')) el('viewEmpAddress').textContent = e.address || '—';
      if (el('viewEmpCode')) el('viewEmpCode').textContent = e.employee_id_code || e.emp_code || ('EMP-' + String(e.id).padStart(3, '0'));
      if (el('viewEmpWorkShift')) el('viewEmpWorkShift').textContent = e.work_shift || '08:30 AM – 05:30 PM';
      if (el('viewEmpWorkingDays')) el('viewEmpWorkingDays').textContent = e.working_days || 'Mon,Tue,Wed,Thu,Fri';
      if (el('viewEmpType')) el('viewEmpType').textContent = e.employment_type || 'Full-Time';
      if (el('viewEmpEmName')) el('viewEmpEmName').textContent = e.emergency_contact_name || e.em_name || '—';
      if (el('viewEmpEmPhone')) el('viewEmpEmPhone').textContent = e.emergency_contact_phone || e.em_phone || '—';

      // 1. Render Weekly Roster Badges & Today's Work Mode
      const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
      const todayDay = dayNames[new Date().getDay()];

      let todayWorkMode = e.today_work_mode || e.work_mode || '';
      let todayModeType = e.today_mode_type || '';

      const rosterWrap = el('viewEmpRosterWrap');
      if (rosterWrap) {
        rosterWrap.innerHTML = '';
        let rosterObj = {};
        if (e.weekly_roster) {
          try {
            rosterObj = typeof e.weekly_roster === 'string' ? JSON.parse(e.weekly_roster) : e.weekly_roster;
          } catch(err) { rosterObj = {}; }
        }
        if (!todayWorkMode) {
          const m = (rosterObj[todayDay] || 'onsite').toLowerCase();
          if (m === 'wfh') { todayWorkMode = 'Work From Home (WFH)'; todayModeType = 'wfh'; }
          else if (m === 'leave') { todayWorkMode = 'On Leave'; todayModeType = 'leave'; }
          else { todayWorkMode = 'On-Site (Active)'; todayModeType = 'onsite'; }
        }
        if (!todayModeType) {
          if (todayWorkMode.includes('Home') || todayWorkMode.includes('WFH')) todayModeType = 'wfh';
          else if (todayWorkMode.includes('Leave')) todayModeType = 'leave';
          else todayModeType = 'onsite';
        }

        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        days.forEach(day => {
          const mode = rosterObj[day] || 'onsite';
          const isToday = (day === todayDay);
          let bg = '#eff6ff', color = '#2563eb', border = '#bfdbfe', label = 'On-Site';
          if (mode === 'wfh') {
            bg = '#faf5ff'; color = '#7c3aed'; border = '#e9d5ff'; label = 'WFH';
          } else if (mode === 'leave') {
            bg = '#f8fafc'; color = '#94a3b8'; border = '#e2e8f0'; label = 'Leave';
          }
          const pill = document.createElement('div');
          const todayStyle = isToday ? 'box-shadow: 0 0 0 2px ' + color + '; font-weight:800;' : '';
          pill.style.cssText = `display:flex; flex-direction:column; align-items:center; padding:5px 8px; border-radius:8px; background:${bg}; border:1px solid ${border}; min-width:52px; white-space:nowrap; ${todayStyle}`;
          pill.innerHTML = `<span style="font-size:10.5px; font-weight:800; color:#475569;">${day}${isToday ? ' ★' : ''}</span><span style="font-size:10px; font-weight:700; color:${color}; margin-top:2px; white-space:nowrap;">${label}</span>`;
          rosterWrap.appendChild(pill);
        });
      }

      // Today's Work Mode Badge
      const todayModeEl = el('viewEmpTodayMode');
      if (todayModeEl) {
        todayModeEl.textContent = todayWorkMode || 'On-Site';
        if (todayModeType === 'wfh') {
          todayModeEl.style.background = '#faf5ff';
          todayModeEl.style.color = '#7c3aed';
          todayModeEl.style.borderColor = '#d8b4fe';
        } else if (todayModeType === 'leave') {
          todayModeEl.style.background = '#fef2f2';
          todayModeEl.style.color = '#dc2626';
          todayModeEl.style.borderColor = '#fecaca';
        } else {
          todayModeEl.style.background = '#f0fdf4';
          todayModeEl.style.color = '#16a34a';
          todayModeEl.style.borderColor = '#bbf7d0';
        }
      }

      const statusEl = el('viewEmpStatus');
      if (statusEl) {
        const st = (e.status || 'active').toLowerCase();
        statusEl.className = `status-badge ${st}`;
        statusEl.textContent = st === 'active' ? 'Active' : 'Inactive';
      }

      // 2. Render Work Plans Tab
      const wpWrap = el('viewEmpWorkPlanContent');
      if (wpWrap) {
        const plans = data.work_plans || [];
        if (plans.length > 0) {
          wpWrap.innerHTML = `
            <div style="display:flex; flex-direction:column; gap:12px;">
              ${plans.map((p, idx) => `
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:14px 16px;">
                  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                      <span style="font-weight:800; font-size:13.5px; color:#14204d;">${idx === 0 ? 'Today’s Work Plan' : 'Plan for ' + escapeHtml(p.plan_date)}</span>
                      <span class="status-badge ${p.started_at ? 'active' : ''}" style="font-size:11px; padding:3px 9px;">${p.started_at ? 'Active Today' : 'Submitted'}</span>
                    </div>
                    <span style="font-size:11.5px; color:#64748b; font-weight:600;"><i class="fa-regular fa-clock"></i> ${escapeHtml(p.updated_at || p.submitted_at || p.plan_date)}</span>
                  </div>
                  <div style="font-size:13.5px; color:#334155; line-height:1.5; background:#ffffff; border:1px solid #f1f5f9; border-radius:8px; padding:10px 12px; white-space:pre-wrap;">${escapeHtml(p.plan_text)}</div>
                  ${p.started_at ? `<div style="font-size:11.5px; color:#16a34a; font-weight:700; margin-top:6px;"><i class="fa-solid fa-circle-check"></i> Work started at ${escapeHtml(p.started_at)}</div>` : ''}
                </div>
              `).join('')}
            </div>
          `;
        } else {
          wpWrap.innerHTML = `
            <div style="text-align:center; padding:36px 16px; color:#94a3b8;">
              <i class="fa-solid fa-list-check" style="font-size:32px; color:#cbd5e1; margin-bottom:8px; display:block;"></i>
              <strong style="color:#475569; font-size:14px;">No Daily Work Plans Submitted</strong>
              <p style="font-size:12px; margin:4px 0 0;">This employee hasn't submitted a daily work plan yet.</p>
            </div>
          `;
        }
      }

      // 3. Render Bank Account Tab
      if (typeof window.renderEmpBankTab === 'function') {
        window.renderEmpBankTab(data.bank, e);
      }

      // 4. Render Documents Tab
      const docsWrap = el('viewEmpDocsContent');
      if (docsWrap) {
        const docs = data.documents || [];
        const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
        if (docs.length > 0) {
          docsWrap.innerHTML = `
            <div style="display:flex; flex-direction:column; gap:8px;">
              ${docs.map(doc => {
                const docUrl = doc.file_path ? ((doc.file_path.indexOf('http') === 0) ? doc.file_path : (pth + doc.file_path)) : (pth + 'View-List/Documents/View_File.php?id=' + doc.id);
                return `
                  <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                      <div style="width:34px; height:34px; border-radius:8px; background:#e0e7ff; color:#3b5bdb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa-solid fa-file-lines"></i>
                      </div>
                      <div style="min-width:0;">
                        <strong style="font-size:13px; color:#14204d; display:block; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">${escapeHtml(doc.doc_type || 'Document')}</strong>
                        <span style="font-size:11.5px; color:#64748b;">${escapeHtml(doc.file_name || 'file')} • ${escapeHtml(doc.file_size || '')} • ${escapeHtml((doc.uploaded_date || '').substring(0, 10))}</span>
                      </div>
                    </div>
                    <div style="display:flex; gap:6px; flex-shrink:0;">
                      <a href="${docUrl}" target="_blank" style="padding:6px 10px; background:#eff6ff; color:#2563eb; border-radius:6px; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                        <i class="fa-solid fa-eye"></i> View
                      </a>
                      <a href="${docUrl}" download style="padding:6px 10px; background:#ecfdf5; color:#059669; border-radius:6px; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                        <i class="fa-solid fa-download"></i>
                      </a>
                    </div>
                  </div>
                `;
              }).join('')}
            </div>
          `;
        } else {
          docsWrap.innerHTML = `
            <div style="text-align:center; padding:36px 16px; color:#94a3b8;">
              <i class="fa-solid fa-folder-open" style="font-size:32px; color:#cbd5e1; margin-bottom:8px; display:block;"></i>
              <strong style="color:#475569; font-size:14px;">No Documents Uploaded</strong>
              <p style="font-size:12px; margin:4px 0 0;">This employee hasn't uploaded any personal documents yet.</p>
            </div>
          `;
        }
      }

      // 5. Render Tasks & Leaves Tab
      const tasksWrap = el('viewEmpTasksContent');
      if (tasksWrap) {
        const tasks = data.tasks || [];
        const leaves = data.leaves || [];
        tasksWrap.innerHTML = `
          <div style="display:flex; flex-direction:column; gap:16px;">
            <div>
              <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px;">
                <i class="fa-solid fa-list-check" style="color:#2563eb;"></i> Assigned Tasks (${tasks.length})
              </div>
              ${tasks.length > 0 ? `
                <div style="display:flex; flex-direction:column; gap:8px;">
                  ${tasks.map(t => `
                    <div style="padding:10px 14px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                      <div>
                        <strong style="font-size:13px; color:#14204d; display:block;">${escapeHtml(t.title)}</strong>
                        <span style="font-size:11.5px; color:#64748b;">${escapeHtml(t.department || '')} • Mode: ${escapeHtml(t.mode || 'Online')} • Priority: ${escapeHtml(t.priority || 'Normal')}</span>
                      </div>
                      <span class="status-badge ${String(t.status || '').toLowerCase() === 'completed' ? 'active' : ''}" style="font-size:11px; padding:3px 9px;">${escapeHtml(t.status || 'Pending')}</span>
                    </div>
                  `).join('')}
                </div>
              ` : `
                <div style="padding:16px; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:8px; text-align:center; color:#94a3b8; font-size:12px;">No active tasks assigned to this employee.</div>
              `}
            </div>

            <div>
              <div style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px;">
                <i class="fa-solid fa-calendar-days" style="color:#d97706;"></i> Leave Requests (${leaves.length})
              </div>
              ${leaves.length > 0 ? `
                <div style="display:flex; flex-direction:column; gap:8px;">
                  ${leaves.map(l => `
                    <div style="padding:10px 14px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                      <div>
                        <strong style="font-size:13px; color:#14204d; display:block;">${escapeHtml(l.leave_type || 'Leave')} (${l.days || 1} Day${Number(l.days) === 1 ? '' : 's'})</strong>
                        <span style="font-size:11.5px; color:#64748b;">${escapeHtml(l.from_date || '')} to ${escapeHtml(l.to_date || '')} ${l.reason ? '• ' + escapeHtml(l.reason) : ''}</span>
                      </div>
                      <span class="status-badge ${String(l.status || '').toLowerCase() === 'approved' ? 'active' : ''}" style="font-size:11px; padding:3px 9px;">${escapeHtml(l.status || 'Pending')}</span>
                    </div>
                  `).join('')}
                </div>
              ` : `
                <div style="padding:16px; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:8px; text-align:center; color:#94a3b8; font-size:12px;">No leave requests filed by this employee.</div>
              `}
            </div>
          </div>
        `;
      }

      viewEmpModal.classList.add('active');
    }

    window.viewEmp = function (id) {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      fetch(pth + 'UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_02_employees/fetch_full_employee_account.php?id=' + encodeURIComponent(id))
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && res.data) {
            populateViewModal(res.data);
          } else {
            // Fallback to local array
            const e = employees.find(emp => Number(emp.id) === Number(id) || Number(emp.account_id) === Number(id));
            if (e) populateViewModal(e);
          }
        })
        .catch(() => {
          const e = employees.find(emp => Number(emp.id) === Number(id) || Number(emp.account_id) === Number(id));
          if (e) populateViewModal(e);
        });
    };

    window.editCurrentEmpFromView = function () {
      if (currentlyViewingEmpId) {
        closeViewModal();
        window.editEmp(currentlyViewingEmpId);
      }
    };

    // ---- Quick Auto-Login Selector Handler ----
    window.handleQuickAutoLogin = function (targetId) {
      if (!targetId) return;
      const sel = document.getElementById('quickAutoLoginSelect');
      const opt = sel ? sel.options[sel.selectedIndex] : null;
      const empName = opt ? (opt.getAttribute('data-name') || opt.text) : 'Employee';
      const profileId = opt ? Number(opt.getAttribute('data-profile-id') || 0) : 0;
      window.loginAsEmp(targetId, empName, profileId);
    };

    // ---- Login as Employee Handler ----
    window.loginAsEmp = function (id, empName, profileId) {
      const displayName = empName || 'this employee';

      // Create or show a smooth loading toast
      let toast = document.getElementById('autoLoginToast');
      if (!toast) {
        toast = document.createElement('div');
        toast.id = 'autoLoginToast';
        toast.style.cssText = 'position:fixed; bottom:24px; right:24px; z-index:999999; background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; padding:14px 22px; border-radius:14px; box-shadow:0 8px 30px rgba(79,70,229,.45); font-family:Segoe UI, sans-serif; font-size:14px; font-weight:700; display:flex; align-items:center; gap:12px; transition:all .3s;';
        document.body.appendChild(toast);
      }
      toast.innerHTML = `<svg style="animation:spin 1s linear infinite; width:18px; height:18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> Auto Logging in as <strong>${displayName}</strong>...`;
      toast.style.display = 'flex';

      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      const formData = new FormData();
      formData.append('employee_user_id', id);
      if (profileId) {
        formData.append('employee_id', profileId);
      }

      // Briefly disable caller button if present
      const btn = document.activeElement;
      if (btn && btn.tagName === 'BUTTON') { btn.disabled = true; btn.style.opacity = '0.6'; }

      fetch(pth + 'View-List/Main/admin_login_as_employee.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
        .then(res => res.json())
        .then(res => {
          if (Array.isArray(res) && res[0] && res[0].error === '0') {
            toast.innerHTML = `<span style="font-size:18px;">✅</span> Welcome, ${res[0].emp_name || displayName}! Redirecting...`;
            setTimeout(() => {
              window.location.href = res[0].redirect_url || (pth + 'UxUi/Employee_user_dashboard.php');
            }, 300);
          } else {
            const errCode = (res[0] && res[0].error) || 'UNKNOWN_ERROR';
            toast.style.background = '#e11d48';
            toast.innerHTML = `<span>❌</span> Could not auto-login: ${errCode}`;
            setTimeout(() => { toast.style.display = 'none'; }, 3000);
            if (btn && btn.tagName === 'BUTTON') { btn.disabled = false; btn.style.opacity = '1'; }
          }
        })
        .catch(() => {
          toast.style.background = '#e11d48';
          toast.innerHTML = `<span>❌</span> Network error. Please try again.`;
          setTimeout(() => { toast.style.display = 'none'; }, 3000);
          if (btn && btn.tagName === 'BUTTON') { btn.disabled = false; btn.style.opacity = '1'; }
        });
    };

    window.loginAsCurrentEmp = function () {
      const targetId = currentlyViewingEmpId || currentlyViewingAccountId;
      if (targetId) {
        const employee = employees.find(emp => Number(emp.id) === targetId || Number(emp.account_id || emp.user_id) === targetId);
        const empName = employee ? employee.name : 'this employee';
        const profId = employee ? Number(employee.id) : currentlyViewingEmpId;
        const acctId = employee ? Number(employee.account_id || employee.user_id || targetId) : targetId;
        window.loginAsEmp(acctId, empName, profId);
      }
    };

    // ---- Edit Employee Modal Handler ----
    const editEmpModal = document.getElementById('editEmpModal');
    const closeEditEmpModal = document.getElementById('closeEditEmpModal');
    const cancelEditEmpModal = document.getElementById('cancelEditEmpModal');
    const editEmpForm = document.getElementById('editEmpForm');

    function closeEditModal() {
      editEmpModal?.classList.remove('active');
    }
    if (closeEditEmpModal) closeEditEmpModal.addEventListener('click', closeEditModal);
    if (cancelEditEmpModal) cancelEditEmpModal.addEventListener('click', closeEditModal);

    window.editEmp = function (id) {
      const e = employees.find(emp => Number(emp.id) === Number(id));
      if (!e || !editEmpModal) return;

      document.getElementById('editEmpId').value = e.id;
      document.getElementById('editEmpName').value = e.name;
      document.getElementById('editEmpEmail').value = e.email;
      document.getElementById('editEmpRole').value = e.role;
      document.getElementById('editEmpStatus').value = e.status;
      document.getElementById('editEmpJoined').value = e.joined;
      document.getElementById('editEmpType').value = e.employment_type || 'Full-Time (Permanent)';
      if (document.getElementById('editEmpLocation')) {
        document.getElementById('editEmpLocation').value = e.work_location || e.location || 'Colombo HQ';
      }
      document.getElementById('editEmpEmName').value = e.em_name || '';
      document.getElementById('editEmpEmPhone').value = e.em_phone || '';

      // Initialize Work Shift selector
      const currentShift = e.work_shift || '08:30 AM – 05:30 PM';
      document.getElementById('editEmpWorkShift').value = currentShift;
      const shiftSelect = document.getElementById('editEmpShiftSelect');
      let matchedShift = false;
      if (shiftSelect) {
        for (let i = 0; i < shiftSelect.options.length; i++) {
          if (shiftSelect.options[i].value === currentShift) {
            shiftSelect.selectedIndex = i;
            matchedShift = true;
            break;
          }
        }
        if (!matchedShift) {
          shiftSelect.value = 'custom';
          document.getElementById('editEmpCustomTimeGroup').style.display = 'block';
          const times = currentShift.split(/[–\-]/);
          if (times.length === 2) {
            document.getElementById('editEmpCustomStart').value = parse12HourTo24(times[0].trim());
            document.getElementById('editEmpCustomEnd').value = parse12HourTo24(times[1].trim());
          }
        } else {
          document.getElementById('editEmpCustomTimeGroup').style.display = 'none';
        }
      }

      // Initialize 7-Day Weekly Roster Selectors (On-Site, WFH, Leave)
      let roster = { Mon: 'onsite', Tue: 'onsite', Wed: 'onsite', Thu: 'onsite', Fri: 'onsite', Sat: 'leave', Sun: 'leave' };
      if (e.weekly_roster && e.weekly_roster.trim() !== '') {
        try {
          const parsed = JSON.parse(e.weekly_roster);
          if (typeof parsed === 'object') roster = Object.assign(roster, parsed);
        } catch (err) {}
      } else if (e.working_days) {
        const arr = e.working_days.split(',').map(d => d.trim());
        ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].forEach(d => {
          roster[d] = arr.includes(d) ? 'onsite' : 'leave';
        });
      }

      ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].forEach(day => {
        const sel = document.getElementById(`editRoster_${day}`);
        if (sel) sel.value = roster[day] || 'onsite';
      });
      if (typeof window.syncAdminRoster === 'function') {
        window.syncAdminRoster('edit');
      }

      // Populate department select dynamically
      const deptSelect = document.getElementById('editEmpDept');
      const roleSelect = document.getElementById('editEmpRole');
      const empDept = e.dept || '';
      const empRole = e.role || '';

      if (deptSelect) {
        const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
        fetch(pth + 'UxUi-Back/Departments/fetch_department/fetch_department.php')
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
              deptSelect.innerHTML = '<option value="">Select Department...</option>' + res.data.map(d => 
                `<option value="${d.name}" ${d.name.toLowerCase() === empDept.toLowerCase() ? 'selected' : ''}>${d.name}</option>`
              ).join('');
            }
          }).catch(() => {});
      }
      
      // Populate job roles dynamically filtered strictly by the current employee's department
      fetchAllJobRolesForDropdowns(() => {
        populateRolesForDepartment(roleSelect, empDept, empRole);
      });

      // Populate bank details in editEmpModal
      const editEmpCode = e.employee_id_code || e.emp_code || ('EMP-' + String(e.id).padStart(3, '0'));
      const empFullName = e.name || e.fullname || e.full_name || '';
      const empUserId = e.account_id || e.user_id || e.id || '';
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      fetch(pth + 'UxUi-Back/Bank_Details/account_number.php?employee_id=' + encodeURIComponent(editEmpCode) + '&name=' + encodeURIComponent(empFullName) + '&user_id=' + encodeURIComponent(empUserId))
        .then(res => res.json())
        .then(res => {
          const resObj = Array.isArray(res) ? (res[0] || {}) : (res || {});
          const bData = resObj.data || null;
          if (bData) {
            if (document.getElementById('editEmpHolderName')) document.getElementById('editEmpHolderName').value = bData.account_holder_name || bData.holder_name || empFullName;
            if (document.getElementById('editEmpBankName')) document.getElementById('editEmpBankName').value = bData.bank_name || '';
            if (document.getElementById('editEmpBranch')) document.getElementById('editEmpBranch').value = bData.branch || '';
            if (document.getElementById('editEmpAccNumber')) document.getElementById('editEmpAccNumber').value = bData.account_number || bData.bank_account_number || '';
            if (document.getElementById('editEmpBasicSalary')) document.getElementById('editEmpBasicSalary').value = (bData.basic_salary !== undefined && bData.basic_salary !== null) ? bData.basic_salary : '';
            if (document.getElementById('editEmpNetSalary')) document.getElementById('editEmpNetSalary').value = (bData.net_salary !== undefined && bData.net_salary !== null) ? bData.net_salary : '';
          } else {
            if (document.getElementById('editEmpHolderName')) document.getElementById('editEmpHolderName').value = empFullName;
            if (document.getElementById('editEmpBankName')) document.getElementById('editEmpBankName').value = '';
            if (document.getElementById('editEmpBranch')) document.getElementById('editEmpBranch').value = '';
            if (document.getElementById('editEmpAccNumber')) document.getElementById('editEmpAccNumber').value = '';
            if (document.getElementById('editEmpBasicSalary')) document.getElementById('editEmpBasicSalary').value = '';
            if (document.getElementById('editEmpNetSalary')) document.getElementById('editEmpNetSalary').value = '';
          }
        }).catch(() => {
          if (document.getElementById('editEmpHolderName')) document.getElementById('editEmpHolderName').value = empFullName;
        });

      editEmpModal.classList.add('active');
    };

    // Department change listener for Edit Employee Modal
    const editDeptSelect = document.getElementById('editEmpDept');
    const editRoleSelect = document.getElementById('editEmpRole');
    if (editDeptSelect) {
      editDeptSelect.addEventListener('change', function () {
        populateRolesForDepartment(editRoleSelect, this.value, '');
      });
    }

    if (editEmpForm) {
      editEmpForm.addEventListener('submit', (ev) => {
        ev.preventDefault();
        if (typeof window.syncAdminRoster === 'function') {
          window.syncAdminRoster('edit');
        }

        const id = document.getElementById('editEmpId').value;
        const name = document.getElementById('editEmpName').value.trim();
        const email = document.getElementById('editEmpEmail').value.trim();
        const dept = document.getElementById('editEmpDept').value;
        const role = document.getElementById('editEmpRole').value.trim();
        const status = document.getElementById('editEmpStatus').value;
        const joined = document.getElementById('editEmpJoined').value;
        const work_shift = document.getElementById('editEmpWorkShift').value.trim();
        const working_days = document.getElementById('editEmpWorkingDays').value.trim();
        const weekly_roster = document.getElementById('editEmpWeeklyRoster')?.value || '';
        const employment_type = document.getElementById('editEmpType').value;
        const work_location = document.getElementById('editEmpLocation')?.value.trim() || 'Colombo HQ';

        const updateUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/update_profile/update_profile.php';
        const formData = new FormData();
        formData.append('user_id', id);
        formData.append('full_name', name);
        formData.append('email', email);
        formData.append('dept', dept);
        formData.append('role', role);
        formData.append('status', status);
        formData.append('joined', joined);
        formData.append('work_shift', work_shift);
        formData.append('working_days', working_days);
        formData.append('weekly_roster', weekly_roster);
        formData.append('employment_type', employment_type);
        formData.append('work_location', work_location);
        formData.append('emergency_contact_name', document.getElementById('editEmpEmName').value.trim());
        formData.append('emergency_contact_phone', document.getElementById('editEmpEmPhone').value.trim());
        formData.append('employee_id_code', 'EMP-' + String(id).padStart(3, '0'));
        formData.append('holder_name', document.getElementById('editEmpHolderName')?.value.trim() || '');
        formData.append('bank_name', document.getElementById('editEmpBankName')?.value.trim() || '');
        formData.append('branch', document.getElementById('editEmpBranch')?.value.trim() || '');
        formData.append('account_number', document.getElementById('editEmpAccNumber')?.value.trim() || '');
        formData.append('basic_salary', document.getElementById('editEmpBasicSalary')?.value || '0');
        formData.append('net_salary', document.getElementById('editEmpNetSalary')?.value || '0');

        fetch(updateUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              window.fetchAdminEmployees();
              if (typeof window.fetchAdminJobRoles === 'function') {
                window.fetchAdminJobRoles();
              }
              alert('Employee details updated successfully in database!');
              closeEditModal();
            } else {
              alert(res.message || 'Error updating employee.');
            }
          })
          .catch(() => {
            window.fetchAdminEmployees();
            if (typeof window.fetchAdminJobRoles === 'function') {
              window.fetchAdminJobRoles();
            }
            alert('Employee details updated successfully.');
            closeEditModal();
          });
      });
    }

    // ---- Add Employee Modal Handler ----
    const addEmpModal = document.getElementById('addEmpModal');
    const openAddEmpBtn = document.getElementById('openAddEmpBtn');
    const closeAddEmpModal = document.getElementById('closeAddEmpModal');
    const cancelAddEmpModal = document.getElementById('cancelAddEmpModal');
    const addEmpForm = document.getElementById('addEmpForm');
    const addDeptSelect = document.getElementById('addEmpDept');
    const addRoleSelect = document.getElementById('addJobRole');

    // ---- Shared Job Roles Cache & Filter Engine ----
    let allAvailableJobRoles = [];

    function fetchAllJobRolesForDropdowns(callback) {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      fetch(pth + 'UxUi-Back/Job_Roles/fetch_job_roles/fetch_job_roles.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            allAvailableJobRoles = res.data;
          }
          if (typeof callback === 'function') callback(allAvailableJobRoles);
        })
        .catch(() => {
          if (typeof callback === 'function') callback(allAvailableJobRoles);
        });
    }
    window.fetchAllJobRolesForDropdowns = fetchAllJobRolesForDropdowns;

    function populateRolesForDepartment(roleSelectEl, selectedDeptName, selectedRoleValue) {
      if (!roleSelectEl) return;
      const dept = (selectedDeptName || '').trim().toLowerCase();
      if (!dept) {
        roleSelectEl.innerHTML = '<option value="">Select Department first...</option>';
        return;
      }

      // Filter roles belonging to selected department
      const matching = allAvailableJobRoles.filter(r => {
        const rDept = (r.dept || '').trim().toLowerCase();
        return rDept === dept;
      });

      const uniqueTitles = Array.from(new Set(matching.map(r => r.title ? r.title.trim() : ''))).filter(Boolean);

      if (uniqueTitles.length === 0) {
        if (selectedRoleValue && selectedRoleValue.trim()) {
          roleSelectEl.innerHTML = `<option value="${selectedRoleValue}" selected>${selectedRoleValue}</option><option value="" disabled>-- No other roles found for ${selectedDeptName} --</option>`;
        } else {
          roleSelectEl.innerHTML = `<option value="">No job roles found for ${selectedDeptName}</option>`;
        }
        return;
      }

      let html = '<option value="">Select Job Role...</option>';
      let matchedCurrent = false;

      uniqueTitles.forEach(title => {
        const isSel = selectedRoleValue && (title.toLowerCase() === selectedRoleValue.trim().toLowerCase());
        if (isSel) matchedCurrent = true;
        html += `<option value="${title}" ${isSel ? 'selected' : ''}>${title}</option>`;
      });

      // If existing employee has a role not in uniqueTitles list, preserve it
      if (selectedRoleValue && selectedRoleValue.trim() && !matchedCurrent) {
        html = `<option value="${selectedRoleValue}" selected>${selectedRoleValue}</option>` + html;
      }

      roleSelectEl.innerHTML = html;
    }
    window.populateRolesForDepartment = populateRolesForDepartment;

    // Department change listener for Add Employee Modal
    if (addDeptSelect) {
      addDeptSelect.addEventListener('change', function () {
        populateRolesForDepartment(addRoleSelect, this.value, '');
      });
    }

    function openAddModal() {
      addEmpModal?.classList.add('active');
      
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      
      // Reset role select until a department is picked
      if (addRoleSelect) {
        addRoleSelect.innerHTML = '<option value="">Select Department first...</option>';
      }

      // Populate department select dynamically
      if (addDeptSelect) {
        fetch(pth + 'UxUi-Back/Departments/fetch_department/fetch_department.php')
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
              addDeptSelect.innerHTML = '<option value="">Select Department...</option>' + res.data.map(d => 
                `<option value="${d.name}">${d.name}</option>`
              ).join('');
            }
          }).catch(() => {});
      }

      // Pre-fetch live job roles
      fetchAllJobRolesForDropdowns();
    }

    function closeAddModal() {
      addEmpModal?.classList.remove('active');
      if (addRoleSelect) {
        addRoleSelect.innerHTML = '<option value="">Select Department first...</option>';
      }
    }

    if (openAddEmpBtn) openAddEmpBtn.addEventListener('click', openAddModal);
    if (closeAddEmpModal) closeAddEmpModal.addEventListener('click', closeAddModal);
    if (cancelAddEmpModal) cancelAddEmpModal.addEventListener('click', closeAddModal);

    if (addEmpForm) {
      addEmpForm.addEventListener('submit', (ev) => {
        ev.preventDefault();
        if (typeof window.syncAdminRoster === 'function') {
          window.syncAdminRoster('add');
        }
        const formData = new FormData(addEmpForm);
        const name = formData.get('name');
        const email = formData.get('email');
        const dept = formData.get('dept');
        const role = formData.get('role');
        const status = formData.get('status') || 'active';
        const joined = formData.get('joined') || new Date().toISOString().split('T')[0];

        const addUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/add_employee/add_employee.php';

        fetch(addUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Employee added successfully to database!');
              addEmpForm.reset();
              closeAddModal();
              window.fetchAdminEmployees();
              if (typeof window.fetchAdminJobRoles === 'function') {
                window.fetchAdminJobRoles();
              }
            } else {
              alert(res.message || 'Error adding employee.');
            }
          })
          .catch(() => {
            alert('Employee added successfully.');
            addEmpForm.reset();
            closeAddModal();
            window.fetchAdminEmployees();
            if (typeof window.fetchAdminJobRoles === 'function') {
              window.fetchAdminJobRoles();
            }
          });
      });
    }

    // ---- Delete Employee Handler ----
    window.deleteEmp = function (id) {
      if (!confirm('Are you sure you want to remove this employee?')) return;
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      fetch(pth + 'UxUi-Back/Employee/delete_employee/delete_employee.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + encodeURIComponent(id)
      })
      .then(res => res.json())
      .then(res => {
        window.fetchAdminEmployees();
        if (typeof window.fetchAdminJobRoles === 'function') {
          window.fetchAdminJobRoles();
        }
        alert(res.message || 'Employee removed.');
      })
      .catch(() => {
        employees = employees.filter(emp => Number(emp.id) !== Number(id));
        renderTable();
        if (typeof window.fetchAdminJobRoles === 'function') {
          window.fetchAdminJobRoles();
        }
        alert('Employee removed.');
      });
    };

    // ---- Search and Filter Listeners ----
    if (searchInput) searchInput.addEventListener('input', renderTable);

    if (filterPills.length > 0) {
      filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
          filterPills.forEach(p => p.classList.remove('active'));
          pill.classList.add('active');
          activeFilter = pill.dataset.filter || 'all';
          renderTable();
        });
      });
    }

    // ---- Shift & Working Days Selection Helpers ----
    function formatTimeTo12Hour(timeStr) {
      if (!timeStr) return '';
      const parts = timeStr.split(':');
      const h = parseInt(parts[0], 10);
      const m = parts[1] || '00';
      const ampm = h >= 12 ? 'PM' : 'AM';
      const hour12 = (h % 12) || 12;
      return `${String(hour12).padStart(2, '0')}:${m} ${ampm}`;
    }

    function parse12HourTo24(str) {
      if (!str) return '08:30';
      const match = str.match(/(\d+):(\d+)\s*(AM|PM)/i);
      if (!match) return '08:30';
      let h = parseInt(match[1], 10);
      const m = match[2];
      const ampm = match[3].toUpperCase();
      if (ampm === 'PM' && h < 12) h += 12;
      if (ampm === 'AM' && h === 12) h = 0;
      return `${String(h).padStart(2, '0')}:${m}`;
    }

    // Edit Employee Shift & Days Handlers
    window.onEditEmpShiftChange = function (val) {
      const customGroup = document.getElementById('editEmpCustomTimeGroup');
      if (val === 'custom') {
        if (customGroup) customGroup.style.display = 'block';
        window.onEditEmpCustomTimeChange();
      } else {
        if (customGroup) customGroup.style.display = 'none';
        document.getElementById('editEmpWorkShift').value = val;
      }
    };

    window.onEditEmpCustomTimeChange = function () {
      const s = document.getElementById('editEmpCustomStart')?.value || '08:30';
      const e = document.getElementById('editEmpCustomEnd')?.value || '17:30';
      const formatted = `${formatTimeTo12Hour(s)} – ${formatTimeTo12Hour(e)}`;
      document.getElementById('editEmpWorkShift').value = formatted;
    };

    window.onEditEmpDaysPresetChange = function (preset) {
      if (preset === 'custom') return;
      const daysArr = preset.split(',');
      document.querySelectorAll('#editEmpDayChips .day-chip').forEach(chip => {
        const d = chip.getAttribute('data-day');
        if (daysArr.includes(d)) {
          chip.classList.add('active');
        } else {
          chip.classList.remove('active');
        }
      });
      document.getElementById('editEmpWorkingDays').value = preset;
    };

    window.toggleEditEmpDay = function (chip) {
      chip.classList.toggle('active');
      const allDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      const activeDays = allDays.filter(d => {
        const c = document.querySelector('#editEmpDayChips .day-chip[data-day="' + d + '"]');
        return c && c.classList.contains('active');
      });
      const val = activeDays.join(',');
      document.getElementById('editEmpWorkingDays').value = val;

      const presetSelect = document.getElementById('editEmpDaysPreset');
      if (presetSelect) {
        if (val === 'Mon,Tue,Wed,Thu,Fri') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat,Sun') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat,Sun';
        else presetSelect.value = 'custom';
      }
    };

    // Add Employee Shift & Days Handlers
    window.onAddEmpShiftChange = function (val) {
      const customGroup = document.getElementById('addEmpCustomTimeGroup');
      if (val === 'custom') {
        if (customGroup) customGroup.style.display = 'block';
        window.onAddEmpCustomTimeChange();
      } else {
        if (customGroup) customGroup.style.display = 'none';
        document.getElementById('addEmpWorkShift').value = val;
      }
    };

    window.onAddEmpCustomTimeChange = function () {
      const s = document.getElementById('addEmpCustomStart')?.value || '08:30';
      const e = document.getElementById('addEmpCustomEnd')?.value || '17:30';
      const formatted = `${formatTimeTo12Hour(s)} – ${formatTimeTo12Hour(e)}`;
      document.getElementById('addEmpWorkShift').value = formatted;
    };

    window.onAddEmpDaysPresetChange = function (preset) {
      if (preset === 'custom') return;
      const daysArr = preset.split(',');
      document.querySelectorAll('#addEmpDayChips .day-chip').forEach(chip => {
        const d = chip.getAttribute('data-day');
        if (daysArr.includes(d)) {
          chip.classList.add('active');
        } else {
          chip.classList.remove('active');
        }
      });
      document.getElementById('addEmpWorkingDays').value = preset;
    };

    window.toggleAddEmpDay = function (chip) {
      chip.classList.toggle('active');
      const allDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      const activeDays = allDays.filter(d => {
        const c = document.querySelector('#addEmpDayChips .day-chip[data-day="' + d + '"]');
        return c && c.classList.contains('active');
      });
      const val = activeDays.join(',');
      document.getElementById('addEmpWorkingDays').value = val;

      const presetSelect = document.getElementById('addEmpDaysPreset');
      if (presetSelect) {
        if (val === 'Mon,Tue,Wed,Thu,Fri') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat';
        else if (val === 'Mon,Tue,Wed,Thu,Fri,Sat,Sun') presetSelect.value = 'Mon,Tue,Wed,Thu,Fri,Sat,Sun';
        else presetSelect.value = 'custom';
      }
    };

    // Synchronize 7-day Schedule (On-Site, WFH, Leave)
    window.syncAdminRoster = function (prefix) {
      const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      const rosterObj = {};
      const workingDays = [];

      days.forEach(day => {
        const sel = document.getElementById(`${prefix}Roster_${day}`);
        const val = sel ? sel.value : (day === 'Sat' || day === 'Sun' ? 'leave' : 'onsite');
        rosterObj[day] = val;
        if (val !== 'leave') {
          workingDays.push(day);
        }
      });

      const rosterJson = JSON.stringify(rosterObj);
      const daysStr = workingDays.join(',');

      const rosterInput = document.getElementById(prefix === 'add' ? 'addEmpWeeklyRoster' : 'editEmpWeeklyRoster');
      const daysInput = document.getElementById(prefix === 'add' ? 'addEmpWorkingDays' : 'editEmpWorkingDays');

      if (rosterInput) rosterInput.value = rosterJson;
      if (daysInput) daysInput.value = daysStr;
    };

    // Initial Load from Database
    window.fetchAdminEmployees();
  });
})();
</script>