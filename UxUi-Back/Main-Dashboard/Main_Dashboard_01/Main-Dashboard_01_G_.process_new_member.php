<?php 
    $pth = "../"; 
    $active_page = "Add-member-manual"; // Tells the sidebar to highlight this tab
    $page_title = "Manual Entry · Add New Member · WWJM Admin";
if (file_exists(__DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php')) {
    include_once __DIR__ . '/../../../imports/Company_Info/Company_Info_Variable_List.php';
}
$company_info_var = class_exists('Company_Info_Variable_List') ? new Company_Info_Variable_List() : null;
$needed_contact_person_count = ($company_info_var && method_exists($company_info_var, 'get_needed_contact_person_count')) ? $company_info_var->get_needed_contact_person_count() : 2;
?>

<style>
  /* ===================================================================
     WWJM Admin — Design tokens (shared values, same as member-list.php)
     Wellawatta Jumma Mosque · Dashboard · Add New Member
     =================================================================== */
  :root{
    --add-member-manual-green-950:#0B2E24;
    --add-member-manual-green-800:#123832;
    --add-member-manual-green-700:#1B4B41;
    --add-member-manual-gold-600:#B8923D;
    --add-member-manual-gold-500:#C9A227;
    --add-member-manual-gold-300:#E4C766;
    --add-member-manual-cream-50:#FAF7F0;
    --add-member-manual-cream-100:#F2EDE0;
    --add-member-manual-white:#FFFFFF;
    --add-member-manual-ink-900:#1E2B26;
    --add-member-manual-ink-600:#5A6A62;
    --add-member-manual-ink-400:#8B978F;
    --add-member-manual-border:#E6E0D0;
    --add-member-manual-danger:#B0453A;
    --add-member-manual-radius-sm:6px;
    --add-member-manual-radius-lg:22px;
    --add-member-manual-shadow:0 6px 24px rgba(11,46,36,0.08);
    --add-member-manual-shadow-sm:0 2px 8px rgba(11,46,36,0.06);
  }

  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}

  body{
    background:var(--add-member-manual-cream-50);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
    color:var(--add-member-manual-ink-900);
    -webkit-font-smoothing:antialiased;
  }

  .add-member-manual-app{
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
  .add-member-manual-topbar{
    grid-area:topbar;
    background:var(--add-member-manual-white);
    border-bottom:1px solid var(--add-member-manual-border);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
  }
  .add-member-manual-topbar-heading h1{
    font-family:'Poppins',Inter,sans-serif;
    font-size:19px;
    font-weight:600;
    margin:0;
    color:var(--add-member-manual-green-950);
  }
  .add-member-manual-topbar-heading p{
    margin:1px 0 0;
    font-size:11.5px;
    color:var(--add-member-manual-ink-400);
  }
  .add-member-manual-topbar-actions{display:flex;align-items:center;gap:18px;}
  .add-member-manual-icon-btn{
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--add-member-manual-cream-100);
    color:var(--add-member-manual-green-800);
    border:none;cursor:pointer;
    transition:background .15s ease;
  }
  .add-member-manual-icon-btn:hover{background:var(--add-member-manual-gold-300);}
  .add-member-manual-icon-btn svg{width:16px;height:16px;}

  /* ---------- Main ---------- */
  .add-member-manual-main{
    grid-area:main;
    padding:26px 30px 50px;
  }
  .add-member-manual-breadcrumb{
    font-size:12px;
    color:var(--add-member-manual-ink-400);
    margin-bottom:16px;
  }
  .add-member-manual-breadcrumb a{color:var(--add-member-manual-ink-400);text-decoration:none;}
  .add-member-manual-breadcrumb a:hover{color:var(--add-member-manual-green-700);}
  .add-member-manual-breadcrumb span{color:var(--add-member-manual-green-700);font-weight:600;}

  .add-member-manual-panel{
    max-width:900px;
    margin:0 auto;
    background:var(--add-member-manual-white);
    border-radius:var(--add-member-manual-radius-lg);
    box-shadow:var(--add-member-manual-shadow);
    overflow:hidden;
    border:1px solid var(--add-member-manual-border);
  }

  .add-member-manual-panel-header{
    background:linear-gradient(135deg,var(--add-member-manual-green-800),var(--add-member-manual-green-950));
    color:var(--add-member-manual-cream-50);
    padding:22px 30px 26px;
    display:flex;align-items:center;justify-content:space-between;
  }
  .add-member-manual-panel-title{
    display:flex;align-items:center;gap:10px;
    font-family:'Poppins',Inter,sans-serif;
    font-size:21px;font-weight:600;letter-spacing:0.01em;
  }
  .add-member-manual-panel-title svg{width:18px;height:18px;color:var(--add-member-manual-gold-300);}
  .add-member-manual-panel-close{
    width:32px;height:32px;border-radius:50%;
    border:1px solid rgba(250,247,240,0.25);
    background:transparent;color:var(--add-member-manual-cream-50);
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    cursor:pointer;transition:background .15s ease;
  }
  .add-member-manual-panel-close:hover{background:rgba(250,247,240,0.12);}

  /* ---------- Form ---------- */
  .add-member-manual-form{padding:28px 30px 30px;}
  .add-member-manual-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
  }
  .add-member-manual-field{display:flex;flex-direction:column;gap:6px;}
  .add-member-manual-field.add-member-manual-span-2{grid-column:1 / -1;}
  .add-member-manual-field label{
    font-size:11px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;
    color:var(--add-member-manual-ink-600);
  }
  .add-member-manual-field .add-member-manual-required{color:var(--add-member-manual-danger);margin-left:2px;}
  .add-member-manual-field input,.add-member-manual-field select,.add-member-manual-field textarea{
    height:42px;
    border:1px solid var(--add-member-manual-border);
    border-radius:var(--add-member-manual-radius-sm);
    padding:0 14px;
    font-size:13.5px;
    font-family:inherit;
    color:var(--add-member-manual-ink-900);
    background:var(--add-member-manual-white);
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .add-member-manual-field textarea{
    height:auto;padding:10px 14px;resize:vertical;min-height:80px;
  }
  .add-member-manual-field input:focus,.add-member-manual-field select:focus,.add-member-manual-field textarea:focus{
    border-color:var(--add-member-manual-gold-500);
    box-shadow:0 0 0 3px rgba(201,162,39,0.15);
  }
  .add-member-manual-hint{font-size:11px;color:var(--add-member-manual-ink-400);}
  .add-member-manual-error{font-size:11px;color:var(--add-member-manual-danger);display:none;}
  .add-member-manual-field.add-member-manual-invalid input,
  .add-member-manual-field.add-member-manual-invalid select{border-color:var(--add-member-manual-danger);}
  .add-member-manual-field.add-member-manual-invalid .add-member-manual-error{display:block;}

  .add-member-manual-divider{
    height:1px;background:var(--add-member-manual-border);
    margin:26px 0;
  }

  /* ---------- Subsection panels (grouped blocks within the form) ---------- */
  .add-member-manual-subsection{
    grid-column:1 / -1;
    background:var(--add-member-manual-cream-100);
    border:1px solid var(--add-member-manual-border);
    border-radius:var(--add-member-manual-radius-sm);
    padding:18px 20px 20px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
  }
  .add-member-manual-subsection-title{
    grid-column:1 / -1;
    font-family:'Poppins',Inter,sans-serif;
    font-size:14px;font-weight:600;
    color:var(--add-member-manual-green-800);
    margin:0 0 2px;
  }

  /* ---------- Checkbox controls ---------- */
  .add-member-manual-checkbox-row{
    grid-column:1 / -1;
    display:flex;flex-wrap:wrap;gap:22px;
  }
  .add-member-manual-checkbox{
    display:flex;align-items:center;gap:8px;
    font-size:13px;font-weight:500;
    color:var(--add-member-manual-ink-900);
    cursor:pointer;
    user-select:none;
  }
  .add-member-manual-checkbox input[type="checkbox"]{
    width:17px;height:17px;
    accent-color:var(--add-member-manual-green-700);
    cursor:pointer;
  }
  .add-member-manual-field-with-check{
    display:flex;align-items:center;gap:12px;
  }
  .add-member-manual-field-with-check .add-member-manual-field{flex:1;}
  .add-member-manual-field-with-check .add-member-manual-checkbox{
    white-space:nowrap;padding-top:22px;
  }

  .add-member-manual-existing-row{
    grid-column:1 / -1;
    display:grid;
    grid-template-columns:auto 1fr;
    align-items:end;
    gap:16px;
  }
  .add-member-manual-existing-row .add-member-manual-checkbox{padding-bottom:11px;}

  .add-member-manual-actions{
    display:flex;align-items:center;justify-content:flex-end;gap:12px;
  }
  .add-member-manual-btn{
    height:42px;padding:0 22px;
    border-radius:var(--add-member-manual-radius-sm);
    border:none;cursor:pointer;
    font-size:13px;font-weight:600;letter-spacing:0.01em;
    display:inline-flex;align-items:center;gap:8px;
    text-decoration:none;
    transition:transform .1s ease, box-shadow .15s ease, background .15s ease, color .15s ease;
  }
  .add-member-manual-btn:active{transform:translateY(1px);}
  .add-member-manual-btn-ghost{
    background:transparent;
    border:1px solid var(--add-member-manual-border);
    color:var(--add-member-manual-ink-600);
  }
  .add-member-manual-btn-ghost:hover{border-color:var(--add-member-manual-green-700);color:var(--add-member-manual-green-700);}
  .add-member-manual-btn-primary{
    background:linear-gradient(135deg,var(--add-member-manual-gold-500),var(--add-member-manual-gold-600));
    color:var(--add-member-manual-green-950);
    box-shadow:0 4px 12px rgba(184,146,61,0.35);
  }
  .add-member-manual-btn-primary:hover{box-shadow:0 6px 16px rgba(184,146,61,0.45);}

  .add-member-manual-toast{
    position:fixed;top:20px;right:20px;
    background:var(--add-member-manual-green-950);
    color:var(--add-member-manual-cream-50);
    border-left:4px solid var(--add-member-manual-gold-500);
    padding:14px 18px;
    border-radius:var(--add-member-manual-radius-sm);
    font-size:13px;font-weight:600;
    box-shadow:var(--add-member-manual-shadow);
    display:none;
    z-index:20;
  }

  @media (max-width:900px){
    .add-member-manual-app{grid-template-columns:1fr;grid-template-areas:"topbar" "main";}
    .add-member-manual-grid{grid-template-columns:1fr;}
  }
</style>

<div data-page="member-list" id="Main_dashboard_01_G">


<div class="add-member-manual-app">

 <?php include_once __DIR__ . '/../../Includes/sidebar.php'; ?>

     
  

  <!-- ================= TOPBAR ================= -->
  <header class="add-member-manual-topbar">
    <div class="add-member-manual-topbar-heading">
      <h1>Dashboard</h1>
      <p>Dashboard Control System</p>
    </div>
    <div class="add-member-manual-topbar-actions">
      <button class="add-member-manual-icon-btn" title="Notifications" aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 10a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
      </button>
      <button class="add-member-manual-icon-btn" title="Messages" aria-label="Messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
      </button>
      <button class="add-member-manual-icon-btn" title="Sign out" aria-label="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>
      </button>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="add-member-manual-main">
    <p class="add-member-manual-breadcrumb">
      <a role="button" tabindex="0" onclick="main_dashboard_01_A_OPEN()">Dashboard</a> /
      <a role="button" tabindex="0" onclick="main_dashboard_01_A_OPEN()">Member List</a> /
      <a role="button" tabindex="0" onclick="main_dashboard_01_B_OPEN()">Add New</a> /
      <a role="button" tabindex="0" onclick="main_dashboard_01_F_OPEN()">Select Street</a> /
      <span>Manual Entry</span>
    </p>

    <section class="add-member-manual-panel" aria-label="Add new member manually">

      <div class="add-member-manual-panel-header">
        <div class="add-member-manual-panel-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.4"/><path d="M2.5 20c1-4 3.4-6 6.5-6s5.5 2 6.5 6"/><path d="M18 5v8M14 9h8"/></svg>
          Process New Member.
        </div>
        <a class="add-member-manual-panel-close" onclick="main_dashboard_01_F_OPEN()" title="Close" aria-label="Close">✕</a>
      </div>

      <form class="add-member-manual-form" id="add-member-manual-form" onsubmit="process_new_member_SUBMIT(event)" novalidate>
        <input type="hidden" id="selected_member_road" name="selected_member_road">
        <input type="hidden" id="add_member_manual_road_id" name="add_member_manual_road_id">
        <input type="hidden" id="Member_body_01_C_4_from_01_ID" value="0">

        <div class="add-member-manual-grid">

          <div class="add-member-manual-field add-member-manual-span-2" id="add-member-manual-field-name">
            <label for="add-member-manual-name">Name<span class="add-member-manual-required">*</span></label>
            <input type="text" id="add-member-manual-name" name="name" placeholder="John Smith" required>
            <span class="add-member-manual-error">Please enter the member's full name.</span>
          </div>

          <div class="add-member-manual-field add-member-manual-span-2" id="add-member-manual-field-address">
            <label for="add-member-manual-address">Residence Address<span class="add-member-manual-required">*</span></label>
            <input type="text" id="add-member-manual-address" name="address" placeholder="123 Main Street, Springfield, USA" required>
            <span class="add-member-manual-error">Please enter the residence address.</span>
          </div>

          <div class="add-member-manual-field add-member-manual-span-2">
            <label>What is your current residing status</label>
            <div class="add-member-manual-checkbox-row">
              <label class="add-member-manual-checkbox">
                <input type="checkbox" id="add-member-manual-own-house" name="residingStatus" value="own">
                Own House
              </label>
              <label class="add-member-manual-checkbox">
                <input type="checkbox" id="add-member-manual-rented-house" name="residingStatus" value="rented">
                Rented House
              </label>
            </div>
          </div>

          <div class="add-member-manual-field add-member-manual-span-2" id="add-member-manual-field-nic">
            <label for="add-member-manual-nic">NIC No<span class="add-member-manual-required">*</span></label>
            <input type="text" id="add-member-manual-nic" name="nic" placeholder="xxxx xxxx xxxx" required>
            <span class="add-member-manual-error">Please enter the NIC number.</span>
          </div>

          <div class="add-member-manual-subsection">
            <h3 class="add-member-manual-subsection-title">Notification data and contact details</h3>

            <div class="add-member-manual-field add-member-manual-span-2">
              <label for="add-member-manual-email">Email</label>
              <input type="email" id="add-member-manual-email" name="email" placeholder="example@gmail.com">
            </div>

            <div class="add-member-manual-field-with-check add-member-manual-span-2" style="grid-column:1 / -1;">
              <div class="add-member-manual-field" id="add-member-manual-field-mobile">
                <label for="add-member-manual-mobile">Mobile (Local Notification)<span class="add-member-manual-required">*</span></label>
                <input type="tel" id="add-member-manual-mobile" name="mobile" placeholder="07x xxx xxxx" required>
                <span class="add-member-manual-error">Please enter a mobile number.</span>
              </div>
              <label class="add-member-manual-checkbox">
                <input type="checkbox" id="add-member-manual-whatsapp-same" name="whatsapp_same" checked>
                WhatsApp on this number?
              </label>
            </div>

            <div class="add-member-manual-field add-member-manual-span-2" id="add-member-manual-field-whatsapp-num">
              <label for="add-member-manual-whatsapp-num">Whats App Number<span class="add-member-manual-required">*</span></label>
              <input type="tel" id="add-member-manual-whatsapp-num" name="whatsappNumber" placeholder="07x xxx xxxx" required>
              <span class="add-member-manual-error">Please enter a WhatsApp number.</span>
            </div>

            <div class="add-member-manual-field add-member-manual-span-2" id="add-member-manual-field-secondary">
              <label for="add-member-manual-secondary">Secondary Number<span class="add-member-manual-required">*</span></label>
              <input type="tel" id="add-member-manual-secondary" name="secondaryNumber" placeholder="07x xxx xxxx" required>
              <span class="add-member-manual-error">Please enter a secondary contact number.</span>
            </div>
          </div>

          <div class="add-member-manual-field add-member-manual-span-2">
            <label for="add-member-manual-profession">Profession</label>
            <input type="text" id="add-member-manual-profession" name="profession" placeholder="Your Profession Hear">
          </div>

          <div class="add-member-manual-field add-member-manual-span-2">
            <label for="add-member-manual-subscription-amount">Monthly Subscription Amount ( Minimum 500LKR)</label>
            <input type="number" id="add-member-manual-subscription-amount" name="subscriptionAmount" min="500" step="0.01" placeholder="0000.00">
          </div>

          <div class="add-member-manual-field add-member-manual-span-2">
            <label for="add-member-manual-opening-balance">Opening Balance</label>
            <input type="number" id="add-member-manual-opening-balance" name="openingBalance" min="0" step="0.01" placeholder="0000.00">
          </div>

          <?php for ($cp_idx = 1; $cp_idx <= $needed_contact_person_count; $cp_idx++): ?>
          <div class="add-member-manual-subsection contact-person-subsection" data-index="<?php echo $cp_idx; ?>">
            <h3 class="add-member-manual-subsection-title">Recommended Person <?php echo str_pad($cp_idx, 2, '0', STR_PAD_LEFT); ?> Details</h3>

            <div class="add-member-manual-field add-member-manual-span-2">
              <label for="add-member-manual-ref<?php echo $cp_idx; ?>-name">Name</label>
              <input type="text" id="add-member-manual-ref<?php echo $cp_idx; ?>-name" class="contact-person-name" name="ref<?php echo $cp_idx; ?>Name" placeholder="John Smith">
            </div>

            <div class="add-member-manual-field" id="add-member-manual-field-ref<?php echo $cp_idx; ?>-membership">
              <label for="add-member-manual-ref<?php echo $cp_idx; ?>-membership">Membership no<span class="add-member-manual-required">*</span></label>
              <input type="text" id="add-member-manual-ref<?php echo $cp_idx; ?>-membership" class="contact-person-membership" name="ref<?php echo $cp_idx; ?>Membership" placeholder="00<?php echo $cp_idx; ?>xxxx" required>
              <span class="add-member-manual-error">Please enter membership no.</span>
            </div>

            <div class="add-member-manual-field" id="add-member-manual-field-ref<?php echo $cp_idx; ?>-contact">
              <label for="add-member-manual-ref<?php echo $cp_idx; ?>-contact">Contact no<span class="add-member-manual-required">*</span></label>
              <input type="tel" id="add-member-manual-ref<?php echo $cp_idx; ?>-contact" class="contact-person-contact" name="ref<?php echo $cp_idx; ?>Contact" placeholder="07x xxx xxxx" required>
              <span class="add-member-manual-error">Please enter a contact no.</span>
            </div>
          </div>
          <?php endfor; ?>

          <div class="add-member-manual-checkbox-row">
            <label class="add-member-manual-checkbox">
              <input type="checkbox" id="add-member-manual-subscription-flag" name="subscription" checked>
              Subscription
            </label>
            <label class="add-member-manual-checkbox">
              <input type="checkbox" id="add-member-manual-zakath-payee" name="zakathPayee">
              Zakath Payee
            </label>
            <label class="add-member-manual-checkbox">
              <input type="checkbox" id="add-member-manual-zakath-receive" name="zakathReceive" checked>
              Zakath receive
            </label>
          </div>

        </div>

        <div class="add-member-manual-divider"></div>

        <div class="add-member-manual-actions">
          <button type="button" class="add-member-manual-btn add-member-manual-btn-ghost" onclick="main_dashboard_01_F_OPEN()">Cancel</button>
          <button type="submit" class="add-member-manual-btn add-member-manual-btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="m5 12.5 5 5L20 7"/></svg>
            Process
          </button>
        </div>
      </form>

    </section>

    <p style="text-align:center;font-size:11px;color:var(--add-member-manual-ink-400);padding-top:22px;">© 2026 Sky Cargo Express Logistics | Neo Solution</p>
  </main>

</div>

<div class="add-member-manual-toast" id="add-member-manual-toast">Member saved successfully.</div>

</div>
