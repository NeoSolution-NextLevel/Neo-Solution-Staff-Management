<?php

class Advance_Security {
   

//$decoded = base64_decode($encoded);

     private function encrypt_decrypt($string, $secret_key, $action = 'encrypt') {
        $encrypt_method = "AES-256-CBC";
//    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
        $secret_iv = '5fgf5HJ5g27'; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function get_data_encrypt($get_key, $get_value) {
        $get_retrun_value = "";
        $get_retrun_value =  $this->encrypt_decrypt($get_value, $get_key, 'encrypt');
        return $get_retrun_value;
    }

    public function get_data_decrypt($get_key, $get_value) {
        $get_retrun_value = "";
        $get_retrun_value = $this->encrypt_decrypt($get_value, $get_key, 'decrypt');
        return $get_retrun_value;
    }

}

//echo "Your Encrypted password is = " . $pwd = encrypt_decrypt('value','key' ,'encrypt');
//echo '<br>';
//echo "Your Decrypted password is = " . encrypt_decrypt('encriptdata','key', 'decrypt');

 function encryptPass($password) {
    $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $encrypted = base64_encode(openssl_encrypt($password, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
    return $encrypted;
}

function decryptPass($password) {
    $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $decrypted = openssl_decrypt(base64_decode($password), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}
 
