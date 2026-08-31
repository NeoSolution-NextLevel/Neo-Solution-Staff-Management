<?php


$company_obj = new Company_Info_Variable_List();


// Google OAuth2 info
$client_id = $company_obj->get_google_authentication_client_id();
$client_secret = $company_obj->get_google_authentication_clent_secret_id();
$redirect_uri = $company_obj->get_compnay_full_web() . "View-List/Main/Google-Login/Main_User_Google_Login_Callback.php";

// Create login URL
$google_login_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'online'
]);
