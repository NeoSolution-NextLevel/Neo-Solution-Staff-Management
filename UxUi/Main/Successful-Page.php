<!DOCTYPE html>
<html lang="en">
<?php
include_once '../../imports/need/session_setup.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <title>ERP Admin Portal | Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== GLOBAL COLOR SYSTEM ===== */
        :root {
            /* Primary ERP Brand Colors - Updated to Green Theme */
            --erp-primary: #2d8556;
            --erp-primary-dark: #1e5b37;
            --erp-primary-light: #48bb78;
            --erp-primary-subtle: #f0fff4;

            /* Success Colors */
            --erp-success-light: #c6f6d5;
            --erp-success-medium: #9ae6b4;
            --erp-success-dark: #38a169;
            --erp-success-darker: #276749;
            --erp-success-glow: rgba(72, 187, 120, 0.3);

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
            --erp-shadow-glow: 0 0 20px rgba(72, 187, 120, 0.4);

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
            background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
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

        /* ===== LOGIN CARD ===== */
        .erp-login-card {
            width: 100%;
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
            min-height: auto;
            position: relative;
            z-index: 1;
            border-top: 4px solid var(--erp-success-dark);
        }

        .erp-login-card__header {
            background: linear-gradient(90deg, var(--erp-success-dark) 0%, var(--erp-success-darker) 100%);
            color: white;
            padding: var(--erp-space-xl) var(--erp-space-xl) var(--erp-space-lg);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background in header */
        .erp-login-card__header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
            animation: pulse-background 4s ease-in-out infinite alternate;
        }

        @keyframes pulse-background {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }

            100% {
                transform: scale(1.2);
                opacity: 0.5;
            }
        }

        /* Add success symbol in header background */
        .erp-login-card__header::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 200px;
            color: rgba(255, 255, 255, 0.05);
            font-weight: bold;
            z-index: 0;
        }

        .erp-login-card__logo {
            font-size: 40px;
            margin-bottom: var(--erp-space-sm);
            color: white;
            position: relative;
            z-index: 2;
        }

        .erp-login-card__title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: var(--erp-space-xs);
            position: relative;
            z-index: 2;
            animation: text-glow 2s ease-in-out infinite alternate;
        }

        @keyframes text-glow {
            0% {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
            }

            100% {
                text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
            }
        }

        .erp-login-card__subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }

        .erp-login-card__body {
            padding: var(--erp-space-xl);
            position: relative;
        }

        /* ===== CREATIVE SUCCESS ANIMATIONS ===== */
        .erp-success-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto var(--erp-space-xl);
        }

        /* Outer animated ring */
        .erp-success-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: var(--erp-radius-full);
            border: 4px solid transparent;
            border-top: 4px solid var(--erp-success-light);
            animation: spin-ring 2s linear infinite;
            z-index: 1;
        }

        .erp-success-ring:nth-child(2) {
            border-top: 4px solid var(--erp-success-medium);
            animation-delay: 0.2s;
        }

        .erp-success-ring:nth-child(3) {
            border-top: 4px solid var(--erp-success-dark);
            animation-delay: 0.4s;
        }

        @keyframes spin-ring {
            0% {
                transform: rotate(0deg);
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                transform: rotate(360deg);
                opacity: 1;
            }
        }

        /* Main success icon with creative animation */
        .erp-success-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 80px;
            color: var(--erp-success-dark);
            z-index: 3;
            animation: checkmark-pop 1s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards,
                icon-pulse 2s 1s ease-in-out infinite;
            filter: drop-shadow(0 5px 10px var(--erp-success-glow));
        }

        @keyframes checkmark-pop {
            0% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0) rotate(-180deg);
            }

            70% {
                transform: translate(-50%, -50%) scale(1.2) rotate(10deg);
            }

            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1) rotate(0deg);
            }
        }

        @keyframes icon-pulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
                filter: drop-shadow(0 5px 10px var(--erp-success-glow));
            }

            50% {
                transform: translate(-50%, -50%) scale(1.05);
                filter: drop-shadow(0 10px 20px var(--erp-success-glow));
            }
        }

        /* Confetti particles */
        .erp-confetti-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            overflow: hidden;
        }

        .erp-confetti {
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: var(--erp-success-dark);
            border-radius: 2px;
            opacity: 0;
            animation: confetti-fall 5s ease-in forwards;
        }

        .erp-confetti:nth-child(2n) {
            background-color: var(--erp-success-medium);
        }

        .erp-confetti:nth-child(3n) {
            background-color: var(--erp-success-light);
        }

        .erp-confetti:nth-child(5n) {
            background-color: var(--erp-primary-light);
        }

        @keyframes confetti-fall {
            0% {
                opacity: 0;
                transform: translateY(-100px) rotate(0deg);
            }

            10% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(500px) rotate(720deg);
            }
        }

        /* Success message with typewriter effect */
        .erp-success-message {
            font-size: 18px;
            font-weight: 500;
            color: var(--erp-text-primary);
            margin-bottom: var(--erp-space-md);
            text-align: center;
            min-height: 60px;
            position: relative;
        }

        .erp-success-message::after {
            content: '|';
            animation: cursor-blink 1s infinite;
            margin-left: 2px;
            color: var(--erp-success-dark);
        }

        @keyframes cursor-blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
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
            background: linear-gradient(90deg, var(--erp-success-dark) 0%, var(--erp-success-darker) 100%);
            color: white;
            box-shadow: var(--erp-shadow-md);
        }

        .erp-btn--primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--erp-shadow-lg), var(--erp-shadow-glow);
        }

        .erp-btn--primary:active {
            transform: translateY(0);
        }

        .erp-btn--primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--erp-primary-subtle);
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

        /* ===== PROGRESS INDICATOR ===== */
        .erp-progress-container {
            width: 100%;
            height: 6px;
            background-color: var(--erp-border);
            border-radius: 3px;
            margin-top: var(--erp-space-lg);
            overflow: hidden;
        }

        .erp-progress-bar {
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, var(--erp-success-light) 0%, var(--erp-success-dark) 100%);
            border-radius: 3px;
            animation: progress-shrink 3s linear forwards;
            transform-origin: left center;
        }

        @keyframes progress-shrink {
            0% {
                transform: scaleX(1);
            }

            100% {
                transform: scaleX(0);
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
            color: var(--erp-success-dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .erp-link:hover {
            color: var(--erp-success-darker);
            text-decoration: underline;
        }

        /* ===== FOOTER ===== */
        .erp-login-card__footer {
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

        /* Floating particles in footer */
        .erp-footer-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background-color: var(--erp-success-light);
            border-radius: 50%;
            opacity: 0.3;
            animation: float-particle 15s infinite linear;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-20px) translateX(10px);
            }

            100% {
                transform: translateY(0) translateX(0);
            }
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

            .erp-success-icon {
                font-size: 60px;
            }

            .erp-success-container {
                width: 140px;
                height: 140px;
            }

            body {
                padding: var(--erp-space-sm);
            }

            .erp-login-card__header::after {
                font-size: 120px;
            }
        }
    </style>
</head>

<body>
    <?php include_once '../../UxUI-Back/Common/header.php'; ?>
    <?php
    include_once '../../UxUI-Back/Main/Successful-Page/Successful-Page.php';
    ?>

    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>