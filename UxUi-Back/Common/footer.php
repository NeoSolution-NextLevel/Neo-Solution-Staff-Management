<!-- components/footer.php -->
<?php if (!isset($footer_included)): ?>
<?php $footer_included = true; ?>

<style>
    /* =========================================================
       PAGE FOOTER
       ========================================================= */
    .erp-footer {
        min-height: 32px;
        height: auto;
        background: var(--erp-primary-dark);
        color: #fff;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 16px;
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 102;
        box-sizing: border-box;
    }

    .erp-footer__content {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 4px;
        text-align: center;
        line-height: 1.3;
    }

    @media (max-width: 768px) {
        .erp-footer {
            font-size: 10.5px;
            padding: 6px 12px;
        }
    }
    @media (max-width: 400px){
        .erp-footer {
            font-size: 10px;
            padding: 4px 8px;
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
    <div class="erp-footer__content">
        © <span id="currentYear"><?php echo date('Y'); ?></span> - Metro International Duty Free (Pvt) Ltd | Design & Maintain by NEO Solutionll
    </div>
</footer>

<script>
    // Footer-specific JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Set current year if not already set by PHP
        const currentYearSpan = document.getElementById('currentYear');
        if (currentYearSpan && !currentYearSpan.textContent.trim()) {
            currentYearSpan.textContent = new Date().getFullYear();
        }
    });
</script>
<?php endif; ?>