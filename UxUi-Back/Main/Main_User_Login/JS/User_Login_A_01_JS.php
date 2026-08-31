<script>
    function User_Login_A_01_from_01_SUMBIT(event) {
        event.preventDefault();


        var val_01 = document.getElementById("User_Login_A_01_val_01"); // user name 
        var val_02 = document.getElementById("User_Login_A_01_val_02"); // Password


        var Sending_value = "val_01=" + encodeURIComponent(val_01.value) +
            "&val_02=" + encodeURIComponent(val_02.value);

        // alert(Sending_value);

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/User_Login_Check.php",
            type: "POST",
            data: Sending_value,
            success: function(res) {
                console.log(res);
                alert(res);

                try {
                    var json = JSON.parse(res);
                    // alert(json[0].error);


                    if (json[0].error === "0") {


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
                        // alert(json[0].error);

                        if (json[0].error === "Username Incorrect") {
                            var errorMsg = encodeURIComponent("Username-Incorrect");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                        } else if (json[0].error === "Password Incorrect") {
                            var errorMsg = encodeURIComponent("Password-Incorrect");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;


                        } else if (json[0].error === "temporary lock") {
                            var errorMsg = encodeURIComponent("Temporary-Lock");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;


                        } else {

                            var errorMsg = encodeURIComponent("Service-Error");
                            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                        }


                    }

                } catch (e) {
                    var errorMsg = encodeURIComponent("Service-Error");
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                }
            }
        });

    }
</script>