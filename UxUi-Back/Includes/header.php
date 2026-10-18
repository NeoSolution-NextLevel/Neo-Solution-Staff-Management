<!-- components/header.php -->
<?php if (!isset($header_included)): ?>
    <?php $header_included = true; ?>

    <link rel="stylesheet" href="<?php echo isset($pth) ? $pth : '../'; ?>UxUi-Back/assets/css/erp-theme.css">

    <style>
        .erp-header {
            height: 64px;
            background: #ffffff;
            color: #14204d;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            font-size: 14px;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 103;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(20, 25, 60, 0.03);
            box-sizing: border-box;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
        }

        .erp-header__title {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex: 1;
        }

        .erp-header__menu {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 12px;
            border: 1px solid #e0edff;
            background: #eef2ff;
            color: #14204d;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            transition: transform 0.15s ease, background 0.15s ease;
        }

        .erp-header__menu:hover {
            background: #e0e7ff;
            transform: translateY(-1px);
        }

        .erp-header__menu svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .erp-header__title-text {
            color: #14204d;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .erp-header__icons {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .erp-header__icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #eef2ff;
            border: 1px solid #e0edff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #14204d;
            cursor: pointer;
            position: relative;
            transition: transform 0.15s ease, background 0.15s ease;
        }

        .erp-header__icon:hover {
            background: #e0e7ff;
            transform: translateY(-1px);
        }

        .erp-header__icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .erp-header__icon--alert::after {
            content: "";
            position: absolute;
            top: 7px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .erp-header__user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: 4px 14px 4px 5px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .erp-header__user-pill:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .erp-header__user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #14204d;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
        }

        .erp-header__user-name {
            font-size: 13px;
            font-weight: 700;
            color: #14204d;
        }

        .erp-sidebar-overlay {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            width: 100%;
            height: calc(100% - 64px);
            background: rgba(15, 23, 42, 0.35);
            z-index: 101;
        }

        @media (max-width: 768px) {
            .erp-header {
                padding: 0 16px;
                height: 58px;
            }

            .erp-header__title-text {
                font-size: 18px;
                max-width: 210px;
            }

            .erp-header__icon {
                width: 36px;
                height: 36px;
            }

            .erp-header__user-name {
                display: none;
            }

            .erp-header__user-pill {
                padding: 4px;
            }

            .erp-sidebar-overlay.active {
                display: block;
            }
        }

    </style>

    <div class="erp-sidebar-overlay" id="sidebarOverlay"></div>

    <header class="erp-header">
        <div class="erp-header__title">
            <button class="erp-header__menu" id="mobileToggleBtn" aria-label="Open menu" type="button">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 12h18"/>
                    <path d="M3 6h18"/>
                    <path d="M3 18h18"/>
                </svg>
            </button>
            <span class="erp-header__title-text"><?php echo htmlspecialchars(!empty($page_title) ? $page_title : 'Dashboard'); ?></span>
        </div>

        <div class="erp-header__icons">
            <span class="erp-header__icon erp-header__icon--alert" title="Notifications" aria-label="Notifications" onclick="if (typeof Admin_user_dashboard_09_OPEN === 'function') { Admin_user_dashboard_09_OPEN(); }">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                </svg>
            </span>
            <div class="erp-header__user-pill" title="Profile &amp; Settings" aria-label="User profile" onclick="if (typeof User_Profile_OPEN === 'function') { User_Profile_OPEN(); }">
                <div class="erp-header__user-avatar"><?php echo htmlspecialchars(!empty($logged_user_initials) ? $logged_user_initials : 'AU'); ?></div>
                <span class="erp-header__user-name"><?php echo htmlspecialchars(!empty($logged_user_first_name) && $logged_user_first_name !== 'Guest' ? $logged_user_first_name : 'Admin'); ?></span>
            </div>
        </div>
    </header>

    <script>
        function User_Profile_OPEN() {
            window.location.href = "<?php echo $home_page ?><?php echo $User_login_url ?>User-Profile<?php echo $online_offline_extention ?>"
        }

        function Item_Service_Management_OPEN() {
            window.location.href = "<?php echo $home_page ?>/UxUi/Item-Service/Item-Service-Settings<?php echo $online_offline_extention ?>"
        }

        function logoutUser() {

            $.ajax({
                url: "<?php echo $pth; ?>View-List/Main/Main_User_Logout.php",
                type: "POST",
                dataType: "json",
                success: function(json) {

                    console.log(json);

                    if (json[0].error === "0") {

                        document.cookie.split(";").forEach(function(cookie) {
                            document.cookie = cookie
                                .replace(/^ +/, "")
                                .replace(/=.*/, "=;expires=" + new Date(0).toUTCString() + ";path=/");
                        });

                        sessionStorage.clear();
                        localStorage.clear();

                        window.location.href = "<?php echo $home_page ?><?php echo $User_login_url; ?>User-Login<?php echo $online_offline_extention ?>"


                    } else {
                        alert("Logout failed: " + json[0].error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Server error during logout");
                }
            });
        }

        // Header-specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggleBtn = document.getElementById('mobileToggleBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (mobileToggleBtn) {
                mobileToggleBtn.addEventListener('click', () => {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        sidebar.classList.add('mobile-open');
                        sidebarOverlay.classList.add('active');
                    }
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        sidebar.classList.remove('mobile-open');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            }
        });
    </script>
<?php endif; ?>