<?php
$pth = "../";
$active_page = "payment-list";
$page_title = "Payment Slip View · WWJM Admin";

include_once __DIR__ . '/../../Includes/header.php'; 

// TODO: replace with a real lookup once a DB layer is wired up.
$payment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>


<style>
  /* ===================================================================
     WWJM Admin — Design tokens
     Wellawatta Jumma Mosque · Dashboard · Payment Slip View
     =================================================================== */
  :root{
    --payment-slip-green-950:#0B2E24;
    --payment-slip-green-800:#123832;
    --payment-slip-green-700:#1B4B41;
    --payment-slip-green-600:#245F52;
    --payment-slip-gold-600:#B8923D;
    --payment-slip-gold-500:#C9A227;
    --payment-slip-gold-300:#E4C766;
    --payment-slip-cream-50:#FAF7F0;
    --payment-slip-cream-100:#F2EDE0;
    --payment-slip-white:#FFFFFF;
    --payment-slip-ink-900:#1E2B26;
    --payment-slip-ink-600:#5A6A62;
    --payment-slip-ink-400:#8B978F;
    --payment-slip-border:#E6E0D0;
    --payment-slip-radius-sm:6px;
    --payment-slip-radius-md:12px;
    --payment-slip-radius-lg:22px;
    --payment-slip-shadow:0 6px 24px rgba(11,46,36,0.08);
    --payment-slip-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-slip-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-slip-ink-900);
    -webkit-font-smoothing:antialiased;
  }

  .payment-slip-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  /* ---------- Topbar ---------- */
  .payment-slip-topbar{
    grid-area:topbar;
    background:var(--payment-slip-white);
    border-bottom:1px solid var(--payment-slip-border);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
  }
  .payment-slip-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;
    font-weight:600;
    margin:0;
    color:var(--payment-slip-green-950);
  }
  .payment-slip-topbar-heading p{
    margin:1px 0 0;
    font-size:11.5px;
    color:var(--payment-slip-ink-400);
  }
  .payment-slip-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-slip-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-slip-cream-100);
    color:var(--payment-slip-green-800);
    border:none;cursor:pointer;
    transition:background .15s ease;
  }
  .payment-slip-icon-btn:hover{background:var(--payment-slip-gold-300);}
  .payment-slip-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-slip-main{
    grid-area:main;
    padding:26px 30px 50px;
  }
  .payment-slip-breadcrumb{
    font-size:12px;
    color:var(--payment-slip-ink-400);
    margin-bottom:16px;
  }
  .payment-slip-breadcrumb span{color:var(--payment-slip-green-700);font-weight:600;}
  .payment-slip-breadcrumb a{color:inherit;text-decoration:none;}
  .payment-slip-breadcrumb a:hover{color:var(--payment-slip-green-700);}

  .payment-slip-panel{
    background:var(--payment-slip-white);
    border-radius:var(--payment-slip-radius-lg);
    box-shadow:var(--payment-slip-shadow);
    overflow:hidden;
    border:1px solid var(--payment-slip-border);
  }

  .payment-slip-panel-header{
    position:relative;
    background:linear-gradient(135deg,var(--payment-slip-green-800),var(--payment-slip-green-950));
    color:var(--payment-slip-cream-50);
    padding:22px 30px 26px;
  }
  .payment-slip-panel-header-row{
    display:flex;align-items:center;justify-content:space-between;
    position:relative;z-index:1;
  }
  .payment-slip-panel-title{
    display:flex;align-items:center;gap:10px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:21px;font-weight:600;letter-spacing:0.01em;
  }
  .payment-slip-panel-title svg{width:18px;height:18px;color:var(--payment-slip-gold-300);}
  .payment-slip-panel-close{
    width:32px;height:32px;border-radius:50%;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-slip-cream-50);
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;transition:background .15s ease;
    text-decoration:none;
  }
  .payment-slip-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Body layout: receipt + side actions ---------- */
  .payment-slip-body{
    display:flex;align-items:flex-start;gap:24px;
    padding:30px;flex-wrap:wrap;
  }

  /* ---------- Receipt card ---------- */
  .payment-slip-receipt{
    flex:1 1 460px;max-width:560px;
    background:var(--payment-slip-white);
    border:1px solid var(--payment-slip-border);
    border-radius:var(--payment-slip-radius-md);
    box-shadow:var(--payment-slip-shadow-sm);
    padding:30px 34px;
  }
  .payment-slip-receipt-header{text-align:center;margin-bottom:6px;}
  .payment-slip-logo{width:52px;height:52px;object-fit:contain;margin-bottom:8px;}
  .payment-slip-org-name{
    font-family:'Poppins',Inter,sans-serif;
    font-size:16px;font-weight:700;letter-spacing:0.03em;
    color:var(--payment-slip-green-950);margin:0;
  }
  .payment-slip-org-sub{font-size:10.5px;letter-spacing:0.08em;color:var(--payment-slip-gold-600);margin:1px 0 8px;text-transform:uppercase;}
  .payment-slip-org-line{font-size:11.5px;color:var(--payment-slip-ink-600);margin:2px 0;}

  .payment-slip-title{
    text-align:center;font-size:14px;font-weight:700;letter-spacing:0.08em;
    color:var(--payment-slip-ink-900);text-transform:uppercase;
    margin:18px 0 16px;
    padding-top:14px;border-top:1px dashed var(--payment-slip-border);
  }

  .payment-slip-meta{margin-bottom:18px;}
  .payment-slip-meta-row{display:flex;gap:10px;font-size:13px;padding:3px 0;}
  .payment-slip-meta-label{width:80px;flex:none;font-weight:600;color:var(--payment-slip-ink-600);}
  .payment-slip-meta-value{color:var(--payment-slip-ink-900);}

  table.payment-slip-table{width:100%;border-collapse:collapse;margin-bottom:14px;}
  .payment-slip-table thead th{
    text-align:left;font-size:11px;letter-spacing:0.05em;text-transform:uppercase;
    color:var(--payment-slip-white);background:var(--payment-slip-green-800);
    padding:9px 12px;
  }
  .payment-slip-table thead th.payment-slip-col-amount{text-align:right;}
  .payment-slip-table td{padding:9px 12px;font-size:13.5px;border-bottom:1px solid var(--payment-slip-cream-100);}
  .payment-slip-table td.payment-slip-col-amount{text-align:right;font-variant-numeric:tabular-nums;}
  .payment-slip-table tfoot td{
    font-weight:700;font-size:14px;
    border-top:2px solid var(--payment-slip-ink-900);border-bottom:none;
    padding-top:12px;
  }
  .payment-slip-table tfoot td.payment-slip-col-amount{text-align:right;font-variant-numeric:tabular-nums;}

  .payment-slip-thanks{
    text-align:center;font-weight:700;letter-spacing:0.04em;
    color:var(--payment-slip-green-800);font-size:14px;
    margin:18px 0 10px;
  }
  .payment-slip-foot{text-align:center;font-size:10.5px;color:var(--payment-slip-ink-400);margin:2px 0;}
  .payment-slip-foot-credit{text-align:center;font-size:9.5px;color:var(--payment-slip-ink-400);margin-top:10px;}

  /* ---------- Side actions ---------- */
  .payment-slip-actions{
    flex:0 0 220px;display:flex;flex-direction:column;gap:12px;
  }
  .payment-slip-action-btn{
    height:44px;border-radius:var(--payment-slip-radius-sm);
    border:none;cursor:pointer;
    font-size:13px;font-weight:600;letter-spacing:0.01em;
    display:flex;align-items:center;justify-content:center;gap:8px;
    background:var(--payment-slip-green-800);color:var(--payment-slip-cream-50);
    box-shadow:var(--payment-slip-shadow-sm);
    transition:background .15s ease, transform .1s ease;
  }
  .payment-slip-action-btn:hover{background:var(--payment-slip-green-950);}
  .payment-slip-action-btn:active{transform:translateY(1px);}
  .payment-slip-action-btn.payment-slip-action-print{
    background:linear-gradient(135deg,var(--payment-slip-gold-500),var(--payment-slip-gold-600));
    color:var(--payment-slip-green-950);
  }
  .payment-slip-action-btn.payment-slip-action-print:hover{filter:brightness(0.96);}
  .payment-slip-action-btn svg{width:16px;height:16px;}
  .payment-slip-action-status{font-size:11.5px;color:var(--payment-slip-ink-400);min-height:14px;}

  .payment-slip-sitefoot{
    text-align:center;font-size:11px;color:var(--payment-slip-ink-400);
    padding:22px 0 0;
  }

  @media (max-width:900px){
    .payment-slip-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-slip-sidebar{display:none;}
    .payment-slip-body{flex-direction:column;}
    .payment-slip-actions{flex:1 1 auto;width:100%;flex-direction:row;flex-wrap:wrap;}
    .payment-slip-action-btn{flex:1 1 140px;}
  }

  /* ---------- Print ---------- */
  @media print{
    .payment-slip-sidebar,.payment-slip-topbar,.payment-slip-breadcrumb,
    .payment-slip-panel-header,.payment-slip-actions,.payment-slip-sitefoot{display:none !important;}
    .payment-slip-app{display:block;}
    .payment-slip-main{padding:0;}
    .payment-slip-panel{border:none;box-shadow:none;border-radius:0;}
    .payment-slip-body{padding:0;}
    .payment-slip-receipt{border:none;box-shadow:none;max-width:100%;}
  }
</style>

<div data-page="payment-slip-view" id="Main_dashboard_02_H">

<div class="payment-slip-app">
  <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>

  <!-- ================= TOPBAR ================= -->
  <header class="payment-slip-topbar">
    <div class="payment-slip-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-slip-topbar-actions">
      <button class="payment-slip-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-slip-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-slip-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-slip-main">
    <p class="payment-slip-breadcrumb"><a href="dashboard.php">Dashboard</a> / <a href="payment-list.php">Payment List</a> / <span>Payment Slip View</span></p>

    <section class="payment-slip-panel" aria-label="Payment slip view">

      <div class="payment-slip-panel-header">
        <div class="payment-slip-panel-header-row">
          <div class="payment-slip-panel-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
            Payment Slip View.
          </div>
          <a class="payment-slip-panel-close" title="Close panel" aria-label="Close panel" onclick="main_dashboard_02_A_OPEN()">✕</a>
        </div>
      </div>

      <div class="payment-slip-body">

        <!-- ===== Printable receipt ===== -->
        <div class="payment-slip-receipt" id="payment-slip-receipt">
          <div class="payment-slip-receipt-header">
            <img src="../assets/wwjm-logo.png" class="payment-slip-logo" alt="Wellawatta Jumma Mosque logo" onerror="this.style.display='none'">
            <p class="payment-slip-org-name">WELLAWATTA JUMMA MOSQUE</p>
            <p class="payment-slip-org-sub">Payment Receipt</p>
            <p class="payment-slip-org-line">193/73, Asiri Uyana, Kerawalapitiya Road, Hendala, Wattala</p>
            <p class="payment-slip-org-line">011 771 0877 &nbsp;|&nbsp; info@wwjm.lk</p>
          </div>

          <h3 class="payment-slip-title">Payment Receipt</h3>

          <div class="payment-slip-meta">
            <div class="payment-slip-meta-row">
              <span class="payment-slip-meta-label">Name</span>
              <span class="payment-slip-meta-value" id="payment-slip-name">Abdul Rasheed M.</span>
            </div>
            <div class="payment-slip-meta-row">
              <span class="payment-slip-meta-label">Mobile</span>
              <span class="payment-slip-meta-value" id="payment-slip-mobile">+94 71 234 5678</span>
            </div>
            <div class="payment-slip-meta-row">
              <span class="payment-slip-meta-label">Address</span>
              <span class="payment-slip-meta-value" id="payment-slip-address">Road 1, Wellawatta</span>
            </div>
          </div>

          <table class="payment-slip-table">
            <thead>
              <tr><th>Reason</th><th class="payment-slip-col-amount">Amount - LKR</th></tr>
            </thead>
            <tbody id="payment-slip-items">
              <tr><td>Zakath</td><td class="payment-slip-col-amount"></td></tr>
            </tbody>
            <tfoot>
              <tr><td>Total Paid Amount</td><td class="payment-slip-col-amount" id="payment-slip-total"></td></tr>
            </tfoot>
          </table>

          <p class="payment-slip-thanks">Thank You, Come Again</p>
          <p class="payment-slip-foot">Wellawatta Jumma Mosque &nbsp;|&nbsp; www.wwjm.lk &nbsp;|&nbsp; 011 771 0877 &nbsp;|&nbsp; info@wwjm.lk</p>
          <p class="payment-slip-foot-credit">Design &amp; Maintain by Neo Solution &nbsp;|&nbsp; hello@neosolution.lk</p>
        </div>

        <!-- ===== Actions ===== -->
        <div class="payment-slip-actions">
          <button class="payment-slip-action-btn" onclick="paymentSlipSend('sms')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h10M7 13h6"/></svg>
            Send By SMS
          </button>
          <button class="payment-slip-action-btn" onclick="paymentSlipSend('email')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
            Send By Email
          </button>
          <button class="payment-slip-action-btn payment-slip-action-print" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9V3h12v6M6 18h12v3H6v-3ZM4 9h16a2 2 0 0 1 2 2v5h-4M2 16v-5a2 2 0 0 1 2-2"/></svg>
            Print
          </button>
          <div class="payment-slip-action-status" id="payment-slip-status"></div>
        </div>

      </div>
    </section>

    <p class="payment-slip-sitefoot">© 2026 Wellawatta Jumma Mosque | Neo Solution</p>
  </main>



<script>
  /* ===================================================================
     payment-slip-view.js — Payment Slip View page logic (WWJM Admin)
     =================================================================== */

  const paymentSlipId = <?php echo (int) $payment_id; ?>;

  // TODO: swap this stub for a real fetch (e.g. fetch(`api/payment.php?id=${paymentSlipId}`))
  // once the backend endpoint exists. It should populate the fields below
  // with the actual member name, mobile, address, reason(s) and amount.

  function paymentSlipSend(channel){
    const status = document.getElementById('payment-slip-status');
    status.textContent = channel === 'sms' ? 'Sending SMS…' : 'Sending email…';

    // TODO: replace with a real request to the backend, e.g.:
    // fetch(`api/send-slip.php?id=${paymentSlipId}&channel=${channel}`, { method: 'POST' })
    setTimeout(() => {
      status.textContent = channel === 'sms' ? 'Slip sent by SMS.' : 'Slip sent by email.';
    }, 600);
  }
</script>

</div>