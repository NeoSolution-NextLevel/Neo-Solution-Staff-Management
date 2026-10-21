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
            "&val_02=" + encodeURIComponent(val_02.value) +
            "&val_03=" + encodeURIComponent(val_03.value) +
            "&val_04=" + encodeURIComponent(val_04_child_01.value) +
            "&val_05=" + encodeURIComponent(val_05 ? val_05.value : "1") +
            "&val_06=" + encodeURIComponent(val_06.value) +
            "&val_07=" + encodeURIComponent(val_01_child_01.value) +
            "&val_08=" + encodeURIComponent(val_01_child_02.value) +
            "&val_09=" + encodeURIComponent(val_09 ? val_09.value : "Administration");

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/Main_User_Login_Account_Create/New_Main_User_Login_Create.php",
            type: "POST",
            data: Sending_value,
            success: function(res) {
                console.log(res);

                try {
                    var json = JSON.parse(res);

                    if (json[0].error === "0") {
                        var sucessMsg = encodeURIComponent("User-Registration-Successful");
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;


                    } else {

                        if (json[0].error === "Already have this email") {
                            var errorMsg = encodeURIComponent("email-already-exist");
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

    function User_Registration_A_01_main_user_account_access_level_list() {
        var container = document.getElementById("User_Registration_A_01_val_05_select_obj");
        if (!container) return;
        container.innerHTML = "";
        var opt = document.createElement("option");
        opt.value = "1";
        opt.textContent = "Administrator (Portal Admin Access)";
        opt.selected = true;
        container.appendChild(opt);
    }
</script>