<?php
$jsFile = __DIR__ . '/../Super_Admin_user_dashboard_02_employees/JS/Super_Admin_user_dashboard_02_employees_JS.php';
$content = file_get_contents($jsFile);

$adminJsFunctions = <<<'JS'
    // =========================================================================
    // Admin Accounts & Approvals Management (Super Admin Control)
    // =========================================================================
    let adminAccountsList = [];
    let currentAdminFilter = 'all';

    window.filterAdminTable = function(filter) {
      currentAdminFilter = filter;
      document.querySelectorAll('#adminFilterPills .w3-pill').forEach(pill => {
        if (pill.getAttribute('data-filter') === filter) {
          pill.classList.add('active');
        } else {
          pill.classList.remove('active');
        }
      });
      window.renderAdminTable();
    };

    window.loadAdminAccountsData = function() {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      const tbody = document.getElementById('adminsTableBody');
      if (tbody) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 25px; color:#64748b;"><i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Loading administrator accounts...</td></tr>';
      }

      fetch(pth + 'UxUi-Back/Admin/fetch_admin_accounts/fetch_admin_accounts.php')
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            adminAccountsList = res.data;

            // Update stats
            const total = adminAccountsList.length;
            const pending = res.pending_count || 0;
            const active = adminAccountsList.filter(a => a.is_active).length;

            const statTotal = document.getElementById('statTotalAdmins');
            const statPending = document.getElementById('statPendingAdmins');
            const statActive = document.getElementById('statActiveAdmins');
            const pendingBadge = document.getElementById('pendingAdminsBadge');
            const banner = document.getElementById('adminApprovalBanner');
            const bannerCount = document.getElementById('adminBannerPendingCount');

            if (statTotal) statTotal.textContent = total;
            if (statPending) statPending.textContent = pending;
            if (statActive) statActive.textContent = active;

            if (pendingBadge) {
              if (pending > 0) {
                pendingBadge.textContent = pending;
                pendingBadge.style.display = 'inline-block';
              } else {
                pendingBadge.style.display = 'none';
              }
            }

            if (banner) {
              if (pending > 0) {
                if (bannerCount) bannerCount.textContent = pending;
                banner.style.display = 'flex';
              } else {
                banner.style.display = 'none';
              }
            }

            window.renderAdminTable();
          } else {
            if (tbody) {
              tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; padding: 25px; color:#ef4444;">${res.message || 'Could not load administrators list.'}</td></tr>`;
            }
          }
        })
        .catch(err => {
          console.error('Error fetching admin accounts:', err);
          if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 25px; color:#ef4444;">Network error while fetching administrator accounts.</td></tr>';
          }
        });
    };

    window.renderAdminTable = function() {
      const tbody = document.getElementById('adminsTableBody');
      const mobileContainer = document.getElementById('mobileAdminCardsContainer');
      if (!tbody) return;

      const searchInput = document.getElementById('adminSearchInput');
      const query = searchInput ? searchInput.value.trim().toLowerCase() : '';

      const filtered = adminAccountsList.filter(a => {
        let matchesFilter = true;
        if (currentAdminFilter === 'pending') {
          matchesFilter = a.is_pending;
        } else if (currentAdminFilter === 'active') {
          matchesFilter = a.is_active;
        } else if (currentAdminFilter === 'blocked') {
          matchesFilter = a.is_blocked;
        }

        const name = (a.name_show || '').toLowerCase();
        const email = (a.user_name || '').toLowerCase();
        const ref = (a.ref_key || '').toLowerCase();
        const matchesQuery = !query || name.includes(query) || email.includes(query) || ref.includes(query);

        return matchesFilter && matchesQuery;
      });

      if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 35px; color:#64748b;">No administrator accounts matching current filter.</td></tr>';
        if (mobileContainer) mobileContainer.innerHTML = '<div style="text-align:center; padding:20px; color:#64748b;">No administrator accounts found.</div>';
        return;
      }

      // Render Desktop Rows
      tbody.innerHTML = filtered.map(a => {
        const safeName = (a.name_show || a.user_name || 'Admin').replace(/"/g, '&quot;').replace(/'/g, '&#39;');

        let statusBadge = '';
        if (a.is_pending) {
          statusBadge = '<span style="background:#fffbeb; color:#d97706; border:1px solid #fef3c7; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:5px;"><i class="fas fa-clock"></i> Pending Approval</span>';
        } else if (a.is_blocked) {
          statusBadge = '<span style="background:#fef2f2; color:#ef4444; border:1px solid #fee2e2; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:5px;"><i class="fas fa-ban"></i> Suspended</span>';
        } else {
          statusBadge = '<span style="background:#ecfdf5; color:#059669; border:1px solid #d1fae5; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:5px;"><i class="fas fa-check-circle"></i> Approved</span>';
        }

        let actionBtns = '';
        if (a.is_root) {
          actionBtns = '<span style="background:#f1f5f9; color:#64748b; padding:5px 12px; border-radius:999px; font-size:11.5px; font-weight:700;"><i class="fas fa-lock" style="margin-right:4px;"></i> Super Admin</span>';
        } else if (a.is_pending) {
          actionBtns = `
            <div style="display:inline-flex; align-items:center; gap:6px;">
              <button type="button" onclick="approveAdminAccount(${a.id}, 'approve', '${safeName}')" class="w3-btn-primary" style="background:linear-gradient(135deg, #10b981 0%, #059669 100%); padding:6px 14px; font-size:12px; border-radius:8px; border:none; box-shadow:0 2px 6px rgba(16,185,129,0.25);">
                <i class="fas fa-check"></i> Approve
              </button>
              <button type="button" onclick="approveAdminAccount(${a.id}, 'reject', '${safeName}')" style="background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">
                <i class="fas fa-xmark"></i> Decline
              </button>
            </div>
          `;
        } else if (a.is_blocked) {
          actionBtns = `
            <button type="button" onclick="approveAdminAccount(${a.id}, 'approve', '${safeName}')" class="w3-btn-primary" style="background:#10b981; padding:6px 14px; font-size:12px; border-radius:8px; border:none;">
              <i class="fas fa-rotate"></i> Approve &amp; Activate
            </button>
          `;
        } else {
          actionBtns = `
            <button type="button" onclick="approveAdminAccount(${a.id}, 'reject', '${safeName}')" style="background:#f8fafc; color:#64748b; border:1px solid #cbd5e1; padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">
              <i class="fas fa-user-slash"></i> Suspend
            </button>
          `;
        }

        const initials = (a.name_show || 'AD').substring(0, 2).toUpperCase();

        return `
          <tr>
            <td>
              <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:50%; background:${a.is_root ? '#14204d' : '#2563eb'}; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; flex-shrink:0;">
                  ${initials}
                </div>
                <div>
                  <div style="font-weight:700; color:#1e293b; font-size:13.5px;">${a.name_show}</div>
                  <div style="font-size:12px; color:#64748b;">${a.user_name}</div>
                </div>
              </div>
            </td>
            <td>
              <div style="font-weight:600; color:#14204d; font-size:13px;">${a.role}</div>
              <div style="font-size:11.5px; color:#64748b; font-family:monospace;">${a.ref_key}</div>
            </td>
            <td style="font-size:12.5px; color:#475569;">${a.sdt}</td>
            <td style="font-size:12.5px; color:#64748b;">${a.last_login}</td>
            <td>${statusBadge}</td>
            <td style="text-align:right;">${actionBtns}</td>
          </tr>
        `;
      }).join('');

      // Render Mobile Cards
      if (mobileContainer) {
        mobileContainer.innerHTML = filtered.map(a => {
          const safeName = (a.name_show || a.user_name || 'Admin').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
          const initials = (a.name_show || 'AD').substring(0, 2).toUpperCase();

          let actionBtns = '';
          if (a.is_root) {
            actionBtns = '<span style="background:#f1f5f9; color:#64748b; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700;">Super Admin (Protected)</span>';
          } else if (a.is_pending) {
            actionBtns = `
              <div style="display:flex; gap:8px; width:100%; margin-top:8px;">
                <button type="button" onclick="approveAdminAccount(${a.id}, 'approve', '${safeName}')" class="w3-btn-primary" style="flex:1; background:#10b981; padding:8px; font-size:12.5px; border-radius:8px; border:none; justify-content:center;">
                  <i class="fas fa-check"></i> Approve
                </button>
                <button type="button" onclick="approveAdminAccount(${a.id}, 'reject', '${safeName}')" style="flex:1; background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; padding:8px; border-radius:8px; font-size:12.5px; font-weight:700; cursor:pointer;">
                  <i class="fas fa-xmark"></i> Decline
                </button>
              </div>
            `;
          } else if (a.is_blocked) {
            actionBtns = `
              <button type="button" onclick="approveAdminAccount(${a.id}, 'approve', '${safeName}')" class="w3-btn-primary" style="width:100%; background:#10b981; padding:8px; font-size:12.5px; border-radius:8px; border:none; margin-top:8px; justify-content:center;">
                <i class="fas fa-rotate"></i> Approve &amp; Activate
              </button>
            `;
          } else {
            actionBtns = `
              <button type="button" onclick="approveAdminAccount(${a.id}, 'reject', '${safeName}')" style="width:100%; background:#f8fafc; color:#64748b; border:1px solid #cbd5e1; padding:6px; border-radius:8px; font-size:12px; margin-top:8px; cursor:pointer;">
                <i class="fas fa-user-slash"></i> Suspend Access
              </button>
            `;
          }

          return `
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:14px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                  <div style="width:34px; height:34px; border-radius:50%; background:${a.is_root ? '#14204d' : '#2563eb'}; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px;">
                    ${initials}
                  </div>
                  <div>
                    <div style="font-weight:700; color:#1e293b; font-size:13.5px;">${a.name_show}</div>
                    <div style="font-size:11.5px; color:#64748b;">${a.user_name}</div>
                  </div>
                </div>
                <div style="font-size:11.5px; font-weight:700;">
                  ${a.is_pending ? '<span style="color:#d97706;">Pending</span>' : (a.is_blocked ? '<span style="color:#ef4444;">Suspended</span>' : '<span style="color:#10b981;">Active</span>')}
                </div>
              </div>
              <div style="font-size:11.5px; color:#64748b; display:flex; justify-content:space-between; border-top:1px dashed #f1f5f9; padding-top:8px;">
                <span>Ref: <strong>${a.ref_key}</strong></span>
                <span>Registered: ${a.sdt}</span>
              </div>
              ${actionBtns}
            </div>
          `;
        }).join('');
      }
    };

    // Action function to Approve or Decline an Admin
    window.approveAdminAccount = function(adminId, action, adminName) {
      const verb = (action === 'approve') ? 'APPROVE and activate' : 'DECLINE / SUSPEND';
      const promptMsg = (action === 'approve')
        ? `Are you sure you want to APPROVE administrator "${adminName}"?\n\nAn email will be dispatched informing them that their account is activated, and they will immediately be permitted to sign in to the Admin Portal.`
        : `Are you sure you want to DECLINE / SUSPEND administrator "${adminName}"?\n\nTheir login access will be blocked and an update notification email will be sent.`;

      if (!confirm(promptMsg)) {
        return;
      }

      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';
      const fd = new FormData();
      fd.append('admin_id', adminId);
      fd.append('action', action);

      fetch(pth + 'UxUi-Back/Admin/approve_admin_account/approve_admin_account.php', {
        method: 'POST',
        body: fd
      })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            alert(res.message || 'Action completed successfully.');
            window.loadAdminAccountsData();
            if (typeof window.fetchAdminNotifications === 'function') {
              window.fetchAdminNotifications();
            }
          } else {
            alert(res.message || 'Operation failed.');
          }
        })
        .catch(err => {
          console.error('Error approving admin:', err);
          alert('Network or server error while updating administrator account.');
        });
    };
JS;

$cNormalized = str_replace("\r\n", "\n", $content);

if (strpos($cNormalized, 'function approveAdminAccount') === false) {
    $searchInit = "    // Initial Load from Database\n    window.fetchAdminEmployees();";
    $replaceInit = $adminJsFunctions . "\n\n    // Initial Load from Database\n    window.fetchAdminEmployees();\n    window.loadAdminAccountsData();";

    if (strpos($cNormalized, $searchInit) !== false) {
        $cNormalized = str_replace($searchInit, $replaceInit, $cNormalized);
        file_put_contents($jsFile, $cNormalized);
        echo "Admin JS functions appended successfully.\n";
    } else {
        echo "searchInit not found.\n";
    }
} else {
    echo "approveAdminAccount already present.\n";
}
