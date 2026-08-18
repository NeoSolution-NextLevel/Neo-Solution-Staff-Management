<?php 
    $pth = "../"; 
    $active_page = "Payment"; // Tells the sidebar to highlight this tab
    $page_title = "Payment List · WWJM Admin";
include '../UxUI-Back/Includes/header.php';  
?>

<title>Payment List · WWJM Admin</title>
<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Payment List
     =================================================================== */
  :root{
    --payment-green-950:#0B2E24;
    --payment-green-800:#123832;
    --payment-green-700:#1B4B41;
    --payment-gold-600:#B8923D;
    --payment-gold-500:#C9A227;
    --payment-gold-300:#E4C766;
    --payment-cream-50:#FAF7F0;
    --payment-cream-100:#F2EDE0;
    --payment-white:#FFFFFF;
    --payment-ink-900:#1E2B26;
    --payment-ink-600:#5A6A62;
    --payment-ink-400:#8B978F;
    --payment-border:#E6E0D0;
    --payment-radius-sm:8px;
    --payment-radius-lg:22px;
    --payment-shadow:0 6px 24px rgba(11,46,36,0.08);
    --payment-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
    --wwjm-footer-green-950:#0B2E24;
    --wwjm-footer-cream-50:#FAF7F0;
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; /* keeps content clear of the fixed shared footer */
  }

  .payment-app{
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
  .payment-topbar{
    grid-area:topbar;
    background:var(--payment-white);
    border-bottom:1px solid var(--payment-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-green-950);
  }
  .payment-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-ink-400);}
  .payment-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-cream-100);color:var(--payment-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-icon-btn:hover{background:var(--payment-gold-300);}
  .payment-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-main{grid-area:main;padding:26px 30px 50px;}
  .payment-breadcrumb{font-size:12px;color:var(--payment-ink-400);margin-bottom:16px;}
  .payment-breadcrumb a{color:var(--payment-ink-400);text-decoration:none;}
  .payment-breadcrumb a:hover{color:var(--payment-green-700);}
  .payment-breadcrumb span{color:var(--payment-green-700);font-weight:600;}

  .payment-panel{
    background:var(--payment-white);
    border-radius:var(--payment-radius-lg);
    box-shadow:var(--payment-shadow);
    overflow:hidden;
    border:1px solid var(--payment-border);
  }

  .payment-panel-header{
    background:linear-gradient(135deg,var(--payment-green-800),var(--payment-green-950));
    color:var(--payment-cream-50);
    padding:24px 30px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .payment-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .payment-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--payment-gold-300);}
  .payment-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Toolbar ---------- */
  .payment-toolbar{
    display:flex;align-items:flex-end;gap:16px;flex-wrap:wrap;
    padding:22px 30px 24px;
  }
  .payment-field{display:flex;flex-direction:column;gap:6px;}
  .payment-field label{
    font-size:12.5px;font-weight:700;color:var(--payment-ink-900);
  }
  .payment-field input,.payment-field select{
    height:42px;
    border:1px solid var(--payment-border);
    border-radius:var(--payment-radius-sm);
    padding:0 12px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--payment-ink-900);
    background:var(--payment-white);
    box-shadow:var(--payment-shadow-sm);
    outline:none;
    transition:border-color .15s ease;
  }
  .payment-field input{width:150px;}
  .payment-field select{min-width:130px;cursor:pointer;}
  .payment-field input:focus,.payment-field select:focus{border-color:var(--payment-gold-500);}
  .payment-toolbar-spacer{flex:1;}

  .payment-btn{
    height:42px;padding:0 20px;
    border-radius:var(--payment-radius-sm);
    border:none;cursor:pointer;
    font-size:13px;font-weight:700;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    white-space:nowrap;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .payment-btn:active{transform:translateY(1px);}
  .payment-btn-primary{
    background:linear-gradient(135deg,var(--payment-gold-500),var(--payment-gold-600));
    color:var(--payment-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .payment-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}

  .payment-perpage{
    height:38px;min-width:110px;
    border:1px solid var(--payment-border);
    border-radius:var(--payment-radius-sm);
    padding:0 12px;
    font-size:12.5px;font-family:inherit;
    color:var(--payment-ink-900);
    background:var(--payment-white);
    outline:none;cursor:pointer;
  }

  /* ---------- Table ---------- */
  .payment-table-wrap{padding:0 30px 8px;}
  table.payment-table{width:100%;border-collapse:collapse;}
  .payment-table thead th{
    text-align:left;
    font-size:11px;letter-spacing:0.06em;text-transform:uppercase;
    color:var(--payment-ink-600);
    padding:0 14px 10px;
    border-bottom:1px solid var(--payment-border);
  }
  .payment-table thead th.payment-col-amount{text-align:right;}
  .payment-table thead th.payment-col-action{text-align:right;}
  .payment-table tbody tr{border-bottom:1px solid var(--payment-cream-100);}
  .payment-table tbody tr:hover{background:var(--payment-cream-50);}
  .payment-table td{padding:14px;font-size:13.5px;vertical-align:middle;}
  .payment-name{font-weight:600;color:var(--payment-ink-900);}
  .payment-type-tag{
    display:inline-block;
    font-size:11px;font-weight:700;letter-spacing:0.02em;
    padding:3px 10px;border-radius:999px;
    background:var(--payment-cream-100);
    color:var(--payment-green-700);
  }
  .payment-date{color:var(--payment-ink-600);}
  .payment-amount{text-align:right;font-variant-numeric:tabular-nums;color:var(--payment-ink-900);font-weight:600;}
  .payment-action-cell{text-align:right;}
  .payment-view{
    height:32px;padding:0 16px;
    border-radius:var(--payment-radius-sm);
    border:1px solid var(--payment-green-700);
    background:var(--payment-white);
    color:var(--payment-green-700);
    font-size:12px;font-weight:700;
    cursor:pointer;
    transition:background .15s ease,color .15s ease;
  }
  .payment-view:hover{background:var(--payment-green-800);color:var(--payment-cream-50);}

  .payment-empty{padding:50px 30px;text-align:center;color:var(--payment-ink-400);font-size:13.5px;}

  .payment-panel-footer{
    display:flex;align-items:center;justify-content:flex-end;
    padding:14px 30px 26px;
  }

  @media (max-width:900px){
    .payment-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-toolbar{align-items:stretch;}
    .payment-field input,.payment-field select{width:100%;}
  .payment-page-btn {
    height: 32px;
    min-width: 32px;
    padding: 0 10px;
    border-radius: var(--payment-radius-sm);
    border: 1px solid var(--payment-border);
    background: var(--payment-white);
    color: var(--payment-ink-900);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
  }
  .payment-page-btn:hover:not(:disabled) {
    background: var(--payment-cream-100);
    border-color: var(--payment-green-700);
  }
  .payment-page-btn.is-active {
    background: var(--payment-green-800);
    color: var(--payment-cream-50);
    border-color: var(--payment-green-800);
  }
  .payment-page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>

<div data-page="payment" id="Main_dashboard_02_A">

<div class="payment-app">

   <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>


  <!-- ================= TOPBAR ================= -->
  <header class="payment-topbar">
    <div class="payment-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-topbar-actions">
      <button class="payment-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-main">
    <p class="payment-breadcrumb">
      <a href="dashboard.php">Dashboard</a> /
      <span>Payment List</span>
    </p>

    <section class="payment-panel" aria-label="Payment list">

      <div class="payment-panel-header">
        <div class="payment-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="6" width="18" height="12" rx="1.8"/><path d="M3 10h18"/></svg>
          Payment List...
        </div>
        <a class="payment-panel-close" onclick="main_dashboard_01_A_OPEN()" title="Close" aria-label="Close">✕</a>
      </div>

      <div class="payment-toolbar">
        <div class="payment-field">
          <label for="payment-start-date">Start Date</label>
          <input type="date" id="payment-start-date" onchange="paymentRender(1)">
        </div>
        <div class="payment-field">
          <label for="payment-end-date">End Date</label>
          <input type="date" id="payment-end-date" onchange="paymentRender(1)">
        </div>
        <div class="payment-field">
          <label for="payment-type">Type</label>
          <select id="payment-type" onchange="paymentRender(1)">
            <option value="all">All</option>
            <option value="subscription">Subscription</option>
            <option value="zakath">Zakath</option>
            <option value="collection">Collection</option>
            <option value="kuruba">Kuruba</option>
          </select>
        </div>
        <div class="payment-field">
          <label for="payment-other-type">Other Type</label>
          <select id="payment-other-type" onchange="paymentRender(1)">
            <option value="all">All</option>
            <option value="cash">Cash</option>
            <option value="qr">Share by QR</option>
            <option value="bank">Bank Deposit</option>
          </select>
        </div>
        <div class="payment-toolbar-spacer"></div>
        <a class="payment-btn payment-btn-primary" onclick="main_dashboard_02_B_OPEN()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
          Add New
        </a>
      </div>

      <div style="display:flex;justify-content:flex-end;padding:0 30px 18px;">
        <select class="payment-perpage" id="payment-perpage" onchange="paymentRender(1)">
          <option value="10">Per Page 10</option>
          <option value="25">Per Page 25</option>
          <option value="50" selected>Per Page 50</option>
        </select>
      </div>

      <div class="payment-table-wrap">
        <table class="payment-table">
          <thead>
            <tr>
              <th>Member name</th>
              <th>Type</th>
              <th>Date</th>
              <th class="payment-col-amount">Amount (Rs.)</th>
              <th class="payment-col-action">Action</th>
            </tr>
          </thead>
          <tbody id="payment-tbody"></tbody>
        </table>
        <div class="payment-empty" id="payment-empty" style="display:none;">No payments match this search.</div>
      </div>

      <div class="payment-panel-footer" style="display:flex;align-items:center;justify-content:space-between;padding:14px 30px 26px;">
        <div id="payment-count" style="color:var(--payment-ink-400);font-size:12px;"></div>
        <div id="payment-pagination" style="display:flex;gap:6px;"></div>
      </div>

    </section>
  </main>



</div>
<?php include_once __DIR__ . '/JS/Main-Dashboard_02_A_JS.php'; ?>
</div>
