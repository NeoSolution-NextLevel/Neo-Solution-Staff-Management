<script type="text/javascript">
    function User_Profile_Page_icone_header_function() {
        var check_user_profile_page = document.getElementById("check_user_profile_page_val_01");

        check_user_profile_page.value = 1;


        var profileIcon = document.getElementById("main_profile_page_user_profile_icon");
        var checkUserProfilePage = document.getElementById("check_user_profile_page_val_01");

        if (checkUserProfilePage && checkUserProfilePage.value === "1") {
            profileIcon.style.display = "none";
        } else {
            profileIcon.style.display = "block";
        }


    }

    function User_Profile_A_01_single_main_user_login_SET_DB() {

       

        var sending_value = "session_user_id=0&user_access_level_dedtails=0&main_user_login_device_login_details=0";


        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/main_user_login_SINGLE_DATA/user_profile_details_single_data.php",
            type: "POST",
            data: sending_value,
            success: function(response) {

                // console.log("User details  Response:", response);
                // alert(response);

                var json_data = JSON.parse(response);

                if (json_data.length === 0) {
                    // not found
                } else if (json_data[0].error == "0") {

                    console.log(json_data[0]);
                    // alert(json_data[0].device_count);
                    User_Profile_A_01_single_main_user_login_SHOW_DB(json_data[0]);


                } else if (json_data[0].error == "user id not found") {
                    var errorMsg = encodeURIComponent("Re-Login-Required");
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to load job tags:", error);
            }
        });
    }



    function User_Profile_A_01_single_main_user_login_SHOW_DB(json) {

        var profileImg = document.getElementById("profile-image");
        var defaultIcon = document.getElementById("profile-default");

        if (json.image_url && json.image_url !== "") {

            profileImg.src = json.image_url;
            profileImg.style.display = "block";
            defaultIcon.style.display = "none";

        } else {

            profileImg.style.display = "none";
            defaultIcon.style.display = "flex";
        }


        var User_Profile_A_01_val_02_obj = document.getElementById("User_Profile_A_01_val_02"); // name
        var User_Profile_A_01_val_03_obj = document.getElementById("User_Profile_A_01_val_03"); // Department 
        var User_Profile_A_01_val_04_obj = document.getElementById("User_Profile_A_01_val_04"); // Gmail 
        var User_Profile_A_01_val_05_obj = document.getElementById("User_Profile_A_01_val_05"); // Department 
        var User_Profile_A_01_val_06_obj = document.getElementById("User_Profile_A_01_val_06"); // Employee ID
        var User_Profile_A_01_val_07_obj = document.getElementById("User_Profile_A_01_val_07"); // SDT join
        var User_Profile_A_01_val_08_obj = document.getElementById("User_Profile_A_01_val_08"); // dis
        var profile_image_obj = document.getElementById("profile-image"); // Image url

        var User_Profile_A_01_val_09_obj = document.getElementById("User_Profile_A_01_val_09"); // first name 
        var User_Profile_A_01_val_10_obj = document.getElementById("User_Profile_A_01_val_10"); // last name 
        var User_Profile_A_01_val_11_obj = document.getElementById("User_Profile_A_01_val_11"); // Email 
        var User_Profile_A_01_val_12_obj = document.getElementById("User_Profile_A_01_val_12"); // Phone number  
        var User_Profile_A_01_val_13_obj = document.getElementById("User_Profile_A_01_val_13"); // Department   
        var User_Profile_A_01_val_14_obj = document.getElementById("User_Profile_A_01_val_14"); // Job Role  
        var User_Profile_A_01_val_15_obj = document.getElementById("User_Profile_A_01_val_15"); // diss
        var User_Profile_A_01_val_17_obj = document.getElementById("User_Profile_A_01_val_17"); // Google Authuntication 
        var User_Profile_A_01_val_18_obj = document.getElementById("User_Profile_A_01_val_18"); // two step verification 
        var User_Profile_A_01_val_20_obj = document.getElementById("User_Profile_A_01_val_20"); // user id 
        var two_factor_phone_number_obj = document.getElementById("two-factor-phone-number"); // Two factor phone number
        var User_Profile_A_01_val_21_obj = document.getElementById("User_Profile_A_01_val_21"); // device login count

        $(User_Profile_A_01_val_02_obj).empty();
        $(User_Profile_A_01_val_03_obj).empty();
        $(User_Profile_A_01_val_04_obj).empty();
        $(User_Profile_A_01_val_05_obj).empty();
        $(User_Profile_A_01_val_06_obj).empty();
        $(User_Profile_A_01_val_07_obj).empty();
        $(User_Profile_A_01_val_08_obj).empty();
        $(User_Profile_A_01_val_09_obj).empty();
        $(User_Profile_A_01_val_10_obj).empty();
        $(User_Profile_A_01_val_11_obj).empty();
        $(User_Profile_A_01_val_12_obj).empty();
        $(User_Profile_A_01_val_13_obj).empty();
        $(User_Profile_A_01_val_14_obj).empty();
        $(User_Profile_A_01_val_15_obj).empty();
        $(User_Profile_A_01_val_17_obj).empty();
        $(User_Profile_A_01_val_18_obj).empty();
        $(User_Profile_A_01_val_20_obj).empty();
        $(User_Profile_A_01_val_21_obj).empty();
        $(two_factor_phone_number_obj).empty();
        $(profile_image_obj).empty();

        User_Profile_A_01_val_02_obj.appendChild(document.createTextNode(json.name_show));
        User_Profile_A_01_val_03_obj.appendChild(document.createTextNode(json.type_of_access));
        User_Profile_A_01_val_04_obj.appendChild(document.createTextNode(json.user_name));
        User_Profile_A_01_val_05_obj.appendChild(document.createTextNode(" " + json.type_of_access));
        const employeeId = String(json.id).padStart(6, '0');
        User_Profile_A_01_val_06_obj.appendChild(document.createTextNode(employeeId));
        User_Profile_A_01_val_20_obj.value = json.id;

        User_Profile_A_01_val_21_obj.appendChild(document.createTextNode(json.device_count));



        User_Profile_A_01_val_07_obj.appendChild(document.createTextNode(json.sdt));

        if (json.dis != null) {
            User_Profile_A_01_val_08_obj.appendChild(document.createTextNode(json.dis));

        }


        if (json.first_name != null) {
            User_Profile_A_01_val_09_obj.value = json.first_name;


        } else {
            User_Profile_A_01_val_09_obj.value = "First Name ";

        }


        if (json.last_name != null) {
            User_Profile_A_01_val_10_obj.value = json.last_name;


        } else {
            User_Profile_A_01_val_10_obj.value = "Last Name";


        }
        User_Profile_A_01_val_11_obj.value = json.user_name;

        if (json.last_name != null) {
            User_Profile_A_01_val_12_obj.value = json.phone_number;
            two_factor_phone_number_obj.value = json.phone_number;




        } else {
            User_Profile_A_01_val_12_obj.value = "+94 11 012 2130";

        }
        User_Profile_A_01_val_13_obj.value = json.type_of_access;
        User_Profile_A_01_val_14_obj.value = json.job_role;
        if (json.dis != null) {
            User_Profile_A_01_val_15_obj.value = json.dis;
        } else {
            User_Profile_A_01_val_15_obj.value = "Not Entered Yet";

        }

        if (json.image_url && json.image_url !== "" && json.image_url !== "0") {
            profile_image_obj.src = "<?php echo $home_page; ?>" + json.image_url;
        } else {
            profile_image_obj.src = "<?php echo $home_page; ?>assets/images/default_user_profile.jpg";
        }



        User_Profile_A_01_val_17_obj.value = json.is_google_authentication_enable;
        User_Profile_A_01_val_18_obj.value = json.is_two_factor_auth_enable;
        // alert(User_Profile_A_01_val_17_obj.value);
        updateGoogleAuthUI();
        two_step_veriification_enable_desable_action();


    }

    function Update_main_user_login_profile(event) {
        event.preventDefault();

        var User_Profile_A_01_val_09_obj = document.getElementById("User_Profile_A_01_val_09"); // first name 
        var User_Profile_A_01_val_10_obj = document.getElementById("User_Profile_A_01_val_10"); // last name 
        var User_Profile_A_01_val_11_obj = document.getElementById("User_Profile_A_01_val_11"); // email
        var User_Profile_A_01_val_12_obj = document.getElementById("User_Profile_A_01_val_12"); // phone number 
        var User_Profile_A_01_val_15_obj = document.getElementById("User_Profile_A_01_val_15"); // dis
        var User_Profile_A_01_val_20_obj = document.getElementById("User_Profile_A_01_val_20"); // id
        var User_Profile_A_01_from_id_obj = document.getElementById("User_Profile_A_01_from_id_image_pth_txt"); // img url

        var fullName = User_Profile_A_01_val_09_obj.value + " " + User_Profile_A_01_val_10_obj.value;

        var val_01 = fullName;

        var Sending_value = "val_01=" + encodeURIComponent(val_01) +
            "&val_02=" + encodeURIComponent(User_Profile_A_01_val_11_obj.value) +
            "&val_03=" + encodeURIComponent(User_Profile_A_01_val_09_obj.value) +
            "&val_04=" + encodeURIComponent(User_Profile_A_01_val_10_obj.value) +
            "&val_05=" + encodeURIComponent(User_Profile_A_01_val_12_obj.value) +
            "&val_06=" + encodeURIComponent(User_Profile_A_01_val_15_obj.value) +
            "&id=" + encodeURIComponent(User_Profile_A_01_val_20_obj.value) +
            "&user_profile_page_details_update=0";

        if (User_Profile_A_01_from_id_obj.value != "0") {
            Sending_value += "&image_url=" + encodeURIComponent(User_Profile_A_01_from_id_obj.value);
        }

        // alert(Sending_value);

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/Main_User_Login_Account_Create/Main_User_Login_UPDATE_DATA.php",
            type: "POST",
            data: Sending_value,
            success: function(res) {
                // console.log(res);
                // alert(res);

                try {
                    var json = JSON.parse(res);

                    if (json[0].error === "0") {
                        var sucessMsg = encodeURIComponent(json[0].message);
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;


                    } else {
                        var errorMsg = encodeURIComponent("Service-Error");
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                    }

                } catch (e) {
                    var errorMsg = encodeURIComponent("Service-Error");
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                }
            }
        });
    }


    function Actions_google_authantication() {
        sendGoogleAuthRequest();
        // updateGoogleAuthUI();
    }

    function updateGoogleAuthUI() {
        const statusBadge = document.getElementById('google-auth-status');
        const button = document.getElementById('google-auth-btn');
        const qrSection = document.getElementById('google-auth-qr-section');
        const otpInput = document.getElementById('google-auth-otp');
        var is_google_authentication_enable = document.getElementById("User_Profile_A_01_val_17").value;

        if (is_google_authentication_enable == 1) {
            statusBadge.textContent = 'Connected';
            statusBadge.className = 'erp-status-badge erp-status-badge--enabled';
            button.innerHTML = '<i class="fab fa-google"></i><span>Disable</span>';
        } else {
            statusBadge.textContent = 'Not Connected';
            statusBadge.className = 'erp-status-badge erp-status-badge--disabled';
            button.innerHTML = '<i class="fab fa-google"></i><span>Enable</span>';
            otpInput.value = '';
        }
    }


    function sendGoogleAuthRequest() {
        var img_section = document.getElementById("User_Profile_A_01_val_16");
        var qrSection = document.getElementById('google-auth-qr-section');
        var is_google_authentication_enable = document.getElementById("User_Profile_A_01_val_17").value;
        var email = document.getElementById("User_Profile_A_01_val_11"); // Email 


        var sending_value = "user_email=" + encodeURIComponent(email.value);
        if (is_google_authentication_enable == 1) {
            sending_value += "&is_disable=1";
        } else {
            sending_value += "&is_enable=1";
        }
        // alert(sending_value);


        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/Google-Authenticator/Enable_Authenticator.php",
            type: "POST",
            data: sending_value,
            success: function(response) {
                // console.log(response);
                var json_data = JSON.parse(response);

                if (json_data.status === "success") {

                    if (is_google_authentication_enable == 0) { // user is enabling

                        img_section.src = json_data.qr;
                        qrSection.style.display = 'block';

                        document.getElementById("User_Profile_A_01_val_17").value = 1;

                    } else { // user is disabling

                        qrSection.style.display = 'none';
                        img_section.src = "";

                        document.getElementById("User_Profile_A_01_val_17").value = 0;
                    }

                    updateGoogleAuthUI();
                }
            }


        });
    }



    function veryfy_google_authentication() {
        var email = document.getElementById("User_Profile_A_01_val_11"); // Email 
        var auth_code = document.getElementById("google-auth-otp"); // otp

        var img_section = document.getElementById("User_Profile_A_01_val_16");
        var qrSection = document.getElementById('google-auth-qr-section');
        var is_google_authentication_enable = document.getElementById("User_Profile_A_01_val_17").value;



        var sending_value = "user_email=" + encodeURIComponent(email.value) +
            "&google_authentication_enable=0" +
            "&auth_code=" + encodeURIComponent(auth_code.value);

        // alert(sending_value);


        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/Google-Authenticator/Verify_Authenticator.php",
            type: "POST",
            data: sending_value,
            success: function(response) {
                // console.log(response);

                var json_data = JSON.parse(response);

                if (json_data[0].error === "0") {

                    document.getElementById("User_Profile_A_01_val_17").value = 1;

                    document.getElementById('google-auth-qr-section').style.display = 'none';

                    document.getElementById('google-auth-otp').value = '';

                    updateGoogleAuthUI();

                } else {

                    // alert(json_data[0].error);

                    // keep disabled
                    document.getElementById("User_Profile_A_01_val_17").value = 0;
                    updateGoogleAuthUI();
                }
            }


        });



    }


    function two_step_veriification_enable_desable_action() {

        var statusBadge = document.getElementById('two-factor-auth-status');
        var toggleButton = document.getElementById('two-factor-auth-toggle');
        var twoFactorFields = document.getElementById('two-factor-auth-fields');
        var phoneNumberInput = document.getElementById('two-factor-phone-number');
        var otpInput = document.getElementById('two-factor-otp');
        var two_step_verify_enable = document.getElementById('User_Profile_A_01_val_18').value;

        if (two_step_verify_enable == 1) {
            statusBadge.textContent = 'Enabled';
            statusBadge.className = 'erp-status-badge erp-status-badge--enabled';
            toggleButton.innerHTML = '<i class="fas fa-shield-alt"></i><span>Disable</span>';
            twoFactorFields.style.display = 'none'; // Show the input fields
        } else {
            statusBadge.textContent = 'Disabled';
            statusBadge.className = 'erp-status-badge erp-status-badge--disabled';
            toggleButton.innerHTML = '<i class="fas fa-shield-alt"></i><span>Enable</span>';
            twoFactorFields.style.display = 'none'; // Hide the input fields
            otpInput.value = ''; // Clear input fields
        }

    }


    function send_two_step_verification_sms() {
        var twoFactorFields = document.getElementById('two-factor-auth-fields');
        var statusBadge = document.getElementById('two-factor-auth-status');
        var verify_btn = document.getElementById('two-factor-verify-btn');



        twoFactorFields.style.display = 'block'; // Show the input fields
        statusBadge.style.display = 'none';


        var two_factor_phone_number_obj = document.getElementById("two-factor-phone-number").value;
        var two_step_verify_enable = document.getElementById('User_Profile_A_01_val_18').value;

        var toggleButton = document.getElementById('two-factor-auth-toggle');

        var sending_value = "val_01=" + encodeURIComponent(two_factor_phone_number_obj);

        if (two_step_verify_enable == 1) {
            sending_value += "&want_disable=1";
        } else {
            sending_value += "&want_enable=1";
        }

        sending_value += "&setting_enable_disable_send_otp=1";
        alert(sending_value);

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/Two_Factor_Authentication/Two_Factor_Authentication.php",
            type: "POST",
            data: sending_value,
            success: function(response) {
                // alert(response);

                // console.log(response);

                var json_data = JSON.parse(response);

                if (json_data[0].error === "0") {



                    document.getElementById("User_Profile_A_01_val_19_otp").value = json_data[0].otp;


                } else {
                    // alert(json_data[0].message);
                    var errorMsg = encodeURIComponent(json_data[0].message);
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;

                }
            }
        });
    }



    function send_two_step_verification_check_otp() {
        // alert("test");
        var User_otp = document.getElementById("two-factor-otp").value; // Two factor phone number
        var otp_encrypt = document.getElementById('User_Profile_A_01_val_19_otp').value;
        var two_step_verify_enable = document.getElementById('User_Profile_A_01_val_18').value;
        var user_email = document.getElementById('User_Profile_A_01_val_11').value;
        var statusBadge = document.getElementById('two-factor-auth-status');
        var toggleButton = document.getElementById('two-factor-auth-toggle');
        var twoFactorFields = document.getElementById('two-factor-auth-fields');
        var actionType = "";

        var sending_value = "val_01=" + encodeURIComponent(otp_encrypt) +
            "&val_02=" + encodeURIComponent(User_otp) +
            "&val_03=" + encodeURIComponent(user_email);

        if (two_step_verify_enable == 1) {
            sending_value += "&want_disable=1";
            actionType = "Disable";
        } else {
            sending_value += "&want_enable=1";
            actionType = "Enable";

        }

        sending_value += "&setting_enable_disable_otp_check=0&setting_enable_disable_main_user_login_update=0";

        // alert(sending_value);

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Main/Two_Factor_Authentication/Two_Factor_Authentication.php",
            type: "POST",
            data: sending_value,
            success: function(response) {
                // alert(response);
                User_otp.value = '';
                // console.log(response);

                var json_data = JSON.parse(response);

                if (json_data[0].error === "0") {




                    if (actionType == "Disable") {
                        twoFactorFields.style.display = 'none';
                        statusBadge.style.display = 'block';


                        two_step_verify_enable = 0;
                        statusBadge.textContent = 'Disabled';
                        statusBadge.className = 'erp-status-badge erp-status-badge--disabled';
                        toggleButton.innerHTML = '<i class="fas fa-shield-alt"></i><span>Enable</span>';


                    } else if (actionType == "Enable") {
                        twoFactorFields.style.display = 'none';
                        statusBadge.style.display = 'block';
                        two_step_verify_enable = 1;
                        statusBadge.textContent = 'Enabled';
                        statusBadge.className = 'erp-status-badge erp-status-badge--enabled';
                        toggleButton.innerHTML = '<i class="fas fa-shield-alt"></i><span>Disable</span>';


                    }


                } else {
                    var errorMsg = encodeURIComponent(json_data[0].message);
                    window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                }

            }


        });

    }


    document.getElementById('profile-upload').addEventListener('change', function(event) {

        const file = event.target.files[0];
        if (!file) return;

        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-image').src = e.target.result;
            document.getElementById('profile-image').style.display = 'block';
            document.getElementById('profile-default').style.display = 'none';
        };
        reader.readAsDataURL(file);

        // Prepare FormData
        var formData = new FormData();
        formData.append("image_uploder_image", file);
        formData.append("image_uploder_image_TYPE", "ITEM");

        // AJAX Upload
        $.ajax({
            url: "<?php echo $pth; ?>View-List/File_Uploader_Control/image_upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // alert(response);
                console.log(response);

                console.log("Raw Response:", response);

                var data = JSON.parse(response);

                if (data[0].error == "0") {

                    // alert(data[0].img_pth);

                    // Save image path to hidden input
                    document.getElementById("User_Profile_A_01_from_id_image_pth_txt").value = data[0].img_pth;

                    console.log("Image Path Saved:", data[0].img_pth);

                } else {
                    alert("Upload Error: " + data[0].error);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", error);
                // alert("Upload Failed");
            }
        });

    });

    // Run after DOM is loaded
    document.addEventListener("DOMContentLoaded", function() {


        // Dynamically set the current year in the copyright
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Profile picture upload functionality
        document.getElementById('<?php echo $get_image_form_id_setup ?>_uploadTrigger').addEventListener('click', function() {
            document.getElementById('profile-upload').click();
        });






        // Form submission handler (for demo purposes)
        document.querySelector('.erp-form').addEventListener('submit', function(event) {
            event.preventDefault();

            // Show a success message
            // alert('Profile changes saved successfully!');

            Update_main_user_login_profile(event)

            // In a real application, this would submit the form data to a server
            // For this demo, we'll just simulate a successful save
            console.log('Form submitted with profile data');
        });

        // Two-Factor Authentication toggle functionality
        document.getElementById('two-factor-auth-toggle').addEventListener('click', function() {

        });
    });
</script>