 <script>
     // Dynamically set the current year in the copyright
     document.getElementById('current-year').textContent = new Date().getFullYear();

     // Create error particles in footer
     function createErrorParticles() {
         const footer = document.getElementById('footer-particles');
         const particleCount = 20;

         for (let i = 0; i < particleCount; i++) {
             const particle = document.createElement('div');
             particle.className = 'erp-error-particle';

             // Random positioning
             particle.style.left = Math.random() * 100 + '%';
             particle.style.top = Math.random() * 100 + '%';

             // Random animation delay and duration
             const delay = Math.random() * 15;
             const duration = 15 + Math.random() * 15;
             particle.style.animationDelay = delay + 's';
             particle.style.animationDuration = duration + 's';

             footer.appendChild(particle);
         }
     }

     // Animate broken pieces
     function animateBrokenPieces() {
         const pieces = document.querySelectorAll('.erp-broken-piece');

         // Set random positions for each piece
         pieces.forEach((piece, index) => {
             const angle = (index * 120) * (Math.PI / 180); // 120 degrees apart
             const distance = 60 + Math.random() * 40;
             const tx = Math.cos(angle) * distance;
             const ty = Math.sin(angle) * distance;
             const rot = 180 + Math.random() * 180;

             piece.style.setProperty('--tx', `${tx}px`);
             piece.style.setProperty('--ty', `${ty}px`);
             piece.style.setProperty('--rot', `${rot}deg`);
         });
     }

     // Button ripple effect
     function addRippleEffect(buttons) {
         buttons.forEach(btn => {
             btn.addEventListener('click', function(e) {
                 const rect = btn.getBoundingClientRect();
                 const x = e.clientX - rect.left;
                 const y = e.clientY - rect.top;

                 const ripple = document.createElement('span');
                 ripple.classList.add('erp-btn-ripple');
                 ripple.style.left = x + 'px';
                 ripple.style.top = y + 'px';

                 btn.appendChild(ripple);

                 // Remove ripple after animation completes
                 setTimeout(() => {
                     ripple.remove();
                 }, 600);
             });
         });
     }

     // Toggle error details visibility
     function setupErrorDetailsToggle() {
         const errorCode = document.getElementById('error-code');
         const errorDetails = document.getElementById('error-details');

         errorCode.addEventListener('click', () => {
             if (errorDetails.style.display === 'none') {
                 errorDetails.style.display = 'block';
                 errorCode.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Error Details';
             } else {
                 errorDetails.style.display = 'none';
                 errorCode.innerHTML = 'Error Code: <span id="error-code-value">ERR-500</span>';
             }
         });
     }

     // Function to customize the error page
     function customizeError(
         title = 'Operation Failed',
         subtitle = 'An error occurred while processing your request',
         message = 'The operation could not be completed. Please try again.',
         errorCode = 'ERR-500',
         errorDetails = 'Internal server error. The request could not be processed.',
         retryText = 'Try Again',
         backText = 'Go Back',
         retryUrl = '#',
         backUrl = 'javascript:history.back()',
         showHelp = true,
         helpText = 'Need help? Contact Support',
         helpUrl = 'https://www.neosolution.lk/Contact-Us'
     ) {
         // Set titles and messages
         document.getElementById('error-title').textContent = title;
         document.getElementById('error-subtitle').textContent = subtitle;
         document.getElementById('error-message').textContent = message;
         document.getElementById('error-code-value').textContent = errorCode;
         document.getElementById('error-details-content').textContent = errorDetails;
         document.getElementById('retry-text').textContent = retryText;
         document.getElementById('back-text').textContent = backText;

         // Set button actions
         document.getElementById('retry-btn').onclick = () => {
             if (retryUrl === '#') {
                 window.location.reload();
             } else {
                 window.location.href = retryUrl;
             }
         };

         document.getElementById('back-btn').onclick = () => {
             if (backUrl === 'javascript:history.back()') {
                 history.back();
             } else {
                 window.location.href = backUrl;
             }
         };

         // Set up help link
         const helpLink = document.getElementById('help-link');
         if (showHelp) {
             helpLink.style.display = 'inline-flex';
             helpLink.innerHTML = `<span>${helpText}</span>`;
             helpLink.href = helpUrl;
         } else {
             helpLink.style.display = 'none';
         }

         // Typewriter effect for error message
         typewriterEffect(message, 'error-message', 30);
     }

     // Typewriter effect
     function typewriterEffect(text, elementId, speed = 50) {
         const element = document.getElementById(elementId);
         let i = 0;

         function typeWriter() {
             if (i < text.length) {
                 element.innerHTML += text.charAt(i);
                 i++;
                 setTimeout(typeWriter, speed);
             }
         }

         element.innerHTML = '';
         setTimeout(() => typeWriter(), 500);
     }

     // Initialize page with animations
     document.addEventListener('DOMContentLoaded', function() {
         // Create error particles
         createErrorParticles();

         // Animate broken pieces
         setTimeout(animateBrokenPieces, 1000);

         // Add ripple effects to buttons
         const buttons = document.querySelectorAll('.erp-btn');
         addRippleEffect(buttons);

         // Set up error details toggle
         setupErrorDetailsToggle();

         // Set default error page configuration
         // customizeError();

         // Example error scenarios (uncomment to use):

         // 1. Login Failure
         // customizeError(
         //     'Login Failed',
         //     'Authentication error',
         //     'Invalid username or password. Please check your credentials and try again.',
         //     'ERR-401',
         //     'Authentication failed: Credentials do not match any user in the system.',
         //     'Try Again',
         //     'Forgot Password?',
         //     'login.html',
         //     'forgot-password.html'
         // );

         // 2. Server Error
         // customizeError(
         //     'Server Error',
         //     'Internal server problem',
         //     'The server encountered an unexpected condition. Our team has been notified.',
         //     'ERR-503',
         //     'Database connection timeout. Could not establish connection to the primary database server.',
         //     'Retry Connection',
         //     'Return Home',
         //     '#',
         //     'index.html'
         // );

         // 3. Validation Error
         // customizeError(
         //     'Validation Failed',
         //     'Invalid input data',
         //     'The information you entered does not meet the required format. Please check and try again.',
         //     'ERR-422',
         //     'Field "email": Must be a valid email address.\nField "password": Must be at least 8 characters long.',
         //     'Fix Errors',
         //     'Clear Form',
         //     '#',
         //     'javascript:document.querySelector("form").reset()'
         // );



         const params = new URLSearchParams(window.location.search);
         const errorType = params.get("error");
         if (errorType === "Service-Error") {

             // Server Error
             customizeError(
                 'Server Error',
                 'Internal server problem',
                 'The server encountered an unexpected condition. Our team has been notified.',
                 'ERR-503',
                 'Database connection timeout. Could not establish connection to the primary database server.',
                 'Retry Connection',
                 'Return Home',
                 '#',
                 'index.html'
             );

         } else if (errorType === "Password-Mismatched") {

             // Validation Error
             customizeError(
                 'Password Mismatch',
                 'Passwords do not match',
                 'The password and confirm password fields must be identical. Please re-enter both passwords and try again.',
                 'ERR-422',
                 'Password and confirm password values are different.',
                 'Fix Password',
                 'Go to Register',
                 '#',
                 '<?php echo $home_page ?><?php echo $User_login_url ?>User-Registration<?php echo $online_offline_extention ?>'
             );


         } else if (errorType === "email-already-exist") {
             customizeError(
                 'Validation Failed',
                 'Email already exists',
                 'The email address you entered is already associated with an existing account. Please use a different email address or try logging in.',
                 'ERR-409',
                 'Duplicate email detected in the system.',
                 'Use Different Email',
                 'Go to Login',
                 '#',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );


         } else if (errorType === "Username-Incorrect") {
             customizeError(
                 'Login Failed',
                 'Incorrect email address',
                 'The email address you entered does not match any account. Please check your email and try again.',
                 'ERR-401',
                 'No user account found with the provided email.',
                 'Retry Login',
                 'Go to Login',
                 '#',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );
         } else if (errorType === "Password-Incorrect") {
             customizeError(
                 'Login Failed',
                 'Incorrect password',
                 'The password you entered is incorrect. Please check your password and try again.',
                 'ERR-401',
                 'Password verification failed for the given account.',
                 'Retry Login',
                 'Go to Login',
                 '#',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );
         } else if (errorType === "Empty-Data-Registration") {
             customizeError(
                 'No Data Available In Department',
                 'Nothing to display',
                 'No records were found for your request. Please try again later or contact the administrator if the problem persists.',
                 'ERR-204',
                 'The server returned an empty data set.',
                 'Go Back',
                 'Return Home',
                 'javascript:history.back()',
                 '<?php echo $home_page ?>'
             );
         } else if (errorType === "Temporary-Lock") {

             customizeError(
                 'Account Temporarily Locked',
                 'Too Many Failed Authentication Attempts',
                 'Your account has been temporarily locked due to multiple failed authentication attempts. Please contact the system administrator to unlock your account. Admin Email: <?php echo $company_obj->get_compnay_default_sending_email() ?> Admin Phone: <?php echo $company_obj->get_compnay_phone() ?>',
                 'ERR-ACCOUNT-LOCK-403',
                 'Account temporarily locked for security reasons.',
                 'Contact Admin',
                 'Back to Login',
                 'javascript:history.back()',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );



         } else if (errorType === "Authentication-Error") {
             customizeError(
                 'Google Authentication Failed',
                 'Verification code error',
                 'The authentication code you entered is invalid or has expired. Please check the code from your Google Authenticator app and try again.',
                 'ERR-GAUTH-401',
                 'Google Authenticator verification failed.',
                 'Retry Verification',
                 'Back to Login',
                 'javascript:history.back()',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );
         } else if (errorType === "Re-Login-Required") {

             customizeError(
                 'Session Expired',
                 'Re-login required',
                 'Your session has expired or you have been logged out for security reasons. Please log in again to continue.',
                 'ERR-401',
                 'User session is invalid or expired.',
                 'Login Again',
                 'Go to Login',
                 '#',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );

         } else if (errorType === "<?php echo $_GET['error'] ?>") {

             <?php
                $error = isset($_GET['error']) ? $_GET['error'] : 'Unknown-Error';

                // replace dash with space
                $error = str_replace('-', ' ', $error);

                ?>

             customizeError(
                 '<?php echo htmlspecialchars($error) ?>',
                 'Action Failed',
                 'Something went wrong while processing your request. Please try again.',
                 'ERR-RETRY',
                 'The requested operation could not be completed at this time.',
                 'Retry',
                 'Try Again',
                 '#',
                 'javascript:location.reload();'
             );


         } else {

             // Default / Unknown error
             customizeError(
                 'Server Error',
                 'Something went wrong',
                 'An unexpected error occurred.',
                 'ERR-000',
                 'No additional details available.',
                 'Go Back',
                 'Home',
                 'javascript:history.back()',
                 '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>'
             );
         }

     });
 </script>