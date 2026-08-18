 <!-- JavaScript for dynamic year, password toggles, and basic validation -->
 <script>
     function main_user_login_change_password() {
         const errorMessage = document.getElementById('error-message');
         const newPassword = document.getElementById('new-password').value;
         const current_password = document.getElementById('current-password').value;




         var Sending_value = "id=" + encodeURIComponent("<?php echo $_SESSION['user_id']; ?>") +
             "&password=" + encodeURIComponent(newPassword) +
             "&current_password=" + encodeURIComponent(current_password) +
             "&user_name=" + encodeURIComponent("<?php echo $_SESSION['user_name']; ?>") +
             "&change_password=0";

         //  alert(Sending_value);
         $.ajax({
             url: "<?php echo $pth; ?>View-List/Main/Main_User_Login_Account_Create/Main_User_Login_UPDATE_DATA.php",
             type: "POST",
             data: Sending_value,
             success: function(res) {
                 //  console.log(res);
                 //  alert(res);

                 try {
                     var json = JSON.parse(res);

                     if (json[0].error === "0") {
                         var sucessMsg = encodeURIComponent(json[0].message);
                         window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;


                     } else if (json[0].message === "Current-Password-Not-Match") {
                         errorMessage.innerHTML = "Current Password Not Match";
                         errorMessage.style.display = 'block';



                     }

                 } catch (e) {
                     var errorMsg = encodeURIComponent("Service-Error");
                     window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                 }
             }
         });

     }
     // Dynamically set the current year in the copyright
     document.getElementById('current-year').textContent = new Date().getFullYear();

     // Function to toggle password visibility
     function togglePassword(inputId, toggleId) {
         const passwordInput = document.getElementById(inputId);
         const toggleIcon = document.getElementById(toggleId);
         if (passwordInput.type === 'password') {
             passwordInput.type = 'text';
             toggleIcon.classList.remove('fa-eye');
             toggleIcon.classList.add('fa-eye-slash');
         } else {
             passwordInput.type = 'password';
             toggleIcon.classList.remove('fa-eye-slash');
             toggleIcon.classList.add('fa-eye');
         }
     }

     // Basic form validation: Check if new and confirm passwords match
     document.getElementById('change-password-form').addEventListener('submit', function(event) {
         const newPassword = document.getElementById('new-password').value;
         const confirmPassword = document.getElementById('confirm-password').value;
         const errorMessage = document.getElementById('error-message');

         if (newPassword !== confirmPassword) {
             event.preventDefault(); // Prevent submission
             errorMessage.style.display = 'block';
         } else {
             errorMessage.style.display = 'none';
             // In a real app, submit to backend; here, just prevent for demo
             event.preventDefault();

             main_user_login_change_password();
         }
     });
 </script>