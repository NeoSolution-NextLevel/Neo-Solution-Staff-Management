<?php 
    $pth = "../"; 
    $active_page = "payment-subscription"; // Tells the sidebar to highlight this tab
    $page_title = "Submit Bank Deposit · Subscription Payment · WWJM Admin";
include '../UxUI-Back/Includes/header.php';  
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values)
     Wellawatta Jumma Mosque · Dashboard · Payment · Submit Bank Deposit
     =================================================================== */
  :root{
    --payment-deposit-green-950:#0B2E24;
    --payment-deposit-green-800:#123832;
    --payment-deposit-green-700:#1B4B41;
    --payment-deposit-gold-600:#B8923D;
    --payment-deposit-gold-500:#C9A227;
    --payment-deposit-gold-300:#E4C766;
    --payment-deposit-cream-50:#FAF7F0;
    --payment-deposit-cream-100:#F2EDE0;
    --payment-deposit-white:#FFFFFF;
    --payment-deposit-ink-900:#1E2B26;
    --payment-deposit-ink-600:#5A6A62;
    --payment-deposit-ink-400:#8B978F;
    --payment-deposit-border:#E6E0D0;
    --payment-deposit-radius-sm:8px;
    --payment-deposit-radius-lg:22px;
    --payment-deposit-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-deposit-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-deposit-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; 
  }

  .payment-deposit-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  /* ---------- Topbar ---------- */
  .payment-deposit-topbar{
    grid-area:topbar;
    background:var(--payment-deposit-white);
    border-bottom:1px solid var(--payment-deposit-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-deposit-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-deposit-green-950);
  }
  .payment-deposit-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-deposit-ink-400);}
  .payment-deposit-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-deposit-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-deposit-cream-100);color:var(--payment-deposit-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-deposit-icon-btn:hover{background:var(--payment-deposit-gold-300);}
  .payment-deposit-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-deposit-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    flex-direction:column;
  }

  .payment-deposit-breadcrumb{font-size:12px;color:var(--payment-deposit-ink-400);margin-bottom:16px;}
  .payment-deposit-breadcrumb a{color:var(--payment-deposit-ink-400);text-decoration:none;}
  .payment-deposit-breadcrumb a:hover{color:var(--payment-deposit-green-700);}
  .payment-deposit-breadcrumb span{color:var(--payment-deposit-green-700);font-weight:600;}

  .payment-deposit-panel-wrapper{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 150px);
  }

  .payment-deposit-panel{
    width:100%;
    max-width:540px;
    background:var(--payment-deposit-cream-50);
    border-radius:var(--payment-deposit-radius-lg);
    box-shadow:var(--payment-deposit-shadow);
    overflow:hidden;
    border:1px solid var(--payment-deposit-border);
  }

  .payment-deposit-panel-header{
    background:linear-gradient(135deg,var(--payment-deposit-green-800),var(--payment-deposit-green-950));
    color:var(--payment-deposit-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .payment-deposit-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .payment-deposit-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-deposit-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-deposit-panel-close:hover{background:rgba(250,247,240,0.12);}

  .payment-deposit-body{
    padding:24px 32px;
  }

  .payment-deposit-form-group{
    margin-bottom:16px;
  }
  .payment-deposit-label{
    display:block;
    font-size:13.5px;
    font-weight:700;
    color:var(--payment-deposit-ink-900);
    margin-bottom:6px;
  }
  .payment-deposit-input, .payment-deposit-textarea{
    width:100%;
    border:1px solid var(--payment-deposit-ink-900);
    border-radius:var(--payment-deposit-radius-sm);
    padding:12px 16px;
    font-size:14px;
    font-family:inherit;
    color:var(--payment-deposit-ink-900);
    background:var(--payment-deposit-white);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .payment-deposit-input:focus, .payment-deposit-textarea:focus{
    border-color:var(--payment-deposit-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }
  .payment-deposit-textarea{
    resize:vertical;
    min-height:90px;
  }

  .payment-deposit-upload-section{
    background:var(--payment-deposit-cream-100);
    padding:20px;
    border-radius:var(--payment-deposit-radius-sm);
    margin-bottom:24px;
  }
  .payment-deposit-image-preview{
    width:100%;
    height:140px;
    background:var(--payment-deposit-ink-600);
    color:var(--payment-deposit-white);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    font-weight:600;
    border-radius:var(--payment-deposit-radius-sm);
    margin-bottom:16px;
    position:relative;
  }
  .payment-deposit-image-preview-icon{
    position:absolute;
    bottom:10px;
    left:10px;
    width:32px;
    height:32px;
    opacity:0.4;
  }
  
  .payment-deposit-upload-actions{
    display:flex;
    gap:12px;
  }
  .payment-deposit-btn-upload{
    flex:3;
    height:42px;
    background:var(--payment-deposit-ink-600);
    color:var(--payment-deposit-white);
    border:none;
    border-radius:var(--payment-deposit-radius-sm);
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:background .15s ease;
  }
  .payment-deposit-btn-scan{
    flex:2;
    height:42px;
    background:var(--payment-deposit-ink-600);
    color:var(--payment-deposit-white);
    border:none;
    border-radius:var(--payment-deposit-radius-sm);
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:background .15s ease;
  }
  .payment-deposit-btn-upload:hover, .payment-deposit-btn-scan:hover{
    background:var(--payment-deposit-ink-900);
  }

  .payment-deposit-footer-actions{
    display:flex;
    gap:16px;
  }
  .payment-deposit-btn-cancel, .payment-deposit-btn-submit{
    flex:1;
    height:50px;
    display:flex;align-items:center;justify-content:center;
    border-radius:var(--payment-deposit-radius-sm);
    border:none;cursor:pointer;
    font-size:15px;font-weight:700;letter-spacing:0.01em;
    text-decoration:none;
    transition:transform .1s ease, box-shadow .15s ease, background .15s ease;
  }
  .payment-deposit-btn-cancel{
    background:var(--payment-deposit-ink-600);
    color:var(--payment-deposit-white);
  }
  .payment-deposit-btn-cancel:hover{
    background:var(--payment-deposit-ink-900);
  }
  
  .payment-deposit-btn-submit{
    background:var(--payment-deposit-ink-600);
    color:var(--payment-deposit-white);
  }
  .payment-deposit-btn-submit:hover{
    background:linear-gradient(135deg,var(--payment-deposit-gold-500),var(--payment-deposit-gold-600));
    color:var(--payment-deposit-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .payment-deposit-btn-cancel:active, .payment-deposit-btn-submit:active{
    transform:translateY(1px);
  }

  @media (max-width:900px){
    .payment-deposit-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-deposit-main{padding:26px 18px 50px;}
    .payment-deposit-footer-actions{flex-direction:column;}
  }
</style>

<div data-page="payment" id="Main_dashboard_02_G">

<div class="payment-deposit-app">

   <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>

  <!-- ================= TOPBAR ================= -->
  <header class="payment-deposit-topbar">
    <div class="payment-deposit-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-deposit-topbar-actions">
      <button class="payment-deposit-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-deposit-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-deposit-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-deposit-main">
    <p class="payment-deposit-breadcrumb">
      <a href="payment.php">Dashboard</a> /
      <a href="payment.php">Payment</a> /
      <a href="payment-new.php">Create Payment</a> /
      <a href="payment-subscription.php">Subscription</a> /
      <span>Bank Deposit</span>
    </p>

    <div class="payment-deposit-panel-wrapper">
      <section class="payment-deposit-panel" aria-label="Bank Deposit">
        
        <div class="payment-deposit-panel-header">
          <div class="payment-deposit-panel-title">
            Bank Deposit..
          </div>
          <a class="payment-deposit-panel-close" onclick="main_dashboard_02_F_OPEN()" title="Close" aria-label="Close">✕</a>
        </div>

        <div class="payment-deposit-body">
          <input type="hidden" id="DashBord_Payment_body_01_B_05_bank_account_details_id" value="">
          <input type="hidden" id="DashBord_Payment_body_01_B_05_bank_name" value="">
          <input type="hidden" id="DashBord_Payment_body_01_B_05_branch_name" value="">
          <input type="hidden" id="DashBord_Payment_body_01_B_05_ac_no" value="">
          
          <div class="payment-deposit-form-group">
            <label class="payment-deposit-label" for="deposit-amount">Amount Has Paid</label>
            <input type="text" class="payment-deposit-input" id="deposit-amount" placeholder="0.00 some example amount hear">
          </div>

          <div class="payment-deposit-form-group">
            <label class="payment-deposit-label" for="deposit-description">Description</label>
            <textarea class="payment-deposit-textarea" id="deposit-description" placeholder="text somthing here..."></textarea>
          </div>

          <div class="payment-deposit-upload-section">
            <div class="payment-deposit-image-preview" id="deposit-image-preview-box">
              <svg class="payment-deposit-image-preview-icon" id="deposit-image-preview-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C9 2 8.5 5 8.5 5H6v2h12V5h-2.5S15 2 12 2zm-7 7v11h14V9H5z" opacity="0.3"/>
              </svg>
              <span id="deposit-image-preview-text">Item Image Not Found</span>
              <img id="deposit-image-preview-img" style="display:none; width:100%; height:100%; object-fit:contain; border-radius:var(--payment-deposit-radius-sm);" alt="Deposit slip preview">
            </div>
            <div class="payment-deposit-upload-actions">
              <button type="button" class="payment-deposit-btn-upload" onclick="document.getElementById('deposit-file-upload').click()">Upload Image</button>
              <input type="file" id="deposit-file-upload" style="display:none;" accept="image/*" onchange="previewDepositImage(this)">
              <input type="hidden" id="deposit-image-path-hidden" value="">
              <button type="button" class="payment-deposit-btn-scan" onclick="document.getElementById('deposit-file-upload').click()">Scan</button>
            </div>
          </div>

          <div class="payment-deposit-footer-actions">
            <button type="button" class="payment-deposit-btn-cancel" onclick="main_dashboard_02_F_OPEN()">Cancel</button>
            <button type="button" class="payment-deposit-btn-submit" onclick="submitBankDeposit()">Submit</button>
          </div>

        </div>

      </section>
    </div>
  </main>

</div>

<?php include __DIR__ . '/JS/Main-Dashboard_02_G_JS.php'; ?>


</div>


