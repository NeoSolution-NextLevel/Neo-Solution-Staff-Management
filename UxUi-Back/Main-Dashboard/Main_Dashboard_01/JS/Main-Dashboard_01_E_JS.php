<script>
    function Main_Dashboard_01_E_SUMBIT(event) {
        if (event) event.preventDefault();
        var val_01 = document.getElementById("Main_Dashboard_01_E_road");
        var wrap = document.getElementById("add-road-field-name");
        var errSpan = document.getElementById("add-road-error-msg");

        if (!val_01 || !val_01.value.trim()) {
            if (wrap) wrap.classList.add("add-road-invalid");
            if (errSpan) errSpan.textContent = "Please enter a valid road or street name.";
            if (val_01) val_01.focus();
            return false;
        }

        if (wrap) wrap.classList.remove("add-road-invalid");

        var roadName = val_01.value.trim();
        var data = "val_01=" + encodeURIComponent(roadName);

        $.ajax({
            url: "<?php echo $pth; ?>View-List/member_register/add_road.php",
            type: "POST",
            data: data,
            success: function(res) {
                try {
                    var json = JSON.parse(res);
                    console.log(json);
                    if (json && json[0] && json[0].error === "0") {
                        // Show success toast
                        var toast = document.getElementById("add-road-toast");
                        if (toast) {
                            toast.style.display = "block";
                            setTimeout(function() { toast.style.display = "none"; }, 2000);
                        }

                        // Add to memberStreetData if available
                        if (typeof memberStreetData !== 'undefined' && Array.isArray(memberStreetData)) {
                            memberStreetData.unshift(roadName);
                            if (typeof memberStreetRender === 'function') {
                                memberStreetRender();
                            }
                        }

                        val_01.value = "";

                        // Navigate back to street list
                        if (typeof main_dashboard_01_F_OPEN === 'function') {
                            main_dashboard_01_F_OPEN();
                        } else if (typeof Member_body_01_C_4_01_OPEN === 'function') {
                            Member_body_01_C_4_01_OPEN();
                        }
                    } else {
                        var errMsg = (json && json[0] && json[0].message) ? json[0].message : "Already have this road name";
                        if (wrap) wrap.classList.add("add-road-invalid");
                        if (errSpan) errSpan.textContent = errMsg;
                        if (typeof create_error === 'function' && document.getElementById("member_pagination_holder_id")) {
                            create_error(
                                document.getElementById("member_pagination_holder_id"),
                                'Member_body_01_C_4_01_01_error_msg',
                                errMsg
                            );
                        }
                    }
                } catch(e) {
                    console.error("Parse error:", e, res);
                }
            },
            error: function(xhr, status, err) {
                console.error("AJAX Error:", err);
            }
        });
    }
</script>