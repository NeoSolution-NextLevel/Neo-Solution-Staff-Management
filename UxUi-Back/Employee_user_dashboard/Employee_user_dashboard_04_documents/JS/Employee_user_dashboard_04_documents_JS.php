<script>
(function () {
    const init = () => {

    const menuBtn = document.getElementById('menuBtn');
    function toggleMobleSidebar() {
        if (typeof openEmployeeSidebar === 'function') {
            openEmployeeSidebar();
        } else {
            const sidebar = document.getElementById('employeeSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar?.classList.toggle('mobile-open');
            overlay?.classList.toggle('active');
        }
    }

    if (menuBtn) {
        menuBtn.addEventListener('click', toggleMobileSidebar);
    }

    
    }
})
</script>