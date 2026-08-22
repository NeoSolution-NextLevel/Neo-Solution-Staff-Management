<div class="erp-container erp-container--login">
    <div class="erp-login-card">
        <!-- Header Section: Displays company branding and change password title -->
        <div class="erp-login-card__header">
            <div class="erp-login-card__brand">
                <svg viewBox="0 0 280 100" width="190" height="64" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="cpBlueSphere" cx="32%" cy="30%" r="68%">
                            <stop offset="0%" stop-color="#7399f7"/>
                            <stop offset="25%" stop-color="#2b4db3"/>
                            <stop offset="60%" stop-color="#142668"/>
                            <stop offset="90%" stop-color="#091338"/>
                            <stop offset="100%" stop-color="#04091c"/>
                        </radialGradient>
                        <radialGradient id="cpGreenSphere" cx="32%" cy="30%" r="68%">
                            <stop offset="0%" stop-color="#5ec95e"/>
                            <stop offset="25%" stop-color="#238029"/>
                            <stop offset="60%" stop-color="#125219"/>
                            <stop offset="90%" stop-color="#0a3310"/>
                            <stop offset="100%" stop-color="#041a08"/>
                        </radialGradient>
                        <linearGradient id="cpSpecularGlow" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#ffffff" stop-opacity="0.6"/>
                            <stop offset="40%" stop-color="#ffffff" stop-opacity="0.1"/>
                            <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
                        </linearGradient>
                        <filter id="cpSphereShadow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="1.5" dy="2.5" stdDeviation="2" flood-color="#0a1535" flood-opacity="0.3"/>
                        </filter>
                    </defs>
                    <g transform="translate(6, 4)" filter="url(#cpSphereShadow)">
                        <circle cx="28" cy="28" r="17" fill="url(#cpBlueSphere)"/>
                        <ellipse cx="23" cy="23" rx="7" ry="4" fill="url(#cpSpecularGlow)" transform="rotate(-30 23 23)"/>
                        <circle cx="62" cy="38" r="16" fill="url(#cpGreenSphere)"/>
                        <ellipse cx="57" cy="33" rx="6" ry="3.5" fill="url(#cpSpecularGlow)" transform="rotate(-30 57 33)"/>
                        <circle cx="30" cy="62" r="16" fill="url(#cpGreenSphere)"/>
                        <ellipse cx="25" cy="57" rx="6" ry="3.5" fill="url(#cpSpecularGlow)" transform="rotate(-30 25 57)"/>
                        <circle cx="62" cy="72" r="17" fill="url(#cpBlueSphere)"/>
                        <ellipse cx="57" cy="67" rx="7" ry="4" fill="url(#cpSpecularGlow)" transform="rotate(-30 57 67)"/>
                    </g>
                    <text x="96" y="58" font-family="'Impact', 'Arial Black', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="58" font-weight="900" letter-spacing="2.5" fill="#ffffff">NEO</text>
                    <text x="130" y="84" font-family="'Playfair Display', 'Georgia', 'Times New Roman', serif" font-size="28" font-style="italic" font-weight="600" letter-spacing="0.5" fill="#dbeafe">Solution</text>
                </svg>
            </div>
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