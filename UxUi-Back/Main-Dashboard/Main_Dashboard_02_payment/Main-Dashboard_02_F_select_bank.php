<?php 
    $pth = "../"; 
    $active_page = "payment-subscription"; // Tells the sidebar to highlight this tab
    $page_title = "Select Bank Account · Subscription Payment · WWJM Admin";
include_once __DIR__ . '/../../Includes/header.php';  
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values)
     Wellawatta Jumma Mosque · Dashboard · Payment · Select Bank
     =================================================================== */
  :root{
    --payment-bank-green-950:#0B2E24;
    --payment-bank-green-800:#123832;
    --payment-bank-green-700:#1B4B41;
    --payment-bank-gold-600:#B8923D;
    --payment-bank-gold-500:#C9A227;
    --payment-bank-gold-300:#E4C766;
    --payment-bank-cream-50:#FAF7F0;
    --payment-bank-cream-100:#F2EDE0;
    --payment-bank-white:#FFFFFF;
    --payment-bank-ink-900:#1E2B26;
    --payment-bank-ink-600:#5A6A62;
    --payment-bank-ink-400:#8B978F;
    --payment-bank-border:#E6E0D0;
    --payment-bank-radius-sm:8px;
    --payment-bank-radius-lg:22px;
    --payment-bank-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-bank-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-bank-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; 
  }

  .payment-bank-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  /* ---------- Topbar ---------- */
  .payment-bank-topbar{
    grid-area:topbar;
    background:var(--payment-bank-white);
    border-bottom:1px solid var(--payment-bank-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-bank-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-bank-green-950);
  }
  .payment-bank-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-bank-ink-400);}
  .payment-bank-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-bank-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-bank-cream-100);color:var(--payment-bank-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-bank-icon-btn:hover{background:var(--payment-bank-gold-300);}
  .payment-bank-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-bank-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    flex-direction:column;
  }

  .payment-bank-breadcrumb{font-size:12px;color:var(--payment-bank-ink-400);margin-bottom:16px;}
  .payment-bank-breadcrumb a{color:var(--payment-bank-ink-400);text-decoration:none;}
  .payment-bank-breadcrumb a:hover{color:var(--payment-bank-green-700);}
  .payment-bank-breadcrumb span{color:var(--payment-bank-green-700);font-weight:600;}

  .payment-bank-panel-wrapper{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 150px);
  }

  .payment-bank-panel{
    width:100%;
    max-width:600px;
    background:var(--payment-bank-cream-50);
    border-radius:var(--payment-bank-radius-lg);
    box-shadow:var(--payment-bank-shadow);
    overflow:hidden;
    border:1px solid var(--payment-bank-border);
    display: flex;
    flex-direction: column;
    max-height: 80vh;
  }

  .payment-bank-panel-header{
    background:linear-gradient(135deg,var(--payment-bank-green-800),var(--payment-bank-green-950));
    color:var(--payment-bank-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
    flex-shrink: 0;
  }
  .payment-bank-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .payment-bank-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-bank-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-bank-panel-close:hover{background:rgba(250,247,240,0.12);}

  .payment-bank-body{
    padding:24px;
    overflow-y:auto;
    flex:1;
  }

  /* Custom scrollbar for bank list */
  .payment-bank-body::-webkit-scrollbar {
    width: 8px;
  }
  .payment-bank-body::-webkit-scrollbar-track {
    background: transparent;
  }
  .payment-bank-body::-webkit-scrollbar-thumb {
    background: var(--payment-bank-ink-400);
    border-radius: 4px;
  }
  .payment-bank-body::-webkit-scrollbar-thumb:hover {
    background: var(--payment-bank-ink-600);
  }

  .payment-bank-card{
    background:var(--payment-bank-white);
    border:1px solid var(--payment-bank-border);
    border-radius:var(--payment-bank-radius-sm);
    margin-bottom:16px;
    overflow:hidden;
    display: flex;
    flex-direction: column;
    transition: border-color .15s ease, box-shadow .15s ease;
  }
  
  .payment-bank-card:hover{
    border-color: var(--payment-bank-gold-500);
    box-shadow: 0 4px 12px rgba(11,46,36,0.06);
  }

  .payment-bank-row{
    display:flex;
    align-items:center;
    padding:12px 20px;
    font-size:14px;
    color:var(--payment-bank-ink-900);
  }
  /* Alternating row colors within the card */
  .payment-bank-row:nth-child(odd){
    background:var(--payment-bank-cream-100);
  }
  .payment-bank-row:nth-child(even){
    background:var(--payment-bank-white);
  }

  .payment-bank-label{
    flex: 1;
    font-weight: 700;
  }
  .payment-bank-colon{
    padding: 0 20px;
    font-weight: 700;
  }
  .payment-bank-value{
    flex: 2;
  }

  .payment-bank-footer{
    padding:14px 20px;
    display:flex;
    justify-content:flex-end;
    background:var(--payment-bank-white); /* matching the mock footer */
    border-top:1px solid var(--payment-bank-border);
  }

  .payment-bank-btn-select{
    height:38px;
    padding:0 24px;
    border-radius:var(--payment-bank-radius-sm);
    border:none;
    cursor:pointer;
    background:var(--payment-bank-ink-600);
    color:var(--payment-bank-white);
    font-size:13px;
    font-weight:700;
    letter-spacing:0.02em;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .payment-bank-btn-select:hover{
    background:linear-gradient(135deg,var(--payment-bank-gold-500),var(--payment-bank-gold-600));
    color:var(--payment-bank-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .payment-bank-btn-select:active{
    transform:translateY(1px);
  }

  @media (max-width:900px){
    .payment-bank-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-bank-main{padding:26px 18px 50px;}
  }
</style>

<div data-page="payment" id="Main_dashboard_02_F">

<div class="payment-bank-app">

   <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>

  <!-- ================= TOPBAR ================= -->
  <header class="payment-bank-topbar">
    <div class="payment-bank-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-bank-topbar-actions">
      <button class="payment-bank-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-bank-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-bank-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-bank-main">
    <p class="payment-bank-breadcrumb">
      <a href="payment.php">Dashboard</a> /
      <a href="payment.php">Payment</a> /
      <a href="payment-new.php">Create Payment</a> /
      <a href="payment-subscription.php">Subscription</a> /
      <span>Select Deposit Bank Account</span>
    </p>

    <div class="payment-bank-panel-wrapper">
      <section class="payment-bank-panel" aria-label="Select Deposit Bank Account">
        
        <div class="payment-bank-panel-header">
          <div class="payment-bank-panel-title">
            Select Deposit Bank Account.
          </div>
          <a class="payment-bank-panel-close" onclick="main_dashboard_02_D_OPEN()" title="Close" aria-label="Close">✕</a>
        </div>

        <div class="payment-bank-body" id="payment-bank-list">
          
        </div>

      </section>
    </div>
  </main>

</div>

<!-- ================= FOOTER (shared component) ================= -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

<?php include __DIR__ . '/JS/Main-Dashboard_02_F_JS.php'; ?>

</div>


