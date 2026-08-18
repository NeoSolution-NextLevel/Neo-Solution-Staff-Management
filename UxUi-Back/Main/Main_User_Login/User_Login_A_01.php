      <div class="erp-container erp-container--login">
          <div class="erp-login-card">
              <!-- Header Section: Displays company branding and login title -->
              <div class="erp-login-card__header">
                  <div class="erp-login-card__brand">
                      <svg viewBox="0 0 260 80" width="180" height="56" xmlns="http://www.w3.org/2000/svg">
                          <defs>
                              <radialGradient id="loginBlueSphere" cx="35%" cy="35%" r="65%">
                                  <stop offset="0%" stop-color="#7ca4ff"/>
                                  <stop offset="40%" stop-color="#3b5bdb"/>
                                  <stop offset="85%" stop-color="#1d3b8a"/>
                                  <stop offset="100%" stop-color="#0e1e4a"/>
                              </radialGradient>
                              <radialGradient id="loginGreenSphere" cx="35%" cy="35%" r="65%">
                                  <stop offset="0%" stop-color="#4ade80"/>
                                  <stop offset="40%" stop-color="#12b76a"/>
                                  <stop offset="85%" stop-color="#0f5128"/>
                                  <stop offset="100%" stop-color="#093118"/>
                              </radialGradient>
                              <filter id="loginSphereShadow" x="-20%" y="-20%" width="140%" height="140%">
                                  <feDropShadow dx="1" dy="2" stdDeviation="1.5" flood-opacity="0.3"/>
                              </filter>
                          </defs>
                          <g transform="translate(4, 2)" filter="url(#loginSphereShadow)">
                              <circle cx="22" cy="22" r="14" fill="url(#loginBlueSphere)"/>
                              <circle cx="48" cy="30" r="13" fill="url(#loginGreenSphere)"/>
                              <circle cx="23" cy="48" r="13" fill="url(#loginGreenSphere)"/>
                              <circle cx="48" cy="56" r="14" fill="url(#loginBlueSphere)"/>
                          </g>
                          <text x="80" y="47" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Impact, Arial Black, sans-serif" font-size="46" font-weight="900" letter-spacing="2" fill="#ffffff">NEO</text>
                          <text x="105" y="68" font-family="'Playfair Display', Georgia, 'Times New Roman', serif" font-size="21" font-style="italic" font-weight="600" letter-spacing="0.5" fill="#c7d0f5">Solution</text>
                      </svg>
                  </div>
                  <h1 class="erp-login-card__title">Sign In to Portal</h1>
                  <p class="erp-login-card__subtitle">Office Staff & HR Management System</p>
              </div>

              <!-- Main Body: Contains the login form and options -->
              <div class="erp-login-card__body">
                  <!-- Traditional Login Form: Allows users to enter credentials -->
                  <form class="erp-form" method="post" onsubmit="return User_Login_A_01_from_01_SUMBIT(event)">
                      <div class="erp-form__group">
                          <label class="erp-form__label">Corporate Email</label>
                          <div class="erp-input-wrapper">
                              <i class="fas fa-envelope erp-form__icon"></i>
                              <input
                                  type="email"
                                  class="erp-form__control erp-form__control--with-icon"
                                  name="email"
                                  placeholder="name@company.com"
                                  required
                                  id="User_Login_A_01_val_01"
                                  aria-label="Corporate Email">
                          </div>
                          <span class="erp-form__hint">Enter your corporate email address</span>
                      </div>

                      <div class="erp-form__group">
                          <label class="erp-form__label">Password</label>
                          <div class="erp-input-wrapper">
                              <i class="fas fa-lock erp-form__icon"></i>
                              <input
                                  type="password"
                                  class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                                  name="password"
                                  placeholder="••••••••"
                                  required
                                  id="User_Login_A_01_val_02"
                                  aria-label="Password">
                              <!-- Password Toggle: Click to show/hide password -->
                              <i class="fas fa-eye erp-form__toggle" id="password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility"></i>
                          </div>
                          <span class="erp-form__hint">Minimum 8 characters with mixed case, numbers & symbols</span>
                      </div>

                      <div class="erp-form__group erp-mt-lg">
                          <button type="submit" class="erp-btn erp-btn--primary erp-btn--block">
                              <i class="fas fa-sign-in-alt"></i>
                              <span>Sign In to Portal</span>
                          </button>
                      </div>

                      <!-- Divider: Separates traditional login from social options -->
                      <div class="erp-divider">
                          <div class="erp-divider__line"></div>
                          <div class="erp-divider__text">OR Sign In With</div>
                          <div class="erp-divider__line"></div>
                      </div>
                      <?php

                        $auth_url = $authorize_url . "?" . http_build_query([
                            'client_id'     => $client_id,
                            'response_type' => 'code',
                            'redirect_uri'  => $redirect_uri,
                            'response_mode' => 'query',
                            'scope'         => $scope,
                            'state'         => bin2hex(random_bytes(16))
                        ]);
                        ?>





                      <!-- Social Login Options: Alternative login methods -->
                      <div class="erp-social-login">
                          <div class="erp-social-login__item">
                              <a href="<?php echo $google_login_url; ?>"
                                  class="erp-btn erp-btn--google erp-btn--block">
                                  <i class="fab fa-google erp-social-login__icon erp-social-login__icon--google"></i>
                                  <span>Google</span>
                              </a>



                          </div>
                          <div class="erp-social-login__item">
                              <button
                                  type="button"
                                  class="erp-btn erp-btn--microsoft erp-btn--block"
                                  onclick="window.location.href='<?= htmlspecialchars($auth_url, ENT_QUOTES) ?>'">

                                  <i class="fab fa-microsoft erp-social-login__icon erp-social-login__icon--microsoft"></i>
                                  <span>Microsoft</span>
                              </button>
                          </div>


                      </div>

                      <!-- Forgot Password Link: Helps users reset password -->
                      <div class="erp-text-center erp-mt-md">
                          <a href="#" class="erp-link erp-text-sm">Forgot your password?</a>
                      </div>

                      <!-- Registration Option: For new users -->
                      <div class="erp-text-center erp-mt-xl">
                          <p class="erp-text-tertiary erp-text-sm erp-mb-sm">Don't have an account?</p>
                          <button class="erp-btn erp-btn--secondary" type="button"
                              onclick="window.location.href='<?php echo $home_page ?><?php echo $User_login_url ?>User-Registration<?php echo $online_offline_extention ?>'">
                              <i class="fas fa-user-plus"></i>
                              <span>Register Now</span>
                          </button>

                      </div>
                  </form>
              </div>

              <!-- Footer: Displays copyright and version info -->
              <div class="erp-login-card__footer">
                  <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> <strong>NEO Solution</strong> • Staff Management System</p>
              </div>
          </div>
      </div>

      <!-- JavaScript for dynamic year and password toggle -->
      <script>
          // Dynamically set the current year in the copyright
          document.getElementById('current-year').textContent = new Date().getFullYear();

          // Function to toggle password visibility
          function togglePassword() {
              const passwordInput = document.getElementById('User_Login_A_01_val_02');
              const toggleIcon = document.getElementById('password-toggle');
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
      </script>