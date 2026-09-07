<!DOCTYPE html>
<?php
include_once '../../imports/need/session_setup.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Registration</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== GLOBAL COLOR SYSTEM ===== ------------------*/
        :root {
           
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

            /* Social Brand Colors */
            --erp-google: #db4437;
            --erp-microsoft: #00a4ef;
            --erp-facebook: #1877f2;

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
            /*            margin: 0 auto;*/
            padding: 0 var(--erp-space-md);
            margin-top: 100px;
            margin-bottom: 100px;
        }

        .erp-container--registration {
            max-width: 800px;
        }

        /* ===== REGISTRATION CARD ===== */
        .erp-registration-card {
            width: 100%;
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
            min-height: auto;
        }

        .erp-registration-card__header {
            background: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            color: white;
            padding: var(--erp-space-xl) var(--erp-space-xl) var(--erp-space-lg);
            text-align: center;
            position: relative;
        }

        .erp-registration-card__logo {
            font-size: 40px;
            margin-bottom: var(--erp-space-sm);
            color: white;
        }

        .erp-registration-card__title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: var(--erp-space-xs);
        }

        .erp-registration-card__subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        .erp-registration-card__body {
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

        .erp-form__control--with-toggle {
            padding-right: 44px;
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

        .erp-form__hint--valid {
            color: var(--erp-accent-success);
        }

        .erp-form__hint--invalid {
            color: var(--erp-accent-error);
        }

        /* ===== INPUT WRAPPER ===== */
        .erp-input-wrapper {
            position: relative;
        }

        /* ===== FORM GRID ===== */
        .erp-form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--erp-space-md);
        }

        /* ===== PASSWORD STRENGTH INDICATOR ===== */
        .erp-password-strength {
            margin-top: var(--erp-space-xs);
        }

        .erp-password-strength__bar {
            height: 4px;
            background-color: var(--erp-border);
            border-radius: 2px;
            margin-bottom: 6px;
            overflow: hidden;
        }

        .erp-password-strength__fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 2px;
        }

        .erp-password-strength__fill--weak {
            background-color: var(--erp-accent-error);
            width: 33%;
        }

        .erp-password-strength__fill--fair {
            background-color: var(--erp-accent-warning);
            width: 66%;
        }

        .erp-password-strength__fill--strong {
            background-color: var(--erp-accent-success);
            width: 100%;
        }

        .erp-password-strength__text {
            font-size: 12px;
            color: var(--erp-text-tertiary);
        }

        /* ===== TERMS & CONDITIONS ===== */
        .erp-terms {
            display: flex;
            align-items: flex-start;
            gap: var(--erp-space-sm);
            margin-bottom: var(--erp-space-lg);
        }

        .erp-terms__checkbox {
            margin-top: 2px;
            accent-color: var(--erp-primary);
        }

        .erp-terms__label {
            font-size: 14px;
            color: var(--erp-text-secondary);
            line-height: 1.4;
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
        .erp-registration-card__footer {
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
        @media (max-width: 768px) {
            .erp-form-grid {
                grid-template-columns: 1fr;
                gap: var(--erp-space-sm);
            }

            .erp-registration-card__header,
            .erp-registration-card__body {
                padding: var(--erp-space-lg);
            }

            .erp-registration-card__footer {
                padding: var(--erp-space-md) var(--erp-space-lg);
            }

            body {
                padding: var(--erp-space-sm);
            }
        }

        @media (max-width: 640px) {
            .erp-container--registration {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php
    include_once '../../UxUI-Back/Common/header.php';
    include_once '../../imports/Company_Info/Company_Info_Variable_List.php';

    $company_obj = new Company_Info_Variable_List();
    ?>

    <!-- content  -->
    <?php

    include_once '../../UxUI-Back/Main/Main_User_Account_Create/JS/User_Registration_A_01_JS.php';
    include_once '../../UxUI-Back/Main/Main_User_Account_Create/User_Registration_A_01.php';

    ?>

    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>