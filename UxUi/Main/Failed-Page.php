<?php
include_once '../../imports/need/session_setup.php';
$is_auth_page = true;
include_once '../../imports/Company_Info/Company_Info_Variable_List.php';

$company_obj = new Company_Info_Variable_List();
$is_admin = (isset($_SESSION['user_role']) && strtolower($_SESSION['user_role']) === 'admin');
$portal_label = $is_admin ? 'Admin Portal' : 'Portal';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <title><?php echo $portal_label; ?> | Alert - NEO Solution</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../UxUi-Back/assets/css/portals/auth-portal.css?v=<?php echo filemtime(__DIR__ . '/../../UxUi-Back/assets/css/portals/auth-portal.css'); ?>">
    <style>
        /* Modern Error Page Theme matching NEO Solution corporate design */
        :root {
            --erp-error-light: #fef2f2;
            --erp-error-border: #fecaca;
            --erp-error-medium: #f87171;
            --erp-error-dark: #dc2626;
            --erp-error-darker: #991b1b;
            --erp-error-glow: rgba(220, 38, 38, 0.2);
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

        /* ===== ERROR CARD ===== */
        .erp-error-card {
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--erp-border, #e2e8f0);
            box-shadow: 0 12px 32px -4px rgba(20, 32, 77, 0.08), 0 4px 12px -2px rgba(20, 32, 77, 0.04);
            overflow: hidden;
            position: relative;
            z-index: 1;
            border-top: 4px solid var(--erp-error-dark);
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

        .erp-error-card__header {
            background: linear-gradient(135deg, #14204d 0%, #1c2b63 60%, #991b1b 100%);
            color: #ffffff;
            padding: 28px 24px 22px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .erp-error-card__logo {
            font-size: 34px;
            margin-bottom: 10px;
            color: #fca5a5;
            position: relative;
            z-index: 2;
            display: inline-block;
        }

        .erp-error-card__title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
            position: relative;
            z-index: 2;
            letter-spacing: -0.3px;
        }

        .erp-error-card__subtitle {
            font-size: 13.5px;
            color: #e2e8f0;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        .erp-error-card__body {
            padding: 28px 24px 24px;
            position: relative;
        }

        /* Modern Error Badge Animation */
        .erp-error-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .erp-error-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            border: 2px solid var(--erp-error-border);
            animation: ring-pulse 2.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) infinite;
        }

        .erp-error-circle:nth-child(1) {
            width: 90px;
            height: 90px;
            border-color: #fecaca;
        }

        .erp-error-circle:nth-child(2) {
            width: 110px;
            height: 110px;
            border-color: #fee2e2;
            animation-delay: 0.6s;
        }

        .erp-error-circle:nth-child(3) {
            width: 130px;
            height: 130px;
            border-color: #fef2f2;
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

        .erp-error-icon {
            font-size: 64px;
            color: var(--erp-error-dark);
            z-index: 3;
            filter: drop-shadow(0 4px 10px var(--erp-error-glow));
            animation: icon-scale 0.5s ease-out;
        }

        @keyframes icon-scale {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }

        .erp-broken-piece {
            display: none;
        }

        .erp-error-message {
            font-size: 15.5px;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.5;
            margin-bottom: 16px;
            min-height: 48px;
            text-align: center;
        }

        /* Error details box */
        .erp-error-details {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid var(--erp-error-dark);
            padding: 12px 14px;
            border-radius: 8px;
            margin: 14px 0;
            text-align: left;
            max-height: 140px;
            overflow-y: auto;
        }

        .erp-error-details__title {
            font-weight: 700;
            color: var(--erp-error-darker);
            margin-bottom: 4px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .erp-error-details__content {
            font-size: 12.5px;
            color: #475569;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            line-height: 1.45;
            word-break: break-word;
        }

        #error-code {
            cursor: pointer;
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            padding: 4px 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            transition: all 0.2s ease;
        }

        #error-code:hover {
            color: #0f172a;
            border-color: #cbd5e1;
            background: #f1f5f9;
        }

        /* Button group */
        .erp-btn-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

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

        .erp-btn--secondary {
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .erp-btn--secondary:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .erp-btn--block {
            flex: 1;
            width: 100%;
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

        .erp-error-card__footer {
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

        .erp-footer__version {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 3px;
        }

        @media (max-width: 640px) {
            .erp-container--login {
                padding: 0 12px !important;
                margin: 16px auto !important;
            }

            .erp-error-card__header {
                padding: 22px 18px 18px;
            }

            .erp-error-card__title {
                font-size: 20px;
            }

            .erp-error-card__body {
                padding: 22px 16px 18px;
            }

            .erp-btn-group {
                flex-direction: column;
                gap: 10px;
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
    <?php include_once '../../UxUi-Back/Main/Failed-Page/Failed-Page.php'; ?>
    <?php include_once '../../UxUi-Back/Main/Failed-Page/JS/Failed-Page_JS.php'; ?>
    <?php include_once '../../UxUi-Back/Common/footer.php'; ?>
</body>

</html>