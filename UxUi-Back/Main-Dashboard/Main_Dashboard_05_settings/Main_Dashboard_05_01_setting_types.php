<?php 
    $pth = "../"; 
    $active_page = "settings"; // Tells the sidebar to highlight this tab
    $page_title = "Settings · WWJM Admin";
include '../UxUI-Back/Includes/header.php'; 
?>

<title>Settings · WWJM Admin</title>
<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Settings
     =================================================================== */
  :root{
    --settings-green-950:#0B2E24;
    --settings-green-800:#123832;
    --settings-green-700:#1B4B41;
    --settings-gold-600:#B8923D;
    --settings-gold-500:#C9A227;
    --settings-gold-300:#E4C766;
    --settings-cream-50:#FAF7F0;
    --settings-cream-100:#F2EDE0;
    --settings-white:#FFFFFF;
    --settings-ink-900:#1E2B26;
    --settings-ink-600:#5A6A62;
    --settings-ink-400:#8B978F;
    --settings-border:#E6E0D0;
    --settings-radius-sm:8px;
    --settings-radius-lg:22px;
    --settings-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--settings-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--settings-ink-900);
    -webkit-font-smoothing:antialiased;
    padding-bottom:40px; /* keeps content clear of the fixed shared footer */
  }

  .settings-app{
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
  .settings-topbar{
    grid-area:topbar;
    background:var(--settings-white);
    border-bottom:1px solid var(--settings-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .settings-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--settings-green-950);
  }
  .settings-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--settings-ink-400);}
  .settings-topbar-actions{display:flex;align-items:center;gap:18px;}
  .settings-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--settings-cream-100);color:var(--settings-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .settings-icon-btn:hover{background:var(--settings-gold-300);}
  .settings-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  /* Centers the card both horizontally and vertically — same reusable
     pattern used on project.php and payment-new.php. */
  .settings-main{
    grid-area:main;
    padding:26px 30px 50px;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:calc(100vh - 64px);
  }

  .settings-panel{
    width:100%;
    max-width:520px;
    background:var(--settings-white);
    border-radius:var(--settings-radius-lg);
    box-shadow:var(--settings-shadow);
    overflow:hidden;
    border:1px solid var(--settings-border);
  }

  .settings-panel-header{
    background:linear-gradient(135deg,var(--settings-green-800),var(--settings-green-950));
    color:var(--settings-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .settings-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .settings-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--settings-gold-300);}
  .settings-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--settings-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .settings-panel-close:hover{background:rgba(250,247,240,0.12);}

  .settings-options{
    display:flex;flex-direction:column;gap:14px;
    padding:28px 32px 32px;
  }
  .settings-option{
    width:100%;
    height:52px;
    display:flex;align-items:center;justify-content:center;
    border-radius:var(--settings-radius-sm);
    border:none;cursor:pointer;
    background:var(--settings-green-800);
    color:var(--settings-cream-50);
    font-size:14px;font-weight:700;letter-spacing:0.01em;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .settings-option:hover{
    background:var(--settings-green-950);
    box-shadow:0 4px 14px rgba(11,46,36,0.25);
  }
  .settings-option:active{transform:translateY(1px);}

  @media (max-width:900px){
    .settings-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .settings-main{padding:26px 18px 50px;}
  }
</style>

<div data-page="settings" id="Main_Dashboard_05_01">

<div class="settings-app">

     <?php include "../UxUI-Back/Includes/Sidebar.php"; ?>

  

  <!-- ================= TOPBAR ================= -->
  <header class="settings-topbar">
    <div class="settings-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="settings-topbar-actions">
      <button class="settings-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="settings-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="settings-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="settings-main">
    <section class="settings-panel" aria-label="Settings">

      <div class="settings-panel-header">
        <div class="settings-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="2.6"/><path d="M19.4 13.4a7.6 7.6 0 0 0 0-2.8l2-1.5-2-3.4-2.3.9a7.5 7.5 0 0 0-2.4-1.4L14.3 3h-4l-.4 2.2a7.5 7.5 0 0 0-2.4 1.4l-2.3-.9-2 3.4 2 1.5a7.6 7.6 0 0 0 0 2.8l-2 1.5 2 3.4 2.3-.9c.7.6 1.5 1.1 2.4 1.4L10.3 21h4l.4-2.2c.9-.3 1.7-.8 2.4-1.4l2.3.9 2-3.4-2-1.5Z"/></svg>
          Settings
        </div>
        <a class="settings-panel-close" onclick="main_dashboard_01_A_OPEN()" title="Close" aria-label="Close">✕</a>
      </div>

      <div class="settings-options">
        <a class="settings-option" href="settings-user-account.php">User Account</a>
        <a class="settings-option" href="settings-management.php">Management Settings</a>
        <a class="settings-option" onclick="main_dashboard_05_03_A_OPEN()">Bank Account</a>
        <a class="settings-option" href="settings-income-expense-type.php">Income &amp; Expense Type</a>
        <a class="settings-option" href="settings-add-old-members.php">Add Old Members</a>
      </div>

    </section>
  </main>

</div>

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->


<!-- ================= FOOTER (shared component) =================
     PHP projects: delete this div and put <?php include 'footer.php'; ?>
     in its place instead. -->
<div id="wwjm-footer-root"></div>
<script src="footer-loader.js"></script>

</div>
