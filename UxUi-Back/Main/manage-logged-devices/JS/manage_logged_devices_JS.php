 <script>
     function main_user_login_device_SET_DB() {
         var container = document.getElementById("manage_logged_devices_login_container_body_01");
         var current_container = document.getElementById("manage_logged_devices_login_container_body_02_main_cotainer");
         $(container).empty();
         $(current_container).empty();
         var device_count = 0;




         $.ajax({
             url: "<?php echo $pth; ?>View-List/Main/device_managment/main_user_login_device_LIST.php",
             type: "POST",
             success: function(response) {
                 //  alert(response)

                 var json_data = JSON.parse(response);
                 //alert("success: " + JSON.stringify(json_data));
                 console.log("jsone_data : " + json_data);

                 if (json_data.length === 0) {

                 } else {
                     for (var i = 0; i < json_data.length; i++) {

                         if (json_data[i].is_active == 1) {
                             main_user_login_device_currenty_device_details(json_data[i]);

                             device_count += 1;

                         } else {
                             device_count += 1;
                             main_user_login_device_SHOW_DATA(json_data[i]);

                         }
                     }
                     var device_count_obj = document.getElementById("manage_logged_devices_device_count");
                     $(device_count_obj).empty();
                     device_count_obj.innerHTML = device_count;
                 }
             },
             error: function(xhr, status, error) {
                 console.error("Failed to load job tags:", error);
             }
         });
     }

     function main_user_login_device_currenty_device_details(json) {

         var container = document.getElementById("manage_logged_devices_login_container_body_01");

         // ===== MAIN CARD =====
         const deviceCard = document.createElement("div");
         deviceCard.className = "erp-device-card erp-device-card--current";

         // ===== ICON SECTION =====
         const iconDiv = document.createElement("div");
         iconDiv.className = "erp-device-card__icon";

         const icon = document.createElement("i");
         icon.className = "fas fa-laptop"; // current device icon

         iconDiv.appendChild(icon);

         // ===== CONTENT SECTION =====
         const contentDiv = document.createElement("div");
         contentDiv.className = "erp-device-card__content";

         // Title
         const titleDiv = document.createElement("div");
         titleDiv.className = "erp-device-card__title";
         titleDiv.textContent = json.device_type + " - " + json.browser;

         // Badge
         const badgeSpan = document.createElement("span");
         badgeSpan.className = "erp-device-card__badge";
         badgeSpan.textContent = "This Device";

         titleDiv.appendChild(badgeSpan);

         // Details
         const detailsDiv = document.createElement("div");
         detailsDiv.className = "erp-device-card__details";
         detailsDiv.textContent =
             "IP: " + json.ip_address + " • Location: " + json.location;

         // Time
         const timeDiv = document.createElement("div");
         timeDiv.className = "erp-device-card__time";
         timeDiv.textContent =
             "Active now • Last activity: " + json.last_activity;

         contentDiv.appendChild(titleDiv);
         contentDiv.appendChild(detailsDiv);
         contentDiv.appendChild(timeDiv);

         // ===== ACTIONS SECTION =====
         const actionsDiv = document.createElement("div");
         actionsDiv.className = "erp-device-card__actions";

         const currentBtn = document.createElement("button");
         currentBtn.className = "erp-btn erp-btn--outline";
         currentBtn.disabled = true;

         const infoIcon = document.createElement("i");
         infoIcon.className = "fas fa-info-circle";

         const btnText = document.createElement("span");
         btnText.textContent = "Current";

         currentBtn.appendChild(infoIcon);
         currentBtn.appendChild(btnText);

         actionsDiv.appendChild(currentBtn);

         // ===== ASSEMBLE CARD =====
         deviceCard.appendChild(iconDiv);
         deviceCard.appendChild(contentDiv);
         deviceCard.appendChild(actionsDiv);

         container.appendChild(deviceCard);
     }


     function main_user_login_device_SHOW_DATA(json) {

         var container = document.getElementById("manage_logged_devices_login_container_body_01");

         // ===== MAIN CARD =====
         const deviceCard = document.createElement("div");
         deviceCard.className = "erp-device-card";

         // ===== ICON SECTION =====
         const iconDiv = document.createElement("div");
         iconDiv.className = "erp-device-card__icon";

         const icon = document.createElement("i");
         if (json.device_type == "Mobile") {
             icon.className = "fas fa-mobile-alt";


         } else if (json.device_type == "Tablet") {
             icon.className = "fas fa-tablet-alt";
         } else if (json.device_type == "Desktop") {
             icon.className = "fas fa-desktop";
         } else {
             icon.className = "fas fa-mobile-alt";


         }

         iconDiv.appendChild(icon);

         // ===== CONTENT SECTION =====
         const contentDiv = document.createElement("div");
         contentDiv.className = "erp-device-card__content";

         // Title
         const titleDiv = document.createElement("div");
         titleDiv.className = "erp-device-card__title";
         titleDiv.textContent = json.device_type + " - " + json.browser;

         // Details
         const detailsDiv = document.createElement("div");
         detailsDiv.className = "erp-device-card__details";
         detailsDiv.textContent = "IP: " + json.ip_address + " • Location: " + json.location;

         // Time
         const timeDiv = document.createElement("div");
         timeDiv.className = "erp-device-card__time";
         timeDiv.textContent = "Last active: " + json.last_activity;

         // Append content
         contentDiv.appendChild(titleDiv);
         contentDiv.appendChild(detailsDiv);
         contentDiv.appendChild(timeDiv);

         // ===== ACTIONS SECTION =====
         const actionsDiv = document.createElement("div");
         actionsDiv.className = "erp-device-card__actions";

         if (json.is_active == "1") {

             const logoutBtn = document.createElement("button");
             logoutBtn.className = "erp-btn erp-btn--danger-outline";

             const logoutIcon = document.createElement("i");
             logoutIcon.className = "fas fa-sign-out-alt";

             const logoutText = document.createElement("span");
             logoutText.textContent = "Log Out";

             logoutBtn.appendChild(logoutIcon);
             logoutBtn.appendChild(logoutText);

             actionsDiv.appendChild(logoutBtn);

             logoutBtn.addEventListener("click", function() {

                 openTerminateDeviceModal(json.id, json.device_type, json.last_activity);
             });

         } else {
             const logoutBtn = document.createElement("button");
             logoutBtn.className = "erp-btn erp-btn--danger-outline";

             const logoutIcon = document.createElement("i");
             logoutIcon.className = "fas fa-sign-out-alt";

             const logoutText = document.createElement("span");
             logoutText.textContent = "Already Logout ";

             logoutBtn.appendChild(logoutIcon);
             logoutBtn.appendChild(logoutText);

             actionsDiv.appendChild(logoutBtn);


         }



         // ===== ASSEMBLE CARD =====
         deviceCard.appendChild(iconDiv);
         deviceCard.appendChild(contentDiv);
         deviceCard.appendChild(actionsDiv);

         container.appendChild(deviceCard);


     }

     function main_user_login_device_remove_all_List_SET_DB() {
         var container = document.getElementById("manage_logged_devices_remove_all_device_content");
         $(container).empty();



         var sending_value = "all_device_without_crrent=0"

         $.ajax({
             url: "<?php echo $pth; ?>View-List/Main/device_managment/main_user_login_device_LIST.php",
             type: "POST",
             success: function(response) {
                 //  alert(response)

                 var json_data = JSON.parse(response);
                 //alert("success: " + JSON.stringify(json_data));

                 if (json_data.length === 0) {

                 } else {
                     for (var i = 0; i < json_data.length; i++) {
                         main_user_login_device_remove_all_List_SHOW_DATA(json_data[i]);


                     }

                 }
             },
             error: function(xhr, status, error) {
                 console.error("Failed to load job tags:", error);
             }
         });
     }

     function main_user_login_device_remove_all_List_SHOW_DATA(json) {
         var container = document.getElementById("manage_logged_devices_remove_all_device_content");

         var li = document.createElement("li");
         li.textContent = json.device_type + " - " + json.browser + " ( Active " + json.last_activity + " ) ";
         container.appendChild(li);


     }

     function main_user_login_device_remove(deviceId, is_all_termination) {

         if (is_all_termination) {
             var sending_value = "all_remove=0";

         } else {
             var sending_value = "id=" + encodeURIComponent(deviceId) + "&remove=0";


         }




         $.ajax({
             url: "<?php echo $pth; ?>View-List/Main/device_managment/main_user_login_device_remove.php",
             type: "POST",
             data: sending_value,
             success: function(response) {

                 var json_data = JSON.parse(response);
                 //alert("success: " + JSON.stringify(json_data));
                 console.log("jsone_data : " + json_data);

                 if (json_data.length === 0) {

                 } else {
                     for (var i = 0; i < json_data.length; i++) {

                         if (json_data[i].is_active == 1) {
                             main_user_login_device_currenty_device_details(json_data[i]);

                             device_count += 1;

                         } else {
                             device_count += 1;
                             main_user_login_device_SHOW_DATA(json_data[i]);

                         }
                     }
                     var device_count_obj = document.getElementById("manage_logged_devices_device_count");
                     $(device_count_obj).empty();
                     device_count_obj.innerHTML = device_count;
                 }
             },
             error: function(xhr, status, error) {
                 console.error("Failed to load job tags:", error);
             }
         });

     }






     // Modal functions
     function openTerminateAllModal() {
         main_user_login_device_remove_all_List_SET_DB();
         document.getElementById('terminateAllModal').classList.add('erp-modal--active');
     }

     function closeTerminateAllModal() {
         document.getElementById('terminateAllModal').classList.remove('erp-modal--active');
     }

     function openTerminateDeviceModal(deviceId, deviceName, lastActive) {
         const deviceInfo = document.getElementById('deviceInfo');
         deviceInfo.innerHTML = `
                <div class="erp-device-card">
                    <div class="erp-device-card__content">
                        <div class="erp-device-card__title">${deviceName}</div>
                        <div class="erp-device-card__time">Last active: ${lastActive}</div>
                    </div>
                </div>
            `;

         // Set up confirm button
         const confirmBtn = document.getElementById('confirmTerminateBtn');
         confirmBtn.onclick = function() {
             terminateDeviceConfirmed(deviceId);
         };

         document.getElementById('terminateDeviceModal').classList.add('erp-modal--active');
     }

     function closeTerminateDeviceModal() {
         document.getElementById('terminateDeviceModal').classList.remove('erp-modal--active');
     }


     function terminateDeviceConfirmed(deviceId) {
         // Show loading state
         const confirmBtn = document.getElementById('confirmTerminateBtn');
         const originalText = confirmBtn.innerHTML;
         confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Processing...</span>';
         confirmBtn.disabled = true;

         // Simulate API call
         setTimeout(() => {
             // In a real application, you would make an API call here
             console.log(`Terminated device: ${deviceId}`);

             main_user_login_device_remove(deviceId, false);

             // Close modal
             closeTerminateDeviceModal();

             main_user_login_device_SET_DB();

             // Reset button
             confirmBtn.innerHTML = originalText;
             confirmBtn.disabled = false;

             showNotification('Device logged out successfully.', 'success');

             // Reset button
             confirmBtn.innerHTML = originalText;
             confirmBtn.disabled = false;
         }, 1000);
     }

     function terminateAllSessions() {
         // Show loading state
         const confirmBtn = document.querySelector('#terminateAllModal .erp-btn--danger');
         const originalText = confirmBtn.innerHTML;
         confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Processing...</span>';
         confirmBtn.disabled = true;

         // Simulate API call
         setTimeout(() => {
             // In a real application, you would make an API call here
             console.log('Terminated all other sessions');


             // Close modal
             closeTerminateAllModal();

             main_user_login_device_remove(0, true);

             // Close modal
             closeTerminateDeviceModal();

             main_user_login_device_SET_DB();


             showNotification('All other sessions have been terminated successfully.', 'success');


             // Reset button
             confirmBtn.innerHTML = originalText;
             confirmBtn.disabled = false;
         }, 1500);
     }

     function refreshDevices() {
         // Show loading state
         const refreshBtn = document.querySelector('.erp-dashboard-card__header .erp-btn');
         const originalText = refreshBtn.innerHTML;
         refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Refreshing...</span>';
         refreshBtn.disabled = true;

         // Simulate API call to refresh devices
         setTimeout(() => {
             // In a real application, you would fetch updated device list from API
             console.log('Refreshed devices list');
             main_user_login_device_SET_DB();


             // Update last updated time
             const lastUpdated = document.querySelector('.erp-action-bar__info .erp-text-tertiary');
             lastUpdated.textContent = 'Last updated: Just now';

             // Reset button
             refreshBtn.innerHTML = originalText;
             refreshBtn.disabled = false;

             // Show notification
             showNotification('Devices list refreshed successfully.', 'success');
         }, 1000);
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
                background-color: ${type === 'success' ? 'var(--erp-accent-success)' : 'var(--erp-accent-error)'};
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
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `;

         document.body.appendChild(notification);

         // Remove after 3 seconds
         setTimeout(() => {
             notification.style.animation = 'slideOut 0.3s ease';
             setTimeout(() => {
                 document.body.removeChild(notification);
             }, 300);
         }, 3000);
     }

     // Add CSS animations for notifications
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
         const terminateAllModal = document.getElementById('terminateAllModal');
         const terminateDeviceModal = document.getElementById('terminateDeviceModal');

         if (event.target === terminateAllModal) {
             closeTerminateAllModal();
         }

         if (event.target === terminateDeviceModal) {
             closeTerminateDeviceModal();
         }
     };
 </script>