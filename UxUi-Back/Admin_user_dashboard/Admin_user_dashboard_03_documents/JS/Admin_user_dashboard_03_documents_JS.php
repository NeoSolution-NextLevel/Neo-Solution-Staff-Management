<script>
/**
 * Admin Documents Management Controller JS
 */
var allAdminDocs = [];

// Initialize PDF.js worker safely
if (typeof pdfjsLib !== 'undefined') {
  try {
    fetch('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js')
      .then(function(res) { return res.text(); })
      .then(function(code) {
        var blob = new Blob([code], { type: 'application/javascript' });
        pdfjsLib.GlobalWorkerOptions.workerSrc = URL.createObjectURL(blob);
      }).catch(function() {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
      });
  } catch(e) {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
  }
}

document.addEventListener("DOMContentLoaded", function() {
  loadAdminDocuments();
});

function loadAdminDocuments() {
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
  var tbody = document.getElementById('docTableBody');
  var mobileCards = document.getElementById('mobileDocCardsContainer');

  if (tbody) {
    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 48px 20px; color: #64748b;"><div style="display:flex; flex-direction:column; align-items:center; gap:8px;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; color: #3b5bdb;"></i><span>Loading documents...</span></div></td></tr>';
  }
  if (mobileCards) {
    mobileCards.innerHTML = '<div style="text-align:center; padding: 36px 16px; color: #64748b; background:#fff; border-radius:12px;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 20px; color: #3b5bdb; margin-bottom: 8px;"></i><div>Loading documents...</div></div>';
  }

  // Fetch documents from endpoint
  $.ajax({
    url: pth + "View-List/Documents/Fetch_Document.php",
    type: "GET",
    dataType: "json",
    success: function(response) {
      if (response && response.status === 'success' && Array.isArray(response.data)) {
        allAdminDocs = response.data.map(function(item) {
          return {
            id: item.id || 0,
            employee_name: item.employee_name || item.employee || 'Employee',
            employee_id: item.employee_id || 'EMP-001',
            doc_type: item.doc_type || item.category || item.type || 'Document',
            file_name: item.file_name || item.title || 'document.pdf',
            file_path: item.file_path || item.url || '',
            file_size: item.file_size || item.size || '1.0 MB',
            uploaded_date: item.uploaded_date || item.uploaded || new Date().toISOString().slice(0, 10),
            status: item.status || 'uploaded'
          };
        });
      } else {
        allAdminDocs = [];
      }
      updateDocStats(allAdminDocs);
      renderAdminDocs(allAdminDocs);
    },
    error: function() {
      // Try fallback endpoint
      $.ajax({
        url: pth + "UxUi-Back/Documents/fetch_cv/fetch_cv.php",
        type: "GET",
        dataType: "json",
        success: function(fallbackRes) {
          if (fallbackRes && fallbackRes.status === 'success' && Array.isArray(fallbackRes.data)) {
            allAdminDocs = fallbackRes.data.map(function(item) {
              return {
                id: item.id || 0,
                employee_name: item.employee || 'Employee',
                employee_id: 'EMP-001',
                doc_type: item.category || item.type || 'Document',
                file_name: item.title || 'document.pdf',
                file_path: item.url || '',
                file_size: item.size || '1.0 MB',
                uploaded_date: item.uploaded || new Date().toISOString().slice(0, 10),
                status: item.status || 'uploaded'
              };
            });
          } else {
            allAdminDocs = [];
          }
          updateDocStats(allAdminDocs);
          renderAdminDocs(allAdminDocs);
        },
        error: function() {
          allAdminDocs = [];
          updateDocStats([]);
          renderAdminDocs([]);
        }
      });
    }
  });
}

function updateDocStats(docs) {
  var total = docs.length;
  var cvCount = 0;
  var idCount = 0;
  var employeesMap = {};

  docs.forEach(function(d) {
    var typeLower = (d.doc_type || '').toLowerCase();
    if (typeLower.indexOf('cv') > -1 || typeLower.indexOf('resume') > -1) {
      cvCount++;
    } else if (typeLower.indexOf('id') > -1 || typeLower.indexOf('cert') > -1 || typeLower.indexOf('nic') > -1 || typeLower.indexOf('passport') > -1) {
      idCount++;
    }
    var empKey = (d.employee_id || d.employee_name || '').trim();
    if (empKey) employeesMap[empKey] = true;
  });

  var totalEl = document.getElementById('statTotalDocs');
  var cvEl = document.getElementById('statCvDocs');
  var idEl = document.getElementById('statIdDocs');
  var empEl = document.getElementById('statEmpDocs');
  var countTextEl = document.getElementById('docCountText');

  if (totalEl) totalEl.textContent = total;
  if (cvEl) cvEl.textContent = cvCount;
  if (idEl) idEl.textContent = idCount;
  if (empEl) empEl.textContent = Object.keys(employeesMap).length;
  if (countTextEl) countTextEl.textContent = total + ' Document' + (total === 1 ? '' : 's');
}

function filterAdminDocs() {
  var searchInput = document.getElementById('docSearchInput');
  var typeSelect = document.getElementById('docTypeFilter');

  var searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
  var typeFilter = typeSelect ? typeSelect.value : 'all';

  var filtered = allAdminDocs.filter(function(doc) {
    var matchesSearch = true;
    if (searchTerm) {
      var name = (doc.employee_name || '').toLowerCase();
      var empId = (doc.employee_id || '').toLowerCase();
      var fileName = (doc.file_name || '').toLowerCase();
      var docType = (doc.doc_type || '').toLowerCase();

      matchesSearch = (name.indexOf(searchTerm) > -1 || empId.indexOf(searchTerm) > -1 || fileName.indexOf(searchTerm) > -1 || docType.indexOf(searchTerm) > -1);
    }

    var matchesType = true;
    if (typeFilter !== 'all') {
      var tLower = (doc.doc_type || '').toLowerCase();
      var fLower = typeFilter.toLowerCase();
      matchesType = (tLower.indexOf(fLower) > -1);
    }

    return matchesSearch && matchesType;
  });

  renderAdminDocs(filtered);
}

function renderAdminDocs(docs) {
  var tbody = document.getElementById('docTableBody');
  var mobileCards = document.getElementById('mobileDocCardsContainer');
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';

  if (!docs || docs.length === 0) {
    var emptyHtml = `
      <tr>
        <td colspan="5" style="text-align:center; padding: 48px 20px; color: #64748b;">
          <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
            <span style="font-weight: 700; font-size: 15px; color: #334155;">No documents found</span>
            <span style="font-size: 13px; color: #94a3b8;">No documents match the current filter or none have been uploaded yet.</span>
          </div>
        </td>
      </tr>
    `;
    if (tbody) tbody.innerHTML = emptyHtml;
    if (mobileCards) {
      mobileCards.innerHTML = `
        <div style="text-align:center; padding: 32px 16px; color: #64748b; background:#fff; border-radius:12px; border:1px solid #e8eaf0;">
          <i class="fa-regular fa-folder-open" style="font-size:32px; color:#94a3b8; margin-bottom:8px;"></i>
          <div style="font-weight:700; font-size:14px; color:#334155;">No documents found</div>
          <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Try adjusting search keywords or filter selection.</div>
        </div>
      `;
    }
    return;
  }

  if (tbody) tbody.innerHTML = '';
  if (mobileCards) mobileCards.innerHTML = '';

  docs.forEach(function(doc, idx) {
    var empName = doc.employee_name || 'Employee';
    var empId = doc.employee_id || 'EMP-001';
    var docType = doc.doc_type || 'Document';
    var fileName = doc.file_name || 'file';
    var fileSize = doc.file_size || '1.0 MB';
    var uploadDate = doc.uploaded_date ? doc.uploaded_date.substring(0, 10) : '2026-08-16';
    var status = doc.status || 'uploaded';
    var id = doc.id || 0;

    var initials = empName !== 'Employee' ? empName.split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase() : 'EM';
    
    var fileUrl = '';
    if (doc.file_path && doc.file_path.length > 0) {
      fileUrl = (doc.file_path.indexOf('http') === 0) ? doc.file_path : (pth + doc.file_path);
    } else {
      fileUrl = pth + "View-List/Documents/View_File.php?id=" + id;
    }

    var ext = (fileName || '').split('.').pop().toLowerCase();
    var extClass = 'default';
    var extIcon = '<i class="fa-solid fa-file"></i>';
    if (ext === 'pdf') {
      extClass = 'pdf';
      extIcon = '<i class="fa-solid fa-file-pdf"></i>';
    } else if (['jpg', 'jpeg', 'png', 'webp', 'gif'].indexOf(ext) > -1) {
      extClass = 'img';
      extIcon = '<i class="fa-solid fa-file-image"></i>';
    } else if (['doc', 'docx'].indexOf(ext) > -1) {
      extClass = 'doc';
      extIcon = '<i class="fa-solid fa-file-word"></i>';
    }

    var typeClass = 'other';
    var typeLower = docType.toLowerCase();
    if (typeLower.indexOf('cv') > -1 || typeLower.indexOf('resume') > -1) {
      typeClass = '';
    } else if (typeLower.indexOf('id') > -1 || typeLower.indexOf('nic') > -1 || typeLower.indexOf('passport') > -1) {
      typeClass = 'id-proof';
    } else if (typeLower.indexOf('cert') > -1 || typeLower.indexOf('degree') > -1) {
      typeClass = 'cert';
    }

    // 1. Desktop Table Row
    if (tbody) {
      var tr = document.createElement('tr');
      tr.innerHTML = `
        <td>
          <div class="emp-cell">
            <div class="emp-avatar">${initials}</div>
            <div class="emp-info">
              <span class="emp-name">${empName}</span>
              <span class="emp-id-badge">${empId}</span>
            </div>
          </div>
        </td>
        <td>
          <span class="doc-type-badge ${typeClass}">
            <i class="fa-regular fa-bookmark" style="font-size:10px;"></i> ${docType}
          </span>
        </td>
        <td>
          <div class="file-cell" title="${fileName}">
            <div class="file-ext-icon ${extClass}">${extIcon}</div>
            <div class="file-meta">
              <span class="file-name">${fileName}</span>
              <span class="file-size">${fileSize}</span>
            </div>
          </div>
        </td>
        <td>
          <span style="color:#475569; font-weight:600; font-size:13px;">${uploadDate}</span>
        </td>
        <td class="col-actions" style="text-align: center; vertical-align: middle;">
          <div class="row-actions" style="display:flex; align-items:center; justify-content:center; margin:0 auto; gap:6px;">
            <button type="button" class="action-btn view" title="View Document" onclick="triggerDocPreview(${id}, '${fileUrl}', '${escapeHtml(fileName)}', '${escapeHtml(docType)}', '${escapeHtml(empName)}')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
            <a href="${fileUrl}" download="${fileName}" class="action-btn download" title="Download Document">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            </a>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    }

    // 2. Mobile Responsive Card
    if (mobileCards) {
      var cardDiv = document.createElement('div');
      cardDiv.className = 'mobile-doc-card';
      cardDiv.innerHTML = `
        <div class="mobile-doc-card-head">
          <div class="emp-cell">
            <div class="emp-avatar">${initials}</div>
            <div class="emp-info">
              <span class="emp-name">${empName}</span>
              <span class="emp-id-badge">${empId}</span>
            </div>
          </div>
          <span class="status-badge ${status}">
            <span class="status-dot"></span> ${(status.charAt(0).toUpperCase() + status.slice(1))}
          </span>
        </div>

        <div class="mobile-doc-details">
          <div class="mobile-doc-row">
            <span class="mobile-doc-label">Type:</span>
            <span class="doc-type-badge ${typeClass}">${docType}</span>
          </div>
          <div class="mobile-doc-row">
            <span class="mobile-doc-label">File:</span>
            <span class="mobile-doc-val" style="max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${fileName}</span>
          </div>
          <div class="mobile-doc-row">
            <span class="mobile-doc-label">Date:</span>
            <span class="mobile-doc-val">${uploadDate}</span>
          </div>
        </div>

        <div class="mobile-doc-actions">
          <button type="button" class="btn-mobile-action view" onclick="triggerDocPreview(${id}, '${fileUrl}', '${escapeHtml(fileName)}', '${escapeHtml(docType)}', '${escapeHtml(empName)}')">
            <i class="fa-solid fa-eye"></i> View
          </button>
          <a href="${fileUrl}" download="${fileName}" class="btn-mobile-action download">
            <i class="fa-solid fa-download"></i> Download
          </a>
        </div>
      `;
      mobileCards.appendChild(cardDiv);
    }
  });
}

function escapeHtml(text) {
  if (!text) return '';
  return text.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

function triggerDocPreview(id, url, fileName, docType, empName) {
  var modal = document.getElementById('viewDocModal');
  var loader = document.getElementById('docViewerLoader');
  var imgContainer = document.getElementById('imageViewerContainer');
  var imgPreview = document.getElementById('docImagePreview');
  var pdfCanvas = document.getElementById('pdfCanvasPagesContainer');
  var iframe = document.getElementById('cvIframeViewer');

  var heading = document.getElementById('viewDocHeaderTitle');
  var subTitle = document.getElementById('viewDocSubTitle');
  var icon = document.getElementById('viewDocTypeIcon');
  var openTabBtn = document.getElementById('viewDocOpenTab');
  var downloadBtn = document.getElementById('viewDocDownloadBtn');
  var metaFooter = document.getElementById('viewDocMetaFooter');

  if (heading) heading.innerText = fileName || 'Document Viewer';
  if (subTitle) subTitle.innerText = (empName ? empName + ' • ' : '') + (docType || 'Document');
  if (openTabBtn) openTabBtn.href = url;
  if (downloadBtn) {
    downloadBtn.href = url;
    downloadBtn.setAttribute('download', fileName || 'document');
  }
  if (metaFooter) metaFooter.innerText = fileName + ' (' + docType + ')';

  var ext = (fileName || url).split('.').pop().toLowerCase();
  var isImage = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'].indexOf(ext) > -1;

  // Reset viewer containers
  if (imgContainer) imgContainer.style.display = 'none';
  if (pdfCanvas) {
    pdfCanvas.style.display = 'none';
    pdfCanvas.innerHTML = '';
  }
  if (iframe) iframe.style.display = 'none';
  if (loader) loader.style.display = 'block';

  if (modal) modal.classList.add('active');

  if (isImage) {
    if (icon) icon.innerHTML = '<i class="fa-solid fa-image" style="color: #12b76a;"></i>';
    if (imgPreview) {
      imgPreview.onload = function() {
        if (loader) loader.style.display = 'none';
        if (imgContainer) imgContainer.style.display = 'flex';
      };
      imgPreview.onerror = function() {
        if (loader) loader.style.display = 'none';
        if (iframe) {
          iframe.src = url;
          iframe.style.display = 'block';
        }
      };
      imgPreview.src = url;
    }
  } else {
    // PDF rendering via PDF.js or Fallback iframe
    if (icon) icon.innerHTML = '<i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i>';

    if (typeof pdfjsLib !== 'undefined') {
      var loadingTask = pdfjsLib.getDocument(url);
      loadingTask.promise.then(function(pdf) {
        if (loader) loader.style.display = 'none';
        if (pdfCanvas) pdfCanvas.style.display = 'flex';

        for (var pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
          renderPdfPageCard(pdf, pageNum, pdfCanvas);
        }
      }).catch(function(err) {
        console.warn('PDF.js render error, fallback to iframe:', err);
        if (loader) loader.style.display = 'none';
        if (iframe) {
          iframe.src = url;
          iframe.style.display = 'block';
        }
      });
    } else {
      if (loader) loader.style.display = 'none';
      if (iframe) {
        iframe.src = url;
        iframe.style.display = 'block';
      }
    }
  }
}

function renderPdfPageCard(pdf, pageNum, container) {
  pdf.getPage(pageNum).then(function(page) {
    var isMobile = window.innerWidth <= 640;
    var scale = isMobile ? 1.2 : 1.6;
    var viewport = page.getViewport({ scale: scale });

    var pageCard = document.createElement('div');
    pageCard.style.cssText = 'background: #ffffff; box-shadow: 0 4px 16px rgba(0,0,0,0.12); border-radius: 8px; overflow: hidden; width: 100%; max-width: 820px; display: flex; flex-direction: column; align-items: center;';

    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;
    canvas.style.width = '100%';
    canvas.style.height = 'auto';
    canvas.style.display = 'block';

    pageCard.appendChild(canvas);
    container.appendChild(pageCard);

    page.render({ canvasContext: ctx, viewport: viewport });
  });
}

function closeDocumentViewer() {
  var modal = document.getElementById('viewDocModal');
  var imgPreview = document.getElementById('docImagePreview');
  var pdfCanvas = document.getElementById('pdfCanvasPagesContainer');
  var iframe = document.getElementById('cvIframeViewer');

  if (iframe) iframe.src = '';
  if (imgPreview) imgPreview.src = '';
  if (pdfCanvas) pdfCanvas.innerHTML = '';
  if (modal) modal.classList.remove('active');
}

function deleteAdminDocument(id) {
  if (!confirm('Are you sure you want to permanently delete this document?')) {
    return;
  }

  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';

  $.ajax({
    url: pth + "View-List/Documents/Delete_Document.php",
    type: "POST",
    data: { id: id },
    dataType: "json",
    success: function(res) {
      if (res && res.status === 'success') {
        loadAdminDocuments();
      } else {
        // Fallback to Documents module delete
        $.ajax({
          url: pth + "UxUi-Back/Documents/delete_cv/delete_cv.php",
          type: "POST",
          data: { id: id },
          dataType: "json",
          success: function(fallbackRes) {
            loadAdminDocuments();
          },
          error: function() {
            allAdminDocs = allAdminDocs.filter(function(d) { return d.id !== id; });
            updateDocStats(allAdminDocs);
            renderAdminDocs(allAdminDocs);
          }
        });
      }
    },
    error: function() {
      allAdminDocs = allAdminDocs.filter(function(d) { return d.id !== id; });
      updateDocStats(allAdminDocs);
      renderAdminDocs(allAdminDocs);
    }
  });
}

function toggleAdminDocFileInputs(cat) {
  var singleWrap = document.getElementById('adminSinglePdfWrap');
  var pngWrap = document.getElementById('adminNationalIdPngWrap');
  var singleInput = document.getElementById('adminUploadFile');
  var frontInput = document.getElementById('adminUploadFileFront');
  var backInput = document.getElementById('adminUploadFileBack');

  if (cat === 'National ID') {
    if (singleWrap) singleWrap.style.display = 'none';
    if (pngWrap) pngWrap.style.display = 'flex';
    if (singleInput) singleInput.value = '';
  } else {
    if (singleWrap) singleWrap.style.display = 'flex';
    if (pngWrap) pngWrap.style.display = 'none';
    if (frontInput) frontInput.value = '';
    if (backInput) backInput.value = '';
  }
}

function openAdminUploadModal() {
  var modal = document.getElementById('adminUploadDocModal');
  if (modal) {
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    var catSelect = document.getElementById('adminUploadCategory');
    if (catSelect) toggleAdminDocFileInputs(catSelect.value);
  }
}

function closeAdminUploadModal() {
  var modal = document.getElementById('adminUploadDocModal');
  if (modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
    var form = document.getElementById('adminUploadDocForm');
    if (form) form.reset();
  }
}

function submitAdminDocUpload(e) {
  e.preventDefault();
  var form = document.getElementById('adminUploadDocForm');
  var catSelect = document.getElementById('adminUploadCategory');
  var category = catSelect ? catSelect.value : 'CV';

  if (category === 'National ID') {
    var frontInput = document.getElementById('adminUploadFileFront');
    var backInput = document.getElementById('adminUploadFileBack');
    var hasFront = frontInput && frontInput.files && frontInput.files[0];
    var hasBack = backInput && backInput.files && backInput.files[0];

    if (!hasFront && !hasBack) {
      alert('Please select at least one National ID PNG image (Front or Back) to upload.');
      return;
    }
  } else {
    var fileInput = document.getElementById('adminUploadFile');
    if (!fileInput || !fileInput.files || !fileInput.files[0]) {
      alert('Please select a PDF document file to upload.');
      return;
    }
  }

  var btn = document.getElementById('btnAdminUploadSubmit');
  var originalText = btn ? btn.innerHTML : 'Upload & Save';
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading...';
  }

  var formData = new FormData(form);
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';

  $.ajax({
    url: pth + "View-List/Documents/Upload_Document.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function(res) {
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = originalText;
      }
      if (res && res.status === 'success') {
        alert('Document(s) uploaded and saved to database successfully!');
        closeAdminUploadModal();
        loadAdminDocuments();
      } else {
        alert('Upload failed: ' + (res.message || 'Error occurred.'));
      }
    },
    error: function() {
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = originalText;
      }
      alert('Server error during document upload.');
    }
  });
}

window.loadAdminDocuments = loadAdminDocuments;
window.filterAdminDocs = filterAdminDocs;
window.triggerDocPreview = triggerDocPreview;
window.closeDocumentViewer = closeDocumentViewer;
window.deleteAdminDocument = deleteAdminDocument;
window.openAdminUploadModal = openAdminUploadModal;
window.closeAdminUploadModal = closeAdminUploadModal;
window.submitAdminDocUpload = submitAdminDocUpload;
window.toggleAdminDocFileInputs = toggleAdminDocFileInputs;

// =====================================================
// DOCUMENT REQUESTS — Admin Side
// =====================================================
var _showingRequests = false;

window.toggleRequestsView = function() {
  _showingRequests = !_showingRequests;
  var docsSection   = document.querySelector('.doc-table-wrap, .doc-main-card .doc-table-wrap');
  var mobileSection = document.getElementById('mobileDocCardsContainer');
  var reqSection    = document.getElementById('adminDocRequestsSection');
  var docMainCard   = document.querySelector('#Admin_user_dashboard_03_documents .doc-main-card');
  var btn           = document.getElementById('btnToggleRequests');

  if (_showingRequests) {
    // Hide uploaded docs, show requests
    if (docMainCard) {
      // Hide children except the toolbar and the requests section
      Array.from(docMainCard.children).forEach(function(ch) {
        if (ch.id !== 'adminDocRequestsSection' && !ch.classList.contains('doc-toolbar')) {
          ch.style.display = 'none';
        }
      });
    }
    if (reqSection) reqSection.style.display = 'block';
    if (btn) { btn.style.background = 'linear-gradient(135deg,#4f46e5,#6366f1)'; }
    loadDocumentRequests();
  } else {
    if (docMainCard) {
      Array.from(docMainCard.children).forEach(function(ch) {
        if (ch.id !== 'adminDocRequestsSection') {
          ch.style.display = '';
        }
      });
    }
    if (reqSection) reqSection.style.display = 'none';
    if (btn) { btn.style.background = 'linear-gradient(135deg,#6366f1,#4f46e5)'; }
  }
};

window.loadDocumentRequests = function() {
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
  var tbody = document.getElementById('reqTableBody');
  var mobileCards = document.getElementById('reqMobileCards');
  if (tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px; color:#64748b;"><i class="fa-solid fa-spinner fa-spin"></i> Loading...</td></tr>';

  $.ajax({
    url: pth + 'View-List/Documents/Fetch_Document_Requests.php?for=admin',
    type: 'GET',
    dataType: 'json',
    success: function(res) {
      if (res && res.status === 'success' && Array.isArray(res.data)) {
        renderDocumentRequests(res.data, pth);
        // Update pending badge
        var pending = res.data.filter(function(r){ return r.status === 'Pending' || r.status === 'Uploaded'; }).length;
        var badge = document.getElementById('reqPendingBadge');
        if (badge) {
          badge.textContent = pending;
          badge.style.display = pending > 0 ? 'inline-block' : 'none';
        }
      } else {
        if (tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px; color:#64748b;">No requests found.</td></tr>';
      }
    },
    error: function() {
      if (tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px; color:#e53e3e;">Failed to load requests.</td></tr>';
    }
  });
};

function statusBadge(s) {
  var map = {
    'Pending':  { bg:'#fdf1dc', color:'#c27f0e', icon:'fa-clock' },
    'Uploaded': { bg:'#dbe4ff', color:'#3b5bdb', icon:'fa-upload' },
    'Approved': { bg:'#e3f9ee', color:'#12b76a', icon:'fa-circle-check' },
    'Ignored':  { bg:'#f1f5f9', color:'#64748b', icon:'fa-ban' }
  };
  var m = map[s] || { bg:'#f1f5f9', color:'#64748b', icon:'fa-circle' };
  return '<span style="display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:999px; background:'+m.bg+'; color:'+m.color+'; font-size:11.5px; font-weight:700;"><i class="fa-solid '+m.icon+'"></i> '+s+'</span>';
}

function reqActions(row, pth) {
  var btns = '';
  if (row.status === 'Uploaded' || row.status === 'Approved') {
    var url = pth + (row.file_path || '');
    btns += '<button onclick="triggerDocPreview(\''+url+'\', \''+row.doc_type+'\', \''+row.target_employee_name+'\')" style="padding:5px 10px; border:none; border-radius:6px; background:#eef2ff; color:#3b5bdb; font-size:11.5px; font-weight:700; cursor:pointer; margin-right:4px;" title="View File"><i class="fa-solid fa-eye"></i></button>';
  }
  if (row.status === 'Uploaded') {
    btns += '<button onclick="approveDocRequest('+row.id+')" style="padding:5px 10px; border:none; border-radius:6px; background:#e3f9ee; color:#12b76a; font-size:11.5px; font-weight:700; cursor:pointer; margin-right:4px;" title="Approve"><i class="fa-solid fa-circle-check"></i> Approve</button>';
    btns += '<button onclick="ignoreDocRequest('+row.id+')" style="padding:5px 10px; border:none; border-radius:6px; background:#f1f5f9; color:#64748b; font-size:11.5px; font-weight:700; cursor:pointer;" title="Ignore"><i class="fa-solid fa-ban"></i> Ignore</button>';
  }
  if (row.status === 'Pending') {
    btns += '<button onclick="ignoreDocRequest('+row.id+')" style="padding:5px 10px; border:none; border-radius:6px; background:#f1f5f9; color:#64748b; font-size:11.5px; font-weight:700; cursor:pointer;" title="Cancel Request"><i class="fa-solid fa-xmark"></i> Cancel</button>';
  }
  return btns || '<span style="color:#94a3b8; font-size:11.5px;">—</span>';
}

function renderDocumentRequests(data, pth) {
  var tbody = document.getElementById('reqTableBody');
  var mobileCards = document.getElementById('reqMobileCards');
  var isMobile = window.innerWidth <= 768;

  if (!data || data.length === 0) {
    if (tbody) tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:48px; color:#64748b;"><div style="display:flex;flex-direction:column;align-items:center;gap:8px;"><i class="fa-solid fa-inbox" style="font-size:28px; color:#cbd5e1;"></i><span>No document requests yet.</span></div></td></tr>';
    if (mobileCards) mobileCards.innerHTML = '<div style="text-align:center; padding:30px; background:#fff; border-radius:12px; color:#64748b;">No requests found.</div>';
    return;
  }

  // Desktop
  if (tbody) {
    tbody.innerHTML = data.map(function(r) {
      var dl = r.deadline ? r.deadline.slice(0,10) : '—';
      return '<tr>' +
        '<td><div style="font-weight:700; color:#1e293b; font-size:12.5px;">'+r.target_employee_name+'</div><div style="font-size:11px; color:#64748b;">by '+r.requested_by_name+'</div></td>' +
        '<td><span style="font-weight:600; color:#1e293b; font-size:12.5px;">'+r.doc_type+'</span></td>' +
        '<td style="font-size:12px; color:#64748b;">'+r.sdt.slice(0,10)+'</td>' +
        '<td style="font-size:12px; color:'+(r.deadline?'#c27f0e':'#94a3b8')+';">'+dl+'</td>' +
        '<td>'+statusBadge(r.status)+'</td>' +
        '<td><div style="display:flex; align-items:center; gap:4px; flex-wrap:wrap;">'+reqActions(r, pth)+'</div></td>' +
        '</tr>';
    }).join('');
  }

  // Mobile cards
  if (mobileCards) {
    mobileCards.innerHTML = data.map(function(r) {
      return '<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,.04);">' +
        '<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">' +
          '<div><div style="font-weight:800; color:#1e293b; font-size:13.5px;">'+r.target_employee_name+'</div>' +
          '<div style="font-size:11.5px; color:#64748b; margin-top:2px;">'+r.doc_type+' — Requested by '+r.requested_by_name+'</div></div>' +
          statusBadge(r.status) +
        '</div>' +
        (r.notes ? '<div style="background:#f8fafc; border-radius:8px; padding:8px 10px; font-size:12px; color:#64748b; margin-bottom:8px; font-style:italic;">"'+r.notes+'"</div>' : '') +
        (r.deadline ? '<div style="font-size:11.5px; color:#c27f0e; margin-bottom:8px;"><i class="fa-regular fa-calendar"></i> Deadline: '+r.deadline.slice(0,10)+'</div>' : '') +
        '<div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">'+reqActions(r, pth)+'</div>' +
        '</div>';
    }).join('');
    mobileCards.style.display = 'flex';
  }
}

window.approveDocRequest = function(id) {
  if (!confirm('✅ Approve this document submission?')) return;
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
  var fd = new FormData();
  fd.append('request_id', id);
  fd.append('action', 'approve');
  fetch(pth + 'View-List/Documents/Approve_Document_Request.php', { method:'POST', body:fd, credentials:'same-origin' })
    .then(function(r){ return r.json(); })
    .then(function(res) {
      if (res && res.status === 'success') { loadDocumentRequests(); }
      else { alert('❌ ' + (res.message || 'Failed to approve.')); }
    });
};

window.ignoreDocRequest = function(id) {
  if (!confirm('Cancel / Ignore this request?')) return;
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
  var fd = new FormData();
  fd.append('request_id', id);
  fd.append('action', 'ignore');
  fetch(pth + 'View-List/Documents/Approve_Document_Request.php', { method:'POST', body:fd, credentials:'same-origin' })
    .then(function(r){ return r.json(); })
    .then(function(res) {
      if (res && res.status === 'success') { loadDocumentRequests(); }
      else { alert('❌ ' + (res.message || 'Failed.')); }
    });
};

window.toggleReqTargetFields = function() {
  var ttype = document.getElementById('reqTargetType') ? document.getElementById('reqTargetType').value : 'employee';
  var empGroup  = document.getElementById('reqEmpGroup');
  var deptGroup = document.getElementById('reqDeptGroup');
  var allNotice = document.getElementById('reqAllNotice');

  if (empGroup)  empGroup.style.display  = (ttype === 'employee') ? 'block' : 'none';
  if (deptGroup) deptGroup.style.display = (ttype === 'department') ? 'block' : 'none';
  if (allNotice) allNotice.style.display = (ttype === 'all') ? 'block' : 'none';
};

window.openDocRequestModal = function() {
  var modal = document.getElementById('reqDocModal');
  if (modal) modal.style.display = 'flex';

  var ttype = document.getElementById('reqTargetType');
  if (ttype) ttype.value = 'employee';
  toggleReqTargetFields();

  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';

  // 1. Populate employee dropdown
  var sel = document.getElementById('reqEmpSelect');
  if (sel) {
    sel.innerHTML = '<option value="">-- Select Employee --</option>';
    $.ajax({
      url: pth + 'UxUi-Back/Employee/fetch_employee/fetch_employee.php',
      type: 'GET', dataType: 'json',
      success: function(res) {
        var data = Array.isArray(res) ? res : (res && Array.isArray(res.data) ? res.data : []);
        data.forEach(function(e) {
          var name = e.name || e.fullname || e.full_name || e.user_name || 'Employee';
          var uid  = e.account_id || e.user_id || e.id || '';
          var empCode = e.emp_code ? ' (' + e.emp_code + ')' : '';
          var dept = e.dept ? ' • ' + e.dept : '';
          if (uid) sel.innerHTML += '<option value="'+uid+'" data-name="'+name+'">'+name + empCode + dept +'</option>';
        });
        if (sel.options.length <= 1) sel.innerHTML += '<option disabled>No employees found</option>';
      },
      error: function() {
        sel.innerHTML = '<option value="">Failed to load employees</option>';
      }
    });
  }

  // 2. Populate departments dropdown
  var deptSel = document.getElementById('reqDeptSelect');
  if (deptSel) {
    deptSel.innerHTML = '<option value="">-- Select Department --</option>';
    $.ajax({
      url: pth + 'UxUi-Back/Departments/fetch_department/fetch_department.php',
      type: 'GET', dataType: 'json',
      success: function(res) {
        var data = Array.isArray(res) ? res : (res && Array.isArray(res.data) ? res.data : []);
        data.forEach(function(d) {
          var dName = d.name || d.department || '';
          if (dName) deptSel.innerHTML += '<option value="'+dName+'">'+dName+'</option>';
        });
        if (deptSel.options.length <= 1) {
          deptSel.innerHTML += '<option value="Engineering">Engineering</option><option value="HR">HR</option><option value="Operations">Operations</option>';
        }
      },
      error: function() {
        deptSel.innerHTML = '<option value="Engineering">Engineering</option><option value="HR">HR</option><option value="Operations">Operations</option>';
      }
    });
  }
};

window.closeDocRequestModal = function() {
  var modal = document.getElementById('reqDocModal');
  if (modal) modal.style.display = 'none';
  var err = document.getElementById('reqModalError');
  if (err) err.style.display = 'none';
};

window.submitDocumentRequest = function() {
  var ttype    = document.getElementById('reqTargetType') ? document.getElementById('reqTargetType').value : 'employee';
  var sel      = document.getElementById('reqEmpSelect');
  var deptSel  = document.getElementById('reqDeptSelect');
  var docType  = document.getElementById('reqDocType');
  var deadline = document.getElementById('reqDeadline');
  var notes    = document.getElementById('reqNotes');
  var errDiv   = document.getElementById('reqModalError');
  var btn      = document.getElementById('btnSubmitDocReq');

  var empId   = '';
  var empName = '';

  if (ttype === 'employee') {
    empId   = sel ? sel.value : '';
    empName = sel && sel.selectedOptions[0] ? sel.selectedOptions[0].getAttribute('data-name') : '';
    if (!empId) {
      errDiv.textContent = 'Please select an employee.';
      errDiv.style.display = 'block';
      return;
    }
  } else if (ttype === 'department') {
    empName = deptSel ? deptSel.value : '';
    if (!empName) {
      errDiv.textContent = 'Please select a department.';
      errDiv.style.display = 'block';
      return;
    }
  } else if (ttype === 'all') {
    empName = 'All Employees';
  }

  var dType = docType ? docType.value : '';
  if (!dType) {
    errDiv.textContent = 'Please select a document type.';
    errDiv.style.display = 'block';
    return;
  }
  errDiv.style.display = 'none';
  if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...'; }

  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
  var fd = new FormData();
  fd.append('target_type', ttype);
  fd.append('target_employee_user_id', empId);
  fd.append('target_employee_name', empName);
  fd.append('doc_type', dType);
  fd.append('deadline', deadline ? deadline.value : '');
  fd.append('notes', notes ? notes.value : '');

  fetch(pth + 'View-List/Documents/Create_Document_Request.php', { method:'POST', body:fd, credentials:'same-origin' })
    .then(function(r){ return r.json(); })
    .then(function(res) {
      if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Request'; }
      if (res && res.status === 'success') {
        closeDocRequestModal();
        if (!_showingRequests) toggleRequestsView();
        else loadDocumentRequests();
        if (notes) notes.value = '';
        if (deadline) deadline.value = '';
      } else {
        errDiv.textContent = res.message || 'Failed to send request.';
        errDiv.style.display = 'block';
      }
    })
    .catch(function() {
      if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Request'; }
      errDiv.textContent = 'Network error. Please try again.';
    });
};

// Auto-load pending badge count on page load
document.addEventListener('DOMContentLoaded', function() {
  var pth = typeof window.pth !== 'undefined' ? window.pth : '../';
  $.ajax({
    url: pth + 'View-List/Documents/Fetch_Document_Requests.php?for=admin',
    type: 'GET', dataType: 'json',
    success: function(res) {
      if (res && res.status === 'success' && Array.isArray(res.data)) {
        var pending = res.data.filter(function(r){ return r.status === 'Pending' || r.status === 'Uploaded'; }).length;
        var badge = document.getElementById('reqPendingBadge');
        if (badge && pending > 0) { badge.textContent = pending; badge.style.display = 'inline-block'; }
      }
    }
  });
});

</script>