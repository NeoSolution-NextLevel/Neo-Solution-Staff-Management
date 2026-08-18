   <div class="erp-container erp-container--login">
        <div class="erp-error-card">
            <!-- Header Section: Displays error/warning title -->
            <div class="erp-error-card__header">
                <i class="fas fa-exclamation-triangle erp-error-card__logo"></i>
                <h1 class="erp-error-card__title" id="error-title">Operation Failed</h1>
                <p class="erp-error-card__subtitle" id="error-subtitle">An error occurred while processing your request</p>
            </div>

            <!-- Main Body: Displays animated error icon and details -->
            <div class="erp-error-card__body">
                <!-- Creative Error Animation -->
                <div class="erp-error-container">
                    <!-- Pulsing circles -->
                    <div class="erp-error-circle"></div>
                    <div class="erp-error-circle"></div>
                    <div class="erp-error-circle"></div>

                    <!-- Main error icon -->
                    <i class="fas fa-times-circle erp-error-icon"></i>

                    <!-- Broken pieces -->
                    <div class="erp-broken-piece" id="piece-1"></div>
                    <div class="erp-broken-piece" id="piece-2"></div>
                    <div class="erp-broken-piece" id="piece-3"></div>
                </div>

                <!-- Error message -->
                <div class="erp-text-center">
                    <p class="erp-error-message" id="error-message"></p>

                    <!-- Error details box (can be toggled) -->
                    <div class="erp-error-details" id="error-details" style="display: none;">
                        <div class="erp-error-details__title">
                            <i class="fas fa-bug"></i>
                            <span>Error Details</span>
                        </div>
                        <div class="erp-error-details__content" id="error-details-content">
                            <!-- Error details will be populated here -->
                        </div>
                    </div>



                    <!-- Error code display -->
                    <p class="erp-text-tertiary erp-text-sm erp-mt-md" id="error-code">
                        Error Code: <span id="error-code-value">ERR-500</span>
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="erp-btn-group">
                    <button type="button" class="erp-btn erp-btn--primary erp-btn--block" id="retry-btn">
                        <i class="fas fa-redo"></i>
                        <span id="retry-text">Try Again</span>
                    </button>

                    <button type="button" class="erp-btn erp-btn--secondary erp-btn--block" id="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span id="back-text">Go Back</span>
                    </button>
                </div>

                <!-- Additional help link -->
                <div class="erp-text-center erp-mt-lg">
                    <a href="#" class="erp-link" id="help-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Need help? Contact Support</span>
                    </a>
                </div>
            </div>

            <!-- Footer: Displays copyright and version info -->
            <div class="erp-error-card__footer" id="footer-particles">
                <p class="erp-footer__copyright" id="copyright">© <span id="current-year"></span> Enterprise Resource Planning System v4.2.1</p>
                <p class="erp-footer__version">Error Handling Module v2.1</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for error page functionality -->
   