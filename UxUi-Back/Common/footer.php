<!-- components/footer.php -->
<?php if (!isset($footer_included)): ?>
<?php $footer_included = true; ?>

<style>
    /* =========================================================
       PAGE FOOTER (MATCHING SYSTEM FOOTER ACROSS ENTIRE APPLICATION)
       ========================================================= */
    .erp-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        min-height: 38px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #94a3b8;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 24px;
        z-index: 1000;
        box-sizing: border-box;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.12);
    }

    .erp-footer__left {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #cbd5e1;
    }

    .erp-footer__left .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 8px #10b981;
        display: inline-block;
        animation: erpPulseDot 2s infinite ease-in-out;
    }

    @keyframes erpPulseDot {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.55;
            transform: scale(0.85);
        }
    }

    .erp-footer__brand {
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.02em;
    }

    .erp-footer__right {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .erp-footer {
            padding: 8px 14px;
            font-size: 11px;
            flex-direction: column;
            justify-content: center;
            gap: 4px;
            text-align: center;
        }

        .erp-footer__right {
            display: none;
        }
    }

    @media print {
        .erp-footer {
            display: none !important;
        }
    }
</style>

<!-- ================= PAGE FOOTER ================= -->
<footer class="erp-footer">
    <div class="erp-footer__left">
        <span class="status-dot" title="System Online"></span>
        <span class="erp-footer__brand">NEO Solution</span>
        <span>© <span id="currentYear"><?php echo date('Y'); ?></span> • All Rights Reserved</span>
    </div>
    <div class="erp-footer__right">
        Staff & HR Management System
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentYearSpan = document.getElementById('currentYear');
        if (currentYearSpan && !currentYearSpan.textContent.trim()) {
            currentYearSpan.textContent = new Date().getFullYear();
        }
    });
</script>
<?php endif; ?>