<?php 
    $pth = "../"; 
    $active_page = "Add-member"; // Tells the sidebar to highlight this tab
    $page_title = "Create New Member · WWJM Admin";
include_once __DIR__ . '/../../Includes/header.php'; 

?>


 

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Create New Member
     =================================================================== */
  :root{
    --add-member-green-950:#0B2E24;
    --add-member-green-800:#123832;
    --add-member-green-700:#1B4B41;
    --add-member-green-600:#245F52;
    --add-member-gold-600:#B8923D;
    --add-member-gold-500:#C9A227;
    --add-member-gold-300:#E4C766;
    --add-member-cream-50:#FAF7F0;
    --add-member-cream-100:#F2EDE0;
    --add-member-white:#FFFFFF;
    --add-member-ink-900:#1E2B26;
    --add-member-ink-600:#5A6A62;
    --add-member-ink-400:#8B978F;
    --add-member-border:#E6E0D0;
    --add-member-radius-sm:8px;
    --add-member-radius-lg:22px;
    --add-member-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--add-member-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--add-member-ink-900);
    -webkit-font-smoothing:antialiased;
  }

  .add-member-app{
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
  .add-member-topbar{
    grid-area:topbar;
    background:var(--add-member-white);
    border-bottom:1px solid var(--add-member-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .add-member-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--add-member-green-950);
  }
  .add-member-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--add-member-ink-400);}
  .add-member-topbar-actions{display:flex;align-items:center;gap:18px;}
  .add-member-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--add-member-cream-100);color:var(--add-member-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .add-member-icon-btn:hover{background:var(--add-member-gold-300);}
  .add-member-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .add-member-main{grid-area:main;padding:26px 30px 50px;}
  .add-member-breadcrumb{font-size:12px;color:var(--add-member-ink-400);margin-bottom:16px;}
  .add-member-breadcrumb a{color:var(--add-member-ink-400);text-decoration:none;}
  .add-member-breadcrumb a:hover{color:var(--add-member-green-700);}
  .add-member-breadcrumb span{color:var(--add-member-green-700);font-weight:600;}

  .add-member-panel{
    max-width:820px;
    margin:0 auto;
    background:var(--add-member-white);
    border-radius:var(--add-member-radius-lg);
    box-shadow:var(--add-member-shadow);
    overflow:hidden;
    border:1px solid var(--add-member-border);
  }

  .add-member-panel-header{
    background:linear-gradient(135deg,var(--add-member-green-800),var(--add-member-green-950));
    color:var(--add-member-cream-50);
    padding:26px 34px;
    display:flex;align-items:flex-start;justify-content:space-between;
  }
  .add-member-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:26px;font-weight:600;line-height:1.2;
  }
  .add-member-panel-title svg{width:22px;height:22px;flex:0 0 22px;color:var(--add-member-gold-300);}
  .add-member-panel-close{
    width:34px;height:34px;border-radius:50%;flex:0 0 34px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--add-member-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;font-size:15px;
    cursor:pointer;transition:background .15s ease;
  }
  .add-member-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Body: share options + QR ---------- */
  .add-member-body{
    display:grid;
    grid-template-columns:1fr auto;
    gap:44px;
    align-items:start;
    padding:34px;
  }

  .add-member-options{
    display:flex;flex-direction:column;gap:14px;
  }
  .add-member-option{
    display:flex;align-items:center;gap:12px;
    height:52px;padding:0 20px;
    border-radius:var(--add-member-radius-sm);
    border:none;cursor:pointer;
    background:var(--add-member-green-800);
    color:var(--add-member-cream-50);
    font-size:14px;font-weight:700;letter-spacing:0.01em;
    text-decoration:none;
    width:100%;
    max-width:280px;
    transition:background .15s ease, transform .1s ease, box-shadow .15s ease;
  }
  .add-member-option svg{width:17px;height:17px;flex:0 0 17px;color:var(--add-member-gold-300);}
  .add-member-option:hover{
    background:var(--add-member-green-950);
    box-shadow:0 4px 14px rgba(11,46,36,0.25);
  }
  .add-member-option:active{transform:translateY(1px);}
  .add-member-option.add-member-option-primary{
    background:linear-gradient(135deg,var(--add-member-gold-500),var(--add-member-gold-600));
    color:var(--add-member-green-950);
  }
  .add-member-option.add-member-option-primary svg{color:var(--add-member-green-950);}
  .add-member-option.add-member-option-primary:hover{box-shadow:0 4px 14px rgba(184,146,61,0.4);}

  .add-member-qr{
    display:flex;flex-direction:column;align-items:center;gap:14px;
    padding:20px;
    border:1px solid var(--add-member-border);
    border-radius:var(--add-member-radius-sm);
    background:var(--add-member-cream-50);
  }
  .add-member-qr-code{
    width:170px;height:170px;
    display:flex;align-items:center;justify-content:center;
    background:var(--add-member-white);
    border-radius:6px;
  }
  .add-member-qr-code img,.add-member-qr-code canvas{width:100%;height:100%;display:block;}
  .add-member-qr-caption{font-size:13px;font-weight:600;color:var(--add-member-ink-600);text-align:center;}

  .add-member-toast{
    position:fixed;top:20px;right:20px;
    background:var(--add-member-green-950);color:var(--add-member-cream-50);
    border-left:4px solid var(--add-member-gold-500);
    padding:14px 18px;border-radius:var(--add-member-radius-sm);
    font-size:13px;font-weight:600;box-shadow:var(--add-member-shadow);
    display:none;z-index:20;
  }

  @media (max-width:720px){
    .add-member-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .add-member-body{grid-template-columns:1fr;justify-items:center;}
    .add-member-options{align-items:center;}
  }
</style>

<div data-page="member-list" id="Main_dashboard_01_B">

<div class="add-member-app">

  <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>

  

  <!-- ================= TOPBAR ================= -->
  <header class="add-member-topbar">
    <div class="add-member-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="add-member-topbar-actions">
      <button class="add-member-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="add-member-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="add-member-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="add-member-main">
    <p class="add-member-breadcrumb">
      <a href="member-list.php">Dashboard</a> /
      <a href="member-list.php">Member List</a> /
      <span>Add New</span>
    </p>

    <section class="add-member-panel" aria-label="Create new member">

      <div class="add-member-panel-header">
        <div class="add-member-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.4"/><path d="M2.5 20c1-4 3.4-6 6.5-6s5.5 2 6.5 6"/><path d="M18 5v8M14 9h8"/></svg>
          Create New Member
        </div>
        <a class="add-member-panel-close" onclick="main_dashboard_01_A_OPEN()" title="Close" aria-label="Close">✕</a>
      </div>

      <div class="add-member-body">

        <div class="add-member-options">
          <a class="add-member-option" id="add-member-share-sms" href="share-sms.php">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="13" rx="2.2"/><path d="M7 20h4M9 18v2"/><path d="M7 9h6M7 12.5h9"/></svg>
            Share From SMS
          </a>

          <button class="add-member-option" id="add-member-share-email" onclick="addMemberShareEmail()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
            Share From Email
          </button>

          <button class="add-member-option" id="add-member-share-url" onclick="addMemberShareUrl()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9.5 14.5 14.5 9.5"/><path d="M12 6.5 13.6 4.9a3.3 3.3 0 0 1 4.7 4.7L16.7 11"/><path d="M12 17.5 10.4 19.1a3.3 3.3 0 0 1-4.7-4.7L7.3 13"/></svg>
            Share By URL
          </button>

          <a class="add-member-option add-member-option-primary" onclick="main_dashboard_01_F_OPEN()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20V6.5A2.5 2.5 0 0 1 6.5 4H15l5 5v11a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z"/><path d="M14 4v4.5a.5.5 0 0 0 .5.5H19"/><path d="M9 13h6M9 16.5h4"/></svg>
            Manual Enter
          </a>
        </div>

        <div class="add-member-qr">
          <div class="add-member-qr-code" id="add-member-qr-code"></div>
          <div class="add-member-qr-caption">Scan To Get The Form</div>
        </div>

      </div>

    </section>

    <p style="text-align:center;font-size:11px;color:var(--add-member-ink-400);padding-top:22px;">© 2026 Sky Cargo Express Logistics | Neo Solution</p>
  </main>

</div>

<div class="add-member-toast" id="add-member-toast">Link copied to clipboard.</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  /* ===================================================================
     add-member.js — Create New Member hub logic (WWJM Admin)
     =================================================================== */

  // Public self-service form URL members fill in from their own phone.
  // Replace with your real hosted form URL once it exists.
  const addMemberFormUrl = window.location.origin + window.location.pathname.replace('add-member.php', 'add-member-manual.php');

  // Render the QR code (falls back to a plain link if the CDN is blocked).
  if (typeof QRCode !== 'undefined') {
    new QRCode(document.getElementById('add-member-qr-code'), {
      text: addMemberFormUrl,
      width: 170,
      height: 170,
      colorDark: '#0B2E24',
      colorLight: '#FFFFFF'
    });
  } else {
    document.getElementById('add-member-qr-code').innerHTML =
      '<a href="' + addMemberFormUrl + '" style="font-size:11px;color:#5A6A62;padding:8px;text-align:center;">' + addMemberFormUrl + '</a>';
  }

  function addMemberToast(message){
    const toast = document.getElementById('add-member-toast');
    toast.textContent = message;
    toast.style.display = 'block';
    clearTimeout(window.__addMemberToastTimer);
    window.__addMemberToastTimer = setTimeout(function(){ toast.style.display = 'none'; }, 2400);
  }

  function addMemberShareEmail(){
    const subject = encodeURIComponent('WWJM Member Registration Form');
    const body = encodeURIComponent('Assalamu alaikum,\n\nPlease fill in your member details using the link below:\n' + addMemberFormUrl);
    window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
  }

  function addMemberShareUrl(){
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(addMemberFormUrl).then(function(){
        addMemberToast('Link copied to clipboard.');
      }).catch(function(){
        addMemberToast(addMemberFormUrl);
      });
    } else {
      addMemberToast(addMemberFormUrl);
    }
  }
</script>

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->

</div>
