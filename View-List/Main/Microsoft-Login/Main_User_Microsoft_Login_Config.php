<?php
if (!isset($company_obj)) {
    $company_obj = new Company_Info_Variable_List();
}

$ms_client_id = $company_obj->get_microsoft_login_client_id();
$ms_client_secret = $company_obj->get_microsoft_login_client_secret_id();

$ms_redirect_uri = (isset($home_page) && $home_page !== '') 
    ? rtrim($home_page, '/') . "/View-List/Main/Microsoft-Login/Main_User_Microsoft_Login_Callback.php" 
    : "http://localhost:3000/View-List/Main/Microsoft-Login/Main_User_Microsoft_Login_Callback.php";

$authorize_url = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize";
$token_url = "https://login.microsoftonline.com/common/oauth2/v2.0/token";

$scope = "openid profile email User.Read";

$ms_auth_url = $authorize_url . "?" . http_build_query([
    'client_id'     => $ms_client_id,
    'response_type' => 'code',
    'redirect_uri'  => $ms_redirect_uri,
    'response_mode' => 'query',
    'scope'         => $scope,
    'state'         => bin2hex(random_bytes(16))
]);

