<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Forgot Password</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== GLOBAL COLOR SYSTEM ===== ---------------------------------------------------colors and spacing*/
        :root {
            /* Primary ERP Brand Colors */
            --erp-primary: #2c5282;
            --erp-primary-dark: #1a365d;
            --erp-primary-light: #4299e1;
            --erp-primary-subtle: #ebf8ff;

            /* Neutral Colors */
            --erp-surface: #ffffff;
            --erp-surface-alt: #f7fafc;
            --erp-border: #e2e8f0;
            --erp-border-dark: #cbd5e0;
            --erp-text-primary: #2d3748;
            --erp-text-secondary: #4a5568;
            --erp-text-tertiary: #718096;

            /* Accent Colors */
            --erp-accent-success: #38a169;
            --erp-accent-warning: #d69e2e;
            --erp-accent-error: #e53e3e;
            --erp-accent-info: #3182ce;

            /* Shadows */
            --erp-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --erp-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --erp-shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1);

            /* Border Radius */
            --erp-radius-sm: 4px;
            --erp-radius-md: 8px;
            --erp-radius-lg: 12px;

            /* Spacing Scale */
            --erp-space-xs: 8px;
            --erp-space-sm: 12px;
            --erp-space-md: 16px;
            --erp-space-lg: 24px;
            --erp-space-xl: 32px;
            --erp-space-2xl: 48px;
        }

        /* ===== BASE RESET & GLOBAL STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #edf2f7 100%);
            color: var(--erp-text-primary);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--erp-space-xl);
        }

        /* ===== LAYOUT CONTAINERS ===== */
        .erp-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--erp-space-md);
            margin-top: 100px;
            margin-bottom: 100px;
        }

        .erp-container--login {
            max-width: 600px;
        }

        /* ===== LOGIN CARD ===== */
        .erp-login-card {
            width: 100%;
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
            min-height: auto;
        }

        .erp-login-card__header {
            background: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            color: white;
            padding: var(--erp-space-xl) var(--erp-space-xl) var(--erp-space-lg);
            text-align: center;
            position: relative;
        }

        .erp-login-card__logo {
            font-size: 40px;
            margin-bottom: var(--erp-space-sm);
            color: white;
        }

        .erp-login-card__title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: var(--erp-space-xs);
        }

        .erp-login-card__subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        .erp-login-card__body {
            padding: var(--erp-space-xl);
        }

        /* ===== FORM COMPONENTS ===== */
        .erp-form {
            width: 100%;
        }

        .erp-form__group {
            margin-bottom: var(--erp-space-lg);
        }

        .erp-form__label {
            display: block;
            margin-bottom: var(--erp-space-xs);
            font-size: 14px;
            font-weight: 500;
            color: var(--erp-text-secondary);
        }

        .erp-form__control {
            width: 100%;
            padding: var(--erp-space-sm) var(--erp-space-md);
            border: 1px solid var(--erp-border);
            border-radius: var(--erp-radius-md);
            font-size: 15px;
            transition: all 0.2s ease;
            background-color: white;
            color: var(--erp-text-primary);
        }

        .erp-form__control:hover {
            border-color: var(--erp-border-dark);
        }

        .erp-form__control:focus {
            outline: none;
            border-color: var(--erp-primary-light);
            box-shadow: 0 0 0 3px var(--erp-primary-subtle);
        }

        .erp-form__control--with-icon {
            padding-left: 44px;
        }

        .erp-form__icon {
            position: absolute;
            left: var(--erp-space-md);
            top: 50%;
            transform: translateY(-50%);
            color: var(--erp-text-tertiary);
            font-size: 16px;
        }

        .erp-form__hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--erp-text-tertiary);
        }

        /* ===== RADIO BUTTON STYLES ===== */
        .erp-radio-group {
            display: flex;
            gap: var(--erp-space-lg);
            margin-bottom: var(--erp-space-lg);
        }

        .erp-radio-item {
            display: flex;
            align-items: center;
            gap: var(--erp-space-sm);
        }

        .erp-radio-item input[type="radio"] {
            margin: 0;
            accent-color: var(--erp-primary);
            /* Custom radio button color */
        }

        .erp-radio-item label {
            font-size: 14px;
            color: var(--erp-text-secondary);
            cursor: pointer;
        }

        /* ===== INPUT WRAPPER ===== */
        .erp-input-wrapper {
            position: relative;
        }

        /* ===== BUTTON SYSTEM ===== */
        .erp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: var(--erp-space-sm) var(--erp-space-md);
            border: none;
            border-radius: var(--erp-radius-md);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 8px;
            height: 44px;
        }

        .erp-btn--primary {
            background-color: var(--erp-primary);
            color: white;
        }

        .erp-btn--primary:hover {
            background-color: var(--erp-primary-dark);
        }

        .erp-btn--primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--erp-primary-subtle);
        }

        .erp-btn--secondary {
            background-color: transparent;
            color: var(--erp-text-secondary);
            border: 1px solid var(--erp-border);
        }

        .erp-btn--secondary:hover {
            background-color: var(--erp-surface-alt);
            border-color: var(--erp-border-dark);
        }

        .erp-btn--block {
            display: flex;
            width: 100%;
        }

        /* ===== UTILITY CLASSES ===== */
        .erp-text-center {
            text-align: center;
        }

        .erp-mt-xs {
            margin-top: var(--erp-space-xs);
        }

        .erp-mt-sm {
            margin-top: var(--erp-space-sm);
        }

        .erp-mt-md {
            margin-top: var(--erp-space-md);
        }

        .erp-mt-lg {
            margin-top: var(--erp-space-lg);
        }

        .erp-mt-xl {
            margin-top: var(--erp-space-xl);
        }

        .erp-mb-xs {
            margin-bottom: var(--erp-space-xs);
        }

        .erp-mb-sm {
            margin-bottom: var(--erp-space-sm);
        }

        .erp-mb-md {
            margin-bottom: var(--erp-space-md);
        }

        .erp-mb-lg {
            margin-bottom: var(--erp-space-lg);
        }

        .erp-mb-xl {
            margin-bottom: var(--erp-space-xl);
        }

        .erp-text-sm {
            font-size: 14px;
        }

        .erp-text-tertiary {
            color: var(--erp-text-tertiary);
        }

        .erp-link {
            color: var(--erp-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .erp-link:hover {
            color: var(--erp-primary-dark);
            text-decoration: underline;
        }

        /* ===== FOOTER ===== */
        .erp-login-card__footer {
            padding: var(--erp-space-lg) var(--erp-space-xl);
            background-color: var(--erp-surface-alt);
            border-top: 1px solid var(--erp-border);
            text-align: center;
        }

        .erp-footer__copyright {
            font-size: 12px;
            color: var(--erp-text-tertiary);
            margin-bottom: var(--erp-space-xs);
        }

        .erp-footer__version {
            font-size: 11px;
            color: var(--erp-text-tertiary);
            opacity: 0.8;
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 640px) {

            .erp-login-card__header,
            .erp-login-card__body {
                padding: var(--erp-space-lg);
            }

            .erp-login-card__footer {
                padding: var(--erp-space-md) var(--erp-space-lg);
            }

            .erp-radio-group {
                flex-direction: column;
                gap: var(--erp-space-sm);
            }

            body {
                padding: var(--erp-space-sm);
            }
        }
    </style>
</head>

<body>
    <?php include_once '../../UxUI-Back/Common/header.php'; ?>
    <div class="erp-container erp-container--login">
        <div class="erp-login-card">
            <!-- Header Section: Displays company branding and reset password title -->
            <div class="erp-login-card__header">
                <h1 class="erp-login-card__title">Forgot Password</h1>
                <p class="erp-login-card__subtitle">Reset your account password securely</p>
            </div>

            <!-- Main Body: Contains the reset password form with method selection -->
            <div class="erp-login-card__body">
                <!-- Reset Password Form: Allows users to select reset method and enter details -->
                <form class="erp-form" method="post" action="#" id="reset-form">
                    <!-- Method Selection: Choose between email or SMS OTP -->
                    <div class="erp-form__group">
                        <label class="erp-form__label">Select Reset Method</label>
                        <div class="erp-radio-group">
                            <div class="erp-radio-item">
                                <input type="radio" id="email-method" name="reset-method" value="email" checked>
                                <label for="email-method">Email</label>
                            </div>
                            <div class="erp-radio-item">
                                <input type="radio" id="sms-method" name="reset-method" value="sms">
                                <label for="sms-method">SMS (OTP)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Email Input: Shown when email method is selected -->
                    <div class="erp-form__group" id="email-group">
                        <label class="erp-form__label">Corporate Email</label>
                        <div class="erp-input-wrapper">
                            <i class="fas fa-envelope erp-form__icon"></i>
                            <input
                                type="email"
                                class="erp-form__control erp-form__control--with-icon"
                                name="email"
                                placeholder="name@company.com"
                                required
                                aria-label="Corporate Email for Password Reset">
                        </div>
                        <span class="erp-form__hint">Enter the email associated with your account</span>
                    </div>

                    <!-- Mobile Input: Shown when SMS method is selected -->
                    <div class="erp-form__group" id="mobile-group" style="display: none;">
                        <label class="erp-form__label">Mobile Number</label>
                        <div class="erp-input-wrapper">
                            <i class="fas fa-mobile-alt erp-form__icon"></i>
                            <input
                                type="tel"
                                class="erp-form__control erp-form__control--with-icon"
                                name="mobile"
                                placeholder="+1 (555) 123-4567"
                                pattern="\+?[0-9\s\-\(\)]+"
                                required
                                aria-label="Mobile Number for OTP Reset">
                        </div>
                        <span class="erp-form__hint">Enter your registered mobile number</span>
                    </div>

                    <div class="erp-form__group erp-mt-lg">
                        <button type="submit" class="erp-btn erp-btn--primary erp-btn--block">
                            <i class="fas fa-paper-plane"></i>
                            <span>Send Reset Code</span>
                        </button>
                    </div>

                    <!-- Success Message Placeholder: Display after form submission (can be handled via JS) -->
                    <div class="erp-text-center erp-mt-md" id="reset-message" style="display: none;">
                        <p class="erp-text-tertiary erp-text-sm">A reset code has been sent to your selected method.</p>
                    </div>

                    <!-- Back to Login Link: Allows users to return to the login page -->
                    <div class="erp-text-center erp-mt-xl">
                        <a href="login.html" class="erp-link erp-text-sm">Back to Login</a>
                    </div>
                </form>
            </div>

            <!-- Footer: Displays copyright and version info -->
            <div class="erp-login-card__footer">
                <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> Enterprise Resource Planning System v4.2.1</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic year, method selection, and form handling -->
    <script>
        // Dynamically set the current year in the copyright
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Function to toggle input fields based on selected method
        function toggleResetMethod() {
            const emailGroup = document.getElementById('email-group');
            const mobileGroup = document.getElementById('mobile-group');
            const emailInput = emailGroup.querySelector('input');
            const mobileInput = mobileGroup.querySelector('input');

            if (document.getElementById('email-method').checked) {
                emailGroup.style.display = 'block';
                mobileGroup.style.display = 'none';
                emailInput.required = true;
                mobileInput.required = false;
            } else {
                emailGroup.style.display = 'none';
                mobileGroup.style.display = 'block';
                emailInput.required = false;
                mobileInput.required = true;
            }
        }

        // Add event listeners to radio buttons
        document.getElementById('email-method').addEventListener('change', toggleResetMethod);
        document.getElementById('sms-method').addEventListener('change', toggleResetMethod);

        // Optional: Handle form submission (e.g., show message)
        document.getElementById('reset-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent actual submission for demo
            document.getElementById('reset-message').style.display = 'block';
        });
    </script>
    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>