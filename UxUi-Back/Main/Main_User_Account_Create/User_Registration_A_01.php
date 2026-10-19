    <div class="erp-container erp-container--registration">
        <div class="erp-registration-card">
            <!-- Header Section: Displays company branding and employee registration title -->
            <div class="erp-registration-card__header">
                <div class="erp-registration-card__logo" style="font-size: 32px; color: #93c5fd; margin-bottom: 8px;">
                    <i class="fas fa-id-card-clip"></i>
                </div>
                <h1 class="erp-registration-card__title">Employee Registration</h1>
                <p class="erp-registration-card__subtitle">Create your staff account to access the <?php echo $company_obj->get_compnay_name() ?> Employee Portal</p>
            </div>

            <!-- Main Body: Contains the registration form -->
            <div class="erp-registration-card__body">
                <!-- Registration Form -->
                <form class="erp-form" method="POST" onsubmit="return User_Registration_A_01_from_01_SUMBIT(event)" id="User_Registration_A_01_from_01">
                    <!-- Personal Information Section -->
                    <div class="erp-form__group">
                        <h3 class="erp-mb-md" style="color: var(--erp-navy, #14204d); font-size: 16px; font-weight: 700; border-bottom: 1px solid var(--erp-border, #e2e8f0); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-user-circle" style="color: var(--erp-primary, #2563eb);"></i> Personal Information
                        </h3>

                        <div class="erp-form-grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">First Name <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-user erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        name="first_name"
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
                                        name="last_name"
                                        placeholder="Doe"
                                        id="User_Registration_A_01_val_01_child_02"
                                        required
                                        aria-label="Last Name">
                                </div>
                            </div>
                        </div>

                        <div class="erp-form-grid erp-mt-sm">
                            <div class="erp-form__group">
                                <label class="erp-form__label">Corporate Email <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-envelope erp-form__icon"></i>
                                    <input
                                        type="email"
                                        class="erp-form__control erp-form__control--with-icon"
                                        name="email"
                                        placeholder="name@company.com"
                                        id="User_Registration_A_01_val_02"
                                        required
                                        aria-label="Corporate Email">
                                </div>
                                <span class="erp-form__hint">Must be your authorized corporate email</span>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Employee ID <span style="color: var(--erp-text-tertiary);">(Optional)</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-id-badge erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        name="employee_id"
                                        placeholder="EMP-001"
                                        id="User_Registration_A_01_val_03"
                                        aria-label="Employee ID">
                                </div>
                                <span class="erp-form__hint">Leave blank to auto-generate</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Credentials Section -->
                    <div class="erp-form__group erp-mt-lg">
                        <h3 class="erp-mb-md" style="color: var(--erp-navy, #14204d); font-size: 16px; font-weight: 700; border-bottom: 1px solid var(--erp-border, #e2e8f0); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-key" style="color: var(--erp-primary, #2563eb);"></i> Account Credentials
                        </h3>

                        <div class="erp-form-grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">Password <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-lock erp-form__icon"></i>
                                    <input
                                        type="password"
                                        class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                                        name="password"
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

                                <div class="erp-mt-xs" style="font-size: 11.5px; color: var(--erp-text-tertiary); display: flex; gap: 10px; flex-wrap: wrap;">
                                    <span id="req-length"><i class="fas fa-check-circle"></i> 8+ chars</span>
                                    <span id="req-upper"><i class="fas fa-check-circle"></i> Upper</span>
                                    <span id="req-lower"><i class="fas fa-check-circle"></i> Lower</span>
                                    <span id="req-number"><i class="fas fa-check-circle"></i> Number</span>
                                </div>
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
                    <div class="erp-form__group erp-mt-lg">
                        <h3 class="erp-mb-md" style="color: var(--erp-navy, #14204d); font-size: 16px; font-weight: 700; border-bottom: 1px solid var(--erp-border, #e2e8f0); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-briefcase" style="color: var(--erp-primary, #2563eb);"></i> Department &amp; Staff Role
                        </h3>

                        <div class="erp-form-grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">Account Access Role <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-shield-halved erp-form__icon"></i>
                                    <select class="erp-form__control erp-form__control--with-icon" name="role" required aria-label="Account Role" id="User_Registration_A_01_val_05_select_obj">
                                        <option value="2" selected>Employee (Staff Access)</option>
                                    </select>
                                </div>
                                <span class="erp-form__hint">Standard staff &amp; employee portal permissions</span>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Department <span style="color: var(--erp-accent-error);">*</span></label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-building erp-form__icon"></i>
                                    <select class="erp-form__control erp-form__control--with-icon" name="department" id="User_Registration_A_01_val_09" required aria-label="Department">
                                        <option value="Engineering" selected>Engineering</option>
                                        <option value="Operations">Operations</option>
                                        <option value="Human Resources">Human Resources</option>
                                        <option value="Finance & Accounts">Finance &amp; Accounts</option>
                                        <option value="Sales & Marketing">Sales &amp; Marketing</option>
                                        <option value="Information Technology">Information Technology</option>
                                        <option value="Administration">Administration</option>
                                    </select>
                                </div>
                                <span class="erp-form__hint">Select your primary work department</span>
                            </div>
                        </div>

                        <div class="erp-form__group erp-mt-sm">
                            <label class="erp-form__label">Job Title / Designation <span style="color: var(--erp-accent-error);">*</span></label>
                            <div class="erp-input-wrapper">
                                <i class="fas fa-user-tag erp-form__icon"></i>
                                <input
                                    type="text"
                                    class="erp-form__control erp-form__control--with-icon"
                                    name="job_title"
                                    placeholder="e.g. Software Engineer, Operations Executive, Staff"
                                    required
                                    id="User_Registration_A_01_val_06"
                                    aria-label="Job Title">
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="erp-form__group erp-mt-lg">
                        <div class="erp-terms">
                            <input type="checkbox" class="erp-terms__checkbox" id="User_Registration_A_01_val_07" name="terms" required>
                            <label for="User_Registration_A_01_val_07" class="erp-terms__label">
                                I confirm that I am an employee of <strong><?php echo $company_obj->get_compnay_name() ?></strong> and agree to the <a href="#" class="erp-link">Terms of Service</a> and <a href="#" class="erp-link">Privacy Policy</a>.
                                <span style="color: var(--erp-accent-error);">*</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="erp-form__group erp-mt-xl">
                        <button type="submit" class="erp-btn erp-btn--primary erp-btn--block" style="height: 48px; font-size: 15px;">
                            <i class="fas fa-user-check"></i>
                            <span>Register as Employee</span>
                        </button>
                    </div>

                    <!-- Login Option: For existing users -->
                    <div class="erp-text-center erp-mt-lg">
                        <p class="erp-text-tertiary erp-text-sm erp-mb-sm">Already registered as an employee?</p>
                        <a href="<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>" class="erp-btn erp-btn--secondary erp-btn--block" style="height: 44px;">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Sign In to Portal</span>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer: Displays copyright and version info -->
            <div class="erp-registration-card__footer" style="padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                <p class="erp-footer__copyright" id="copyright" style="font-size: 12px; color: #64748b; margin: 0; font-weight: 500;">© <span id="current-year"></span> <?php echo $company_obj->get_compnay_name() ?>. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic year, password toggle, and validation -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set dynamic current year
            var yearEl = document.getElementById('current-year');
            if (yearEl) yearEl.textContent = new Date().getFullYear();

            // Load locked Employee role
            if (typeof User_Registration_A_01_main_user_account_access_level_list === "function") {
                User_Registration_A_01_main_user_account_access_level_list();
            }
        });

        // Function to toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('User_Registration_A_01_val_04_child_01');
            const toggleIcon = document.getElementById('password-toggle');
            if (!passwordInput || !toggleIcon) return;
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
            if (!confirmPasswordInput || !toggleIcon) return;
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

        // Safe helper for requirement indicators
        function updateReqIndicator(id, valid) {
            const el = document.getElementById(id);
            if (!el) return;
            if (valid) {
                el.style.color = '#10b981';
                const icon = el.querySelector('i');
                if (icon) icon.className = 'fas fa-check-circle';
            } else {
                el.style.color = '#94a3b8';
                const icon = el.querySelector('i');
                if (icon) icon.className = 'far fa-circle';
            }
        }

        // Function to check password strength
        function checkPasswordStrength() {
            const passwordInput = document.getElementById('User_Registration_A_01_val_04_child_01');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            if (!passwordInput) return;

            const password = passwordInput.value || '';

            // Check criteria
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasMinLength = password.length >= 8;

            updateReqIndicator('req-length', hasMinLength);
            updateReqIndicator('req-upper', hasUpperCase);
            updateReqIndicator('req-lower', hasLowerCase);
            updateReqIndicator('req-number', hasNumbers);

            // Calculate strength score
            let strength = 0;
            if (hasMinLength) strength++;
            if (hasUpperCase) strength++;
            if (hasLowerCase) strength++;
            if (hasNumbers) strength++;

            if (strengthBar && strengthText) {
                strengthBar.className = 'erp-password-strength__fill';
                if (password.length === 0) {
                    strengthBar.style.width = '0%';
                    strengthText.textContent = 'Password strength';
                    strengthText.style.color = 'var(--erp-text-tertiary)';
                } else if (strength <= 2) {
                    strengthBar.style.width = '33%';
                    strengthBar.style.backgroundColor = '#ef4444';
                    strengthText.textContent = 'Weak password';
                    strengthText.style.color = '#ef4444';
                } else if (strength === 3) {
                    strengthBar.style.width = '66%';
                    strengthBar.style.backgroundColor = '#f59e0b';
                    strengthText.textContent = 'Medium password';
                    strengthText.style.color = '#f59e0b';
                } else {
                    strengthBar.style.width = '100%';
                    strengthBar.style.backgroundColor = '#10b981';
                    strengthText.textContent = 'Strong password';
                    strengthText.style.color = '#10b981';
                }
            }

            checkPasswordMatch();
        }

        // Function to check if passwords match
        function checkPasswordMatch() {
            const passwordInput = document.getElementById('User_Registration_A_01_val_04_child_01');
            const confirmPasswordInput = document.getElementById('User_Registration_A_01_val_04_child_02');
            const matchHint = document.getElementById('password-match-hint');
            if (!passwordInput || !confirmPasswordInput || !matchHint) return;

            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword.length === 0) {
                matchHint.textContent = 'Re-enter your password';
                matchHint.style.color = 'var(--erp-text-tertiary)';
            } else if (password === confirmPassword) {
                matchHint.innerHTML = '<i class="fas fa-check-circle" style="color: #10b981;"></i> Passwords match';
                matchHint.style.color = '#10b981';
            } else {
                matchHint.innerHTML = '<i class="fas fa-circle-exclamation" style="color: #ef4444;"></i> Passwords do not match';
                matchHint.style.color = '#ef4444';
            }
        }
    </script>
