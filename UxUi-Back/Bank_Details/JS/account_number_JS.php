<script>
/**
 * Bank Details - Account Number Management JavaScript Library
 * Neo Solution Staff Management System
 */

window.NeoBankDetails = {
    getPth: function() {
        return typeof window.pth !== 'undefined' ? window.pth : '../';
    },

    maskAccountNumber: function(num) {
        if (!num) return '—';
        var str = String(num).trim();
        if (str.length <= 4) return str;
        var last4 = str.slice(-4);
        return '••••••••' + last4;
    },

    saveBankDetails: function(payload, onSuccess, onError) {
        var pth = this.getPth();
        
        // Cache to localStorage immediately for persistent offline access
        try {
            localStorage.setItem('neo_employee_bank_details', JSON.stringify(payload));
        } catch(e) {}

        // Send via jQuery AJAX if available, else standard Fetch
        if (typeof $ !== 'undefined' && $.ajax) {
            $.ajax({
                url: pth + "UxUi-Back/Bank_Details/account_number.php",
                type: "POST",
                data: payload,
                dataType: "json",
                success: function(res) {
                    var resObj = Array.isArray(res) ? (res[0] || {}) : (res || {});
                    if (resObj.error === "0" || resObj.status === "success") {
                        if (typeof onSuccess === 'function') onSuccess(resObj);
                    } else {
                        if (typeof onError === 'function') onError(resObj.message || resObj.error);
                    }
                },
                error: function(xhr, status, error) {
                    // Fallback to secondary View-List endpoint
                    $.ajax({
                        url: pth + "View-List/Bank_details/Save_Bank_Details.php",
                        type: "POST",
                        data: payload,
                        dataType: "json",
                        success: function(res2) {
                            var resObj2 = Array.isArray(res2) ? (res2[0] || {}) : (res2 || {});
                            if (resObj2.error === "0" || resObj2.status === "success") {
                                if (typeof onSuccess === 'function') onSuccess(resObj2);
                            } else {
                                if (typeof onError === 'function') onError(resObj2.message || resObj2.error);
                            }
                        },
                        error: function() {
                            if (typeof onError === 'function') onError("Failed to connect to the server.");
                        }
                    });
                }
            });
        } else {
            var formData = new FormData();
            for (var key in payload) {
                if (payload.hasOwnProperty(key)) {
                    formData.append(key, payload[key]);
                }
            }
            fetch(pth + "UxUi-Back/Bank_Details/account_number.php", {
                method: "POST",
                body: formData
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                var resObj = Array.isArray(res) ? (res[0] || {}) : (res || {});
                if (resObj.error === "0" || resObj.status === "success") {
                    if (typeof onSuccess === 'function') onSuccess(resObj);
                } else {
                    if (typeof onError === 'function') onError(resObj.message || resObj.error);
                }
            })
            .catch(function(err) {
                if (typeof onError === 'function') onError(err.message || "Network error");
            });
        }
    },

    fetchBankDetails: function(empId, callback) {
        var pth = this.getPth();
        empId = empId || (window.currentEmployeeId || "EMP-001");

        // Try local storage cache first
        try {
            var cached = localStorage.getItem('neo_employee_bank_details');
            if (cached) {
                var data = JSON.parse(cached);
                if (data && typeof callback === 'function') {
                    callback(data);
                }
            }
        } catch(e) {}

        // Fetch live from server
        var url = pth + "UxUi-Back/Bank_Details/account_number.php?employee_id=" + encodeURIComponent(empId);
        fetch(url)
            .then(function(r) { return r.json(); })
            .then(function(res) {
                var resObj = Array.isArray(res) ? (res[0] || {}) : (res || {});
                if (resObj.status === 'success' && resObj.data) {
                    try {
                        localStorage.setItem('neo_employee_bank_details', JSON.stringify(resObj.data));
                    } catch(e) {}
                    if (typeof callback === 'function') callback(resObj.data);
                }
            })
            .catch(function() {});
    }
};
</script>
