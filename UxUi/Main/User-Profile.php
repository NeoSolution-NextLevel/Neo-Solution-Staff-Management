<!DOCTYPE html>
<html lang="en">
<?php
include_once '../../imports/need/session_setup.php'
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | User Profile</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php
    include_once '../../imports/Company_Info/Company_Info_Variable_List.php';

    $company_obj = new Company_Info_Variable_List();
    ?>
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
            --erp-radius-full: 9999px;

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

        .erp-container--profile {
            max-width: 1000px;
            padding-top: 30px;
            padding-bottom: 50px;
        }

        /* ===== PROFILE CARD ===== */
        .erp-profile-card {
            width: 100%;
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
            margin-bottom: var(--erp-space-xl);
        }

        .erp-profile-card__header {
            background: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            color: white;
            padding: var(--erp-space-xl) var(--erp-space-xl) var(--erp-space-lg);
            position: relative;
            min-height: 180px;
        }

        .erp-profile-card__title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: var(--erp-space-xs);
        }

        .erp-profile-card__subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 400;
        }

        .erp-profile-card__body {
            padding: var(--erp-space-xl);
        }

        /* ===== PROFILE HEADER CONTENT ===== */
        .erp-profile-header {
            display: flex;
            align-items: flex-start;
            gap: var(--erp-space-xl);
            margin-bottom: var(--erp-space-xl);
        }

        /* ===== PROFILE PICTURE SECTION ===== */
        .erp-profile-picture {
            position: relative;
            flex-shrink: 0;
        }

        /* .erp-profile-picture__wrapper {
            position: relative;
            width: 160px;
            height: 160px;
            border-radius: var(--erp-radius-full);
            border: 5px solid white;
            box-shadow: var(--erp-shadow-md);
            overflow: hidden;
            background-color: var(--erp-surface-alt);
        } */

        .erp-profile-picture__wrapper {
            width: 96px;
            height: 96px;
            position: relative;
        }

        /* .erp-profile-picture__img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        } */

        .erp-profile-picture__img {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }


        /* .erp-profile-picture__default {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--erp-primary-light);
            color: white;
            font-size: 60px;
        } */

        .erp-profile-picture__default {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(90deg,
                    var(--erp-primary) 0%,
                    var(--erp-primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .erp-profile-picture__upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: var(--erp-primary);
            color: white;
            border-radius: var(--erp-radius-full);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
            transition: background-color 0.2s;
        }

        .erp-profile-picture__upload:hover {
            background-color: var(--erp-primary-dark);
        }

        .erp-profile-picture__upload-input {
            display: none;
        }

        /* ===== PROFILE INFO SECTION ===== */
        .erp-profile-info {
            flex: 1;
        }

        .erp-profile-info__name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: var(--erp-space-xs);
            color: var(--erp-text-primary);
        }

        .erp-profile-info__role {
            font-size: 18px;
            color: var(--erp-primary);
            font-weight: 600;
            margin-bottom: var(--erp-space-sm);
        }

        .erp-profile-info__meta {
            display: flex;
            flex-wrap: wrap;
            gap: var(--erp-space-md);
            margin-bottom: var(--erp-space-md);
        }

        .erp-profile-info__meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--erp-text-secondary);
        }

        .erp-profile-info__meta-icon {
            color: var(--erp-primary-light);
        }

        .erp-profile-info__bio {
            color: var(--erp-text-secondary);
            line-height: 1.6;
            margin-top: var(--erp-space-md);
        }

        /* ===== FORM COMPONENTS ===== */
        .erp-form {
            width: 100%;
        }

        .erp-form__section {
            margin-bottom: var(--erp-space-2xl);
        }

        .erp-form__section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--erp-text-primary);
            padding-bottom: var(--erp-space-sm);
            margin-bottom: var(--erp-space-lg);
            border-bottom: 1px solid var(--erp-border);
        }

        .erp-form__grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--erp-space-lg);
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
            background-color: white;
            color: var(--erp-text-secondary);
            border: 1px solid var(--erp-border);
        }

        .erp-btn--secondary:hover {
            background-color: var(--erp-surface-alt);
            border-color: var(--erp-border-dark);
        }

        .erp-btn--success {
            background-color: var(--erp-accent-success);
            color: white;
        }

        .erp-btn--success:hover {
            background-color: #2f855a;
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

        .erp-btn--block {
            display: flex;
            width: 100%;
        }

        /* ===== SECURITY SECTION ===== */
        .erp-security-settings {
            background-color: var(--erp-surface-alt);
            border-radius: var(--erp-radius-md);
            padding: var(--erp-space-lg);
            margin-top: var(--erp-space-xl);
        }

        .erp-security-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--erp-space-md) 0;
            border-bottom: 1px solid var(--erp-border);
        }

        .erp-security-item:last-child {
            border-bottom: none;
        }

        .erp-security-item__info {
            flex: 1;
        }

        .erp-security-item__title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .erp-security-item__description {
            font-size: 14px;
            color: var(--erp-text-tertiary);
        }

        .erp-security-item__status {
            display: flex;
            align-items: center;
            gap: var(--erp-space-sm);
        }

        .erp-status-badge {
            padding: 4px 10px;
            border-radius: var(--erp-radius-full);
            font-size: 12px;
            font-weight: 600;
        }

        .erp-status-badge--enabled {
            background-color: rgba(56, 161, 105, 0.1);
            color: var(--erp-accent-success);
        }

        .erp-status-badge--disabled {
            background-color: rgba(229, 62, 62, 0.1);
            color: var(--erp-accent-error);
        }

        /* ===== NOTIFICATION SETTINGS ===== */
        .erp-notification-settings {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--erp-space-md);
        }

        .erp-notification-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--erp-space-sm);
            border: 1px solid var(--erp-border);
            border-radius: var(--erp-radius-md);
            transition: border-color 0.2s;
        }

        .erp-notification-item:hover {
            border-color: var(--erp-border-dark);
        }

        .erp-notification-item__info {
            display: flex;
            align-items: center;
            gap: var(--erp-space-sm);
        }

        /* ===== SWITCH TOGGLE ===== */
        .erp-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .erp-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .erp-switch__slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--erp-border);
            transition: .3s;
            border-radius: 34px;
        }

        .erp-switch__slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        .erp-switch input:checked+.erp-switch__slider {
            background-color: var(--erp-accent-success);
        }

        .erp-switch input:checked+.erp-switch__slider:before {
            transform: translateX(24px);
        }

        /* ===== ACTION BUTTONS ===== */
        .erp-profile-actions {
            display: flex;
            justify-content: flex-end;
            gap: var(--erp-space-md);
            margin-top: var(--erp-space-xl);
            padding-top: var(--erp-space-lg);
            border-top: 1px solid var(--erp-border);
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

        .erp-mt-2xl {
            margin-top: var(--erp-space-2xl);
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
        .erp-profile-card__footer {
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


        /* DEFAULT USER ICON (ROUND) */
        .erp-profile-picture__default {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            /* light gray */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .erp-profile-picture__default i {
            font-size: 36px;
            color: #6b7280;
        }

        /* Camera button */
        .erp-profile-picture__upload {
            margin-top: 8px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #111827;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 768px) {
            .erp-profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: var(--erp-space-lg);
            }

            .erp-profile-info__meta {
                justify-content: center;
            }

            .erp-form__grid {
                grid-template-columns: 1fr;
                gap: var(--erp-space-md);
            }

            .erp-notification-settings {
                grid-template-columns: 1fr;
            }

            .erp-profile-actions {
                flex-direction: column;
            }

            .erp-btn--block-mobile {
                width: 100%;
            }
        }

        @media (max-width: 640px) {

            .erp-profile-card__header,
            .erp-profile-card__body {
                padding: var(--erp-space-lg);
            }

            .erp-profile-card__footer {
                padding: var(--erp-space-md) var(--erp-space-lg);
            }

            /* .erp-profile-picture__wrapper {
                width: 140px;
                height: 140px;
            } */



            .erp-profile-picture__wrapper {
                width: 96px;
                height: 96px;
                position: relative;
            }


            .erp-profile-info__name {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <script>
        // Run after DOM is loaded
        document.addEventListener("DOMContentLoaded", function() {
            User_Profile_Page_icone_header_function();
            User_Profile_A_01_single_main_user_login_SET_DB();

        });
    </script>

    <?php include_once '../../UxUI-Back/Common/header.php'; ?>

    <input type="hidden" id="check_user_profile_page_val_01" value="0">

    <?php
    include_once '../../UxUI-Back/Main/User_profile/User-Profile.php';
    include_once '../../UxUI-Back/Main/User_profile/JS/User-Profile_JS.php';
    ?>


    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>