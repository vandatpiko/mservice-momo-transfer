<?php
namespace VandatPiko\Mservice\Encrypt;

use Crypt_RSA;
use VandatPiko\Mservice\Contracts\CryptRsaContract;

class CryptRsa implements CryptRsaContract
{
    public static function encrypt(string $publicKey,string $message)
    {
        $rsa = new Crypt_RSA();
        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        $rsa->loadKey($publicKey);
        return base64_encode($rsa->encrypt($message));
    }
}
