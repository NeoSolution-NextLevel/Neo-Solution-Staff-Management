<script type="text/javascript">
let paymentSubscription_totalCount = 0;
let paymentSubscription_currentPage = 1;

function paymentSubscriptionRender(resetPage = true) {
    if (resetPage) {
        paymentSubscription_currentPage = 1;
        fetchPaymentSubscriptionData(true);
    } else {
        fetchPaymentSubscriptionData(false);
    }
}

function fetchPaymentSubscriptionData(isFirstLoad = false) {
    var search_txt = document.getElementById("payment-subscription-search").value;
    var search_by = document.getElementById("payment-subscription-type").value;
    var per_page = parseInt(document.getElementById("payment-subscription-perpage").value, 10);
    
    if (isFirstLoad) {
        var sending_value = "count=0";
        sending_value += "&search_txt=" + encodeURIComponent(search_txt) + "&search_by=" + encodeURIComponent(search_by);
        
        $.ajax({
            url: "<?php echo $pth; ?>View-List/Member/view_member_list.php",
            type: 'POST',
            data: sending_value,
            cache: false,
            success: function(data) {
                try {
                    var json = eval(data);
                    if (json.length > 0) {
                        paymentSubscription_totalCount = parseInt(json[0].count);
                    } else {
                        paymentSubscription_totalCount = 0;
                    }
                } catch(e) {
                    paymentSubscription_totalCount = 0;
                }
                renderPaymentSubscriptionPagination();
                loadPaymentSubscriptionPageData();
            }
        });
    } else {
        loadPaymentSubscriptionPageData();
    }
}

function renderPaymentSubscriptionPagination() {
    var container = document.getElementById("payment-subscription-pagination");
    if(!container) return;
    $(container).empty();
    
    var per_page = parseInt(document.getElementById("payment-subscription-perpage").value, 10);
    if(paymentSubscription_totalCount <= per_page) return; // Don't show pagination if 1 page
    
    var no_of_pages = Math.ceil(paymentSubscription_totalCount / per_page);
    
    for (var i = 1; i <= no_of_pages; i++) {
        var btn = document.createElement("button");
        btn.setAttribute("class", "payment-subscription-skip"); 
        btn.style.height = "36px";
        btn.style.padding = "0 12px";
        btn.style.minWidth = "36px";
        if (i === paymentSubscription_currentPage) {
            btn.style.background = "var(--payment-subscription-green-700)";
            btn.style.color = "var(--payment-subscription-white)";
            btn.style.border = "1px solid var(--payment-subscription-green-700)";
        } else {
            btn.style.background = "var(--payment-subscription-white)";
            btn.style.color = "var(--payment-subscription-ink-900)";
            btn.style.border = "1px solid var(--payment-subscription-border)";
        }
        btn.innerText = i;
        btn.onclick = (function(page) {
            return function() {
                paymentSubscription_currentPage = page;
                renderPaymentSubscriptionPagination(); 
                loadPaymentSubscriptionPageData();
            };
        })(i);
        container.appendChild(btn);
    }
}

function loadPaymentSubscriptionPageData() {
    var search_txt = document.getElementById("payment-subscription-search").value;
    var search_by = document.getElementById("payment-subscription-type").value;
    var per_page = parseInt(document.getElementById("payment-subscription-perpage").value, 10);
    
    var start_count = (paymentSubscription_currentPage - 1) * per_page;
    var sending_value = "st_count=" + start_count + "&per_page=" + per_page + "&page_data=0";
    sending_value += "&search_txt=" + encodeURIComponent(search_txt) + "&search_by=" + encodeURIComponent(search_by);
    
    $.ajax({
        url: "<?php echo $pth; ?>View-List/Member/view_member_list.php",
        type: 'POST',
        data: sending_value,
        cache: false,
        success: function(data) {
            var json = eval(data);
            var list = document.getElementById("payment-subscription-list");
            var empty = document.getElementById("payment-subscription-empty");
            
            if (json.length == 0) {
                list.innerHTML = "";
                empty.style.display = "block";
            } else {
                empty.style.display = "none";
                $(list).empty();
                for (var i = 0; i < json.length; i++) {
                    list.appendChild(createPaymentSubscriptionRow(json[i]));
                }
            }
        }
    });
}

function createPaymentSubscriptionRow(json) {
    var div = document.createElement("div");
    div.className = "payment-subscription-row";
    
    var infoDiv = document.createElement("div");
    infoDiv.className = "payment-subscription-row-info";
    
    var nameSpan = document.createElement("span");
    nameSpan.className = "payment-subscription-row-name";
    nameSpan.innerText = json.name_M;
    
    var idSpan = document.createElement("span");
    idSpan.className = "payment-subscription-row-road";
    idSpan.innerText = json.membership_no;
    
    infoDiv.appendChild(nameSpan);
    infoDiv.appendChild(idSpan);
    
    var btn = document.createElement("button");
    btn.className = "payment-subscription-row-select";
    btn.innerText = "Select";
    btn.onclick = function() {
        var setVal = function(id, val) {
            var el = document.getElementById(id);
            if (!el) {
                el = document.createElement("input");
                el.type = "hidden";
                el.id = id;
                document.body.appendChild(el);
            }
            el.value = val || '';
        };

        setVal("DashBord_Payment_body_member_list_id", json.id);
        setVal("DashBord_Payment_body_member_list_phone_number", json.phone_mobile);
        setVal("DashBord_Payment_body_member_list_email", json.email);
        setVal("DashBord_Payment_body_member_list_address", json.residence_address_M);
        setVal("DashBord_Payment_body_member_list_name", json.name_M);
        setVal("DashBord_Payment_body_member_list_membership_no", json.membership_no);
        setVal("DashBord_Payment_body_member_list_amount", json.due_to_pay);

        // Display actual customer data on Cash Payment page
        var cashMemberNo = document.getElementById("cash-payment-member-no");
        if (cashMemberNo) cashMemberNo.innerText = json.membership_no || '';
        
        var cashMemberName = document.getElementById("cash-payment-member-name");
        if (cashMemberName) cashMemberName.innerText = json.name_M || '';
        
        var cashDueAmount = document.getElementById("cash-payment-due-amount");
        if (cashDueAmount) cashDueAmount.innerText = json.due_to_pay || '';

        if (typeof main_dashboard_02_D_OPEN === "function") {
            main_dashboard_02_D_OPEN();
        }
    };
    
    div.appendChild(infoDiv);
    div.appendChild(btn);
    return div;
}

// Initial load
document.addEventListener("DOMContentLoaded", function() {
    // Small timeout to ensure jQuery is ready and DOM is parsed
    setTimeout(function() {
        paymentSubscriptionRender();
    }, 100);
});
</script>