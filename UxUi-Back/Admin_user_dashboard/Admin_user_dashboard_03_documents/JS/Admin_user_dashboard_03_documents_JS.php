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
        <td>
          <div class="row-actions">
            <button type="button" class="action-btn view" title="View Document" onclick="triggerDocPreview(${id}, '${fileUrl}', '${escapeHtml(fileName)}', '${escapeHtml(docType)}', '${escapeHtml(empName)}')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
            <a href="${fileUrl}" download="${fileName}" class="action-btn download" title="Download Document">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            </a>
            <button type="button" class="action-btn delete" title="Delete Document" onclick="deleteAdminDocument(${id})">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
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
          <button type="button" class="btn-mobile-action delete" title="Delete" onclick="deleteAdminDocument(${id})">
            <i class="fa-solid fa-trash"></i>
          </button>
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

window.loadAdminDocuments = loadAdminDocuments;
window.filterAdminDocs = filterAdminDocs;
window.triggerDocPreview = triggerDocPreview;
window.closeDocumentViewer = closeDocumentViewer;
window.deleteAdminDocument = deleteAdminDocument;
</script>