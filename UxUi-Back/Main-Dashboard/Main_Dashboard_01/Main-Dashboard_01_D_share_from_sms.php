<?php 
    $pth = "../"; 
    $active_page = "share-sms"; // Tells the sidebar to highlight this tab
    $page_title = "Share By SMS · WWJM Admin";
include '../Includes/header.php'; 
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Share By SMS
     =================================================================== */
  :root{
    --share-sms-green-950:#0B2E24;
    --share-sms-green-800:#123832;
    --share-sms-green-700:#1B4B41;
    --share-sms-gold-600:#B8923D;
    --share-sms-gold-500:#C9A227;
    --share-sms-gold-300:#E4C766;
    --share-sms-cream-50:#FAF7F0;
    --share-sms-cream-100:#F2EDE0;
    --share-sms-white:#FFFFFF;
    --share-sms-ink-900:#1E2B26;
    --share-sms-ink-600:#5A6A62;
    --share-sms-ink-400:#8B978F;
    --share-sms-border:#E6E0D0;
    --share-sms-danger:#B0453A;
    --share-sms-radius-sm:8px;
    --share-sms-radius-lg:22px;
    --share-sms-shadow:0 6px 24px rgba(11,46,36,0.08);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--share-sms-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--share-sms-ink-900);
    -webkit-font-smoothing:antialiased;
  }

  .share-sms-app{
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
  .share-sms-topbar{
    grid-area:topbar;
    background:var(--share-sms-white);
    border-bottom:1px solid var(--share-sms-border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 30px;
  }
  .share-sms-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;font-weight:600;margin:0;
    color:var(--share-sms-green-950);
  }
  .share-sms-topbar-heading p{margin:1px 0 0;font-size:11.5px;color:var(--share-sms-ink-400);}
  .share-sms-topbar-actions{display:flex;align-items:center;gap:18px;}
  .share-sms-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--share-sms-cream-100);color:var(--share-sms-green-800);
    border:none;cursor:pointer;transition:background .15s ease;
  }
  .share-sms-icon-btn:hover{background:var(--share-sms-gold-300);}
  .share-sms-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .share-sms-main{grid-area:main;padding:26px 30px 50px;}
  .share-sms-breadcrumb{font-size:12px;color:var(--share-sms-ink-400);margin-bottom:16px;}
  .share-sms-breadcrumb a{color:var(--share-sms-ink-400);text-decoration:none;}
  .share-sms-breadcrumb a:hover{color:var(--share-sms-green-700);}
  .share-sms-breadcrumb span{color:var(--share-sms-green-700);font-weight:600;}

  .share-sms-panel{
    max-width:560px;
    background:var(--share-sms-white);
    border-radius:var(--share-sms-radius-lg);
    box-shadow:var(--share-sms-shadow);
    overflow:hidden;
    border:1px solid var(--share-sms-border);
  }

  .share-sms-panel-header{
    background:linear-gradient(135deg,var(--share-sms-green-800),var(--share-sms-green-950));
    color:var(--share-sms-cream-50);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .share-sms-panel-title{
    display:flex;align-items:center;gap:12px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:24px;font-weight:600;
  }
  .share-sms-panel-title svg{width:20px;height:20px;flex:0 0 20px;color:var(--share-sms-gold-300);}
  .share-sms-panel-close{
    width:32px;height:32px;border-radius:50%;flex:0 0 32px;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--share-sms-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .share-sms-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Form ---------- */
  .share-sms-form{padding:28px 32px 30px;}
  .share-sms-field{display:flex;flex-direction:column;gap:8px;}
  .share-sms-field label{
    font-size:13.5px;font-weight:700;
    color:var(--share-sms-ink-900);
  }
  .share-sms-field input{
    height:46px;
    border:1px solid var(--share-sms-border);
    border-radius:var(--share-sms-radius-sm);
    padding:0 16px;
    font-size:14px;
    font-family:inherit;
    color:var(--share-sms-ink-900);
    background:var(--share-sms-white);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .share-sms-field input::placeholder{color:var(--share-sms-ink-400);}
  .share-sms-field input:focus{
    border-color:var(--share-sms-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }
  .share-sms-field.share-sms-invalid input{border-color:var(--share-sms-danger);}
  .share-sms-error{
    font-size:11.5px;color:var(--share-sms-danger);
    margin-top:6px;display:none;
  }
  .share-sms-field.share-sms-invalid .share-sms-error{display:block;}

  .share-sms-actions{
    display:flex;align-items:center;gap:12px;
    margin-top:24px;
  }
  .share-sms-btn{
    height:44px;padding:0 22px;
    border-radius:var(--share-sms-radius-sm);
    border:none;cursor:pointer;
    font-size:13.5px;font-weight:700;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    text-decoration:none;
    transition:background .15s ease, box-shadow .15s ease, transform .1s ease;
  }
  .share-sms-btn:active{transform:translateY(1px);}
  .share-sms-btn-ghost{
    background:var(--share-sms-cream-100);
    color:var(--share-sms-ink-900);
  }
  .share-sms-btn-ghost:hover{background:var(--share-sms-border);}
  .share-sms-btn-primary{
    background:linear-gradient(135deg,var(--share-sms-gold-500),var(--share-sms-gold-600));
    color:var(--share-sms-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .share-sms-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}
  .share-sms-btn-primary:disabled{opacity:0.6;cursor:not-allowed;box-shadow:none;}

  .share-sms-toast{
    position:fixed;top:20px;right:20px;
    background:var(--share-sms-green-950);color:var(--share-sms-cream-50);
    border-left:4px solid var(--share-sms-gold-500);
    padding:14px 18px;border-radius:var(--share-sms-radius-sm);
    font-size:13px;font-weight:600;box-shadow:var(--share-sms-shadow);
    display:none;z-index:20;
  }

  @media (max-width:900px){
    .share-sms-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
  }
</style>

<body data-page="member-list">

<div class="share-sms-app">

     <?php include "../Includes/Sidebar.php"; ?>

  

  <!-- ================= TOPBAR ================= -->
  <header class="share-sms-topbar">
    <div class="share-sms-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="share-sms-topbar-actions">
      <button class="share-sms-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="share-sms-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="share-sms-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="share-sms-main">
    <p class="share-sms-breadcrumb">
      <a href="member-list.php">Dashboard</a> /
      <a href="member-list.php">Member List</a> /
      <a href="add-member.php">Add New</a> /
      <span>Share By SMS</span>
    </p>

    <section class="share-sms-panel" aria-label="Share by SMS">

      <div class="share-sms-panel-header">
        <div class="share-sms-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="13" rx="2.2"/><path d="M7 20h4M9 18v2"/><path d="M7 9h6M7 12.5h9"/></svg>
          Share By SMS
        </div>
        <a class="share-sms-panel-close" href="add-member.php" title="Close" aria-label="Close">✕</a>
      </div>

      <form class="share-sms-form" id="share-sms-form" novalidate>
        <div class="share-sms-field" id="share-sms-field-number">
          <label for="share-sms-number">Local Number</label>
          <input type="tel" id="share-sms-number" name="number" placeholder="0xx xxx xxxx" inputmode="numeric" autocomplete="tel" required>
          <span class="share-sms-error">Please enter a valid local mobile number.</span>
        </div>

        <div class="share-sms-actions">
          <a class="share-sms-btn share-sms-btn-ghost" href="add-member.php">Cancel</a>
          <button type="submit" class="share-sms-btn share-sms-btn-primary" id="share-sms-submit">Share Now</button>
        </div>
      </form>

    </section>
  </main>

</div>

<div class="share-sms-toast" id="share-sms-toast">Form link sent by SMS.</div>

<script>
  /* ===================================================================
     share-sms.js — Share By SMS logic (WWJM Admin)
     =================================================================== */

  // Same public form URL used on the Create New Member / QR page.
  const shareSmsFormUrl = window.location.origin + window.location.pathname.replace('share-sms.php', 'add-member-manual.php');

  document.getElementById('share-sms-form').addEventListener('submit', function(e){
    e.preventDefault();

    const input = document.getElementById('share-sms-number');
    const wrap = document.getElementById('share-sms-field-number');
    const value = input.value.trim();

    // Basic Sri Lankan local-number check: starts with 0, 9-10 digits total.
    const valid = /^0\d{9}$/.test(value.replace(/\s+/g, ''));
    wrap.classList.toggle('share-sms-invalid', !valid);
    if(!valid){ input.focus(); return; }

    // TODO: replace with a real SMS-send request to your backend, e.g.
    // fetch('send-member-sms.php', { method:'POST', body:new FormData(this) });
    // For now this opens the device's own SMS composer, pre-filled.
    const body = encodeURIComponent('Please fill in your WWJM member form here: ' + shareSmsFormUrl);
    window.location.href = 'sms:' + value + '?&body=' + body;

    const toast = document.getElementById('share-sms-toast');
    toast.style.display = 'block';
    setTimeout(function(){ toast.style.display = 'none'; }, 2400);
  });
</script>

<!-- Loads sidebar.php into # above. Remove this line
     if you switch to a PHP include instead. -->


</body>
