<?php 
    $pth = "../"; 
    $active_page = "payment-subscription"; // Tells the sidebar to highlight this tab
    $page_title = "Select Member · Subscription Payment · WWJM Admin";
include_once __DIR__ . '/../../Includes/header.php';  
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Payment · Select Member (Subscription)
     =================================================================== */
  :root{
    --payment-subscription-green-950:#0B2E24;
    --payment-subscription-green-800:#123832;
    --payment-subscription-green-700:#1B4B41;
    --payment-subscription-gold-600:#B8923D;
    --payment-subscription-gold-500:#C9A227;
    --payment-subscription-gold-300:#E4C766;
    --payment-subscription-cream-50:#FAF7F0;
    --payment-subscription-cream-100:#F2EDE0;
    --payment-subscription-white:#FFFFFF;
    --payment-subscription-ink-900:#1E2B26;
    --payment-subscription-ink-600:#5A6A62;
    --payment-subscription-ink-400:#8B978F;
    --payment-subscription-border:#E6E0D0;
    --payment-subscription-radius-sm:8px;
    --payment-subscription-radius-lg:22px;
    --payment-subscription-shadow:0 6px 24px rgba(11,46,36,0.08);
    --payment-subscription-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--payment-subscription-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--payment-subscription-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; /* keeps content clear of the fixed shared footer */
  }

  .payment-subscription-app{
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
  .payment-subscription-topbar{
    grid-area:topbar;
    background:var(--payment-subscription-white);
    border-bottom:1px solid var(--payment-subscription-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .payment-subscription-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--payment-subscription-green-950);
  }
  .payment-subscription-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--payment-subscription-ink-400);}
  .payment-subscription-topbar-actions{display:flex;align-items:center;gap:18px;}
  .payment-subscription-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--payment-subscription-cream-100);color:var(--payment-subscription-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .payment-subscription-icon-btn:hover{background:var(--payment-subscription-gold-300);}
  .payment-subscription-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .payment-subscription-main{grid-area:main;padding:26px 30px 50px;}
  .payment-subscription-breadcrumb{font-size:12px;color:var(--payment-subscription-ink-400);margin-bottom:16px;}
  .payment-subscription-breadcrumb a{color:var(--payment-subscription-ink-400);text-decoration:none;}
  .payment-subscription-breadcrumb a:hover{color:var(--payment-subscription-green-700);}
  .payment-subscription-breadcrumb span{color:var(--payment-subscription-green-700);font-weight:600;}

  .payment-subscription-panel{
    background:var(--payment-subscription-white);
    border-radius:var(--payment-subscription-radius-lg);
    box-shadow:var(--payment-subscription-shadow);
    overflow:hidden;
    border:1px solid var(--payment-subscription-border);
  }

  .payment-subscription-panel-header{
    background:linear-gradient(135deg,var(--payment-subscription-green-800),var(--payment-subscription-green-950));
    color:var(--payment-subscription-cream-50);
    padding:24px 30px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .payment-subscription-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .payment-subscription-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--payment-subscription-gold-300);}
  .payment-subscription-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--payment-subscription-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .payment-subscription-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Toolbar ---------- */
  .payment-subscription-toolbar{
    display:flex;align-items:center;gap:12px;flex-wrap:wrap;
    padding:22px 30px 0;
  }
  .payment-subscription-search{
    flex:1;min-width:200px;
    height:42px;
    border:1px solid var(--payment-subscription-border);
    border-radius:var(--payment-subscription-radius-sm);
    padding:0 14px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--payment-subscription-ink-900);
    background:var(--payment-subscription-white);
    outline:none;
    transition:border-color .15s ease;
  }
  .payment-subscription-search::placeholder{color:var(--payment-subscription-ink-400);}
  .payment-subscription-search:focus{border-color:var(--payment-subscription-gold-500);}

  .payment-subscription-select{
    height:42px;min-width:150px;
    border:1px solid var(--payment-subscription-border);
    border-radius:var(--payment-subscription-radius-sm);
    padding:0 14px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--payment-subscription-ink-900);
    background:var(--payment-subscription-white);
    outline:none;cursor:pointer;
    transition:border-color .15s ease;
  }
  .payment-subscription-select:focus{border-color:var(--payment-subscription-gold-500);}

  .payment-subscription-skip{
    height:42px;padding:0 24px;
    border-radius:var(--payment-subscription-radius-sm);
    border:none;cursor:pointer;
    background:var(--payment-subscription-cream-100);
    color:var(--payment-subscription-ink-400);
    font-size:13px;font-weight:700;letter-spacing:0.01em;
    text-decoration:none;
    display:inline-flex;align-items:center;
    transition:background .15s ease,color .15s ease;
  }
  .payment-subscription-skip:hover{background:var(--payment-subscription-border);color:var(--payment-subscription-ink-900);}

  .payment-subscription-toolbar-row2{
    display:flex;justify-content:flex-end;
    padding:14px 30px 4px;
  }
  .payment-subscription-perpage{
    height:36px;min-width:110px;
    border:1px solid var(--payment-subscription-border);
    border-radius:var(--payment-subscription-radius-sm);
    padding:0 12px;
    font-size:12.5px;font-family:inherit;
    color:var(--payment-subscription-ink-900);
    background:var(--payment-subscription-white);
    outline:none;cursor:pointer;
  }

  /* ---------- Member list ---------- */
  .payment-subscription-list{
    display:flex;flex-direction:column;
    padding:14px 30px 30px;
    gap:10px;
  }
  .payment-subscription-row{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 18px;
    background:var(--payment-subscription-cream-50);
    border:1px solid var(--payment-subscription-border);
    border-radius:var(--payment-subscription-radius-sm);
    transition:border-color .15s ease, background .15s ease;
  }
  .payment-subscription-row:hover{border-color:var(--payment-subscription-gold-500);background:var(--payment-subscription-white);}
  .payment-subscription-row-info{display:flex;flex-direction:column;gap:2px;}
  .payment-subscription-row-name{font-size:14px;font-weight:700;color:var(--payment-subscription-ink-900);}
  .payment-subscription-row-road{font-size:12px;color:var(--payment-subscription-ink-600);}
  .payment-subscription-row-select{
    height:36px;padding:0 20px;
    border-radius:var(--payment-subscription-radius-sm);
    border:1px solid var(--payment-subscription-green-700);
    background:var(--payment-subscription-white);
    color:var(--payment-subscription-green-700);
    font-size:12.5px;font-weight:700;letter-spacing:0.01em;
    cursor:pointer;
    transition:background .15s ease,color .15s ease;
  }
  .payment-subscription-row-select:hover{
    background:var(--payment-subscription-green-800);
    color:var(--payment-subscription-cream-50);
    border-color:var(--payment-subscription-green-800);
  }

  .payment-subscription-empty{padding:40px 18px;text-align:center;color:var(--payment-subscription-ink-400);font-size:13.5px;}

  @media (max-width:900px){
    .payment-subscription-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .payment-subscription-toolbar{flex-direction:column;align-items:stretch;}
    .payment-subscription-skip{width:100%;justify-content:center;}
  }
</style>

<div data-page="payment" id="Main_dashboard_02_C">

<div class="payment-subscription-app">

   <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>


  <!-- ================= TOPBAR ================= -->
  <header class="payment-subscription-topbar">
    <div class="payment-subscription-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="payment-subscription-topbar-actions">
      <button class="payment-subscription-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="payment-subscription-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="payment-subscription-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="payment-subscription-main">
    <p class="payment-subscription-breadcrumb">
      <a href="payment.php">Dashboard</a> /
      <a href="payment.php">Payment</a> /
      <a href="payment-new.php">Create Payment</a> /
      <span>Subscription</span>
    </p>

    <section class="payment-subscription-panel" aria-label="Select member for subscription payment">

      <div class="payment-subscription-panel-header">
        <div class="payment-subscription-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.4"/><path d="M2.5 20c1-4 3.4-6 6.5-6s5.5 2 6.5 6"/><circle cx="18" cy="9" r="2.4"/><path d="M15.8 14c2.4.2 4 1.9 4.7 5.2"/></svg>
          Member List,
        </div>
        <a class="payment-subscription-panel-close" onclick="main_dashboard_02_B_OPEN()" title="Close" aria-label="Close">✕</a>
      </div>

      <div class="payment-subscription-toolbar">
        <input type="text" class="payment-subscription-search" id="payment-subscription-search"
               placeholder="Search from member here" oninput="paymentSubscriptionRender()">
        <select class="payment-subscription-select" id="payment-subscription-type" onchange="paymentSubscriptionRender()">
            <option value="All">All</option>
            <option value="membership_no">Membership Number</option>
            <option value="Email">Email</option>
            <option value="name">Name</option>
            <option value="Phone_no">Phone Number</option>
            <option value="old_membership_no">Old Membership Number</option>
        </select>
        <a class="payment-subscription-skip" href="payment.php">Skip</a>
      </div>

      <div class="payment-subscription-toolbar-row2">
        <div id="payment-subscription-pagination" style="display:flex; gap:8px; flex-wrap:wrap; margin-right:auto;"></div>
        <select class="payment-subscription-perpage" id="payment-subscription-perpage" onchange="paymentSubscriptionRender()">
          <option value="10">Per Page 10</option>
          <option value="25">Per Page 25</option>
          <option value="50" selected>Per Page 50</option>
        </select>
      </div>

      <div class="payment-subscription-list" id="payment-subscription-list"></div>
      <div class="payment-subscription-empty" id="payment-subscription-empty" style="display:none;">No members match this search.</div>

    </section>
  </main>

</div>

<!-- The JavaScript logic is loaded from JS/Main-Dashboard_02_C_JS.php -->

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->


<!-- ================= FOOTER (shared component) =================
     PHP projects: delete this div and put <?php include_once __DIR__ . '/../../Includes/footer.php'; ?>
     in its place instead. -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

</div>










<!-- 
//old code

<div class="container-fluid" id="DashBord_Payment_body_01_B_03">

    <div class="row w3-theme-l3">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="container-fluid w3-theme-l4 w3-margin-bottom ">
                <div class="row w3-theme-dark w3-padding-16">
                    <div class="col-lg-10  w3-xxlarge w3-strong w3-header w3-animate-zoom"
                        id="body_01_01_C_headding">
                        Member List.
                    </div>
                    <div class="col-lg-2  w3-xlarge">
                        <button
                            class="w3-button w3-round w3-theme-dark w3-hover-theme w3-padding-16 w3-block w3-animate-zoom"
                            onclick="DashBord_Payment_body_01_B_02_OPEN()">
                            <span class="fa fa-times"></span>
                        </button>
                    </div>

                </div>
                <div class="row w3-margin-top ">

                    <div class="col-lg-5 w3-padding">
                        <input type="search" class="w3-input w3-border w3-border-theme w3-round w3-animate-zoom"
                            id="DashBord_Payment_body_01_B_03_search_txt" onkeydown="DashBord_Payment_body_01_B_03_member_list_SET_DB()">

                    </div>
                    <div class="col-lg-4 w3-padding">

                        <select class="w3-input w3-round w3-border w3-border-black w3-animate-zoom w3-padding-" id="DashBord_Payment_body_01_B_03_select_member_details">
                            <option value="All">All</option>
                            <option value="membership_no">Membership Number</option>
                            <option value="Email">Email</option>
                            <option value="name">Name</option>
                            <option value="Phone_no">Phone Number</option>
                            <option value="old_membership_no">Old Membership Number</option>
                        </select>

                    </div>


                    <div class="col-lg-3 w3-margin-bottom">
                        <button type="submit" class="w3-button w3-theme-dark w3-strong w3-round w3-animate-zoom w3-padding-16 w3-block w3-animate-zoom" id="DashBord_Payment_body_01_B_03_skip_member_btn" onclick="DashBord_Payment_body_01_B_08_02_OPEN()">
                            Skip
                        </button>

                    </div>

                </div>

                <div class="row ">
                    <div class="col-lg-9" id="DashBord_Payment_body_01_B_03_PAGINATION_BUTTON_BODY">

                    </div>
                    <div class="col-lg-3">
                        <select class="w3-select w3-round w3-border w3-border-theme w3-padding w3-animate-zoom" id="DashBord_Payment_body_01_B_03_pre_page_selector" onchange="DashBord_Payment_body_01_B_03_member_list_SET_DB()">
                            <option value="50">Per Page 50</option>
                            <option value="100">Per Page 100</option>
                            <option value="200">Per Page 200</option>
                            <option value="300">Per Page 300</option>
                        </select>
                    </div>
                </div>

                <div class="container-fluid   w3-padding-16  ">
                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="container-fluid" id="DashBord_Payment_body_01_B_03_data_body_1">

                               

                            </div>
                        </div>
                    </div>


                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 w3-margin-bottom"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-2"></div>

    </div>
</div> -->
