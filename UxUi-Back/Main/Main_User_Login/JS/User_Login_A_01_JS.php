<script>
    function User_Login_A_01_from_01_SUMBIT(event) {
        event.preventDefault();


        var val_01 = document.getElementById("User_Login_A_01_val_01"); // user name 
        var val_02 = document.getElementById("User_Login_A_01_val_02"); // Password


        var Sending_value = "val_01=" + encodeURIComponent(val_01.value) +
            "&val_02=" + encodeURIComponent(val_02.value);

        // alert(Sending_value);

        $.ajax({
            url: "<?php echo $home_page; ?>View-List/Main/User_Login_Check.php",
            type: "POST",
            data: Sending_value,
            success: function(res) {
                console.log("Login check response:", res);

                try {
                    var json = (typeof res === "object") ? res : JSON.parse(typeof res === "string" ? res.trim() : res);

                    if (json[0].error === "0") {

                        if (json[0].otp_verification_required === "1") {
                            window.location.href = "<?php echo $home_page ?>UxUi/Main/Employee-Verify-OTP.php?email=" + encodeURIComponent(json[0].email || val_01.value || "");
                            return;
                        }

                        if (json[0].google_authentication === "1") {
                            var type = encodeURIComponent("Google-Authentication");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>OTP-Two-step-Verification<?php echo $online_offline_extention ?>?type=" + type;

                        } else if (json[0].is_two_factor_auth_enable === "1") {
                            var type = encodeURIComponent("Two-Factor-Authentication");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>OTP-Two-step-Verification<?php echo $online_offline_extention ?>?type=" + type;

                        } else {
                            var sucessMsg = encodeURIComponent("User-Login-Successful");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;
                        }

                    } else {

                        if (json[0].error === "OTP-Verification-Pending") {
                            window.location.href = "<?php echo $home_page ?>UxUi/Main/Employee-Verify-OTP.php?email=" + encodeURIComponent(val_01.value || "");

                        } else if (json[0].error === "Admin-Pending-Approval") {
                            var errorMsg = encodeURIComponent("Admin-Pending-Approval");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Admin-Account-Blocked") {
                            var errorMsg = encodeURIComponent("Admin-Account-Blocked");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Application-Pending-Approval") {
                            var errorMsg = encodeURIComponent("Application-Pending-Approval");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Application-Declined") {
                            var errorMsg = encodeURIComponent("Application-Declined");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Username Incorrect") {
                            var errorMsg = encodeURIComponent("Username-Incorrect");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Password Incorrect") {
                            var errorMsg = encodeURIComponent("Password-Incorrect");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "temporary lock") {
                            var errorMsg = encodeURIComponent("Temporary-Lock");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Admin Access Only") {
                            var errorMsg = encodeURIComponent("Admin-Access-Only");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else {
                            var rawErr = json[0].error || "Login-Failed";
                            var errorMsg = encodeURIComponent(String(rawErr).replace(/\s+/g, '-'));
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                        }

                    }

                } catch (e) {
                    console.error("Login parsing error:", e, res);
                    var errorMsg = encodeURIComponent("Service-Error");
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                }
            },
            error: function(xhr, status, error) {
                console.error("Login request failed:", status, error);
                var errorMsg = encodeURIComponent("Service-Error");
                window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
            }
        });

    }
</script>