<div class="erp-container erp-container--login">
    <div class="erp-login-card">
        <!-- Header Section: Displays company branding and change password title -->
        <div class="erp-login-card__header">
            <h1 class="erp-login-card__title">Change Password</h1>
            <p class="erp-login-card__subtitle">Update your account password securely</p>
        </div>

        <!-- Main Body: Contains the change password form -->
        <div class="erp-login-card__body">
            <!-- Change Password Form: Allows users to update their password -->
            <form class="erp-form" method="post" action="#" id="change-password-form">
                <div class="erp-form__group">
                    <label class="erp-form__label">Current Password</label>
                    <div class="erp-input-wrapper">
                        <i class="fas fa-lock erp-form__icon"></i>
                        <input
                            type="password"
                            class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                            name="current-password"
                            placeholder="••••••••"
                            required
                            id="current-password"
                            aria-label="Current Password">
                        <!-- Password Toggle: Click to show/hide current password -->
                        <i class="fas fa-eye erp-form__toggle" id="current-toggle" onclick="togglePassword('current-password', 'current-toggle')" aria-label="Toggle current password visibility"></i>
                    </div>
                    <span class="erp-form__hint">Enter your existing password</span>
                </div>

                <div class="erp-form__group">
                    <label class="erp-form__label">New Password</label>
                    <div class="erp-input-wrapper">
                        <i class="fas fa-key erp-form__icon"></i>
                        <input
                            type="password"
                            class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                            name="new-password"
                            placeholder="••••••••"
                            required
                            id="new-password"
                            aria-label="New Password">
                        <!-- Password Toggle: Click to show/hide new password -->
                        <i class="fas fa-eye erp-form__toggle" id="new-toggle" onclick="togglePassword('new-password', 'new-toggle')" aria-label="Toggle new password visibility"></i>
                    </div>
                    <span class="erp-form__hint">Minimum 8 characters with mixed case, numbers & symbols</span>
                </div>

                <div class="erp-form__group">
                    <label class="erp-form__label">Confirm New Password</label>
                    <div class="erp-input-wrapper">
                        <i class="fas fa-check-circle erp-form__icon"></i>
                        <input
                            type="password"
                            class="erp-form__control erp-form__control--with-icon erp-form__control--with-toggle"
                            name="confirm-password"
                            placeholder="••••••••"
                            required
                            id="confirm-password"
                            aria-label="Confirm New Password">
                        <!-- Password Toggle: Click to show/hide confirm password -->
                        <i class="fas fa-eye erp-form__toggle" id="confirm-toggle" onclick="togglePassword('confirm-password', 'confirm-toggle')" aria-label="Toggle confirm password visibility"></i>
                    </div>
                    <span class="erp-form__hint">Re-enter your new password to confirm</span>
                </div>

                <div class="erp-form__group erp-mt-lg">
                    <button type="submit" class="erp-btn erp-btn--primary erp-btn--block">
                        <i class="fas fa-save"></i>
                        <span>Update Password</span>
                    </button>
                </div>

                <!-- Error Message Placeholder: Display if passwords don't match (can be handled via JS) -->
                <div class="erp-text-center erp-mt-md" id="error-message" style="display: none; color: var(--erp-accent-error);">
                    <p class="erp-text-sm">Passwords do not match. Please try again.</p>
                </div>

                <!-- Back to Dashboard Link: Allows users to return without changing -->
                <div class="erp-text-center erp-mt-xl">
                    <a href="dashboard.html" class="erp-link erp-text-sm">Back to Dashboard</a>
                </div>
            </form>
        </div>

        <!-- Footer: Displays copyright and version info -->
        <div class="erp-login-card__footer">
            <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> Enterprise Resource Planning System v4.2.1</p>
        </div>
    </div>
</div>