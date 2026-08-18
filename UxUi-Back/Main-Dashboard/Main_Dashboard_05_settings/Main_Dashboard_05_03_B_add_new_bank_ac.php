<?php 
    $pth = "../"; 
    $active_page = "settings-bank-account-new"; // Tells the sidebar to highlight this tab
    $page_title = "Add New Bank Account · WWJM Admin";
include '../UxUI-Back/Includes/header.php'; 
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Settings · Add New Bank Account
     =================================================================== */


  :root{
    --settings-bank-account-new-green-950:#0B2E24;
    --settings-bank-account-new-green-800:#123832;
    --settings-bank-account-new-green-700:#1B4B41;
    --settings-bank-account-new-gold-600:#B8923D;
    --settings-bank-account-new-gold-500:#C9A227;
    --settings-bank-account-new-gold-300:#E4C766;
    --settings-bank-account-new-cream-50:#FAF7F0;
    --settings-bank-account-new-cream-100:#F2EDE0;
    --settings-bank-account-new-white:#FFFFFF;
    --settings-bank-account-new-ink-900:#1E2B26;
    --settings-bank-account-new-ink-600:#5A6A62;
    --settings-bank-account-new-ink-400:#8B978F;
    --settings-bank-account-new-border:#E6E0D0;
    --settings-bank-account-new-danger:#B0453A;
    --settings-bank-account-new-radius-sm:8px;
    --settings-bank-account-new-radius-lg:22px;
    --settings-bank-account-new-shadow:0 6px 24px rgba(11,46,36,0.08);
    --settings-bank-account-new-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--settings-bank-account-new-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--settings-bank-account-new-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px;
  }

  .settings-bank-account-new-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  .settings-bank-account-new-topbar{
    grid-area:topbar;
    background:var(--settings-bank-account-new-white);
    border-bottom:1px solid var(--settings-bank-account-new-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .settings-bank-account-new-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--settings-bank-account-new-green-950);
  }
  .settings-bank-account-new-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--settings-bank-account-new-ink-400);}
  .settings-bank-account-new-topbar-actions{display:flex;align-items:center;gap:18px;}
  .settings-bank-account-new-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--settings-bank-account-new-cream-100);color:var(--settings-bank-account-new-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .settings-bank-account-new-icon-btn:hover{background:var(--settings-bank-account-new-gold-300);}
  .settings-bank-account-new-icon-btn svg{width:16px;height:16px;}

  .settings-bank-account-new-breadcrumb{font-size:12px;color:var(--settings-bank-account-new-ink-400);margin-bottom:16px;}
  .settings-bank-account-new-breadcrumb a{color:var(--settings-bank-account-new-ink-400);text-decoration:none;}
  .settings-bank-account-new-breadcrumb a:hover{color:var(--settings-bank-account-new-green-700);}
  .settings-bank-account-new-breadcrumb span{color:var(--settings-bank-account-new-green-700);font-weight:600;}

  .settings-bank-account-new-panel-header{
    background:linear-gradient(135deg,var(--settings-bank-account-new-green-800),var(--settings-bank-account-new-green-950));
    color:var(--settings-bank-account-new-cream-50);
    padding:24px 30px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .settings-bank-account-new-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .settings-bank-account-new-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--settings-bank-account-new-gold-300);}
  .settings-bank-account-new-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--settings-bank-account-new-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .settings-bank-account-new-panel-close:hover{background:rgba(250,247,240,0.12);}

  .settings-bank-account-new-btn{
    height:42px;padding:0 20px;
    border-radius:var(--settings-bank-account-new-radius-sm);
    border:none;cursor:pointer;
    font-size:13px;font-weight:700;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    white-space:nowrap;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease, color .15s ease;
  }
  .settings-bank-account-new-btn:active{transform:translateY(1px);}
  .settings-bank-account-new-btn-primary{
    background:linear-gradient(135deg,var(--settings-bank-account-new-gold-500),var(--settings-bank-account-new-gold-600));
    color:var(--settings-bank-account-new-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .settings-bank-account-new-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}
  .settings-bank-account-new-btn-ghost{
    background:var(--settings-bank-account-new-cream-100);
    color:var(--settings-bank-account-new-ink-900);
  }
  .settings-bank-account-new-btn-ghost:hover{background:var(--settings-bank-account-new-border);}

  @media (max-width:900px){
    .settings-bank-account-new-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
  }

  .settings-bank-account-new-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 64px);
  }

  .settings-bank-account-new-panel{
    width:100%;
    max-width:520px;
    background:var(--settings-bank-account-new-white);
    border-radius:var(--settings-bank-account-new-radius-lg);
    box-shadow:var(--settings-bank-account-new-shadow);
    overflow:hidden;
    border:1px solid var(--settings-bank-account-new-border);
  }

  .settings-bank-account-new-form{padding:28px 32px 30px;}

  .settings-bank-account-new-field-block{display:flex;flex-direction:column;gap:8px;margin-bottom:22px;}
  .settings-bank-account-new-field-block label{font-size:13.5px;font-weight:700;color:var(--settings-bank-account-new-ink-900);}
  .settings-bank-account-new-field-block input[type="text"],
  .settings-bank-account-new-field-block input[type="number"],
  .settings-bank-account-new-field-block textarea {
    border:1px solid var(--settings-bank-account-new-border);
    border-radius:var(--settings-bank-account-new-radius-sm);
    padding:0 16px;
    font-size:14px;font-family:inherit;
    color:var(--settings-bank-account-new-ink-900);
    background:var(--settings-bank-account-new-white);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .settings-bank-account-new-field-block input[type="text"],
  .settings-bank-account-new-field-block input[type="number"] {
    height:46px;
  }
  .settings-bank-account-new-field-block textarea {
    padding:12px 16px;
    resize:vertical;
    min-height:80px;
  }
  .settings-bank-account-new-field-block input:focus,
  .settings-bank-account-new-field-block textarea:focus {
    border-color:var(--settings-bank-account-new-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }
  .settings-bank-account-new-field-block.settings-bank-account-new-invalid input,
  .settings-bank-account-new-field-block.settings-bank-account-new-invalid textarea {border-color:var(--settings-bank-account-new-danger);}
  .settings-bank-account-new-error{font-size:11.5px;color:var(--settings-bank-account-new-danger);display:none;}
  .settings-bank-account-new-field-block.settings-bank-account-new-invalid .settings-bank-account-new-error{display:block;}

  .settings-bank-account-new-check-row{display:flex;align-items:center;gap:24px;margin-bottom:26px;}
  .settings-bank-account-new-check-item{display:flex;align-items:center;gap:9px;}
  .settings-bank-account-new-check-item input{
    width:19px;height:19px;flex:0 0 19px;
    accent-color:var(--settings-bank-account-new-green-700);
    cursor:pointer;
  }
  .settings-bank-account-new-check-item label{font-size:13.5px;font-weight:700;color:var(--settings-bank-account-new-ink-900);cursor:pointer;}

  .settings-bank-account-new-actions{display:flex;align-items:center;gap:12px;}
  .settings-bank-account-new-actions .settings-bank-account-new-btn{flex:1;justify-content:center;}

  .settings-bank-account-new-toast{
    position:fixed;top:20px;right:20px;
    background:var(--settings-bank-account-new-green-950);color:var(--settings-bank-account-new-cream-50);
    border-left:4px solid var(--settings-bank-account-new-gold-500);
    padding:14px 18px;border-radius:var(--settings-bank-account-new-radius-sm);
    font-size:13px;font-weight:600;box-shadow:var(--settings-bank-account-new-shadow);
    display:none;z-index:20;
  }

</style>

<div data-page="settings" id="Main_Dashboard_05_03_B">

<div class="settings-bank-account-new-app">

    <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>

  

  <!-- ================= TOPBAR ================= -->
  <header class="settings-bank-account-new-topbar">
    <div class="settings-bank-account-new-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="settings-bank-account-new-topbar-actions">
      <button class="settings-bank-account-new-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="settings-bank-account-new-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="settings-bank-account-new-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="settings-bank-account-new-main">
    <section class="settings-bank-account-new-panel" aria-label="Add New Bank Account">

      <div class="settings-bank-account-new-panel-header">
        <div class="settings-bank-account-new-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10 12 4l9 6"/><path d="M4.5 10v9M9 10v9M15 10v9M19.5 10v9"/><path d="M3 19h18"/></svg>
          Add New Bank Account
        </div>
        <button type="button" class="settings-bank-account-new-panel-close" onclick="Settings_body_01_D_07_OPEN()" title="Close" aria-label="Close">✕</button>
      </div>

      <form class="settings-bank-account-new-form" id="Settings_body_01_D_08_from_01" onsubmit="Settings_body_01_D_08_from_01_SUMBIT(event)" novalidate>
        <div id="Settings_body_01_D_02_position_id"></div>
        <div class="settings-bank-account-new-toast" id="Settings_body_01_D_08_error_msg_body" style="display: none; background: var(--settings-bank-account-new-danger); border-left-color: var(--settings-bank-account-new-ink-900); position: static; margin-bottom: 20px;">
            <p id="Settings_body_01_D_08_error_msg" style="margin:0;"></p>
        </div>
        
        <div class="settings-bank-account-new-field-block" id="settings-bank-account-new-field-bank">
          <label for="Settings_body_01_D_08_bank_name">Bank Name</label>
          <input type="text" id="Settings_body_01_D_08_bank_name" placeholder="e.g. Bank of Ceylon" required>
        </div>
        <div class="settings-bank-account-new-field-block" id="settings-bank-account-new-field-branch">
          <label for="Settings_body_01_D_08_branch">Branch</label>
          <input type="text" id="Settings_body_01_D_08_branch" placeholder="e.g. Wellawatta" required>
        </div>
        <div class="settings-bank-account-new-field-block" id="settings-bank-account-new-field-account">
          <label for="Settings_body_01_D_08_ac_no">Account Number</label>
          <input type="number" id="Settings_body_01_D_08_ac_no" placeholder="e.g. 001234567890" required>
        </div>
        <div class="settings-bank-account-new-field-block" id="settings-bank-account-new-field-holder">
          <label for="Settings_body_01_D_08_ac_name">Account Holder Name</label>
          <input type="text" id="Settings_body_01_D_08_ac_name" placeholder="e.g. Wellawatta Jumma Mosque" required>
        </div>
        <div class="settings-bank-account-new-field-block" id="settings-bank-account-new-field-swift">
          <label for="Settings_body_01_D_08_swif_code">Swift Code</label>
          <input type="text" id="Settings_body_01_D_08_swif_code" placeholder="e.g. BOCLXX" required>
        </div>
        
        <div class="settings-bank-account-new-check-row">
          <div class="settings-bank-account-new-check-item">
            <input type="checkbox" id="Settings_body_01_D_08_current_ac" name="Settings_body_01_D_08_current_ac">
            <label for="Settings_body_01_D_08_current_ac">Current Account</label>
          </div>
          <div class="settings-bank-account-new-check-item">
            <input type="checkbox" id="Settings_body_01_D_08_savings_ac" name="Settings_body_01_D_08_savings_ac">
            <label for="Settings_body_01_D_08_savings_ac">Savings Account</label>
          </div>
        </div>

        <div class="settings-bank-account-new-field-block" id="settings-bank-account-new-field-desc">
          <label for="Settings_body_01_D_08_dis">Description</label>
          <textarea id="Settings_body_01_D_08_dis" placeholder="Enter Description" required></textarea>
        </div>

        <div class="settings-bank-account-new-actions">
          <button type="button" class="settings-bank-account-new-btn settings-bank-account-new-btn-ghost" onclick="Settings_body_01_D_07_OPEN()">Cancel</button>
          <button type="submit" class="settings-bank-account-new-btn settings-bank-account-new-btn-primary" id="Settings_body_01_D_08_btn">Save</button>
        </div>
      </form>


    </section>

  </main>

</div>

<div class="settings-bank-account-new-toast" id="settings-bank-account-new-toast">Saved successfully.</div>
<?php include 'JS/Main_Dashboard_05_03_B_JS.php'; ?>

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->


<!-- ================= FOOTER (shared component) =================
     PHP projects: delete this div and put <?php include 'footer.php'; ?>
     in its place instead. -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

</div>








