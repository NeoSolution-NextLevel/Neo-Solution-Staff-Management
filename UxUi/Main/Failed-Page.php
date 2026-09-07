<!DOCTYPE html>
<html lang="en">
<?php
include_once '../../imports/need/session_setup.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <title>ERP Admin Portal | Operation Failed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

            /* Error Colors */
            --erp-error-light: #fed7d7;
            --erp-error-medium: #fc8181;
            --erp-error-dark: #e53e3e;
            --erp-error-darker: #c53030;
            --erp-error-glow: rgba(229, 62, 62, 0.3);

            /* Warning Colors */
            --erp-warning-light: #feebc8;
            --erp-warning-dark: #d69e2e;

            /* Accent Colors */
            --erp-accent-success: #38a169;
            --erp-accent-warning: #d69e2e;
            --erp-accent-error: #e53e3e;
            --erp-accent-info: #3182ce;

            /* Shadows */
            --erp-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --erp-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --erp-shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --erp-shadow-error: 0 0 20px rgba(229, 62, 62, 0.2);

            /* Border Radius */
            --erp-radius-sm: 4px;
            --erp-radius-md: 8px;
            --erp-radius-lg: 12px;
            --erp-radius-full: 50%;

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
            background: linear-gradient(135deg, #fdf2f2 0%, #fed7d7 100%);
            color: var(--erp-text-primary);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--erp-space-xl);
            overflow-x: hidden;
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

        /* ===== ERROR CARD ===== */
        .erp-error-card {
            width: 100%;
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
            min-height: auto;
            position: relative;
            z-index: 1;
            border-top: 4px solid var(--erp-error-dark);
            animation: card-shake 0.5s ease-in-out;
        }

        @keyframes card-shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .erp-error-card__header {
            background: linear-gradient(90deg, var(--erp-error-dark) 0%, var(--erp-error-darker) 100%);
            color: white;
            padding: var(--erp-space-xl) var(--erp-space-xl) var(--erp-space-lg);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated warning background in header */
        .erp-error-card__header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 70% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: error-pulse 2s ease-in-out infinite alternate;
        }

        @keyframes error-pulse {
            0% {
                transform: scale(1);
                opacity: 0.2;
            }

            100% {
                transform: scale(1.1);
                opacity: 0.4;
            }
        }

        .erp-error-card__logo {
            font-size: 40px;
            margin-bottom: var(--erp-space-sm);
            color: white;
            position: relative;
            z-index: 2;
            animation: warning-flash 1.5s ease-in-out infinite;
        }

        @keyframes warning-flash {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .erp-error-card__title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: var(--erp-space-xs);
            position: relative;
            z-index: 2;
        }

        .erp-error-card__subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }

        .erp-error-card__body {
            padding: var(--erp-space-xl);
            position: relative;
        }

        /* ===== CREATIVE ERROR ANIMATIONS ===== */
        .erp-error-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto var(--erp-space-xl);
        }

        /* Pulsing warning circle */
        .erp-error-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: var(--erp-radius-full);
            border: 3px solid var(--erp-error-light);
            animation: circle-pulse 2s ease-out infinite;
            z-index: 1;
        }

        .erp-error-circle:nth-child(2) {
            border-color: var(--erp-error-medium);
            animation-delay: 0.5s;
        }

        .erp-error-circle:nth-child(3) {
            border-color: var(--erp-error-dark);
            animation-delay: 1s;
        }

        @keyframes circle-pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.3);
                opacity: 0;
            }
        }

        /* Main error icon with creative animation */
        .erp-error-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 80px;
            color: var(--erp-error-dark);
            z-index: 3;
            animation: error-pop 1s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards,
                error-vibrate 2s 1s ease-in-out infinite;
            filter: drop-shadow(0 5px 10px var(--erp-error-glow));
        }

        @keyframes error-pop {
            0% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0) rotate(180deg);
            }

            70% {
                transform: translate(-50%, -50%) scale(1.3) rotate(-10deg);
            }

            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1) rotate(0deg);
            }
        }

        @keyframes error-vibrate {

            0%,
            100% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            25% {
                transform: translate(-50%, -50%) rotate(-1deg);
            }

            75% {
                transform: translate(-50%, -50%) rotate(1deg);
            }
        }

        /* Broken pieces animation */
        .erp-broken-piece {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: var(--erp-error-medium);
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            opacity: 0;
            z-index: 2;
            animation: break-apart 1.5s ease-out forwards;
        }

        .erp-broken-piece:nth-child(2) {
            background-color: var(--erp-error-light);
            animation-delay: 0.1s;
        }

        .erp-broken-piece:nth-child(3) {
            background-color: var(--erp-error-dark);
            animation-delay: 0.2s;
        }

        @keyframes break-apart {
            0% {
                opacity: 0;
                transform: translate(0, 0) rotate(0deg);
            }

            20% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translate(var(--tx), var(--ty)) rotate(var(--rot));
            }
        }

        /* Error details box */
        .erp-error-details {
            background-color: var(--erp-error-light);
            border-left: 4px solid var(--erp-error-dark);
            padding: var(--erp-space-md);
            border-radius: var(--erp-radius-md);
            margin: var(--erp-space-lg) 0;
            animation: slide-in 0.5s ease-out;
            max-height: 150px;
            overflow-y: auto;
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .erp-error-details__title {
            font-weight: 600;
            color: var(--erp-error-darker);
            margin-bottom: var(--erp-space-xs);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .erp-error-details__content {
            font-size: 13px;
            color: var(--erp-text-secondary);
            font-family: 'Courier New', monospace;
            line-height: 1.4;
        }

        /* Error message */
        .erp-error-message {
            font-size: 18px;
            font-weight: 500;
            color: var(--erp-text-primary);
            margin-bottom: var(--erp-space-md);
            text-align: center;
            min-height: 60px;
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
            transition: all 0.3s ease;
            text-decoration: none;
            gap: 8px;
            height: 44px;
            position: relative;
            overflow: hidden;
        }

        .erp-btn--primary {
            background: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            color: white;
            box-shadow: var(--erp-shadow-md);
        }

        .erp-btn--primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--erp-shadow-lg);
        }

        .erp-btn--primary:active {
            transform: translateY(0);
        }

        .erp-btn--primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--erp-primary-subtle);
        }

        .erp-btn--secondary {
            background-color: var(--erp-surface);
            color: var(--erp-error-dark);
            border: 2px solid var(--erp-error-medium);
            box-shadow: var(--erp-shadow-sm);
        }

        .erp-btn--secondary:hover {
            background-color: var(--erp-error-light);
            transform: translateY(-2px);
        }

        /* Button ripple effect */
        .erp-btn-ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .erp-btn--block {
            display: flex;
            width: 100%;
        }

        /* ===== BUTTON GROUP ===== */
        .erp-btn-group {
            display: flex;
            gap: var(--erp-space-md);
            margin-top: var(--erp-space-xl);
        }

        @media (max-width: 640px) {
            .erp-btn-group {
                flex-direction: column;
            }
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
        .erp-error-card__footer {
            padding: var(--erp-space-lg) var(--erp-space-xl);
            background-color: var(--erp-surface-alt);
            border-top: 1px solid var(--erp-border);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .erp-footer__copyright {
            font-size: 12px;
            color: var(--erp-text-tertiary);
            margin-bottom: var(--erp-space-xs);
            position: relative;
            z-index: 2;
        }

        .erp-footer__version {
            font-size: 11px;
            color: var(--erp-text-tertiary);
            opacity: 0.8;
            position: relative;
            z-index: 2;
        }

        /* Error warning particles in footer */
        .erp-error-particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background-color: var(--erp-error-medium);
            border-radius: 50%;
            opacity: 0.3;
            animation: error-float 20s infinite linear;
        }

        @keyframes error-float {
            0% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-15px) translateX(5px);
            }

            100% {
                transform: translateY(0) translateX(0);
            }
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 640px) {

            .erp-error-card__header,
            .erp-error-card__body {
                padding: var(--erp-space-lg);
            }

            .erp-error-card__footer {
                padding: var(--erp-space-md) var(--erp-space-lg);
            }

            .erp-error-icon {
                font-size: 60px;
            }

            .erp-error-container {
                width: 140px;
                height: 140px;
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
    <?php
    include_once '../../UxUI-Back/Main/Failed-Page/Failed-Page.php';

    include_once '../../UxUI-Back/Main/Failed-Page/JS/Failed-Page_JS.php';
    ?>

    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>