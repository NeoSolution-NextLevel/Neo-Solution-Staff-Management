<script>
// Tab 06 Job Information delegated to Tab 02 My Profile
window.fetchJobInformation = function() {
  if (typeof window.fetchEmployeeProfileData === 'function') {
    window.fetchEmployeeProfileData();
  }
};
</script>

