<style>
  /* =========================================================
     EMPLOYEE DOCUMENTS (RESPONSIVE WITH MOBILE-OPTIMIZED VIEWER)
  ========================================================= */
  .docs-wrapper {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
  }

  .docs-page-head {
    margin-bottom: 20px;
  }

  .docs-page-head h1 {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy, #14204d);
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
  }

  .docs-page-head p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
  }

  /* Grid of Document Upload Cards */
  .docs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    width: 100%;
    margin-bottom: 24px;
  }

  .doc-upload-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 22px 24px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .doc-upload-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(20, 25, 60, 0.07);
  }

  .doc-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
  }

  .doc-card-head h4 {
    font-size: 15.5px;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
  }

  .doc-status-tag {
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
  }

  .doc-status-tag.not-uploaded {
    background: #f1f5f9;
    color: #64748b;
  }

  .doc-status-tag.uploaded {
    background: #e3f9ee;
    color: #12b76a;
  }

  .doc-desc {
    font-size: 13px;
    color: #64748b;
    margin: 0 0 14px 0;
  }

  /* Drop Zone */
  .doc-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 20px 16px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-bottom: 14px;
  }

  .doc-dropzone:hover, .doc-dropzone.dragover {
    border-color: #3b5bdb;
    background: #eff6ff;
  }

  .doc-dropzone svg, .doc-dropzone i {
    font-size: 26px;
    color: #3b5bdb;
    margin-bottom: 2px;
  }

  .doc-dropzone .drop-title {
    font-weight: 700;
    font-size: 13.5px;
    color: #1e293b;
  }

  .doc-dropzone .drop-hint {
    font-size: 11.5px;
    color: #94a3b8;
  }

  /* Selected File Info Box */
  .doc-file-info {
    display: none;
    align-items: center;
    justify-content: space-between;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 14px;
  }

  .doc-file-left {
    display: flex;
    align-items: center;
    gap: 10px;
    overflow: hidden;
  }

  .doc-file-left svg, .doc-file-left i {
    color: #16a34a;
    font-size: 18px;
    flex-shrink: 0;
  }

  .doc-file-name {
    font-size: 13px;
    font-weight: 700;
    color: #15803d;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
  }

  .doc-file-size {
    font-size: 11.5px;
    color: #4ade80;
    font-weight: 600;
  }

  /* Action Buttons Row */
  .doc-actions-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 6px;
  }

  .btn-doc-save {
    flex: 1;
    background: #14204d;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    padding: 10px 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .btn-doc-save:hover {
    background: #1c2b63;
  }

  .btn-doc-view {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #dbeafe;
    font-size: 13px;
    font-weight: 700;
    border-radius: 8px;
    padding: 10px 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .btn-doc-view:hover {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .btn-doc-view:disabled {
    opacity: 0.45;
    cursor: not-allowed;
  }

  /* Responsive Modal Layout */
  .doc-modal-overlay {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.8);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 12px;
    box-sizing: border-box;
    backdrop-filter: blur(4px);
  }

  .doc-modal-box {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 940px;
    height: 90vh;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
  }

  @media (max-width: 900px) {
    .docs-grid {
      grid-template-columns: 1fr !important;
      gap: 16px !important;
    }
  }

  @media (max-width: 640px) {
    .doc-modal-overlay {
      padding: 0 !important;
    }
    .doc-modal-box {
      width: 100% !important;
      height: 100% !important;
      max-height: 100% !important;
      border-radius: 0 !important;
    }
  }
</style>

<div id="Employee_user_dashboard_04_documents" class="emp-main" style="display:none; padding:0;">
  <div class="docs-container" style="width:100%; box-sizing:border-box;">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_04" aria-label="Open menu" onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Documents</h2>
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
          <div class="avatar" id="topAvatarDocPreview">--</div>
          <span id="topEmpDocName">Loading...</span>
        </div>
      </div>
    </div>

    <div class="docs-wrapper w3-container" style="padding: 0;">

      <!-- Page Head -->
      <div class="docs-page-head">
        <p>Upload and manage your required employment documents</p>
      </div>

      <!-- Grid of 5 Upload Cards -->
      <div class="docs-grid">

        <!-- 1. CV Upload Card -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_cv" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>Curriculum Vitae (CV)</h4>
              <span class="doc-status-tag not-uploaded" id="tag_cv">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload your updated resume or CV.</p>

            <input type="file" id="fileInput_cv" accept=".pdf,.doc,.docx,.png,.jpg" style="display:none;" onchange="previewDocFile(this, 'cv')">

            <div class="doc-dropzone" onclick="document.getElementById('fileInput_cv').click();">
              <i class="fa-solid fa-cloud-arrow-up"></i>
              <span class="drop-title">Drag & drop or click to browse</span>
              <span class="drop-hint">PDF, DOC, PNG up to 10MB</span>
            </div>

            <div class="doc-file-info" id="info_cv">
              <div class="doc-file-left">
                <i class="fa-solid fa-file-circle-check"></i>
                <div>
                  <div class="doc-file-name" id="name_cv">document.pdf</div>
                  <div class="doc-file-size" id="size_cv">2.4 MB</div>
                </div>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_cv" onclick="saveEmployeeDoc('cv', 'CV')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save Document</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_cv" onclick="viewEmployeeDoc('cv', 'CV')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
          </div>
        </div>

        <!-- 2. National ID / Passport -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_id" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>National ID / Passport</h4>
              <span class="doc-status-tag not-uploaded" id="tag_id">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload front & back scan of your NIC or Passport.</p>

            <input type="file" id="fileInput_id" accept=".pdf,.doc,.docx,.png,.jpg" style="display:none;" onchange="previewDocFile(this, 'id')">

            <div class="doc-dropzone" onclick="document.getElementById('fileInput_id').click();">
              <i class="fa-solid fa-id-card"></i>
              <span class="drop-title">Drag & drop or click to browse</span>
              <span class="drop-hint">PDF, PNG, JPG up to 10MB</span>
            </div>

            <div class="doc-file-info" id="info_id">
              <div class="doc-file-left">
                <i class="fa-solid fa-file-circle-check"></i>
                <div>
                  <div class="doc-file-name" id="name_id">nic_scan.pdf</div>
                  <div class="doc-file-size" id="size_id">1.2 MB</div>
                </div>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_id" onclick="saveEmployeeDoc('id', 'National ID')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save Document</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_id" onclick="viewEmployeeDoc('id', 'National ID')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
          </div>
        </div>

        <!-- 3. Employment Agreement -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_agreement" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>Employment Agreement</h4>
              <span class="doc-status-tag not-uploaded" id="tag_agreement">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload signed employment contract or agreement copy.</p>

            <input type="file" id="fileInput_agreement" accept=".pdf,.doc,.docx,.png,.jpg" style="display:none;" onchange="previewDocFile(this, 'agreement')">

            <div class="doc-dropzone" onclick="document.getElementById('fileInput_agreement').click();">
              <i class="fa-solid fa-file-signature"></i>
              <span class="drop-title">Drag & drop or click to browse</span>
              <span class="drop-hint">PDF, DOC up to 10MB</span>
            </div>

            <div class="doc-file-info" id="info_agreement">
              <div class="doc-file-left">
                <i class="fa-solid fa-file-circle-check"></i>
                <div>
                  <div class="doc-file-name" id="name_agreement">agreement.pdf</div>
                  <div class="doc-file-size" id="size_agreement">3.1 MB</div>
                </div>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_agreement" onclick="saveEmployeeDoc('agreement', 'Agreement')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save Document</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_agreement" onclick="viewEmployeeDoc('agreement', 'Agreement')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
          </div>
        </div>

        <!-- 4. Grama Sevaka Certificate -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_grama" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>Grama Sevaka Certificate</h4>
              <span class="doc-status-tag not-uploaded" id="tag_grama">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload certificate issued by your Grama Niladhari.</p>

            <input type="file" id="fileInput_grama" accept=".pdf,.doc,.docx,.png,.jpg" style="display:none;" onchange="previewDocFile(this, 'grama')">

            <div class="doc-dropzone" onclick="document.getElementById('fileInput_grama').click();">
              <i class="fa-solid fa-stamp"></i>
              <span class="drop-title">Drag & drop or click to browse</span>
              <span class="drop-hint">PDF, PNG, JPG up to 10MB</span>
            </div>

            <div class="doc-file-info" id="info_grama">
              <div class="doc-file-left">
                <i class="fa-solid fa-file-circle-check"></i>
                <div>
                  <div class="doc-file-name" id="name_grama">grama_cert.pdf</div>
                  <div class="doc-file-size" id="size_grama">950 KB</div>
                </div>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_grama" onclick="saveEmployeeDoc('grama', 'Grama Sevaka Certificate')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save Document</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_grama" onclick="viewEmployeeDoc('grama', 'Grama Sevaka Certificate')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
          </div>
        </div>

        <!-- 5. Police Report -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_police" data-doc-id="0" style="grid-column: 1 / -1;">
          <div>
            <div class="doc-card-head">
              <h4>Police Clearance Report</h4>
              <span class="doc-status-tag not-uploaded" id="tag_police">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload your valid Police Clearance Certificate.</p>

            <input type="file" id="fileInput_police" accept=".pdf,.doc,.docx,.png,.jpg" style="display:none;" onchange="previewDocFile(this, 'police')">

            <div class="doc-dropzone" onclick="document.getElementById('fileInput_police').click();">
              <i class="fa-solid fa-shield-halved"></i>
              <span class="drop-title">Drag & drop or click to browse</span>
              <span class="drop-hint">PDF, PNG, JPG up to 10MB</span>
            </div>

            <div class="doc-file-info" id="info_police">
              <div class="doc-file-left">
                <i class="fa-solid fa-file-circle-check"></i>
                <div>
                  <div class="doc-file-name" id="name_police">police_report.pdf</div>
                  <div class="doc-file-size" id="size_police">1.8 MB</div>
                </div>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_police" onclick="saveEmployeeDoc('police', 'Police Report')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save Document</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_police" onclick="viewEmployeeDoc('police', 'Police Report')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
          </div>
        </div>

      </div>

    </div>

    <!-- Responsive Employee Document Viewer Modal -->
    <div class="doc-modal-overlay" id="empViewDocModal">
      <div class="doc-modal-box">
        
        <div style="flex-shrink: 0; padding: 12px 18px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #ffffff;">
          <div style="display: flex; align-items: center; gap: 10px; overflow: hidden;">
            <div id="empDocTypeIcon" style="width: 34px; height: 34px; border-radius: 8px; background: #eef2ff; color: #3b5bdb; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
              <i class="fa-solid fa-file-lines"></i>
            </div>
            <div style="overflow: hidden;">
              <h3 id="empViewDocTitle" style="font-size: 15px; font-weight: 800; color: #1e293b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Document Preview</h3>
              <span id="empViewDocSub" style="font-size: 12px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">View Document</span>
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
            <a id="empViewDocOpenTab" href="#" target="_blank" style="background: #f1f5f9; color: #475569; font-size: 12px; font-weight: 700; padding: 7px 12px; border-radius: 8px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
              <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Tab
            </a>
            <a id="empViewDocDownload" href="#" download style="background: #e6f4ea; color: #12b76a; font-size: 12px; font-weight: 700; padding: 7px 12px; border-radius: 8px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
              <i class="fa-solid fa-download"></i> Download
            </a>
            <button type="button" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #64748b; padding: 0 4px; line-height: 1;" onclick="closeEmpDocumentViewer()">&times;</button>
          </div>
        </div>

        <div style="flex: 1; padding: 0; overflow-y: auto; height: 100%; background: #f1f5f9; position: relative;">
          
          <div id="empDocLoader" style="display:none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size: 36px; color: #3b5bdb; margin-bottom: 8px;"></i>
            <div style="font-size: 13.5px; font-weight: 700; color: #475569;">Rendering document preview...</div>
          </div>

          <!-- Direct Image Viewer -->
          <div id="empImageViewContainer" style="display:none; width: 100%; min-height: 100%; padding: 20px; box-sizing: border-box; display: flex; align-items: center; justify-content: center;">
            <img id="empDocImage" src="" alt="Document Image" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 18px rgba(0,0,0,0.12); object-fit: contain; background: #fff;">
          </div>

          <!-- PDF Canvas Pages Container -->
          <div id="empPdfCanvasPages" style="display:none; width: 100%; padding: 16px; box-sizing: border-box; display: flex; flex-direction: column; align-items: center; gap: 16px;"></div>

          <!-- Fallback iframe -->
          <iframe id="empDocIframe" src="" style="display:none; width: 100%; height: 100%; min-height: 520px; border: none; background: #fff;"></iframe>

        </div>

        <div style="flex-shrink: 0; padding: 10px 18px; background-color: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
          <button type="button" style="background: #e2e8f0; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; cursor: pointer; color: #475569; font-size: 13px;" onclick="closeEmpDocumentViewer()">Close</button>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Load PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script>
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

  var empUploadedDocs = {};

  document.addEventListener("DOMContentLoaded", function() {
    loadUploadedEmployeeDocs();
  });

  function loadUploadedEmployeeDocs() {
    var pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
    $.ajax({
      url: pth + "View-List/Documents/Fetch_Document.php",
      type: "GET",
      data: { employee_id: "EMP-002" },
      dataType: "json",
      success: function(res) {
        if (res && res.status === 'success' && res.data && res.data.length > 0) {
          res.data.forEach(function(doc) {
            var key = '';
            var type = (doc.doc_type || '').toLowerCase();
            if (type.indexOf('cv') > -1 || type.indexOf('resume') > -1) key = 'cv';
            else if (type.indexOf('id') > -1 || type.indexOf('passport') > -1 || type.indexOf('nic') > -1) key = 'id';
            else if (type.indexOf('agree') > -1) key = 'agreement';
            else if (type.indexOf('grama') > -1) key = 'grama';
            else if (type.indexOf('police') > -1) key = 'police';

            if (key) {
              empUploadedDocs[key] = doc;
              var card = document.getElementById('docCard_' + key);
              var tag = document.getElementById('tag_' + key);
              var info = document.getElementById('info_' + key);
              var name = document.getElementById('name_' + key);
              var size = document.getElementById('size_' + key);
              var viewBtn = document.getElementById('btnView_' + key);

              if (card && doc.id) card.setAttribute('data-doc-id', doc.id);
              if (tag) {
                tag.className = 'doc-status-tag uploaded';
                tag.innerText = doc.status || 'Uploaded';
              }
              if (info) info.style.display = 'flex';
              if (name) name.innerText = doc.file_name || 'document';
              if (size) size.innerText = doc.file_size || '';
              if (viewBtn) viewBtn.disabled = false;
            }
          });
        }
      }
    });
  }

  function previewDocFile(input, key) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];

    var info = document.getElementById('info_' + key);
    var name = document.getElementById('name_' + key);
    var size = document.getElementById('size_' + key);

    var formattedSize = (file.size >= 1048576) 
      ? (file.size / 1048576).toFixed(2) + ' MB' 
      : (file.size / 1024).toFixed(1) + ' KB';

    if (info) info.style.display = 'flex';
    if (name) name.innerText = file.name;
    if (size) size.innerText = formattedSize;
  }

  function saveEmployeeDoc(key, docType) {
    var input = document.getElementById('fileInput_' + key);
    if (!input.files || !input.files[0]) {
      alert('Please select a file to upload first.');
      input.click();
      return;
    }

    var file = input.files[0];
    var formData = new FormData();
    formData.append('document_file', file);
    formData.append('doc_type', docType);
    formData.append('employee_name', 'Amal Perera');
    formData.append('employee_id', 'EMP-002');
    formData.append('user_id', 1);

    var btn = document.getElementById('btnSave_' + key);
    var tag = document.getElementById('tag_' + key);
    var originalBtnText = btn ? btn.innerHTML : 'Save Document';

    if (btn) {
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
      btn.disabled = true;
    }
    if (tag) {
      tag.className = 'doc-status-tag not-uploaded';
      tag.innerText = 'Uploading...';
    }

    var pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
    $.ajax({
      url: pth + "View-List/Documents/Upload_Document.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = originalBtnText;
        }

        if (response && response.status === 'success') {
          if (tag) {
            tag.className = 'doc-status-tag uploaded';
            tag.innerText = 'Uploaded';
          }
          var card = document.getElementById('docCard_' + key);
          if (card && response.id) card.setAttribute('data-doc-id', response.id);

          var viewBtn = document.getElementById('btnView_' + key);
          if (viewBtn) viewBtn.disabled = false;

          empUploadedDocs[key] = {
            id: response.id,
            file_name: response.file_name || file.name,
            doc_type: docType,
            file_path: response.file_path || ''
          };

          alert(docType + ' saved and uploaded successfully!');
        } else {
          alert('Upload failed: ' + (response.message || 'Error occurred.'));
          if (tag) {
            tag.className = 'doc-status-tag not-uploaded';
            tag.innerText = 'Not Uploaded';
          }
        }
      },
      error: function() {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = originalBtnText;
        }
        alert('Server error during upload.');
      }
    });
  }

  function viewEmployeeDoc(key, docType) {
    var card = document.getElementById('docCard_' + key);
    var docId = card ? card.getAttribute('data-doc-id') : '0';

    if (!docId || docId === '0') {
      alert('Please save the document first to view.');
      return;
    }

    var doc = empUploadedDocs[key];
    var pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
    var fileUrl = (doc && doc.file_path && doc.file_path.length > 0) ? (pth + doc.file_path) : (pth + "View-List/Documents/View_File.php?id=" + docId);

    var modal = document.getElementById('empViewDocModal');
    var loader = document.getElementById('empDocLoader');
    var imgContainer = document.getElementById('empImageViewContainer');
    var imgPreview = document.getElementById('empDocImage');
    var pdfCanvas = document.getElementById('empPdfCanvasPages');
    var iframe = document.getElementById('empDocIframe');

    var titleElem = document.getElementById('empViewDocTitle');
    var subElem = document.getElementById('empViewDocSub');
    var icon = document.getElementById('empDocTypeIcon');
    var openTab = document.getElementById('empViewDocOpenTab');
    var downloadBtn = document.getElementById('empViewDocDownload');

    var fileName = doc ? doc.file_name : (docType + '.pdf');
    if (titleElem) titleElem.innerText = fileName;
    if (subElem) subElem.innerText = docType;
    if (openTab) openTab.href = fileUrl;
    if (downloadBtn) {
      downloadBtn.href = fileUrl;
      downloadBtn.setAttribute('download', fileName);
    }

    var ext = fileName.split('.').pop().toLowerCase();
    var isImage = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'].indexOf(ext) > -1;

    if (imgContainer) imgContainer.style.display = 'none';
    if (pdfCanvas) {
      pdfCanvas.style.display = 'none';
      pdfCanvas.innerHTML = '';
    }
    if (iframe) iframe.style.display = 'none';
    if (loader) loader.style.display = 'block';

    if (modal) modal.style.display = 'flex';

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
            iframe.src = fileUrl;
            iframe.style.display = 'block';
          }
        };
        imgPreview.src = fileUrl;
      }
    } else {
      if (icon) icon.innerHTML = '<i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i>';

      if (typeof pdfjsLib !== 'undefined') {
        var loadingTask = pdfjsLib.getDocument(fileUrl);
        loadingTask.promise.then(function(pdf) {
          if (loader) loader.style.display = 'none';
          if (pdfCanvas) pdfCanvas.style.display = 'flex';

          for (var pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            renderEmpPdfPageCard(pdf, pageNum, pdfCanvas);
          }
        }).catch(function(err) {
          console.warn('PDF.js render error, fallback to iframe:', err);
          if (loader) loader.style.display = 'none';
          if (iframe) {
            iframe.src = fileUrl;
            iframe.style.display = 'block';
          }
        });
      } else {
        if (loader) loader.style.display = 'none';
        if (iframe) {
          iframe.src = fileUrl;
          iframe.style.display = 'block';
        }
      }
    }
  }

  function renderEmpPdfPageCard(pdf, pageNum, container) {
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

  function closeEmpDocumentViewer() {
    var modal = document.getElementById('empViewDocModal');
    var imgPreview = document.getElementById('empDocImage');
    var pdfCanvas = document.getElementById('empPdfCanvasPages');
    var iframe = document.getElementById('empDocIframe');

    if (iframe) iframe.src = '';
    if (imgPreview) imgPreview.src = '';
    if (pdfCanvas) pdfCanvas.innerHTML = '';
    if (modal) modal.style.display = 'none';
  }
</script>
