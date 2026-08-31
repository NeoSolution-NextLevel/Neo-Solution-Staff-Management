<!-- components/header.php -->
<?php if (!isset($header_included)): ?>
    <?php $header_included = true; ?>

    <style>
        /* =========================================================
       ERP HEADER
       ========================================================= */
        .erp-header {
            height: 50px;
            background: var(--erp-primary-dark);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            font-size: 14px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 103;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .erp-header__title {
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 1;
        }

        .erp-header__icons {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-shrink: 0;
        }

        .erp-header__icon {
            cursor: pointer;
            padding: 6px;
            border-radius: 4px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .erp-header__icon:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Mobile Menu Toggle */
        .erp-mobile-toggle {
            display: none;
            position: fixed;
            top: 58px;
            left: 16px;
            z-index: 104;
            background: var(--erp-primary);
            color: white;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .erp-mobile-toggle svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        /* Overlay for mobile */
        .erp-sidebar-overlay {
            display: none;
            position: fixed;
            top: 50px;
            left: 0;
            width: 100%;
            height: calc(100% - 50px - 32px);
            background: rgba(0, 0, 0, 0.5);
            z-index: 101;
        }

        @media (max-width: 768px) {
            .erp-mobile-toggle {
                display: flex;
            }

            .erp-header {
                padding: 0 16px;
            }

            .erp-header__title {
                font-size: 13px;
                max-width: 180px;
            }

            .erp-header__icons {
                gap: 6px;
            }

            .erp-header__icon {
                padding: 4px;
            }

            .erp-header__icon svg {
                width: 18px;
                height: 18px;
            }

            .erp-sidebar-overlay.active {
                display: block;
            }

            @media (max-width: 480px) {
                .erp-header__title {
                    display: none;
                }

                .erp-header {
                    justify-content: flex-end;
                }

                .erp-header__icons {
                    width: 100%;
                    justify-content: space-around;
                }
            }
        }
    </style>


    <button class="erp-mobile-toggle" id="mobileToggleBtn">
        <svg viewBox="0 0 24 24">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
        </svg>
    </button>
    <div class="erp-sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ================= TOP BAR ================= -->
    <header class="erp-header">

        <div class="erp-header__title">Welcome To Metro International Duty Free (Pvt) Ltd Dashboardll</div>
        <div class="erp-header__icons">
            <span class="erp-header__icon" title="Notifications">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                </svg>
            </span>
            <span class="erp-header__icon" title="Item Service Management" onclick="Item_Service_Management_OPEN()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                </svg>
            </span>
            <span class="erp-header__icon" title="User Profile" onclick="User_Profile_OPEN()" id="main_profile_page_user_profile_icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </span>
            <span class="erp-header__icon" title="Messages">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z" />
                </svg>
            </span>
            <span class="erp-header__icon" title="Logout" onclick="logoutUser()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                </svg>
            </span>



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