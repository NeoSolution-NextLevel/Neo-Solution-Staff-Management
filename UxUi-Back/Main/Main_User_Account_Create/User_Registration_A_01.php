
    <div class="erp-container erp-container--registration">
        <div class="erp-registration-card">
            <!-- Header Section: Displays company branding and registration title -->
            <div class="erp-registration-card__header">
                <div class="erp-registration-card__brand">
                    <svg viewBox="0 0 260 80" width="180" height="56" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="regBlueSphere" cx="35%" cy="35%" r="65%">
                                <stop offset="0%" stop-color="#7ca4ff"/>
                                <stop offset="40%" stop-color="#3b5bdb"/>
                                <stop offset="85%" stop-color="#1d3b8a"/>
                                <stop offset="100%" stop-color="#0e1e4a"/>
                            </radialGradient>
                            <radialGradient id="regGreenSphere" cx="35%" cy="35%" r="65%">
                                <stop offset="0%" stop-color="#4ade80"/>
                                <stop offset="40%" stop-color="#12b76a"/>
                                <stop offset="85%" stop-color="#0f5128"/>
                                <stop offset="100%" stop-color="#093118"/>
                            </radialGradient>
                            <filter id="regSphereShadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="1" dy="2" stdDeviation="1.5" flood-opacity="0.3"/>
                            </filter>
                        </defs>
                        <g transform="translate(4, 2)" filter="url(#regSphereShadow)">
                            <circle cx="22" cy="22" r="14" fill="url(#regBlueSphere)"/>
                            <circle cx="48" cy="30" r="13" fill="url(#regGreenSphere)"/>
                            <circle cx="23" cy="48" r="13" fill="url(#regGreenSphere)"/>
                            <circle cx="48" cy="56" r="14" fill="url(#regBlueSphere)"/>
                        </g>
                        <text x="80" y="47" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Impact, Arial Black, sans-serif" font-size="46" font-weight="900" letter-spacing="2" fill="#ffffff">NEO</text>
                        <text x="105" y="68" font-family="'Playfair Display', Georgia, 'Times New Roman', serif" font-size="21" font-style="italic" font-weight="600" letter-spacing="0.5" fill="#c7d0f5">Solution</text>
                    </svg>
                </div>
                <h1 class="erp-registration-card__title">Create Account</h1>
                <p class="erp-registration-card__subtitle">Join NEO Solution Office Staff System</p>
            </div>

            <!-- Main Body: Contains the registration form -->
            <div class="erp-registration-card__body">
                <!-- Registration Form -->
                <form class="erp-form" method="POST" onsubmit="return User_Registration_A_01_from_01_SUMBIT(event)" id="User_Registration_A_01_from_01">
                    <!-- Personal Information Section -->
                    <div class="erp-form__group">
                        <h3 class="erp-mb-md" style="color: var(--erp-primary); border-bottom: 1px solid var(--erp-border); padding-bottom: var(--erp-space-xs);">
                            <i class="fas fa-user-circle"></i> Personal Information
                        </h3>

                        <div class="erp-form-grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">First Name <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-user erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        name="val_07"
                                        id="User_Registration_A_01_val_01_child_01"
                                        placeholder="John"
                                        required
                                        aria-label="First Name">
                                </div>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Last Name <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-user erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        name="val_08"
                                        placeholder="Doe"
                                        id="User_Registration_A_01_val_01_child_02"
                                        required
                                        aria-label="Last Name">
                                </div>
                            </div>
                        </div>

                        <div class="erp-form__group">
                            <label class="erp-form__label">Corporate Email <span style="color: var(--erp-accent-error);">*</span></label>
                            <div class="erp-input-wrapper">
                                <i class="fas fa-envelope erp-form__icon"></i>
                                <input
                                    type="email"
                                    class="erp-form__control erp-form__control--with-icon"
                                    name="val_02"
                                    placeholder="john.doe@company.com"
                                    id="User_Registration_A_01_val_02"
                                    required
                                    aria-label="Corporate Email">
                            </div>
                            <span class="erp-form__hint">Must be a valid corporate email address</span>
                        </div>

                        <div class="erp-form__group">
                            <label class="erp-form__label">Employee ID <span style="color: var(--erp-text-tertiary);">(Optional)</span></label>
                            <div class="erp-input-wrapper">
                                <i class="fas fa-id-badge erp-form__icon"></i>
                                <input
                                    type="text"
                                    class="erp-form__control erp-form__control--with-icon"
                                    name="val_03"
                                    placeholder="EMP-12345"
                                    id="User_Registration_A_01_val_03"
                                    aria-label="Employee ID">
                            </div>
                            <span class="erp-form__hint">Enter your company employee ID if available</span>
                        </div>
                    </div>

                    <!-- Account Credentials Section -->
                    <div class="erp-form__group">
                        <h3 class="erp-mb-md" style="color: var(--erp-primary); border-bottom: 1px solid var(--erp-border); padding-bottom: var(--erp-space-xs);">
                            <i class="fas fa-key"></i> Account Credentials
                        </h3>

                        <div class="erp-form-grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">Password <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-lock erp-form__icon"></i>
                                    <input
                                        type="password"
                                        class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                                        name="val_04"
                                        placeholder="••••••••"
                                        required
                                        id="User_Registration_A_01_val_04_child_01"
                                        onkeyup="checkPasswordStrength()"
                                        aria-label="Password">
                                    <i class="fas fa-eye erp-form__toggle" id="password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility"></i>
                                </div>

                                <div class="erp-password-strength">
                                    <div class="erp-password-strength__bar">
                                        <div class="erp-password-strength__fill" id="password-strength-bar"></div>
                                    </div>
                                    <div class="erp-password-strength__text" id="password-strength-text">Password strength</div>
                                </div>

                                <!--                                <div class="erp-mt-sm">
                                    <span class="erp-form__hint"><i class="fas fa-check-circle erp-form__hint--valid" id="uppercase-check"></i> At least one uppercase letter</span><br>
                                    <span class="erp-form__hint"><i class="fas fa-check-circle erp-form__hint--valid" id="lowercase-check"></i> At least one lowercase letter</span><br>
                                    <span class="erp-form__hint"><i class="fas fa-check-circle erp-form__hint--valid" id="number-check"></i> At least one number</span><br>
                                    <span class="erp-form__hint"><i class="fas fa-check-circle erp-form__hint--valid" id="special-check"></i> At least one special character</span><br>
                                    <span class="erp-form__hint"><i class="fas fa-check-circle erp-form__hint--valid" id="length-check"></i> Minimum 8 characters</span>
                                </div>-->
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Confirm Password <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-lock erp-form__icon"></i>
                                    <input
                                        type="password"
                                        class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                                        name="confirm_password"
                                        placeholder="••••••••"
                                        required
                                        id="User_Registration_A_01_val_04_child_02"
                                        onkeyup="checkPasswordMatch()"
                                        aria-label="Confirm Password">
                                    <i class="fas fa-eye erp-form__toggle" id="confirm-password-toggle" onclick="toggleConfirmPassword()" aria-label="Toggle password visibility"></i>
                                </div>
                                <span class="erp-form__hint" id="password-match-hint">Re-enter your password</span>
                            </div>
                        </div>
                    </div>

                    <!-- Department & Role Section -->
                    <div class="erp-form__group">
                        <h3 class="erp-mb-md" style="color: var(--erp-primary); border-bottom: 1px solid var(--erp-border); padding-bottom: var(--erp-space-xs);">
                            <i class="fas fa-briefcase"></i> Department & Role
                        </h3>

                        <div class="erp-form-grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">Department <span style="color: var(--erp-accent-error);">*</span></label>
                                <select class="erp-form__control" name="val_05" required aria-label="Department" id="User_Registration_A_01_val_05_select_obj" onchange="User_Registration_A_01_update_ac_type(this)">
                                    <option value="" disabled selected>Select Department</option>
                                </select>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Access Type <span style="color: var(--erp-accent-error);">*</span></label>
                                <input
                                    type="text"
                                    class="erp-form__control"
                                    name="val_06"
                                    placeholder="Select a department to set access type"
                                    readonly
                                    required
                                    id="User_Registration_A_01_val_06"
                                    aria-label="Access Type">
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="erp-form__group">
                        <div class="erp-terms">
                            <input type="checkbox" class="erp-terms__checkbox" id="User_Registration_A_01_val_07" name="terms" required>
                            <label for="User_Registration_A_01_val_07" class="erp-terms__label">
                                I agree to the <a href="#" class="erp-link">Terms of Service</a> and <a href="#" class="erp-link">Privacy Policy</a>.
                                I understand that my account will be verified by the system administrator before I can access the ERP system.
                                <span style="color: var(--erp-accent-error);">*</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="erp-form__group erp-mt-xl">
                        <button type="submit" class="erp-btn erp-btn--primary erp-btn--block">
                            <i class="fas fa-user-plus"></i>
                            <span>Create Account</span>
                        </button>
                    </div>

                    <!-- Login Option: For existing users -->
                    <div class="erp-text-center erp-mt-lg">
                        <p class="erp-text-tertiary erp-text-sm erp-mb-sm">Already have an account?</p>
                        <a href="<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>" class="erp-btn erp-btn--secondary">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Sign In Instead</span>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer: Displays copyright and version info -->
            <div class="erp-registration-card__footer">
                <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> <strong>NEO Solution</strong> • Staff Management System</p>
            </div>
        </div>
    </div>



    <!-- JavaScript for dynamic year, password toggle, and validation -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            //load user access level ( department )
            User_Registration_A_01_main_user_account_access_level_list();
        });


        // Dynamically set the current year in the copyright
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Function to toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('User_Registration_A_01_val_04_child_01');
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

        // Function to toggle confirm password visibility
        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('User_Registration_A_01_val_04_child_02');
            const toggleIcon = document.getElementById('confirm-password-toggle');
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Function to check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('User_Registration_A_01_val_04_child_01').value;
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');

            // Reset checks
            document.getElementById('uppercase-check').style.color = 'var(--erp-text-tertiary)';
            document.getElementById('lowercase-check').style.color = 'var(--erp-text-tertiary)';
            document.getElementById('number-check').style.color = 'var(--erp-text-tertiary)';
            document.getElementById('special-check').style.color = 'var(--erp-text-tertiary)';
            document.getElementById('length-check').style.color = 'var(--erp-text-tertiary)';

            // Check criteria
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            const hasMinLength = password.length >= 8;

            // Update check icons
            if (hasUpperCase) document.getElementById('uppercase-check').style.color = 'var(--erp-accent-success)';
            if (hasLowerCase) document.getElementById('lowercase-check').style.color = 'var(--erp-accent-success)';
            if (hasNumbers) document.getElementById('number-check').style.color = 'var(--erp-accent-success)';
            if (hasSpecialChar) document.getElementById('special-check').style.color = 'var(--erp-accent-success)';
            if (hasMinLength) document.getElementById('length-check').style.color = 'var(--erp-accent-success)';

            // Calculate strength score
            let strength = 0;
            if (hasUpperCase) strength++;
            if (hasLowerCase) strength++;
            if (hasNumbers) strength++;
            if (hasSpecialChar) strength++;
            if (hasMinLength) strength++;

            // Update strength bar and text
            strengthBar.className = 'erp-password-strength__fill';

            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthText.textContent = 'Password strength';
                strengthText.style.color = 'var(--erp-text-tertiary)';
            } else if (strength <= 2) {
                strengthBar.classList.add('erp-password-strength__fill--weak');
                strengthText.textContent = 'Weak password';
                strengthText.style.color = 'var(--erp-accent-error)';
            } else if (strength <= 4) {
                strengthBar.classList.add('erp-password-strength__fill--fair');
                strengthText.textContent = 'Fair password';
                strengthText.style.color = 'var(--erp-accent-warning)';
            } else {
                strengthBar.classList.add('erp-password-strength__fill--strong');
                strengthText.textContent = 'Strong password';
                strengthText.style.color = 'var(--erp-accent-success)';
            }

            // Also check password match
            checkPasswordMatch();
        }

        // Function to check if passwords match
        function checkPasswordMatch() {
            const password = document.getElementById('User_Registration_A_01_val_04_child_01').value;
            const confirmPassword = document.getElementById('User_Registration_A_01_val_04_child_02').value;
            const matchHint = document.getElementById('password-match-hint');

            if (confirmPassword.length === 0) {
                matchHint.textContent = 'Re-enter your password';
                matchHint.style.color = 'var(--erp-text-tertiary)';
            } else if (password === confirmPassword) {
                matchHint.innerHTML = '<i class="fas fa-check-circle"></i> Passwords match';
                matchHint.style.color = 'var(--erp-accent-success)';
            } else {
                matchHint.innerHTML = '<i class="fas fa-exclamation-circle"></i> Passwords do not match';
                matchHint.style.color = 'var(--erp-accent-error)';
            }
        }

    </script>
