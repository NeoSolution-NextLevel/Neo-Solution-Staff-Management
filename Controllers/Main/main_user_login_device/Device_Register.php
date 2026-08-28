<?php
include_once __DIR__ . '/../User_Account_Check_Device.php';

class Device_Register
{
    public static function register($userId, $sessionToken = '')
    {
        $deviceHandler = new User_Account_Check_Device();
        if (empty($sessionToken)) {
            $sessionToken = bin2hex(random_bytes(24));
        }
        return $deviceHandler->register_device($userId, $sessionToken);
    }
}
?>
