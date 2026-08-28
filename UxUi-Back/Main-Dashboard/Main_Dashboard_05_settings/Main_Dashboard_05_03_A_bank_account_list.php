<?php 
    $pth = "../"; 
    $active_page = "settings-bank-account"; // Tells the sidebar to highlight this tab
    $page_title = "Create New Member · WWJM Admin";
include_once __DIR__ . '/../../Includes/header.php'; 
?>

<title>Bank Account List · WWJM Admin</title>
<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Settings · Bank Account List
     =================================================================== */


  :root{
    --settings-bank-account-green-950:#0B2E24;
    --settings-bank-account-green-800:#123832;
    --settings-bank-account-green-700:#1B4B41;
    --settings-bank-account-gold-600:#B8923D;
    --settings-bank-account-gold-500:#C9A227;
    --settings-bank-account-gold-300:#E4C766;
    --settings-bank-account-cream-50:#FAF7F0;
    --settings-bank-account-cream-100:#F2EDE0;
    --settings-bank-account-white:#FFFFFF;
    --settings-bank-account-ink-900:#1E2B26;
    --settings-bank-account-ink-600:#5A6A62;
    --settings-bank-account-ink-400:#8B978F;
    --settings-bank-account-border:#E6E0D0;
    --settings-bank-account-danger:#B0453A;
    --settings-bank-account-radius-sm:8px;
    --settings-bank-account-radius-lg:22px;
    --settings-bank-account-shadow:0 6px 24px rgba(11,46,36,0.08);
    --settings-bank-account-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--settings-bank-account-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--settings-bank-account-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px;
  }

  .settings-bank-account-app{
    display:grid;
    grid-template-columns:248px 1fr;
    grid-template-rows:64px 1fr;
    min-height:100vh;
    grid-template-areas:
      "sidebar topbar"
      "sidebar main";
  }

  .settings-bank-account-topbar{
    grid-area:topbar;
    background:var(--settings-bank-account-white);
    border-bottom:1px solid var(--settings-bank-account-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .settings-bank-account-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--settings-bank-account-green-950);
  }
  .settings-bank-account-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--settings-bank-account-ink-400);}
  .settings-bank-account-topbar-actions{display:flex;align-items:center;gap:18px;}
  .settings-bank-account-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--settings-bank-account-cream-100);color:var(--settings-bank-account-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .settings-bank-account-icon-btn:hover{background:var(--settings-bank-account-gold-300);}
  .settings-bank-account-icon-btn svg{width:16px;height:16px;}

  .settings-bank-account-breadcrumb{font-size:12px;color:var(--settings-bank-account-ink-400);margin-bottom:16px;}
  .settings-bank-account-breadcrumb a{color:var(--settings-bank-account-ink-400);text-decoration:none;}
  .settings-bank-account-breadcrumb a:hover{color:var(--settings-bank-account-green-700);}
  .settings-bank-account-breadcrumb span{color:var(--settings-bank-account-green-700);font-weight:600;}

  .settings-bank-account-panel-header{
    background:linear-gradient(135deg,var(--settings-bank-account-green-800),var(--settings-bank-account-green-950));
    color:var(--settings-bank-account-cream-50);
    padding:24px 30px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .settings-bank-account-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .settings-bank-account-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--settings-bank-account-gold-300);}
  .settings-bank-account-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--settings-bank-account-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .settings-bank-account-panel-close:hover{background:rgba(250,247,240,0.12);}

  .settings-bank-account-btn{
    height:42px;padding:0 20px;
    border-radius:var(--settings-bank-account-radius-sm);
    border:none;cursor:pointer;
    font-size:13px;font-weight:700;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    white-space:nowrap;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease, color .15s ease;
  }
  .settings-bank-account-btn:active{transform:translateY(1px);}
  .settings-bank-account-btn-primary{
    background:linear-gradient(135deg,var(--settings-bank-account-gold-500),var(--settings-bank-account-gold-600));
    color:var(--settings-bank-account-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .settings-bank-account-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}
  .settings-bank-account-btn-ghost{
    background:var(--settings-bank-account-cream-100);
    color:var(--settings-bank-account-ink-900);
  }
  .settings-bank-account-btn-ghost:hover{background:var(--settings-bank-account-border);}

  @media (max-width:900px){
    .settings-bank-account-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
  }

  .settings-bank-account-main{grid-area:main;padding:26px 30px 50px;}

  .settings-bank-account-panel{
    background:var(--settings-bank-account-white);
    border-radius:var(--settings-bank-account-radius-lg);
    box-shadow:var(--settings-bank-account-shadow);
    overflow:hidden;
    border:1px solid var(--settings-bank-account-border);
  }

  .settings-bank-account-toolbar{
    display:flex;align-items:center;gap:12px;flex-wrap:wrap;
    padding:22px 30px 4px;
  }
  .settings-bank-account-search{
    flex:1;min-width:200px;
    height:42px;
    border:1px solid var(--settings-bank-account-border);
    border-radius:var(--settings-bank-account-radius-sm);
    padding:0 14px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--settings-bank-account-ink-900);
    background:var(--settings-bank-account-white);
    outline:none;
    transition:border-color .15s ease;
  }
  .settings-bank-account-search::placeholder{color:var(--settings-bank-account-ink-400);}
  .settings-bank-account-search:focus{border-color:var(--settings-bank-account-gold-500);}

  .settings-bank-account-field{display:flex;flex-direction:column;gap:6px;}
  .settings-bank-account-field label{font-size:12px;font-weight:700;color:var(--settings-bank-account-ink-900);}

  .settings-bank-account-select{
    height:42px;min-width:170px;
    border:1px solid var(--settings-bank-account-border);
    border-radius:var(--settings-bank-account-radius-sm);
    padding:0 14px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--settings-bank-account-ink-900);
    background:var(--settings-bank-account-white);
    outline:none;cursor:pointer;
    transition:border-color .15s ease;
  }
  .settings-bank-account-select:focus{border-color:var(--settings-bank-account-gold-500);}

  .settings-bank-account-badge{
    height:42px;padding:0 20px;
    border-radius:var(--settings-bank-account-radius-sm);
    background:var(--settings-bank-account-cream-100);
    color:var(--settings-bank-account-ink-900);
    display:flex;align-items:center;gap:6px;
    font-size:13px;font-weight:800;
    white-space:nowrap;
  }
  .settings-bank-account-badge span{color:var(--settings-bank-account-green-700);}

  .settings-bank-account-toolbar-row2{
    display:flex;justify-content:flex-end;
    padding:14px 30px 4px;
  }
  .settings-bank-account-perpage{
    height:36px;min-width:110px;
    border:1px solid var(--settings-bank-account-border);
    border-radius:var(--settings-bank-account-radius-sm);
    padding:0 12px;
    font-size:12.5px;font-family:inherit;
    color:var(--settings-bank-account-ink-900);
    background:var(--settings-bank-account-white);
    outline:none;cursor:pointer;
  }

  .settings-bank-account-list{
    display:flex;flex-direction:column;
    padding:18px 30px 30px;
    gap:10px;
  }
  .settings-bank-account-row{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 18px;
    background:var(--settings-bank-account-cream-50);
    border:1px solid var(--settings-bank-account-border);
    border-radius:var(--settings-bank-account-radius-sm);
    transition:border-color .15s ease, background .15s ease;
  }
  .settings-bank-account-row:hover{border-color:var(--settings-bank-account-gold-500);background:var(--settings-bank-account-white);}
  .settings-bank-account-row-info{display:flex;flex-direction:column;gap:2px;}
  .settings-bank-account-row-name{font-size:14px;font-weight:700;color:var(--settings-bank-account-ink-900);}
  .settings-bank-account-row-sub{font-size:12px;color:var(--settings-bank-account-ink-600);}
  .settings-bank-account-row-actions{display:flex;align-items:center;gap:10px;}
  .settings-bank-account-tag{
    display:inline-block;
    font-size:11px;font-weight:700;letter-spacing:0.02em;
    padding:3px 10px;border-radius:999px;
    background:var(--settings-bank-account-cream-100);
    color:var(--settings-bank-account-green-700);
  }
  .settings-bank-account-row-btn{
    height:34px;padding:0 18px;
    border-radius:var(--settings-bank-account-radius-sm);
    border:1px solid var(--settings-bank-account-green-700);
    background:var(--settings-bank-account-white);
    color:var(--settings-bank-account-green-700);
    font-size:12px;font-weight:700;letter-spacing:0.01em;
    cursor:pointer;
    transition:background .15s ease,color .15s ease;
  }
  .settings-bank-account-row-btn:hover{background:var(--settings-bank-account-green-800);color:var(--settings-bank-account-cream-50);}

  .settings-bank-account-empty{padding:40px 18px;text-align:center;color:var(--settings-bank-account-ink-400);font-size:13.5px;}

  @media (max-width:900px){
    .settings-bank-account-toolbar{flex-direction:column;align-items:stretch;}
  }

</style>
<div data-page="settings" id="Main_Dashboard_05_03_A">

<div class="settings-bank-account-app">

     <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>


  

  <!-- ================= TOPBAR ================= -->
  <header class="settings-bank-account-topbar">
    <div class="settings-bank-account-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="settings-bank-account-topbar-actions">
      <button class="settings-bank-account-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="settings-bank-account-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="settings-bank-account-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="settings-bank-account-main">
    <p class="settings-bank-account-breadcrumb">
      <a href="dashboard.php">Dashboard</a> /
      <a href="settings.php">Settings</a> /
      <span>Bank Account</span>
    </p>

    <section class="settings-bank-account-panel" aria-label="Bank Account List">

      <div class="settings-bank-account-panel-header">
        <div class="settings-bank-account-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10 12 4l9 6"/><path d="M4.5 10v9M9 10v9M15 10v9M19.5 10v9"/><path d="M3 19h18"/></svg>
          Bank Account List
        </div>
        <a class="settings-bank-account-panel-close" onclick="main_dashboard_05_01_OPEN()" title="Close" aria-label="Close">✕</a>
      </div>

      <div class="settings-bank-account-toolbar">
        <div class="settings-bank-account-field">
          <label for="settings-bank-account-search">Search</label>
          <input type="text" class="settings-bank-account-search" id="settings-bank-account-search" style="height:42px;"
                 placeholder="search..." oninput="Settings_body_01_D_07_bank_account_list()">
        </div>
        <div class="settings-bank-account-field">
          <label for="settings-bank-account-type">Select Type To Search</label>
          <select class="settings-bank-account-select" id="settings-bank-account-type" onchange="Settings_body_01_D_07_bank_account_list()">
            <option value="account">From Account Number</option>
            <option value="bank">From Bank Name</option>
            <option value="branch">From Branch</option>
          </select>
        </div>
        <a class="settings-bank-account-btn settings-bank-account-btn-primary" onclick="main_dashboard_05_03_B_OPEN()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
          Add New
        </a>
      </div>

      <div class="settings-bank-account-list" id="settings-bank-account-list"></div>
      <div class="settings-bank-account-empty" id="settings-bank-account-empty" style="display:none;">No bank accounts match this search.</div>


    </section>

  </main>

</div>

<?php include 'JS/Main_Dashboard_05_03_A_JS.php'; ?>

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->


<!-- ================= FOOTER (shared component) =================
     PHP projects: delete this div and put <?php include_once __DIR__ . '/../../Includes/footer.php'; ?>
     in its place instead. -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

</div>















<!-- <input type="text" id="member_pagination_holder_id"> -->
<!-- <div class="container-fluid" id="Settings_body_01_D_07">
    <div class="row w3-theme-l3">

        <div class="col-lg-1">

        </div>
        <div class="col-lg-10">

            <div class="container-fluid w3-theme-l4 ">
                <div class="row w3-theme-dark w3-padding-16 ">
                    <div class="col-lg-10  w3-xxlarge w3-strong w3-header w3-animate-zoom " id="body_01_01_C_headding">
                        Bank Account List
                    </div>
                    <div class="col-lg-2  w3-xlarge ">
                        <button class="w3-button w3-round w3-theme-dark w3-hover-theme w3-padding-16 w3-block w3-animate-zoom "
                            onclick="Settings_body_01_D_01_OPEN()">
                            <span class="fa fa-times"></span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid ">
                            <div class="row w3-margin-top">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <strong>Search From Name</strong>
                                    <input type="text" class="w3-input w3-round w3-border w3-border-black w3-animate-zoom" placeholder="search name" id="Settings_body_01_D_07_JS_Member_List_search_txt" onkeydown="Settings_body_01_D_07_bank_account_list()">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <strong> Select Type To Search</strong>
                                    <select id="Settings_body_01_D_07_Member_List_search_type"
                                        class="w3-input w3-round w3-border w3-border-black w3-animate-zoom ">
                                        <option value="membership_no">From Account Number</option>
                                        <option value="road_name">From Bank Account</option>
                                    </select>

                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1  w3-padding-16">
                                   
                                </div>
                                <div class="col-lg-3  col-md-3 col-sm-3 col-xs-3 w3-padding-16">
                                    <button class="w3-button w3-theme-dark w3-round w3-padding-16 w3-block w3-animate-zoom w3-strong" id="Settings_body_01_D_07_add_btn" onclick="Settings_body_01_D_08_OPEN()">
                                        Add New
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">

                                </div>
                                
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid w3-padding" id="Settings_body_01_D_07_Member_List_data_body">


                            


                        </div>
                    </div>
                </div>
                <div class="row w3-margin-top w3-margin-bottom w3-padding-16">
                    <div class="col-lg-12" id="Settings_body_01_D_07_JS_Member_List_history_PAGINATION_BUTTON_BODY"> </div>
                </div>

            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>
</div> -->