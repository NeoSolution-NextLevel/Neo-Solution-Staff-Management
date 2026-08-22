    <div class="erp-container erp-container--profile">
        <input type="hidden" id="User_Profile_A_01_val_17" value="">
        <input type="hidden" id="User_Profile_A_01_val_18" value="">
        <input type="hidden" id="User_Profile_A_01_val_19_otp" value="">
        <input type="hidden" id="User_Profile_A_01_val_20" value="">
        <div class="erp-profile-card">
            <!-- Header Section: Displays page title -->
            <div class="erp-profile-card__header">
                <div class="erp-profile-card__brand" style="display: flex; justify-content: center; margin-bottom: 12px;">
                    <svg viewBox="0 0 280 100" width="180" height="60" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="prfBlueSphere" cx="32%" cy="30%" r="68%">
                                <stop offset="0%" stop-color="#7399f7"/>
                                <stop offset="25%" stop-color="#2b4db3"/>
                                <stop offset="60%" stop-color="#142668"/>
                                <stop offset="90%" stop-color="#091338"/>
                                <stop offset="100%" stop-color="#04091c"/>
                            </radialGradient>
                            <radialGradient id="prfGreenSphere" cx="32%" cy="30%" r="68%">
                                <stop offset="0%" stop-color="#5ec95e"/>
                                <stop offset="25%" stop-color="#238029"/>
                                <stop offset="60%" stop-color="#125219"/>
                                <stop offset="90%" stop-color="#0a3310"/>
                                <stop offset="100%" stop-color="#041a08"/>
                            </radialGradient>
                            <linearGradient id="prfSpecularGlow" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ffffff" stop-opacity="0.6"/>
                                <stop offset="40%" stop-color="#ffffff" stop-opacity="0.1"/>
                                <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
                            </linearGradient>
                            <filter id="prfSphereShadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="1.5" dy="2.5" stdDeviation="2" flood-color="#0a1535" flood-opacity="0.3"/>
                            </filter>
                        </defs>
                        <g transform="translate(6, 4)" filter="url(#prfSphereShadow)">
                            <circle cx="28" cy="28" r="17" fill="url(#prfBlueSphere)"/>
                            <ellipse cx="23" cy="23" rx="7" ry="4" fill="url(#prfSpecularGlow)" transform="rotate(-30 23 23)"/>
                            <circle cx="62" cy="38" r="16" fill="url(#prfGreenSphere)"/>
                            <ellipse cx="57" cy="33" rx="6" ry="3.5" fill="url(#prfSpecularGlow)" transform="rotate(-30 57 33)"/>
                            <circle cx="30" cy="62" r="16" fill="url(#prfGreenSphere)"/>
                            <ellipse cx="25" cy="57" rx="6" ry="3.5" fill="url(#prfSpecularGlow)" transform="rotate(-30 25 57)"/>
                            <circle cx="62" cy="72" r="17" fill="url(#prfBlueSphere)"/>
                            <ellipse cx="57" cy="67" rx="7" ry="4" fill="url(#prfSpecularGlow)" transform="rotate(-30 57 67)"/>
                        </g>
                        <text x="96" y="58" font-family="'Impact', 'Arial Black', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="58" font-weight="900" letter-spacing="2.5" fill="#ffffff">NEO</text>
                        <text x="130" y="84" font-family="'Playfair Display', 'Georgia', 'Times New Roman', serif" font-size="28" font-style="italic" font-weight="600" letter-spacing="0.5" fill="#dbeafe">Solution</text>
                    </svg>
                </div>
                <h1 class="erp-profile-card__title">User Profile</h1>
                <p class="erp-profile-card__subtitle">Manage your account settings and preferences</p>
            </div>

            <!-- Main Body: Contains the profile content -->
            <div class="erp-profile-card__body">
                <form class="erp-form" method="POST">

                    <!-- Profile Header: Picture and basic info -->
                    <div class="erp-profile-header">
                        <div class="erp-profile-picture">
                            <div class="erp-profile-picture__wrapper">
                                <input type="hidden" id="User_Profile_A_01_from_id_image_pth_txt" value="0">
                                <?php $get_image_form_id_setup = "User_Profile_A_01_from_id" ?>

                                <!-- Profile Picture -->
                                <img src=""
                                    alt="Profile Picture"
                                    class="erp-profile-picture__img"
                                    id="profile-image"
                                    style="display: none;">

                                <!-- Default Icon -->
                                <div class="erp-profile-picture__default" id="profile-default">
                                    <i class="fas fa-user"></i>
                                </div>

                                <!-- Hidden File Input -->
                                <input type="file"
                                    id="profile-upload"
                                    name="image_uploder_image"
                                    class="erp-profile-picture__upload-input"
                                    accept="image/*"
                                    hidden>


                            </div>

                            <!-- Upload Button -->
                            <div class="erp-profile-picture__upload" id="<?php echo $get_image_form_id_setup ?>_uploadTrigger">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>


                        <div class="erp-profile-info">
                            <h2 class="erp-profile-info__name" id="User_Profile_A_01_val_02">Alex Johnson</h2>
                            <p class="erp-profile-info__role" id="User_Profile_A_01_val_03">Senior System Administrator</p>

                            <div class="erp-profile-info__meta">
                                <div class="erp-profile-info__meta-item">
                                    <i class="fas fa-envelope erp-profile-info__meta-icon"></i>
                                    <span id="User_Profile_A_01_val_04">alex.johnson@company.com</span>
                                </div>
                                <div class="erp-profile-info__meta-item">
                                    <i class="fas fa-building erp-profile-info__meta-icon"></i>
                                    <span>Department:<span id="User_Profile_A_01_val_05"> IT</span></span>
                                </div>
                                <div class="erp-profile-info__meta-item">
                                    <i class="fas fa-id-badge erp-profile-info__meta-icon"></i>
                                    <span>Employee ID: <span id="User_Profile_A_01_val_06">EMP-2023-0456</span></span>
                                </div>
                                <div class="erp-profile-info__meta-item">
                                    <i class="fas fa-calendar-alt erp-profile-info__meta-icon"></i>
                                    <span>Joined:<span id="User_Profile_A_01_val_07"> AprilMarch 15, 2021</span></span>
                                </div>
                            </div>

                            <p class="erp-profile-info__bio" id="User_Profile_A_01_val_08">
                                Responsible for system administration, user management, and security protocols.
                                Oversees ERP implementation and provides technical support to all departments.
                            </p>
                        </div>
                    </div>

                    <!-- Personal Information Form -->
                    <div class="erp-form__section">
                        <h3 class="erp-form__section-title">Personal Information</h3>

                        <div class="erp-form__grid">
                            <div class="erp-form__group">
                                <label class="erp-form__label">First Name</label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-user erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        value="Alex"
                                        id="User_Profile_A_01_val_09"
                                        aria-label="First Name">
                                </div>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Last Name</label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-user erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        value="Johnson"
                                        id="User_Profile_A_01_val_10"
                                        aria-label="Last Name">
                                </div>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Email Address</label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-envelope erp-form__icon"></i>
                                    <input
                                        type="email"
                                        class="erp-form__control erp-form__control--with-icon"
                                        value="alex.johnson@company.com"
                                        id="User_Profile_A_01_val_11"
                                        disabled
                                        aria-label="Email Address">
                                </div>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Phone Number</label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-phone erp-form__icon"></i>
                                    <input
                                        type="tel"
                                        class="erp-form__control erp-form__control--with-icon"
                                        value="+1 (555) 123-4567"
                                        id="User_Profile_A_01_val_12"
                                        aria-label="Phone Number">
                                </div>
                            </div>


                            <div class="erp-form__group">
                                <label class="erp-form__label">Department</label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-building erp-form__icon"></i>
                                    <input
                                        type="text"
                                        class="erp-form__control erp-form__control--with-icon"
                                        value="alex.johnson@company.com"
                                        id="User_Profile_A_01_val_13"
                                        disabled
                                        aria-label="Email Address">
                                </div>
                            </div>

                            <div class="erp-form__group">
                                <label class="erp-form__label">Job Title</label>
                                <div class="erp-input-wrapper">
                                    <i class="fas fa-briefcase erp-form__icon"></i>
                                    <input
                                        type="email"
                                        class="erp-form__control erp-form__control--with-icon"
                                        id="User_Profile_A_01_val_14"
                                        disabled
                                        aria-label="Email Address">
                                </div>
                            </div>



                        </div>



                    </div>

                    <div class="erp-form__group">
                        <label class="erp-form__label">Bio / Description</label>
                        <textarea
                            class="erp-form__control"
                            rows="4"
                            id="User_Profile_A_01_val_15"
                            aria-label="Bio / Description">Responsible for system administration, user management, and security protocols. Oversees ERP implementation and provides technical support to all departments.</textarea>
                    </div>


                    <!-- Security Settings Section -->
                    <div class="erp-form__section">
                        <h3 class="erp-form__section-title">Security Settings</h3>

                        <div class="erp-security-settings">
                            <div class="erp-security-item">
                                <div class="erp-security-item__info">
                                    <div class="erp-security-item__title">Password</div>
                                    <div class="erp-security-item__description">Last changed 30 days ago</div>
                                </div>
                                <div class="erp-security-item__status">
                                    <span class="erp-status-badge erp-status-badge--enabled">Active</span>
                                    <button class="erp-btn erp-btn--secondary" type="button"
                                        onclick="window.location.href='<?php echo $home_page ?><?php echo $User_login_url ?>change-password<?php echo $online_offline_extention;  ?>'">
                                        <i class="fas fa-key"></i>
                                        <span>Change</span>
                                    </button>

                                </div>
                            </div>

                            <div class="erp-security-item">
                                <div class="erp-security-item__info">
                                    <div class="erp-security-item__title">Two-Factor Authentication</div>
                                    <div class="erp-security-item__description">Add an extra layer of security to your account</div>
                                </div>
                                <div class="erp-security-item__status">
                                    <span class="erp-status-badge erp-status-badge--disabled" id="two-factor-auth-status">Disabled</span>
                                    <button class="erp-btn erp-btn--secondary" type="button" id="two-factor-auth-toggle" onclick="send_two_step_verification_sms()">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Enable</span>
                                    </button>
                                </div>
                            </div>

                            <div id="two-factor-auth-fields" style="display: none; padding-top: var(--erp-space-lg);">
                                <div class="erp-form__grid">
                                    <div class="erp-form__group">
                                        <label class="erp-form__label">Phone Number for 2FA</label>
                                        <div class="erp-input-wrapper">
                                            <i class="fas fa-mobile-alt erp-form__icon"></i>
                                            <input
                                                type="tel"
                                                class="erp-form__control erp-form__control--with-icon"
                                                placeholder="Enter phone number"
                                                id="two-factor-phone-number"
                                                disabled
                                                aria-label="Phone Number for Two-Factor Authentication">
                                        </div>
                                    </div>
                                    <div class="erp-form__group">
                                        <label class="erp-form__label">Verification Code (OTP)</label>
                                        <div class="erp-input-wrapper">
                                            <i class="fas fa-key erp-form__icon"></i>
                                            <input
                                                type="text"
                                                class="erp-form__control erp-form__control--with-icon"
                                                placeholder="Enter OTP"
                                                id="two-factor-otp"
                                                aria-label="One-Time Password">
                                        </div>
                                    </div>

                                </div>
                                <div class="erp-profile-actions" style="border-top: none; padding-top: 0;">
                                    <button class="erp-btn erp-btn--primary" type="button" id="two-factor-verify-btn" onclick="send_two_step_verification_check_otp()">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Verify 2FA</span>
                                    </button>
                                </div>
                            </div>


                            <!-- Google Authentication Section -->
                            <div class="erp-security-item">
                                <div class="erp-security-item__info">
                                    <div class="erp-security-item__title">Google Authentication</div>
                                    <div class="erp-security-item__description">Add an extra layer of security to your account</div>
                                </div>
                                <div class="erp-security-item__status">
                                    <span class="erp-status-badge erp-status-badge--disabled" id="google-auth-status">Not Connected</span>
                                    <!-- Google Authentication Button -->
                                    <button class="erp-btn erp-btn--google" type="button" id="google-auth-btn" onclick="Actions_google_authantication()">
                                        <i class="fab fa-google"></i>
                                        <span>Enable</span>
                                    </button>
                                </div>
                            </div>


                            <div id="google-auth-qr-section" style="display: none; padding-top: var(--erp-space-lg); text-align: center;">
                                <img src="" alt="QR Code" style="margin-bottom: var(--erp-space-md);" id="User_Profile_A_01_val_16">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">Enter Google Authenticator Code</label>
                                    <div class="erp-input-wrapper" style="max-width: 300px; margin: 0 auto;">
                                        <i class="fas fa-key erp-form__icon"></i>
                                        <input
                                            type="text"
                                            class="erp-form__control erp-form__control--with-icon"
                                            placeholder="Enter 6-digit code"
                                            id="google-auth-otp"
                                            aria-label="Google Authenticator OTP">
                                    </div>
                                </div>
                                <div class="erp-profile-actions" style="border-top: none; padding-top: 0; justify-content: center;">
                                    <button class="erp-btn erp-btn--primary" type="button" id="google-auth-verify-btn" onclick="veryfy_google_authentication()">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Verify Code</span>
                                    </button>
                                </div>
                            </div>


                            <div class="erp-security-item">
                                <div class="erp-security-item__info">
                                    <div class="erp-security-item__title">Active Sessions</div>
                                    <div class="erp-security-item__description"><span id="User_Profile_A_01_val_21">3 </span> devices currently signed in</div>
                                </div>
                                <div class="erp-security-item__status">
                                    <button class="erp-btn erp-btn--secondary" type="button" onclick="window.location.href='<?php echo $home_page ?><?php echo $User_login_url ?>manage-logged-devices<?php echo $online_offline_extention;  ?>'">
                                        <i class="fas fa-desktop"></i>
                                        <span>Manage</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="erp-form__section" style="display: none;">
                        <h3 class="erp-form__section-title">Notification Preferences</h3>

                        <div class="erp-notification-settings">
                            <div class="erp-notification-item">
                                <div class="erp-notification-item__info">
                                    <i class="fas fa-envelope erp-profile-info__meta-icon"></i>
                                    <span>Email Notifications</span>
                                </div>
                                <label class="erp-switch">
                                    <input type="checkbox" checked>
                                    <span class="erp-switch__slider"></span>
                                </label>
                            </div>



                            <div class="erp-notification-item">
                                <div class="erp-notification-item__info">
                                    <i class="fas fa-comment-dots erp-profile-info__meta-icon"></i>
                                    <span>Message Alerts</span>
                                </div>
                                <label class="erp-switch">
                                    <input type="checkbox" checked>
                                    <span class="erp-switch__slider"></span>
                                </label>
                            </div>

                            <div class="erp-notification-item" style="display: none;">
                                <div class="erp-notification-item__info">
                                    <i class="fas fa-bell erp-profile-info__meta-icon"></i>
                                    <span>Push Notifications</span>
                                </div>
                                <label class="erp-switch">
                                    <input type="checkbox" checked>
                                    <span class="erp-switch__slider"></span>
                                </label>
                            </div>

                            <div class="erp-notification-item" style="display: none;">
                                <div class="erp-notification-item__info">
                                    <i class="fas fa-tasks erp-profile-info__meta-icon"></i>
                                    <span>Task Reminders</span>
                                </div>
                                <label class="erp-switch">
                                    <input type="checkbox">
                                    <span class="erp-switch__slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="erp-profile-actions">
                        <button class="erp-btn erp-btn--secondary erp-btn--block-mobile" type="button">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </button>
                        <button class="erp-btn erp-btn--primary erp-btn--block-mobile" type="submit">
                            <i class="fas fa-save"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <!-- Footer: Displays copyright and version info -->
        <div class="erp-profile-card__footer">
            <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> <?php echo $company_obj->get_compnay_name() ?></p>
        </div>
    </div>


    <!-- JavaScript for profile page functionality -->
    <script>
    </script>