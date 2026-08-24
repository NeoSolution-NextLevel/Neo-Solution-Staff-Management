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
    padding: 18px 14px;
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
    min-height: 125px;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
  }

  .doc-dropzone:hover, .doc-dropzone.dragover {
    border-color: #2563eb;
    background: #eff6ff;
  }

  .doc-dropzone.has-file {
    border: 1.5px solid #86efac;
    background: #f0fdf4;
    padding: 12px;
  }

  .doc-dropzone.has-file:hover {
    border-color: #22c55e;
    background: #ecfdf5;
  }

  .doc-drop-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: 100%;
  }

  .doc-drop-filled {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    height: 100%;
    text-align: center;
  }

  .doc-dropzone.has-file .doc-drop-empty {
    display: none !important;
  }

  .doc-dropzone.has-file .doc-drop-filled {
    display: flex !important;
  }

  .doc-filled-thumb {
    max-height: 60px;
    max-width: 100%;
    border-radius: 6px;
    object-fit: contain;
    border: 1px solid #bbf7d0;
    background: #fff;
    margin-bottom: 2px;
  }

  .doc-filled-icon {
    font-size: 28px;
    color: #16a34a;
    margin-bottom: 2px;
  }

  .doc-filled-name {
    font-size: 12.5px;
    font-weight: 700;
    color: #14532d;
    max-width: 90%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .doc-filled-size {
    font-size: 11px;
    font-weight: 600;
    color: #16a34a;
  }

  .doc-filled-change {
    font-size: 11px;
    font-weight: 700;
    color: #2563eb;
    margin-top: 3px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
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

  .btn-doc-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    font-size: 13px;
    font-weight: 700;
    border-radius: 8px;
    padding: 10px 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .btn-doc-delete:hover {
    background: #fee2e2;
    color: #b91c1c;
  }

  .btn-doc-delete:disabled {
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

        <!-- 1. CV Upload Card (1 PDF) -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_cv" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>Curriculum Vitae (CV)</h4>
              <span class="doc-status-tag not-uploaded" id="tag_cv">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload your updated resume or CV (PDF format).</p>

            <input type="file" id="fileInput_cv" accept=".pdf" style="display:none;" onchange="previewDocFile(this, 'cv')">

            <div class="doc-dropzone" id="dropzone_cv" onclick="document.getElementById('fileInput_cv').click();">
              <div class="doc-drop-empty" id="empty_cv">
                <i class="fa-solid fa-file-pdf" style="font-size: 26px; color: #dc2626;"></i>
                <span class="drop-title">Upload CV (PDF)</span>
                <span class="drop-hint">PDF only (Max 10MB)</span>
              </div>
              <div class="doc-drop-filled" id="filled_cv">
                <i class="fa-solid fa-file-circle-check doc-filled-icon" style="color: #dc2626;"></i>
                <span class="doc-filled-name" id="name_cv">document.pdf</span>
                <span class="doc-filled-size" id="size_cv">2.4 MB</span>
                <span class="doc-filled-change"><i class="fa-solid fa-arrows-rotate"></i> Change PDF</span>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_cv" onclick="saveEmployeeDoc('cv', 'CV')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_cv" onclick="viewEmployeeDoc('cv', 'CV')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
            <button type="button" class="btn-doc-delete" id="btnDelete_cv" onclick="deleteEmployeeDoc('cv', 'CV')" disabled>
              <i class="fa-solid fa-trash"></i> <span>Delete</span>
            </button>
          </div>
        </div>

        <!-- 2. National ID / Passport (2 PNGs: Front & Back) -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_id" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>National ID / Passport (2 PNG)</h4>
              <span class="doc-status-tag not-uploaded" id="tag_id">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload Front & Back PNG images of your NIC / Passport.</p>

            <input type="file" id="fileInput_id_front" accept=".png,.jpg,.jpeg" style="display:none;" onchange="previewDocFileSide(this, 'id', 'front')">
            <input type="file" id="fileInput_id_back" accept=".png,.jpg,.jpeg" style="display:none;" onchange="previewDocFileSide(this, 'id', 'back')">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
              <!-- Front Side PNG Dropzone -->
              <div class="doc-dropzone" id="dropzone_id_front" style="padding: 12px 8px; margin: 0; min-height: 125px;" onclick="document.getElementById('fileInput_id_front').click();">
                <div class="doc-drop-empty" id="empty_id_front">
                  <i class="fa-solid fa-image" style="font-size: 22px; color: #2563eb;"></i>
                  <span class="drop-title" style="font-size: 12px;">Front Side (PNG)</span>
                  <span class="drop-hint" style="font-size: 10px;">PNG image</span>
                </div>
                <div class="doc-drop-filled" id="filled_id_front">
                  <img id="thumb_id_front" class="doc-filled-thumb" src="" alt="Front" style="display:none;" />
                  <i id="icon_id_front" class="fa-solid fa-file-image doc-filled-icon" style="color: #2563eb;"></i>
                  <span class="doc-filled-name" id="name_id_front" style="font-size: 11.5px;">front.png</span>
                  <span class="doc-filled-size" id="size_id_front" style="font-size: 10px;">Front Side</span>
                  <span class="doc-filled-change" style="font-size: 10.5px;"><i class="fa-solid fa-arrows-rotate"></i> Change</span>
                </div>
              </div>

              <!-- Back Side PNG Dropzone -->
              <div class="doc-dropzone" id="dropzone_id_back" style="padding: 12px 8px; margin: 0; min-height: 125px;" onclick="document.getElementById('fileInput_id_back').click();">
                <div class="doc-drop-empty" id="empty_id_back">
                  <i class="fa-solid fa-image" style="font-size: 22px; color: #0284c7;"></i>
                  <span class="drop-title" style="font-size: 12px;">Back Side (PNG)</span>
                  <span class="drop-hint" style="font-size: 10px;">PNG image</span>
                </div>
                <div class="doc-drop-filled" id="filled_id_back">
                  <img id="thumb_id_back" class="doc-filled-thumb" src="" alt="Back" style="display:none;" />
                  <i id="icon_id_back" class="fa-solid fa-file-image doc-filled-icon" style="color: #0284c7;"></i>
                  <span class="doc-filled-name" id="name_id_back" style="font-size: 11.5px;">back.png</span>
                  <span class="doc-filled-size" id="size_id_back" style="font-size: 10px;">Back Side</span>
                  <span class="doc-filled-change" style="font-size: 10.5px;"><i class="fa-solid fa-arrows-rotate"></i> Change</span>
                </div>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_id" onclick="saveEmployeeDoc('id', 'National ID')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_id" onclick="viewEmployeeDoc('id', 'National ID')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
            <button type="button" class="btn-doc-delete" id="btnDelete_id" onclick="deleteEmployeeDoc('id', 'National ID')" disabled>
              <i class="fa-solid fa-trash"></i> <span>Delete</span>
            </button>
          </div>
        </div>

        <!-- 3. Employment Agreement (1 PDF) -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_agreement" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>Employment Agreement</h4>
              <span class="doc-status-tag not-uploaded" id="tag_agreement">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload signed employment agreement (PDF format).</p>

            <input type="file" id="fileInput_agreement" accept=".pdf" style="display:none;" onchange="previewDocFile(this, 'agreement')">

            <div class="doc-dropzone" id="dropzone_agreement" onclick="document.getElementById('fileInput_agreement').click();">
              <div class="doc-drop-empty" id="empty_agreement">
                <i class="fa-solid fa-file-signature" style="font-size: 26px; color: #14204d;"></i>
                <span class="drop-title">Upload Agreement (PDF)</span>
                <span class="drop-hint">PDF only (Max 10MB)</span>
              </div>
              <div class="doc-drop-filled" id="filled_agreement">
                <i class="fa-solid fa-file-circle-check doc-filled-icon" style="color: #14204d;"></i>
                <span class="doc-filled-name" id="name_agreement">agreement.pdf</span>
                <span class="doc-filled-size" id="size_agreement">3.1 MB</span>
                <span class="doc-filled-change"><i class="fa-solid fa-arrows-rotate"></i> Change PDF</span>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_agreement" onclick="saveEmployeeDoc('agreement', 'Agreement')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_agreement" onclick="viewEmployeeDoc('agreement', 'Agreement')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
            <button type="button" class="btn-doc-delete" id="btnDelete_agreement" onclick="deleteEmployeeDoc('agreement', 'Agreement')" disabled>
              <i class="fa-solid fa-trash"></i> <span>Delete</span>
            </button>
          </div>
        </div>

        <!-- 4. Grama Sevaka Certificate (1 PDF) -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_grama" data-doc-id="0">
          <div>
            <div class="doc-card-head">
              <h4>Grama Sevaka Certificate</h4>
              <span class="doc-status-tag not-uploaded" id="tag_grama">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload Grama Niladhari certificate (PDF format).</p>

            <input type="file" id="fileInput_grama" accept=".pdf" style="display:none;" onchange="previewDocFile(this, 'grama')">

            <div class="doc-dropzone" id="dropzone_grama" onclick="document.getElementById('fileInput_grama').click();">
              <div class="doc-drop-empty" id="empty_grama">
                <i class="fa-solid fa-stamp" style="font-size: 26px; color: #059669;"></i>
                <span class="drop-title">Upload Certificate (PDF)</span>
                <span class="drop-hint">PDF only (Max 10MB)</span>
              </div>
              <div class="doc-drop-filled" id="filled_grama">
                <i class="fa-solid fa-file-circle-check doc-filled-icon" style="color: #059669;"></i>
                <span class="doc-filled-name" id="name_grama">grama_cert.pdf</span>
                <span class="doc-filled-size" id="size_grama">950 KB</span>
                <span class="doc-filled-change"><i class="fa-solid fa-arrows-rotate"></i> Change PDF</span>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_grama" onclick="saveEmployeeDoc('grama', 'Grama Sevaka Certificate')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_grama" onclick="viewEmployeeDoc('grama', 'Grama Sevaka Certificate')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
            <button type="button" class="btn-doc-delete" id="btnDelete_grama" onclick="deleteEmployeeDoc('grama', 'Grama Sevaka Certificate')" disabled>
              <i class="fa-solid fa-trash"></i> <span>Delete</span>
            </button>
          </div>
        </div>

        <!-- 5. Police Report (1 PDF) -->
        <div class="doc-upload-card w3-card w3-round-xlarge" id="docCard_police" data-doc-id="0" style="grid-column: 1 / -1;">
          <div>
            <div class="doc-card-head">
              <h4>Police Clearance Report</h4>
              <span class="doc-status-tag not-uploaded" id="tag_police">Not Uploaded</span>
            </div>
            <p class="doc-desc">Upload your valid Police Clearance Certificate (PDF format).</p>

            <input type="file" id="fileInput_police" accept=".pdf" style="display:none;" onchange="previewDocFile(this, 'police')">

            <div class="doc-dropzone" id="dropzone_police" onclick="document.getElementById('fileInput_police').click();">
              <div class="doc-drop-empty" id="empty_police">
                <i class="fa-solid fa-shield-halved" style="font-size: 26px; color: #4338ca;"></i>
                <span class="drop-title">Upload Police Report (PDF)</span>
                <span class="drop-hint">PDF only (Max 10MB)</span>
              </div>
              <div class="doc-drop-filled" id="filled_police">
                <i class="fa-solid fa-file-circle-check doc-filled-icon" style="color: #4338ca;"></i>
                <span class="doc-filled-name" id="name_police">police_report.pdf</span>
                <span class="doc-filled-size" id="size_police">1.8 MB</span>
                <span class="doc-filled-change"><i class="fa-solid fa-arrows-rotate"></i> Change PDF</span>
              </div>
            </div>
          </div>

          <div class="doc-actions-row">
            <button type="button" class="btn-doc-save" id="btnSave_police" onclick="saveEmployeeDoc('police', 'Police Report')">
              <i class="fa-solid fa-floppy-disk"></i> <span>Save</span>
            </button>
            <button type="button" class="btn-doc-view" id="btnView_police" onclick="viewEmployeeDoc('police', 'Police Report')" disabled>
              <i class="fa-solid fa-eye"></i> <span>View</span>
            </button>
            <button type="button" class="btn-doc-delete" id="btnDelete_police" onclick="deleteEmployeeDoc('police', 'Police Report')" disabled>
              <i class="fa-solid fa-trash"></i> <span>Delete</span>
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
    if (typeof window.userProfileData === 'undefined' || !window.userProfileData.full_name) {
      $.ajax({
        url: pth + "UxUi-Back/Employee/fetch_profile/fetch_profile.php",
        type: "GET",
        dataType: "json",
        success: function(pRes) {
          if (pRes && pRes.status === 'success' && pRes.data) {
            window.userProfileData = pRes.data;
          }
        }
      });
    }

    $.ajax({
      url: pth + "View-List/Documents/Fetch_Document.php",
      type: "GET",
      dataType: "json",
      success: function(res) {
        if (res && res.status === 'success' && res.data && res.data.length > 0) {
          res.data.forEach(function(doc) {
            var key = '';
            var type = (doc.category || doc.doc_type || doc.type || '').toLowerCase();
            if (type.indexOf('cv') > -1 || type.indexOf('resume') > -1) key = 'cv';
            else if (type.indexOf('id') > -1 || type.indexOf('passport') > -1 || type.indexOf('nic') > -1) key = 'id';
            else if (type.indexOf('agree') > -1) key = 'agreement';
            else if (type.indexOf('grama') > -1) key = 'grama';
            else if (type.indexOf('police') > -1) key = 'police';

            if (key) {
              empUploadedDocs[key] = doc;
              var card = document.getElementById('docCard_' + key);
              var tag = document.getElementById('tag_' + key);
              var viewBtn = document.getElementById('btnView_' + key);
              var delBtn = document.getElementById('btnDelete_' + key);

              if (card && doc.id) card.setAttribute('data-doc-id', doc.id);
              if (tag) {
                tag.className = 'doc-status-tag uploaded';
                tag.innerText = doc.status || 'Uploaded';
              }
              if (viewBtn) viewBtn.disabled = false;
              if (delBtn) delBtn.disabled = false;

              if (key === 'id') {
                var dzFront = document.getElementById('dropzone_id_front');
                var dzBack = document.getElementById('dropzone_id_back');
                var nameFront = document.getElementById('name_id_front');
                var nameBack = document.getElementById('name_id_back');
                var thumbFront = document.getElementById('thumb_id_front');
                var iconFront = document.getElementById('icon_id_front');

                if (dzFront) dzFront.classList.add('has-file');
                if (dzBack) dzBack.classList.add('has-file');
                if (nameFront) nameFront.innerText = doc.file_name || doc.title || 'front.png';
                if (nameBack) nameBack.innerText = doc.file_name || doc.title || 'back.png';

                if (doc.url && (doc.url.indexOf('.png') > -1 || doc.url.indexOf('.jpg') > -1 || doc.url.indexOf('.jpeg') > -1)) {
                  var pthUrl = (doc.url.indexOf('http') === 0) ? doc.url : (pth + doc.url);
                  if (thumbFront) {
                    thumbFront.src = pthUrl;
                    thumbFront.style.display = 'block';
                  }
                  if (iconFront) iconFront.style.display = 'none';
                }
              } else {
                var dropzone = document.getElementById('dropzone_' + key);
                var name = document.getElementById('name_' + key);
                var size = document.getElementById('size_' + key);

                if (dropzone) dropzone.classList.add('has-file');
                if (name) name.innerText = doc.file_name || doc.title || 'document.pdf';
                if (size) size.innerText = doc.file_size || doc.size || '';
              }
            }
          });
        }
      }
    });
  }

  function previewDocFile(input, key) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];

    var dropzone = document.getElementById('dropzone_' + key);
    var name = document.getElementById('name_' + key);
    var size = document.getElementById('size_' + key);

    var formattedSize = (file.size >= 1048576) 
      ? (file.size / 1048576).toFixed(2) + ' MB' 
      : (file.size / 1024).toFixed(1) + ' KB';

    if (dropzone) dropzone.classList.add('has-file');
    if (name) name.innerText = file.name;
    if (size) size.innerText = formattedSize;
  }

  function previewDocFileSide(input, key, side) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];

    var dropzone = document.getElementById('dropzone_' + key + '_' + side);
    var name = document.getElementById('name_' + key + '_' + side);
    var size = document.getElementById('size_' + key + '_' + side);
    var thumb = document.getElementById('thumb_' + key + '_' + side);
    var icon = document.getElementById('icon_' + key + '_' + side);

    var formattedSize = (file.size >= 1048576) 
      ? (file.size / 1048576).toFixed(2) + ' MB' 
      : (file.size / 1024).toFixed(1) + ' KB';

    if (dropzone) dropzone.classList.add('has-file');
    if (name) name.innerText = file.name;
    if (size) size.innerText = (side.toUpperCase() + ' • ' + formattedSize);

    if (file.type && file.type.indexOf('image') > -1) {
      var reader = new FileReader();
      reader.onload = function(e) {
        if (thumb) {
          thumb.src = e.target.result;
          thumb.style.display = 'block';
        }
        if (icon) icon.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  }

  function saveEmployeeDoc(key, docType) {
    var formData = new FormData();
    var empName = (typeof window.userProfileData !== 'undefined' && window.userProfileData.full_name) ? window.userProfileData.full_name : '';
    var empId = (typeof window.userProfileData !== 'undefined' && window.userProfileData.employee_id_code) ? window.userProfileData.employee_id_code : 'EMP-001';

    formData.append('doc_type', docType);
    formData.append('category', docType);
    if (empName) {
      formData.append('employee_name', empName);
      formData.append('employee', empName);
    }
    formData.append('employee_id', empId);
    formData.append('user_id', 1);

    if (key === 'id') {
      var frontInput = document.getElementById('fileInput_id_front');
      var backInput = document.getElementById('fileInput_id_back');
      var hasFront = frontInput && frontInput.files && frontInput.files[0];
      var hasBack = backInput && backInput.files && backInput.files[0];

      if (!hasFront && !hasBack) {
        alert('Please select at least one National ID PNG image (Front or Back) to upload.');
        if (frontInput) frontInput.click();
        return;
      }

      if (hasFront) formData.append('document_file_front', frontInput.files[0]);
      if (hasBack) formData.append('document_file_back', backInput.files[0]);
    } else {
      var input = document.getElementById('fileInput_' + key);
      if (!input || !input.files || !input.files[0]) {
        alert('Please select a PDF file to upload first.');
        if (input) input.click();
        return;
      }
      formData.append('document_file', input.files[0]);
    }

    var btn = document.getElementById('btnSave_' + key);
    var tag = document.getElementById('tag_' + key);
    var originalBtnText = btn ? btn.innerHTML : 'Save';

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
          var savedId = response.id || (response.data && response.data.id) || 0;
          var savedUrl = response.file_path || (response.data && response.data.url) || '';
          var savedName = response.file_name || (response.data && response.data.title) || '';

          if (tag) {
            tag.className = 'doc-status-tag uploaded';
            tag.innerText = 'Uploaded';
          }
          var card = document.getElementById('docCard_' + key);
          if (card && savedId) card.setAttribute('data-doc-id', savedId);

          var viewBtn = document.getElementById('btnView_' + key);
          if (viewBtn) viewBtn.disabled = false;

          var delBtn = document.getElementById('btnDelete_' + key);
          if (delBtn) delBtn.disabled = false;

          empUploadedDocs[key] = {
            id: savedId,
            file_name: savedName,
            title: savedName,
            doc_type: docType,
            category: docType,
            file_path: savedUrl,
            url: savedUrl
          };

          alert(docType + ' saved and uploaded to database successfully!');
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

  function deleteEmployeeDoc(key, docType) {
    var card = document.getElementById('docCard_' + key);
    var docId = card ? card.getAttribute('data-doc-id') : '0';

    if (!docId || docId === '0') {
      if (key === 'id') {
        var fiFront = document.getElementById('fileInput_id_front');
        var fiBack = document.getElementById('fileInput_id_back');
        if (fiFront) fiFront.value = '';
        if (fiBack) fiBack.value = '';
        var dzF = document.getElementById('dropzone_id_front');
        var dzB = document.getElementById('dropzone_id_back');
        if (dzF) dzF.classList.remove('has-file');
        if (dzB) dzB.classList.remove('has-file');
      } else {
        var input = document.getElementById('fileInput_' + key);
        if (input) input.value = '';
        var dz = document.getElementById('dropzone_' + key);
        if (dz) dz.classList.remove('has-file');
      }
      return;
    }

    if (!confirm('Are you sure you want to permanently delete your ' + docType + '?')) {
      return;
    }

    var delBtn = document.getElementById('btnDelete_' + key);
    if (delBtn) delBtn.disabled = true;

    var pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
    $.ajax({
      url: pth + "View-List/Documents/Delete_Document.php",
      type: "POST",
      data: { id: docId },
      dataType: "json",
      success: function(res) {
        if (res && res.status === 'success') {
          delete empUploadedDocs[key];
          if (card) card.setAttribute('data-doc-id', '0');
          var tag = document.getElementById('tag_' + key);
          if (tag) {
            tag.className = 'doc-status-tag not-uploaded';
            tag.innerText = 'Not Uploaded';
          }
          
          if (key === 'id') {
            var fiFront = document.getElementById('fileInput_id_front');
            var fiBack = document.getElementById('fileInput_id_back');
            if (fiFront) fiFront.value = '';
            if (fiBack) fiBack.value = '';
            var dzF = document.getElementById('dropzone_id_front');
            var dzB = document.getElementById('dropzone_id_back');
            if (dzF) dzF.classList.remove('has-file');
            if (dzB) dzB.classList.remove('has-file');
            var thumbF = document.getElementById('thumb_id_front');
            var thumbB = document.getElementById('thumb_id_back');
            var iconF = document.getElementById('icon_id_front');
            var iconB = document.getElementById('icon_id_back');
            if (thumbF) thumbF.style.display = 'none';
            if (thumbB) thumbB.style.display = 'none';
            if (iconF) iconF.style.display = 'block';
            if (iconB) iconB.style.display = 'block';
          } else {
            var input = document.getElementById('fileInput_' + key);
            if (input) input.value = '';
            var dz = document.getElementById('dropzone_' + key);
            if (dz) dz.classList.remove('has-file');
          }

          var viewBtn = document.getElementById('btnView_' + key);
          if (viewBtn) viewBtn.disabled = true;
          if (delBtn) delBtn.disabled = true;

          alert(docType + ' deleted permanently from database.');
        } else {
          if (delBtn) delBtn.disabled = false;
          alert('Delete failed: ' + (res.message || 'Error occurred.'));
        }
      },
      error: function() {
        if (delBtn) delBtn.disabled = false;
        alert('Server error during deletion.');
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
