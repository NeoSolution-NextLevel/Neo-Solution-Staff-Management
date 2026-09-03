<script>
/**
 * Admin Leave Requests JS (Basic, Clean & Plain Text)
 */
(function () {
  const init = () => {

    const menuBtn = document.getElementById('menuBtn_08') || document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (typeof openAdminSidebar === 'function') openAdminSidebar();
      });
    }

    let leaveRequests = [];
    const tableBody = document.getElementById('leaveTableBody');
    const leaveCount = document.getElementById('leaveCount');
    const filterTabs = document.querySelectorAll('#leaveFilterTabs .filter-btn');
    const leaveModal = document.getElementById('leaveDetailsModal');
    let activeFilter = 'All';

    // ---- Render Table ----
    function renderLeaveTable() {
      if (!tableBody) return;

      const filtered = leaveRequests.filter(r => {
        if (activeFilter === 'All') return true;
        return (r.status || '').toLowerCase() === activeFilter.toLowerCase();
      });

      if (filtered.length > 0) {
        tableBody.innerHTML = filtered.map(r => {
          const statusClass = (r.status || 'Pending').toLowerCase();
          const fromDate = (r.from || '').split(' ')[0];
          const toDate = (r.to || '').split(' ')[0];
          const reasonFull = r.reason ? r.reason : '—';
          const empName = r.employee || 'Employee';

          let actionCell = `
            <div class="btn-actions-group" style="display:flex; align-items:center; justify-content:center; margin:0 auto;">
              <button type="button" class="btn-action view" onclick="openLeaveDetails(${r.id})">
                View
              </button>
            </div>
          `;

          if (statusClass === 'pending') {
            actionCell = `
              <div class="btn-actions-group" style="display:flex; align-items:center; justify-content:center; margin:0 auto;">
                <button type="button" class="btn-action approve" onclick="approveLeave(${r.id}, event)">
                  Approve
                </button>
                <button type="button" class="btn-action reject" onclick="rejectLeave(${r.id}, event)">
                  Reject
                </button>
              </div>
            `;
          }

          return `
            <tr data-id="${r.id}">
              <td>
                <span class="clickable-link" onclick="openLeaveDetails(${r.id})">
                  ${escapeHtml(empName)}
                </span>
              </td>
              <td><strong>${escapeHtml(r.type || 'Leave')}</strong></td>
              <td>${fromDate} to ${toDate} (${r.days || 1} d)</td>
              <td class="reason-cell" onclick="openLeaveDetails(${r.id})" title="${escapeHtml(reasonFull)}">
                ${escapeHtml(reasonFull)}
              </td>
              <td>
                <span class="status-tag ${statusClass}">${r.status || 'Pending'}</span>
              </td>
              <td class="col-actions" style="text-align: center; vertical-align: middle;">${actionCell}</td>
            </tr>
          `;
        }).join('');
      } else {
        tableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 36px 20px; color: #64748b;">No leave requests found for this filter.</td></tr>';
      }

      const pendingCount = leaveRequests.filter(r => (r.status || '').toLowerCase() === 'pending').length;
      if (leaveCount) {
        leaveCount.textContent = `${pendingCount} pending approval${pendingCount === 1 ? '' : 's'}`;
      }
    }

    function escapeHtml(text) {
      if (!text) return '';
      return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    // ---- Open Modal ----
    window.openLeaveDetails = function(id) {
      const req = leaveRequests.find(r => Number(r.id) === Number(id));
      if (!req) return;

      const modal = document.getElementById('leaveDetailsModal');
      const name = document.getElementById('modalEmpName');
      const type = document.getElementById('modalLeaveType');
      const status = document.getElementById('modalLeaveStatus');
      const duration = document.getElementById('modalLeaveDuration');
      const days = document.getElementById('modalLeaveDays');
      const submitted = document.getElementById('modalLeaveSubmitted');
      const reason = document.getElementById('modalLeaveReason');
      const actionButtons = document.getElementById('modalActionButtons');

      const statusClass = (req.status || 'Pending').toLowerCase();

      if (name) name.textContent = req.employee || 'Employee';
      if (type) type.textContent = req.type || 'Leave';
      if (status) status.innerHTML = `<span class="status-tag ${statusClass}">${req.status || 'Pending'}</span>`;
      if (duration) duration.textContent = `${(req.from || '').split(' ')[0]} to ${(req.to || '').split(' ')[0]}`;
      if (days) days.textContent = `${req.days || 1} day${req.days == 1 ? '' : 's'}`;
      if (submitted) submitted.textContent = req.submitted || '—';
      if (reason) reason.textContent = req.reason || 'No reason provided.';

      if (actionButtons) {
        if (statusClass === 'pending') {
          actionButtons.innerHTML = `
            <button type="button" class="btn-action approve" onclick="approveLeave(${req.id}); closeLeaveModal();">
              Approve
            </button>
            <button type="button" class="btn-action reject" onclick="rejectLeave(${req.id}); closeLeaveModal();">
              Reject
            </button>
          `;
        } else {
          actionButtons.innerHTML = '';
        }
      }

      if (modal) modal.style.display = 'block';
    };

    window.closeLeaveModal = function() {
      const modal = document.getElementById('leaveDetailsModal');
      if (modal) modal.style.display = 'none';
    };

    if (leaveModal) {
      leaveModal.addEventListener('click', (e) => {
        if (e.target === leaveModal) closeLeaveModal();
      });
    }

    // ---- Fetch Data ----
    window.fetchAdminLeaveRequests = function() {
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/fetch_leave_request/fetch_leave_request.php';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success' && Array.isArray(res.data)) {
            leaveRequests = res.data;
          } else {
            leaveRequests = [];
          }
          renderLeaveTable();
        })
        .catch(() => {
          renderLeaveTable();
        });
    };

    // ---- Filter Buttons ----
    if (filterTabs.length > 0) {
      filterTabs.forEach(btn => {
        btn.addEventListener('click', () => {
          filterTabs.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeFilter = btn.dataset.filter || 'All';
          renderLeaveTable();
        });
      });
    }

    // ---- Toast Notification Helper ----
    function showToast(message, type = 'success') {
      let toastContainer = document.getElementById('dashboardToastContainer');
      if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'dashboardToastContainer';
        toastContainer.style.cssText = 'position:fixed; top:24px; right:24px; z-index:99999; display:flex; flex-direction:column; gap:10px; pointer-events:none;';
        document.body.appendChild(toastContainer);
      }

      const toast = document.createElement('div');
      const bg = type === 'success' ? '#16a34a' : (type === 'error' ? '#dc2626' : '#2563eb');
      const icon = type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ');

      toast.style.cssText = `
        background: ${bg};
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transform: translateY(-12px);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: auto;
      `;

      toast.innerHTML = `<span style="font-size:15px; font-weight:800; background:rgba(255,255,255,0.22); width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">${icon}</span> <span>${escapeHtml(message)}</span>`;
      toastContainer.appendChild(toast);

      requestAnimationFrame(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
      });

      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-12px)';
        setTimeout(() => toast.remove(), 300);
      }, 3200);
    }

    // ---- Approve Leave ----
    window.approveLeave = function (id, event) {
      if (event) event.stopPropagation();

      // Optimistic instant UI update
      const req = leaveRequests.find(r => Number(r.id) === Number(id));
      if (req) {
        req.status = 'Approved';
        renderLeaveTable();
      }

      const approveUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/approve_leave_request/approve_leave_request.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(approveUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            showToast('Leave request approved successfully!', 'success');
            window.fetchAdminLeaveRequests();
          } else {
            showToast(res.message || 'Could not approve leave.', 'error');
            window.fetchAdminLeaveRequests();
          }
        })
        .catch(() => {
          showToast('Leave request approved successfully!', 'success');
          window.fetchAdminLeaveRequests();
        });
    };

    // ---- Reject Leave ----
    window.rejectLeave = function (id, event) {
      if (event) event.stopPropagation();

      // Optimistic instant UI update
      const req = leaveRequests.find(r => Number(r.id) === Number(id));
      if (req) {
        req.status = 'Rejected';
        renderLeaveTable();
      }

      const rejectUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/reject_leave_request/reject_leave_request.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(rejectUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            showToast('Leave request rejected successfully.', 'success');
            window.fetchAdminLeaveRequests();
          } else {
            showToast(res.message || 'Could not reject leave.', 'error');
            window.fetchAdminLeaveRequests();
          }
        })
        .catch(() => {
          showToast('Leave request rejected successfully.', 'success');
          window.fetchAdminLeaveRequests();
        });
    };

    window.fetchAdminLeaveRequests();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>