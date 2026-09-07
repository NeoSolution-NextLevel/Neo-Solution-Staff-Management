<!DOCTYPE html>
<html lang="en">
<?php include_once '../../imports/need/session_setup.php' ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Admin Portal | Two-Step Verification</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

            /* Error Colors */
            --erp-error: #e53e3e;
            --erp-error-dark: #c53030;
            --erp-error-light: #fed7d7;

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

        /* ===== ERROR NOTIFICATION ===== */
        .erp-error-notification {
            /*            display: none;  Hidden by default */
            background-color: var(--erp-error-light);
            border: 1px solid var(--erp-error);
            border-radius: var(--erp-radius-md);
            padding: var(--erp-space-sm) var(--erp-space-md);
            margin-top: var(--erp-space-sm);
            color: var(--erp-error-dark);
            font-size: 14px;
            font-weight: 500;
        }

        .erp-error-notification--show {
            display: block;
        }

        .erp-error-notification__icon {
            margin-right: 8px;
            vertical-align: middle;
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

        .erp-form__hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--erp-text-tertiary);
        }

        /* ===== OTP INPUT GROUP ===== */
        .erp-otp-group {
            display: flex;
            justify-content: center;
            gap: var(--erp-space-sm);
            margin-bottom: var(--erp-space-lg);
        }

        .erp-otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            border: 1px solid var(--erp-border);
            border-radius: var(--erp-radius-md);
            background-color: white;
            color: var(--erp-text-primary);
            transition: all 0.2s ease;
        }

        .erp-otp-input:focus {
            outline: none;
            border-color: var(--erp-primary-light);
            box-shadow: 0 0 0 3px var(--erp-primary-subtle);
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

            .erp-otp-group {
                gap: var(--erp-space-xs);
            }

            .erp-otp-input {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }

            body {
                padding: var(--erp-space-sm);
            }
        }
    </style>
</head>

<body>
    <?php
    include_once '../../UxUI-Back/Common/header.php';
    ?>
    <div class="erp-container erp-container--login">
        <div class="erp-login-card">
            <!-- Header Section: Displays company branding and 2FA title -->
            <div class="erp-login-card__header">
                <h1 class="erp-login-card__title">Two-Step Verification</h1>
                <p class="erp-login-card__subtitle">Enter the 6-digit code sent to your device</p>
            </div>

            <!-- Main Body: Contains the OTP input form -->
            <div class="erp-login-card__body">
                <!-- OTP Form: Allows users to enter the 6-digit verification code -->
                <form class="erp-form" method="post" id="otp-form">
                    <div class="erp-form__group">
                        <label class="erp-form__label">Verification Code</label>
                        <div class="erp-otp-group">
                            <input type="text" class="erp-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required aria-label="Digit 1">
                            <input type="text" class="erp-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required aria-label="Digit 2">
                            <input type="text" class="erp-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required aria-label="Digit 3">
                            <input type="text" class="erp-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required aria-label="Digit 4">
                            <input type="text" class="erp-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required aria-label="Digit 5">
                            <input type="text" class="erp-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required aria-label="Digit 6">
                        </div>

                        <!-- Error Notification: Hidden by default, shown when needed -->
                        <!-- <div class="erp-error-notification" id="error-notification">
                            <i class="fas fa-exclamation-circle erp-error-notification__icon"></i>
                            <span id="error-message">Error message will appear here</span>
                        </div> -->

                        <span class="erp-form__hint">Enter the code sent to your registered email or mobile</span>
                    </div>

                    <div class="erp-form__group erp-mt-lg">
                        <button type="submit" class="erp-btn erp-btn--primary erp-btn--block">
                            <i class="fas fa-check"></i>
                            <span>Verify Code</span>
                        </button>
                    </div>

                    <!-- Resend Code Option: Allows users to request a new code -->
                    <div class="erp-text-center erp-mt-md">
                        <p class="erp-text-tertiary erp-text-sm erp-mb-sm">Didn't receive the code?</p>
                        <button type="button" class="erp-btn erp-btn--secondary" id="resend-btn">
                            <i class="fas fa-redo"></i>
                            <span>Resend Code</span>
                        </button>
                    </div>

                    <!-- Back to Login Option: In case of issues -->
                    <div class="erp-text-center erp-mt-xl">
                        <a href="<?php echo $home_page; ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention; ?>" class="erp-link erp-text-sm">Back to Login</a>
                    </div>
                </form>
            </div>

            <!-- Footer: Displays copyright and version info -->
            <div class="erp-login-card__footer">
                <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> Enterprise Resource Planning System v4.2.1</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic year and basic OTP handling 123456-->

    <script>
        function OTP_Two_step_verification_config_functions(otp) {

            const params = new URLSearchParams(window.location.search);
            const Type = params.get("type");

            alert("Type : " + Type);

            if (Type == "Google-Authentication") {
                OTP_Two_step_Verification_A_01_from_01_SUMBIT(otp)

            } else {
                OTP_TWO_step_verification_using_phone(otp);

            }





        }

        function OTP_TWO_step_verification_using_phone(otp) {

            var Sending_value = "val_02=" + encodeURIComponent(otp) +
                "&setting_enable_disable_otp_check=0";

            $.ajax({
                url: "<?php echo $pth; ?>View-List/Main/Two_Factor_Authentication/Two_Factor_Authentication.php",
                type: "POST",
                data: Sending_value,
                success: function(res) {
                    // alert(res);
                    // console.log(res);
                    var json = JSON.parse(res);
                    if (json[0].error === "0") {
                        // alert("varifyed");
                        var sucessMsg = encodeURIComponent("User-Login-Successful");
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;

                    } else {
                        // alert("Error: " + json[0].error);
                        var errorMsg = encodeURIComponent(json[0].message);
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                    }
                }
            });

        }

        function OTP_Two_step_Verification_A_01_from_01_SUMBIT(otp) {
            // The rest of the function is commented out as requested.

            var Sending_value = "auth_code=" + encodeURIComponent(otp);


            $.ajax({
                url: "<?php echo $pth; ?>View-List/Main/Google-Authenticator/Verify_Authenticator.php",
                type: "POST",
                data: Sending_value,
                success: function(res) {
                    alert(res);
                    console.log(res);
                    var json = JSON.parse(res);
                    if (json[0].error === "0") {
                        // alert("varifyed");
                        var sucessMsg = encodeURIComponent("User-Login-Successful");
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Successful-Page<?php echo $online_offline_extention ?>?message=" + sucessMsg;

                    } else {
                        // alert("Error: " + json[0].error);
                        var errorMsg = encodeURIComponent("Authentication-Error");
                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>Failed-Page<?php echo $online_offline_extention ?>?error=" + errorMsg;
                    }
                }
            });

        }

        // Dynamically set the current year in the copyright
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Simple OTP Input Handling
        const otpInputs = document.querySelectorAll('.erp-otp-input');
        const errorNotification = document.getElementById('error-notification');
        const errorMessage = document.getElementById('error-message');
        const otpForm = document.getElementById('otp-form');
        const resendBtn = document.getElementById('resend-btn');

        // Handle OTP input navigation
        otpInputs.forEach((input, index) => {
            // Handle input
            input.addEventListener('input', (e) => {
                // Only allow numbers
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Hide error when user starts typing
                hideError();

                // Auto-focus next input
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            // Handle paste (for better UX) - Enhanced version
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').trim();
                const numbers = pasteData.replace(/[^0-9]/g, '').split('');

                // If exactly 6 digits are pasted, distribute them across all inputs
                if (numbers.length === 6) {
                    numbers.forEach((num, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = num;
                        }
                    });

                    // Focus on last input (6th digit)
                    otpInputs[5].focus();
                }
                // If more than 6 digits, take only first 6
                else if (numbers.length > 6) {
                    const firstSix = numbers.slice(0, 6);
                    firstSix.forEach((num, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = num;
                        }
                    });

                    // Focus on last input (6th digit)
                    otpInputs[5].focus();
                }
                // If less than 6 digits, fill from current input position
                else if (numbers.length > 0) {
                    let currentIndex = index;
                    for (let i = 0; i < numbers.length && currentIndex < otpInputs.length; i++) {
                        otpInputs[currentIndex].value = numbers[i];
                        currentIndex++;
                    }

                    // Focus on the next empty input or last filled one
                    const nextEmptyIndex = Array.from(otpInputs).findIndex(inp => inp.value === '');
                    if (nextEmptyIndex !== -1) {
                        otpInputs[nextEmptyIndex].focus();
                    } else {
                        otpInputs[Math.min(index + numbers.length - 1, 5)].focus();
                    }
                }

                hideError();
            });

            // Handle backspace navigation
            input.addEventListener('keydown', (e) => {
                // If backspace is pressed on empty input, go to previous
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }

                // If delete is pressed, clear current and stay
                if (e.key === 'Delete') {
                    e.target.value = '';
                }

                // Handle arrow key navigation
                if (e.key === 'ArrowLeft' && index > 0) {
                    otpInputs[index - 1].focus();
                    e.preventDefault();
                }

                if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                    e.preventDefault();
                }
            });

            // Handle focus - select all text when focused
            input.addEventListener('focus', (e) => {
                e.target.select();
            });
        });

        // Enhanced paste handler for the entire form (catches paste anywhere)
        otpForm.addEventListener('paste', (e) => {
            // Only handle if the paste is not on an OTP input (already handled)
            if (!e.target.classList.contains('erp-otp-input')) {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').trim();
                const numbers = pasteData.replace(/[^0-9]/g, '').split('');

                // If we have digits to paste
                if (numbers.length > 0) {
                    // Clear all inputs first
                    otpInputs.forEach(input => {
                        input.value = '';
                    });

                    // Fill with pasted numbers (max 6)
                    const digitsToFill = Math.min(numbers.length, 6);
                    for (let i = 0; i < digitsToFill; i++) {
                        otpInputs[i].value = numbers[i];
                    }

                    // Focus appropriate input
                    if (digitsToFill === 6) {
                        otpInputs[5].focus();
                    } else {
                        otpInputs[digitsToFill].focus();
                    }

                    hideError();
                }
            }
        });

        // Error handling functions
        function showError(message) {
            errorMessage.textContent = message;
            errorNotification.style.display = 'block';
            errorNotification.classList.add('erp-error-notification--show');
        }

        function hideError() {
            if (errorNotification.classList.contains('erp-error-notification--show')) {
                errorNotification.style.display = 'none';
                errorNotification.classList.remove('erp-error-notification--show');
            }
        }

        // Function to get complete OTP value
        function getOTPValue() {
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });
            return otp;
        }

        // Form submission handler
        otpForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get OTP value
            const otp = getOTPValue();

            // Validate OTP
            if (otp.length !== 6) {
                showError('Please enter all 6 digits of the verification code.');
                // Focus on first empty input
                const firstEmpty = Array.from(otpInputs).findIndex(input => !input.value);
                if (firstEmpty !== -1) {
                    otpInputs[firstEmpty].focus();
                }
                return;
            }

            // Here you would typically send the OTP to your backend for verification
            console.log('OTP submitted:', otp);

            // Simulate verification - replace with actual API call
            // For demo, show success
            alert('OTP verified successfully! In a real app, this would redirect to dashboard.');
            OTP_Two_step_verification_config_functions(otp);

            // Example error:
            // showError('Invalid verification code. Please try again.');
            // showError('Verification code expired. Please request a new one.');

            // On success, you would redirect or show success message
            // window.location.href = '/dashboard.html';
        });

        // Resend code handler
        resendBtn.addEventListener('click', function() {
            // Here you would call your backend to resend the code
            console.log('Resend code requested');

            // Clear OTP inputs
            otpInputs.forEach(input => {
                input.value = '';
            });

            // Focus on first input
            otpInputs[0].focus();

            // Hide any errors
            hideError();

            // Show success message (temporary)
            const originalText = resendBtn.innerHTML;
            const originalDisabled = resendBtn.disabled;
            resendBtn.innerHTML = '<i class="fas fa-check"></i><span>Code Sent!</span>';
            resendBtn.disabled = true;

            // Reset button after 3 seconds
            setTimeout(() => {
                resendBtn.innerHTML = originalText;
                resendBtn.disabled = originalDisabled;
            }, 3000);
        });

        // Optional: Auto-focus first OTP input on page load
        window.addEventListener('DOMContentLoaded', () => {
            otpInputs[0].focus();
        });

        // Optional: Auto-submit when all 6 digits are entered
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                const otp = getOTPValue();
                if (otp.length === 6) {
                    // Small delay to ensure last digit is captured
                    setTimeout(() => {
                        otpForm.requestSubmit();
                    }, 100);
                }
            });
        });
    </script>
    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>