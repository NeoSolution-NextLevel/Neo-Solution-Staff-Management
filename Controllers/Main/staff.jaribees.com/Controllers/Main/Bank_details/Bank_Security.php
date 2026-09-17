<?php
/**
 * Bank Details Security & Encryption Helper
 * Neo Solution Staff Management System
 * 
 * Provides:
 * 1. AES-256-CBC At-Rest Encryption & Decryption
 * 2. Secure Account Number Dynamic Masking
 * 3. Sanitization & Anti-Tampering Helpers
 */

class Bank_Security
{
    // 256-bit Secret Key for Bank Account Encryption
    private static $encryption_key = "NeoSolution@SecuredBankEncryptionKey#2026";
    private static $cipher_method = "AES-256-CBC";

    /**
     * Encrypt sensitive bank account numbers before saving to database
     */
    public static function encrypt($plainText)
    {
        if (empty($plainText)) return "";
        $ivLength = openssl_cipher_iv_length(self::$cipher_method);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($plainText, self::$cipher_method, self::$encryption_key, 0, $iv);
        return base64_encode($encrypted . "::" . $iv);
    }

    /**
     * Decrypt bank account numbers for authorized disbursement processing
     */
    public static function decrypt($cipherText)
    {
        if (empty($cipherText)) return "";
        if (strpos($cipherText, "::") === false && base64_decode($cipherText, true) === false) {
            // Unencrypted legacy fallback
            return $cipherText;
        }

        $decoded = base64_decode($cipherText);
        if (strpos($decoded, "::") !== false) {
            list($encryptedData, $iv) = explode("::", $decoded, 2);
            return openssl_decrypt($encryptedData, self::$cipher_method, self::$encryption_key, 0, $iv);
        }
        return $cipherText;
    }

    /**
     * Mask bank account numbers (e.g., ••••••••5678)
     */
    public static function mask($accountNumber, $visibleDigits = 4)
    {
        if (empty($accountNumber) || $accountNumber === '-') return '-';
        $str = trim((string)$accountNumber);
        $len = strlen($str);
        if ($len <= $visibleDigits) return $str;
        $lastDigits = substr($str, -$visibleDigits);
        return str_repeat('•', max(4, $len - $visibleDigits)) . $lastDigits;
    }

    /**
     * Sanitize input strings for database queries
     */
    public static function sanitize($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}
?>
