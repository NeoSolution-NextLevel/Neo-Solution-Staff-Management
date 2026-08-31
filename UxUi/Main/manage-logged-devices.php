<?php
include_once '../../imports/need/session_setup.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Linked Devices</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php
    include_once '../../imports/Company_Info/Company_Info_Variable_List.php';

    $company_obj = new Company_Info_Variable_List();
    ?>
    <style>
        /* ===== GLOBAL COLOR SYSTEM ===== */
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
        }

        /* ===== LAYOUT CONTAINERS ===== */
        .erp-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--erp-space-xl);
            margin-top: 100px;
            margin-bottom: 100px;
        }

        /* ===== DASHBOARD CARD ===== */
        .erp-dashboard-card {
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
            margin-bottom: var(--erp-space-xl);
        }

        .erp-dashboard-card__header {
            background: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            color: white;
            padding: var(--erp-space-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .erp-dashboard-card__title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: var(--erp-space-xs);
        }

        .erp-dashboard-card__subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        .erp-dashboard-card__body {
            padding: var(--erp-space-xl);
        }

        /* ===== SECURITY ALERT BANNER ===== */
        .erp-security-alert {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: var(--erp-radius-md);
            padding: var(--erp-space-md);
            margin-bottom: var(--erp-space-xl);
            display: flex;
            align-items: center;
            gap: var(--erp-space-md);
        }

        .erp-security-alert__icon {
            color: var(--erp-accent-warning);
            font-size: 20px;
        }

        .erp-security-alert__content {
            flex: 1;
        }

        .erp-security-alert__title {
            font-weight: 600;
            color: #856404;
            margin-bottom: 4px;
        }

        .erp-security-alert__text {
            color: #856404;
            font-size: 14px;
        }

        /* ===== DEVICES LIST ===== */
        .erp-devices-list {
            display: flex;
            flex-direction: column;
            gap: var(--erp-space-md);
        }

        .erp-device-card {
            border: 1px solid var(--erp-border);
            border-radius: var(--erp-radius-md);
            padding: var(--erp-space-md);
            display: flex;
            align-items: center;
            gap: var(--erp-space-md);
            transition: all 0.2s ease;
            background-color: white;
        }

        .erp-device-card:hover {
            border-color: var(--erp-primary-light);
            box-shadow: var(--erp-shadow-sm);
        }

        .erp-device-card--current {
            border-color: var(--erp-primary);
            background-color: var(--erp-primary-subtle);
        }

        .erp-device-card__icon {
            width: 48px;
            height: 48px;
            background-color: var(--erp-surface-alt);
            border-radius: var(--erp-radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--erp-text-secondary);
        }

        .erp-device-card--current .erp-device-card__icon {
            background-color: var(--erp-primary);
            color: white;
        }

        .erp-device-card__content {
            flex: 1;
        }

        .erp-device-card__title {
            font-weight: 600;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: var(--erp-space-xs);
        }

        .erp-device-card__badge {
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            background-color: var(--erp-accent-success);
            color: white;
        }

        .erp-device-card__details {
            font-size: 14px;
            color: var(--erp-text-secondary);
            margin-bottom: 4px;
        }

        .erp-device-card__time {
            font-size: 12px;
            color: var(--erp-text-tertiary);
        }

        .erp-device-card__actions {
            display: flex;
            gap: var(--erp-space-sm);
        }

        /* ===== BUTTON SYSTEM ===== */
        .erp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: var(--erp-space-sm) var(--erp-space-md);
            border: none;
            border-radius: var(--erp-radius-md);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 6px;
            height: 36px;
        }

        .erp-btn--primary {
            background-color: var(--erp-primary);
            color: white;
        }

        .erp-btn--primary:hover {
            background-color: var(--erp-primary-dark);
        }

        .erp-btn--danger {
            background-color: var(--erp-accent-error);
            color: white;
        }

        .erp-btn--danger:hover {
            background-color: #c53030;
        }

        .erp-btn--outline {
            background-color: transparent;
            color: var(--erp-text-secondary);
            border: 1px solid var(--erp-border);
        }

        .erp-btn--outline:hover {
            background-color: var(--erp-surface-alt);
            border-color: var(--erp-border-dark);
        }

        .erp-btn--danger-outline {
            background-color: transparent;
            color: var(--erp-accent-error);
            border: 1px solid var(--erp-accent-error);
        }

        .erp-btn--danger-outline:hover {
            background-color: #fff5f5;
        }

        /* ===== MODAL DIALOG ===== */
        .erp-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: var(--erp-space-md);
        }

        .erp-modal--active {
            display: flex;
        }

        .erp-modal__content {
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }

        .erp-modal__header {
            padding: var(--erp-space-lg);
            border-bottom: 1px solid var(--erp-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .erp-modal__title {
            font-size: 18px;
            font-weight: 600;
            color: var(--erp-text-primary);
        }

        .erp-modal__close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--erp-text-tertiary);
            cursor: pointer;
            padding: 4px;
        }

        .erp-modal__close:hover {
            color: var(--erp-text-secondary);
        }

        .erp-modal__body {
            padding: var(--erp-space-lg);
        }

        .erp-modal__footer {
            padding: var(--erp-space-lg);
            border-top: 1px solid var(--erp-border);
            display: flex;
            justify-content: flex-end;
            gap: var(--erp-space-sm);
        }

        /* ===== ACTION BAR ===== */
        .erp-action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--erp-space-xl);
            padding: var(--erp-space-md);
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-md);
            box-shadow: var(--erp-shadow-sm);
        }

        .erp-action-bar__info {
            display: flex;
            align-items: center;
            gap: var(--erp-space-md);
        }

        .erp-action-bar__count {
            font-weight: 600;
            color: var(--erp-primary);
        }

        /* ===== EMPTY STATE ===== */
        .erp-empty-state {
            text-align: center;
            padding: var(--erp-space-2xl) var(--erp-space-xl);
            color: var(--erp-text-tertiary);
        }

        .erp-empty-state__icon {
            font-size: 48px;
            margin-bottom: var(--erp-space-md);
            color: var(--erp-border-dark);
        }

        .erp-empty-state__title {
            font-size: 18px;
            margin-bottom: var(--erp-space-xs);
            color: var(--erp-text-secondary);
        }

        .erp-empty-state__text {
            font-size: 14px;
            margin-bottom: var(--erp-space-lg);
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

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 768px) {
            .erp-container {
                padding: var(--erp-space-md);
            }

            .erp-dashboard-card__header,
            .erp-dashboard-card__body {
                padding: var(--erp-space-lg);
            }

            .erp-device-card {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--erp-space-sm);
            }

            .erp-device-card__actions {
                width: 100%;
                justify-content: flex-end;
            }

            .erp-action-bar {
                flex-direction: column;
                gap: var(--erp-space-md);
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <script>
        // Run after DOM is loaded
        document.addEventListener("DOMContentLoaded", function() {

            main_user_login_device_SET_DB();

        });
    </script>


    <?php include_once '../../UxUI-Back/Common/header.php'; ?>

    <?php
    include_once '../../UxUI-Back/Main/manage-logged-devices/manage_logged_devices.php';
    include_once '../../UxUI-Back/Main/manage-logged-devices/JS/manage_logged_devices_JS.php';
    ?>


    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>