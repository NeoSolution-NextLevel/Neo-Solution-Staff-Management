    <?php
    include_once '../../imports/need/session_setup.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Portal | Login</title>
        <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>



        <style>
            /* ===== GLOBAL COLOR SYSTEM ===== */
            :root {
                /* Website Theme Colors */
                --navy: #14204d;
                --navy-2: #1c2b63;
                --blue: #3b5bdb;
                --blue-light: #dbe4ff;
                --blue-lighter: #eef2ff;
                --green: #12b76a;
                --green-bg: #e3f9ee;
                --amber: #f5a623;
                --amber-bg: #fdf1dc;
                --red: #f0576a;
                --red-bg: #fde8ec;
                --ink: #1a1f36;
                --muted: #6b7280;
                --border: #e8eaf0;
                --bg: #f5f6fa;
                --card: #ffffff;
                --radius: 16px;
                --shadow: 0 1px 3px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.06);

                /* Primary ERP Brand Colors */
                --erp-primary: var(--blue);
                --erp-primary-dark: var(--navy);
                --erp-primary-light: var(--blue-light);
                --erp-primary-subtle: var(--blue-lighter);

                /* Neutral Colors */
                --erp-surface: #ffffff;
                --erp-surface-alt: #fafbfd;
                --erp-border: #e8eaf0;
                --erp-border-dark: #cbd5e1;
                --erp-text-primary: #1a1f36;
                --erp-text-secondary: #4a5568;
                --erp-text-tertiary: #6b7280;

                /* Accent Colors */
                --erp-accent-success: #12b76a;
                --erp-accent-warning: #f5a623;
                --erp-accent-error: #f0576a;
                --erp-accent-info: #3b5bdb;

                /* Social Brand Colors */
                --erp-google: #ea4335;
                --erp-microsoft: #00a4ef;
                --erp-facebook: #1877f2;

                /* Shadows */
                --erp-shadow-sm: 0 1px 3px rgba(20, 25, 60, 0.05);
                --erp-shadow-md: 0 4px 12px rgba(20, 25, 60, 0.08);
                --erp-shadow-lg: 0 12px 32px rgba(20, 25, 60, 0.08);

                /* Border Radius */
                --erp-radius-sm: 6px;
                --erp-radius-md: 10px;
                --erp-radius-lg: 16px;

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
                font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
                background: radial-gradient(at 0% 0%, rgba(59, 91, 219, 0.07) 0px, transparent 50%),
                            radial-gradient(at 100% 100%, rgba(20, 32, 77, 0.07) 0px, transparent 50%),
                            var(--bg);
                color: var(--erp-text-primary);
                line-height: 1.5;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: var(--erp-space-xl) var(--erp-space-md);
            }

            /* ===== LAYOUT CONTAINERS ===== */
            .erp-container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 var(--erp-space-md);
            }

            .erp-container--login {
                max-width: 520px;
            }

            /* ===== LOGIN CARD ===== */
            .erp-login-card {
                width: 100%;
                background-color: var(--erp-surface);
                border-radius: var(--erp-radius-lg);
                box-shadow: var(--erp-shadow-lg);
                border: 1px solid var(--erp-border);
                overflow: hidden;
            }

            .erp-login-card__header {
                background: linear-gradient(135deg, var(--navy) 0%, var(--navy-2) 55%, #3648a0 100%);
                color: white;
                padding: 28px 24px 22px;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .erp-login-card__header::before {
                content: "";
                position: absolute;
                top: -60px; right: -40px;
                width: 200px; height: 200px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%);
            }

            .erp-login-card__brand {
                display: flex;
                justify-content: center;
                margin-bottom: 12px;
                position: relative;
            }

            .erp-login-card__title {
                font-size: 22px;
                font-weight: 800;
                margin-bottom: 4px;
                letter-spacing: -0.3px;
                position: relative;
            }

            .erp-login-card__subtitle {
                font-size: 13.5px;
                color: #c7d0f5;
                font-weight: 500;
                position: relative;
            }

            .erp-login-card__body {
                padding: 28px 30px;
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

            .erp-form__control--with-toggle {
                padding-right: 44px;
                /* Adjusted for toggle icon */
            }

            .erp-form__icon {
                position: absolute;
                left: var(--erp-space-md);
                top: 50%;
                transform: translateY(-50%);
                color: var(--erp-text-tertiary);
                font-size: 16px;
            }

            .erp-form__toggle {
                position: absolute;
                right: var(--erp-space-md);
                top: 50%;
                transform: translateY(-50%);
                color: var(--erp-text-tertiary);
                font-size: 16px;
                cursor: pointer;
                transition: color 0.2s;
            }

            .erp-form__toggle:hover {
                color: var(--erp-text-secondary);
            }

            .erp-form__hint {
                display: block;
                margin-top: 6px;
                font-size: 12px;
                color: var(--erp-text-tertiary);
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

            .erp-btn--google {
                background-color: white;
                color: var(--erp-text-primary);
                border: 1px solid var(--erp-border);
            }

            .erp-btn--google:hover {
                background-color: var(--erp-surface-alt);
                border-color: var(--erp-google);
            }

            .erp-btn--microsoft {
                background-color: white;
                color: var(--erp-text-primary);
                border: 1px solid var(--erp-border);
            }

            .erp-btn--microsoft:hover {
                background-color: var(--erp-surface-alt);
                border-color: var(--erp-microsoft);
            }

            .erp-btn--facebook {
                background-color: white;
                color: var(--erp-text-primary);
                border: 1px solid var(--erp-border);
            }

            .erp-btn--facebook:hover {
                background-color: var(--erp-surface-alt);
                border-color: var(--erp-facebook);
            }

            .erp-btn--block {
                display: flex;
                width: 100%;
            }

            /* ===== SOCIAL LOGIN GRID ===== */
            .erp-social-login {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: var(--erp-space-sm);
                margin-bottom: var(--erp-space-xl);
            }

            .erp-social-login__item {
                text-align: center;
            }

            .erp-social-login__icon {
                font-size: 18px;
            }

            .erp-social-login__icon--google {
                color: var(--erp-google);
            }

            .erp-social-login__icon--microsoft {
                color: var(--erp-microsoft);
            }

            .erp-social-login__icon--facebook {
                color: var(--erp-facebook);
            }

            /* ===== DIVIDER ===== */
            .erp-divider {
                display: flex;
                align-items: center;
                margin: var(--erp-space-lg) 0;
            }

            .erp-divider__line {
                flex: 1;
                height: 1px;
                background-color: var(--erp-border);
            }

            .erp-divider__text {
                padding: 0 var(--erp-space-md);
                color: var(--erp-text-tertiary);
                font-size: 14px;
                font-weight: 500;
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

                .erp-social-login {
                    grid-template-columns: 1fr;
                    gap: var(--erp-space-xs);
                }

                body {
                    padding: var(--erp-space-sm);
                }
            }
        </style>
    </head>

    <body>

        <!-- DB included part  -->
        <?php
        include_once '../../imports/Company_Info/Company_Info_Variable_List.php';
        include_once '../../View-List/Main/Google-Login/Main_User_Google_Login_Config.php';
        include_once '../../View-List/Main/Microsoft-Login/Main_User_Microsoft_Login_Config.php';
        ?>

        <?php
        include_once '../../UxUI-Back/Main/Main_User_Login/JS/User_Login_A_01_JS.php';
        include_once '../../UxUI-Back/Main/Main_User_Login/User_Login_A_01.php';
        ?>
    </body>

    </html>