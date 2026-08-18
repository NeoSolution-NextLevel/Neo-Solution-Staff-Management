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
            <button type="button" class="btn-view" onclick="openLeaveDetails(${r.id})">
              View
            </button>
          `;

          if (statusClass === 'pending') {
            actionCell = `
              <button type="button" class="btn-approve" onclick="approveLeave(${r.id}, event)">
                Approve
              </button>
              <button type="button" class="btn-reject" onclick="rejectLeave(${r.id}, event)">
                Reject
              </button>
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
              <td style="text-align:right;">${actionCell}</td>
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
            <button type="button" class="btn-approve" onclick="approveLeave(${req.id}); closeLeaveModal();">
              Approve
            </button>
            <button type="button" class="btn-reject" onclick="rejectLeave(${req.id}); closeLeaveModal();">
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

    // ---- Approve Leave ----
    window.approveLeave = function (id, event) {
      if (event) event.stopPropagation();
      if (!confirm('Are you sure you want to approve this leave request?')) return;

      const approveUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/approve_leave_request/approve_leave_request.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(approveUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            window.fetchAdminLeaveRequests();
            alert('Leave request approved successfully!');
          } else {
            alert(res.message || 'Could not approve leave.');
          }
        })
        .catch(() => {
          const req = leaveRequests.find(r => Number(r.id) === Number(id));
          if (req) req.status = 'Approved';
          renderLeaveTable();
        });
    };

    // ---- Reject Leave ----
    window.rejectLeave = function (id, event) {
      if (event) event.stopPropagation();
      if (!confirm('Are you sure you want to reject this leave request?')) return;

      const rejectUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Leave_Requests/reject_leave_request/reject_leave_request.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(rejectUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            window.fetchAdminLeaveRequests();
            alert('Leave request rejected successfully.');
          } else {
            alert(res.message || 'Could not reject leave.');
          }
        })
        .catch(() => {
          const req = leaveRequests.find(r => Number(r.id) === Number(id));
          if (req) req.status = 'Rejected';
          renderLeaveTable();
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