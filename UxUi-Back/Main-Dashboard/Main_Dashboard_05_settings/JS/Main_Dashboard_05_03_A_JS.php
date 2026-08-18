<script type="text/javascript">
    function Settings_body_01_D_07_bank_account_list() {
        var list = document.getElementById("settings-bank-account-list");
        var empty = document.getElementById("settings-bank-account-empty");
        
        var searchTxtObj = document.getElementById("settings-bank-account-search");
        var searchTxt = searchTxtObj ? searchTxtObj.value.trim() : "";
        
        var searchTypeObj = document.getElementById("settings-bank-account-type");
        var searchType = searchTypeObj ? searchTypeObj.value : "account";

        // Optional: you can implement frontend filtering if you fetch everything, or send to backend
        var sending_value = "search_txt=" + encodeURIComponent(searchTxt) + "&search_type=" + encodeURIComponent(searchType);

        if(list) list.innerHTML = "Loading...";

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Settings/bank_details/view_bank_account_details.php",
            type: "POST",
            data: sending_value,
            cache: false,
            success: function(response) {
                try {
                    var json_data = JSON.parse(response);
                    
                    // Simple frontend filter (since backend might not filter it by all types)
                    if (searchTxt !== "") {
                        var q = searchTxt.toLowerCase();
                        json_data = json_data.filter(function(r) {
                            var b_name = (r.bank_name || "").toLowerCase();
                            var b_branch = (r.branch || "").toLowerCase();
                            var b_acc = (r.ac_no || "").toLowerCase();
                            if(searchType === 'bank') return b_name.includes(q);
                            if(searchType === 'branch') return b_branch.includes(q);
                            return b_acc.includes(q); // default account
                        });
                    }

                    if (json_data.length === 0) {
                        if(list) list.innerHTML = '';
                        if(empty) empty.style.display = 'block';
                    } else {
                        if(empty) empty.style.display = 'none';
                        
                        var html = "";
                        for (var i = 0; i < json_data.length; i++) {
                            var r = json_data[i];
                            html += '<div class="settings-bank-account-row">';
                            html += '  <div class="settings-bank-account-row-info">';
                            html += '    <span class="settings-bank-account-row-name">' + (r.bank_name || '') + '</span>';
                            html += '    <span class="settings-bank-account-row-sub">' + (r.branch || '') + ' · Acc No. ' + (r.ac_no || '') + '</span>';
                            html += '  </div>';
                            html += '  <button class="settings-bank-account-row-btn" onclick="alert(\'Edit Bank: ' + (r.bank_name || '') + '\')">Edit</button>';
                            html += '</div>';
                        }
                        
                        if(list) list.innerHTML = html;
                    }
                } catch(e) {
                    console.error("Error parsing bank list:", e);
                    if(list) list.innerHTML = '';
                    if(empty) empty.style.display = 'block';
                }
            },
            error: function() {
                if(list) list.innerHTML = 'Error loading data.';
            }
        });
    }

    $(document).ready(function() {
        Settings_body_01_D_07_bank_account_list();
    });
</script>