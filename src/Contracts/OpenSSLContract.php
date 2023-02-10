<?php
namespace VandatPiko\Mservice\Contracts;

interface OpenSSLContract
{
    /**
     * @param string $method
     * @param string $url
     */
    public static function encrypt(mixed $message, string $passphrase);

    /**
     * @param string $message
     * @param string $passphrase
     */
    public static function decrypt(string $message, string $passphrase);
}
