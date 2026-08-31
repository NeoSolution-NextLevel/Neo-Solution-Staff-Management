  <div class="erp-container erp-container--login">
      <div class="erp-login-card">
          <!-- Header Section: Displays company branding and generic success title -->
          <div class="erp-login-card__header">
              <h1 class="erp-login-card__title">Success</h1>
              <p class="erp-login-card__subtitle">Your action has been completed successfully</p>
          </div>

          <!-- Main Body: Displays animated success icon and customizable message -->
          <div class="erp-login-card__body">
              <!-- Creative Success Animation with multiple elements -->
              <div class="erp-success-container">
                  <!-- Animated rings -->
                  <div class="erp-success-ring"></div>
                  <div class="erp-success-ring"></div>
                  <div class="erp-success-ring"></div>

                  <!-- Main success icon -->
                  <i class="fas fa-check-circle erp-success-icon"></i>

                  <!-- Confetti container -->
                  <div class="erp-confetti-container" id="confetti-container"></div>
              </div>

              <!-- Success message with typewriter effect -->
              <div class="erp-text-center">
                  <p class="erp-success-message" id="success-message"></p>

                  <!-- Countdown indicator -->
                  <div class="erp-progress-container" id="progress-container">
                      <div class="erp-progress-bar" id="progress-bar"></div>
                  </div>

                  <p class="erp-text-tertiary erp-text-sm erp-mt-md" id="countdown-text">Redirecting in 3 seconds...</p>
              </div>

              <!-- Proceed Button: Customizable button text and action -->
              <div class="erp-mt-xl">
                  <button type="button" class="erp-btn erp-btn--primary erp-btn--block" id="proceed-btn">
                      <i class="fas fa-arrow-right"></i>
                      <span id="proceed-text">Continue to Dashboard</span>
                  </button>
              </div>

              <!-- Optional Additional Links -->
              <div class="erp-text-center erp-mt-md">
                  <a href="#" class="erp-link" id="additional-link" style="display: none;">
                      <i class="fas fa-external-link-alt"></i>
                      <span id="additional-link-text"></span>
                  </a>
              </div>
          </div>

          <!-- Footer: Displays copyright and version info -->
          <div class="erp-login-card__footer" id="footer-particles">
              <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> Enterprise Resource Planning System v4.2.1</p>
          </div>
      </div>
  </div>
  <script>
      // Dynamically set the current year in the copyright
      document.getElementById('current-year').textContent = new Date().getFullYear();

      // Create confetti particles
      function createConfetti() {
          const container = document.getElementById('confetti-container');
          const particleCount = 50;

          for (let i = 0; i < particleCount; i++) {
              const confetti = document.createElement('div');
              confetti.className = 'erp-confetti';

              // Random positioning
              confetti.style.left = Math.random() * 100 + '%';
              confetti.style.top = '-20px';

              // Random animation delay and duration
              const delay = Math.random() * 2;
              const duration = 3 + Math.random() * 4;
              confetti.style.animationDelay = delay + 's';
              confetti.style.animationDuration = duration + 's';

              // Random size
              const size = 4 + Math.random() * 8;
              confetti.style.width = size + 'px';
              confetti.style.height = size + 'px';

              container.appendChild(confetti);
          }
      }

      // Create floating particles in footer
      function createFooterParticles() {
          const footer = document.getElementById('footer-particles');
          const particleCount = 15;

          for (let i = 0; i < particleCount; i++) {
              const particle = document.createElement('div');
              particle.className = 'erp-footer-particle';

              // Random positioning
              particle.style.left = Math.random() * 100 + '%';
              particle.style.top = Math.random() * 100 + '%';

              // Random animation delay and duration
              const delay = Math.random() * 10;
              const duration = 10 + Math.random() * 10;
              particle.style.animationDelay = delay + 's';
              particle.style.animationDuration = duration + 's';

              footer.appendChild(particle);
          }
      }

      // Typewriter effect for success message
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

      // Button ripple effect
      document.getElementById('proceed-btn').addEventListener('click', function(e) {
          const btn = e.currentTarget;
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

          // Redirect after ripple animation
          setTimeout(() => {
              window.location.href = 'dashboard.html'; //-----------------------------------------------------------------redirecting page
          }, 300);
      });

      // Countdown timer for auto-redirect
      function startCountdown(seconds, redirectUrl) {
          let countdown = seconds;
          const countdownText = document.getElementById('countdown-text');
          const progressBar = document.getElementById('progress-bar');

          const countdownInterval = setInterval(() => {
              countdownText.textContent = `Redirecting in ${countdown} seconds...`;
              countdown--;

              if (countdown < 0) {
                  clearInterval(countdownInterval);
                  window.location.href = redirectUrl;
              }
          }, 1000);
      }

      // Function to customize the success page
      function customizeSuccess(
          title = 'Success!',
          subtitle = 'Your action has been completed successfully',
          message = 'Operation completed successfully. You will be redirected to the dashboard shortly.',
          buttonText = 'Continue to Dashboard',
          redirectUrl = '<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>',
          autoRedirectDelay = 5000,
          additionalLink = null,
          additionalLinkText = '',
          additionalLinkUrl = '#'
      ) {
          document.querySelector('.erp-login-card__title').textContent = title;
          document.querySelector('.erp-login-card__subtitle').textContent = subtitle;

          // Apply typewriter effect to message
          typewriterEffect(message, 'success-message');

          document.getElementById('proceed-text').textContent = buttonText;

          // Update button click event
          const proceedBtn = document.getElementById('proceed-btn');
          const newOnClick = () => {
              const ripple = document.createElement('span');
              ripple.classList.add('erp-btn-ripple');
              ripple.style.left = '50%';
              ripple.style.top = '50%';
              proceedBtn.appendChild(ripple);

              setTimeout(() => {
                  window.location.href = redirectUrl;
              }, 300);
          };

          proceedBtn.onclick = newOnClick;

          // Setup additional link if provided
          if (additionalLink) {
              const linkElement = document.getElementById('additional-link');
              const linkTextElement = document.getElementById('additional-link-text');
              linkElement.style.display = 'inline-flex';
              linkTextElement.textContent = additionalLinkText;
              linkElement.href = additionalLinkUrl;
          }

          // Start countdown for auto-redirect
          if (autoRedirectDelay > 0) {
              const seconds = Math.floor(autoRedirectDelay / 1000);
              startCountdown(seconds, redirectUrl);

              setTimeout(() => {
                  window.location.href = redirectUrl;
              }, autoRedirectDelay);
          } else {
              document.getElementById('progress-container').style.display = 'none';
              document.getElementById('countdown-text').style.display = 'none';
          }
      }

      // Initialize page with animations
      document.addEventListener('DOMContentLoaded', function() {
          // Create confetti on load
          createConfetti();
          createFooterParticles();

          // Set default success page configuration
          // customizeSuccess();

          const params = new URLSearchParams(window.location.search);
          const sucessType = params.get("message");
          if (sucessType === "User-Registration-Successful") {

              customizeSuccess(
                  'Registration Successful',
                  'Welcome to the ERP System',
                  'Your account has been created successfully. You can now log in using your email and password.',
                  'Go to Login',
                  '<?php echo $home_page ?><?php echo $User_login_url ?>User-Profile<?php echo $online_offline_extention ?>',
                  3000,
                  true,
                  'Back to Home',
                  '<?php echo $home_page ?>'
              );




          } else if (sucessType === "User-Login-Successful") {
              customizeSuccess(
                  'Login Successful',
                  'Welcome back to the ERP System',
                  'Authentication successful. You are now logged in and your dashboard is loading.',
                  'Go to Dashboard',
                  '<?php echo $home_page ?><?php echo $User_login_url ?>User-Profile<?php echo $online_offline_extention ?>',
                  3000,
                  true,
                  'Back to Home',
                  '<?php echo $home_page ?>'
              );
          } else if (sucessType === "<?php echo $_GET['message'] ?>") {

              <?php
                $message_content = isset($_GET['message']) ? $_GET['message'] : 'Unknown-Message';

                // replace dash with space
                $message_content = str_replace('-', ' ', $message_content);

                ?>
              customizeSuccess(
                  'Success!',
                  'Your action has been completed successfully',
                  '<?php echo htmlspecialchars($message_content) ?>', // <-- your dynamic message here
                  'Continue to Dashboard',
                  '<?php echo $home_page ?><?php echo $User_login_url ?>User-Profile<?php echo $online_offline_extention ?>',
                  5000,
                  null,
                  '',
                  '#'
              );


          } else {
              customizeSuccess();
          }

          // Example customizations (uncomment and modify as needed):

          // For login success: 
          // customizeSuccess(
          //     'Login Successful', 
          //     'Welcome back to ERP System',
          //     'Authentication successful. Loading your dashboard with latest updates...',
          //     'Go to Dashboard',
          //     'dashboard.html',
          //     3000,
          //     true,
          //     'View Recent Activities',
          //     'activities.html'
          // );

          // For password reset:
          // customizeSuccess(
          //     'Password Reset Complete', 
          //     'Your security has been updated',
          //     'Your password has been successfully changed. Please login with your new credentials.',
          //     'Back to Login',
          //     'login.html',
          //     5000,
          //     true,
          //     'Security Settings',
          //     'security.html'
          // );

          // For user registration:
          // customizeSuccess(
          //     'Registration Complete', 
          //     'Welcome to ERP System',
          //     'Your account has been created successfully. A verification email has been sent to your inbox.',
          //     'Go to Dashboard',
          //     'dashboard.html',
          //     4000,
          //     true,
          //     'Verify Email',
          //     'verify-email.html'
          // );
      });
  </script>

  <!-- JavaScript for dynamic year, optional redirect, and customization -->