<?php
include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../imports/Company_Info/Company_Info_Variable_List.php';

$company_obj = new Company_Info_Variable_List();
$prefill_email = isset($_GET['email']) && !empty($_GET['email']) 
    ? trim($_GET['email']) 
    : (isset($_SESSION['temp_otp_email']) && !empty($_SESSION['temp_otp_email']) 
        ? trim($_SESSION['temp_otp_email']) 
        : (isset($_SESSION['user_name']) ? trim($_SESSION['user_name']) : ''));

$phone_masked = '';
$is_approved = false;
$is_pending = false;

if (!empty($prefill_email)) {
    try {
        $db = new DataBase();
        $conn = $db->get_data_base_connction();
        $safe_email = addslashes($prefill_email);
        $res = $conn->query("SELECT * FROM `employee_form_submissions` WHERE `email` = '{$safe_email}' ORDER BY `id` DESC LIMIT 1");
        if ($res && ($row = $res->fetch_assoc())) {
            if ($row['status'] === 'approved') {
                $is_approved = true;
                $raw_phone = $row['phone_number'];
                if (strlen($raw_phone) > 4) {
                    $phone_masked = substr($raw_phone, 0, 3) . '****' . substr($raw_phone, -3);
                } else {
                    $phone_masked = $raw_phone;
                }
            } elseif ($row['status'] === 'pending') {
                $is_pending = true;
            }
        }
    } catch (\Throwable $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Verify Employee Account | <?php echo htmlspecialchars($company_obj->get_compnay_name()); ?></title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../UxUi-Back/assets/css/portals/auth-portal.css?v=<?php echo filemtime(__DIR__ . '/../../UxUi-Back/assets/css/portals/auth-portal.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .otp-inputs-grid {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 24px 0 20px;
        }
        .otp-digit {
            width: 48px;
            height: 56px;
            font-size: 24px;
            font-weight: 800;
            text-align: center;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            outline: none;
            background: #ffffff;
            color: #14204d;
            transition: all 0.2s ease;
        }
        .otp-digit:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            transform: scale(1.05);
        }
        @media (max-width: 420px) {
            .otp-digit {
                width: 40px;
                height: 48px;
                font-size: 20px;
                gap: 6px;
            }
        }
        .status-alert {
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .status-alert--info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
        }
        .status-alert--warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }
        .status-alert--error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .status-alert--success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
    </style>
</head>

<body>
    <!-- Header component -->
    <?php include_once '../../UxUi-Back/Common/header.php'; ?>

    <div class="erp-container erp-container--login" style="max-width: 520px;">
        <div class="erp-login-card">

            <div class="erp-login-card__header">
                <div style="font-size: 32px; color: #93c5fd; margin-bottom: 8px;">
                    <i class="fas fa-mobile-screen-button"></i>
                </div>
                <h1 class="erp-login-card__title">Employee Account Verification</h1>
                <p class="erp-login-card__subtitle">Enter the 6-digit OTP code sent to your contact number</p>
            </div>

            <div class="erp-login-card__body">

                <?php if ($is_pending): ?>
                    <div class="status-alert status-alert--warning">
                        <i class="fas fa-clock" style="font-size: 18px; color: #d97706; margin-top: 2px;"></i>
                        <div>
                            <strong>Application Pending Approval:</strong>
                            <p style="margin: 4px 0 0; font-size: 13px;">
                                Your registration form has been submitted and is currently waiting for administrator review. You will receive an SMS with your OTP as soon as the administrator approves your application.
                            </p>
                        </div>
                    </div>
                <?php elseif ($is_approved): ?>
                    <div class="status-alert status-alert--success">
                        <i class="fas fa-check-circle" style="font-size: 18px; color: #16a34a; margin-top: 2px;"></i>
                        <div>
                            <strong>Application Approved!</strong>
                            <p style="margin: 4px 0 0; font-size: 13px;">
                                Your application has been approved. A 6-digit OTP verification code was dispatched to your phone number <strong><?php echo htmlspecialchars($phone_masked); ?></strong>.
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="status-alert status-alert--info">
                        <i class="fas fa-info-circle" style="font-size: 18px; color: #2563eb; margin-top: 2px;"></i>
                        <div>
                            Enter the corporate email address you used in your registration form along with the 6-digit OTP code sent via SMS.
                        </div>
                    </div>
                <?php endif; ?>

                <div id="otpAlertMsg" style="display: none;" class="status-alert status-alert--error">
                    <i class="fas fa-circle-exclamation" style="font-size: 18px; margin-top: 2px;"></i>
                    <div id="otpAlertText"></div>
                </div>

                <form id="verifyOtpForm" onsubmit="submitOtpVerification(event);">
                    
                    <div class="erp-form__group">
                        <label class="erp-form__label">Registered Corporate Email <span style="color: var(--erp-accent-error);">*</span></label>
                        <div class="erp-input-wrapper">
                            <i class="fas fa-envelope erp-form__icon"></i>
                            <input type="email" class="erp-form__control erp-form__control--with-icon" 
                                   id="verifyEmail" name="email" 
                                   value="<?php echo htmlspecialchars($prefill_email); ?>" 
                                   placeholder="name@company.com" required>
                        </div>
                    </div>

                    <div class="erp-form__group erp-mt-md">
                        <label class="erp-form__label" style="text-align: center; display: block;">6-Digit OTP Code <span style="color: var(--erp-accent-error);">*</span></label>
                        
                        <div class="otp-inputs-grid" id="otpGrid">
                            <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" autocomplete="one-time-code" autofocus>
                            <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                        </div>

                        <input type="hidden" id="fullOtpCode" name="otp_code">
                    </div>

                    <div class="erp-form__group erp-mt-lg">
                        <button type="submit" id="verifyBtn" class="erp-btn erp-btn--primary erp-btn--block" style="height: 48px; font-size: 15px;">
                            <i class="fas fa-shield-check"></i>
                            <span>Verify Account &amp; Activate</span>
                        </button>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; font-size: 13px;">
                        <button type="button" id="resendOtpBtn" onclick="resendOtpCode();" style="background: none; border: none; color: #2563eb; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; padding: 0;">
                            <i class="fas fa-rotate-right"></i> Resend OTP Code
                        </button>
                        <a href="User-Login.php" class="erp-link">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>
                    </div>
                </form>
            </div>

            <div class="erp-login-card__footer" style="padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                <p style="font-size: 12px; color: #64748b; margin: 0; font-weight: 500;">
                    © <?php echo date('Y'); ?> <?php echo htmlspecialchars($company_obj->get_compnay_name()); ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        const digits = document.querySelectorAll('.otp-digit');

        digits.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val;
                if (val && index < digits.length - 1) {
                    digits[index + 1].focus();
                }
                syncOtpCode();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    digits[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim().replace(/[^0-9]/g, '');
                if (pasteData) {
                    const chars = pasteData.slice(0, 6).split('');
                    chars.forEach((c, i) => {
                        if (digits[i]) digits[i].value = c;
                    });
                    if (chars.length < 6) {
                        digits[chars.length].focus();
                    } else {
                        digits[5].focus();
                    }
                    syncOtpCode();
                }
            });
        });

        function syncOtpCode() {
            let code = '';
            digits.forEach(d => { code += d.value; });
            document.getElementById('fullOtpCode').value = code;
            return code;
        }

        function showOtpAlert(msg, type = 'error') {
            const el = document.getElementById('otpAlertMsg');
            const txt = document.getElementById('otpAlertText');
            if (!el || !txt) return;
            txt.textContent = msg;
            el.className = 'status-alert status-alert--' + type;
            el.style.display = 'flex';
        }

        function hideOtpAlert() {
            const el = document.getElementById('otpAlertMsg');
            if (el) el.style.display = 'none';
        }

        function submitOtpVerification(e) {
            e.preventDefault();
            hideOtpAlert();

            const email = document.getElementById('verifyEmail').value.trim();
            const otp = syncOtpCode();

            if (!email) {
                showOtpAlert('Please enter your corporate email address.');
                document.getElementById('verifyEmail').focus();
                return;
            }

            if (otp.length !== 6) {
                showOtpAlert('Please enter all 6 digits of the OTP verification code.');
                return;
            }

            const btn = document.getElementById('verifyBtn');
            const origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Code...';

            $.ajax({
                url: '../../UxUi-Back/Employee/forms/verify_employee_otp.php',
                type: 'POST',
                data: {
                    email: email,
                    otp_code: otp
                },
                success: function(res) {
                    try {
                        const json = typeof res === 'object' ? res : JSON.parse(res);
                        if (json.status === 'success') {
                            showOtpAlert('Verification Successful! Activating account...', 'success');
                            setTimeout(() => {
                                window.location.href = json.data && json.data.redirect_url 
                                    ? json.data.redirect_url 
                                    : (json.redirect_url || 'User-Login.php');
                            }, 1200);
                        } else {
                            showOtpAlert(json.message || 'OTP verification failed. Please check the code and try again.');
                            btn.disabled = false;
                            btn.innerHTML = origHtml;
                        }
                    } catch (err) {
                        showOtpAlert('Server error: ' + err.message);
                        btn.disabled = false;
                        btn.innerHTML = origHtml;
                    }
                },
                error: function(xhr, status, error) {
                    showOtpAlert('Network error: ' + error);
                    btn.disabled = false;
                    btn.innerHTML = origHtml;
                }
            });
        }

        function resendOtpCode() {
            const email = document.getElementById('verifyEmail').value.trim();
            if (!email) {
                showOtpAlert('Please enter your registered email address first.');
                document.getElementById('verifyEmail').focus();
                return;
            }

            const btn = document.getElementById('resendOtpBtn');
            const origText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

            $.ajax({
                url: '../../UxUi-Back/Employee/forms/resend_otp.php',
                type: 'POST',
                data: { email: email },
                success: function(res) {
                    try {
                        const json = typeof res === 'object' ? res : JSON.parse(res);
                        if (json.status === 'success') {
                            showOtpAlert(json.message || 'A new OTP has been dispatched to your contact number.', 'success');
                            let countdown = 30;
                            btn.innerHTML = `<i class="fas fa-check"></i> Sent! (${countdown}s)`;
                            const timer = setInterval(() => {
                                countdown--;
                                if (countdown <= 0) {
                                    clearInterval(timer);
                                    btn.disabled = false;
                                    btn.innerHTML = origText;
                                } else {
                                    btn.innerHTML = `<i class="fas fa-check"></i> Sent! (${countdown}s)`;
                                }
                            }, 1000);
                        } else {
                            showOtpAlert(json.message || 'Could not resend OTP.');
                            btn.disabled = false;
                            btn.innerHTML = origText;
                        }
                    } catch (err) {
                        showOtpAlert('Server error: ' + err.message);
                        btn.disabled = false;
                        btn.innerHTML = origText;
                    }
                },
                error: function(xhr, status, error) {
                    showOtpAlert('Network error: ' + error);
                    btn.disabled = false;
                    btn.innerHTML = origText;
                }
            });
        }
    </script>

    <?php include_once '../../UxUi-Back/Common/footer.php'; ?>
</body>

</html>
