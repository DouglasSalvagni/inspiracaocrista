<?php

class Encryption {
    const ENCRYPTION_METHOD = 'aes-256-cbc';
    const ENCRYPTION_KEY = 'your_secret_key';

    public static function encrypt($data, $url_safe = false) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::ENCRYPTION_METHOD));
        $encrypted = openssl_encrypt($data, self::ENCRYPTION_METHOD, self::ENCRYPTION_KEY, 0, $iv);
        
        // Prepend the IV for later use during decryption
        $encrypted_with_iv = base64_encode($iv . $encrypted);
        
        if ($url_safe) {
            return strtr($encrypted_with_iv, '+/', '-_');
        }

        return $encrypted_with_iv;
    }

    public static function decrypt($data, $url_safe = false) {
        if ($url_safe) {
            $data = base64_decode(strtr($data, '-_', '+/'));
        } else {
            $data = base64_decode($data);
        }

        // Extract the IV which is stored at the beginning of the encrypted data
        $iv_length = openssl_cipher_iv_length(self::ENCRYPTION_METHOD);
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);

        return openssl_decrypt($encrypted, self::ENCRYPTION_METHOD, self::ENCRYPTION_KEY, 0, $iv);
    }
}


