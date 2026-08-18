<?php 
    $pth = "../"; 
    $active_page = "member-street-list"; // Tells the sidebar to highlight this tab
    $page_title = "Member Street List · WWJM Admin";
include '../UxUI-Back/Includes/header.php'; 
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Member Street List
     =================================================================== */
  :root{
    --member-street-green-950:#0B2E24;
    --member-street-green-800:#123832;
    --member-street-green-700:#1B4B41;
    --member-street-gold-600:#B8923D;
    --member-street-gold-500:#C9A227;
    --member-street-gold-300:#E4C766;
    --member-street-cream-50:#FAF7F0;
    --member-street-cream-100:#F2EDE0;
    --member-street-white:#FFFFFF;
    --member-street-ink-900:#1E2B26;
    --member-street-ink-600:#5A6A62;
    --member-street-ink-400:#8B978F;
    --member-street-border:#E6E0D0;
    --member-street-radius-sm:8px;
    --member-street-radius-lg:22px;
    --member-street-shadow:0 6px 24px rgba(11,46,36,0.08);
    --member-street-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--member-street-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--member-street-ink-900);
    -webkit-font-smoothing:antialiased;
  }

  .member-street-app{
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
  .member-street-topbar{
    grid-area:topbar;
    background:var(--member-street-white);
    border-bottom:1px solid var(--member-street-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .member-street-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--member-street-green-950);
  }
  .member-street-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--member-street-ink-400);}
  .member-street-topbar-actions{display:flex;align-items:center;gap:18px;}
  .member-street-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--member-street-cream-100);color:var(--member-street-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .member-street-icon-btn:hover{background:var(--member-street-gold-300);}
  .member-street-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .member-street-main{grid-area:main;padding:26px 30px 50px;}
  .member-street-breadcrumb{font-size:12px;color:var(--member-street-ink-400);margin-bottom:16px;}
  .member-street-breadcrumb a{color:var(--member-street-ink-400);text-decoration:none;}
  .member-street-breadcrumb a:hover{color:var(--member-street-green-700);}
  .member-street-breadcrumb span{color:var(--member-street-green-700);font-weight:600;}

  .member-street-panel{
    max-width:700px;
    margin:0 auto;
    background:var(--member-street-white);
    border-radius:var(--member-street-radius-lg);
    box-shadow:var(--member-street-shadow);
    overflow:hidden;
    border:1px solid var(--member-street-border);
  }

  .member-street-panel-header{
    background:linear-gradient(135deg,var(--member-street-green-800),var(--member-street-green-950));
    color:var(--member-street-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .member-street-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .member-street-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--member-street-gold-300);}
  .member-street-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--member-street-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .member-street-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Toolbar ---------- */
  .member-street-toolbar{
    display:flex;align-items:center;gap:14px;flex-wrap:wrap;
    padding:24px 32px 18px;
  }
  .member-street-search-wrap{
    position:relative;
    flex:1;min-width:220px;
    display:flex;align-items:center;
  }
  .member-street-search-icon{
    position:absolute;left:14px;
    width:16px;height:16px;
    color:var(--member-street-ink-400);
    pointer-events:none;
  }
  .member-street-search{
    width:100%;
    height:44px;
    border:1px solid var(--member-street-border);
    border-radius:var(--member-street-radius-sm);
    padding:0 16px 0 40px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--member-street-ink-900);
    background:var(--member-street-white);
    box-shadow:var(--member-street-shadow-sm);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .member-street-search::placeholder{color:var(--member-street-ink-400);}
  .member-street-search:focus{
    border-color:var(--member-street-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }

  .member-street-btn{
    height:44px;padding:0 20px;
    border-radius:var(--member-street-radius-sm);
    border:none;cursor:pointer;
    font-size:13px;font-weight:700;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    white-space:nowrap;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .member-street-btn:active{transform:translateY(1px);}
  .member-street-btn-primary{
    background:linear-gradient(135deg,var(--member-street-gold-500),var(--member-street-gold-600));
    color:var(--member-street-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .member-street-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}

  /* ---------- Street list ---------- */
  .member-street-list{
    display:flex;flex-direction:column;
    padding:0 32px 30px;
    gap:10px;
  }
  .member-street-row{
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 18px;
    background:var(--member-street-cream-50);
    border:1px solid var(--member-street-border);
    border-radius:var(--member-street-radius-sm);
    transition:border-color .15s ease, background .15s ease;
  }
  .member-street-row:hover{border-color:var(--member-street-gold-500);background:var(--member-street-white);}
  .member-street-name{font-size:14px;font-weight:700;color:var(--member-street-ink-900);}
  .member-street-select{
    height:36px;padding:0 20px;
    border-radius:var(--member-street-radius-sm);
    border:1px solid var(--member-street-green-700);
    background:var(--member-street-white);
    color:var(--member-street-green-700);
    font-size:12.5px;font-weight:700;letter-spacing:0.01em;
    cursor:pointer;
    transition:background .15s ease,color .15s ease;
  }
  .member-street-select:hover{
    background:var(--member-street-green-800);
    color:var(--member-street-cream-50);
    border-color:var(--member-street-green-800);
  }

  .member-street-empty{
    padding:40px 18px;text-align:center;color:var(--member-street-ink-400);font-size:13.5px;
  }

  @media (max-width:900px){
    .member-street-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .member-street-toolbar{flex-direction:column;align-items:stretch;}
    .member-street-btn{width:100%;justify-content:center;}
  }
</style>

<div data-page="member-list" id="Main_dashboard_01_F">

  <div class="member-street-app">

      <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>

    

    <!-- ================= TOPBAR ================= -->
    <header class="member-street-topbar">
      <div class="member-street-topbar-heading">
        <h1>Dashboard</h1>
        <p>Dashboard Control System</p>
      </div>
      <div class="member-street-topbar-actions">
        <button class="member-street-icon-btn" title="Notifications" aria-label="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
        </button>
        <button class="member-street-icon-btn" title="Messages" aria-label="Messages">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
        </button>
        <button class="member-street-icon-btn" title="Sign out" aria-label="Sign out">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
        </button>
      </div>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="member-street-main">
      <p class="member-street-breadcrumb">
        <a href="javascript:void(0);" onclick="main_dashboard_01_A_OPEN()">Dashboard</a> /
        <a href="javascript:void(0);" onclick="main_dashboard_01_A_OPEN()">Member List</a> /
        <a href="javascript:void(0);" onclick="main_dashboard_01_B_OPEN()">Add New</a> /
        <span>Select Street</span>
      </p>

      <section class="member-street-panel" aria-label="Member street list">

        <div class="member-street-panel-header">
          <div class="member-street-panel-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20V6.5A2.5 2.5 0 0 1 6.5 4H15l5 5v11a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z"/><path d="M14 4v4.5a.5.5 0 0 0 .5.5H19"/><path d="M9 13h6M9 16.5h4"/></svg>
            Member Street List
          </div>
          <a class="member-street-panel-close" onclick="main_dashboard_01_A_OPEN()" title="Close" aria-label="Close">✕</a>
        </div>

        <div class="member-street-toolbar">
          <div class="member-street-search-wrap">
            <svg class="member-street-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="7"/>
              <path d="m20 20-3.5-3.5"/>
            </svg>
            <input type="text" class="member-street-search" id="member-street-search"
                  placeholder="Search from road here..." oninput="memberStreetRender()" onkeyup="memberStreetRender()">
          </div>
          <button class="member-street-btn member-street-btn-primary" onclick="main_dashboard_01_E_OPEN()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
            Add New Road
          </button>
        </div>

        <div class="member-street-list" id="member-street-list"></div>
        <div class="member-street-empty" id="member-street-empty" style="display:none;">No roads match this search.</div>

      </section>
    </main>

  </div>

</div>
