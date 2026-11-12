<?php
$empFile = __DIR__ . '/../Super_Admin_user_dashboard_02_employees/Super_Admin_user_dashboard_02_employees.php';
$content = file_get_contents($empFile);

// 1. Add tab button
$search1 = '<button type="button" class="emp-section-tab" id="tabOnboardingBtn" onclick="switchEmpSectionTab(\'onboarding\')" style="padding: 10px 18px; border: none; background: transparent; font-size: 13.5px; font-weight: 600; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-file-signature"></i> Onboarding Submissions &amp; Forms
        <span id="pendingSubmissionsBadge" style="display: none; background: #ef4444; color: #ffffff; font-size: 11px; padding: 2px 8px; border-radius: 999px; font-weight: 800;">0</span>
      </button>';

$replace1 = $search1 . "\n" . '      <button type="button" class="emp-section-tab" id="tabAdminAccountsBtn" onclick="switchEmpSectionTab(\'admins\')" style="padding: 10px 18px; border: none; background: transparent; font-size: 13.5px; font-weight: 600; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-user-shield"></i> Admin Accounts &amp; Approvals
        <span id="pendingAdminsBadge" style="display: none; background: #ef4444; color: #ffffff; font-size: 11px; padding: 2px 8px; border-radius: 999px; font-weight: 800;">0</span>
      </button>';

if (strpos($content, 'tabAdminAccountsBtn') === false) {
    // Normalize newlines for replacement
    $cNormalized = str_replace("\r\n", "\n", $content);
    if (strpos($cNormalized, $search1) !== false) {
        $cNormalized = str_replace($search1, $replace1, $cNormalized);
        file_put_contents($empFile, $cNormalized);
        echo "Tab button added successfully.\n";
    } else {
        echo "Search 1 not found.\n";
    }
} else {
    echo "Tab button already present.\n";
}

// 2. Add sectionAdminAccounts
$content = file_get_contents($empFile);
$search2 = '<tbody id="formsTableBody">
              <tr><td colspan="6" style="text-align:center; padding: 20px; color:#64748b;">Loading generated forms...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>';

$adminSectionHtml = <<<'HTML'
    <!-- 3. Admin Accounts & Approvals View -->
    <div id="sectionAdminAccounts" style="display: none;">
      <!-- Super Admin Alert Banner for Pending Registrations -->
      <div id="adminApprovalBanner" style="display: none; background: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; border-radius: 12px; padding: 14px 18px; margin-bottom: 16px; align-items: center; justify-content: space-between; gap: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 38px; height: 38px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
            <i class="fas fa-shield-halved"></i>
          </div>
          <div>
            <div style="font-size: 14.5px; font-weight: 700; color: #92400e;" id="adminApprovalBannerTitle">Administrator Registrations Awaiting Approval</div>
            <div style="font-size: 12.5px; color: #b45309;">New administrator accounts require Super Admin approval before credentials can be used to log in.</div>
          </div>
        </div>
        <button type="button" onclick="filterAdminTable('pending')" class="w3-btn-primary" style="padding: 7px 14px; font-size: 12px; background: #f59e0b; border: none; white-space: nowrap; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.28);">
          Review Pending (<span id="adminBannerPendingCount">0</span>)
        </button>
      </div>

      <!-- Stats summary cards -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 20px;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-user-shield"></i>
          </div>
          <div>
            <div style="font-size: 20px; font-weight: 800; color: #0f172a;" id="statTotalAdmins">0</div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Total Administrators</div>
          </div>
        </div>
        
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-hourglass-half"></i>
          </div>
          <div>
            <div style="font-size: 20px; font-weight: 800; color: #d97706;" id="statPendingAdmins">0</div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Pending Super Admin Approval</div>
          </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-check-circle"></i>
          </div>
          <div>
            <div style="font-size: 20px; font-weight: 800; color: #0f172a;" id="statActiveAdmins">0</div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">Approved / Active Admins</div>
          </div>
        </div>
      </div>

      <!-- Toolbar -->
      <div class="w3-toolbar" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; flex:1; min-width:280px;">
          <div class="w3-search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="adminSearchInput" placeholder="Search administrators by name or email..." oninput="renderAdminTable()">
          </div>
          <div class="w3-filter-pills" id="adminFilterPills">
            <div class="w3-pill active" data-filter="all" onclick="filterAdminTable('all')">All</div>
            <div class="w3-pill" data-filter="pending" onclick="filterAdminTable('pending')">Pending Approval</div>
            <div class="w3-pill" data-filter="active" onclick="filterAdminTable('active')">Active</div>
            <div class="w3-pill" data-filter="blocked" onclick="filterAdminTable('blocked')">Declined</div>
          </div>
        </div>
        <button type="button" onclick="loadAdminAccountsData()" class="w3-btn-primary" style="padding: 8px 16px; font-size: 13px; background: #ffffff; color: #14204d; border: 1px solid #cbd5e1; box-shadow: none;">
          <i class="fas fa-rotate"></i> Refresh List
        </button>
      </div>

      <!-- Desktop Table Card -->
      <div class="w3-table-card">
        <div class="w3-table-wrap">
          <table class="emp-table">
            <thead>
              <tr>
                <th>Administrator</th>
                <th>Role &amp; Ref ID</th>
                <th>Registered At</th>
                <th>Last Login</th>
                <th>Status</th>
                <th style="text-align: right;">Approval Action</th>
              </tr>
            </thead>
            <tbody id="adminsTableBody">
              <tr><td colspan="6" style="text-align:center; padding: 25px; color:#64748b;"><i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Loading administrator accounts...</td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Mobile Cards Container -->
      <div id="mobileAdminCardsContainer" style="display: none; flex-direction: column; gap: 12px; margin-top: 12px;"></div>
    </div>
HTML;

if (strpos($content, 'sectionAdminAccounts') === false) {
    $cNormalized = str_replace("\r\n", "\n", $content);
    if (strpos($cNormalized, $search2) !== false) {
        $cNormalized = str_replace($search2, $search2 . "\n\n" . $adminSectionHtml, $cNormalized);
        file_put_contents($empFile, $cNormalized);
        echo "sectionAdminAccounts added successfully.\n";
    } else {
        echo "Search 2 not found.\n";
    }
} else {
    echo "sectionAdminAccounts already present.\n";
}

