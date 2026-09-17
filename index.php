<?php
include_once __DIR__ . '/imports/need/session_setup.php';

if (is_logged_in()) {
    header('Location: ' . get_dashboard_redirect_url());
} else {
    header('Location: ' . get_login_page_url());
}
exit;
