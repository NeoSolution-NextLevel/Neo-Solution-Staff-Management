<script type="text/javascript">
function previewDepositImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var previewImg = document.getElementById("deposit-image-preview-img");
            var previewText = document.getElementById("deposit-image-preview-text");
            var previewIcon = document.getElementById("deposit-image-preview-icon");
            var hiddenPath = document.getElementById("deposit-image-path-hidden");

            if (previewImg) {
                previewImg.src = e.target.result;
                previewImg.style.display = "block";
            }
            if (previewText) previewText.style.display = "none";
            if (previewIcon) previewIcon.style.display = "none";
            if (hiddenPath) hiddenPath.value = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function submitBankDeposit() {
    var amountEl = document.getElementById("deposit-amount") || document.getElementById("DashBord_Payment_body_01_B_05_01_from_01_val_1");
    var descEl = document.getElementById("deposit-description") || document.getElementById("DashBord_Payment_body_01_B_05_01_from_01_val_2");

    var amountVal = amountEl ? amountEl.value.trim() : "";
    var descVal = descEl ? descEl.value.trim() : "";

    if (!amountVal || isNaN(parseFloat(amountVal)) || parseFloat(amountVal) <= 0) {
        alert("Please enter a valid paid amount.");
        if (amountEl) amountEl.focus();
        return;
    }

    var membershipNoEl = document.getElementById("DashBord_Payment_body_member_list_membership_no");
    var imagePathEl = document.getElementById("deposit-image-path-hidden") || document.getElementById("DashBord_Payment_body_01_B_05_01_from_id_image_pth_txt");
    var bankNameEl = document.getElementById("DashBord_Payment_body_01_B_05_bank_name");
    var branchEl = document.getElementById("DashBord_Payment_body_01_B_05_branch_name");
    var acNoEl = document.getElementById("DashBord_Payment_body_01_B_05_ac_no");
    var bankAccIdEl = document.getElementById("DashBord_Payment_body_01_B_05_bank_account_details_id");
    var memberListIdEl = document.getElementById("DashBord_Payment_body_member_list_id");
    var nonMemberStateEl = document.getElementById("DashBord_Payment_body_01_B_08_02_non_member_state");
    var payingTypeEl = document.getElementById("DashBord_Payment_body_paying_type_default");

    var membership_no = membershipNoEl ? membershipNoEl.value : "";
    var image_pth = imagePathEl ? imagePathEl.value : "";
    var bank_name = bankNameEl ? bankNameEl.value : "";
    var branch = branchEl ? branchEl.value : "";
    var ac_no = acNoEl ? acNoEl.value : "";
    var bank_account_details_id = bankAccIdEl ? bankAccIdEl.value : "";
    if (!bank_account_details_id) {
        alert("Please select a deposit bank account first.");
        if (typeof main_dashboard_02_F_OPEN === "function") {
            main_dashboard_02_F_OPEN();
        }
        return;
    }
    var member_list_id = memberListIdEl ? memberListIdEl.value : "";
    var non_member_state = (nonMemberStateEl && nonMemberStateEl.value == "1") ? "1" : "0";

    if (non_member_state !== "1" && !member_list_id) {
        alert("Please select a member first.");
        if (typeof main_dashboard_02_C_OPEN === "function") {
            main_dashboard_02_C_OPEN();
        }
        return;
    }

    var person_name = "";
    var address = "";
    var member_email = "";
    var member_mobile_no = "";

    if (non_member_state === "1") {
        var pNameEl = document.getElementById("DashBord_Payment_body_01_B_08_02_person_name");
        var addrEl = document.getElementById("DashBord_Payment_body_01_B_08_02_address");
        var emailEl = document.getElementById("DashBord_Payment_body_01_B_08_02_non_mem_email");
        var phoneEl = document.getElementById("DashBord_Payment_body_01_B_08_02_non_mem_phone_no");

        person_name = pNameEl ? pNameEl.value : "";
        address = addrEl ? addrEl.value : "";
        member_email = emailEl ? emailEl.value : "";
        member_mobile_no = phoneEl ? phoneEl.value : "";
    } else {
        var mNameEl = document.getElementById("DashBord_Payment_body_member_list_name");
        var mAddrEl = document.getElementById("DashBord_Payment_body_member_list_address");
        var mEmailEl = document.getElementById("DashBord_Payment_body_member_list_email");
        var mPhoneEl = document.getElementById("DashBord_Payment_body_member_list_phone_number");

        person_name = mNameEl ? mNameEl.value : "";
        address = mAddrEl ? mAddrEl.value : "";
        member_email = mEmailEl ? mEmailEl.value : "";
        member_mobile_no = mPhoneEl ? mPhoneEl.value : "";
    }

    var postData = "val_01=" + encodeURIComponent(amountVal) +
        "&val_02=" + encodeURIComponent(descVal) +
        "&val_03=" + encodeURIComponent(person_name) +
        "&val_04=" + encodeURIComponent(address) +
        "&val_05=" + encodeURIComponent(membership_no) +
        "&val_06=" + encodeURIComponent(image_pth) +
        "&val_07=" + encodeURIComponent(bank_name) +
        "&val_08=" + encodeURIComponent(branch) +
        "&val_09=" + encodeURIComponent(ac_no) +
        "&val_10=" + encodeURIComponent(bank_account_details_id) +
        "&val_11=" + encodeURIComponent(member_list_id) +
        "&member_email=" + encodeURIComponent(member_email) +
        "&member_mobile_no=" + encodeURIComponent(member_mobile_no) +
        "&wwjm_payment_sliip_id_bank_deposite=0";

    var pType = payingTypeEl ? payingTypeEl.value : "";
    if (pType === "subcription" || pType === "subscription") {
        postData += "&pay_resion_subcption=0";
    } else if (pType === "Donation" || pType === "donation") {
        postData += "&pay_resion_donation=0";
    } else if (pType === "Zakath" || pType === "zakath") {
        postData += "&pay_resion_zakath=0";
    }

    if (non_member_state !== "1") {
        postData += "&is_member=0";
    }

    $.ajax({
        url: "<?php echo $pth; ?>View-List/Payment/Create_member_bank_deposit.php",
        type: "POST",
        data: postData,
        success: function(res) {
            try {
                var json = JSON.parse(res);
                if (json[0] && json[0].error === "0") {
                    alert("Bank deposit payment submitted successfully!");
                    if (amountEl) amountEl.value = "";
                    if (descEl) descEl.value = "";
                    if (typeof main_dashboard_02_A_OPEN === "function") {
                        main_dashboard_02_A_OPEN();
                    } else if (typeof DashBord_Payment_body_01_B_01_OPEN === "function") {
                        DashBord_Payment_body_01_B_01_OPEN();
                    }
                } else {
                    alert("Failed to submit bank deposit: " + (json[0] ? json[0].error : "Unknown error"));
                }
            } catch (e) {
                console.error("Response parsing error:", e, res);
                alert("Bank deposit payment processed.");
                if (typeof main_dashboard_02_A_OPEN === "function") {
                    main_dashboard_02_A_OPEN();
                }
            }
        },
        error: function(xhr, status, error) {
            alert("AJAX error submitting deposit: " + error);
        }
    });
}

function DashBord_Payment_body_01_B_05_01_from_01_SUMBIT(event) {
    if (event) event.preventDefault();
    submitBankDeposit();
}
</script>