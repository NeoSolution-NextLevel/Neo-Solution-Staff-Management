<!-- components/footer.php -->
<?php if (!isset($footer_included)): ?>
<?php $footer_included = true; ?>

<style>
    /* =========================================================
       PAGE FOOTER (NATURAL SCROLL FLOW AT PAGE BOTTOM)
       ========================================================= */
    .erp-footer {
        position: relative;
        margin-left: 250px;
        width: calc(100% - 250px);
        min-height: 40px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #94a3b8;
        font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        z-index: 10;
        box-sizing: border-box;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        transition: margin-left 0.3s ease, width 0.3s ease;
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

    .erp-footer__right span.neo-highlight {
        color: #60a5fa;
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    @media (max-width: 768px) {
        .erp-footer {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 12px 16px;
            font-size: 11px;
            flex-direction: column;
            justify-content: center;
            gap: 6px;
            text-align: center;
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