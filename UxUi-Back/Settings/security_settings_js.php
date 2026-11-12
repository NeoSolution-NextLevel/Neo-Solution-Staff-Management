<script>
/* Shared "Security" section logic for the Employee, Admin and Super Admin settings pages:
   phone number, two-factor authentication (OTP) and change password. */
(function () {
  if (window.__securitySettingsInit) return;
  window.__securitySettingsInit = true;

  const base = () => (typeof window.pth !== 'undefined' ? window.pth : '../');
  const url = {
    fetch:  () => base() + 'UxUi-Back/Settings/fetch_security_settings/fetch_security_settings.php',
    phone:  () => base() + 'UxUi-Back/Settings/update_phone_number/update_phone_number.php',
    toggle: () => base() + 'UxUi-Back/Settings/toggle_two_factor/toggle_two_factor.php',
    otp:    () => base() + 'View-List/Main/Two_Factor_Authentication/Two_Factor_Authentication.php',
    pass:   () => base() + 'UxUi-Back/Settings/change_password/change_password_ajax.php'
  };

  // POST/GET and always return parsed JSON, or throw a readable error (never "Unexpected token <")
  async function call(u, formData) {
    const res = await fetch(u, formData ? { method: 'POST', body: formData, credentials: 'same-origin' } : { credentials: 'same-origin' });
    const text = await res.text();
    let data;
    try { data = JSON.parse(text); }
    catch (e) { throw new Error('The server sent an unexpected response (HTTP ' + res.status + '). Please try again or contact support.'); }
    if (res.status === 401) throw new Error('Your session has expired. Please log in again.');
    return data;
  }
  const first = d => Array.isArray(d) ? d[0] : d;

  const init = () => {
    const $ = id => document.getElementById(id);
    const phoneInput = $('sec_phone_number'), btnSavePhone = $('btnSavePhone');
    const toggle = $('sec_two_factor_toggle'), badge = $('two_factor_badge');
    const verifyBox = $('two_factor_verify_box'), tfAlert = $('two_factor_alert');
    const otpInput = $('two_factor_otp_input'), btnVerify = $('btnVerify2faOtp'), btnResend = $('btnResend2faOtp');
    const curPass = $('sec_current_password'), newPass = $('sec_new_password'), confPass = $('sec_confirm_password');
    const btnPass = $('btnSubmitChangePassword'), passAlert = $('change_password_alert');
    if (!phoneInput && !toggle && !btnPass) return;   // page has no security section

    const PHONE_RE = /^\+?[0-9]{7,15}$/;
    const cleanPhone = v => (v || '').replace(/[\s\-().]/g, '');

    function showBox(el, msg, kind) {
      if (!el) return;
      const c = { ok: ['#ecfdf5', '#065f46', '#a7f3d0'], err: ['#fef2f2', '#991b1b', '#fecaca'], info: ['#eff6ff', '#1e40af', '#bfdbfe'] }[kind];
      el.style.display = 'block'; el.style.background = c[0]; el.style.color = c[1]; el.style.border = '1px solid ' + c[2];
      el.textContent = msg;
    }
    function setBadge(on) {
      if (!badge) return;
      badge.textContent = on ? 'Active' : 'Disabled';
      badge.style.background = on ? '#ecfdf5' : '#fef2f2';
      badge.style.color = on ? '#059669' : '#dc2626';
    }
    function setToggle(on) { if (toggle) toggle.checked = !!on; setBadge(!!on); }

    // ---------- load current status ----------
    async function load() {
      try {
        const r = await call(url.fetch());
        if (r.status === 'success' && r.data) {
          if (phoneInput && r.data.phone_number) phoneInput.value = r.data.phone_number;
          setToggle(r.data.is_two_factor_auth_enable);
        }
      } catch (e) { console.error('Security settings:', e.message); }
    }

    // ---------- phone ----------
    if (btnSavePhone) btnSavePhone.addEventListener('click', async () => {
      const phone = cleanPhone(phoneInput && phoneInput.value);
      if (!PHONE_RE.test(phone)) { alert('Enter a valid phone number (7-15 digits, optional + prefix), e.g. +94771234567.'); return; }
      const orig = btnSavePhone.textContent; btnSavePhone.disabled = true; btnSavePhone.textContent = 'Saving...';
      try {
        const fd = new FormData(); fd.append('phone_number', phone);
        const r = await call(url.phone(), fd);
        if (r.status === 'success') { if (phoneInput) phoneInput.value = r.phone_number || phone; alert(r.message || 'Phone number saved.'); }
        else alert(r.message || 'Could not save phone number.');
      } catch (e) { alert(e.message); }
      finally { btnSavePhone.disabled = false; btnSavePhone.textContent = orig; }
    });

    // ---------- 2FA ----------
    async function sendOtp() {
      const phone = cleanPhone(phoneInput && phoneInput.value);
      if (!PHONE_RE.test(phone)) { alert('Enter a valid phone number first.'); setToggle(false); return; }
      if (verifyBox) verifyBox.style.display = 'block';
      showBox(tfAlert, 'Sending verification code...', 'info');
      try {
        const fd = new FormData(); fd.append('setting_enable_disable_send_otp', '1'); fd.append('val_01', phone);
        const item = first(await call(url.otp(), fd));
        if (item && String(item.error) === '0') { showBox(tfAlert, item.message || 'Code sent. Enter it below.', 'ok'); if (otpInput) otpInput.focus(); }
        else { showBox(tfAlert, (item && item.message) || 'Could not send the code.', 'err'); }
      } catch (e) { showBox(tfAlert, e.message, 'err'); }
    }

    if (toggle) toggle.addEventListener('change', async () => {
      if (toggle.checked) {
        if (!cleanPhone(phoneInput && phoneInput.value)) {
          alert('Please enter and save your phone number before enabling Two-Factor Authentication.');
          toggle.checked = false; if (phoneInput) phoneInput.focus(); return;
        }
        sendOtp();
      } else {
        if (!confirm('Are you sure you want to disable Two-Factor Authentication?')) { toggle.checked = true; return; }
        try {
          const fd = new FormData(); fd.append('action', 'disable');
          const r = await call(url.toggle(), fd);
          if (r.status === 'success') { setToggle(false); if (verifyBox) verifyBox.style.display = 'none'; alert('Two-Factor Authentication disabled.'); }
          else { alert(r.message || 'Could not disable 2FA.'); toggle.checked = true; }
        } catch (e) { alert(e.message); toggle.checked = true; }
      }
    });
    if (btnResend) btnResend.addEventListener('click', sendOtp);

    if (btnVerify) btnVerify.addEventListener('click', async () => {
      const code = (otpInput && otpInput.value || '').trim();
      if (!/^[0-9]{6}$/.test(code)) { showBox(tfAlert, 'Enter the 6-digit code.', 'err'); return; }
      btnVerify.disabled = true; const orig = btnVerify.textContent; btnVerify.textContent = 'Verifying...';
      try {
        const fd = new FormData();
        fd.append('setting_enable_disable_otp_check', '1'); fd.append('val_02', code);
        fd.append('phone_number', cleanPhone(phoneInput && phoneInput.value)); fd.append('want_enable', '1');
        const item = first(await call(url.otp(), fd));
        if (item && String(item.error) === '0') {
          if (verifyBox) verifyBox.style.display = 'none'; if (otpInput) otpInput.value = '';
          setToggle(true); alert('Two-Factor Authentication enabled.');
        } else showBox(tfAlert, (item && item.message) || 'Invalid code.', 'err');
      } catch (e) { showBox(tfAlert, e.message, 'err'); }
      finally { btnVerify.disabled = false; btnVerify.textContent = orig; }
    });

    // ---------- change password ----------
    if (btnPass) btnPass.addEventListener('click', async () => {
      const cur = (curPass && curPass.value || ''), nw = (newPass && newPass.value || ''), cf = (confPass && confPass.value || '');
      if (!cur || !nw || !cf) return showBox(passAlert, 'Please fill in all password fields.', 'err');
      if (nw.length < 6) return showBox(passAlert, 'New password must be at least 6 characters.', 'err');
      if (nw !== cf) return showBox(passAlert, 'New password and confirmation do not match.', 'err');
      const orig = btnPass.textContent; btnPass.disabled = true; btnPass.textContent = 'Updating...';
      try {
        const fd = new FormData(); fd.append('current_password', cur); fd.append('new_password', nw); fd.append('confirm_password', cf);
        const r = await call(url.pass(), fd);
        if (r.status === 'success') { showBox(passAlert, r.message || 'Password changed successfully!', 'ok'); [curPass, newPass, confPass].forEach(i => { if (i) i.value = ''; }); }
        else showBox(passAlert, r.message || 'Could not change password.', 'err');
      } catch (e) { showBox(passAlert, e.message, 'err'); }
      finally { btnPass.disabled = false; btnPass.textContent = orig; }
    });

    window.fetchSecuritySettings = load;
    load();
  };

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>
