<script type="text/javascript">
    function DashBord_Payment_body_01_B_05_bank_account_list() {
        var container = document.getElementById("payment-bank-list");
        if(container) container.innerHTML = "Loading...";

        $.ajax({
            url: "<?php echo $pth; ?>View-List/Settings/bank_details/view_bank_account_details.php",
            type: "POST",
            cache: false,
            success: function(response) {
                try {
                    var json_data = JSON.parse(response);
                    if (json_data.length === 0) {
                        if(container) container.innerHTML = "<div style='text-align:center; padding: 20px; color: var(--payment-bank-ink-600);'>No bank account found</div>";
                    } else {
                        if(container) container.innerHTML = "";
                        for (var i = 0; i < json_data.length; i++) {
                            DashBord_Payment_body_01_B_05_load_bank_account_list(json_data[i], container);
                        }
                    }
                } catch(e) {
                    console.error("Error parsing bank list:", e);
                    if(container) container.innerHTML = "<div style='text-align:center; padding: 20px; color: var(--payment-bank-ink-600);'>Error loading data</div>";
                }
            },
            error: function() {
                if(container) container.innerHTML = "<div style='text-align:center; padding: 20px; color: var(--payment-bank-ink-600);'>Error loading data</div>";
            }
        });
    }

    function DashBord_Payment_body_01_B_05_load_bank_account_list(json, container) {
        var card = document.createElement("div");
        card.className = "payment-bank-card";

        // Row 1: Bank Name
        var row1 = document.createElement("div");
        row1.className = "payment-bank-row";
        row1.innerHTML = `<div class="payment-bank-label">Bank Name</div><div class="payment-bank-colon">:</div><div class="payment-bank-value">${json.bank_name || ''}</div>`;
        card.appendChild(row1);

        // Row 2: Account No
        var row2 = document.createElement("div");
        row2.className = "payment-bank-row";
        row2.innerHTML = `<div class="payment-bank-label">Account No</div><div class="payment-bank-colon">:</div><div class="payment-bank-value">${json.ac_no || ''}</div>`;
        card.appendChild(row2);

        // Row 3: Branch Name
        var row3 = document.createElement("div");
        row3.className = "payment-bank-row";
        row3.innerHTML = `<div class="payment-bank-label">Branch Name</div><div class="payment-bank-colon">:</div><div class="payment-bank-value">${json.branch || ''}</div>`;
        card.appendChild(row3);

        // Footer with button
        var footer = document.createElement("div");
        footer.className = "payment-bank-footer";
        
        var btn = document.createElement("button");
        btn.className = "payment-bank-btn-select";
        btn.textContent = "Select";
        btn.onclick = function() {
            var idEl = document.getElementById("DashBord_Payment_body_01_B_05_bank_account_details_id");
            if (!idEl) {
                idEl = document.createElement("input");
                idEl.type = "hidden";
                idEl.id = "DashBord_Payment_body_01_B_05_bank_account_details_id";
                document.body.appendChild(idEl);
            }
            idEl.value = json.id;

            var nameEl = document.getElementById("DashBord_Payment_body_01_B_05_bank_name");
            if (!nameEl) {
                nameEl = document.createElement("input");
                nameEl.type = "hidden";
                nameEl.id = "DashBord_Payment_body_01_B_05_bank_name";
                document.body.appendChild(nameEl);
            }
            nameEl.value = json.bank_name || '';

            var branchEl = document.getElementById("DashBord_Payment_body_01_B_05_branch_name");
            if (!branchEl) {
                branchEl = document.createElement("input");
                branchEl.type = "hidden";
                branchEl.id = "DashBord_Payment_body_01_B_05_branch_name";
                document.body.appendChild(branchEl);
            }
            branchEl.value = json.branch || '';

            var acNoEl = document.getElementById("DashBord_Payment_body_01_B_05_ac_no");
            if (!acNoEl) {
                acNoEl = document.createElement("input");
                acNoEl.type = "hidden";
                acNoEl.id = "DashBord_Payment_body_01_B_05_ac_no";
                document.body.appendChild(acNoEl);
            }
            acNoEl.value = json.ac_no || '';

            // Trigger navigation to deposit submission
            if (typeof DashBord_Payment_body_01_B_05_01_OPEN === "function") {
                DashBord_Payment_body_01_B_05_01_OPEN();
            } else if (typeof main_dashboard_02_G_OPEN === "function") {
                main_dashboard_02_G_OPEN();
            } else {
                console.warn("Navigation function not found. Selected bank:", json.bank_name);
            }
        };

        footer.appendChild(btn);
        card.appendChild(footer);

        container.appendChild(card);
    }

    $(document).ready(function() {
        DashBord_Payment_body_01_B_05_bank_account_list();
    });
</script>