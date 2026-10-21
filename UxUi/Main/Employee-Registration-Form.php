<?php
include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../imports/Company_Info/Company_Info_Variable_List.php';

$company_obj = new Company_Info_Variable_List();
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

$is_valid_form = false;
$form_data = null;
$error_message = '';

if (!empty($token)) {
    try {
        $db = new DataBase();
        $conn = $db->get_data_base_connction();
        $safe_token = addslashes($token);
        
        $res = $conn->query("SELECT * FROM `employee_registration_forms` WHERE `form_token` = '{$safe_token}' AND `status` = 'active' LIMIT 1");
        if ($res && ($row = $res->fetch_assoc())) {
            if (!empty($row['expires_at']) && strtotime($row['expires_at']) < time()) {
                $error_message = 'This onboarding form link has expired. Please contact your Super Admin for an updated registration link.';
            } else {
                $is_valid_form = true;
                $form_data = $row;
            }
        } else {
            $error_message = 'Invalid or inactive registration link. Please verify the link or contact your Super Admin.';
        }
    } catch (\Throwable $e) {
        $error_message = 'Database error: ' . $e->getMessage();
    }
} else {
    // Direct employee self-registration: candidate fills the onboarding form
    $is_valid_form = true;
    $form_data = [
        'title' => 'Employee Registration & Onboarding Form',
        'department' => 'Engineering',
        'job_title' => 'Staff',
        'target_email' => '',
        'form_token' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Employee Registration Form | <?php echo htmlspecialchars($company_obj->get_compnay_name()); ?></title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../UxUi-Back/assets/css/portals/auth-portal.css?v=<?php echo filemtime(__DIR__ . '/../../UxUi-Back/assets/css/portals/auth-portal.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .form-section-title {
            color: #14204d;
            font-size: 15.5px;
            font-weight: 700;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-notice-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid #2563eb;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            color: #1e3a8a;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .form-notice-box i {
            color: #2563eb;
            margin-right: 6px;
        }
        .success-submission-card {
            display: none;
            text-align: center;
            padding: 30px 10px;
        }
        .success-icon-wrap {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #dcfce7;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.2);
            animation: pulse-green 2s infinite;
        }
        @keyframes pulse-green {
            0% { transform: scale(1); }
            50% { transform: scale(1.06); }
            100% { transform: scale(1); }
        }
    </style>
</head>

<body>
    <!-- Header component -->
    <?php include_once '../../UxUi-Back/Common/header.php'; ?>

    <div class="erp-container erp-container--registration" style="max-width: 740px;">
        <div class="erp-registration-card">

            <?php if (!$is_valid_form): ?>
                <!-- Invalid or Expired Form Notice -->
                <div class="erp-registration-card__header" style="background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);">
                    <div style="font-size: 38px; color: #fecaca; margin-bottom: 8px;">
                        <i class="fas fa-link-slash"></i>
                    </div>
                    <h1 class="erp-registration-card__title">Registration Link Unavailable</h1>
                    <p class="erp-registration-card__subtitle" style="color: #fca5a5;">
                        <?php echo htmlspecialchars($error_message); ?>
                    </p>
                </div>
                <div class="erp-registration-card__body" style="padding: 32px 24px; text-align: center;">
                    <p style="color: #475569; font-size: 14.5px; line-height: 1.6; margin-bottom: 24px;">
                        Employees can only register with an active invitation link created by the <strong>Super Admin</strong>.
                        Please reach out to your HR department or administrator to request a valid registration link.
                    </p>
                    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                        <a href="User-Login.php" class="erp-btn erp-btn--primary" style="height: 44px; padding: 0 20px;">
                            <i class="fas fa-sign-in-alt"></i> Go to Sign In
                        </a>
                        <a href="mailto:<?php echo htmlspecialchars($company_obj->get_default_sending_email()); ?>" class="erp-btn erp-btn--secondary" style="height: 44px; padding: 0 20px;">
                            <i class="fas fa-envelope"></i> Contact Support
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- Valid Employee Registration Form -->
                <div class="erp-registration-card__header">
                    <div class="erp-registration-card__logo" style="font-size: 32px; color: #93c5fd; margin-bottom: 8px;">
                        <i class="fas fa-id-card-clip"></i>
                    </div>
                    <h1 class="erp-registration-card__title"><?php echo htmlspecialchars($form_data['title'] ?: 'Employee Registration Form'); ?></h1>
                    <p class="erp-registration-card__subtitle">Complete your details to submit your employee account application to <?php echo htmlspecialchars($company_obj->get_compnay_name()); ?></p>
                </div>

                <div class="erp-registration-card__body">
                    
                    <!-- Notice on OTP process -->
                    <div class="form-notice-box">
                        <i class="fas fa-shield-halved"></i>
                        <strong>Verification Workflow:</strong> Once you submit this form, your application will be routed to the <strong>Administrator for review and approval</strong>. Upon approval, an approval email will be sent and an <strong>OTP verification code</strong> will be dispatched to your contact number to activate your account.
                    </div>

                    <!-- Submission Success Container -->
                    <div id="submissionSuccessContainer" class="success-submission-card">
                        <div class="success-icon-wrap">
                            <i class="fas fa-check"></i>
                        </div>
                        <h2 style="font-size: 22px; font-weight: 800; color: #14204d; margin-bottom: 8px;">Application Submitted Successfully!</h2>
                        <p style="font-size: 14.5px; color: #475569; max-width: 520px; margin: 0 auto 20px; line-height: 1.6;">
                            Your registration form has been transmitted to the Administrator for approval. A copy of your submission has been forwarded to the administration.
                        </p>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin: 0 auto 24px; max-width: 500px; text-align: left;">
                            <div style="font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                                <strong>Registered Email:</strong> <span id="resEmail" style="color: #2563eb;"></span>
                            </div>
                            <div style="font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                                <strong>Contact Phone:</strong> <span id="resPhone" style="font-weight: 600;"></span>
                            </div>
                            <div style="font-size: 12.5px; color: #16a34a; background: #dcfce7; padding: 6px 10px; border-radius: 6px; margin-top: 10px;">
                                <i class="fas fa-info-circle"></i> Once approved, you will receive an approval email and an SMS with a 6-digit OTP code to verify your phone number.
                            </div>
                        </div>

                        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                            <a id="verifyNowBtn" href="Employee-Verify-OTP.php" class="erp-btn erp-btn--primary" style="height: 44px; padding: 0 24px;">
                                <i class="fas fa-mobile-screen"></i> Check Verification Status
                            </a>
                            <a href="User-Login.php" class="erp-btn erp-btn--secondary" style="height: 44px; padding: 0 20px;">
                                <i class="fas fa-sign-in-alt"></i> Return to Login
                            </a>
                        </div>
                    </div>

                    <!-- The Actual Form -->
                    <form id="employeeOnboardingForm" class="erp-form" method="POST" onsubmit="submitEmployeeOnboarding(event);">
                        <input type="hidden" name="form_token" value="<?php echo htmlspecialchars($token); ?>">

                        <!-- 1. Personal Information -->
                        <div class="erp-form__group">
                            <h3 class="form-section-title">
                                <i class="fas fa-user-circle" style="color: var(--erp-primary, #2563eb);"></i> 1. Personal Information
                            </h3>

                            <div class="erp-form-grid">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">First Name <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-user erp-form__icon"></i>
                                        <input type="text" class="erp-form__control erp-form__control--with-icon" name="first_name" placeholder="John" required>
                                    </div>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Last Name <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-user erp-form__icon"></i>
                                        <input type="text" class="erp-form__control erp-form__control--with-icon" name="last_name" placeholder="Doe" required>
                                    </div>
                                </div>
                            </div>

                            <div class="erp-form-grid erp-mt-sm">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">Email Address <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-envelope erp-form__icon"></i>
                                        <input type="email" class="erp-form__control erp-form__control--with-icon" name="email" 
                                               value="<?php echo htmlspecialchars($form_data['target_email'] ?: ''); ?>" 
                                               placeholder="name@company.com" required>
                                    </div>
                                    <span class="erp-form__hint">This email will receive your approval confirmation</span>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Contact Phone Number <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-phone erp-form__icon"></i>
                                        <input type="tel" class="erp-form__control erp-form__control--with-icon" name="phone_number" 
                                               placeholder="0771234567 or +94771234567" required>
                                    </div>
                                    <span class="erp-form__hint" style="color: #2563eb; font-weight: 600;">
                                        <i class="fas fa-sms"></i> OTP verification code will be sent to this number
                                    </span>
                                </div>
                            </div>

                            <div class="erp-form-grid erp-mt-sm">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">National Identity Card (NIC) / Passport <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-id-card erp-form__icon"></i>
                                        <input type="text" class="erp-form__control erp-form__control--with-icon" name="nic" placeholder="e.g. 199012345678 or 901234567V" required>
                                    </div>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Date of Birth</label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-calendar erp-form__icon"></i>
                                        <input type="date" class="erp-form__control erp-form__control--with-icon" name="dob">
                                    </div>
                                </div>
                            </div>

                            <div class="erp-form-grid erp-mt-sm">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">Gender</label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-venus-mars erp-form__icon"></i>
                                        <select class="erp-form__control erp-form__control--with-icon" name="gender">
                                            <option value="Male" selected>Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Residential Address</label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-map-marker-alt erp-form__icon"></i>
                                        <input type="text" class="erp-form__control erp-form__control--with-icon" name="address" placeholder="e.g. No 12, Main Street, Colombo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Employment & Department -->
                        <div class="erp-form__group erp-mt-lg">
                            <h3 class="form-section-title">
                                <i class="fas fa-briefcase" style="color: var(--erp-primary, #2563eb);"></i> 2. Department &amp; Position
                            </h3>

                            <div class="erp-form-grid">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">Department <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-building erp-form__icon"></i>
                                        <select class="erp-form__control erp-form__control--with-icon" name="department" required>
                                            <?php 
                                            $curr_dept = !empty($form_data['department']) ? $form_data['department'] : 'Engineering';
                                            $depts = ['Engineering', 'Human Resources', 'Operations', 'Finance & Accounts', 'Sales & Marketing', 'Information Technology', 'Administration'];
                                            if (!in_array($curr_dept, $depts)) { $depts[] = $curr_dept; }
                                            foreach ($depts as $d): ?>
                                                <option value="<?php echo htmlspecialchars($d); ?>" <?php echo $curr_dept === $d ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($d); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Job Title / Designation <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-user-tag erp-form__icon"></i>
                                        <input type="text" class="erp-form__control erp-form__control--with-icon" name="job_title" 
                                               value="<?php echo htmlspecialchars($form_data['job_title'] ?: 'Staff'); ?>" required placeholder="e.g. Software Engineer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Emergency Contact -->
                        <div class="erp-form__group erp-mt-lg">
                            <h3 class="form-section-title">
                                <i class="fas fa-phone-volume" style="color: var(--erp-primary, #2563eb);"></i> 3. Emergency Contact Details
                            </h3>

                            <div class="erp-form-grid">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">Emergency Contact Name</label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-user-shield erp-form__icon"></i>
                                        <input type="text" class="erp-form__control erp-form__control--with-icon" name="emergency_contact_name" placeholder="Full name of contact">
                                    </div>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Emergency Contact Phone</label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-mobile-screen erp-form__icon"></i>
                                        <input type="tel" class="erp-form__control erp-form__control--with-icon" name="emergency_contact_phone" placeholder="Emergency phone number">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Account Security Password -->
                        <div class="erp-form__group erp-mt-lg">
                            <h3 class="form-section-title">
                                <i class="fas fa-lock" style="color: var(--erp-primary, #2563eb);"></i> 4. Account Password
                            </h3>

                            <div class="erp-form-grid">
                                <div class="erp-form__group">
                                    <label class="erp-form__label">Password <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-lock erp-form__icon"></i>
                                        <input type="password" class="erp-form__control erp-form__control--with-icon" 
                                               id="empPassword" name="password" placeholder="••••••••" required onkeyup="checkEmpPassword()">
                                    </div>
                                    <span class="erp-form__hint">Minimum 6 characters</span>
                                </div>

                                <div class="erp-form__group">
                                    <label class="erp-form__label">Confirm Password <span style="color: var(--erp-accent-error);">*</span></label>
                                    <div class="erp-input-wrapper">
                                        <i class="fas fa-lock erp-form__icon"></i>
                                        <input type="password" class="erp-form__control erp-form__control--with-icon" 
                                               id="empConfirmPassword" placeholder="••••••••" required onkeyup="checkEmpMatch()">
                                    </div>
                                    <span class="erp-form__hint" id="empMatchHint">Re-enter your password</span>
                                </div>
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="erp-form__group erp-mt-lg">
                            <div class="erp-terms">
                                <input type="checkbox" class="erp-terms__checkbox" id="empTerms" required>
                                <label for="empTerms" class="erp-terms__label">
                                    I confirm that the details provided above are true and accurate. I understand that my registration requires administrator approval, after which an OTP will be dispatched to my contact number for mobile verification.
                                    <span style="color: var(--erp-accent-error);">*</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="erp-form__group erp-mt-xl">
                            <button type="submit" id="submitFormBtn" class="erp-btn erp-btn--primary erp-btn--block" style="height: 48px; font-size: 15px;">
                                <i class="fas fa-paper-plane"></i>
                                <span>Submit Registration Form to Admin</span>
                            </button>
                        </div>

                        <!-- Navigation links -->
                        <div class="erp-text-center erp-mt-lg" style="margin-top: 20px; text-align: center;">
                            <p class="erp-text-tertiary erp-text-sm erp-mb-sm" style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Already have an account, or registering as an Administrator?</p>
                            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                                <a href="User-Login.php" class="erp-btn erp-btn--secondary" style="height: 38px; padding: 0 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-sign-in-alt"></i> Sign In to Portal
                                </a>
                                <a href="User-Registration.php" class="erp-btn erp-btn--secondary" style="height: 38px; padding: 0 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-user-shield"></i> Register as Administrator
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div class="erp-registration-card__footer" style="padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                <p style="font-size: 12px; color: #64748b; margin: 0; font-weight: 500;">
                    © <?php echo date('Y'); ?> <?php echo htmlspecialchars($company_obj->get_compnay_name()); ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function checkEmpPassword() {
            var p = document.getElementById('empPassword').value;
            checkEmpMatch();
        }

        function checkEmpMatch() {
            var p1 = document.getElementById('empPassword').value;
            var p2 = document.getElementById('empConfirmPassword').value;
            var hint = document.getElementById('empMatchHint');
            if (!hint) return;
            if (!p2) {
                hint.textContent = 'Re-enter your password';
                hint.style.color = '#64748b';
            } else if (p1 === p2) {
                hint.innerHTML = '<i class="fas fa-check-circle" style="color:#10b981;"></i> Passwords match';
                hint.style.color = '#10b981';
            } else {
                hint.innerHTML = '<i class="fas fa-times-circle" style="color:#ef4444;"></i> Passwords do not match';
                hint.style.color = '#ef4444';
            }
        }

        function submitEmployeeOnboarding(e) {
            e.preventDefault();

            var p1 = document.getElementById('empPassword').value;
            var p2 = document.getElementById('empConfirmPassword').value;

            if (p1 !== p2) {
                alert('Passwords do not match. Please verify your password entry.');
                document.getElementById('empConfirmPassword').focus();
                return;
            }

            var terms = document.getElementById('empTerms');
            if (terms && !terms.checked) {
                alert('Please accept the declaration terms before submitting.');
                return;
            }

            var btn = document.getElementById('submitFormBtn');
            var originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting Form to Admin...';

            var formData = new FormData(document.getElementById('employeeOnboardingForm'));

            $.ajax({
                url: '../../UxUi-Back/Employee/forms/submit_employee_form.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    try {
                        var json = typeof res === 'object' ? res : JSON.parse(res);
                        if (json.status === 'success') {
                            document.getElementById('employeeOnboardingForm').style.display = 'none';
                            var succ = document.getElementById('submissionSuccessContainer');
                            if (succ) succ.style.display = 'block';

                            if (json.data) {
                                document.getElementById('resEmail').textContent = json.data.email || '';
                                document.getElementById('resPhone').textContent = json.data.phone || '';
                                var vBtn = document.getElementById('verifyNowBtn');
                                if (vBtn) {
                                    vBtn.href = 'Employee-Verify-OTP.php?email=' + encodeURIComponent(json.data.email);
                                }
                            }
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            alert(json.message || 'Error submitting registration form.');
                            btn.disabled = false;
                            btn.innerHTML = originalBtnHtml;
                        }
                    } catch (err) {
                        alert('Error processing server response: ' + err.message);
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;
                    }
                },
                error: function(xhr, status, error) {
                    alert('Submission error: ' + error);
                    btn.disabled = false;
                    btn.innerHTML = originalBtnHtml;
                }
            });
        }
    </script>

    <?php include_once '../../UxUi-Back/Common/footer.php'; ?>
</body>

</html>
