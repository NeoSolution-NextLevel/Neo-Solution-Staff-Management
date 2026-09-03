<script>
(function () {
    const init = () => {

    const menuBtn = document.getElementById('menuBtn_04') || document.getElementById('menuBtn');
    function toggleMobileSidebar() {
        if (typeof openEmployeeSidebar === 'function') {
            openEmployeeSidebar();
        } else {
            const sidebar = document.getElementById('employeeSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar?.classList.toggle('mobile-open');
            overlay?.classList.toggle('active');
        }
    }

    if (menuBtn) {
        menuBtn.addEventListener('click', toggleMobileSidebar);
    }

    // Load pending requests when the Documents section opens
    loadEmpPendingDocRequests();

    };

    // ===================================================
    // EMPLOYEE — Pending Document Requests
    // ===================================================
    window.loadEmpPendingDocRequests = function() {
        var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
        var userId = typeof window._empUserId !== 'undefined' ? window._empUserId
                   : (typeof window.currentUserId !== 'undefined' ? window.currentUserId : 0);

        // Fallback: read from PHP session echo (set on the dashboard page)
        if (!userId && typeof window.empSessionUserId !== 'undefined') userId = window.empSessionUserId;

        var url = pth + 'View-List/Documents/Fetch_Document_Requests.php?for=employee';
        if (userId) url += '&user_id=' + userId;

        fetch(url, { credentials: 'same-origin' })
          .then(function(r){ return r.json(); })
          .then(function(res) {
              var panel = document.getElementById('pendingDocRequestsPanel');
              if (!res || res.status !== 'success' || !Array.isArray(res.data)) {
                  if (panel) panel.style.display = 'none';
                  return;
              }
              // Only show Pending or Uploaded (not Approved/Ignored)
              var active = res.data.filter(function(r){ return r.status === 'Pending' || r.status === 'Uploaded'; });
              if (active.length === 0) {
                  if (panel) panel.style.display = 'none';
                  return;
              }

              var subtitle = document.getElementById('pendingReqSubtitle');
              var list     = document.getElementById('pendingReqList');
              var btn      = document.getElementById('btnTogglePendingReqs');
              if (panel) panel.style.display = 'block';
              if (subtitle) subtitle.textContent = active.length + ' document request' + (active.length > 1 ? 's' : '') + ' awaiting your action';
              if (list) list.style.display = 'block';
              if (btn) btn.innerHTML = '<i class="fa-solid fa-chevron-up"></i> Hide Requests';

              renderEmpRequestCards(active, pth);
          })
          .catch(function(){});
    };

    window.togglePendingReqs = function() {
        var list     = document.getElementById('pendingReqList');
        var chevron  = document.getElementById('pendingReqChevron');
        var btn      = document.getElementById('btnTogglePendingReqs');
        if (!list) return;
        var open = list.style.display !== 'none' && list.style.display !== '';
        list.style.display = open ? 'none' : 'block';
        if (chevron) {
            chevron.className = open ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-up';
        }
        if (btn) btn.innerHTML = (open ? '<i class="fa-solid fa-chevron-down"></i> View Requests' : '<i class="fa-solid fa-chevron-up"></i> Hide Requests');
    };

    function renderEmpRequestCards(requests, pth) {
        var container = document.getElementById('pendingReqCards');
        if (!container) return;
        container.innerHTML = requests.map(function(req) {
            var statusColor = req.status === 'Uploaded' ? '#12b76a' : '#fff';
            var statusBg    = req.status === 'Uploaded' ? 'rgba(18,183,106,.15)' : 'rgba(255,255,255,.12)';
            var dl          = req.deadline ? ' · Due: ' + req.deadline.slice(0,10) : '';
            var uploadedNote = req.status === 'Uploaded' ? '<div style="font-size:11.5px; color:#86efac; margin-top:6px;"><i class="fa-solid fa-circle-check"></i> File uploaded — awaiting admin review</div>' : '';
            var actionBtn   = req.status === 'Pending'
                ? '<button onclick="empUploadForRequest('+req.id+',\''+req.doc_type+'\')" style="display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border:none; border-radius:8px; background:#fff; color:#4f46e5; font-size:12.5px; font-weight:800; cursor:pointer;"><i class="fa-solid fa-upload"></i> Upload Now</button>'
                : '<span style="color:rgba(255,255,255,.6); font-size:12px;"><i class="fa-solid fa-clock"></i> Awaiting admin review</span>';

            return '<div style="background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); border-radius:10px; padding:14px 16px;">' +
                '<div style="display:flex; align-items:flex-start; justify-content:space-between; gap:10px; flex-wrap:wrap;">' +
                    '<div style="flex:1; min-width:0;">' +
                        '<div style="color:#fff; font-size:13.5px; font-weight:800; margin-bottom:3px;"><i class="fa-solid fa-file-arrow-up" style="margin-right:6px;"></i>' + req.doc_type + '</div>' +
                        '<div style="color:rgba(255,255,255,.75); font-size:11.5px;">Requested by ' + req.requested_by_name + dl + '</div>' +
                        (req.notes ? '<div style="color:rgba(255,255,255,.7); font-size:11.5px; margin-top:6px; font-style:italic;">"' + req.notes + '"</div>' : '') +
                        uploadedNote +
                    '</div>' +
                    actionBtn +
                '</div>' +
                '</div>';
        }).join('');
    }

    window.empUploadForRequest = function(requestId, docType) {
        // Pre-fill the existing upload input for this doc type, then trigger upload-for-request
        // Map doc_type to existing card keys
        var typeMap = { 'CV': 'cv', 'National ID': 'id', 'Agreement': 'agreement', 'Certificate': 'cert', 'Police Report': 'police' };
        var cardKey = typeMap[docType] || 'cv';

        // Store request context globally so saveEmployeeDoc can use it
        window._pendingRequestId = requestId;
        window._pendingRequestDocType = docType;

        var fileInput = document.getElementById('fileInput_' + cardKey) || document.getElementById('fileInput_cv');
        if (fileInput) {
            // One-time listener to auto-submit after file chosen
            var onchange = function() {
                fileInput.removeEventListener('change', onchange);
                // Small delay to let preview update
                setTimeout(function() {
                    var saveBtn = document.getElementById('btnSave_' + cardKey) || document.getElementById('btnSave_cv');
                    if (saveBtn) saveBtn.click();
                }, 300);
            };
            fileInput.addEventListener('change', onchange);
            fileInput.click();
        } else {
            alert('Please scroll to the "' + docType + '" section below and upload the file manually.');
        }
    };

    // Request ID and reload are handled directly in saveEmployeeDoc in Employee_user_dashboard_04_documents.php


    // Trigger init when docs section becomes visible
    var docsSection = document.getElementById('Employee_user_dashboard_04_documents');
    if (docsSection) {
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(m) {
                if (m.type === 'attributes' && m.attributeName === 'style') {
                    var disp = docsSection.style.display;
                    if (disp && disp !== 'none') {
                        loadEmpPendingDocRequests();
                    }
                }
            });
        });
        observer.observe(docsSection, { attributes: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>