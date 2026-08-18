<?php 
    $pth = "../"; 
    $active_page = "payment-new"; // Tells the sidebar to highlight this tab
    $page_title = "Create Payment · WWJM Admin";
include '../UxUI-Back/Includes/header.php';  
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Create Payment
     =================================================================== */
  :root{
    --payment-new-green-950:#0B2E24;
    --payment-new-green-800:#123832;
    --payment-new-green-700:#1B4B41;
    --payment-new-gold-600:#B8923D;
    --payment-new-gold-500:#C9A227;
    --payment-new-gold-300:#E4C766;
    --payment-new-cream-50:#FAF7F0;
    --payment-new-cream-100:#F2EDE0;
    --payment-new-white:#FFFFFF;
    --payment-new-ink-900:#1E2B26;
    --payment-new-ink-600:#5A6A62;
    --payment-new-ink-400:#8B978F;
    --payment-new-border:#E6E0D0;
    --payment-new-radius-sm:8px;
    --payment-new-radius-lg:22px;
    --payment-new-shadow:0 6px 24px rgba(11,46,36,0.08);
    --wwjm-footer-green-950:#0B2E24;
    --wwjm-footer-cream-50:#FAF7F0;
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-new-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-new-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; /* keeps content clear of the fixed shared footer */
  }

  .payment-new-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  /* Sidebar markup/styles live in sidebar.php (shared component). */

  /* ---------- Topbar ---------- */
  .payment-new-topbar{
    grid-area:topbar;
    background:var(--payment-new-white);
    border-bottom:1px solid var(--payment-new-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-new-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-new-green-950);
  }
  .payment-new-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-new-ink-400);}
  .payment-new-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-new-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-new-cream-100);color:var(--payment-new-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-new-icon-btn:hover{background:var(--payment-new-gold-300);}
  .payment-new-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-new-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 64px);
  }

  .payment-new-panel{
    width:100%;
    max-width:520px;
    background:var(--payment-new-white);
    border-radius:var(--payment-new-radius-lg);
    box-shadow:var(--payment-new-shadow);
    overflow:hidden;
    border:1px solid var(--payment-new-border);
  }

  .payment-new-panel-header{
    background:linear-gradient(135deg,var(--payment-new-green-800),var(--payment-new-green-950));
    color:var(--payment-new-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .payment-new-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:26px;font-weight:600;
  }
  .payment-new-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--payment-new-gold-300);}
  .payment-new-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-new-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-new-panel-close:hover{background:rgba(250,247,240,0.12);}

  .payment-new-options{
    display:flex;flex-direction:column;gap:14px;
    padding:28px 32px 32px;
  }
  .payment-new-option{
    height:52px;
    display:flex;align-items:center;justify-content:center;
    border-radius:var(--payment-new-radius-sm);
    border:none;cursor:pointer;
    background:var(--payment-new-green-800);
    color:var(--payment-new-cream-50);
    font-size:14px;font-weight:700;letter-spacing:0.01em;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .payment-new-option:hover{
    background:var(--payment-new-green-950);
    box-shadow:0 4px 14px rgba(11,46,36,0.25);
  }
  .payment-new-option:active{transform:translateY(1px);}
  .payment-new-option-back{
    background:var(--payment-new-cream-100);
    color:var(--payment-new-ink-900);
  }
  .payment-new-option-back:hover{
    background:var(--payment-new-border);
    box-shadow:none;
  }

  @media (max-width:900px){
    .payment-new-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-new-main{min-height:calc(100vh - 64px);padding:26px 18px 50px;}
  }
</style>

<div data-page="payment" id="Main_dashboard_02_B">

<div class="payment-new-app">

   <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>


  <!-- ================= TOPBAR ================= -->
  <header class="payment-new-topbar">
    <div class="payment-new-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-new-topbar-actions">
      <button class="payment-new-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-new-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-new-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-new-main">
    <section class="payment-new-panel" aria-label="Create payment">

      <div class="payment-new-panel-header">
        <div class="payment-new-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="6" width="18" height="12" rx="1.8"/><path d="M3 10h18"/></svg>
          Create Payment.
        </div>
        <a class="payment-new-panel-close" onclick="main_dashboard_02_A_OPEN()">✕</a>
      </div>

      <div class="payment-new-options">
        <input type="hidden" id="DashBord_Payment_body_paying_type_default" value="subcription">
        <a class="payment-new-option" onclick="selectPaymentReason('subcription')">Subscription</a>
        <a class="payment-new-option" onclick="selectPaymentReason('Zakath')">Zakatha</a>
        <a class="payment-new-option" onclick="selectPaymentReason('Donation')">Donation</a>
        <a class="payment-new-option" onclick="selectPaymentReason('Projects')">Projects</a>
        <a class="payment-new-option payment-new-option-back" onclick="main_dashboard_02_A_OPEN()">Back</a>
      </div>

    </section>
  </main>

</div>

<script type="text/javascript">
function selectPaymentReason(reason) {
    var el = document.getElementById("DashBord_Payment_body_paying_type_default");
    if (!el) {
        el = document.createElement("input");
        el.type = "hidden";
        el.id = "DashBord_Payment_body_paying_type_default";
        document.body.appendChild(el);
    }
    el.value = reason;

    if (typeof main_dashboard_02_C_OPEN === "function") {
        main_dashboard_02_C_OPEN();
    }
}
</script>

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->


<!-- ================= FOOTER (shared component) =================
     PHP projects: delete this div and put <?php include 'footer.php'; ?>
     in its place instead. -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

</div>
