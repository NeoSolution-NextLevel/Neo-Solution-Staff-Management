<?php 
    $pth = "../"; 
    $active_page = "payment-subscription"; // Tells the sidebar to highlight this tab
    $page_title = "Choose Payment Type · Subscription Payment · WWJM Admin";
include_once __DIR__ . '/../../Includes/header.php';  
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values)
     Wellawatta Jumma Mosque · Dashboard · Payment · Choose Payment Type
     =================================================================== */
  :root{
    --payment-type-green-950:#0B2E24;
    --payment-type-green-800:#123832;
    --payment-type-green-700:#1B4B41;
    --payment-type-gold-600:#B8923D;
    --payment-type-gold-500:#C9A227;
    --payment-type-gold-300:#E4C766;
    --payment-type-cream-50:#FAF7F0;
    --payment-type-cream-100:#F2EDE0;
    --payment-type-white:#FFFFFF;
    --payment-type-ink-900:#1E2B26;
    --payment-type-ink-600:#5A6A62;
    --payment-type-ink-400:#8B978F;
    --payment-type-border:#E6E0D0;
    --payment-type-radius-sm:8px;
    --payment-type-radius-lg:22px;
    --payment-type-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-type-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-type-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; 
  }

  .payment-type-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  /* ---------- Topbar ---------- */
  .payment-type-topbar{
    grid-area:topbar;
    background:var(--payment-type-white);
    border-bottom:1px solid var(--payment-type-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-type-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-type-green-950);
  }
  .payment-type-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-type-ink-400);}
  .payment-type-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-type-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-type-cream-100);color:var(--payment-type-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-type-icon-btn:hover{background:var(--payment-type-gold-300);}
  .payment-type-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-type-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    flex-direction:column;
  }

  .payment-type-breadcrumb{font-size:12px;color:var(--payment-type-ink-400);margin-bottom:16px;}
  .payment-type-breadcrumb a{color:var(--payment-type-ink-400);text-decoration:none;}
  .payment-type-breadcrumb a:hover{color:var(--payment-type-green-700);}
  .payment-type-breadcrumb span{color:var(--payment-type-green-700);font-weight:600;}

  .payment-type-panel-wrapper{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 150px);
  }

  .payment-type-panel{
    width:100%;
    max-width:520px;
    background:var(--payment-type-white);
    border-radius:var(--payment-type-radius-lg);
    box-shadow:var(--payment-type-shadow);
    overflow:hidden;
    border:1px solid var(--payment-type-border);
  }

  .payment-type-panel-header{
    background:linear-gradient(135deg,var(--payment-type-green-800),var(--payment-type-green-950));
    color:var(--payment-type-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .payment-type-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .payment-type-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--payment-type-gold-300);}
  .payment-type-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-type-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-type-panel-close:hover{background:rgba(250,247,240,0.12);}

  .payment-type-options{
    display:flex;flex-direction:column;gap:14px;
    padding:32px;
  }
  .payment-type-option{
    height:56px;
    display:flex;align-items:center;justify-content:center;gap:12px;
    border-radius:var(--payment-type-radius-sm);
    border:none;cursor:pointer;
    background:var(--payment-type-green-800);
    color:var(--payment-type-cream-50);
    font-size:15px;font-weight:600;letter-spacing:0.01em;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .payment-type-option svg{width:18px;height:18px;color:var(--payment-type-gold-300);}
  .payment-type-option:hover{
    background:var(--payment-type-green-950);
    box-shadow:0 4px 14px rgba(11,46,36,0.25);
  }
  .payment-type-option:active{transform:translateY(1px);}
  
  .payment-type-option-back{
    background:var(--payment-type-cream-100);
    color:var(--payment-type-ink-900);
    margin-top:8px;
  }
  .payment-type-option-back:hover{
    background:var(--payment-type-border);
    box-shadow:none;
  }
  .payment-type-option-back svg{color:var(--payment-type-ink-600);}

  @media (max-width:900px){
    .payment-type-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-type-main{padding:26px 18px 50px;}
  }
</style>

<div data-page="payment" id="Main_dashboard_02_D">

<div class="payment-type-app">

   <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>

  <!-- ================= TOPBAR ================= -->
  <header class="payment-type-topbar">
    <div class="payment-type-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-type-topbar-actions">
      <button class="payment-type-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-type-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-type-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-type-main">
    <p class="payment-type-breadcrumb">
      <a href="payment.php">Dashboard</a> /
      <a href="payment.php">Payment</a> /
      <a href="payment-new.php">Create Payment</a> /
      <a href="payment-subscription.php">Subscription</a> /
      <span>Choose Payment Type</span>
    </p>

    <div class="payment-type-panel-wrapper">
      <section class="payment-type-panel" aria-label="Choose Payment Type">
        
        <div class="payment-type-panel-header">
          <div class="payment-type-panel-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            Subscription Payment
          </div>
          <a class="payment-type-panel-close" onclick="main_dashboard_02_C_OPEN()" title="Close" aria-label="Close">✕</a>
        </div>

        <div class="payment-type-options">
          <button class="payment-type-option" onclick="openCashPayment()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
            Cash
          </button>
          
          <button class="payment-type-option" onclick="main_dashboard_02_F_OPEN()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 6l7-3 7 3"/><path d="M4 10v11"/><path d="M20 10v11"/><path d="M8 14v3"/><path d="M12 14v3"/><path d="M16 14v3"/></svg>
            Bank Deposit
          </button>

          <button class="payment-type-option" onclick="selectPaymentType('card_link')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            Send Card Payment Link
          </button>

          <button class="payment-type-option payment-type-option-back" onclick="main_dashboard_02_C_OPEN()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back
          </button>
        </div>

      </section>
    </div>
  </main>

</div>

<!-- ================= FOOTER (shared component) ================= -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

<script>
  function selectPaymentType(type) {
    console.log("Selected payment type:", type);
    // You can redirect or trigger a modal here
    // e.g. window.location.href = "payment-process.php?type=" + type;
  }
</script>

</div>
