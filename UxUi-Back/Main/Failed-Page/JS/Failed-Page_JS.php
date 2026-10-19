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
        const loginUrl = '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>';
        const homeUrl = '<?php echo $home_page ?>';

        if (errorType === "Service-Error") {
            customizeError(
                'Service Notice',
                'Temporary System Problem',
                'The service encountered an unexpected situation. Please refresh or retry in a few moments.',
                'ERR-503',
                'Database or application service timeout.',
                'Retry Action',
                'Back to Login',
                'javascript:location.reload()',
                loginUrl
            );

        } else if (errorType === "Password-Mismatched") {
            customizeError(
                'Password Mismatch',
                'Passwords do not match',
                'The password and confirm password fields must be identical. Please verify and submit again.',
                'ERR-422',
                'Password and confirm password entries do not match.',
                'Fix Password',
                'Go to Registration',
                'javascript:history.back()',
                '<?php echo $home_page ?><?php echo $User_login_url ?>User-Registration<?php echo $online_offline_extention ?>'
            );

        } else if (errorType === "email-already-exist") {
            customizeError(
                'Registration Failed',
                'Corporate email already registered',
                'The email address entered is already registered in the NEO Solution directory. Please sign in or use another email.',
                'ERR-409',
                'Duplicate corporate email identifier found.',
                'Sign In Instead',
                'Try Registration',
                loginUrl,
                '<?php echo $home_page ?><?php echo $User_login_url ?>User-Registration<?php echo $online_offline_extention ?>'
            );

        } else if (errorType === "Username-Incorrect") {
            customizeError(
                'Login Failed',
                'Account not found',
                'The corporate email address entered does not match any active user account. Please check your credentials.',
                'ERR-401',
                'No active employee or admin account associated with this email address.',
                'Retry Login',
                'Portal Home',
                loginUrl,
                homeUrl
            );
        } else if (errorType === "Password-Incorrect") {
            customizeError(
                'Login Failed',
                'Incorrect password',
                'The password entered is incorrect for this corporate account. Please check your credentials and try again.',
                'ERR-401',
                'Password credential verification failed.',
                'Try Again',
                'Portal Home',
                loginUrl,
                homeUrl
            );
         } else if (errorType === "Admin-Access-Only") {
             customizeError(
                 'Access Restricted',
                 'Administrator Privileges Required',
                 'This section requires administrative authorization. If you are an employee, please sign in with your employee credentials or return to the staff portal.',
                 'ERR-403',
                 'Access denied: User does not possess administrator role permissions.',
                 'Sign In to Portal',
                 'Staff Portal',
                 loginUrl,
                 '<?php echo $home_page ?>UxUi/Employee_user_dashboard<?php echo $online_offline_extention ?>'
             );

         } else if (errorType === "User-Not-Found") {
             customizeError(
                 'Account Not Found',
                 'Single Sign-On Verification',
                 'Your identity was authenticated, but no staff profile is registered with this email address. Please contact your system administrator.',
                 'ERR-SSO-404',
                 'No employee or administrator record matched the authenticated SSO account email.',
                 'Return to Login',
                 'Contact Support',
                 loginUrl,
                 'mailto:<?php echo $company_obj->get_compnay_default_sending_email() ?>'
             );

         } else if (errorType === "Authentication-Required") {
             customizeError(
                 'Authentication Required',
                 'Sign-in required to continue',
                 'You must be signed in with an active account to view this portal page.',
                 'ERR-AUTH-401',
                 'No active session found for protected endpoint.',
                 'Sign In to Portal',
                 'Portal Home',
                 loginUrl,
                 homeUrl
             );

         } else if (errorType === "Empty-Data-Registration") {
             customizeError(
                 'No Data Available',
                 'Department records empty',
                 'No records were found for your requested department or division. Please contact your administrator if this is unexpected.',
                 'ERR-204',
                 'The server returned an empty dataset for this request.',
                 'Go Back',
                 'Return Home',
                 'javascript:history.back()',
                 homeUrl
             );

         } else if (errorType === "Temporary-Lock") {
             customizeError(
                 'Account Temporarily Locked',
                 'Security Threshold Exceeded',
                 'Your account has been temporarily locked due to multiple consecutive failed sign-in attempts. Please contact IT Administration to unlock your account. Admin Email: <?php echo $company_obj->get_compnay_default_sending_email() ?>',
                 'ERR-LOCK-429',
                 'Brute-force protection triggered. Administrator unlock required.',
                 'Contact Admin',
                 'Back to Login',
                 'mailto:<?php echo $company_obj->get_compnay_default_sending_email() ?>',
                 loginUrl
             );

         } else if (errorType === "Authentication-Error") {
             customizeError(
                 'Two-Step Verification Failed',
                 'Verification code invalid or expired',
                 'The authentication code entered is invalid or has expired. Please check your verification code and try again.',
                 'ERR-2FA-401',
                 'Multi-factor verification challenge failed.',
                 'Retry Verification',
                 'Back to Login',
                 'javascript:history.back()',
                 loginUrl
             );

         } else if (errorType === "Re-Login-Required" || errorType === "Session-Expired") {
             customizeError(
                 'Session Expired',
                 'Re-authentication required',
                 'Your portal session has expired for security reasons. Please sign in again to continue.',
                 'ERR-AUTH-TIMEOUT',
                 'User session token expired or terminated.',
                 'Sign In Again',
                 'Portal Home',
                 loginUrl,
                 homeUrl
             );

         } else if (errorType && errorType.length > 0) {
             const friendlyName = errorType.replace(/-/g, ' ');
             customizeError(
                 friendlyName,
                 'Action Notice',
                 'Something went wrong while processing your request. Please try again.',
                 'ERR-REQ',
                 'The requested operation returned status: ' + errorType,
                 'Try Again',
                 'Back to Login',
                 loginUrl,
                 loginUrl
             );

         } else {
             customizeError(
                 'Portal Alert',
                 'Operation could not be completed',
                 'An unexpected condition occurred while processing your request. Please try again or return to the portal.',
                 'ERR-GENERAL',
                 'Unspecified portal condition.',
                 'Back to Login',
                 'Portal Home',
                 loginUrl,
                 homeUrl
             );
         }

     });
 </script>