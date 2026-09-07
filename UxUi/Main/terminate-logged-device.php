<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Sessions | ERP Portal</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== GLOBAL COLOR SYSTEM ===== */
        :root {
            --erp-primary: #2c5282;
            --erp-primary-dark: #1a365d;
            --erp-primary-light: #4299e1;
            --erp-primary-subtle: #ebf8ff;
            --erp-surface: #ffffff;
            --erp-surface-alt: #f7fafc;
            --erp-border: #e2e8f0;
            --erp-border-dark: #cbd5e0;
            --erp-text-primary: #2d3748;
            --erp-text-secondary: #4a5568;
            --erp-text-tertiary: #718096;
            --erp-accent-success: #38a169;
            --erp-accent-warning: #d69e2e;
            --erp-accent-error: #e53e3e;
            --erp-accent-info: #3182ce;
            --erp-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --erp-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --erp-shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --erp-radius-sm: 4px;
            --erp-radius-md: 8px;
            --erp-radius-lg: 12px;
            --erp-space-xs: 8px;
            --erp-space-sm: 12px;
            --erp-space-md: 16px;
            --erp-space-lg: 24px;
            --erp-space-xl: 32px;
        }

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
            padding: var(--erp-space-md);
        }

        /* ===== COMPACT SESSION CARD ===== */
        .erp-session-card {
            width: 100%;
            max-width: 500px;
            background-color: var(--erp-surface);
            border-radius: var(--erp-radius-lg);
            box-shadow: var(--erp-shadow-lg);
            overflow: hidden;
        }

        .erp-session-card__header {
            background: linear-gradient(90deg, var(--erp-primary) 0%, var(--erp-primary-dark) 100%);
            color: white;
            padding: var(--erp-space-md);
            text-align: center;
        }

        .erp-session-card__title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .erp-session-card__subtitle {
            font-size: 12px;
            opacity: 0.9;
            font-weight: 400;
        }

        .erp-session-card__body {
            padding: var(--erp-space-lg);
        }

        /* ===== DEVICES ROW ===== */
        .erp-devices-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: var(--erp-space-sm);
            margin-bottom: var(--erp-space-lg);
            flex-wrap: wrap;
        }

        .erp-device-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: var(--erp-space-sm);
            min-width: 70px;
            border-radius: var(--erp-radius-md);
            background-color: var(--erp-surface-alt);
            border: 1px solid var(--erp-border);
            transition: all 0.2s ease;
            cursor: default;
        }

        .erp-device-badge--current {
            background-color: var(--erp-primary-subtle);
            border-color: var(--erp-primary-light);
            box-shadow: 0 0 0 2px var(--erp-primary-subtle);
        }

        .erp-device-badge__icon {
            font-size: 20px;
            margin-bottom: 6px;
            color: var(--erp-text-secondary);
        }

        .erp-device-badge--current .erp-device-badge__icon {
            color: var(--erp-primary);
        }

        .erp-device-badge__name {
            font-size: 11px;
            font-weight: 500;
            color: var(--erp-text-secondary);
            text-align: center;
            line-height: 1.2;
        }

        .erp-device-badge__status {
            font-size: 9px;
            margin-top: 2px;
            padding: 1px 6px;
            border-radius: 10px;
            background-color: var(--erp-accent-success);
            color: white;
        }

        .erp-device-badge--inactive .erp-device-badge__status {
            background-color: var(--erp-text-tertiary);
        }

        /* ===== BUTTONS GRID ===== */
        .erp-actions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--erp-space-sm);
        }

        .erp-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: var(--erp-space-sm);
            border: none;
            border-radius: var(--erp-radius-md);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 6px;
            height: 80px;
            text-align: center;
            background-color: var(--erp-surface-alt);
            border: 1px solid var(--erp-border);
            color: var(--erp-text-primary);
        }

        .erp-action-btn:hover {
            background-color: white;
            border-color: var(--erp-border-dark);
            transform: translateY(-2px);
            box-shadow: var(--erp-shadow-sm);
        }

        .erp-action-btn--danger {
            background-color: #fff5f5;
            border-color: #fed7d7;
            color: var(--erp-accent-error);
        }

        .erp-action-btn--danger:hover {
            background-color: #fed7d7;
            border-color: var(--erp-accent-error);
        }

        .erp-action-btn--primary {
            background-color: var(--erp-primary-subtle);
            border-color: var(--erp-primary-light);
            color: var(--erp-primary);
        }

        .erp-action-btn--primary:hover {
            background-color: #bee3f8;
            border-color: var(--erp-primary);
        }

        .erp-action-btn--success {
            background-color: #f0fff4;
            border-color: #c6f6d5;
            color: var(--erp-accent-success);
        }

        .erp-action-btn--success:hover {
            background-color: #c6f6d5;
            border-color: var(--erp-accent-success);
        }

        .erp-action-btn__icon {
            font-size: 20px;
        }

        .erp-action-btn__text {
            line-height: 1.2;
        }

        /* ===== INFO SECTION ===== */
        .erp-session-info {
            margin-top: var(--erp-space-lg);
            padding: var(--erp-space-sm);
            background-color: var(--erp-surface-alt);
            border-radius: var(--erp-radius-md);
            border-left: 3px solid var(--erp-primary);
        }

        .erp-session-info__text {
            font-size: 12px;
            color: var(--erp-text-secondary);
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .erp-session-info__icon {
            color: var(--erp-primary);
            font-size: 14px;
            margin-top: 1px;
        }

        /* ===== MODAL ===== */
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
            max-width: 400px;
            overflow: hidden;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .erp-modal__header {
            padding: var(--erp-space-md);
            border-bottom: 1px solid var(--erp-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .erp-modal__title {
            font-size: 16px;
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

        .erp-modal__body {
            padding: var(--erp-space-md);
        }

        .erp-modal__footer {
            padding: var(--erp-space-md);
            border-top: 1px solid var(--erp-border);
            display: flex;
            justify-content: flex-end;
            gap: var(--erp-space-sm);
        }

        .erp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border: none;
            border-radius: var(--erp-radius-md);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            gap: 6px;
            height: 36px;
        }

        .erp-btn--outline {
            background-color: transparent;
            color: var(--erp-text-secondary);
            border: 1px solid var(--erp-border);
        }

        .erp-btn--outline:hover {
            background-color: var(--erp-surface-alt);
        }

        .erp-btn--danger {
            background-color: var(--erp-accent-error);
            color: white;
        }

        .erp-btn--danger:hover {
            background-color: #c53030;
        }

        .erp-btn--primary {
            background-color: var(--erp-primary);
            color: white;
        }

        .erp-btn--primary:hover {
            background-color: var(--erp-primary-dark);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 500px) {
            .erp-actions-grid {
                grid-template-columns: 1fr;
            }

            .erp-action-btn {
                height: 60px;
                flex-direction: row;
                justify-content: flex-start;
                padding: var(--erp-space-sm);
            }

            .erp-devices-row {
                gap: var(--erp-space-xs);
            }

            .erp-device-badge {
                min-width: 60px;
                padding: 6px;
            }
        }

        @media (max-width: 350px) {
            .erp-devices-row {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <?php include_once '../../UxUI-Back/Common/header.php'; ?>

    <div class="erp-session-card">
        <!-- Header -->
        <div class="erp-session-card__header">
            <div class="erp-session-card__title">Active Sessions</div>
            <div class="erp-session-card__subtitle">Manage your account access across devices</div>
        </div>

        <!-- Body -->
        <div class="erp-session-card__body">
            <!-- Devices Row -->
            <div class="erp-devices-row">
                <div class="erp-device-badge erp-device-badge--current">
                    <i class="fas fa-laptop erp-device-badge__icon"></i>
                    <div class="erp-device-badge__name">Windows PC</div>
                    <div class="erp-device-badge__status">Current</div>
                </div>

                <div class="erp-device-badge">
                    <i class="fas fa-mobile-alt erp-device-badge__icon"></i>
                    <div class="erp-device-badge__name">iPhone</div>
                    <div class="erp-device-badge__status">Active</div>
                </div>

                <div class="erp-device-badge">
                    <i class="fas fa-tablet-alt erp-device-badge__icon"></i>
                    <div class="erp-device-badge__name">iPad</div>
                    <div class="erp-device-badge__status">Active</div>
                </div>

                <div class="erp-device-badge erp-device-badge--inactive">
                    <i class="fas fa-desktop erp-device-badge__icon"></i>
                    <div class="erp-device-badge__name">Office PC</div>
                    <div class="erp-device-badge__status">1 day ago</div>
                </div>
            </div>

            <!-- Action Buttons Grid -->
            <div class="erp-actions-grid">
                <button class="erp-action-btn erp-action-btn--danger" onclick="openTerminateAllModal()">
                    <i class="fas fa-sign-out-alt erp-action-btn__icon"></i>
                    <div class="erp-action-btn__text">Terminate All Other Sessions</div>
                </button>

                <button class="erp-action-btn erp-action-btn--primary" onclick="openLoginModal()">
                    <i class="fas fa-sign-in-alt erp-action-btn__icon"></i>
                    <div class="erp-action-btn__text">Login on Another Device</div>
                </button>

                <button class="erp-action-btn erp-action-btn--success" onclick="openNewSessionModal()">
                    <i class="fas fa-plus-circle erp-action-btn__icon"></i>
                    <div class="erp-action-btn__text">Start New Session</div>
                </button>
            </div>

            <!-- Info Section -->
            <div class="erp-session-info">
                <div class="erp-session-info__text">
                    <i class="fas fa-info-circle erp-session-info__icon"></i>
                    <span>You have 4 active sessions. Terminating sessions will log you out from those devices.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Terminate All Sessions -->
    <div class="erp-modal" id="terminateAllModal">
        <div class="erp-modal__content">
            <div class="erp-modal__header">
                <div class="erp-modal__title">Terminate All Sessions</div>
                <button class="erp-modal__close" onclick="closeTerminateAllModal()">&times;</button>
            </div>
            <div class="erp-modal__body">
                <div style="display: flex; align-items: center; gap: var(--erp-space-sm); margin-bottom: var(--erp-space-md);">
                    <i class="fas fa-exclamation-triangle" style="color: var(--erp-accent-warning); font-size: 20px;"></i>
                    <div style="font-weight: 500; color: var(--erp-text-primary);">Security Alert</div>
                </div>
                <p style="font-size: 14px; color: var(--erp-text-secondary); margin-bottom: var(--erp-space-sm);">
                    You are about to log out from all other devices. This will end your sessions on:
                </p>
                <ul style="font-size: 13px; color: var(--erp-text-secondary); padding-left: var(--erp-space-lg); margin-bottom: var(--erp-space-md);">
                    <li>iPhone 13 - Safari</li>
                    <li>iPad Pro - Chrome</li>
                    <li>Office PC - Firefox</li>
                </ul>
                <p style="font-size: 13px; color: var(--erp-accent-error); font-weight: 500;">
                    <i class="fas fa-exclamation-circle"></i> You will remain logged in on this device only.
                </p>
            </div>
            <div class="erp-modal__footer">
                <button class="erp-btn erp-btn--outline" onclick="closeTerminateAllModal()">Cancel</button>
                <button class="erp-btn erp-btn--danger" onclick="terminateAllSessions()">
                    <i class="fas fa-sign-out-alt"></i>
                    Terminate All
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Login on Another Device -->
    <div class="erp-modal" id="loginModal">
        <div class="erp-modal__content">
            <div class="erp-modal__header">
                <div class="erp-modal__title">Login on Another Device</div>
                <button class="erp-modal__close" onclick="closeLoginModal()">&times;</button>
            </div>
            <div class="erp-modal__body">
                <div style="display: flex; align-items: center; gap: var(--erp-space-sm); margin-bottom: var(--erp-space-md);">
                    <i class="fas fa-mobile-alt" style="color: var(--erp-primary); font-size: 20px;"></i>
                    <div style="font-weight: 500; color: var(--erp-text-primary);">Multi-Device Login</div>
                </div>
                <p style="font-size: 14px; color: var(--erp-text-secondary); margin-bottom: var(--erp-space-md);">
                    To login on another device:
                </p>
                <ol style="font-size: 13px; color: var(--erp-text-secondary); padding-left: var(--erp-space-lg); margin-bottom: var(--erp-space-md);">
                    <li>Go to the login page on the other device</li>
                    <li>Enter your credentials</li>
                    <li>Complete any 2-factor authentication if enabled</li>
                    <li>You'll be logged in on both devices simultaneously</li>
                </ol>
                <div style="background-color: var(--erp-primary-subtle); padding: var(--erp-space-sm); border-radius: var(--erp-radius-sm);">
                    <p style="font-size: 12px; color: var(--erp-primary); margin: 0;">
                        <i class="fas fa-info-circle"></i> You can have up to 5 active sessions at once.
                    </p>
                </div>
            </div>
            <div class="erp-modal__footer">
                <button class="erp-btn erp-btn--primary" onclick="closeLoginModal()">
                    <i class="fas fa-check"></i>
                    Got It
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Start New Session -->
    <div class="erp-modal" id="newSessionModal">
        <div class="erp-modal__content">
            <div class="erp-modal__header">
                <div class="erp-modal__title">Start New Session</div>
                <button class="erp-modal__close" onclick="closeNewSessionModal()">&times;</button>
            </div>
            <div class="erp-modal__body">
                <div style="display: flex; align-items: center; gap: var(--erp-space-sm); margin-bottom: var(--erp-space-md);">
                    <i class="fas fa-plus-circle" style="color: var(--erp-accent-success); font-size: 20px;"></i>
                    <div style="font-weight: 500; color: var(--erp-text-primary);">New Session Options</div>
                </div>

                <div style="margin-bottom: var(--erp-space-md);">
                    <p style="font-size: 13px; color: var(--erp-text-secondary); margin-bottom: var(--erp-space-sm);">
                        Choose how you want to start a new session:
                    </p>

                    <div style="display: flex; flex-direction: column; gap: var(--erp-space-sm);">
                        <button class="erp-action-btn" style="height: auto; padding: var(--erp-space-sm);" onclick="startIncognitoSession()">
                            <div style="display: flex; align-items: center; gap: var(--erp-space-sm);">
                                <i class="fas fa-user-secret" style="color: var(--erp-text-secondary);"></i>
                                <div style="text-align: left;">
                                    <div style="font-weight: 500; font-size: 13px;">Incognito Session</div>
                                    <div style="font-size: 11px; color: var(--erp-text-tertiary);">Private browsing, won't save cookies</div>
                                </div>
                            </div>
                        </button>

                        <button class="erp-action-btn" style="height: auto; padding: var(--erp-space-sm);" onclick="startNewTabSession()">
                            <div style="display: flex; align-items: center; gap: var(--erp-space-sm);">
                                <i class="fas fa-window-restore" style="color: var(--erp-primary);"></i>
                                <div style="text-align: left;">
                                    <div style="font-weight: 500; font-size: 13px;">New Tab Session</div>
                                    <div style="font-size: 11px; color: var(--erp-text-tertiary);">Open in new tab on this device</div>
                                </div>
                            </div>
                        </button>

                        <button class="erp-action-btn" style="height: auto; padding: var(--erp-space-sm);" onclick="startGuestSession()">
                            <div style="display: flex; align-items: center; gap: var(--erp-space-sm);">
                                <i class="fas fa-user-clock" style="color: var(--erp-accent-warning);"></i>
                                <div style="text-align: left;">
                                    <div style="font-weight: 500; font-size: 13px;">Temporary Guest Session</div>
                                    <div style="font-size: 11px; color: var(--erp-text-tertiary);">Limited access, auto-expires in 1 hour</div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="erp-modal__footer">
                <button class="erp-btn erp-btn--outline" onclick="closeNewSessionModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openTerminateAllModal() {
            document.getElementById('terminateAllModal').classList.add('erp-modal--active');
        }

        function closeTerminateAllModal() {
            document.getElementById('terminateAllModal').classList.remove('erp-modal--active');
        }

        function openLoginModal() {
            document.getElementById('loginModal').classList.add('erp-modal--active');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('erp-modal--active');
        }

        function openNewSessionModal() {
            document.getElementById('newSessionModal').classList.add('erp-modal--active');
        }

        function closeNewSessionModal() {
            document.getElementById('newSessionModal').classList.remove('erp-modal--active');
        }

        // Action Functions
        function terminateAllSessions() {
            const btn = document.querySelector('#terminateAllModal .erp-btn--danger');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                // In real app, call API to terminate sessions
                console.log('Terminated all other sessions');

                // Update UI
                const devices = document.querySelectorAll('.erp-device-badge:not(.erp-device-badge--current)');
                devices.forEach(device => {
                    device.classList.add('erp-device-badge--inactive');
                    const status = device.querySelector('.erp-device-badge__status');
                    status.textContent = 'Logged out';
                    status.style.backgroundColor = 'var(--erp-text-tertiary)';
                });

                // Show success message
                showNotification('All other sessions terminated successfully!', 'success');

                // Close modal
                closeTerminateAllModal();

                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 1500);
        }

        function startIncognitoSession() {
            showNotification('Opening incognito session...', 'info');
            closeNewSessionModal();
            // In real app, would open incognito window or set session flag
            setTimeout(() => {
                window.open('/login?session_type=incognito', '_blank');
            }, 500);
        }

        function startNewTabSession() {
            showNotification('Opening new tab session...', 'info');
            closeNewSessionModal();
            // Open in new tab
            window.open(window.location.href + '?new_session=true', '_blank');
        }

        function startGuestSession() {
            showNotification('Creating guest session...', 'info');
            closeNewSessionModal();
            // In real app, would create temporary guest session
            setTimeout(() => {
                window.open('/guest-access', '_blank');
            }, 500);
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 16px;
                border-radius: 8px;
                background-color: ${type === 'success' ? 'var(--erp-accent-success)' : 
                                 type === 'error' ? 'var(--erp-accent-error)' : 
                                 'var(--erp-accent-info)'};
                color: white;
                font-weight: 500;
                z-index: 1001;
                box-shadow: var(--erp-shadow-md);
                display: flex;
                align-items: center;
                gap: 8px;
                animation: slideIn 0.3s ease;
            `;

            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 
                                  type === 'error' ? 'exclamation-circle' : 
                                  'info-circle'}"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = ['terminateAllModal', 'loginModal', 'newSessionModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.classList.remove('erp-modal--active');
                }
            });
        };

        // Close modals with Escape key
        document.onkeydown = function(event) {
            if (event.key === 'Escape') {
                const modals = ['terminateAllModal', 'loginModal', 'newSessionModal'];
                modals.forEach(modalId => {
                    document.getElementById(modalId).classList.remove('erp-modal--active');
                });
            }
        };

        // Device badges click for more info
        document.querySelectorAll('.erp-device-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                const deviceName = this.querySelector('.erp-device-badge__name').textContent;
                const isCurrent = this.classList.contains('erp-device-badge--current');

                let message = `Device: ${deviceName}\n`;
                message += isCurrent ? 'Status: Current Device (You are here)\n' : 'Status: Active Session\n';
                message += 'Click "Terminate All Other Sessions" to log out from this device.';

                alert(message);
            });
        });
    </script>

    <?php include_once '../../UxUI-Back/Common/footer.php'; ?>
</body>

</html>