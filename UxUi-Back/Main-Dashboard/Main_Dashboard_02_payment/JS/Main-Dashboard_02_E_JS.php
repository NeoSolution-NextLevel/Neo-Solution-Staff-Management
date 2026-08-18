<script type="text/javascript">
  var currentCashPaymentMember = null;

  function loadCashPaymentData() {
      var memberIdEl = document.getElementById("DashBord_Payment_body_member_list_id") || document.getElementById("selected-member-id");
      if (!memberIdEl || !memberIdEl.value) {
          console.error("No member selected!");
          return;
      }
      
      var memberId = memberIdEl.value;
      var sending_value = "search_txt=" + encodeURIComponent(memberId) + "&search_by=id";
      
      $.ajax({
          url: "<?php echo $pth; ?>View-List/Member/view_member_list.php",
          type: 'POST',
          data: sending_value,
          cache: false,
          success: function(data) {
              try {
                  var json = eval(data);
                  if (json && json.length > 0) {
                      var member = json[0];
                      currentCashPaymentMember = member; // Store globally for submission
                      
                      var cashMemberNo = document.getElementById("cash-payment-member-no");
                      if (cashMemberNo) cashMemberNo.innerText = member.membership_no || '';
                      
                      var cashMemberName = document.getElementById("cash-payment-member-name");
                      if (cashMemberName) cashMemberName.innerText = member.name_M || '';
                      
                      var cashDueAmount = document.getElementById("cash-payment-due-amount");
                      if (cashDueAmount) cashDueAmount.innerText = member.due_to_pay || '0.00';
                      
                      // Update global hidden fields if they exist
                      var hiddenNo = document.getElementById("selected-payment-member-no");
                      if(hiddenNo) hiddenNo.value = member.membership_no || '';
                      var hiddenName = document.getElementById("selected-payment-member-name");
                      if(hiddenName) hiddenName.value = member.name_M || '';
                      var hiddenAmount = document.getElementById("selected-payment-due-amount");
                      if(hiddenAmount) hiddenAmount.value = member.due_to_pay || '';
                  }
              } catch(e) {
                  console.error("Error parsing member data: ", e);
              }
          }
      });
  }

  function openCashPayment() {
      // Fetch the data first before opening the interface
      loadCashPaymentData();
      if (typeof main_dashboard_02_E_OPEN === "function") {
          main_dashboard_02_E_OPEN();
      } else {
          // Fallback if not inside the SPA dashboard wrapper
          window.location.href = 'Main-Dashboard_02_E_cash_payment.php';
      }
  }

  function processCashPayment() {
    console.log("Processing cash payment...");
    
    if (!currentCashPaymentMember) {
        var memberIdEl = document.getElementById("DashBord_Payment_body_member_list_id") || document.getElementById("selected-member-id");
        var mNo = document.getElementById("cash-payment-member-no") ? document.getElementById("cash-payment-member-no").innerText.trim() : "";
        var mName = document.getElementById("cash-payment-member-name") ? document.getElementById("cash-payment-member-name").innerText.trim() : "";
        var mAddress = document.getElementById("DashBord_Payment_body_member_list_address") ? document.getElementById("DashBord_Payment_body_member_list_address").value : "";
        var mEmail = document.getElementById("DashBord_Payment_body_member_list_email") ? document.getElementById("DashBord_Payment_body_member_list_email").value : "";
        var mPhone = document.getElementById("DashBord_Payment_body_member_list_phone_number") ? document.getElementById("DashBord_Payment_body_member_list_phone_number").value : "";
        var mDue = document.getElementById("cash-payment-due-amount") ? document.getElementById("cash-payment-due-amount").innerText.trim() : "";

        if (memberIdEl && memberIdEl.value) {
            currentCashPaymentMember = {
                id: memberIdEl.value,
                membership_no: mNo,
                name_M: mName,
                residence_address_M: mAddress,
                email: mEmail,
                phone_mobile: mPhone,
                due_to_pay: mDue
            };
        }
    }

    if (!currentCashPaymentMember) {
        alert("Error: Member data not loaded.");
        return;
    }
    
    var payingAmount = document.getElementById('cash-paying-amount').value;
    if (!payingAmount || isNaN(payingAmount) || payingAmount <= 0) {
        alert("Please enter a valid paying amount.");
        return;
    }
    
    var sendSms = document.getElementById('cash-slip-sms').checked;
    var sendEmail = document.getElementById('cash-slip-email').checked;
    var printSlip = document.getElementById('cash-slip-print').checked;
    
    var sending_value = "val_01=" + encodeURIComponent(payingAmount) +
                        "&val_02=0" +
                        "&val_03=" + encodeURIComponent(currentCashPaymentMember.name_M || "") +
                        "&val_04=" + encodeURIComponent(currentCashPaymentMember.residence_address_M || "") +
                        "&val_05=" + encodeURIComponent(currentCashPaymentMember.membership_no || "") +
                        "&member_email=" + encodeURIComponent(currentCashPaymentMember.email || "") +
                        "&member_mobile_no=" + encodeURIComponent(currentCashPaymentMember.phone_mobile || "") +
                        "&wwjm_member_list_id=" + encodeURIComponent(currentCashPaymentMember.id) +
                        "&is_cash=1" +
                        "&is_member=1" +
                        "&pay_resion_subcption=1"; 
                        
    // Display loading state
    var btn = document.querySelector('.payment-cash-btn-process');
    var originalText = btn.innerText;
    btn.innerText = "Processing...";
    btn.disabled = true;
    
    $.ajax({
        url: "<?php echo $pth; ?>View-List/Payment/create_wwjm_payment_slip.php",
        type: 'POST',
        data: sending_value,
        cache: false,
        success: function(data) {
            btn.innerText = originalText;
            btn.disabled = false;
            
            try {
                var json = eval(data);
                if (json && json[0] && json[0].error === "0") {
                    alert("Payment submitted successfully! Receipt ID: " + json[0].id);
                    document.getElementById('cash-paying-amount').value = "";
                    
                    // You could add logic here to trigger SMS/Email or open print view based on checkboxes
                    if (typeof main_dashboard_02_C_OPEN === "function") {
                        // Return to member list on success
                        main_dashboard_02_C_OPEN();
                    }
                } else {
                    alert("Failed to submit payment: " + (json[0].error || "Unknown error"));
                }
            } catch(e) {
                console.error("Payment submission error:", e, data);
                alert("An error occurred while submitting the payment.");
            }
        },
        error: function() {
            btn.innerText = originalText;
            btn.disabled = false;
            alert("Network error occurred. Please try again.");
        }
    });
  }
</script>
