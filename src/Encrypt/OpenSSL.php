<?php
namespace VandatPiko\Mservice\Encrypt;

use VandatPiko\Mservice\Contracts\OpenSSLContract;

class OpenSSL implements OpenSSLContract
{

    public static function encrypt(mixed $message,string $passphrase)
    {
        if (is_array($message)){
            $message = json_encode($message);
        }
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($message, "AES-256-CBC", $passphrase, OPENSSL_RAW_DATA, $iv));
    }

    public static function decrypt(string $message, string $passphrase)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($message), "AES-256-CBC", $passphrase, OPENSSL_RAW_DATA, $iv);
    }

}
