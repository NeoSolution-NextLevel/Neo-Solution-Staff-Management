<script>
/**
 * Payment Slip View — Dashboard JavaScript Logic
 * WWJM Admin · Main Dashboard 02 H
 */

function escapeSlipHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function openPaymentSlipView(slipId) {
    if (typeof main_dashboard_02_H_OPEN === 'function') {
        main_dashboard_02_H_OPEN();
    }
    loadPaymentSlipDetail(slipId);
}

function loadPaymentSlipDetail(slipId) {
    if (!slipId) return;

    var nameElem = document.getElementById('payment-slip-name');
    var mobileElem = document.getElementById('payment-slip-mobile');
    var addressElem = document.getElementById('payment-slip-address');
    var itemsElem = document.getElementById('payment-slip-items');
    var totalElem = document.getElementById('payment-slip-total');
    var statusElem = document.getElementById('payment-slip-status');

    if (statusElem) statusElem.textContent = '';

    $.ajax({
        url: "<?php echo $pth; ?>View-List/Payment/single_payment_slip.php",
        type: 'POST',
        data: { id: slipId },
        cache: false,
        dataType: 'json',
        success: function(data) {
            if (Array.isArray(data) && data.length > 0) {
                var p = data[0];

                var memberName = p.person_name || (p.membership_no ? 'Member #' + p.membership_no : 'Payment #' + p.id);
                if (nameElem) nameElem.textContent = memberName;
                if (mobileElem) mobileElem.textContent = p.phone_number || 'N/A';
                if (addressElem) addressElem.textContent = p.address || 'N/A';

                // Reason Label
                var reasonLabel = 'General Payment';
                if (parseInt(p.pay_resion_subcption, 10) === 1) reasonLabel = 'Subscription';
                else if (parseInt(p.pay_resion_zakath, 10) === 1) reasonLabel = 'Zakath';
                else if (parseInt(p.pay_resion_donation, 10) === 1) reasonLabel = 'Donation';
                else if (parseInt(p.pay_resion_projects, 10) === 1) reasonLabel = 'Project';

                if (p.dis && p.dis.trim() !== '') {
                    reasonLabel += ' (' + p.dis.trim() + ')';
                }

                var amountVal = parseFloat(p.amount || 0);
                var formattedAmount = amountVal.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                if (itemsElem) {
                    itemsElem.innerHTML = '<tr><td>' + escapeSlipHtml(reasonLabel) + '</td><td class="payment-slip-col-amount">' + formattedAmount + '</td></tr>';
                }

                if (totalElem) {
                    totalElem.textContent = formattedAmount;
                }
            } else {
                if (nameElem) nameElem.textContent = 'N/A';
                if (mobileElem) mobileElem.textContent = 'N/A';
                if (addressElem) addressElem.textContent = 'N/A';
                if (itemsElem) itemsElem.innerHTML = '<tr><td colspan="2">No payment slip details found.</td></tr>';
                if (totalElem) totalElem.textContent = '0.00';
            }
        },
        error: function(err) {
            console.error("Error fetching single payment slip:", err);
        }
    });
}
</script>
