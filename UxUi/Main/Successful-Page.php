<?php
include_once '../../imports/need/session_setup.php';
require_login();
$is_auth_page = true;
$is_admin = (isset($_SESSION['user_role']) && strtolower($_SESSION['user_role']) === 'admin');
$portal_type = $is_admin ? 'Admin Portal' : 'Staff Portal';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <title><?php echo $portal_type; ?> | Success - NEO Solution</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../UxUi-Back/assets/css/portals/auth-portal.css?v=<?php echo filemtime(__DIR__ . '/../../UxUi-Back/assets/css/portals/auth-portal.css'); ?>">
    <style>
        /* Modern Success Theme matching NEO Solution corporate design */
        :root {
            --erp-success-light: #ecfdf5;
            --erp-success-border: #a7f3d0;
            --erp-success-medium: #34d399;
            --erp-success-dark: #10b981;
            --erp-success-darker: #065f46;
            --erp-success-glow: rgba(16, 185, 129, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: var(--erp-text-primary, #0f172a);
            line-height: 1.5;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .erp-header {
            flex: 0 0 auto;
            width: 100%;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .erp-footer {
            flex: 0 0 auto;
            width: 100%;
            position: static !important;
            margin-top: auto;
        }

        .erp-container {
            flex: 1 0 auto;
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 32px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .erp-container--login {
            max-width: 520px;
            width: 100%;
        }

        /* ===== LOGIN / SUCCESS CARD ===== */
        .erp-login-card {
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--erp-border, #e2e8f0);
            box-shadow: 0 12px 32px -4px rgba(20, 32, 77, 0.08), 0 4px 12px -2px rgba(20, 32, 77, 0.04);
            overflow: hidden;
            position: relative;
            z-index: 1;
            border-top: 4px solid var(--erp-success-dark);
            animation: card-appear 0.4s ease-out;
        }

        @keyframes card-appear {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .erp-login-card__header {
            background: linear-gradient(135deg, #14204d 0%, #1c2b63 60%, #059669 100%);
            color: #ffffff;
            padding: 28px 24px 22px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .erp-login-card__title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
            position: relative;
            z-index: 2;
            letter-spacing: -0.3px;
        }

        .erp-login-card__subtitle {
            font-size: 13.5px;
            color: #e2e8f0;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        .erp-login-card__body {
            padding: 28px 24px 24px;
            position: relative;
        }

        /* Modern Success Badge Animation */
        .erp-success-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .erp-success-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            border: 2px solid var(--erp-success-border);
            animation: ring-pulse 2.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) infinite;
        }

        .erp-success-ring:nth-child(1) {
            width: 90px;
            height: 90px;
            border-color: #a7f3d0;
        }

        .erp-success-ring:nth-child(2) {
            width: 110px;
            height: 110px;
            border-color: #d1fae5;
            animation-delay: 0.6s;
        }

        .erp-success-ring:nth-child(3) {
            width: 130px;
            height: 130px;
            border-color: #ecfdf5;
            animation-delay: 1.2s;
        }

        @keyframes ring-pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.85);
                opacity: 0.9;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0;
            }
        }

        .erp-success-icon {
            font-size: 64px;
            color: var(--erp-success-dark);
            z-index: 3;
            filter: drop-shadow(0 4px 10px var(--erp-success-glow));
            animation: icon-scale 0.5s ease-out;
        }

        @keyframes icon-scale {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }

        .erp-confetti-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .erp-confetti {
            position: absolute;
            border-radius: 2px;
            background: #10b981;
            opacity: 0.6;
            animation: confetti-fall 3s linear infinite;
        }

        @keyframes confetti-fall {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(140px) rotate(360deg); opacity: 0; }
        }

        .erp-success-message {
            font-size: 15.5px;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.5;
            margin-bottom: 16px;
            min-height: 48px;
            text-align: center;
        }

        /* Countdown & Progress */
        .erp-progress-container {
            width: 100%;
            max-width: 240px;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 999px;
            margin: 0 auto 12px;
            overflow: hidden;
        }

        .erp-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            border-radius: 999px;
            animation: progress-fill 2.5s linear forwards;
        }

        @keyframes progress-fill {
            from { width: 0%; }
            to { width: 100%; }
        }

        #countdown-text {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        /* Buttons */
        .erp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            height: 46px;
            border-radius: 10px;
            font-size: 14.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 8px;
            border: none;
        }

        .erp-btn--primary {
            background: linear-gradient(135deg, #14204d 0%, #1c2b63 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(20, 32, 77, 0.18);
        }

        .erp-btn--primary:hover {
            background: linear-gradient(135deg, #1c2b63 0%, #2563eb 100%);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            transform: translateY(-1px);
        }

        .erp-btn--block {
            width: 100%;
        }

        .erp-btn-ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple 0.6s linear;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .erp-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .erp-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .erp-login-card__footer {
            padding: 16px 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .erp-footer__copyright {
            font-size: 12px;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        @media (max-width: 640px) {
            .erp-container--login {
                padding: 0 12px !important;
                margin: 16px auto !important;
            }

            .erp-login-card__header {
                padding: 22px 18px 18px;
            }

            .erp-login-card__title {
                font-size: 20px;
            }

            .erp-login-card__body {
                padding: 22px 16px 18px;
            }

            .erp-btn {
                height: 44px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php include_once '../../UxUi-Back/Common/header.php'; ?>
    <?php include_once '../../UxUi-Back/Main/Successful-Page/Successful-Page.php'; ?>
    <?php include_once '../../UxUi-Back/Common/footer.php'; ?>
</body>

</html>