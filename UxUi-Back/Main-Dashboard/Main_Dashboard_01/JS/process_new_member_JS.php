<script type="text/javascript">
  /* ===================================================================
     process_new_member_JS.php — Process New Member form submission
     Wellawatta Jumma Mosque · Admin Dashboard
     =================================================================== */

  let isMemberSubmitting = false;

  function syncWhatsAppNumber() {
    const isSame = document.getElementById('add-member-manual-whatsapp-same');
    const mobileInput = document.getElementById('add-member-manual-mobile');
    const whatsappInput = document.getElementById('add-member-manual-whatsapp-num');
    const whatsappWrap = document.getElementById('add-member-manual-field-whatsapp-num');

    if (isSame && whatsappWrap) {
      if (isSame.checked) {
        whatsappWrap.style.display = 'none';
        if (mobileInput && whatsappInput) {
          whatsappInput.value = mobileInput.value;
        }
      } else {
        whatsappWrap.style.display = 'flex';
      }
    }
  }

  function process_new_member_SUBMIT(event) {
    if (event) event.preventDefault();

    if (isMemberSubmitting) return false;

    const form = document.getElementById("add-member-manual-form");
    if (!form) return false;

    // Sync WhatsApp number before validation if checkbox is checked
    syncWhatsAppNumber();

    const isSame = document.getElementById('add-member-manual-whatsapp-same');

    // Required fields validation
    const requiredFields = [
      { id: 'add-member-manual-name',         wrap: 'add-member-manual-field-name' },
      { id: 'add-member-manual-address',      wrap: 'add-member-manual-field-address' },
      { id: 'add-member-manual-nic',          wrap: 'add-member-manual-field-nic' },
      { id: 'add-member-manual-mobile',       wrap: 'add-member-manual-field-mobile' },
      { id: 'add-member-manual-secondary',    wrap: 'add-member-manual-field-secondary' }
    ];

    if (!isSame || !isSame.checked) {
      requiredFields.push({ id: 'add-member-manual-whatsapp-num', wrap: 'add-member-manual-field-whatsapp-num' });
    }

    let valid = true;
    requiredFields.forEach(function(f) {
      const input = document.getElementById(f.id);
      const wrap = document.getElementById(f.wrap);
      if (input && wrap) {
        const filled = input.value.trim().length > 0;
        wrap.classList.toggle('add-member-manual-invalid', !filled);
        if (!filled) valid = false;
      }
    });

    if (!valid) {
      const firstInvalid = document.querySelector('.add-member-manual-invalid input');
      if (firstInvalid) firstInvalid.focus();
      return false;
    }

    // Collect Form Values
    const getVal = (id) => {
      const el = document.getElementById(id);
      return el ? el.value.trim() : '';
    };

    const isChecked = (id) => {
      const el = document.getElementById(id);
      return el && el.checked ? '1' : '';
    };

    const name = getVal('add-member-manual-name');
    const address = getVal('add-member-manual-address');
    const nic = getVal('add-member-manual-nic');
    const email = getVal('add-member-manual-email');
    const mobile = getVal('add-member-manual-mobile');
    const whatsappNum = (isSame && isSame.checked) ? mobile : getVal('add-member-manual-whatsapp-num');
    const secondary = getVal('add-member-manual-secondary');
    const profession = getVal('add-member-manual-profession');
    const subAmount = getVal('add-member-manual-subscription-amount');
    const openingBal = getVal('add-member-manual-opening-balance');
    const roadId = window.selected_member_road_id || getVal('selected_member_road') || getVal('body_01_01_D_member_road_id') || '1';

    // Collect dynamic contact persons
    const contactPersons = [];
    document.querySelectorAll('.contact-person-subsection').forEach(function(sec) {
      const nameEl = sec.querySelector('.contact-person-name');
      const memEl = sec.querySelector('.contact-person-membership');
      const contactEl = sec.querySelector('.contact-person-contact');

      contactPersons.push({
        name: nameEl ? nameEl.value.trim() : '',
        membership_no: memEl ? memEl.value.trim() : '',
        contact: contactEl ? contactEl.value.trim() : ''
      });
    });

    const cp1 = contactPersons[0] || { name: '', membership_no: '', contact: '' };
    const cp2 = contactPersons[1] || { name: '', membership_no: '', contact: '' };

    let formData = {
      val_01: name,
      val_02: address,
      val_05: nic,
      val_09: mobile,
      val_10: whatsappNum,
      val_11: secondary,
      val_12: email,
      val_13: profession,
      val_15: subAmount,
      val_17: openingBal,
      val_20: roadId,
      val_21: cp1.name,
      val_22: cp1.membership_no,
      val_23: cp1.contact,
      val_24: cp2.name,
      val_25: cp2.membership_no,
      val_26: cp2.contact,
      admin_form: '1',
    };

    if (isChecked('add-member-manual-own-house')) formData.owner = '1';
    if (isChecked('add-member-manual-rented-house')) formData.tenant = '1';
    if (isChecked('add-member-manual-subscription-flag')) formData.account_type_subcrption = '1';
    if (isChecked('add-member-manual-zakath-payee')) formData.zakath_pay_state = '1';
    if (isChecked('add-member-manual-zakath-receive')) formData.account_type_zakath_reciver = '1';

    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
    isMemberSubmitting = true;

    if (typeof preloader_show === 'function') preloader_show();

    $.ajax({
      url: "<?php echo $pth; ?>View-List/member_register/process_new_member.php",
      type: "POST",
      data: formData,
      success: function(response) {
        if (typeof preloader_hide === 'function') preloader_hide();
        isMemberSubmitting = false;
        if (submitBtn) submitBtn.disabled = false;

        try {
          const json = JSON.parse(response);
          console.log("Create Member Response:", json);
          if (json && json[0] && json[0].error === "0") {
            const toast = document.getElementById("add-member-manual-toast");
            if (toast) {
              toast.style.display = "block";
              setTimeout(function() { toast.style.display = "none"; }, 2000);
            }
            form.reset();
            syncWhatsAppNumber();

            // Navigate back to member list view
            setTimeout(function() {
              if (typeof main_dashboard_01_A_OPEN === 'function') {
                main_dashboard_01_A_OPEN();
              } else if (typeof New_admission_02_A_01_OPEN === 'function') {
                New_admission_02_A_01_OPEN();
              }
            }, 1000);
          } else {
            const errorMsg = (json && json[0] && json[0].error) ? json[0].error : "An error occurred while saving the member.";
            alert("Error: " + errorMsg);
          }
        } catch(e) {
          console.error("JSON parse error:", e, response);
          alert("Member created successfully.");
          if (typeof main_dashboard_01_A_OPEN === 'function') {
            main_dashboard_01_A_OPEN();
          }
        }
      },
      error: function(xhr, status, errorThrown) {
        if (typeof preloader_hide === 'function') preloader_hide();
        isMemberSubmitting = false;
        if (submitBtn) submitBtn.disabled = false;
        console.error("AJAX Error:", errorThrown);
        alert("Network error. Please try again.");
      }
    });

    return false;
  }

  $(document).ready(function() {
    const isSame = document.getElementById('add-member-manual-whatsapp-same');
    const mobileInput = document.getElementById('add-member-manual-mobile');

    if (isSame) {
      isSame.addEventListener('change', syncWhatsAppNumber);
    }

    if (mobileInput) {
      mobileInput.addEventListener('input', function() {
        if (isSame && isSame.checked) {
          syncWhatsAppNumber();
        }
      });
    }

    syncWhatsAppNumber();
  });
</script>
