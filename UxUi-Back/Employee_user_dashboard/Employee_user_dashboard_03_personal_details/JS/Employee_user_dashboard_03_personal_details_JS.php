<script>
// Tab 03 Personal Details delegated to Tab 02
window.fetchPersonalDetails = function() {
  if (typeof window.fetchEmployeeProfileData === 'function') {
    window.fetchEmployeeProfileData();
  }
};

window.openEditPersonalDetailsModal = function() {
  if (typeof window.openEditProfileModal === 'function') {
    window.openEditProfileModal();
  }
};

window.closeEditPersonalDetailsModal = function() {
  if (typeof window.closeEditProfileModal === 'function') {
    window.closeEditProfileModal();
  }
};

window.savePersonalDetailsEdits = function(e) {
  if (typeof window.saveProfileEdits === 'function') {
    window.saveProfileEdits(e);
  }
};
</script>
