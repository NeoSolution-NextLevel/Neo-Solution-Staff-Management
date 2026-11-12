<script>
(function () {
  const init = () => {

    // ---- Mobile sidebar toggle ----
    const menuBtn = document.getElementById('menuBtn');

    function toggleMobileSidebar() {
      if (typeof openAdminSidebar === 'function') {
        openAdminSidebar();
      } else {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar?.classList.toggle('mobile-open');
        overlay?.classList.toggle('active');
      }
    }

    if (menuBtn) {
      menuBtn.addEventListener('click', toggleMobileSidebar);
    }

    // Live database rows are rendered directly from backend controller
  };

  // Safe DOM readiness execution check
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>