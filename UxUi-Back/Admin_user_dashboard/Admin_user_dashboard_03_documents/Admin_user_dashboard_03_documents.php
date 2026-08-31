<?php
// Admin_user_dashboard_03_documents.php
?>
<style>
  /* =========================================================
     ADMIN DOCUMENTS MANAGEMENT (FIXED VIEWPORT - ZERO PAGE SCROLL)
  ========================================================= */
  :root {
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #3b5bdb;
    --blue-light: #dbe4ff;
    --blue-lighter: #eef2ff;
    --green: #12b76a;
    --green-bg: #e3f9ee;
    --amber: #f5a623;
    --amber-bg: #fdf1dc;
    --red: #f0576a;
    --red-bg: #fde8ec;
    --ink: #1a1f36;
    --muted: #64748b;
    --border: #e8eaf0;
    --bg: #f5f6fa;
    --card: #ffffff;
    --radius: 16px;
    --shadow: 0 1px 2px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
    font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }

  #Admin_user_dashboard_03_documents {
    width: 100%;
    min-height; 100vh;
  }

  .main {
    margin-left: 250px;
    width: calc(100% - 250px);
    max-width: calc(100% - 250px);
    min-heigth: 100vh;
    padding: 16px 20px 24px;
    box-sizing: border-box;
    transition: margin-left 0.3s ease, width 0.3s ease;
  }

  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }
  .topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .topbar h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.3px;
  }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--blue-lighter);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
  }
  
  .icon-btn svg { 
  width: 18px; 
  height: 18px; 
  color: var(--navy); 
  }
  .dot {
    position: absolute;
    top: 8px;
    right: 9px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--red);
    border: 2px solid #ffffff;
  }

  .admin-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--blue-lighter);
    padding: 5px 14px 5px 5px;
    border-radius: 999px;
    cursor: pointer;
  }
  .admin-pill .avatar {
    width: 30px;
    height: 30px;
    font-size: 11.5px;
    background: var(--navy);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
  }
  .admin-pill span {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--navy);
  }

  .menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: var(--blue-lighter);
    border: none;
    cursor: pointer;
    color: var(--navy);
    margin-right: 6px;
  }
  .menu-btn svg { width: 20px; height: 20px; }

  /* Main Card Layout) */
  .doc-main-card {
    flex: 1;
    min-height: 0;
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
  }

  /* Toolbar Header: Search, Filters, Stats Counter */
  .doc-toolbar {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--border);
    background: #ffffff;
  }

  .doc-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    max-width: 540px;
  }

  .doc-search-box {
    position: relative;
    flex: 1;
  }
  .doc-search-box svg {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 15px;
    color: #94a3b8;
    pointer-events: none;
  }
  .doc-search-input {
    width: 100%;
    padding: 8px 12px 8px 34px;
    border: 1px solid #dbe4ff;
    border-radius: 8px;
    font-size: 13px;
    color: var(--ink);
    background: #f8fafc;
    outline: none;
    transition: all 0.2s ease;
  }
  .doc-search-input:focus {
    background: #ffffff;
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59, 91, 219, 0.12);
  }

  .doc-select {
    padding: 7.5px 12px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #f8fafc;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ink);
    outline: none;
    cursor: pointer;
    transition: border-color 0.15s ease;
  }
  .doc-select:focus {
    border-color: var(--blue);
    background: #ffffff;
  }

  .doc-toolbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .doc-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--blue-lighter);
    color: var(--blue);
    font-size: 12px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 8px;
    white-space: nowrap;
  }

  .doc-btn-refresh {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7.5px 12px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--navy);
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
    white-space: nowrap;
  }
  .doc-btn-refresh:hover {
    background: var(--blue-lighter);
    border-color: #cbd5e1;
  }

  /* Table Container: Vertical Scroll ONLY, Zero Horizontal Scroll */
  .doc-table-wrap {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden !important;
    width: 100%;
  }

  /* Sleek Scrollbar */
  .doc-table-wrap::-webkit-scrollbar {
    width: 6px;
  }
  .doc-table-wrap::-webkit-scrollbar-track {
    background: #f8fafc;
  }
  .doc-table-wrap::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  .doc-table-wrap::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }

  /* Fixed Layout Table (Columns Stay 100% In View Without Side Scrolling) */
  table.doc-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
  }

  table.doc-table thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #fafbfd;
    color: #64748b;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 700;
    padding: 11px 16px;
    border-bottom: 1px solid #e8eaf0;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  table.doc-table tbody td {
    padding: 10px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  table.doc-table tbody tr {
    transition: background 0.12s ease;
  }
  table.doc-table tbody tr:hover {
    background: #f8fafc;
  }
  table.doc-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Column Widths (Sum to 100%) */
  .col-emp { width: 28%; }
  .col-type { width: 20%; }
  .col-file { width: 28%; }
  .col-date { width: 12%; }
  .col-actions { width: 12%; text-align: right !important; }

  /* Cell Elements */
  .emp-cell {
    display: flex;
    align-items: center;
    gap: 10px;
    overflow: hidden;
  }
  .emp-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #14204d 0%, #3b5bdb 100%);
    color: #ffffff;
    font-size: 11.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .emp-info {
    display: flex;
    flex-direction: column;
    gap: 1px;
    overflow: hidden;
  }
  .emp-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .emp-id-badge {
    font-size: 11px;
    color: var(--muted);
    font-weight: 600;
    font-family: monospace;
  }

  .doc-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 700;
    background: #eef2ff;
    color: #3b5bdb;
    border: 1px solid #dbe4ff;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .doc-type-badge.id-proof {
    background: #ecfdf5;
    color: #059669;
    border-color: #a7f3d0;
  }
  .doc-type-badge.cert {
    background: #fef3c7;
    color: #d97706;
    border-color: #fde68a;
  }
  .doc-type-badge.other {
    background: #f1f5f9;
    color: #475569;
    border-color: #e2e8f0;
  }

  .file-cell {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow: hidden;
  }
  .file-ext-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
  }
  .file-ext-icon.pdf { background: #fee2e2; color: #ef4444; }
  .file-ext-icon.img { background: #dcfce7; color: #16a34a; }
  .file-ext-icon.doc { background: #e0e7ff; color: #4338ca; }
  .file-ext-icon.default { background: #f1f5f9; color: #64748b; }

  .file-meta {
    display: flex;
    flex-direction: column;
    gap: 1px;
    overflow: hidden;
  }
  .file-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 12.5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .file-size {
    font-size: 10.5px;
    color: #94a3b8;
    font-weight: 600;
  }

  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
  }
  .status-badge.uploaded { background: #e6f4ea; color: #137333; }
  .status-badge.verified { background: #eeeffe; color: #4338ca; }
  .status-badge.pending { background: #fef3c7; color: #d97706; }
  .status-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: currentColor;
  }

  .row-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    justify-content: flex-end;
  }
  .action-btn {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.15s ease;
  }
  .action-btn svg { width: 14px; height: 14px; }
  .action-btn.view { background: #eef2ff; color: #3b5bdb; }
  .action-btn.view:hover { background: #3b5bdb; color: #ffffff; }
  .action-btn.download { background: #e6f4ea; color: #12b76a; }
  .action-btn.download:hover { background: #12b76a; color: #ffffff; }
  .action-btn.delete { background: #fde8ec; color: #f0576a; }
  .action-btn.delete:hover { background: #f0576a; color: #ffffff; }

  /* Mobile Responsive Cards View (<= 768px) */
  .mobile-doc-cards {
    display: none;
    flex-direction: column;
    gap: 10px;
    padding: 12px;
    overflow-y: auto;
    background: #f8fafc;
  }

  .mobile-doc-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--border);
    padding: 14px;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .mobile-doc-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 8px;
    border-bottom: 1px solid #f1f5f9;
  }

  .mobile-doc-details {
    display: flex;
    flex-direction: column;
    gap: 6px;
    background: #f8fafc;
    border-radius: 8px;
    padding: 10px 12px;
  }

  .mobile-doc-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
  }
  .mobile-doc-label { color: #64748b; font-weight: 600; }
  .mobile-doc-val { color: #1e293b; font-weight: 700; text-align: right; }

  .mobile-doc-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 2px;
  }

  .btn-mobile-action {
    flex: 1;
    font-size: 12.5px;
    font-weight: 700;
    border-radius: 8px;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    text-decoration: none;
    border: 1px solid transparent;
    transition: all 0.15s ease;
  }
  .btn-mobile-action.view { background: #eef2ff; color: #3b5bdb; border-color: #dbe4ff; }
  .btn-mobile-action.download { background: #e6f4ea; color: #12b76a; border-color: #cbf0d8; }
  .btn-mobile-action.delete { background: #fde8ec; color: #f0576a; border-color: #fbd0d8; flex: 0 0 38px; }

  /* Document Viewer Modal */
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
    padding: 20px;
    box-sizing: border-box;
    backdrop-filter: blur(4px);
  }
  .doc-modal-overlay.active { display: flex; }

  .doc-modal-box {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 920px;
    height: 86vh;
    max-height: 86vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
  }

  .doc-modal-header {
    flex-shrink: 0;
    padding: 12px 18px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
  }

  .doc-modal-body {
    flex: 1;
    overflow-y: auto;
    background: #f1f5f9;
    position: relative;
    padding: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .doc-modal-footer {
    flex-shrink: 0;
    padding: 10px 18px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  /* Phone & Mobile Media Queries */
  @media (max-width: 768px) {
    #Admin_user_dashboard_03_documents {
      min-height: 100vh !important;
      height: auto !important;
      max-height: none !important;
      overflow: visible !important;
      padding: 0 12px 80px !important;
    }
    #Admin_user_dashboard_03_documents .main {
      margin-left: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      padding: 0 !important;
      height: auto !important;
      max-height: none !important;
      overflow: visible !important;
    }
    .menu-btn { display: inline-flex !important; }
    .topbar h2 { font-size: 18px !important; }
    
    .doc-main-card {
      border: none !important;
      box-shadow: none !important;
      background: transparent !important;
      padding: 0 !important;
      border-radius: 0 !important;
      height: auto !important;
      max-height: none !important;
    }

    .doc-toolbar {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
      padding: 12px;
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
      margin-bottom: 12px;
    }
    .doc-toolbar-left {
      max-width: 100%;
      width: 100%;
      flex-direction: column;
      gap: 8px;
    }
    .doc-search-box {
      width: 100% !important;
    }
    .doc-search-input {
      width: 100% !important;
      box-sizing: border-box !important;
    }
    .doc-select {
      width: 100% !important;
      box-sizing: border-box !important;
    }
    .doc-toolbar-right {
      justify-content: space-between;
      width: 100%;
      gap: 10px;
    }

    .doc-table-wrap { display: none !important; }
    .mobile-doc-cards { 
      display: flex !important; 
      padding: 0 !important; 
      background: transparent !important;
      gap: 12px;
    }
  }

  @media (max-width: 640px) {
    .doc-modal-overlay { padding: 0 !important; }
    .doc-modal-box {
      width: 100% !important;
      height: 100% !important;
      max-height: 100% !important;
      border-radius: 0 !important;
    }
    .hide-on-mobile { display: none !important; }
  }
</style>

<div id="Admin_user_dashboard_03_documents" style="display:none;">
  <main class="main">

    <!-- Compact Topbar Header -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
        </button>
        <h2>Documents</h2>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" onclick="Admin_user_dashboard_09_OPEN();" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          <span class="dot"></span>
        </div>
        <div class="admin-pill">
          <div class="avatar">AU</div>
          <span>Admin</span>
        </div>
      </div>
    </div>

    <!-- Main Container Card (Fills Remaining Viewport Exactly) -->
    <div class="doc-main-card">
      
      <!-- Filter Toolbar -->
      <div class="doc-toolbar">
        <div class="doc-toolbar-left">
          <div class="doc-search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="docSearchInput" class="doc-search-input" placeholder="Search by employee, file name, or ID..." oninput="filterAdminDocs();">
          </div>

          <select id="docTypeFilter" class="doc-select" onchange="filterAdminDocs();">
            <option value="all">All Document Types</option>
            <option value="CV">CV</option>
            <option value="National ID">National ID</option>
            <option value="Agreement">Employment Agreement</option>
            <option value="Certificate">Grama sevaka Certificate</option>
            <option value="Police Report">Police Report</option>
          </select>
        </div>

        <div class="doc-toolbar-right">
          <div class="doc-count-badge" id="docCountBadge">
            <i class="fa-solid fa-folder-closed"></i> <span id="docCountText">0 Documents</span>
          </div>

      

          <button type="button" class="doc-btn-refresh" onclick="loadAdminDocuments();" title="Refresh Document List">
            <i class="fa-solid fa-rotate-right"></i> Refresh
          </button>
        </div>
      </div>

      <!-- 1. Desktop & Tablet Table View (No Horizontal Scroll, Clean Vertical Scroll) -->
      <div class="doc-table-wrap">
        <table class="doc-table">
          <thead>
            <tr>
              <th class="col-emp">Employee</th>
              <th class="col-type">Document Type</th>
              <th class="col-file">File Name</th>
              <th class="col-date">Upload Date</th>
              <th class="col-actions">Actions</th>
            </tr>
          </thead>
          <tbody id="docTableBody">
            <tr>
              <td colspan="5" style="text-align:center; padding: 48px 20px; color: #64748b;">
                <div style="display:flex; flex-direction:column; align-items:center; gap:8px;">
                  <i class="fa-solid fa-spinner fa-spin" style="font-size: 22px; color: #3b5bdb;"></i>
                  <span>Loading documents...</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 2. Mobile Responsive Cards View (Screens <= 768px) -->
      <div class="mobile-doc-cards" id="mobileDocCardsContainer">
        <div style="text-align:center; padding: 30px 16px; color: #64748b; background:#fff; border-radius:10px;">
          <i class="fa-solid fa-spinner fa-spin" style="font-size: 18px; color: #3b5bdb; margin-bottom: 6px;"></i>
          <div>Loading documents...</div>
        </div>
      </div>

    </div>

    <!-- 3. Document Viewer Modal -->
    <div class="doc-modal-overlay" id="viewDocModal">
      <div class="doc-modal-box">
        
        <!-- Header -->
        <div class="doc-modal-header">
          <div style="display: flex; align-items: center; gap: 10px; overflow: hidden;">
            <div id="viewDocTypeIcon" style="width: 34px; height: 34px; border-radius: 8px; background: #eef2ff; color: #3b5bdb; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
              <i class="fa-solid fa-file-lines"></i>
            </div>
            <div style="overflow: hidden;">
              <h3 id="viewDocHeaderTitle" style="font-size: 14px; font-weight: 800; color: #1e293b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Document Viewer</h3>
              <span id="viewDocSubTitle" style="font-size: 11.5px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">Document preview</span>
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
            <a id="viewDocOpenTab" href="#" target="_blank" style="background: #f1f5f9; color: #475569; font-size: 12px; font-weight: 700; padding: 6px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; border: 1px solid #e2e8f0;">
              <i class="fa-solid fa-arrow-up-right-from-square"></i> <span class="hide-on-mobile">Open Tab</span>
            </a>
            <a id="viewDocDownloadBtn" href="#" download style="background: #e6f4ea; color: #12b76a; font-size: 12px; font-weight: 700; padding: 6px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; border: 1px solid #cbf0d8;">
              <i class="fa-solid fa-download"></i> <span class="hide-on-mobile">Download</span>
            </a>
            <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #64748b; padding: 0 4px; line-height: 1; display:flex; align-items:center;" onclick="closeDocumentViewer()">&times;</button>
          </div>
        </div>

        <!-- Body with Image & Canvas PDF Viewer -->
        <div class="doc-modal-body">
          
          <!-- Loading state -->
          <div id="docViewerLoader" style="display:none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size: 34px; color: #3b5bdb; margin-bottom: 10px;"></i>
            <div style="font-size: 13.5px; font-weight: 700; color: #475569;">Rendering document preview...</div>
          </div>

          <!-- Image Container (PNG / JPG / WEBP) -->
          <div id="imageViewerContainer" style="display: none; width: 100%; min-height: 100%; padding: 8px; box-sizing: border-box; align-items: center; justify-content: center;">
            <img id="docImagePreview" src="" alt="Document Preview" style="max-width: 100%; max-height: 68vh; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); object-fit: contain; background: #fff;">
          </div>

          <!-- PDF Canvas Pages Container -->
          <div id="pdfCanvasPagesContainer" style="display: none; width: 100%; padding: 8px; box-sizing: border-box; flex-direction: column; align-items: center; gap: 14px;"></div>

          <!-- Fallback direct embed iframe -->
          <iframe id="cvIframeViewer" src="" style="display:none; width: 100%; height: 100%; min-height: 480px; border: none; background: #fff; border-radius: 8px;"></iframe>

        </div>

        <!-- Footer -->
        <div class="doc-modal-footer">
          <span id="viewDocMetaFooter" style="font-size: 11.5px; color: #64748b; font-weight: 600;">Office Document System</span>
          <button type="button" style="background: #e2e8f0; border: none; padding: 6px 16px; border-radius: 6px; font-weight: 700; cursor: pointer; color: #475569; font-size: 12.5px;" onclick="closeDocumentViewer()">Close</button>
        </div>

      </div>
    </div>

  

  </main>
</div>

<!-- Load PDF.js library for direct image-based PDF rendering -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
