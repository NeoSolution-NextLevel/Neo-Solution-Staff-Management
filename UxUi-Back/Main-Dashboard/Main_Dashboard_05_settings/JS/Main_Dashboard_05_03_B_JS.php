<script>
    function Settings_body_01_D_08_from_01_SUMBIT(event) {
        event.preventDefault();
        var val_01 = document.getElementById("Settings_body_01_D_08_bank_name");
        var val_02 = document.getElementById("Settings_body_01_D_08_branch");
        var val_03 = document.getElementById("Settings_body_01_D_08_ac_no");
        var val_04 = document.getElementById("Settings_body_01_D_08_ac_name");
        var val_05 = document.getElementById("Settings_body_01_D_08_swif_code");
        var val_06 = document.getElementById("Settings_body_01_D_08_current_ac");
        var val_07 = document.getElementById("Settings_body_01_D_08_savings_ac");
        var val_08 = document.getElementById("Settings_body_01_D_08_dis");


        var sending_value = "val_01=" + encodeURIComponent(val_01.value) +
            "&val_02=" + encodeURIComponent(val_02.value) +
            "&val_03=" + encodeURIComponent(val_03.value) +
            "&val_04=" + encodeURIComponent(val_04.value) +
            "&val_05=" + encodeURIComponent(val_05.value) +
            "&val_08=" + encodeURIComponent(val_08.value);

        if (val_06.checked) {
            sending_value = sending_value + "&current_ac=0";
        }

        if (val_07.checked) {
            sending_value = sending_value + "&savings_ac=0";
        }

        // alert(sending_value);

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Settings/bank_details/add_bank_account_details.php",
            type: "POST",
            data: sending_value,
            success: function(res) {
                // alert(res);

                var json = JSON.parse(res);
                // alert("success");
                console.log(json);
                if (json[0].error === "already have Account Number") {

                    // alert("Member saved successfully");
                    create_error(
                        document.getElementById("Settings_body_01_D_02_position_id"),
                        'Settings_body_01_D_08_error_msg',
                        "Already have this Account Number "
                    );
                    return;


                }
                if (json[0].error === "0") {
                    main_dashboard_05_03_A_OPEN();

                } else {

                }

            }
        });
    }
</script>