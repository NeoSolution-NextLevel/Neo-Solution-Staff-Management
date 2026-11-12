<script>
    function User_Registration_A_01_from_01_SUMBIT(event) {
        event.preventDefault();

        // alert("1");
        var val_01_child_01 = document.getElementById("User_Registration_A_01_val_01_child_01"); //first name 
        var val_01_child_02 = document.getElementById("User_Registration_A_01_val_01_child_02"); //last name 
        var val_02 = document.getElementById("User_Registration_A_01_val_02"); // Email - User name 
        var val_03 = document.getElementById("User_Registration_A_01_val_03"); // Employee id 
        var val_04_child_01 = document.getElementById("User_Registration_A_01_val_04_child_01"); // Password
        var val_04_child_02 = document.getElementById("User_Registration_A_01_val_04_child_02"); // confirm password 

        var val_05 = document.getElementById("User_Registration_A_01_val_05_select_obj"); // Role
        var val_06 = document.getElementById("User_Registration_A_01_val_06"); // Job Title
        var val_09 = document.getElementById("User_Registration_A_01_val_09"); // Department

        var agree_check_box = document.getElementById("User_Registration_A_01_val_07"); // Agree checkbox 

        // agree button checked
        if (agree_check_box.checked === false) {
            alert("Please agree to the Terms of Service and Privacy Policy.");
            agree_check_box.focus();
            return;
        }

        // check password and confirm password 
        if (val_04_child_01.value !== val_04_child_02.value) {
            alert("Passwords do not match. Please ensure both passwords are the same.");
            val_04_child_02.focus();
            return;
        }

        // combine first and last name 
        var val_01 = val_01_child_01.value + " " + val_01_child_02.value;

        var Sending_value = "val_01=" + encodeURIComponent(val_01) +
            "&val_02=" + encodeURIComponent(val_02 ? val_02.value : "") +
            "&val_03=" + encodeURIComponent(val_03 ? val_03.value : "") +
            "&val_04=" + encodeURIComponent(val_04_child_01 ? val_04_child_01.value : "") +
            "&val_05=" + encodeURIComponent(val_05 ? val_05.value : "1") +
            "&val_06=" + encodeURIComponent(val_06 ? val_06.value : "Administrator") +
            "&val_07=" + encodeURIComponent(val_01_child_01 ? val_01_child_01.value : "") +
            "&val_08=" + encodeURIComponent(val_01_child_02 ? val_01_child_02.value : "") +
            "&val_09=" + encodeURIComponent(val_09 ? val_09.value : "Administration");

        $.ajax({
            url: "<?php echo $home_page; ?>View-List/Main/Main_User_Login_Account_Create/New_Main_User_Login_Create.php",
            type: "POST",
            data: Sending_value,
            success: function(res) {
                console.log("Registration response:", res);

                try {
                    var json = (typeof res === "object") ? res : JSON.parse(typeof res === "string" ? res.trim() : res);

                    if (json[0].error === "0") {
                        var sucessMsg = (json[0].status === "pending_approval") 
                            ? encodeURIComponent("Admin-Registration-Pending-Approval")
                            : encodeURIComponent("User-Registration-Successful");
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;
                    } else {

                        if (json[0].error === "Already have this email") {
                            var errorMsg = encodeURIComponent("email-already-exist");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Missing required fields") {
                            alert("Please fill in all required fields (Name, Corporate Email, Password).");
                        } else {
                            var rawErr = json[0].error || "Registration-Error";
                            var errorMsg = encodeURIComponent(String(rawErr).replace(/\s+/g, '-'));
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                        }

                    }

                } catch (e) {
                    console.error("Registration JSON parse error:", e, res);
                    var errorMsg = encodeURIComponent("Service-Error");
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                }
            },
            error: function(xhr, status, error) {
                console.error("Registration request failed:", status, error);
                var errorMsg = encodeURIComponent("Service-Error");
                window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
            }
        });

    }

    function User_Registration_A_01_main_user_account_access_level_list() {
        var container = document.getElementById("User_Registration_A_01_val_05_select_obj");
        if (!container) return;
        if (container.options.length === 0) {
            container.add(new Option("Administrator", "Admin"));
        }
    }
</script>