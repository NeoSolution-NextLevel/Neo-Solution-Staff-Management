<?php
$_SERVER['REQUEST_URI'] = '/Neo-Solution-Staff-Management/index.php';
$_SERVER['HTTP_HOST'] = 'localhost';

require_once __DIR__ . '/session_setup.php';

$fn = basename(dirname(dirname(__DIR__)));
$pp = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
echo "fn: '$fn', pp: " . json_encode($pp) . ", search: " . var_export(array_search($fn, $pp, true), true) . PHP_EOL;

echo "Logged in state: " . (is_logged_in() ? "YES" : "NO") . PHP_EOL;
echo "Login URL: " . get_login_page_url() . PHP_EOL;
echo "Home page: " . $home_page . PHP_EOL;

// Test authenticated state
$_SESSION['user_id'] = '1';
$_SESSION['user_role'] = 'admin';
echo "After login state: " . (is_logged_in() ? "YES" : "NO") . PHP_EOL;
echo "Admin Dashboard URL: " . get_dashboard_redirect_url() . PHP_EOL;

$_SESSION['user_role'] = 'Employee';
echo "Employee Dashboard URL: " . get_dashboard_redirect_url() . PHP_EOL;

// Test Company_Info
require_once __DIR__ . '/../Company_Info/Company_Info_Variable_List.php';
$comp = new Company_Info_Variable_List();
echo "Full Company Web: " . $comp->get_compnay_full_web() . PHP_EOL;
