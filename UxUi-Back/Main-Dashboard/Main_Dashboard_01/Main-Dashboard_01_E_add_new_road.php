<?php 
    $pth = "../"; 
    $active_page = "add-new-road"; // Tells the sidebar to highlight this tab
    $page_title = "Add New Road · WWJM Admin";
include_once __DIR__ . '/../../Includes/header.php'; 

?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens
     Wellawatta Jumma Mosque · Dashboard · Add New Road (Dash-Board-01-E)
     =================================================================== */
  :root{
    --add-road-green-950:#0B2E24;
    --add-road-green-800:#123832;
    --add-road-green-700:#1B4B41;
    --add-road-gold-600:#B8923D;
    --add-road-gold-500:#C9A227;
    --add-road-gold-300:#E4C766;
    --add-road-cream-50:#FAF7F0;
    --add-road-cream-100:#F2EDE0;
    --add-road-white:#FFFFFF;
    --add-road-ink-900:#1E2B26;
    --add-road-ink-600:#5A6A62;
    --add-road-ink-400:#8B978F;
    --add-road-border:#E6E0D0;
    --add-road-danger:#B0453A;
    --add-road-radius-sm:8px;
    --add-road-radius-lg:22px;
    --add-road-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--add-road-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--add-road-ink-900);
    -webkit-font-smoothing:antialiased;
  }

  .add-road-app{
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
  .add-road-topbar{
    grid-area:topbar;
    background:var(--add-road-white);
    border-bottom:1px solid var(--add-road-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .add-road-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--add-road-green-950);
  }
  .add-road-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--add-road-ink-400);}
  .add-road-topbar-actions{display:flex;align-items:center;gap:18px;}
  .add-road-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--add-road-cream-100);color:var(--add-road-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .add-road-icon-btn:hover{background:var(--add-road-gold-300);}
  .add-road-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .add-road-main{grid-area:main;padding:26px 30px 50px;}
  .add-road-breadcrumb{font-size:12px;color:var(--add-road-ink-400);margin-bottom:16px;}
  .add-road-breadcrumb a{color:var(--add-road-ink-400);text-decoration:none;}
  .add-road-breadcrumb a:hover{color:var(--add-road-green-700);}
  .add-road-breadcrumb span{color:var(--add-road-green-700);font-weight:600;}

  .add-road-panel{
    max-width:620px;
    margin:0 auto;
    background:var(--add-road-white);
    border-radius:var(--add-road-radius-lg);
    box-shadow:var(--add-road-shadow);
    overflow:hidden;
    border:1px solid var(--add-road-border);
  }

  .add-road-panel-header{
    background:linear-gradient(135deg,var(--add-road-green-800),var(--add-road-green-950));
    color:var(--add-road-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .add-road-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:22px;font-weight:600;
  }
  .add-road-panel-title svg{width:22px;height:22px;flex:0 0 22px;color:var(--add-road-gold-300);}
  .add-road-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--add-road-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .add-road-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Form ---------- */
  .add-road-form{padding:28px 32px 30px;}
  .add-road-field{display:flex;flex-direction:column;gap:8px;margin-bottom:20px;}
  .add-road-field label{
    font-size:13.5px;font-weight:700;
    color:var(--add-road-ink-900);
  }
  .add-road-field input, .add-road-field select, .add-road-field textarea{
    height:46px;
    border:1px solid var(--add-road-border);
    border-radius:var(--add-road-radius-sm);
    padding:0 16px;
    font-size:14px;
    font-family:inherit;
    color:var(--add-road-ink-900);
    background:var(--add-road-white);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .add-road-field textarea{
    height:90px;
    padding:12px 16px;
    resize:vertical;
  }
  .add-road-field input::placeholder, .add-road-field textarea::placeholder{color:var(--add-road-ink-400);}
  .add-road-field input:focus, .add-road-field select:focus, .add-road-field textarea:focus{
    border-color:var(--add-road-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }
  .add-road-field.add-road-invalid input{border-color:var(--add-road-danger);}
  .add-road-error{
    font-size:11.5px;color:var(--add-road-danger);
    margin-top:2px;display:none;
  }
  .add-road-field.add-road-invalid .add-road-error{display:block;}

  .add-road-actions{
    display:flex;align-items:center;gap:12px;
    margin-top:28px;
  }
  .add-road-btn{
    height:44px;padding:0 24px;
    border-radius:var(--add-road-radius-sm);
    border:none;cursor:pointer;
    font-size:13.5px;font-weight:700;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .add-road-btn:active{transform:translateY(1px);}
  .add-road-btn-ghost{
    background:var(--add-road-cream-100);
    color:var(--add-road-ink-900);
  }
  .add-road-btn-ghost:hover{background:var(--add-road-border);}
  .add-road-btn-primary{
    background:linear-gradient(135deg,var(--add-road-gold-500),var(--add-road-gold-600));
    color:var(--add-road-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .add-road-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}
  .add-road-btn-primary:disabled{opacity:0.6;cursor:not-allowed;box-shadow:none;}

  .add-road-toast{
    position:fixed;top:20px;right:20px;
    background:var(--add-road-green-950);color:var(--add-road-cream-50);
    border-left:4px solid var(--add-road-gold-500);
    padding:14px 18px;border-radius:var(--add-road-radius-sm);
    font-size:13px;font-weight:600;box-shadow:var(--add-road-shadow);
    display:none;z-index:20;
  }

  @media (max-width:900px){
    .add-road-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
  }
</style>

<div data-page="member-list" id="Main_dashboard_01_E">

  <div class="add-road-app">

    <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>

    <!-- ================= TOPBAR ================= -->
    <header class="add-road-topbar">
      <div class="add-road-topbar-heading">
        <h1>Dashboard</h1>
        <p>Dashboard Control System</p>
      </div>
      <div class="add-road-topbar-actions">
        <button class="add-road-icon-btn" title="Notifications" aria-label="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
        </button>
        <button class="add-road-icon-btn" title="Messages" aria-label="Messages">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
        </button>
        <button class="add-road-icon-btn" title="Sign out" aria-label="Sign out">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
        </button>
      </div>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="add-road-main">
      <p class="add-road-breadcrumb">
        <a role="button" tabindex="0" onclick="main_dashboard_01_A_OPEN()">Dashboard</a> /
        <a role="button" tabindex="0" onclick="main_dashboard_01_A_OPEN()">Member List</a> /
        <a role="button" tabindex="0" onclick="main_dashboard_01_F_OPEN()">Select Street</a> /
        <span>Add New Road</span>
      </p>

      <section class="add-road-panel" aria-label="Add New Road">

        <div class="add-road-panel-header">
          <div class="add-road-panel-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M4 20V6.5A2.5 2.5 0 0 1 6.5 4H15l5 5v11a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z"/>
              <path d="M14 4v4.5a.5.5 0 0 0 .5.5H19"/>
              <path d="M12 11v6M9 14h6"/>
            </svg>
            Add New Road
          </div>
          <a class="add-road-panel-close" onclick="main_dashboard_01_F_OPEN()" title="Close" aria-label="Close">✕</a>
        </div>

        <form class="add-road-form" id="add-road-form" onsubmit="Main_Dashboard_01_E_SUMBIT(event)" novalidate>
          <div class="add-road-field" id="add-road-field-name">
            <label for="Main_Dashboard_01_E_road">Road / Street Name</label>
            <input type="text" id="Main_Dashboard_01_E_road" name="val_01" placeholder="Enter road or street name (e.g. Road 6, Mosque Lane)" required>
            <span class="add-road-error" id="add-road-error-msg">Please enter a valid road or street name.</span>
          </div>

          <!-- <div class="add-road-field">
            <label for="add-road-notes">Note / Description (Optional)</label>
            <textarea id="add-road-notes" name="notes" placeholder="Enter any additional notes or landmark info..."></textarea>
          </div> -->

          <div class="add-road-actions">
            <button type="button" class="add-road-btn add-road-btn-ghost" onclick="main_dashboard_01_F_OPEN()">Cancel</button>
            <button type="submit" class="add-road-btn add-road-btn-primary" id="add-road-submit">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
              Add Road
            </button>
          </div>
        </form>

      </section>
    </main>

  </div>

  <div class="add-road-toast" id="add-road-toast">New road added successfully!</div>

</div>
