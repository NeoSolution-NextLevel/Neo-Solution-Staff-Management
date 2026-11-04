<?php
include_once '../../imports/need/session_setup.php';
redirect_if_logged_in();

// Unified Registration: All public registrations are staff registrations.
// Super Admin decides role (Admin / Staff) and department upon review and approval.
header('Location: Employee-Registration-Form.php');
exit;
