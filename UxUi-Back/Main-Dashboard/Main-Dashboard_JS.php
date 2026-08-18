<script type="text/javascript">
    function setSidebarActive(pageName) {
        document.querySelectorAll('.wwjm-sidebar-nav-item').forEach(function(item){
            item.classList.toggle('wwjm-sidebar-active', item.getAttribute('data-page') === pageName);
        });
    }

    function main_dashboard_close_all() {
        document.getElementById("Main_dashboard_01_A").style.display = "none";
        document.getElementById("Main_dashboard_01_B").style.display = "none";
        document.getElementById("Main_dashboard_01_E").style.display = "none";
        document.getElementById("Main_dashboard_01_F").style.display = "none";
        document.getElementById("Main_dashboard_01_G").style.display = "none";
        document.getElementById("Main_dashboard_02_A").style.display = "none";
        document.getElementById("Main_dashboard_02_B").style.display = "none";
        document.getElementById("Main_dashboard_02_C").style.display = "none";
        document.getElementById("Main_dashboard_02_D").style.display = "none";
        document.getElementById("Main_dashboard_02_E").style.display = "none";
        document.getElementById("Main_dashboard_02_F").style.display = "none";
        document.getElementById("Main_dashboard_02_G").style.display = "none";
        document.getElementById("Main_dashboard_02_H").style.display = "none";
        
        
        document.getElementById("Main_Dashboard_05_01").style.display = "none";
        document.getElementById("Main_Dashboard_05_03_A").style.display = "none";
        document.getElementById("Main_Dashboard_05_03_B").style.display = "none";
    }

    function main_dashboard_01_A_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_01_A").style.display = "";
        setSidebarActive('member-list');
    }

    function main_dashboard_01_B_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_01_B").style.display = "";
        setSidebarActive('accounts');
    }

    function main_dashboard_01_E_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_01_E").style.display = "";
        setSidebarActive('member-list');
    }

    function main_dashboard_01_F_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_01_F").style.display = "";
        setSidebarActive('member-list');
    } 

    function main_dashboard_01_G_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_01_G").style.display = "";
        setSidebarActive('member-list');
    }

    function main_dashboard_02_A_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_A").style.display = "";
        setSidebarActive('payment');
    }

    function main_dashboard_02_B_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_B").style.display = "";
        setSidebarActive('payment');
    }

    function main_dashboard_02_C_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_C").style.display = "";
        setSidebarActive('payment');
    }   

    function main_dashboard_02_D_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_D").style.display = "";
        setSidebarActive('payment');
    }

    function main_dashboard_02_E_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_E").style.display = "";
        setSidebarActive('payment');
    }

    function main_dashboard_02_F_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_F").style.display = "";
        setSidebarActive('payment');
    }

    function main_dashboard_02_G_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_G").style.display = "";
        setSidebarActive('payment');
    }

    function main_dashboard_02_H_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_dashboard_02_H").style.display = "";
        setSidebarActive('payment');
    }



    function main_dashboard_05_01_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_Dashboard_05_01").style.display = "";
        setSidebarActive('settings');
    }

    function main_dashboard_05_03_A_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_Dashboard_05_03_A").style.display = "";
        setSidebarActive('settings');
    }

    function main_dashboard_05_03_B_OPEN() {
        main_dashboard_close_all();
        document.getElementById("Main_Dashboard_05_03_B").style.display = "";
        setSidebarActive('settings');
    }

    
</script>