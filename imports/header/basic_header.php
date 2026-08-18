<?php
$company_obj = new Company_Info_Variable_List();
?>



<!-- jquery -->
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- bootstrapcd -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<!-- num format -->
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<!-- fa fa icon -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allerta+Stencil">

<!-- w3.css  -->
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-signal.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-vivid.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="<?php echo $pth; ?>imports/lib/w3css_color.css">

<!-- others  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


<!-- js prict  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<link rel="icon" type="image/x-icon" href="<?php echo $company_obj->get_compnay_logo_icon_url(); ?>">


<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->

<style type="text/css">
    .w3-strong {
        font-weight: bold;
    }

    .w3-italic {
        font-style: italic;
    }

    .w3-small {
        font-size: small;
    }

    .w3-header {
        font-family: "Allerta Stencil", "Sans-serif";
    }

    a:hover {
        text-decoration: none;
    }

    a:visited {
        text-decoration: none;
    }

    .w3-input {
        color: black;
    }

    .w3-uppercase {
        text-transform: uppercase;
    }

    /* Toast container (hidden by default) */
    #toast {
        visibility: hidden;
        min-width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 50px;
        transform: translateX(-50%);
        font-size: 17px;
    }

    /* Show the toast */
    #toast.show {
        visibility: visible;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    /* Animations to fade the toast in and out */
    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }
</style>

<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->

<script type="text/javascript">
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }


    function decimal_format(get_value_of_currency_string) {
        //        alert(get_value_of_currency_string);
        return numeral(parseFloat(get_value_of_currency_string)).format('0,0.00');
    }

    function number_format(get_int_value) {
        return numeral(parseFloat(get_int_value)).format('0,0');
    }

    function numarical_formate_id(get_id_to_format) {
        return numeral(parseFloat(get_id_to_format)).format('0000000000');
    }

    function next_field(event, text_field_id) {
        if (event.keyCode === 13) {
            document.getElementById(text_field_id).focus();
        }
    }

    function selete_feild(text_field_id) {
        document.getElementById(text_field_id).focus();
    }

    function create_error(obj_text_field, error_id, error_msg) {
        $("#" + error_id).empty();
        var get_error = document.getElementById(error_id + "_body");
        get_error.style.display = "block";
        document.getElementById(error_id).appendChild(document.createTextNode(error_msg));
        obj_text_field.setAttribute("class", "w3-border-red w3-input w3-border w3-margin-16");
        preloader_hide();
    }

    function create_error_selector(obj_text_field, error_id, error_msg) {
        $("#" + error_id).empty();
        var get_error = document.getElementById(error_id + "_body");
        get_error.style.display = "block";
        document.getElementById(error_id).appendChild(document.createTextNode(error_msg));
        obj_text_field.setAttribute("class", "w3-select w3-border-red w3-border w3-margin-16");
        preloader_hide();
    }

    function create_error_without_field(error_id, error_msg) {
        $("#" + error_id).empty();
        var get_error = document.getElementById(error_id + "_body");
        get_error.style.display = "block";
        document.getElementById(error_id).appendChild(document.createTextNode(error_msg));
        preloader_hide();
    }

    function remove_erorr(obj_text_field, error_id) {
        var get_error = document.getElementById(error_id + "_body");
        get_error.style.display = "none";
        obj_text_field.setAttribute("class", "w3-input w3-border w3-border-theme w3-round");
        $("#" + error_id).empty();
    }

    function remove_erorr_selecotr(obj_text_field, error_id) {
        var get_error = document.getElementById(error_id + "_body");
        get_error.style.display = "none";
        obj_text_field.setAttribute("class", "w3-select w3-border w3-round w3-border-theme w3-padding");
        $("#" + error_id).empty();
    }

    function remove_erorr_check(obj_text_field, error_id) {
        var get_error = document.getElementById(error_id + "_body");
        get_error.style.display = "none";
        obj_text_field.setAttribute("class", "w3-check w3-margin-right");
        $("#" + error_id).empty();
    }
</script>

<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->

<!---------------------------------------------------------------------pre loader start----------------------------------------------------------------------------------------->

<script type="text/javascript">
    var ajax_state = true;
    $(document).ajaxStart(function() {
        console.log('AJAX request started');
        if (ajax_state) {
            var preloader = document.getElementById("preloader");
            if (preloader) {
                preloader.style.display = "block";
            } else {
                console.error('Element with ID "preloader" not found');
            }
        }
    });

    $(document).ajaxComplete(function() {
        console.log('AJAX request completed');
        if (ajax_state) {
            var preloader = document.getElementById("preloader");
            if (preloader) {
                preloader.style.display = "none";
            } else {
                console.error('Element with ID "preloader" not found');
            }
        }
    });

    function set_audit_trail_data(get_dis_data) {
        var sending_value = "dis=" + get_dis_data;
        $.ajax({
            url: "<?php echo $pth; ?>View-List/Audit-Trail.php",
            type: 'POST',
            data: sending_value,
            cache: false,
            success: function(data, textStatus, jqXHR) {
                //                alert(data);
            }
        });
    }

    function preloader_show() {
        document.getElementById("preloader").style.display = "block";
    }

    function preloader_hide() {
        document.getElementById("preloader").style.display = "none";
    }

    function showToast(get_text) {
        let toast = document.getElementById("toast");
        $(toast).empty();
        toast.appendChild(document.createTextNode(get_text));
        toast.className = "show"; // Add the 'show' class to make it visible

        // After 3 seconds, remove the show class to hide the toast
        setTimeout(function() {
            toast.className = toast.className.replace("show", "");
        }, 3000);
    }
</script>
<style>
    /* Preloader Styles */
    #loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    #loader {
        width: 120px;
        height: 120px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        animation: spin 2s linear infinite;
    }

    /* Logo Styles */
    #logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100px;
        height: auto;
    }

    /* Animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .w3-notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: red;
        border-radius: 50%;
        padding: 5px;
        font-size: 12px;
    }
</style>

<!-- Preloader -->
<div id="preloader" style="display: none;">
    <div id="loader-container">
        <div id="loader"></div>
        <!-- Replace 'your-logo.png' with the path to your logo -->
        <img id="logo" src="<?php echo $company_obj->get_compnay_logo_url(); ?>" alt="Floor Desinger ">
    </div>
</div>
<!---------------------------------------------------------------------pre loader end ----------------------------------------------------------------------------------------->

<div id="toast" class="w3-uppercase w3-animate-zoom">This is a toast notification!</div>

<script type="text/javascript">
   
    function isElementVisible(element) {
        return element && element.offsetParent !== null; // Ensure the element is visible
    }

    function preventScroll(event) {
        // Allow scrolling inside any element with the class 'allow-scroll'
        if (event.target.closest('.allow-scroll')) {
            //            alert("1");
            return; // Let the user scroll inside this div
        }

        // Prevent window (page) scrolling
        event.preventDefault();
    }

    function lockWindowScroll() {
        window.addEventListener('wheel', preventScroll, {
            passive: false
        });
        window.addEventListener('touchmove', preventScroll, {
            passive: false
        });
    }

    function unlockWindowScroll() {
        window.removeEventListener('wheel', preventScroll);
        window.removeEventListener('touchmove', preventScroll);
    }
</script>
<!--
coppy to fooeter
<div class="container-fluid">
    <div class="hidden-md hidden-sm hidden-xs" id="avbl_lg">
        show on lg
        .
    </div>
    <div class="hidden-lg hidden-sm hidden-xs" id="avbl_md">
        show on md
        .
    </div>
     <div class="hidden-lg hidden-md hidden-xs" id="avbl_sm">
        show on sm
        .
    </div>
    <div class="hidden-lg hidden-md hidden-sm" id="avbl_xs">
        show on sm
        .
    </div>
</div>-->