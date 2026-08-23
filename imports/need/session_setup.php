<?php

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    $timeout_duration = 3600 * 24; 
    @ini_set('session.gc_maxlifetime', $timeout_duration);
    @session_start();
}


$time = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
if (session_status() === PHP_SESSION_ACTIVE) {
    $_SESSION['LAST_ACTIVITY'] = $time;
}


$pth = "";
$online_state = true;
$online_exnction = "";
// $online_offline_extention = "";
$pth_php = "";

$online_offline_extention = ".php";

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$scriptUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$pathParts = explode('/', trim($scriptUri, '/'));
$projectPrefix = '';
$uxIndex = array_search('UxUi', $pathParts, true);
if ($uxIndex !== false && $uxIndex > 0) {
    $projectPrefix = implode('/', array_slice($pathParts, 0, $uxIndex)) . '/';
}
$home_page = $scheme . '://' . $host . '/' . $projectPrefix;
$User_login_url = "UxUi/Main/";
$home_page_url = $home_page . "index" . $online_offline_extention;

// $home_page_url = "http://localhost:3000/";

//---------------local host-------------------------------------
$total_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''; // e.g.  /folder/sub/page.php

$pth = "";

// split the path into parts
$parts = explode("/", trim($total_url, "/")); // ["folder", "sub", "page.php"]

// remove the last element (the file itself)
array_pop($parts);

// count how many folders deep
$count = count($parts);

// build ../
for ($i = 0; $i < $count; $i++) {
    $pth .= "../";
}

//-------------------online-------------------------------


$pth_php = dirname(__FILE__);

//---------------local host-------------------------------------
$_SESSION['pth'] = $pth;

$_SESSION['pth_php'] = $pth_php;

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "0";
$user_main_cook_id = isset($_SESSION['user_main_cook_id']) ? $_SESSION['user_main_cook_id'] : "0";

//----------------------company data--------------------------------
