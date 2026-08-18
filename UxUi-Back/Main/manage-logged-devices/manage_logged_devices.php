   <div class="erp-container">
       <div class="erp-dashboard-card">
           <!-- Header Section -->
           <div class="erp-dashboard-card__header">
               <div>
                   <h1 class="erp-dashboard-card__title">Linked Devices</h1>
                   <p class="erp-dashboard-card__subtitle">Manage devices where your account is logged in</p>
               </div>
               <button class="erp-btn erp-btn--primary" onclick="refreshDevices()">
                   <i class="fas fa-sync-alt"></i>
                   <span>Refresh</span>
               </button>
           </div>

           <!-- Security Alert -->
           <div class="erp-security-alert erp-mt-xl">
               <i class="fas fa-shield-alt erp-security-alert__icon"></i>
               <div class="erp-security-alert__content">
                   <div class="erp-security-alert__title">Security Notice</div>
                   <div class="erp-security-alert__text">
                       Review the devices that have accessed your account. If you see any devices you don't recognize,
                       log them out immediately and consider changing your password.
                   </div>
               </div>
           </div>

           <!-- Action Bar -->
           <div class="erp-action-bar">
               <div class="erp-action-bar__info">
                   <div class="erp-action-bar__count"><span id="manage_logged_devices_device_count"></span> Active Sessions</div>
                   <div class="erp-text-tertiary">Last updated: Just now</div>
               </div>
               <button class="erp-btn erp-btn--danger-outline" onclick="openTerminateAllModal()">
                   <i class="fas fa-sign-out-alt"></i>
                   <span>Terminate All Other Sessions</span>
               </button>
           </div>

           <!-- Devices List -->
           <div class="erp-devices-list">
               <!-- Current Device -->
               <!-- <div class="erp-device-card erp-device-card--current">
                   <div class="erp-device-card__icon">
                       <i class="fas fa-laptop"></i>
                   </div>
                   <div class="erp-device-card__content">
                       <div class="erp-device-card__title">
                           Windows PC - Chrome
                           <span class="erp-device-card__badge">This Device</span>
                       </div>
                       <div class="erp-device-card__details">
                           IP: 192.168.1.105 • Location: New York, US
                       </div>
                       <div class="erp-device-card__time">
                           Active now • Last activity: 2 minutes ago
                       </div>
                   </div>
                   <div class="erp-device-card__actions">
                       <button class="erp-btn erp-btn--outline" disabled>
                           <i class="fas fa-info-circle"></i>
                           <span>Current</span>
                       </button>
                   </div>
               </div> -->

               <div id="manage_logged_devices_login_container_body_02_main_cotainer">
               </div>



               <div id="manage_logged_devices_login_container_body_01">

                   <!-- Other Devices -->
                   <!-- <div class="erp-device-card">
                       <div class="erp-device-card__icon">
                           <i class="fas fa-mobile-alt"></i>
                       </div>
                       <div class="erp-device-card__content">
                           <div class="erp-device-card__title">
                               iPhone 13 - Safari
                           </div>
                           <div class="erp-device-card__details">
                               IP: 192.168.1.102 • Location: New York, US
                           </div>
                           <div class="erp-device-card__time">
                               Last active: 5 hours ago
                           </div>
                       </div>
                       <div class="erp-device-card__actions">
                           <button class="erp-btn erp-btn--danger-outline" onclick="terminateDevice('device1')">
                               <i class="fas fa-sign-out-alt"></i>
                               <span>Log Out</span>
                           </button>
                       </div>
                   </div>

                   <div class="erp-device-card">
                       <div class="erp-device-card__icon">
                           <i class="fas fa-tablet-alt"></i>
                       </div>
                       <div class="erp-device-card__content">
                           <div class="erp-device-card__title">
                               iPad Pro - Chrome
                           </div>
                           <div class="erp-device-card__details">
                               IP: 203.0.113.45 • Location: Chicago, US
                           </div>
                           <div class="erp-device-card__time">
                               Last active: 2 days ago
                           </div>
                       </div>
                       <div class="erp-device-card__actions">
                           <button class="erp-btn erp-btn--danger-outline" onclick="terminateDevice('device2')">
                               <i class="fas fa-sign-out-alt"></i>
                               <span>Log Out</span>
                           </button>
                       </div>
                   </div>

                   <div class="erp-device-card">
                       <div class="erp-device-card__icon">
                           <i class="fas fa-laptop"></i>
                       </div>
                       <div class="erp-device-card__content">
                           <div class="erp-device-card__title">
                               MacBook Pro - Firefox
                           </div>
                           <div class="erp-device-card__details">
                               IP: 198.51.100.23 • Location: London, UK
                           </div>
                           <div class="erp-device-card__time">
                               Last active: 1 week ago
                           </div>
                       </div>
                       <div class="erp-device-card__actions">
                           <button class="erp-btn erp-btn--danger-outline" onclick="terminateDevice('device3')">
                               <i class="fas fa-sign-out-alt"></i>
                               <span>Log Out</span>
                           </button>
                       </div>
                   </div>

                   <div class="erp-device-card">
                       <div class="erp-device-card__icon">
                           <i class="fas fa-desktop"></i>
                       </div>
                       <div class="erp-device-card__content">
                           <div class="erp-device-card__title">
                               Desktop PC - Edge
                               <span class="erp-device-card__badge" style="background-color: var(--erp-accent-warning);">Unusual</span>
                           </div>
                           <div class="erp-device-card__details">
                               IP: 203.0.113.78 • Location: Tokyo, JP
                           </div>
                           <div class="erp-device-card__time">
                               Last active: 3 hours ago
                           </div>
                       </div>
                       <div class="erp-device-card__actions">
                           <button class="erp-btn erp-btn--danger" onclick="terminateDevice('device4')">
                               <i class="fas fa-exclamation-triangle"></i>
                               <span>Terminate</span>
                           </button>
                       </div>
                   </div> -->

               </div>


           </div>

           <!-- Additional Information -->
           <div class="erp-mt-xl erp-text-tertiary" style="font-size: 14px;">
               <p><i class="fas fa-info-circle"></i> <strong>Note:</strong> Terminating a session will log you out from that device.
                   Any unsaved work may be lost. You will need to log in again on that device to access your account.</p>
           </div>
       </div>
   </div>

   <!-- Modal for Terminate All Confirmation -->
   <div class="erp-modal" id="terminateAllModal">
       <div class="erp-modal__content">
           <div class="erp-modal__header">
               <div class="erp-modal__title">Terminate All Other Sessions</div>
               <button class="erp-modal__close" onclick="closeTerminateAllModal()">&times;</button>
           </div>
           <div class="erp-modal__body">
               <div class="erp-security-alert">
                   <i class="fas fa-exclamation-triangle erp-security-alert__icon"></i>
                   <div class="erp-security-alert__content">
                       <div class="erp-security-alert__title">Security Alert</div>
                       <div class="erp-security-alert__text">
                           You are about to log out from all other devices. This action cannot be undone.
                       </div>
                   </div>
               </div>

               <div class="erp-mt-md">
                   <p>The following devices will be logged out:</p>
                   <ul style="padding-left: var(--erp-space-lg); margin-top: var(--erp-space-sm); color: var(--erp-text-secondary);" id="manage_logged_devices_remove_all_device_content">
                       <!-- <li>iPhone 13 - Safari (Active 5 hours ago)</li>
                       <li>iPad Pro - Chrome (Active 2 days ago)</li>
                       <li>MacBook Pro - Firefox (Active 1 week ago)</li>
                       <li>Desktop PC - Edge (Active 3 hours ago)</li> -->
                   </ul>
               </div>

               <div class="erp-mt-md">
                   <p><strong>You will remain logged in on this device.</strong></p>
               </div>
           </div>
           <div class="erp-modal__footer">
               <button class="erp-btn erp-btn--outline" onclick="closeTerminateAllModal()">Cancel</button>
               <button class="erp-btn erp-btn--danger" onclick="terminateAllSessions()">
                   <i class="fas fa-sign-out-alt"></i>
                   <span>Terminate All Sessions</span>
               </button>
           </div>
       </div>
   </div>

   <!-- Modal for Single Device Termination -->
   <div class="erp-modal" id="terminateDeviceModal">
       <div class="erp-modal__content">
           <div class="erp-modal__header">
               <div class="erp-modal__title">Log Out Device</div>
               <button class="erp-modal__close" onclick="closeTerminateDeviceModal()">&times;</button>
           </div>
           <div class="erp-modal__body">
               <p>Are you sure you want to log out from this device?</p>
               <div class="erp-mt-md" id="deviceInfo">
                   <!-- Device info will be inserted here -->
               </div>
           </div>
           <div class="erp-modal__footer">
               <button class="erp-btn erp-btn--outline" onclick="closeTerminateDeviceModal()">Cancel</button>
               <button class="erp-btn erp-btn--danger" id="confirmTerminateBtn">
                   <i class="fas fa-sign-out-alt"></i>
                   <span>Log Out Device</span>
               </button>
           </div>
       </div>
   </div>