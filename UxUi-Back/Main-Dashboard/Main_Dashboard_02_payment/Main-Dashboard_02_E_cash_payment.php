<?php 
    $pth = "../"; 
    $active_page = "payment-subscription"; // Tells the sidebar to highlight this tab
    $page_title = "Cash Payment · Subscription Payment · WWJM Admin";
include '../UxUI-Back/Includes/header.php';  
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values)
     Wellawatta Jumma Mosque · Dashboard · Payment · Cash Payment
     =================================================================== */
  :root{
    --payment-cash-green-950:#0B2E24;
    --payment-cash-green-800:#123832;
    --payment-cash-green-700:#1B4B41;
    --payment-cash-gold-600:#B8923D;
    --payment-cash-gold-500:#C9A227;
    --payment-cash-gold-300:#E4C766;
    --payment-cash-cream-50:#FAF7F0;
    --payment-cash-cream-100:#F2EDE0;
    --payment-cash-white:#FFFFFF;
    --payment-cash-ink-900:#1E2B26;
    --payment-cash-ink-600:#5A6A62;
    --payment-cash-ink-400:#8B978F;
    --payment-cash-border:#E6E0D0;
    --payment-cash-radius-sm:8px;
    --payment-cash-radius-lg:22px;
    --payment-cash-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-cash-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-cash-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; 
  }

  .payment-cash-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  /* ---------- Topbar ---------- */
  .payment-cash-topbar{
    grid-area:topbar;
    background:var(--payment-cash-white);
    border-bottom:1px solid var(--payment-cash-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-cash-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-cash-green-950);
  }
  .payment-cash-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-cash-ink-400);}
  .payment-cash-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-cash-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-cash-cream-100);color:var(--payment-cash-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-cash-icon-btn:hover{background:var(--payment-cash-gold-300);}
  .payment-cash-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-cash-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    flex-direction:column;
  }

  .payment-cash-breadcrumb{font-size:12px;color:var(--payment-cash-ink-400);margin-bottom:16px;}
  .payment-cash-breadcrumb a{color:var(--payment-cash-ink-400);text-decoration:none;}
  .payment-cash-breadcrumb a:hover{color:var(--payment-cash-green-700);}
  .payment-cash-breadcrumb span{color:var(--payment-cash-green-700);font-weight:600;}

  .payment-cash-panel-wrapper{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 150px);
  }

  .payment-cash-panel{
    width:100%;
    max-width:580px;
    background:var(--payment-cash-cream-50);
    border-radius:var(--payment-cash-radius-lg);
    box-shadow:var(--payment-cash-shadow);
    overflow:hidden;
    border:1px solid var(--payment-cash-border);
  }

  .payment-cash-panel-header{
    background:linear-gradient(135deg,var(--payment-cash-green-800),var(--payment-cash-green-950));
    color:var(--payment-cash-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .payment-cash-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .payment-cash-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-cash-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-cash-panel-close:hover{background:rgba(250,247,240,0.12);}

  .payment-cash-body{
    padding:24px 32px 32px;
  }

  .payment-cash-info-row{
    display:flex;
    align-items:center;
    background:var(--payment-cash-cream-100);
    padding:14px 20px;
    margin-bottom:10px;
    border-radius:var(--payment-cash-radius-sm);
    font-size:14px;
    color:var(--payment-cash-ink-900);
  }
  .payment-cash-info-label{
    flex:1;
    font-weight:500;
  }
  .payment-cash-info-colon{
    padding:0 20px;
  }
  .payment-cash-info-value{
    flex:2;
    font-weight:600;
  }

  .payment-cash-due-section{
    text-align:center;
    margin:32px 0 24px;
  }
  .payment-cash-due-label{
    font-size:26px;
    font-weight:700;
    color:var(--payment-cash-ink-900);
    margin-bottom:10px;
  }
  .payment-cash-due-amount{
    font-size:32px;
    font-weight:700;
    color:var(--payment-cash-ink-900);
  }

  .payment-cash-input-group{
    margin-bottom:24px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
  }
  .payment-cash-input-label{
    display:block;
    font-size:13px;
    font-weight:700;
    color:var(--payment-cash-ink-900);
    margin-bottom:8px;
  }
  .payment-cash-input{
    width:100%;
    height:46px;
    border:1px solid var(--payment-cash-ink-900);
    border-radius:var(--payment-cash-radius-sm);
    padding:0 16px;
    font-size:14px;
    font-family:inherit;
    color:var(--payment-cash-ink-900);
    background:var(--payment-cash-white);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .payment-cash-input:focus{
    border-color:var(--payment-cash-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }

  .payment-cash-checkboxes{
    display:flex;
    flex-direction:column;
    gap:12px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 32px;
  }
  .payment-cash-checkbox-label{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:14px;
    font-weight:600;
    color:var(--payment-cash-ink-900);
    cursor:pointer;
    user-select:none;
  }
  .payment-cash-checkbox-label input[type="checkbox"]{
    width:18px;
    height:18px;
    accent-color:var(--payment-cash-green-700);
    cursor:pointer;
  }

  .payment-cash-actions{
    display:flex;
    gap:16px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
  }
  .payment-cash-btn{
    flex:1;
    height:50px;
    display:flex;align-items:center;justify-content:center;
    border-radius:var(--payment-cash-radius-sm);
    border:none;cursor:pointer;
    font-size:15px;font-weight:700;letter-spacing:0.01em;
    text-decoration:none;
    transition:transform .1s ease, box-shadow .15s ease, background .15s ease;
  }
  .payment-cash-btn:active{transform:translateY(1px);}
  
  .payment-cash-btn-cancel{
    background:var(--payment-cash-ink-600);
    color:var(--payment-cash-white);
  }
  .payment-cash-btn-cancel:hover{
    background:var(--payment-cash-ink-900);
  }
  
  .payment-cash-btn-process{
    background:var(--payment-cash-ink-600);
    color:var(--payment-cash-white);
  }
  .payment-cash-btn-process:hover{
    background:linear-gradient(135deg,var(--payment-cash-gold-500),var(--payment-cash-gold-600));
    color:var(--payment-cash-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }

  @media (max-width:900px){
    .payment-cash-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-cash-main{padding:26px 18px 50px;}
    .payment-cash-actions{flex-direction:column;}
  }
</style>

<div data-page="payment" id="Main_dashboard_02_E">

<div class="payment-cash-app">

   <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>

  <!-- ================= TOPBAR ================= -->
  <header class="payment-cash-topbar">
    <div class="payment-cash-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-cash-topbar-actions">
      <button class="payment-cash-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-cash-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-cash-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-cash-main">
    <p class="payment-cash-breadcrumb">
      <a href="payment.php">Dashboard</a> /
      <a href="payment.php">Payment</a> /
      <a href="payment-new.php">Create Payment</a> /
      <a href="payment-subscription.php">Subscription</a> /
      <span>Cash Payment</span>
    </p>

    <div class="payment-cash-panel-wrapper">
      <section class="payment-cash-panel" aria-label="Cash Payment For Subscription">
        
        <div class="payment-cash-panel-header">
          <div class="payment-cash-panel-title">
            Cash Payment For Subscription
          </div>
          <a class="payment-cash-panel-close" onclick="main_dashboard_02_D_OPEN()" title="Close" aria-label="Close">✕</a>
        </div>

        <div class="payment-cash-body">
          
          <div class="payment-cash-info-row">
            <div class="payment-cash-info-label">Member No</div>
            <div class="payment-cash-info-colon">:</div>
            <div class="payment-cash-info-value" id="cash-payment-member-no">000010237</div>
          </div>
          
          <div class="payment-cash-info-row">
            <div class="payment-cash-info-label">Name</div>
            <div class="payment-cash-info-colon">:</div>
            <div class="payment-cash-info-value" id="cash-payment-member-name">Sunt a ut porro aspe</div>
          </div>

          <div class="payment-cash-due-section">
            <div class="payment-cash-due-label">Due Amount</div>
            <div class="payment-cash-due-amount" id="cash-payment-due-amount">99.00</div>
          </div>

          <div class="payment-cash-input-group">
            <label class="payment-cash-input-label" for="cash-paying-amount">Paying Amount</label>
            <input type="text" class="payment-cash-input" id="cash-paying-amount" placeholder="0.00 some example amount hear">
          </div>

          <div class="payment-cash-checkboxes">
            <label class="payment-cash-checkbox-label">
              <input type="checkbox" id="cash-slip-sms"> E-Payment Slip Send By SMS
            </label>
            <label class="payment-cash-checkbox-label">
              <input type="checkbox" id="cash-slip-email"> E-Payment Slip Send By Email
            </label>
            <label class="payment-cash-checkbox-label">
              <input type="checkbox" id="cash-slip-print"> Print Payment Slip
            </label>
          </div>

          <div class="payment-cash-actions">
            <button class="payment-cash-btn payment-cash-btn-cancel" onclick="main_dashboard_02_D_OPEN()">Cancel</button>
            <button class="payment-cash-btn payment-cash-btn-process" onclick="processCashPayment()">Process</button>
          </div>

        </div>

      </section>
    </div>
  </main>

</div>

<!-- ================= FOOTER (shared component) ================= -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

<?php include 'JS/Main-Dashboard_02_E_JS.php'; ?>

</div>
