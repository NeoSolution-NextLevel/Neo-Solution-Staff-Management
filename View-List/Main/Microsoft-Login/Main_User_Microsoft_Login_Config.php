<?php
$company_obj = new Company_Info_Variable_List();

$client_id = $company_obj->get_microsoft_login_client_id();
$client_secret = $company_obj->get_microsoft_login_client_secret_id();

// http://localhost:3000/View-List/Main/Microsoft-Login/Main_User_Microsoft_Login_Callback.php
$redirect_uri = "http://localhost:3000/View-List/Main/Microsoft-Login/Main_User_Microsoft_Login_Callback.php";


$authorize_url = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize";
$token_url = "https://login.microsoftonline.com/common/oauth2/v2.0/token";

$scope = "openid profile email User.Read";
